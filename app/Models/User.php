<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'bio',
        'whatsapp',
        'telephone',
        'ville',
        'score',
        'is_admin',
        'bloque',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_admin'          => 'boolean',
            'bloque'            => 'boolean',
        ];
    }

    // Relations
    public function annonces()
    {
        return $this->hasMany(Annonce::class);
    }

    public function favoris()
    {
        return $this->hasMany(Favori::class);
    }

    public function alertes()
    {
        return $this->hasMany(Alerte::class);
    }
}