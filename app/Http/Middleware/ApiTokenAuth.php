<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class ApiTokenAuth
{
    public function handle(Request $request, Closure $next)
    {
        $bearer = $request->bearerToken();

        if (!$bearer) {
            return response()->json(['message' => 'Token manquant.'], 401);
        }

        $decoded = base64_decode($bearer, true);

        if (!$decoded || substr_count($decoded, '|') < 2) {
            return response()->json(['message' => 'Token invalide.'], 401);
        }

        [$userId, $timestamp, $signature] = explode('|', $decoded, 3);

        $expected = hash_hmac('sha256', $userId . '|' . $timestamp, config('app.key'));

        if (!hash_equals($expected, $signature)) {
            return response()->json(['message' => 'Token invalide.'], 401);
        }

        $user = User::find((int) $userId);

        if (!$user) {
            return response()->json(['message' => 'Utilisateur introuvable.'], 401);
        }

        $request->merge(['_api_user' => $user]);

        return $next($request);
    }
}
