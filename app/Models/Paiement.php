<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'annonce_id',
        'offre',
        'montant',
        'mode_paiement',
        'statut',
        'transaction_id',
        'cinetpay_token',
        'cinetpay_data',
    ];

    protected $casts = [
        'cinetpay_data' => 'array',
    ];

    // ── Montants par offre (en FCFA) ──────────────────────────────────────────
    public static array $tarifs = [
        'boost_14j'   => 2000,
        'premium_30j' => 5000,
        'pass_annuel' => 25000,
    ];

    // ── Durées en jours ───────────────────────────────────────────────────────
    public static array $durees = [
        'boost_14j'   => 14,
        'premium_30j' => 30,
        'pass_annuel' => 365,
    ];

    // ── Relations ─────────────────────────────────────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function annonce()
    {
        return $this->belongsTo(Annonce::class);
    }
}