<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
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

    // ─── Token HMAC signé (sans Sanctum) ─────────────────────────────────────
    private function generateToken(int $userId): string
    {
        $payload   = $userId . '|' . time();
        $signature = hash_hmac('sha256', $payload, config('app.key'));

        return base64_encode($payload . '|' . $signature);
    }
}
