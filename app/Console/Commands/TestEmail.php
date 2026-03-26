<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmail extends Command
{
    protected $signature   = 'test:email';
    protected $description = 'Test envoi email';

    public function handle()
    {
        try {
            Mail::raw('Test ImmoGabon — email fonctionnel !', function($m) {
                $m->to('soleil@gmail.com')
                  ->subject('Test ImmoGabon');
            });
            $this->info('Email envoyé avec succès !');
        } catch (\Exception $e) {
            $this->error('Erreur : ' . $e->getMessage());
        }
    }
}