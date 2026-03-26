<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = [
        'annonce_id',
        'url',
        'ordre',
    ];

    public function annonce()
    {
        return $this->belongsTo(Annonce::class);
    }
}