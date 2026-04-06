{{--
  CE FICHIER EST UTILISÉ PAR :
  - resources/views/annonces/location.blade.php
  - resources/views/annonces/vente.blade.php
  - resources/views/annonces/commerces.blade.php

  Le controller passe :
  - $typeActif  : 'location' | 'vente_maison' | 'commerce'
  - $annonces   : collection paginée
  - $annoncesCarteJson
  - $aDejaGratuite
--}}
@extends('layouts.app')

@section('title', $pageTitle ?? 'Annonces')

@section('content')
<style>
/* ══ HERO COMPACT TYPE-SPÉCIFIQUE ═══════════════════════════════════════════ */
.tp-hero{position:relative;min-height:320px;display:flex;align-items:center;overflow:hidden;background:#0a2540}
.tp-hero-bg{position:absolute;inset:0;background-size:cover;background-position:center;z-index:0}
.tp-hero-overlay{position:absolute;inset:0;background:linear-gradient(105deg,rgba(10,37,64,.95) 0%,rgba(10,37,64,.75) 50%,rgba(10,37,64,.35) 100%);z-index:1}
.tp-hero-content{position:relative;z-index:2;padding:3rem 3rem;max-width:640px}
.tp-hero-pill{display:inline-flex;align-items:center;gap:6px;padding:5px 14px;border-radius:30px;font-size:12px;font-weight:700;color:white;margin-bottom:1rem}
.tp-hero h1{font-size:2.5rem;font-weight:800;color:white;line-height:1.2;margin-bottom:.75rem;letter-spacing:-1px}
.tp-hero h1 em{font-style:normal}
.tp-hero p{font-size:15px;color:rgba(255,255,255,.65);line-height:1.7;margin-bottom:2rem}
.tp-hero-search{background:white;border-radius:12px;padding:5px;display:flex;gap:0;max-width:560px;box-shadow:0 16px 48px rgba(0,0,0,.3)}
.tp-hs-field{flex:1;padding:8px 14px;border-right:1px solid #e2e8f0;display:flex;flex-direction:column}
.tp-hs-field:last-of-type{border-right:none}
.tp-hs-label{font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;margin-bottom:3px}
.tp-hs-select,.tp-hs-input{border:none;outline:none;background:transparent;font-size:13px;font-weight:500;color:#1e293b;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif;padding:0}
.tp-hero-btn{background:#0a2540;color:white;border:none;padding:0 24px;border-radius:9px;margin:3px;font-size:13px;font-weight:700;cursor:pointer;display:flex;align-items:center;gap:7px;white-space:nowrap;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif;transition:background .2s}
.tp-hero-btn:hover{background:#0f3460}

/* STATS */
.tp-stats{background:white;border-bottom:1px solid #e2e8f0;padding:1.25rem 3rem;display:flex;justify-content:center;gap:5rem;flex-wrap:wrap}
.tp-stat{text-align:center}
.tp-stat-n{font-size:1.75rem;font-weight:800;color:#0a2540;line-height:1}
.tp-stat-l{font-size:11px;color:#94a3b8;text-transform:uppercase;letter-spacing:1.5px;margin-top:4px;font-weight:600}

/* CONTENU */
.tp-content{max-width:1200px;margin:0 auto;padding:1.75rem 1.5rem}
.tp-bar{display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;flex-wrap:wrap;gap:10px}
.tp-count{font-size:15px;font-weight:700;color:#0a2540}
.tp-bar-right{display:flex;align-items:center;gap:10px}
.tp-tri{padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:13px;color:#1e293b;outline:none;background:white;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif;cursor:pointer}
.tp-filter-btn{display:inline-flex;align-items:center;gap:7px;padding:8px 16px;border-radius:10px;border:1.5px solid #e2e8f0;background:white;font-size:13px;font-weight:600;color:#0a2540;cursor:pointer;transition:all .2s;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif}
.tp-filter-btn:hover{border-color:#0a2540;background:#f8fafc}
.tp-filtres-badge{background:#0a2540;color:white;width:20px;height:20px;border-radius:50%;font-size:11px;font-weight:700;display:inline-flex;align-items:center;justify-content:center}

/* CARDS (réutilise le même style que index) */
.gp-cards-grid{display:grid;grid-template-columns:1fr 1fr;gap:1.25rem}
.gp-card{background:white;border-radius:14px;overflow:hidden;border:1px solid #e8edf2;text-decoration:none;color:inherit;display:grid;grid-template-columns:220px 1fr;transition:box-shadow .2s,transform .2s;position:relative}
.gp-card:hover{box-shadow:0 8px 32px rgba(0,0,0,.09);transform:translateY(-2px)}
.gp-card-img{position:relative;overflow:hidden;background:#f1f5f9;min-height:180px}
.gp-card-img img{width:100%;height:100%;object-fit:cover;display:block}
.gp-card-no-img{width:100%;height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;color:#cbd5e1;font-size:12px;gap:8px;padding:1rem;min-height:180px}
.gp-carrousel-inner{display:flex;height:100%;transition:transform .4s ease}
.gp-carrousel-inner img{min-width:100%;height:100%;object-fit:cover;flex-shrink:0}
.gp-carr-btn{position:absolute;top:50%;transform:translateY(-50%);background:rgba(0,0,0,.45);color:white;border:none;border-radius:50%;width:26px;height:26px;cursor:pointer;font-size:14px;display:flex;align-items:center;justify-content:center;z-index:3}
.gp-carr-prev{left:6px}.gp-carr-next{right:6px}
.gp-carr-dots{position:absolute;bottom:6px;left:50%;transform:translateX(-50%);display:flex;gap:4px;z-index:3}
.gp-carr-dot{width:5px;height:5px;border-radius:50%;background:rgba(255,255,255,.5)}
.gp-carr-dot.active{background:white}
.gp-type-badge{position:absolute;top:10px;left:10px;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;color:white;z-index:2}
.gp-verifie-badge{position:absolute;top:10px;right:10px;background:white;color:#1d4ed8;padding:3px 9px;border-radius:20px;font-size:10px;font-weight:700;z-index:2;border:1px solid #bfdbfe}
.gp-fav-btn{position:absolute;top:10px;right:10px;width:30px;height:30px;border-radius:50%;background:rgba(255,255,255,.92);border:none;cursor:pointer;font-size:15px;display:flex;align-items:center;justify-content:center;z-index:3;transition:transform .15s;box-shadow:0 2px 6px rgba(0,0,0,.12)}
.gp-fav-btn:hover{transform:scale(1.15)}
.gp-fav-btn.active{color:#ef4444}
.gp-card-body{padding:1.1rem 1.25rem;display:flex;flex-direction:column}
.gp-card-type-row{display:flex;align-items:center;justify-content:space-between;margin-bottom:6px}
.gp-card-type-pill{font-size:11px;font-weight:700;padding:2px 9px;border-radius:20px;color:white}
.gp-card-vues{font-size:11px;color:#94a3b8;display:flex;align-items:center;gap:3px}
.gp-card-price{font-size:18px;font-weight:800;color:#0a2540;margin-bottom:3px;line-height:1}
.gp-card-price small{font-size:12px;color:#94a3b8;font-weight:500}
.gp-card-title{font-size:14px;font-weight:600;color:#1e293b;margin-bottom:4px;line-height:1.4}
.gp-card-loc{font-size:12px;color:#94a3b8;margin-bottom:10px;display:flex;align-items:center;gap:4px}
.gp-card-chips{display:flex;gap:5px;flex-wrap:wrap;margin-bottom:12px}
.gp-chip{font-size:11px;background:#f8fafc;color:#64748b;padding:3px 9px;border-radius:6px;font-weight:600;border:1px solid #e8edf2;white-space:nowrap}
.gp-chip.green{background:#f0fdf4;color:#166534;border-color:#bbf7d0}
.gp-chip.blue{background:#eff6ff;color:#1d4ed8;border-color:#bfdbfe}
.gp-card-footer{margin-top:auto;padding-top:10px;border-top:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between}
.gp-card-agent{display:flex;align-items:center;gap:7px}
.gp-agent-avatar{width:26px;height:26px;border-radius:50%;background:#0a2540;color:white;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;flex-shrink:0;overflow:hidden}
.gp-agent-avatar img{width:100%;height:100%;object-fit:cover}
.gp-agent-name{font-size:12px;color:#64748b;font-weight:500}
.gp-card-surface{font-size:11px;color:#94a3b8;background:#f8fafc;padding:3px 9px;border-radius:6px;border:1px solid #e8edf2}
.gp-empty{text-align:center;padding:5rem 2rem;background:white;border:1px solid #e8edf2;border-radius:14px;color:#94a3b8}
.gp-pagination{margin-top:2rem;display:flex;justify-content:center}
.badge-location{background:#059669}.badge-vente_maison{background:#2563eb}.badge-vente_terrain{background:#d97706}.badge-commerce{background:#7c3aed}

/* SIDEBAR FILTRES (réutilise le même code qu'index) */
.gp-overlay{position:fixed;inset:0;background:rgba(10,37,64,.45);z-index:2000;opacity:0;pointer-events:none;transition:opacity .3s}
.gp-overlay.open{opacity:1;pointer-events:all}
.gp-sidebar{position:fixed;top:0;left:0;bottom:0;width:320px;background:white;z-index:2001;box-shadow:4px 0 32px rgba(0,0,0,.15);transform:translateX(-100%);transition:transform .35s cubic-bezier(.4,0,.2,1);display:flex;flex-direction:column;overflow:hidden}
.gp-sidebar.open{transform:translateX(0)}
.gp-sb-head{display:flex;align-items:center;justify-content:space-between;padding:1.25rem 1.5rem;border-bottom:1px solid #f1f5f9;flex-shrink:0}
.gp-sb-head h3{font-size:16px;font-weight:700;color:#0a2540}
.gp-sb-close{width:32px;height:32px;border-radius:8px;border:1px solid #e2e8f0;background:white;cursor:pointer;font-size:20px;display:flex;align-items:center;justify-content:center;color:#64748b;line-height:1}
.gp-sb-body{flex:1;overflow-y:auto;padding:1.25rem 1.5rem}
.gp-sb-group{margin-bottom:1.5rem}
.gp-sb-lbl{display:block;font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.8px;margin-bottom:8px}
.gp-sb-select,.gp-sb-input{width:100%;padding:10px 12px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:14px;color:#1e293b;outline:none;background:white;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif;cursor:pointer;transition:border-color .2s}
.gp-sb-select:focus,.gp-sb-input:focus{border-color:#2563eb}
.gp-sb-pills{display:flex;flex-wrap:wrap;gap:8px}
.gp-sb-pill-chk{display:none}
.gp-sb-pill-lbl{padding:7px 14px;border-radius:30px;border:1.5px solid #e2e8f0;background:white;font-size:13px;font-weight:600;color:#64748b;cursor:pointer;transition:all .15s;user-select:none}
.gp-sb-pill-chk:checked + .gp-sb-pill-lbl{background:#0a2540;color:white;border-color:#0a2540}
.gp-sb-divider{height:1px;background:#f1f5f9;margin:0.25rem 0 1.5rem}
.gp-sb-foot{padding:1rem 1.5rem;border-top:1px solid #f1f5f9;flex-shrink:0;display:flex;flex-direction:column;gap:8px}
.gp-sb-apply{width:100%;background:#0a2540;color:white;border:none;padding:13px;border-radius:10px;font-size:14px;font-weight:700;cursor:pointer;transition:background .2s;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif}
.gp-sb-apply:hover{background:#0f3460}
.gp-sb-reset{width:100%;background:white;color:#64748b;border:1.5px solid #e2e8f0;padding:11px;border-radius:10px;font-size:14px;font-weight:600;cursor:pointer;transition:all .15s;text-decoration:none;text-align:center;display:block;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif}
.gp-active-filters{display:flex;gap:8px;flex-wrap:wrap;align-items:center;margin-top:.75rem;margin-bottom:.75rem}
.gp-af-chip{display:inline-flex;align-items:center;gap:6px;padding:5px 12px;background:#f1f5f9;border-radius:30px;font-size:12px;font-weight:600;color:#475569}
.gp-af-chip a{color:#94a3b8;text-decoration:none;font-size:14px;line-height:1}

@media(max-width:960px){.gp-cards-grid{grid-template-columns:1fr}.gp-card{grid-template-columns:160px 1fr}}
@media(max-width:640px){.tp-hero h1{font-size:1.8rem}.tp-hero-content{padding:2.5rem 1.5rem}.tp-hero-search{flex-direction:column}.tp-hs-field{border-right:none;border-bottom:1px solid #e2e8f0}.tp-hero-btn{padding:12px;width:calc(100% - 8px);margin:4px;justify-content:center}.tp-stats{gap:2rem;padding:1rem 1.5rem}.tp-content{padding:1rem}.gp-card{grid-template-columns:1fr}.gp-card-img{min-height:200px}.gp-sidebar{width:100%}}
</style>

<!-- SIDEBAR FILTRES -->
<div class="gp-overlay" id="gpOverlay" onclick="gpCloseSidebar()"></div>
<div class="gp-sidebar" id="gpSidebar">
    <div class="gp-sb-head">
        <h3>Filtres avancés</h3>
        <button class="gp-sb-close" onclick="gpCloseSidebar()">×</button>
    </div>
    <div class="gp-sb-body">
        <form method="GET" action="{{ request()->url() }}" id="gpSidebarForm">
            <input type="hidden" name="type" value="{{ $typeActif }}">
            @if(request('ville'))<input type="hidden" name="ville" value="{{ request('ville') }}">@endif
            @if(request('prix_max'))<input type="hidden" name="prix_max" value="{{ request('prix_max') }}">@endif
            <div class="gp-sb-group">
                <span class="gp-sb-lbl">Nombre de chambres</span>
                <select name="nb_chambres" class="gp-sb-select">
                    <option value="">Toutes</option>
                    @foreach([1,2,3,4] as $n)<option value="{{ $n }}" {{ request('nb_chambres')==$n?'selected':'' }}>{{ $n }}+</option>@endforeach
                </select>
            </div>
            <div class="gp-sb-group">
                <span class="gp-sb-lbl">État du bien</span>
                <select name="etat_bien" class="gp-sb-select">
                    <option value="">Tous</option>
                    <option value="neuf" {{ request('etat_bien')==='neuf'?'selected':'' }}>Neuf</option>
                    <option value="bon_etat" {{ request('etat_bien')==='bon_etat'?'selected':'' }}>Bon état</option>
                    <option value="a_renover" {{ request('etat_bien')==='a_renover'?'selected':'' }}>À rénover</option>
                </select>
            </div>
            <div class="gp-sb-group">
                <span class="gp-sb-lbl">Superficie min (m²)</span>
                <input type="number" name="superficie_min" class="gp-sb-input" placeholder="Ex: 50" value="{{ request('superficie_min') }}" min="0">
            </div>
            <div class="gp-sb-divider"></div>
            <div class="gp-sb-group">
                <span class="gp-sb-lbl">Options</span>
                <div class="gp-sb-pills">
                    <input type="checkbox" name="meuble" value="1" id="sbM" class="gp-sb-pill-chk" {{ request('meuble')?'checked':'' }}>
                    <label for="sbM" class="gp-sb-pill-lbl">Meublé</label>
                    <input type="checkbox" name="parking" value="1" id="sbP" class="gp-sb-pill-chk" {{ request('parking')?'checked':'' }}>
                    <label for="sbP" class="gp-sb-pill-lbl">Parking</label>
                    <input type="checkbox" name="titre_foncier" value="1" id="sbT" class="gp-sb-pill-chk" {{ request('titre_foncier')?'checked':'' }}>
                    <label for="sbT" class="gp-sb-pill-lbl">Titre foncier</label>
                </div>
            </div>
            <button type="submit" class="gp-sb-apply">Appliquer</button>
            <a href="{{ request()->url() }}" class="gp-sb-reset">Réinitialiser</a>
        </form>
    </div>
</div>

<!-- ══ HERO ══════════════════════════════════════════════════════════════════ -->
@php
    $heroConfig = match($typeActif ?? 'location') {
        'location'     => ['img'=>'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=1600&q=80','color'=>'#059669','label'=>'Location','title'=>'Trouver un bien <em>à louer</em>','sub'=>'Appartements, maisons et studios à louer partout au Gabon.'],
        'vente_maison' => ['img'=>'https://images.unsplash.com/photo-1600047508788-786f3865b4c1?w=1600&q=80','color'=>'#2563eb','label'=>'Vente','title'=>'Trouver un bien <em>à acheter</em>','sub'=>'Maisons, villas et immeubles à vendre au Gabon.'],
        'commerce'     => ['img'=>'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=1600&q=80','color'=>'#7c3aed','label'=>'Commerce','title'=>'Trouver un <em>local commercial</em>','sub'=>'Bureaux, boutiques et entrepôts disponibles au Gabon.'],
        default        => ['img'=>'https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=1600&q=80','color'=>'#0a2540','label'=>'Annonces','title'=>'Annonces <em>immobilières</em>','sub'=>'Toutes les annonces immobilières au Gabon.']
    };
@endphp
<div class="tp-hero">
    <div class="tp-hero-bg" style="background-image:url('{{ $heroConfig['img'] }}')"></div>
    <div class="tp-hero-overlay"></div>
    <div class="tp-hero-content">
        <div class="tp-hero-pill" style="background:{{ $heroConfig['color'] }}20;border:1px solid {{ $heroConfig['color'] }}40;color:white">
            <span style="width:6px;height:6px;background:{{ $heroConfig['color'] }};border-radius:50%;flex-shrink:0"></span>
            {{ $heroConfig['label'] }}
        </div>
        <h1>{!! $heroConfig['title'] !!}</h1>
        <p>{{ $heroConfig['sub'] }}</p>
        <form method="GET" action="{{ request()->url() }}" class="tp-hero-search">
            <input type="hidden" name="type" value="{{ $typeActif }}">
            <div class="tp-hs-field">
                <span class="tp-hs-label">Ville</span>
                <select name="ville" class="tp-hs-select">
                    <option value="">Toutes</option>
                    @foreach(['Libreville','Port-Gentil','Franceville','Oyem','Moanda','Lambaréné','Tchibanga'] as $v)
                        <option value="{{ $v }}" {{ request('ville')===$v?'selected':'' }}>{{ $v }}</option>
                    @endforeach
                </select>
            </div>
            <div class="tp-hs-field">
                <span class="tp-hs-label">Prix max (FCFA)</span>
                <input type="number" name="prix_max" class="tp-hs-input" placeholder="Illimité" value="{{ request('prix_max') }}">
            </div>
            <button type="submit" class="tp-hero-btn">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                Rechercher
            </button>
        </form>
    </div>
</div>

<!-- STATS -->
<div class="tp-stats">
    <div class="tp-stat"><div class="tp-stat-n">{{ $annonces->total() }}</div><div class="tp-stat-l">Annonces {{ strtolower($heroConfig['label']) }}</div></div>
    <div class="tp-stat"><div class="tp-stat-n">7</div><div class="tp-stat-l">Villes</div></div>
    <div class="tp-stat"><div class="tp-stat-n">100%</div><div class="tp-stat-l">Vérifiées</div></div>
</div>

<!-- CONTENU -->
<div class="tp-content">

    @php
        $nbFiltres = collect([request('nb_chambres'),request('etat_bien'),request('meuble'),request('parking'),request('titre_foncier'),request('superficie_min')])->filter()->count();
    @endphp

    <div class="tp-bar">
        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap">
            <button class="tp-filter-btn" onclick="gpOpenSidebar()">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="6" x2="20" y2="6"/><line x1="8" y1="12" x2="16" y2="12"/><line x1="11" y1="18" x2="13" y2="18"/></svg>
                Filtres avancés
                @if($nbFiltres > 0)<span class="tp-filtres-badge">{{ $nbFiltres }}</span>@endif
            </button>
            <span class="tp-count">
                {{ $annonces->total() }} annonce(s)
                @if(request('ville')) à <strong style="color:#2563eb">{{ request('ville') }}</strong>@endif
            </span>
        </div>
        <div class="tp-bar-right">
            <form method="GET" action="{{ request()->url() }}" id="tpTriForm">
                @foreach(request()->except('tri') as $k=>$v)<input type="hidden" name="{{ $k }}" value="{{ $v }}">@endforeach
                <select name="tri" class="tp-tri" onchange="document.getElementById('tpTriForm').submit()">
                    <option value="" {{ !request('tri')?'selected':'' }}>Plus récent</option>
                    <option value="prix_asc" {{ request('tri')==='prix_asc'?'selected':'' }}>Prix croissant</option>
                    <option value="prix_desc" {{ request('tri')==='prix_desc'?'selected':'' }}>Prix décroissant</option>
                    <option value="plus_vus" {{ request('tri')==='plus_vus'?'selected':'' }}>Plus vus</option>
                </select>
            </form>
        </div>
    </div>

    <!-- CHIPS FILTRES ACTIFS -->
    @if($nbFiltres > 0)
        <div class="gp-active-filters">
            <span style="font-size:12px;color:#94a3b8;font-weight:600">Filtres :</span>
            @if(request('nb_chambres'))<span class="gp-af-chip">{{ request('nb_chambres') }}+ ch. <a href="{{ request()->fullUrlWithQuery(['nb_chambres'=>null]) }}">×</a></span>@endif
            @if(request('etat_bien'))<span class="gp-af-chip">{{ str_replace('_',' ',request('etat_bien')) }} <a href="{{ request()->fullUrlWithQuery(['etat_bien'=>null]) }}">×</a></span>@endif
            @if(request('meuble'))<span class="gp-af-chip">Meublé <a href="{{ request()->fullUrlWithQuery(['meuble'=>null]) }}">×</a></span>@endif
            @if(request('parking'))<span class="gp-af-chip">Parking <a href="{{ request()->fullUrlWithQuery(['parking'=>null]) }}">×</a></span>@endif
            @if(request('titre_foncier'))<span class="gp-af-chip">Titre foncier <a href="{{ request()->fullUrlWithQuery(['titre_foncier'=>null]) }}">×</a></span>@endif
            @if(request('superficie_min'))<span class="gp-af-chip">Min {{ request('superficie_min') }} m² <a href="{{ request()->fullUrlWithQuery(['superficie_min'=>null]) }}">×</a></span>@endif
            <a href="{{ request()->url() }}" style="font-size:12px;color:#94a3b8;font-weight:600;text-decoration:none">Tout effacer</a>
        </div>
    @endif

    @if($annonces->isEmpty())
        <div class="gp-empty">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" style="margin-bottom:1rem"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            <h3 style="font-size:16px;color:#64748b;font-weight:600;margin-bottom:8px">Aucune annonce trouvée</h3>
            <p style="font-size:13px;margin-bottom:1.5rem">Modifiez vos critères ou <a href="#" onclick="gpOpenSidebar();return false;" style="color:#2563eb;text-decoration:none;font-weight:600">ajustez les filtres</a></p>
        </div>
    @else
        <div class="gp-cards-grid">
            @foreach($annonces as $annonce)
            @php
                $typeLabel=match($annonce->type){'location'=>'Location','vente_maison'=>'Vente','vente_terrain'=>'Terrain','commerce'=>'Commerce',default=>$annonce->type};
                $photos=$annonce->photos??collect();
                $estFavori=Auth::check()?$annonce->estEnFavori(Auth::id()):false;
                $nomContact=$annonce->nom_affiche?:$annonce->user->name;
            @endphp
            <a href="{{ route('annonces.show',$annonce) }}" class="gp-card">
                <div class="gp-card-img">
                    @if($photos->isNotEmpty())
                        <div class="gp-carrousel-inner" id="gpCarr-{{ $annonce->id }}">
                            @foreach($photos as $p)<img src="{{ str_starts_with($p->url, 'http') ? $p->url : asset('storage/'.$p->url) }}" alt="{{ $annonce->titre }}">@endforeach
                        </div>
                        @if($photos->count() > 1)
                            <button onclick="event.preventDefault();gpSlide('{{ $annonce->id }}',-1)" class="gp-carr-btn gp-carr-prev">‹</button>
                            <button onclick="event.preventDefault();gpSlide('{{ $annonce->id }}',1)" class="gp-carr-btn gp-carr-next">›</button>
                            <div class="gp-carr-dots" id="gpDots-{{ $annonce->id }}">@foreach($photos as $p)<div class="gp-carr-dot {{ $loop->first?'active':'' }}"></div>@endforeach</div>
                        @endif
                    @else
                        <div class="gp-card-no-img"><svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="3"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg></div>
                    @endif
                    <span class="gp-type-badge badge-{{ $annonce->type }}">{{ $typeLabel }}</span>
                    @if($annonce->verifie)<span class="gp-verifie-badge">✓ Vérifié</span>
                    @else @auth
                        <button type="button" class="gp-fav-btn {{ $estFavori?'active':'' }}" onclick="event.preventDefault();gpToggleFav(this,{{ $annonce->id }})">{{ $estFavori?'♥':'♡' }}</button>
                    @endauth @endif
                </div>
                <div class="gp-card-body">
                    <div class="gp-card-type-row">
                        <span class="gp-card-type-pill badge-{{ $annonce->type }}">{{ $typeLabel }}</span>
                        <span class="gp-card-vues"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>{{ $annonce->vues??0 }}</span>
                    </div>
                    <div class="gp-card-price">
                        {{ number_format($annonce->prix,0,',',' ') }} FCFA
                        @if($annonce->type==='location')<small>/mois</small>@endif
                    </div>
                    <div class="gp-card-title">{{ $annonce->titre }}</div>
                    <div class="gp-card-loc"><svg width="11" height="11" viewBox="0 0 24 24" fill="#94a3b8"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>{{ $annonce->quartier }}, {{ $annonce->ville }}</div>
                    <div class="gp-card-chips">
                        @if($annonce->nb_chambres)<span class="gp-chip">{{ $annonce->nb_chambres }} ch.</span>@endif
                        @if($annonce->superficie)<span class="gp-chip">{{ $annonce->superficie }} m²</span>@endif
                        @if($annonce->meuble)<span class="gp-chip green">Meublé</span>@endif
                        @if($annonce->parking)<span class="gp-chip blue">Parking</span>@endif
                    </div>
                    <div class="gp-card-footer">
                        <div class="gp-card-agent">
                            <div class="gp-agent-avatar">
                                @if($annonce->user->avatar)
                                    <img src="{{ asset('storage/'.$annonce->user->avatar) }}" alt="">
                                @else
                                    {{ strtoupper(substr($nomContact,0,1)) }}
                                @endif
                            </div>
                            <span class="gp-agent-name">{{ Str::limit($nomContact,18) }}</span>
                        </div>
                        @if($annonce->superficie)<span class="gp-card-surface">{{ $annonce->superficie }} m²</span>@endif
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        <div class="gp-pagination">{{ $annonces->withQueryString()->links() }}</div>
    @endif
</div>

<script>
var gpPos={};
function gpSlide(id,dir){var c=document.getElementById('gpCarr-'+id);if(!c)return;var imgs=c.querySelectorAll('img'),total=imgs.length;if(!gpPos[id])gpPos[id]=0;gpPos[id]=(gpPos[id]+dir+total)%total;c.style.transform='translateX(-'+(gpPos[id]*100)+'%)';document.querySelectorAll('#gpDots-'+id+' .gp-carr-dot').forEach(function(d,i){d.classList.toggle('active',i===gpPos[id])});}
document.addEventListener('DOMContentLoaded',function(){document.querySelectorAll('.gp-carrousel-inner').forEach(function(c){var id=c.id.replace('gpCarr-','');if(c.querySelectorAll('img').length>1){setInterval(function(){gpSlide(id,1);},4500);}});});
function gpOpenSidebar(){document.getElementById('gpSidebar').classList.add('open');document.getElementById('gpOverlay').classList.add('open');document.body.style.overflow='hidden'}
function gpCloseSidebar(){document.getElementById('gpSidebar').classList.remove('open');document.getElementById('gpOverlay').classList.remove('open');document.body.style.overflow=''}
document.addEventListener('keydown',function(e){if(e.key==='Escape')gpCloseSidebar();});
function gpToggleFav(btn,id){
    @auth
    fetch('/favoris/'+id+'/toggle',{method:'POST',headers:{'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content,'Accept':'application/json'}})
    .then(function(r){return r.json();}).then(function(d){if(d.status==='added'){btn.innerHTML='♥';btn.classList.add('active');}else{btn.innerHTML='♡';btn.classList.remove('active');}});
    @else window.location.href='{{ route("login") }}';@endauth
}
</script>
@endsection