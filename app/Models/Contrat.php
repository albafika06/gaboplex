<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contrat extends Model
{
    use HasFactory;

    protected $fillable = [
        'annonce_id',
        'locataire_id',
        'proprietaire_id',
        'type',
        'montant_mensuel',
        'montant_total',
        'caution',
        'date_debut',
        'date_fin',
        'statut',
        'solde_restant',
        'credit_avance',
        'confirme_locataire',
        'confirme_proprietaire',
        'note_locataire',
        'avis_locataire',
        'note_proprietaire',
        'avis_proprietaire',
    ];

    protected $casts = [
        'date_debut'             => 'date',
        'date_fin'               => 'date',
        'confirme_locataire'     => 'boolean',
        'confirme_proprietaire'  => 'boolean',
    ];

    // ── Relations ──────────────────────────────────────────────────────────────

    public function annonce()
    {
        return $this->belongsTo(Annonce::class);
    }

    public function locataire()
    {
        return $this->belongsTo(User::class, 'locataire_id');
    }

    public function proprietaire()
    {
        return $this->belongsTo(User::class, 'proprietaire_id');
    }

    public function paiements()
    {
        return $this->hasMany(PaiementContrat::class)->orderBy('date_echeance');
    }

    public function dernierPaiement()
    {
        return $this->hasOne(PaiementContrat::class)->latestOfMany('date_paiement');
    }

    // ── Helpers ────────────────────────────────────────────────────────────────

    /**
     * Le contrat est actif (les deux ont confirmé)
     */
    public function estActif(): bool
    {
        return $this->statut === 'actif';
    }

    /**
     * Le contrat est pleinement confirmé par les deux parties
     */
    public function estConfirme(): bool
    {
        return $this->confirme_locataire && $this->confirme_proprietaire;
    }

    /**
     * Montant dû ce mois (location) ou montant total restant (vente)
     */
    public function getMontantDuAttribute(): int
    {
        if ($this->type === 'location') {
            return $this->montant_mensuel ?? 0;
        }
        return $this->solde_restant ?? 0;
    }

    /**
     * Statut lisible en français
     */
    public function getStatutLabelAttribute(): string
    {
        return match($this->statut) {
            'en_attente' => 'En attente de confirmation',
            'actif'      => 'Actif',
            'termine'    => 'Terminé',
            'litige'     => 'Litige en cours',
            'annule'     => 'Annulé',
            default      => $this->statut,
        };
    }

    /**
     * Générer automatiquement la période du mois en cours
     */
    public static function periodeActuelle(): string
    {
        return now()->format('Y-m');
    }
}