<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaiementContrat extends Model
{
    use HasFactory;

    protected $table = 'paiements_contrat';

    protected $fillable = [
        'contrat_id',
        'periode',
        'montant_du',
        'montant_paye',
        'montant_restant',
        'mode',
        'statut',
        'confirme_locataire',
        'confirme_proprietaire',
        'date_echeance',
        'date_paiement',
        'litige',
        'motif_litige',
        'preuve_url',
    ];

    protected $casts = [
        'date_echeance'          => 'date',
        'date_paiement'          => 'datetime',
        'confirme_locataire'     => 'boolean',
        'confirme_proprietaire'  => 'boolean',
        'litige'                 => 'boolean',
    ];

    // ── Relations ──────────────────────────────────────────────────────────────

    public function contrat()
    {
        return $this->belongsTo(Contrat::class);
    }

    // ── Helpers ────────────────────────────────────────────────────────────────

    /**
     * Le paiement est-il totalement confirmé des deux côtés ?
     */
    public function estConfirme(): bool
    {
        return $this->confirme_locataire && $this->confirme_proprietaire;
    }

    /**
     * Le paiement est-il en retard ?
     */
    public function estEnRetard(): bool
    {
        return $this->statut === 'en_attente'
            && $this->date_echeance->isPast()
            && $this->montant_paye === 0;
    }

    /**
     * Points gagnés selon le mode de paiement
     */
    public function pointsGagnes(): int
    {
        if ($this->statut === 'avance')   return 8;
        if ($this->statut === 'partiel')  return 2;
        if ($this->statut !== 'complet')  return 0;

        return match($this->mode) {
            'airtel_money', 'moov_money' => 6,
            'cash'                       => 3,
            default                      => 3,
        };
    }

    /**
     * Label lisible du mode de paiement
     */
    public function getModeLabelAttribute(): string
    {
        return match($this->mode) {
            'airtel_money' => 'Airtel Money',
            'moov_money'   => 'Moov Money',
            'cash'         => 'Cash',
            default        => $this->mode,
        };
    }

    /**
     * Label lisible de la période (ex: "2026-05" → "Mai 2026")
     */
    public function getPeriodeLabelAttribute(): string
    {
        if (str_starts_with($this->periode, 'tranche_')) {
            $num = str_replace('tranche_', '', $this->periode);
            return 'Tranche ' . $num;
        }
        try {
            return \Carbon\Carbon::createFromFormat('Y-m', $this->periode)->translatedFormat('F Y');
        } catch (\Exception $e) {
            return $this->periode;
        }
    }
}