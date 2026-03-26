@php
    $typeColor = match($annonce->type) {
        'location'     => '#10b981',
        'vente_maison' => '#3b82f6',
        'vente_terrain'=> '#f59e0b',
        'commerce'     => '#8b5cf6',
        default        => '#64748b'
    };
    $typeLabel = match($annonce->type) {
        'location'     => 'Location',
        'vente_maison' => 'Vente',
        'vente_terrain'=> 'Terrain',
        'commerce'     => 'Commerce',
        default        => $annonce->type
    };
    $statusLabel = match($annonce->statut) {
        'active'     => ['Active',   'status-active'],
        'en_attente' => ['En attente','status-attente'],
        'rejetee'    => ['Rejetée',  'status-rejetee'],
        'expiree'    => ['Expirée',  'status-expiree'],
        default      => [$annonce->statut, 'status-expiree']
    };
@endphp

<div class="annonce-card-dash">
    <div class="card-img-dash">
        @if($annonce->photoPrincipale)
            <img src="{{ asset('storage/'.$annonce->photoPrincipale->url) }}" alt="">
        @else
            <div class="card-no-img">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="3"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
            </div>
        @endif
        <span class="card-type-tag" style="background:{{ $typeColor }};">{{ $typeLabel }}</span>
        <span class="card-status-tag {{ $statusLabel[1] }}">{{ $statusLabel[0] }}</span>
    </div>

    <div class="card-body-dash">
        <div class="card-titre">{{ $annonce->titre }}</div>
        <div class="card-loc">📍 {{ $annonce->quartier }}, {{ $annonce->ville }}</div>
        <div class="card-prix">{{ number_format($annonce->prix, 0, ',', ' ') }} FCFA</div>

        <div class="card-stats-mini">
            <span class="card-stat-mini">👁 {{ $annonce->vues ?? 0 }} vues</span>
            <span class="card-stat-mini">❤️ {{ $annonce->favoris_count ?? 0 }} favoris</span>
            <span class="card-stat-mini">📅 {{ $annonce->created_at->format('d/m/Y') }}</span>
        </div>

        @if($annonce->statut === 'rejetee' && $annonce->motif_rejet)
            <div class="motif-box">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:1px;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <span><strong>Motif :</strong> {{ $annonce->motif_rejet }}</span>
            </div>
        @endif

        @if($annonce->is_premium && $annonce->expire_at)
            <div style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:6px;padding:5px 10px;font-size:0.72rem;color:#1d4ed8;font-weight:600;margin-bottom:10px;">
                💎 Premium — expire le {{ $annonce->expire_at->format('d/m/Y') }}
            </div>
        @endif

        <div class="card-actions">
            <a href="{{ route('annonces.show', $annonce) }}" class="btn-card btn-voir-c">👁 Voir</a>
            <a href="{{ route('annonces.edit', $annonce) }}" class="btn-card btn-edit-c">✏️ Modifier</a>

            @if(!$annonce->is_premium || ($annonce->expire_at && $annonce->expire_at->isPast()))
                <a href="{{ route('annonces.create') }}?booster={{ $annonce->id }}" class="btn-card btn-boost-c">🚀 Booster</a>
            @endif

            <form method="POST" action="{{ route('annonces.destroy', $annonce) }}"
                  onsubmit="return confirm('Supprimer cette annonce définitivement ?')" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-card btn-del-c">🗑</button>
            </form>
        </div>
    </div>
</div>