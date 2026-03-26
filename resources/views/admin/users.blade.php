@extends('layouts.app')

@section('title', 'Gestion des utilisateurs — Admin')

@section('content')

<style>
    .admin-container { max-width:1100px; margin:2rem auto; padding:0 1.5rem; }

    .page-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; flex-wrap:wrap; gap:1rem; }
    .page-header h1 { font-size:1.6rem; font-weight:800; color:#0a2540; margin-bottom:4px; }
    .page-header p { color:#94a3b8; font-size:0.875rem; }
    .btn-back { color:#94a3b8; text-decoration:none; font-size:0.85rem; font-weight:600; display:inline-flex; align-items:center; gap:5px; transition:color 0.2s; }
    .btn-back:hover { color:#0a2540; }

    .search-bar {
        background:white; border-radius:12px; border:1px solid #e8edf2;
        padding:1rem 1.2rem; margin-bottom:1.2rem;
        display:flex; gap:10px; align-items:center; flex-wrap:wrap;
    }
    .search-input {
        flex:1; padding:9px 14px; border:1.5px solid #e2e8f0; border-radius:8px;
        font-size:0.88rem; color:#1e293b; outline:none;
        transition:border-color 0.2s; font-family:'Segoe UI',sans-serif; min-width:200px;
    }
    .search-input:focus { border-color:#3b82f6; }
    .btn-search {
        background:#0a2540; color:white; border:none;
        padding:9px 20px; border-radius:8px; font-size:0.85rem;
        font-weight:700; cursor:pointer; font-family:'Segoe UI',sans-serif; transition:background 0.2s;
    }
    .btn-search:hover { background:#0f3460; }
    .btn-reset { color:#94a3b8; text-decoration:none; font-size:0.83rem; font-weight:600; }
    .btn-reset:hover { color:#0a2540; }

    .table-card { background:white; border-radius:14px; border:1px solid #e8edf2; overflow:hidden; }
    table { width:100%; border-collapse:collapse; }
    thead tr { background:#f8fafc; }
    thead th {
        padding:11px 14px; text-align:left;
        font-size:0.72rem; font-weight:700; color:#94a3b8;
        text-transform:uppercase; letter-spacing:1px;
    }
    thead th.center { text-align:center; }
    tbody tr { border-bottom:1px solid #f1f5f9; transition:background 0.15s; }
    tbody tr:last-child { border-bottom:none; }
    tbody tr:hover { background:#fafbfc; }
    td { padding:11px 14px; font-size:0.87rem; color:#475569; vertical-align:middle; }
    td.center { text-align:center; }

    .user-avatar-img { width:36px; height:36px; border-radius:50%; object-fit:cover; }
    .user-avatar-initials {
        width:36px; height:36px; background:#0a2540; border-radius:50%;
        display:flex; align-items:center; justify-content:center;
        color:white; font-weight:800; font-size:0.85rem; flex-shrink:0;
    }
    .user-name { font-weight:700; color:#0f172a; font-size:0.88rem; }

    /* BADGES RÔLE / STATUT */
    .badge { padding:3px 10px; border-radius:20px; font-size:0.72rem; font-weight:700; display:inline-block; }
    .badge-admin  { background:#fffbeb; color:#d97706; }
    .badge-membre { background:#f1f5f9; color:#94a3b8; }
    .badge-actif  { background:#f0fdf4; color:#16a34a; }
    .badge-bloque { background:#fff1f2; color:#e11d48; }

    /* BOUTONS ACTIONS — distincts des badges */
    .actions { display:flex; gap:5px; justify-content:center; flex-wrap:wrap; }
    .btn-action {
        padding:5px 10px; border-radius:7px; font-size:0.75rem;
        font-weight:700; border:none; cursor:pointer;
        font-family:'Segoe UI',sans-serif; transition:opacity 0.15s;
    }
    .btn-action:hover { opacity:0.8; }
    .btn-debloquer  { background:#f0fdf4; color:#16a34a; }
    .btn-bloquer    { background:#fff1f2; color:#e11d48; }
    .btn-promouvoir { background:#e0f2fe; color:#0369a1; } /* bleu clair — distinct du badge admin orange */
    .btn-suppr      { background:#fff1f2; color:#e11d48; }

    .table-footer { padding:1rem 1.2rem; border-top:1px solid #f1f5f9; }

    @media (max-width:768px) {
        .admin-container { padding:0 1rem; }
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
            <h1>Gestion des utilisateurs</h1>
            <p>{{ $users->total() }} utilisateur(s) au total</p>
        </div>
    </div>

    <!-- RECHERCHE -->
    <form method="GET" class="search-bar">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Rechercher par nom ou email..."
               class="search-input">
        <button type="submit" class="btn-search">Rechercher</button>
        @if(request('search'))
            <a href="{{ route('admin.users') }}" class="btn-reset">Réinitialiser</a>
        @endif
    </form>

    <!-- TABLE -->
    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th>Utilisateur</th>
                    <th>Email</th>
                    <th class="center">Annonces</th>
                    <th class="center">Rôle</th>
                    <th class="center">Statut</th>
                    <th>Inscrit le</th>
                    <th class="center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" class="user-avatar-img" alt="">
                            @else
                                <div class="user-avatar-initials">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                            @endif
                            <span class="user-name">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td class="center" style="font-weight:700; color:#0a2540;">{{ $user->annonces_count }}</td>
                    <td class="center">
                        @if($user->is_admin)
                            <span class="badge badge-admin">Admin</span>
                        @else
                            <span class="badge badge-membre">Membre</span>
                        @endif
                    </td>
                    <td class="center">
                        @if($user->bloque)
                            <span class="badge badge-bloque">Bloqué</span>
                        @else
                            <span class="badge badge-actif">Actif</span>
                        @endif
                    </td>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                    <td>
                        @if(!$user->is_admin)
                        <div class="actions">
                            <form method="POST" action="{{ route('admin.users.bloquer', $user) }}">
                                @csrf @method('PUT')
                                <button type="submit" class="btn-action {{ $user->bloque ? 'btn-debloquer' : 'btn-bloquer' }}">
                                    {{ $user->bloque ? 'Débloquer' : 'Bloquer' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.users.promouvoir', $user) }}">
                                @csrf @method('PUT')
                                <button type="submit" class="btn-action btn-promouvoir">Promouvoir</button>
                            </form>
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                  onsubmit="return confirm('Supprimer cet utilisateur et toutes ses annonces ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action btn-suppr">Supprimer</button>
                            </form>
                        </div>
                        @else
                            <span style="color:#cbd5e1; font-size:0.78rem;">—</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="table-footer">{{ $users->withQueryString()->links() }}</div>
    </div>

</div>

@endsection