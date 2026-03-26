<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    // ─── LISTE DES CONVERSATIONS ──────────────────────────────────────────────
    public function index()
    {
        $conversations = Message::conversationsDeUser(Auth::id());

        $totalNonLus = Message::where('receiver_id', Auth::id())
            ->where('lu', false)
            ->count();

        return view('messages.index', compact('conversations', 'totalNonLus'));
    }

    // ─── FIL DE CONVERSATION ─────────────────────────────────────────────────
    public function conversation(Annonce $annonce, User $interlocuteur)
    {
        $userId = Auth::id();

        // Récupérer tous les messages de cette conversation
        $messages = Message::conversation($annonce->id, $userId, $interlocuteur->id)
            ->with(['sender', 'receiver'])
            ->get();

        // Si aucun message et pas propriétaire → accès refusé
        if ($messages->isEmpty() && $annonce->user_id !== $userId && $interlocuteur->id !== $userId) {
            abort(403);
        }

        // Marquer comme lus les messages reçus
        Message::where('annonce_id', $annonce->id)
            ->where('receiver_id', $userId)
            ->where('sender_id', $interlocuteur->id)
            ->where('lu', false)
            ->update(['lu' => true]);

        // Vérifier s'il existe un contrat entre les deux pour cette annonce
        $contrat = \App\Models\Contrat::where('annonce_id', $annonce->id)
            ->where(function ($q) use ($userId, $interlocuteur) {
                $q->where('locataire_id', $userId)
                  ->orWhere('locataire_id', $interlocuteur->id);
            })
            ->whereIn('statut', ['en_attente', 'actif'])
            ->first();

        $scoreInter = $interlocuteur->score ?? 30;
        $badgeInter = \App\Services\ScoreService::badge($scoreInter);

        return view('messages.conversation', compact(
            'annonce',
            'interlocuteur',
            'messages',
            'contrat',
            'scoreInter',
            'badgeInter'
        ));
    }

    // ─── PREMIER MESSAGE (depuis page annonce) ────────────────────────────────
    public function store(Request $request, Annonce $annonce)
    {
        $request->validate([
            'contenu' => 'required|string|max:2000',
        ]);

        $user = Auth::user();

        if ($user->id === $annonce->user_id) {
            return back()->with('error', 'Vous ne pouvez pas envoyer un message sur votre propre annonce.');
        }

        Message::create([
            'annonce_id'       => $annonce->id,
            'sender_id'        => $user->id,
            'receiver_id'      => $annonce->user_id,
            'expediteur_nom'   => $user->name,
            'expediteur_email' => $user->email,
            'contenu'          => $request->contenu,
            'lu'               => false,
        ]);

        try {
            \Mail::send('emails.nouveau-message', [
                'annonce'    => $annonce,
                'expediteur' => $user,
                'contenu'    => $request->contenu,
            ], function ($m) use ($annonce) {
                $m->to($annonce->user->email)
                  ->subject('Nouveau message sur votre annonce — GaboPlex');
            });
        } catch (\Exception $e) {}

        return redirect()
            ->route('messages.conversation', [$annonce->id, $annonce->user_id])
            ->with('success', 'Message envoyé !');
    }

    // ─── RÉPONDRE DANS LA CONVERSATION ───────────────────────────────────────
    public function repondre(Request $request, Annonce $annonce, User $interlocuteur)
    {
        $request->validate([
            'contenu' => 'required|string|max:2000',
        ]);

        $user = Auth::user();

        Message::create([
            'annonce_id'       => $annonce->id,
            'sender_id'        => $user->id,
            'receiver_id'      => $interlocuteur->id,
            'expediteur_nom'   => $user->name,
            'expediteur_email' => $user->email,
            'contenu'          => $request->contenu,
            'lu'               => false,
        ]);

        try {
            \Mail::send('emails.nouveau-message', [
                'annonce'    => $annonce,
                'expediteur' => $user,
                'contenu'    => $request->contenu,
            ], function ($m) use ($interlocuteur) {
                $m->to($interlocuteur->email)
                  ->subject('Nouveau message — GaboPlex');
            });
        } catch (\Exception $e) {}

        return redirect()
            ->route('messages.conversation', [$annonce->id, $interlocuteur->id])
            ->with('success', 'Message envoyé.');
    }

    // ─── MARQUER LU ──────────────────────────────────────────────────────────
    public function marquer(Message $message)
    {
        if ($message->receiver_id !== Auth::id()) abort(403);
        $message->update(['lu' => true]);
        return back();
    }

    public function marquerLu(Message $message)
    {
        return $this->marquer($message);
    }
}