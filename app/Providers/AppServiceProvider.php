<?php

namespace App\Providers;

use App\Models\Annonce;
use App\Policies\AnnoncePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(Annonce::class, AnnoncePolicy::class);
        URL::forceScheme('https');
    }
}