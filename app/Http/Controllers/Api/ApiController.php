<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use App\Models\Favori;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    // ─── POST /api/login ─────────────────────────────────────────────────────
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Identifiants invalides.'], 401);
        }

        $token = $this->generateToken($user->id);

        return response()->json([
            'token' => $token,
            'user'  => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
            ],
        ]);
    }

    // ─── GET /api/annonces ────────────────────────────────────────────────────
    public function annonces(Request $request): JsonResponse
    {
        $annonces = Annonce::with('photos', 'photoPrincipale')
            ->where('statut', 'active')
            ->latest()
            ->paginate(20);

        return response()->json($annonces);
    }

    // ─── GET /api/annonces/{id} ───────────────────────────────────────────────
    public function annonce(int $id): JsonResponse
    {
        $annonce = Annonce::with('photos', 'user')
            ->where('statut', 'active')
            ->findOrFail($id);

        return response()->json($annonce);
    }

    // ─── GET /api/favoris ─────────────────────────────────────────────────────
    public function favoris(Request $request): JsonResponse
    {
        $user = $request->_api_user;

        $favoris = Favori::with(['annonce.photoPrincipale'])
            ->where('user_id', $user->id)
            ->latest()
            ->get()
            ->map(fn($f) => $f->annonce)
            ->filter()
            ->values();

        return response()->json($favoris);
    }

    // ─── POST /api/favoris/{annonce_id} ───────────────────────────────────────
    public function ajouterFavori(Request $request, int $annonce_id): JsonResponse
    {
        $user = $request->_api_user;

        Annonce::where('statut', 'active')->findOrFail($annonce_id);

        Favori::firstOrCreate([
            'user_id'    => $user->id,
            'annonce_id' => $annonce_id,
        ]);

        return response()->json(['message' => 'Ajouté aux favoris.'], 201);
    }

    // ─── DELETE /api/favoris/{annonce_id} ─────────────────────────────────────
    public function supprimerFavori(Request $request, int $annonce_id): JsonResponse
    {
        $user = $request->_api_user;

        Favori::where('user_id', $user->id)
            ->where('annonce_id', $annonce_id)
            ->delete();

        return response()->json(['message' => 'Retiré des favoris.']);
    }

    // ─── Token HMAC signé (sans Sanctum) ─────────────────────────────────────
    private function generateToken(int $userId): string
    {
        $payload   = $userId . '|' . time();
        $signature = hash_hmac('sha256', $payload, config('app.key'));

        return base64_encode($payload . '|' . $signature);
    }
}
