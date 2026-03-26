<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScoreHistorique extends Model
{
    protected $table = 'scores_historique';

    protected $fillable = [
        'user_id',
        'contrat_id',
        'action',
        'points',
        'score_avant',
        'score_apres',
        'detail',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contrat()
    {
        return $this->belongsTo(Contrat::class);
    }

    public function getPointsLabelAttribute(): string
    {
        return ($this->points >= 0 ? '+' : '') . $this->points . ' pts';
    }
}