@extends('layouts.app')

@section('title', 'Gestion des annonces — Admin')

@section('content')

<style>
    .admin-container { max-width:1200px; margin:2rem auto; padding:0 1.5rem; }
    .page-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; flex-wrap:wrap; gap:1rem; }
    .page-header h1 { font-size:1.6rem; font-weight:800; color:#0a2540; margin-bottom:4px; }
    .page-header p { color:#94a3b8; font-size:0.875rem; }
    .btn-back { color:#94a3b8; text-decoration:none; font-size:0.85rem; font-weight:600; display:inline-flex; align-items:center; gap:5px; transition:color 0.2s; }
    .btn-back:hover { color:#0a2540; }
    .btn-danger-soft { background:#fee2e2; color:#dc2626; border:none; padding:9px 16px; border-radius:10px; font-size:0.83rem; font-weight:700; cursor:pointer; transition:background 0.2s; font-family:'Segoe UI',sans-serif; }
    .btn-danger-soft:hover { background:#fecaca; }
    .filters-bar { background:white; border-radius:12px; border:1px solid #e8edf2; padding:1rem 1.2rem; margin-bottom:1.2rem; display:flex; gap:10px; align-items:center; flex-wrap:wrap; }
    .form-control-sm { padding:8px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.85rem; color:#1e293b; outline:none; transition:border-color 0.2s; font-family:'Segoe UI',sans-serif; background:white; }
    .form-control-sm:focus { border-color:#3b82f6; }
    .btn-filter { background:#0a2540; color:white; border:none; padding:8px 18px; border-radius:8px; font-size:0.85rem; font-weight:700; cursor:pointer; font-family:'Segoe UI',sans-serif; transition:background 0.2s; }
    .btn-filter:hover { background:#0f3460; }
    .btn-reset { color:#94a3b8; text-decoration:none; font-size:0.83rem; font-weight:600; }
    .btn-reset:hover { color:#0a2540; }
    .table-card { background:white; border-radius:14px; border:1px solid #e8edf2; overflow:hidden; }
    table { width:100%; border-collapse:collapse; }
    thead tr { background:#f8fafc; }
    thead th { padding:11px 14px; text-align:left; font-size:0.72rem; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:1px; }
    thead th.center { text-align:center; }
    tbody tr { border-bottom:1px solid #f1f5f9; transition:background 0.15s; }
    tbody tr:last-child { border-bottom:none; }
    tbody tr:hover { background:#fafbfc; }
    td { padding:11px 14px; font-size:0.87rem; color:#475569; vertical-align:middle; }
    .annonce-thumb { width:44px; height:44px; border-radius:8px; overflow:hidden; background:#f1f5f9; flex-shrink:0; }
    .annonce-thumb img { width:100%; height:100%; object-fit:cover; }
    .annonce-title { font-weight:700; color:#0f172a; font-size:0.88rem; }
    .annonce-loc { font-size:0.75rem; color:#94a3b8; }
    .badge { padding:3px 10px; border-radius:20px; font-size:0.72rem; font-weight:700; display:inline-block; }
    .badge-active { background:#f0fdf4; color:#16a34a; }
    .badge-en_attente { background:#fffbeb; color:#d97706; }
    .badge-rejetee { background:#fff1f2; color:#e11d48; }
    .badge-expiree { background:#f1f5f9; color:#94a3b8; }
    .badge-verifie-tag { background:#eff6ff; color:#1d4ed8; padding:2px 7px; border-radius:20px; font-size:0.65rem; font-weight:700; display:inline-block; margin-left:4px; }
    .actions { display:flex; gap:5px; justify-content:center; flex-wrap:wrap; }
    .btn-action { padding:5px 10px; border-radius:7px; font-size:0.75rem; font-weight:700; border:none; cursor:pointer; font-family:'Segoe UI',sans-serif; text-decoration:none; display:inline-block; transition:opacity 0.15s; }
    .btn-action:hover { opacity:0.8; }
    .btn-voir { background:#eff6ff; color:#1d4ed8; }
    .btn-valider { background:#f0fdf4; color:#16a34a; }
    .btn-rejeter { background:#fffbeb; color:#d97706; }
    .btn-suppr { background:#fff1f2; color:#e11d48; }
    .btn-verifier-on { background:#f0fdf4; color:#16a34a; }
    .btn-verifier-off { background:#eff6ff; color:#1d4ed8; }
    .table-footer { padding:1rem 1.2rem; border-top:1px solid #f1f5f9; }
    .empty-row td { padding:3rem; text-align:center; color:#94a3b8; font-size:0.88rem; }

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
            <h1>Gestion des annonces</h1>
            <p>{{ $annonces->total() }} annonce(s) au total</p>
        </div>
        <form method="POST" action="{{ route('admin.annonces.expirees') }}" onsubmit="return confirm('Supprimer toutes les annonces expirées ?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn-danger-soft">Supprimer expirées</button>
        </form>
    </div>

    <form method="GET" class="filters-bar">
        <select name="statut" class="form-control-sm">
            <option value="">Tous les statuts</option>
            <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
            <option value="active" {{ request('statut') == 'active' ? 'selected' : '' }}>Actives</option>
            <option value="rejetee" {{ request('statut') == 'rejetee' ? 'selected' : '' }}>Rejetées</option>
            <option value="expiree" {{ request('statut') == 'expiree' ? 'selected' : '' }}>Expirées</option>
        </select>
        <button type="submit" class="btn-filter">Filtrer</button>
        <a href="{{ route('admin.annonces') }}" class="btn-reset">Réinitialiser</a>
    </form>

    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th>Annonce</th>
                    <th>Propriétaire</th>
                    <th>Type</th>
                    <th>Prix</th>
                    <th>Statut</th>
                    <th class="center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($annonces as $annonce)
                @php
                    $typeLabel = match($annonce->type) {
                        'location'      => 'Location',
                        'vente_maison'  => 'Vente',
                        'vente_terrain' => 'Terrain',
                        'commerce'      => 'Commerce',
                        default         => $annonce->type
                    };
                @endphp
                <tr>
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div class="annonce-thumb">
                                @if($annonce->photoPrincipale)
                                    <img src="{{ asset('storage/'.$annonce->photoPrincipale->url) }}" alt="">
                                @endif
                            </div>
                            <div>
                                <div class="annonce-title">
                                    {{ Str::limit($annonce->titre, 32) }}
                                    @if($annonce->verifie)
                                        <span class="badge-verifie-tag">✓ Vérifié</span>
                                    @endif
                                </div>
                                <div class="annonce-loc">📍 {{ $annonce->ville }}</div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $annonce->user->name }}</td>
                    <td>{{ $typeLabel }}</td>
                    <td style="font-weight:700; color:#3b82f6;">{{ number_format($annonce->prix, 0, ',', ' ') }} FCFA</td>
                    <td>
                        <span class="badge badge-{{ $annonce->statut }}">
                            {{ match($annonce->statut) { 'active' => 'Active', 'en_attente' => 'En attente', 'rejetee' => 'Rejetée', 'expiree' => 'Expirée', default => $annonce->statut } }}
                        </span>
                    </td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('annonces.show', $annonce) }}" class="btn-action btn-voir">Voir</a>

                            @if($annonce->statut == 'en_attente' || $annonce->statut == 'rejetee')
                                <form method="POST" action="{{ route('admin.annonces.valider', $annonce) }}">
                                    @csrf @method('PUT')
                                    <button type="submit" class="btn-action btn-valider">Valider</button>
                                </form>
                            @endif

                            @if($annonce->statut == 'active' || $annonce->statut == 'en_attente')
                                <form method="POST" action="{{ route('admin.annonces.rejeter', $annonce) }}" onsubmit="return demanderMotif(this, {{ $annonce->id }})">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="motif" id="motif-{{ $annonce->id }}">
                                    <button type="submit" class="btn-action btn-rejeter">Rejeter</button>
                                </form>
                            @endif

                            @if($annonce->statut == 'active')
                                <form method="POST" action="{{ route('admin.annonces.verifier', $annonce->id) }}">
                                    @csrf
                                    <input type="hidden" name="_method" value="PUT">
                                    <button type="submit" class="btn-action {{ $annonce->verifie ? 'btn-verifier-on' : 'btn-verifier-off' }}">
                                        {{ $annonce->verifie ? '✓ Vérifié' : 'Vérifier' }}
                                    </button>
                                </form>
                            @endif

                            <form method="POST" action="{{ route('admin.annonces.destroy', $annonce) }}" onsubmit="return confirm('Supprimer définitivement ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action btn-suppr">Supprimer</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                    <tr class="empty-row"><td colspan="6">Aucune annonce trouvée.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="table-footer">{{ $annonces->withQueryString()->links() }}</div>
    </div>
</div>

<script>
function demanderMotif(form, id) {
    var motif = prompt('Motif de rejet (sera envoyé par email au propriétaire) :');
    if (!motif || motif.trim() === '') { alert('Veuillez saisir un motif de rejet.'); return false; }
    document.getElementById('motif-' + id).value = motif;
    return true;
}
</script>

@endsection