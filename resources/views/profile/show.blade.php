@extends('layouts.app')
@section('title', 'Mon profil')
@section('content')
<style>
.prof-wrap{max-width:1100px;margin:0 auto;padding:2rem 1.5rem}
.prof-banner{position:relative;height:180px;border-radius:16px;overflow:hidden;background:#0a2540;margin-bottom:0}
.prof-banner-bg{position:absolute;inset:0;background-image:url('https://images.unsplash.com/photo-1484154218962-a197022b5858?w=1200&q=70');background-size:cover;background-position:center;opacity:.35}
.prof-banner-overlay{position:absolute;inset:0;background:linear-gradient(180deg,transparent 30%,rgba(10,37,64,.85) 100%)}
.prof-card{background:white;border:1px solid #e8edf2;border-radius:16px;padding:1.5rem;margin-bottom:1.5rem;position:relative;margin-top:-60px}
.prof-header{display:flex;align-items:flex-end;gap:1.5rem;margin-bottom:1.5rem;flex-wrap:wrap}
.prof-avatar{width:90px;height:90px;border-radius:50%;background:#0a2540;color:white;display:flex;align-items:center;justify-content:center;font-size:2rem;font-weight:700;border:4px solid white;overflow:hidden;flex-shrink:0;box-shadow:0 4px 16px rgba(0,0,0,.12)}
.prof-avatar img{width:100%;height:100%;object-fit:cover}
.prof-name{font-size:20px;font-weight:800;color:#0a2540;letter-spacing:-.5px;margin-bottom:3px}
.prof-email{font-size:13px;color:#94a3b8;margin-bottom:8px}
.prof-badges{display:flex;gap:6px;flex-wrap:wrap}
.pb{padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700}
.pb-m{background:#f1f5f9;color:#64748b}
.pb-p{background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe}
.pb-a{background:#fef9c3;color:#854d0e;border:1px solid #fde68a}
.prof-edit-btn{display:inline-flex;align-items:center;gap:6px;padding:9px 18px;border-radius:10px;background:#0a2540;color:white;font-size:13px;font-weight:700;text-decoration:none;transition:background .2s;margin-left:auto;flex-shrink:0;align-self:center}
.prof-edit-btn:hover{background:#0f3460;color:white}
.prof-stats{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;padding-top:1.25rem;border-top:1px solid #f1f5f9}
.prof-stat{text-align:center}
.prof-stat-n{font-size:22px;font-weight:800;color:#0a2540;line-height:1}
.prof-stat-l{font-size:11px;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;margin-top:4px;font-weight:600}
.prof-offre{background:#f0f7ff;border:1px solid #bfdbfe;border-radius:12px;padding:1rem 1.25rem;margin-bottom:1.5rem;display:flex;align-items:center;gap:12px;flex-wrap:wrap}
.prof-offre-info{flex:1}
.prof-offre-title{font-size:14px;font-weight:700;color:#0a2540}
.prof-offre-sub{font-size:12px;color:#64748b;margin-top:2px}
.prof-offre-btn{padding:7px 16px;border-radius:8px;background:#2563eb;color:white;font-size:12px;font-weight:700;text-decoration:none;white-space:nowrap;flex-shrink:0}
.prof-offre-btn:hover{background:#1d4ed8;color:white}
.prof-grid{display:grid;grid-template-columns:1fr 1fr;gap:1.5rem}
.prof-sec{background:white;border:1px solid #e8edf2;border-radius:14px;padding:1.5rem}
.prof-sec-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem}
.prof-sec-title{font-size:14px;font-weight:700;color:#0a2540;display:flex;align-items:center;gap:8px}
.prof-sec-link{font-size:12px;color:#2563eb;text-decoration:none;font-weight:600}
.prof-ann-row{display:flex;gap:10px;padding:10px 0;border-bottom:1px solid #f8fafc}
.prof-ann-row:last-child{border-bottom:none;padding-bottom:0}
.prof-ann-row:first-child{padding-top:0}
.prof-ann-thumb{width:60px;height:50px;border-radius:8px;overflow:hidden;flex-shrink:0;background:#f1f5f9;display:flex;align-items:center;justify-content:center}
.prof-ann-thumb img{width:100%;height:100%;object-fit:cover}
.prof-ann-t{font-size:13px;font-weight:600;color:#0f172a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.prof-ann-p{font-size:12px;font-weight:700;color:#2563eb;margin-top:2px}
.prof-ann-s{display:inline-block;padding:1px 8px;border-radius:20px;font-size:10px;font-weight:700;margin-top:3px}
.sa{background:#dcfce7;color:#166534}.sw{background:#fef9c3;color:#854d0e}.sr{background:#fee2e2;color:#991b1b}
.prof-info-row{display:flex;align-items:center;justify-content:space-between;padding:8px 0;border-bottom:1px solid #f8fafc}
.prof-info-row:last-child{border-bottom:none}
.prof-info-k{font-size:12px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.4px}
.prof-info-v{font-size:13px;font-weight:600;color:#0f172a}
.prof-wa-box{display:flex;align-items:center;gap:10px;padding:.75rem 1rem;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;margin-top:.75rem}
.prof-wa-icon{width:32px;height:32px;border-radius:50%;background:#25D366;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.prof-notif{background:#fef9c3;border:1px solid #fde68a;border-radius:10px;padding:.75rem 1rem;font-size:13px;color:#854d0e;margin-bottom:1rem;display:flex;align-items:center;gap:8px}
.prof-notif.red{background:#fee2e2;border-color:#fecaca;color:#991b1b}
.prof-motif-row{padding:10px 0;border-bottom:1px solid #f8fafc}
.prof-motif-row:last-child{border-bottom:none}
.prof-motif-t{font-size:13px;font-weight:600;color:#0f172a;margin-bottom:3px}
.prof-motif-r{font-size:12px;color:#991b1b;background:#fef2f2;border-radius:6px;padding:3px 8px;display:inline-block}
.prof-empty{text-align:center;padding:2rem;color:#94a3b8;font-size:13px}
@media(max-width:768px){.prof-grid{grid-template-columns:1fr}.prof-stats{grid-template-columns:repeat(2,1fr)}.prof-header{flex-wrap:wrap}.prof-edit-btn{margin-left:0}}
</style>

<div class="prof-wrap">
    <div class="prof-banner"><div class="prof-banner-bg"></div><div class="prof-banner-overlay"></div></div>

    <div class="prof-card">
        <div class="prof-header">
            <div class="prof-avatar">
                @if(Auth::user()->avatar)<img src="{{ asset('storage/'.Auth::user()->avatar) }}" alt="">
                @else{{ strtoupper(substr(Auth::user()->name,0,1)) }}@endif
            </div>
            <div style="flex:1;min-width:0">
                <div class="prof-name">{{ Auth::user()->name }}</div>
                <div class="prof-email">{{ Auth::user()->email }}</div>
                <div class="prof-badges">
                    <span class="pb pb-m">Membre depuis {{ Auth::user()->created_at->format('M Y') }}</span>
                    @if(Auth::user()->is_admin)<span class="pb pb-a">⚙ Admin</span>@endif
                    @php $offreP=\App\Models\Annonce::where('user_id',Auth::id())->where('statut','active')->where('is_premium',true)->whereNotNull('expire_at')->where('expire_at','>',now())->first(); @endphp
                    @if($offreP)<span class="pb pb-p">💎 Premium</span>@endif
                </div>
            </div>
            <a href="{{ route('profile.edit') }}" class="prof-edit-btn">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Modifier le profil
            </a>
        </div>
        @php $mes=Auth::user()->annonces()->withCount('favoris')->get(); @endphp
        <div class="prof-stats">
            <div class="prof-stat"><div class="prof-stat-n">{{ $mes->count() }}</div><div class="prof-stat-l">Annonces</div></div>
            <div class="prof-stat"><div class="prof-stat-n" style="color:#059669">{{ $mes->where('statut','active')->count() }}</div><div class="prof-stat-l">Actives</div></div>
            <div class="prof-stat"><div class="prof-stat-n" style="color:#7c3aed">{{ number_format($mes->sum('vues'),0,',',' ') }}</div><div class="prof-stat-l">Vues totales</div></div>
            <div class="prof-stat"><div class="prof-stat-n" style="color:#db2777">{{ $mes->sum('favoris_count') }}</div><div class="prof-stat-l">Favoris reçus</div></div>
        </div>
    </div>

    @if($offreP)
        <div class="prof-offre">
            <span style="font-size:1.5rem">💎</span>
            <div class="prof-offre-info">
                <div class="prof-offre-title">Offre Premium active</div>
                <div class="prof-offre-sub">Expire le {{ $offreP->expire_at->format('d/m/Y') }} — {{ (int)now()->diffInDays($offreP->expire_at) }} jours restants</div>
            </div>
            <a href="{{ route('annonces.create') }}" class="prof-offre-btn">Renouveler</a>
        </div>
    @endif

    <div class="prof-grid">
        <div class="prof-sec">
            <div class="prof-sec-head">
                <div class="prof-sec-title"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>Mes annonces récentes</div>
                <a href="{{ route('dashboard') }}" class="prof-sec-link">Voir tout →</a>
            </div>
            @php $rec=$mes->sortByDesc('created_at')->take(5); @endphp
            @if($rec->isEmpty())<div class="prof-empty">Aucune annonce publiée</div>
            @else
                @foreach($rec as $a)
                    @php $sl=match($a->statut){'active'=>['Active','sa'],'en_attente'=>['En attente','sw'],'rejetee'=>['Rejetée','sr'],default=>['—','']}; @endphp
                    <div class="prof-ann-row">
                        <div class="prof-ann-thumb">
                            @if($a->photoPrincipale)<img src="{{ asset('storage/'.$a->photoPrincipale->url) }}" alt="">
                            @else<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="3"/></svg>@endif
                        </div>
                        <div style="flex:1;min-width:0">
                            <div class="prof-ann-t">{{ $a->titre }}</div>
                            <div class="prof-ann-p">{{ number_format($a->prix,0,',',' ') }} FCFA</div>
                            <span class="prof-ann-s {{ $sl[1] }}">{{ $sl[0] }}</span>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <div style="display:flex;flex-direction:column;gap:1.5rem">
            <div class="prof-sec">
                <div class="prof-sec-head">
                    <div class="prof-sec-title"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>Informations du compte</div>
                    <a href="{{ route('profile.edit') }}" class="prof-sec-link">Modifier</a>
                </div>
                <div class="prof-info-row"><span class="prof-info-k">Nom</span><span class="prof-info-v">{{ Auth::user()->name }}</span></div>
                <div class="prof-info-row"><span class="prof-info-k">Email</span><span class="prof-info-v">{{ Auth::user()->email }}</span></div>
                <div class="prof-info-row"><span class="prof-info-k">Inscrit le</span><span class="prof-info-v">{{ Auth::user()->created_at->format('d/m/Y') }}</span></div>
                @if(Auth::user()->whatsapp)
                    <div class="prof-wa-box">
                        <div class="prof-wa-icon"><svg width="15" height="15" viewBox="0 0 24 24" fill="white"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg></div>
                        <div><div style="font-size:13px;font-weight:600;color:#166534">{{ Auth::user()->whatsapp }}</div><div style="font-size:11px;color:#64748b;margin-top:1px">WhatsApp de contact</div></div>
                    </div>
                @else
                    <div style="padding:.75rem;background:#fff7ed;border:1px solid #fed7aa;border-radius:8px;font-size:12px;color:#c2410c;margin-top:.75rem">
                        <a href="{{ route('profile.edit') }}" style="color:#c2410c;font-weight:600">Ajoutez votre WhatsApp</a> pour être contacté directement.
                    </div>
                @endif
            </div>

            @php $att=$mes->where('statut','en_attente');$rej=$mes->where('statut','rejetee'); @endphp
            @if($att->count()>0)
                <div class="prof-sec">
                    <div class="prof-notif"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $att->count() }} annonce(s) en attente de validation</div>
                    @foreach($att->take(3) as $a)<div class="prof-motif-row"><div class="prof-motif-t">{{ $a->titre }}</div><div style="font-size:12px;color:#94a3b8">Soumise le {{ $a->created_at->format('d/m/Y') }}</div></div>@endforeach
                </div>
            @endif
            @if($rej->count()>0)
                <div class="prof-sec">
                    <div class="prof-notif red"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ $rej->count() }} annonce(s) rejetée(s)</div>
                    @foreach($rej->take(3) as $a)<div class="prof-motif-row"><div class="prof-motif-t">{{ $a->titre }}</div>@if($a->motif_rejet)<span class="prof-motif-r">{{ $a->motif_rejet }}</span>@endif</div>@endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection