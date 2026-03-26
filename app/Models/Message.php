<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'annonce_id',
        'sender_id',
        'receiver_id',
        'expediteur_nom',
        'expediteur_email',
        'contenu',
        'lu',
    ];

    protected $casts = [
        'lu' => 'boolean',
    ];

    // ── Relations ──────────────────────────────────────────────────────────────

    public function annonce()
    {
        return $this->belongsTo(Annonce::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    // ── Helpers ────────────────────────────────────────────────────────────────

    /**
     * Tous les messages d'une conversation entre deux users sur une annonce
     */
    public function scopeConversation($query, int $annonceId, int $user1Id, int $user2Id)
    {
        return $query->where('annonce_id', $annonceId)
            ->where(function ($q) use ($user1Id, $user2Id) {
                $q->where(function ($q2) use ($user1Id, $user2Id) {
                    $q2->where('sender_id', $user1Id)
                       ->where('receiver_id', $user2Id);
                })->orWhere(function ($q2) use ($user1Id, $user2Id) {
                    $q2->where('sender_id', $user2Id)
                       ->where('receiver_id', $user1Id);
                });
            })
            ->orderBy('created_at');
    }

    /**
     * Toutes les conversations d'un utilisateur groupées
     */
    public static function conversationsDeUser(int $userId): \Illuminate\Support\Collection
    {
        $messages = static::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with(['annonce.photos', 'sender', 'receiver'])
            ->orderByDesc('created_at')
            ->get();

        $conversations = collect();
        $vus = [];

        foreach ($messages as $msg) {
            $interlocuteurId = $msg->sender_id === $userId
                ? $msg->receiver_id
                : $msg->sender_id;

            $k1 = min($userId, $interlocuteurId ?? 0);
            $k2 = max($userId, $interlocuteurId ?? 0);
            $key = $msg->annonce_id . '-' . $k1 . '-' . $k2;

            if (!isset($vus[$key])) {
                $vus[$key] = true;
                $nonLus = static::where('annonce_id', $msg->annonce_id)
                    ->where('receiver_id', $userId)
                    ->where('lu', false)
                    ->count();

                $conversations->push([
                    'key'             => $key,
                    'annonce_id'      => $msg->annonce_id,
                    'interlocuteur_id'=> $interlocuteurId,
                    'annonce'         => $msg->annonce,
                    'interlocuteur'   => $msg->sender_id === $userId ? $msg->receiver : $msg->sender,
                    'dernier_message' => $msg,
                    'non_lus'         => $nonLus,
                ]);
            }
        }

        return $conversations;
    }
}