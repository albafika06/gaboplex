<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nom'     => 'required|string|max:100',
            'email'   => 'required|email',
            'sujet'   => 'required|string|max:200',
            'message' => 'required|string',
        ]);

        Contact::create([
            'nom'     => $request->nom,
            'email'   => $request->email,
            'sujet'   => $request->sujet,
            'message' => $request->message,
        ]);

        $admin = User::where('is_admin', true)->first();
        if ($admin) {
            try {
                Mail::send('emails.contact', [
                    'nom'     => $request->nom,
                    'email'   => $request->email,
                    'sujet'   => $request->sujet,
                    'message' => $request->message,
                ], function($mail) use ($admin, $request) {
                    $mail->to($admin->email)
                         ->subject('Message de contact — ImmoGabon : ' . $request->sujet);
                });
            } catch (\Exception $e) {
                Log::error('Erreur email contact: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Votre message a été envoyé ! Nous vous répondrons dans les plus brefs délais.');
    }

    public function bloque(Request $request)
{
    Log::info('Tentative déblocage reçue', $request->all());

    $request->validate([
        'nom'     => 'required|string|max:100',
        'email'   => 'required|email',
        'message' => 'required|string',
    ]);

    Log::info('Validation passée');

    Contact::create([
        'nom'     => $request->nom,
        'email'   => $request->email,
        'sujet'   => 'Demande de déblocage — ' . $request->nom,
        'message' => $request->message,
    ]);

    Log::info('Contact créé en base');

    $admin = User::where('is_admin', true)->first();
    if ($admin) {
        try {
            Mail::send('emails.contact', [
                'nom'     => $request->nom,
                'email'   => $request->email,
                'sujet'   => 'Demande de déblocage',
                'message' => $request->message,
            ], function($mail) use ($admin) {
                $mail->to($admin->email)
                     ->subject('Demande de déblocage — ImmoGabon');
            });
            Log::info('Email envoyé à ' . $admin->email);
        } catch (\Exception $e) {
            Log::error('Erreur email: ' . $e->getMessage());
        }
    }

    return redirect()->route('login')
                     ->with('success', 'Message envoyé !');
}
}