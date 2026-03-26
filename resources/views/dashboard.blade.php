@extends('layouts.app')
@section('title', 'Mon espace')
@section('content')
<style>
.ds-wrap{max-width:1180px;margin:0 auto;padding:1.75rem 1.5rem}
.ds-header{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:1.75rem;flex-wrap:wrap;gap:1rem}
.ds-welcome h1{font-size:20px;font-weight:700;color:#042C53;letter-spacing:-.5px}
.ds-welcome p{font-size:13px;color:#94a3b8;margin-top:2px;font-weight:400}
.ds-btn-new{display:inline-flex;align-items:center;gap:5px;padding:8px 16px;border-radius:8px;background:#042C53;color:white;font-size:13px;font-weight:600;text-decoration:none;transition:background .2s;white-space:nowrap}
.ds-btn-new:hover{background:#185FA5;color:white}
.ds-stats{display:grid;grid-template-columns:repeat(6,1fr);gap:8px;margin-bottom:1.75rem}
.ds-stat{background:#f8fafc;border-radius:8px;padding:1rem;text-align:center}
.ds-stat-n{font-size:20px;font-weight:700;line-height:1;color:#042C53}
.ds-stat-l{font-size:10px;color:#94a3b8;text-transform:uppercase;letter-spacing:.4px;margin-top:4px;font-weight:500}
.ds-offre-banner{background:white;border:0.5px solid #e8edf2;border-radius:10px;padding:.9rem 1.25rem;margin-bottom:1.5rem;display:flex;align-items:center;gap:10px;flex-wrap:wrap}
.ds-offre-banner.premium{border-color:#B5D4F4;background:#E6F1FB}
.ds-offre-banner.expiring{border-color:#FAC775;background:#FAEEDA}
.ds-offre-icon{font-size:1.35rem;flex-shrink:0}
.ds-offre-text{flex:1}
.ds-offre-title{font-size:13px;font-weight:600;color:#042C53}
.ds-offre-sub{font-size:11px;color:#64748b;margin-top:1px}
.ds-btn-renouveler{padding:6px 14px;border-radius:7px;background:#185FA5;color:white;font-size:12px;font-weight:600;text-decoration:none;white-space:nowrap;flex-shrink:0}
.ds-btn-renouveler:hover{background:#042C53;color:white}
.ds-toolbar{display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;flex-wrap:wrap;gap:8px}
.ds-filters{display:flex;gap:5px;flex-wrap:wrap}
.ds-filter-btn{padding:6px 14px;border-radius:20px;border:0.5px solid #e2e8f0;background:white;font-size:12px;font-weight:500;color:#64748b;cursor:pointer;transition:all .15s;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif}
.ds-filter-btn:hover{border-color:#042C53;color:#042C53}
.ds-filter-btn.active{background:#042C53;color:white;border-color:#042C53}
.ds-pay-btn{display:inline-flex;align-items:center;gap:5px;padding:6px 14px;border-radius:20px;border:0.5px solid #B5D4F4;background:transparent;color:#185FA5;font-size:12px;font-weight:500;cursor:pointer;text-decoration:none;transition:all .15s;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif}
.ds-pay-btn:hover{background:#E6F1FB}
.ds-grid{display:grid;grid-template-columns:1fr 1fr;gap:1rem}
.ds-card{background:white;border:0.5px solid #e8edf2;border-radius:12px;overflow:hidden;transition:box-shadow .2s}
.ds-card:hover{box-shadow:0 3px 16px rgba(0,0,0,.06)}
.ds-card-img{height:150px;background:#f1f5f9;position:relative;overflow:hidden;display:flex;align-items:center;justify-content:center}
.ds-card-img img{width:100%;height:100%;object-fit:cover}
.ds-card-no-img{display:flex;flex-direction:column;align-items:center;justify-content:center;height:100%;color:#cbd5e1;font-size:11px;gap:5px}
.ds-carr-inner{display:flex;height:100%;transition:transform .4s ease}
.ds-carr-inner img{min-width:100%;height:100%;object-fit:cover;flex-shrink:0}
.ds-carr-btn{position:absolute;top:50%;transform:translateY(-50%);background:rgba(0,0,0,.4);color:white;border:none;border-radius:50%;width:22px;height:22px;cursor:pointer;font-size:13px;display:flex;align-items:center;justify-content:center;z-index:4;transition:background .15s}
.ds-carr-btn:hover{background:rgba(0,0,0,.6)}
.ds-carr-prev{left:5px}.ds-carr-next{right:5px}
.ds-carr-dots{position:absolute;bottom:5px;left:50%;transform:translateX(-50%);display:flex;gap:3px;z-index:4}
.ds-carr-dot{width:4px;height:4px;border-radius:50%;background:rgba(255,255,255,.5);transition:background .2s}
.ds-carr-dot.on{background:white}
.ds-card-type{position:absolute;top:8px;left:8px;padding:2px 8px;border-radius:20px;font-size:10px;font-weight:600;color:white}
.ds-card-status{position:absolute;top:8px;right:8px;padding:2px 8px;border-radius:20px;font-size:10px;font-weight:600}
.s-active{background:#EAF3DE;color:#27500A}
.s-wait{background:#FAEEDA;color:#633806}
.s-rej{background:#FCEBEB;color:#791F1F}
.s-exp{background:#f1f5f9;color:#64748b}
.ds-card-body{padding:.9rem 1rem}
.ds-card-title{font-size:13px;font-weight:600;color:#0f172a;margin-bottom:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.ds-card-loc{font-size:11px;color:#94a3b8;margin-bottom:5px}
.ds-card-price{font-size:14px;font-weight:700;color:#042C53;margin-bottom:7px}
.ds-card-meta{display:flex;gap:9px;margin-bottom:8px}
.ds-meta-item{font-size:10px;color:#94a3b8;display:flex;align-items:center;gap:2px}
.ds-motif{background:#FCEBEB;border:0.5px solid #F7C1C1;border-radius:6px;padding:7px 9px;font-size:11px;color:#791F1F;margin-bottom:8px;line-height:1.5}
.ds-premium-tag{background:#E6F1FB;border:0.5px solid #B5D4F4;border-radius:5px;padding:3px 8px;font-size:10px;color:#185FA5;font-weight:500;margin-bottom:8px;display:inline-block}
.ds-card-actions{display:flex;gap:5px;flex-wrap:wrap}
.ds-act-btn{padding:5px 10px;border-radius:6px;font-size:11px;font-weight:500;border:0.5px solid #e2e8f0;background:white;color:#475569;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:3px;transition:all .15s;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif}
.ds-act-btn:hover{border-color:#94a3b8;color:#042C53}
.ds-act-blue{border-color:#B5D4F4;color:#185FA5;background:#E6F1FB}
.ds-act-blue:hover{background:#B5D4F4;border-color:#85B7EB;color:#185FA5}
.ds-act-boost{border-color:#FAC775;color:#633806;background:#FAEEDA}
.ds-act-boost:hover{background:#EF9F27;border-color:#EF9F27;color:white}
.ds-act-del{border-color:#F7C1C1;color:#A32D2D;background:#FCEBEB}
.ds-act-del:hover{background:#F7C1C1;color:#791F1F}
.ds-pagination{display:flex;justify-content:center;margin-top:1.25rem;gap:5px}
.ds-page-btn{width:32px;height:32px;border-radius:7px;border:0.5px solid #e2e8f0;background:white;font-size:12px;font-weight:500;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#64748b;transition:all .15s}
.ds-page-btn:hover{border-color:#042C53;color:#042C53}
.ds-page-btn.active{background:#042C53;color:white;border-color:#042C53}
.ds-page-btn.disabled{opacity:.4;cursor:not-allowed;pointer-events:none}
.ds-empty{text-align:center;padding:3.5rem 2rem;background:white;border:0.5px solid #e8edf2;border-radius:12px;color:#94a3b8}
.ds-empty h3{font-size:14px;color:#64748b;margin-bottom:7px;font-weight:600}
.ds-pay-overlay{position:fixed;inset:0;background:rgba(4,44,83,.4);z-index:2000;opacity:0;pointer-events:none;transition:opacity .3s}
.ds-pay-overlay.open{opacity:1;pointer-events:all}
.ds-pay-modal{position:fixed;bottom:0;left:0;right:0;background:white;border-radius:16px 16px 0 0;z-index:2001;transform:translateY(100%);transition:transform .3s cubic-bezier(.4,0,.2,1);max-height:75vh;overflow-y:auto;padding:1.25rem}
.ds-pay-modal.open{transform:translateY(0)}
.ds-pay-modal-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem}
.ds-pay-modal-head h3{font-size:15px;font-weight:600;color:#042C53}
.ds-pay-close{width:28px;height:28px;border-radius:6px;border:0.5px solid #e2e8f0;background:white;cursor:pointer;font-size:18px;display:flex;align-items:center;justify-content:center;color:#64748b;line-height:1}
.ds-pay-table{width:100%;border-collapse:collapse}
.ds-pay-table th{padding:8px 11px;text-align:left;font-size:10px;color:#94a3b8;font-weight:500;text-transform:uppercase;letter-spacing:.4px;border-bottom:0.5px solid #f1f5f9;background:#f8fafc}
.ds-pay-table td{padding:10px 11px;font-size:12px;border-bottom:0.5px solid #f1f5f9;color:#1e293b}
.ds-pay-table tr:last-child td{border-bottom:none}
@media(max-width:900px){.ds-stats{grid-template-columns:repeat(3,1fr)}.ds-grid{grid-template-columns:1fr}}
@media(max-width:640px){.ds-wrap{padding:1rem}.ds-stats{grid-template-columns:repeat(2,1fr)}}
</style>

<div class="ds-pay-overlay" id="dsPayOverlay" onclick="dsClosePay()"></div>
<div class="ds-pay-modal" id="dsPayModal">
    <div class="ds-pay-modal-head">
        <h3>Historique des paiements</h3>
        <button class="ds-pay-close" onclick="dsClosePay()">×</button>
    </div>
    @php $paiements=\App\Models\Paiement::where('user_id',Auth::id())->with('annonce')->orderByDesc('created_at')->get(); @endphp
    @if($paiements->isEmpty())
        <div style="text-align:center;padding:2rem;color:#94a3b8;font-size:13px">Aucun paiement effectué pour l'instant.</div>
    @else
        <table class="ds-pay-table">
            <thead><tr><th>Annonce</th><th>Offre</th><th>Montant</th><th>Mode</th><th>Statut</th><th>Date</th></tr></thead>
            <tbody>
                @foreach($paiements as $p)
                    @php $sc=match($p->statut??''){'complete'=>['Confirmé','#EAF3DE','#27500A'],'en_attente'=>['En attente','#FAEEDA','#633806'],default=>['Échoué','#FCEBEB','#791F1F']}; @endphp
                    <tr>
                        <td style="font-weight:500">{{ $p->annonce?->titre??'—' }}</td>
                        <td>{{ match($p->offre??''){'boost_14j'=>'Boost 14j','premium_30j'=>'Premium 30j','pass_annuel'=>'Pro annuel',default=>$p->offre??'—'} }}</td>
                        <td style="font-weight:600;color:#042C53">{{ number_format($p->montant,0,',',' ') }} FCFA</td>
                        <td style="color:#64748b">{{ match($p->mode_paiement??''){'airtel_money'=>'Airtel','moov_money'=>'Moov','carte'=>'Visa/MC',default=>'—'} }}</td>
                        <td><span style="background:{{ $sc[1] }};color:{{ $sc[2] }};padding:2px 7px;border-radius:20px;font-size:10px;font-weight:600">{{ $sc[0] }}</span></td>
                        <td style="color:#94a3b8;font-size:11px">{{ $p->created_at->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<div class="ds-wrap">
    @php
    $scoreUser = Auth::user()->score ?? 30;
    $scoreBg   = match(true){ $scoreUser>=90=>'#042C53',$scoreUser>=75=>'#185FA5',$scoreUser>=60=>'#1D9E75',$scoreUser>=40=>'#BA7517',default=>'#A32D2D' };
    $badgeUser = match(true){ $scoreUser>=90=>['Elite GaboPlex','#042C53','white'],$scoreUser>=75=>['De confiance','#185FA5','white'],$scoreUser>=60=>['Fiable','#EAF3DE','#27500A'],$scoreUser>=40=>['Profil actif','#E6F1FB','#0C447C'],default=>['Profil basique','#f1f5f9','#64748b'] };
@endphp
<div class="ds-header">
        <div class="ds-welcome">
            <h1>Bonjour, {{ Auth::user()->name }} 👋</h1>
            <p>Gérez vos annonces immobilières sur GaboPlex</p>
        </div>
        {{-- SCORE BADGE --}}
        <a href="{{ route('contrats.index') }}" style="display:inline-flex;align-items:center;gap:10px;padding:.6rem 1.1rem;background:white;border:0.5px solid #e8edf2;border-radius:12px;text-decoration:none;transition:all .2s" title="Voir mes contrats et mon score">
            <div style="display:flex;flex-direction:column;align-items:center">
                <span style="font-size:20px;font-weight:700;color:{{ $scoreBg }};line-height:1">{{ $scoreUser }}</span>
                <span style="font-size:9px;color:#94a3b8;font-weight:400">/100</span>
            </div>
            <div>
                <span style="display:block;padding:2px 9px;border-radius:20px;font-size:11px;font-weight:600;background:{{ $badgeUser[1] }};color:{{ $badgeUser[2] }};margin-bottom:3px">{{ $badgeUser[0] }}</span>
                <span style="font-size:11px;color:#94a3b8">Mon score GaboPlex →</span>
            </div>
        </a>
        <a href="{{ route('annonces.create') }}" class="ds-btn-new">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Nouvelle annonce
        </a>
    </div>

    @php
        $total=$annonces->count();$actives=$annonces->where('statut','active')->count();
        $attente=$annonces->where('statut','en_attente')->count();$rejetees=$annonces->where('statut','rejetee')->count();
        $totalVues=$annonces->sum('vues');$totalFavs=$annonces->sum('favoris_count');
    @endphp
    <div class="ds-stats">
        <div class="ds-stat"><div class="ds-stat-n">{{ $total }}</div><div class="ds-stat-l">Annonces</div></div>
        <div class="ds-stat"><div class="ds-stat-n" style="color:#27500A">{{ $actives }}</div><div class="ds-stat-l">Actives</div></div>
        <div class="ds-stat"><div class="ds-stat-n" style="color:#633806">{{ $attente }}</div><div class="ds-stat-l">En attente</div></div>
        <div class="ds-stat"><div class="ds-stat-n" style="color:#791F1F">{{ $rejetees }}</div><div class="ds-stat-l">Rejetées</div></div>
        <div class="ds-stat"><div class="ds-stat-n" style="color:#534AB7">{{ number_format($totalVues,0,',',' ') }}</div><div class="ds-stat-l">Vues</div></div>
        <div class="ds-stat"><div class="ds-stat-n" style="color:#993556">{{ $totalFavs }}</div><div class="ds-stat-l">Favoris</div></div>
    </div>

    @php $offreActive=$annonces->where('statut','active')->where('is_premium',true)->whereNotNull('expire_at')->sortByDesc('expire_at')->first();$joursRestants=$offreActive?(int)now()->diffInDays($offreActive->expire_at,false):null; @endphp
    @if($offreActive)
        <div class="ds-offre-banner {{ $joursRestants<=5?'expiring':'premium' }}">
            <span class="ds-offre-icon">{{ $joursRestants<=5?'⚠️':'💎' }}</span>
            <div class="ds-offre-text">
                <div class="ds-offre-title">
                    @if($joursRestants<=5)
                        Votre offre expire dans {{ $joursRestants }} jour(s)
                    @else
                        Offre Premium active
                    @endif
                </div>
                <div class="ds-offre-sub">Expire le {{ $offreActive->expire_at->format('d/m/Y') }}</div>
            </div>
            <a href="{{ route('annonces.booster',$offreActive) }}" class="ds-btn-renouveler">Renouveler</a>
        </div>
    @endif

    <div class="ds-toolbar">
        <div class="ds-filters">
            <button class="ds-filter-btn active" onclick="dsFilter('toutes',this)">Toutes <span style="background:#e2e8f0;color:#475569;padding:1px 6px;border-radius:20px;font-size:10px;margin-left:3px">{{ $total }}</span></button>
            <button class="ds-filter-btn" onclick="dsFilter('active',this)">Actives <span style="background:#EAF3DE;color:#27500A;padding:1px 6px;border-radius:20px;font-size:10px;margin-left:3px">{{ $actives }}</span></button>
            <button class="ds-filter-btn" onclick="dsFilter('en_attente',this)">En attente <span style="background:#FAEEDA;color:#633806;padding:1px 6px;border-radius:20px;font-size:10px;margin-left:3px">{{ $attente }}</span></button>
            <button class="ds-filter-btn" onclick="dsFilter('rejetee',this)">Rejetées <span style="background:#FCEBEB;color:#791F1F;padding:1px 6px;border-radius:20px;font-size:10px;margin-left:3px">{{ $rejetees }}</span></button>
            <button class="ds-pay-btn" onclick="dsOpenPay()">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                Paiements
            </button>
        </div>
    </div>

    @if($annonces->isEmpty())
        <div class="ds-empty">
            <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" style="margin-bottom:.9rem"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            <h3>Aucune annonce pour l'instant</h3>
            <p style="font-size:12px;margin-bottom:1.25rem">Publiez votre première annonce gratuitement</p>
            <a href="{{ route('annonces.create') }}" style="display:inline-block;background:#042C53;color:white;padding:9px 22px;border-radius:8px;text-decoration:none;font-weight:600;font-size:13px">+ Publier une annonce</a>
        </div>
    @else
        <div class="ds-grid" id="dsGrid">
            @foreach($annonces as $annonce)
                @php $typeLabel=match($annonce->type){'location'=>'Location','vente_maison'=>'Vente','vente_terrain'=>'Terrain','commerce'=>'Commerce',default=>$annonce->type};$sLabel=match($annonce->statut){'active'=>['Active','s-active'],'en_attente'=>['En attente','s-wait'],'rejetee'=>['Rejetée','s-rej'],default=>['Expirée','s-exp']}; @endphp
                <div class="ds-card" data-statut="{{ $annonce->statut }}">
                    <div class="ds-card-img">
                        @php $photos=$annonce->photos??collect(); @endphp
                        @if($photos->isNotEmpty())
                            <div class="ds-carr-inner" id="dsCarr-{{ $annonce->id }}">
                                @foreach($photos as $photo)<img src="{{ asset('storage/'.$photo->url) }}" alt="{{ $annonce->titre }}">@endforeach
                            </div>
                            @if($photos->count()>1)
                                <button onclick="event.preventDefault();event.stopPropagation();dsSlide('{{ $annonce->id }}',-1)" class="ds-carr-btn ds-carr-prev">‹</button>
                                <button onclick="event.preventDefault();event.stopPropagation();dsSlide('{{ $annonce->id }}',1)" class="ds-carr-btn ds-carr-next">›</button>
                                <div class="ds-carr-dots" id="dsDots-{{ $annonce->id }}">@foreach($photos as $p)<div class="ds-carr-dot {{ $loop->first?'on':'' }}"></div>@endforeach</div>
                            @endif
                        @else
                            <div class="ds-card-no-img"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="3"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg></div>
                        @endif
                        <span class="ds-card-type badge-{{ $annonce->type }}">{{ $typeLabel }}</span>
                        <span class="ds-card-status {{ $sLabel[1] }}">{{ $sLabel[0] }}</span>
                    </div>
                    <div class="ds-card-body">
                        <div class="ds-card-title">{{ $annonce->titre }}</div>
                        <div class="ds-card-loc">📍 {{ $annonce->quartier }}, {{ $annonce->ville }}</div>
                        <div class="ds-card-price">
                            {{ number_format($annonce->prix,0,',',' ') }} FCFA
                            @if($annonce->type==='location')<span style="font-size:10px;color:#94a3b8;font-weight:400">/mois</span>@endif
                        </div>
                        @if($annonce->is_premium&&$annonce->expire_at)
                            <div class="ds-premium-tag">💎 Premium — expire le {{ $annonce->expire_at->format('d/m/Y') }}</div>
                        @endif
                        @if($annonce->statut==='rejetee'&&$annonce->motif_rejet)
                            <div class="ds-motif"><strong>Motif :</strong> {{ $annonce->motif_rejet }}</div>
                        @endif
                        <div class="ds-card-meta">
                            <span class="ds-meta-item"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>{{ $annonce->vues??0 }}</span>
                            <span class="ds-meta-item"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>{{ $annonce->favoris_count??0 }}</span>
                            <span class="ds-meta-item">{{ $annonce->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="ds-card-actions">
                            <a href="{{ route('annonces.show',$annonce) }}" class="ds-act-btn">Voir</a>
                            @if($annonce->statut !== 'expiree' && $annonce->statut !== 'vendue')
                                <a href="{{ route('annonces.edit',$annonce) }}" class="ds-act-btn ds-act-blue">Modifier</a>
                            @endif
                            @if($annonce->statut === 'expiree')
                                <span class="ds-act-btn" style="cursor:default;opacity:.5;border-color:#fecaca;color:#dc2626">Expirée</span>
                            @elseif($annonce->statut === 'vendue')
                                <span class="ds-act-btn" style="cursor:default;opacity:.5;border-color:#C0DD97;color:#27500A">Vendue</span>
                            @elseif(!$annonce->is_premium||($annonce->expire_at&&$annonce->expire_at->isPast()))
                                <a href="{{ route('annonces.booster',$annonce) }}" class="ds-act-btn ds-act-boost"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>Booster</a>
                            @endif
                            @if($annonce->statut==='active')
                                <a href="{{ route('annonces.pancarte',$annonce) }}" class="ds-act-btn" style="border-color:#B5D4F4;color:#0C447C;background:#E6F1FB" title="Télécharger la pancarte QR Code"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>Pancarte</a>

                            @if($annonce->statut==='active')
                                @php
                                    try {
                                        $nbMsg = \App\Models\Message::where('annonce_id', $annonce->id)
                                            ->where(function($q){ $q->where('receiver_id', Auth::id())->orWhere('sender_id', Auth::id()); })
                                            ->count();
                                    } catch (\Exception $e) {
                                        $nbMsg = 0;
                                    }
                                @endphp
                                @if($nbMsg > 0)
                                <a href="{{ route('messages.index') }}" class="ds-act-btn" style="border-color:#C0DD97;color:#27500A;background:#EAF3DE">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/></svg>
                                    Formaliser un accord
                                </a>
                                @endif
                            @endif
                            @endif
                            <form method="POST" action="{{ route('annonces.destroy',$annonce) }}" onsubmit="return confirm('Supprimer définitivement ?')" style="display:inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="ds-act-btn ds-act-del">✕</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="ds-pagination" id="dsPagination">
            <button class="ds-page-btn disabled" id="dsPrev" onclick="dsPage(-1)">←</button>
            <span class="ds-page-btn active" id="dsPageLbl">1</span>
            <button class="ds-page-btn" id="dsNext" onclick="dsPage(1)">→</button>
        </div>
    @endif
</div>

<script>
var dsFilter_current='toutes',dsPage_current=1,dsPerPage=6;
function dsFilter(s,btn){dsFilter_current=s;dsPage_current=1;document.querySelectorAll('.ds-filter-btn').forEach(function(b){b.classList.remove('active')});btn.classList.add('active');dsRender()}
function dsGetCards(){var all=Array.from(document.querySelectorAll('#dsGrid .ds-card'));return dsFilter_current==='toutes'?all:all.filter(function(c){return c.dataset.statut===dsFilter_current})}
function dsRender(){var cards=dsGetCards(),total=cards.length,start=(dsPage_current-1)*dsPerPage,end=start+dsPerPage;document.querySelectorAll('#dsGrid .ds-card').forEach(function(c){c.style.display='none'});cards.slice(start,end).forEach(function(c){c.style.display=''});var tp=Math.ceil(total/dsPerPage);document.getElementById('dsPageLbl').textContent=dsPage_current;document.getElementById('dsPrev').classList.toggle('disabled',dsPage_current<=1);document.getElementById('dsNext').classList.toggle('disabled',dsPage_current>=tp);document.getElementById('dsPagination').style.display=tp<=1?'none':'flex'}
function dsPage(d){var total=dsGetCards().length,tp=Math.ceil(total/dsPerPage);dsPage_current=Math.max(1,Math.min(dsPage_current+d,tp));dsRender()}
document.addEventListener('DOMContentLoaded',dsRender);
var dsCP={};
function dsSlide(id,dir){var c=document.getElementById('dsCarr-'+id);if(!c)return;var imgs=c.querySelectorAll('img'),total=imgs.length;if(!dsCP[id])dsCP[id]=0;dsCP[id]=(dsCP[id]+dir+total)%total;c.style.transform='translateX(-'+(dsCP[id]*100)+'%)';document.querySelectorAll('#dsDots-'+id+' .ds-carr-dot').forEach(function(d,i){d.classList.toggle('on',i===dsCP[id])})}
document.addEventListener('DOMContentLoaded',function(){document.querySelectorAll('.ds-carr-inner').forEach(function(c){var id=c.id.replace('dsCarr-','');if(c.querySelectorAll('img').length>1){setInterval(function(){dsSlide(id,1)},5000)}})});
function dsOpenPay(){document.getElementById('dsPayOverlay').classList.add('open');document.getElementById('dsPayModal').classList.add('open');document.body.style.overflow='hidden'}
function dsClosePay(){document.getElementById('dsPayOverlay').classList.remove('open');document.getElementById('dsPayModal').classList.remove('open');document.body.style.overflow=''}
document.addEventListener('keydown',function(e){if(e.key==='Escape')dsClosePay()});
</script>
@endsection