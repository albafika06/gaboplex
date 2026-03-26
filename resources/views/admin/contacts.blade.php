@extends('layouts.app')

@section('title', 'Messages de contact — Admin')

@section('content')

<style>
    .admin-container { max-width:1000px; margin:2rem auto; padding:0 1.5rem; }

    .page-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; flex-wrap:wrap; gap:1rem; }
    .page-header h1 { font-size:1.6rem; font-weight:800; color:#0a2540; margin-bottom:4px; }
    .page-header p { color:#94a3b8; font-size:0.875rem; }
    .btn-back { color:#94a3b8; text-decoration:none; font-size:0.85rem; font-weight:600; display:inline-flex; align-items:center; gap:5px; transition:color 0.2s; }
    .btn-back:hover { color:#0a2540; }

    .alert-nonlus {
        background:#fffbeb; border:1px solid #fcd34d;
        border-radius:10px; padding:11px 16px;
        margin-bottom:1.2rem; color:#92400e;
        font-size:0.88rem; font-weight:600;
    }

    .messages-list { display:flex; flex-direction:column; gap:1rem; }

    .message-card {
        background:white; border-radius:16px;
        border:1px solid #e8edf2; border-left:4px solid #e2e8f0;
        padding:1.5rem; transition:box-shadow 0.2s;
    }
    .message-card:hover { box-shadow:0 4px 16px rgba(10,37,64,0.08); }
    .message-card.non-lu { border-left-color:#3b82f6; }

    .msg-top { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:1rem; }
    .msg-sender { display:flex; align-items:center; gap:10px; }
    .msg-avatar {
        width:42px; height:42px; background:#0a2540; border-radius:50%;
        display:flex; align-items:center; justify-content:center;
        color:white; font-weight:700; font-size:1rem; flex-shrink:0;
    }
    .msg-avatar.non-lu { background:#3b82f6; }
    .msg-sender-name { font-weight:700; color:#0f172a; font-size:0.95rem; }
    .msg-sender-email { font-size:0.8rem; color:#94a3b8; }
    .msg-meta { text-align:right; }
    .msg-date { font-size:0.78rem; color:#94a3b8; margin-bottom:4px; }
    .badge-nouveau {
        background:#eff6ff; color:#1d4ed8;
        padding:3px 10px; border-radius:20px;
        font-size:0.72rem; font-weight:700; display:inline-block;
    }

    .msg-sujet {
        background:#f8fafc; border:1px solid #f1f5f9;
        padding:8px 12px; border-radius:8px;
        margin-bottom:1rem; font-size:0.83rem;
    }
    .msg-sujet span { color:#94a3b8; }
    .msg-sujet strong { color:#0a2540; font-weight:700; }

    .msg-contenu { color:#475569; line-height:1.6; font-size:0.9rem; }

    .msg-actions {
        display:flex; gap:10px; margin-top:1rem;
        padding-top:1rem; border-top:1px solid #f1f5f9; flex-wrap:wrap;
    }
    .btn-repondre {
        background:#0a2540; color:white; padding:8px 18px;
        border-radius:8px; text-decoration:none;
        font-size:0.83rem; font-weight:700; transition:background 0.2s;
    }
    .btn-repondre:hover { background:#0f3460; }
    .btn-lu {
        background:#f1f5f9; color:#64748b; border:none;
        padding:8px 18px; border-radius:8px;
        font-size:0.83rem; font-weight:600; cursor:pointer;
        transition:background 0.2s; font-family:'Segoe UI',sans-serif;
    }
    .btn-lu:hover { background:#e2e8f0; }

    .empty-state {
        background:white; border-radius:16px; border:1px solid #e8edf2;
        padding:4rem; text-align:center; color:#94a3b8; font-size:0.9rem;
    }

    @media (max-width:640px) {
        .admin-container { padding:0 1rem; }
        .message-card { padding:1.2rem 1rem; }
        .page-header { flex-direction:column; align-items:flex-start; }
    }
</style>

<div class="admin-container">

    <div class="page-header">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="btn-back">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M5 12l7 7M5 12l7-7"/></svg>
                Dashboard
            </a>
            <h1>Messages de contact</h1>
            <p>Messages reçus depuis la page À propos</p>
        </div>
    </div>

    @if($nonLus > 0)
        <div class="alert-nonlus">
            📬 Vous avez <strong>{{ $nonLus }}</strong> message(s) non lu(s)
        </div>
    @endif

    @if($contacts->isEmpty())
        <div class="empty-state">Aucun message de contact pour l'instant.</div>
    @else
        <div class="messages-list">
            @foreach($contacts as $contact)
            <div class="message-card {{ !$contact->lu ? 'non-lu' : '' }}">

                <div class="msg-top">
                    <div class="msg-sender">
                        <div class="msg-avatar {{ !$contact->lu ? 'non-lu' : '' }}">
                            {{ strtoupper(substr($contact->nom, 0, 1)) }}
                        </div>
                        <div>
                            <div class="msg-sender-name">{{ $contact->nom }}</div>
                            <div class="msg-sender-email">{{ $contact->email }}</div>
                        </div>
                    </div>
                    <div class="msg-meta">
                        <div class="msg-date">{{ $contact->created_at->diffForHumans() }}</div>
                        @if(!$contact->lu)
                            <span class="badge-nouveau">Nouveau</span>
                        @endif
                    </div>
                </div>

                <div class="msg-sujet">
                    <span>Sujet : </span>
                    <strong>{{ $contact->sujet }}</strong>
                </div>

                <p class="msg-contenu">{{ $contact->message }}</p>

                <div class="msg-actions">
                    <a href="mailto:{{ $contact->email }}" class="btn-repondre">Répondre par email</a>
                    @if(!$contact->lu)
                        <form method="POST" action="{{ route('admin.contacts.lu', $contact) }}">
                            @csrf @method('PUT')
                            <button type="submit" class="btn-lu">Marquer comme lu</button>
                        </form>
                    @endif
                </div>

            </div>
            @endforeach
        </div>

        <div style="margin-top:2rem; display:flex; justify-content:center;">
            {{ $contacts->links() }}
        </div>
    @endif

</div>

@endsection