<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alerte extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'ville',
        'prix_max',
        'nb_chambres',
    ];

    // ── Relations ──────────────────────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ── Helper : est-ce que cette annonce correspond à l'alerte ? ─────────────
    public function correspondA(Annonce $annonce): bool
    {
        if ($this->type && $this->type !== $annonce->type) return false;
        if ($this->ville && strtolower($this->ville) !== strtolower($annonce->ville)) return false;
        if ($this->prix_max && $annonce->prix > $this->prix_max) return false;
        if ($this->nb_chambres && $annonce->nb_chambres < $this->nb_chambres) return false;

        return true;
    }
}