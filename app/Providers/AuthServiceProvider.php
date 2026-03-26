<?php

namespace App\Providers;

use App\Models\Annonce;
use App\Policies\AnnoncePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Mapping modèle → policy
     */
    protected $policies = [
        Annonce::class => AnnoncePolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}