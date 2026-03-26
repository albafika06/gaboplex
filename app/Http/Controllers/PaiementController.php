<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Paiement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaiementController extends Controller
{
    // ── CONFIG CINETPAY ───────────────────────────────────────────────────────
    private function config(): array
    {
        return [
            'apikey'     => config('services.cinetpay.apikey'),
            'site_id'    => config('services.cinetpay.site_id'),
            'secret_key' => config('services.cinetpay.secret_key'),
            'base_url'   => 'https://api-checkout.cinetpay.com/v2',
        ];
    }

    // ── INITIER PAIEMENT ─────────────────────────────────────────────────────
    // Appelé depuis AnnonceController::store() quand offre != gratuit
    public static function initier(Annonce $annonce, string $offre, string $modePaiement): ?string
    {
        $tarifs = Paiement::$tarifs;
        $montant = $tarifs[$offre] ?? null;
        if (!$montant) return null;

        $cfg = (new self)->config();
        $transactionId = 'GP-' . strtoupper(Str::random(12));

        // Créer le paiement en base (statut en_attente)
        $paiement = Paiement::create([
            'user_id'       => Auth::id(),
            'annonce_id'    => $annonce->id,
            'offre'         => $offre,
            'montant'       => $montant,
            'mode_paiement' => $modePaiement,
            'statut'        => 'en_attente',
            'transaction_id'=> $transactionId,
        ]);

        // Appel API CinetPay
        $response = Http::post($cfg['base_url'] . '/payment', [
            'apikey'                => $cfg['apikey'],
            'site_id'               => $cfg['site_id'],
            'transaction_id'        => $transactionId,
            'amount'                => $montant,
            'currency'              => 'XAF', // FCFA
            'description'           => 'GaboPlex — ' . self::offreLabel($offre),
            'notify_url'            => route('paiement.webhook'),
            'return_url'            => route('paiement.retour', ['transaction_id' => $transactionId]),
            'customer_name'         => Auth::user()->name,
            'customer_email'        => Auth::user()->email,
            'customer_phone_number' => Auth::user()->whatsapp ?? '',
            'customer_address'      => 'Libreville, Gabon',
            'customer_city'         => 'Libreville',
            'customer_country'      => 'GA',
            'customer_state'        => 'GA',
            'customer_zip_code'     => '00241',
            'channels'              => self::modeToChannel($modePaiement),
        ]);

        if ($response->successful()) {
            $data = $response->json();
            if (isset($data['data']['payment_url'])) {
                // Sauvegarder token CinetPay
                $paiement->update([
                    'cinetpay_token' => $data['data']['payment_token'] ?? null,
                    'cinetpay_data'  => $data,
                ]);
                return $data['data']['payment_url'];
            }
        }

        // Échec API
        Log::error('CinetPay initier paiement échoué', [
            'status'   => $response->status(),
            'response' => $response->json(),
            'offre'    => $offre,
            'annonce'  => $annonce->id,
        ]);

        $paiement->update(['statut' => 'echoue']);
        return null;
    }

    // ── RETOUR APRÈS PAIEMENT (redirect CinetPay) ─────────────────────────────
    public function retour(Request $request)
    {
        $transactionId = $request->transaction_id;
        $paiement = Paiement::where('transaction_id', $transactionId)
                            ->where('user_id', Auth::id())
                            ->first();

        if (!$paiement) {
            return redirect()->route('dashboard')->with('error', 'Transaction introuvable.');
        }

        // Vérifier le statut auprès de CinetPay
        $statut = $this->verifierStatut($transactionId);

        if ($statut === 'ACCEPTED') {
            $this->activerOffre($paiement);
            return redirect()->route('dashboard')
                ->with('success', '🎉 Paiement confirmé ! Votre annonce est en cours de validation.');
        }

        if ($statut === 'REFUSED' || $statut === 'CANCELLED') {
            $paiement->update(['statut' => 'echoue']);
            return redirect()->route('annonces.create')
                ->with('error', 'Paiement annulé ou refusé. Veuillez réessayer.');
        }

        // En attente — le webhook confirmera
        return redirect()->route('dashboard')
            ->with('info', 'Paiement en cours de traitement. Vous recevrez un email de confirmation.');
    }

    // ── WEBHOOK CINETPAY (notification serveur à serveur) ────────────────────
    public function webhook(Request $request)
    {
        $cfg = $this->config();

        // Vérification signature CinetPay
        $cpmSiteId      = $request->cpm_site_id;
        $cpmTransId     = $request->cpm_trans_id;
        $cpmPayDate     = $request->cpm_payment_date;
        $cpmAmount      = $request->cpm_amount;
        $cpmCurrency    = $request->cpm_currency;
        $signature      = $request->signature;

        $expected = sha1(
            $cfg['apikey'] .
            $cpmSiteId .
            $cpmTransId .
            $cpmPayDate .
            $cpmAmount .
            $cpmCurrency .
            $cfg['secret_key']
        );

        if ($signature !== $expected) {
            Log::warning('CinetPay webhook signature invalide', $request->all());
            return response('Signature invalide', 400);
        }

        $paiement = Paiement::where('transaction_id', $cpmTransId)->first();
        if (!$paiement) {
            return response('Transaction inconnue', 404);
        }

        $statut = $request->cpm_result; // '00' = succès

        if ($statut === '00') {
            $paiement->update([
                'statut'        => 'complete',
                'cinetpay_data' => $request->all(),
            ]);
            $this->activerOffre($paiement);
        } else {
            $paiement->update(['statut' => 'echoue']);
        }

        return response('OK', 200);
    }

    // ── ACTIVER L'OFFRE SUR L'ANNONCE ────────────────────────────────────────
    private function activerOffre(Paiement $paiement): void
    {
        if ($paiement->statut === 'complete') return; // déjà activé

        $annonce = $paiement->annonce;
        if (!$annonce) return;

        $durees = Paiement::$durees;
        $jours  = $durees[$paiement->offre] ?? 30;

        $annonce->update([
            'is_premium' => true,
            'expire_at'  => now()->addDays($jours),
            'statut'     => 'en_attente', // soumettre à l'admin maintenant
        ]);

        $paiement->update(['statut' => 'complete']);

        // Email de confirmation au propriétaire
        try {
            \Mail::send('emails.paiement-confirme', [
                'annonce' => $annonce,
                'offre'   => self::offreLabel($paiement->offre),
                'montant' => $paiement->montant,
                'expire'  => $annonce->expire_at->format('d/m/Y'),
            ], function ($m) use ($annonce) {
                $m->to($annonce->user->email)
                  ->subject('Paiement confirmé — GaboPlex');
            });
        } catch (\Exception $e) {
            Log::error('Email paiement confirme échoué: ' . $e->getMessage());
        }
    }

    // ── VÉRIFIER STATUT AUPRÈS DE CINETPAY ───────────────────────────────────
    private function verifierStatut(string $transactionId): string
    {
        $cfg = $this->config();
        try {
            $response = Http::post($cfg['base_url'] . '/payment/check', [
                'apikey'         => $cfg['apikey'],
                'site_id'        => $cfg['site_id'],
                'transaction_id' => $transactionId,
            ]);
            if ($response->successful()) {
                return $response->json('data.status') ?? 'UNKNOWN';
            }
        } catch (\Exception $e) {
            Log::error('CinetPay vérification statut échoué: ' . $e->getMessage());
        }
        return 'UNKNOWN';
    }

    // ── HELPERS ───────────────────────────────────────────────────────────────
    private static function offreLabel(string $offre): string
    {
        return match($offre) {
            'boost_14j'   => 'Boost 14 jours',
            'premium_30j' => 'Premium 30 jours',
            'pass_annuel' => 'Pass Pro annuel',
            default       => $offre,
        };
    }

    private static function modeToChannel(string $mode): string
    {
        return match($mode) {
            'airtel_money' => 'AIRTEL_GABON',
            'moov_money'   => 'MOOV_GABON',
            'carte'        => 'CREDIT_CARD',
            default        => 'ALL',
        };
    }
    // ── BOOSTER UNE ANNONCE EXISTANTE ─────────────────────────────────────────
    public function boosterForm(\App\Models\Annonce $annonce)
    {
        // Vérifier que l'annonce appartient à l'utilisateur
        if ($annonce->user_id !== Auth::id()) {
            abort(403);
        }

        $annonce->load('photos');
        return view('annonces.booster', compact('annonce'));
    }

    public function boosterPay(Request $request, \App\Models\Annonce $annonce)
    {
        if ($annonce->user_id !== Auth::id()) {
            abort(403);
        }

        $offre   = $request->input('offre', 'boost_14j');
        $modePay = $request->input('mode_paiement', 'airtel_money');

        $paymentUrl = self::initier($annonce, $offre, $modePay);

        if ($paymentUrl) {
            return redirect($paymentUrl);
        }

        return back()->with('error', 'Erreur lors de l\'initialisation du paiement. Veuillez réessayer.');
    }

}