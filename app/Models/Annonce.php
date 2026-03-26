<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Annonce extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'titre',
        'description',
        'type',
        'sous_type',
        'prix',
        'superficie',
        'ville',
        'quartier',
        'latitude',
        'longitude',
        'whatsapp',
        'nom_affiche',
        'nb_chambres',
        'nb_sdb',
        'meuble',
        'parking',
        'caution',
        'charges_incluses',
        'disponible_le',
        'etat_bien',
        'titre_foncier',
        'prix_negotiable',
        'verifie',
        'statut',
        'motif_rejet',
        'is_premium',
        'expire_at',
        'vues',
    ];

    protected $casts = [
        'meuble'           => 'boolean',
        'parking'          => 'boolean',
        'charges_incluses' => 'boolean',
        'titre_foncier'    => 'boolean',
        'prix_negotiable'  => 'boolean',
        'verifie'          => 'boolean',
        'is_premium'       => 'boolean',
        'expire_at'        => 'datetime',
        'disponible_le'    => 'date',
    ];

    // ── Relations ──────────────────────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class)->orderBy('ordre');
    }

    public function photoPrincipale()
    {
        return $this->hasOne(Photo::class)->orderBy('ordre');
    }

    public function favoris()
    {
        return $this->hasMany(Favori::class);
    }

    // ── Scopes ─────────────────────────────────────────────────────────────────

    public function scopeActives($query)
    {
        return $query->where('statut', 'active');
    }

    public function scopePremium($query)
    {
        return $query->where('is_premium', true)
                     ->where(function($q) {
                         $q->whereNull('expire_at')->orWhere('expire_at', '>=', now());
                     });
    }

    // ── Helpers ────────────────────────────────────────────────────────────────

    public function estEnFavori(int $userId): bool
    {
        return $this->favoris()->where('user_id', $userId)->exists();
    }

    /**
     * Numéro WhatsApp à afficher : celui de l'annonce en priorité,
     * sinon celui du profil utilisateur.
     */
    public function getWhatsappContactAttribute(): ?string
    {
        return $this->whatsapp ?: ($this->user->whatsapp ?? null);
    }

    /**
     * Nom affiché sur l'annonce : nom_affiche en priorité, sinon nom du compte.
     */
    public function getNomAfficheContactAttribute(): string
    {
        return $this->nom_affiche ?: ($this->user->name ?? '');
    }
}