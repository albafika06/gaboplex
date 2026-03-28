@extends('layouts.app')
@section('title', 'Annonces immobilières au Gabon')
@section('content')
<style>
/* ══ HERO ════════════════════════════════════════════════════════════════════ */
.gp-hero{position:relative;min-height:480px;display:flex;align-items:flex-end;background:#042C53;overflow:hidden}
.gp-hero-bg{position:absolute;inset:0;background:linear-gradient(110deg,rgba(4,44,83,.96) 0%,rgba(4,44,83,.8) 45%,rgba(4,44,83,.35) 100%);z-index:1}
.gp-hero-img{position:absolute;inset:0;background-image:url('https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=1600&q=80');background-size:cover;background-position:center right;z-index:0}
.gp-hero-content{position:relative;z-index:2;padding:3rem 3rem 3.5rem;max-width:640px}
.gp-hero-pill{display:inline-flex;align-items:center;gap:5px;background:rgba(55,138,221,.15);border:0.5px solid rgba(55,138,221,.35);color:#85B7EB;padding:4px 12px;border-radius:20px;font-size:11px;font-weight:500;letter-spacing:.3px;margin-bottom:1rem}
.gp-hero-pill-dot{width:5px;height:5px;border-radius:50%;background:#378ADD;flex-shrink:0}
.gp-hero h1{font-size:2.5rem;font-weight:700;color:white;line-height:1.2;margin-bottom:.75rem;letter-spacing:-.5px}
.gp-hero h1 em{color:#85B7EB;font-style:normal}
.gp-hero p{font-size:14px;color:rgba(255,255,255,.55);line-height:1.7;margin-bottom:1.75rem}
.gp-type-tabs{display:flex;gap:3px;background:rgba(255,255,255,.08);border-radius:8px;padding:3px;width:fit-content;margin-bottom:1rem}
.gp-type-tab{padding:7px 18px;border-radius:6px;border:none;background:transparent;color:rgba(255,255,255,.5);font-size:12px;font-weight:500;cursor:pointer;transition:all .2s;white-space:nowrap;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif}
.gp-type-tab:hover{color:rgba(255,255,255,.8)}
.gp-type-tab.active{background:white;color:#042C53}
.gp-hero-search{background:white;border-radius:10px;padding:4px;display:flex;gap:0;align-items:stretch;max-width:580px;box-shadow:0 16px 48px rgba(0,0,0,.3)}
.gp-hs-field{flex:1;min-width:0;display:flex;flex-direction:column;padding:7px 12px;border-right:0.5px solid #e2e8f0}
.gp-hs-field:last-of-type{border-right:none}
.gp-hs-label{font-size:9px;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;margin-bottom:2px}
.gp-hs-select,.gp-hs-input{border:none;outline:none;background:transparent;font-size:13px;font-weight:500;color:#1e293b;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif;width:100%;padding:0}
.gp-hero-search-btn{background:#042C53;color:white;border:none;padding:0 22px;border-radius:7px;margin:2px;font-size:13px;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:6px;transition:background .2s;white-space:nowrap;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif;flex-shrink:0}
.gp-hero-search-btn:hover{background:#185FA5}

/* STATS */
.gp-stats-strip{display:flex;background:white;border-bottom:0.5px solid #e2e8f0}
.gp-stat{flex:1;padding:1.1rem;text-align:center;border-right:0.5px solid #e2e8f0}
.gp-stat:last-child{border-right:none}
.gp-stat-num{font-size:1.6rem;font-weight:700;color:#042C53;line-height:1}
.gp-stat-lbl{font-size:10px;color:#94a3b8;text-transform:uppercase;letter-spacing:1px;margin-top:3px;font-weight:500}

/* SIDEBAR */
.gp-overlay{position:fixed;inset:0;background:rgba(4,44,83,.4);z-index:2000;opacity:0;pointer-events:none;transition:opacity .3s}
.gp-overlay.open{opacity:1;pointer-events:all}
.gp-sidebar{position:fixed;top:0;left:0;bottom:0;width:300px;background:white;z-index:2001;box-shadow:4px 0 24px rgba(0,0,0,.12);transform:translateX(-100%);transition:transform .3s cubic-bezier(.4,0,.2,1);display:flex;flex-direction:column;overflow:hidden}
.gp-sidebar.open{transform:translateX(0)}
.gp-sb-head{display:flex;align-items:center;justify-content:space-between;padding:1.1rem 1.25rem;border-bottom:0.5px solid #f1f5f9;flex-shrink:0}
.gp-sb-head h3{font-size:15px;font-weight:600;color:#042C53}
.gp-sb-close{width:30px;height:30px;border-radius:6px;border:0.5px solid #e2e8f0;background:white;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#64748b;font-size:18px;transition:all .15s;line-height:1}
.gp-sb-close:hover{background:#f8fafc;color:#042C53}
.gp-sb-body{flex:1;overflow-y:auto;padding:1.1rem 1.25rem}
.gp-sb-group{margin-bottom:1.25rem}
.gp-sb-lbl{display:block;font-size:10px;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.6px;margin-bottom:7px}
.gp-sb-select,.gp-sb-input{width:100%;padding:9px 11px;border:0.5px solid #e2e8f0;border-radius:8px;font-size:13px;color:#1e293b;outline:none;background:white;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif;cursor:pointer;transition:border-color .2s}
.gp-sb-select:focus,.gp-sb-input:focus{border-color:#185FA5}
.gp-sb-pills{display:flex;flex-wrap:wrap;gap:6px}
.gp-sb-pill-chk{display:none}
.gp-sb-pill-lbl{padding:6px 12px;border-radius:20px;border:0.5px solid #e2e8f0;background:white;font-size:12px;font-weight:500;color:#64748b;cursor:pointer;transition:all .15s;user-select:none}
.gp-sb-pill-chk:checked+.gp-sb-pill-lbl{background:#042C53;color:white;border-color:#042C53}
.gp-sb-pill-lbl:hover{border-color:#042C53;color:#042C53}
.gp-sb-divider{height:0.5px;background:#f1f5f9;margin:0 0 1.25rem}
.gp-sb-foot{padding:.9rem 1.25rem;border-top:0.5px solid #f1f5f9;flex-shrink:0;display:flex;flex-direction:column;gap:6px}
.gp-sb-apply{width:100%;background:#042C53;color:white;border:none;padding:11px;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;transition:background .2s;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif}
.gp-sb-apply:hover{background:#185FA5}
.gp-sb-reset{width:100%;background:white;color:#64748b;border:0.5px solid #e2e8f0;padding:9px;border-radius:8px;font-size:13px;font-weight:500;cursor:pointer;text-decoration:none;text-align:center;display:block;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif;transition:all .15s}
.gp-sb-reset:hover{border-color:#94a3b8;color:#042C53}

/* BARRE RÉSULTATS */
.gp-results-bar{max-width:1200px;margin:1.5rem auto 0;padding:0 1.5rem;display:flex;align-items:center;justify-content:space-between;gap:10px;flex-wrap:wrap}
.gp-results-left{display:flex;align-items:center;gap:8px}
.gp-btn-filtres{display:inline-flex;align-items:center;gap:7px;padding:7px 14px;border-radius:8px;border:0.5px solid #e2e8f0;background:white;font-size:13px;font-weight:500;color:#042C53;cursor:pointer;transition:all .2s;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif}
.gp-btn-filtres:hover{border-color:#042C53;background:#f8fafc}
.gp-filtres-badge{background:#042C53;color:white;width:18px;height:18px;border-radius:50%;font-size:10px;font-weight:600;display:inline-flex;align-items:center;justify-content:center}
.gp-results-count{font-size:14px;font-weight:600;color:#042C53}
.gp-results-right{display:flex;align-items:center;gap:8px}
.gp-tri-select{padding:7px 11px;border:0.5px solid #e2e8f0;border-radius:8px;font-size:13px;color:#1e293b;outline:none;background:white;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif;cursor:pointer}
.gp-vue-toggle{display:flex;border:0.5px solid #e2e8f0;border-radius:8px;overflow:hidden}
.gp-vue-btn{padding:6px 12px;font-size:12px;font-weight:500;cursor:pointer;border:none;background:white;color:#64748b;transition:all .15s;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif;display:flex;align-items:center;gap:4px}
.gp-vue-btn.active{background:#042C53;color:white}

/* CHIPS FILTRES ACTIFS */
.gp-active-filters{max-width:1200px;margin:.5rem auto 0;padding:0 1.5rem;display:flex;gap:6px;flex-wrap:wrap;align-items:center}
.gp-af-chip{display:inline-flex;align-items:center;gap:5px;padding:4px 10px;background:#f1f5f9;border-radius:20px;font-size:12px;font-weight:500;color:#475569}
.gp-af-chip a{color:#94a3b8;text-decoration:none;font-size:13px;line-height:1}
.gp-af-chip a:hover{color:#042C53}

/* GRILLE CARDS */
.gp-listings{max-width:1200px;margin:1.25rem auto 3rem;padding:0 1.5rem}
.gp-cards-grid{display:grid;grid-template-columns:1fr 1fr;gap:1rem}
.gp-card{background:white;border-radius:12px;overflow:hidden;border:0.5px solid #e8edf2;text-decoration:none;color:inherit;display:grid;grid-template-columns:200px 1fr;transition:box-shadow .2s,transform .2s;position:relative}
.gp-card:hover{box-shadow:0 4px 20px rgba(0,0,0,.07);transform:translateY(-1px)}
.gp-card-img{position:relative;overflow:hidden;background:#f1f5f9;min-height:170px}
.gp-card-img img{width:100%;height:100%;object-fit:cover;display:block}
.gp-card-no-img{width:100%;height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;color:#cbd5e1;font-size:12px;gap:6px;padding:1rem;min-height:170px}
.gp-carrousel-inner{display:flex;height:100%;transition:transform .4s ease}
.gp-carrousel-inner img{min-width:100%;height:100%;object-fit:cover;flex-shrink:0}
.gp-carr-btn{position:absolute;top:50%;transform:translateY(-50%);background:rgba(0,0,0,.4);color:white;border:none;border-radius:50%;width:24px;height:24px;cursor:pointer;font-size:13px;display:flex;align-items:center;justify-content:center;z-index:3;transition:background .15s}
.gp-carr-btn:hover{background:rgba(0,0,0,.6)}
.gp-carr-prev{left:6px}.gp-carr-next{right:6px}
.gp-carr-dots{position:absolute;bottom:5px;left:50%;transform:translateX(-50%);display:flex;gap:3px;z-index:3}
.gp-carr-dot{width:4px;height:4px;border-radius:50%;background:rgba(255,255,255,.5);transition:background .2s}
.gp-carr-dot.active{background:white}
.gp-type-badge{position:absolute;top:8px;left:8px;padding:2px 8px;border-radius:20px;font-size:10px;font-weight:600;color:white;z-index:2}
.gp-verifie-badge{position:absolute;top:8px;right:8px;background:white;color:#185FA5;padding:2px 8px;border-radius:20px;font-size:10px;font-weight:600;z-index:2;border:0.5px solid #B5D4F4}
.gp-fav-btn{position:absolute;top:8px;right:8px;width:28px;height:28px;border-radius:50%;background:rgba(255,255,255,.9);border:none;cursor:pointer;font-size:14px;display:flex;align-items:center;justify-content:center;z-index:3;transition:transform .15s;box-shadow:0 1px 4px rgba(0,0,0,.1)}
.gp-fav-btn:hover{transform:scale(1.1)}
.gp-fav-btn.active{color:#e11d48}
.gp-card-body{padding:1rem 1.1rem;display:flex;flex-direction:column}
.gp-card-type-row{display:flex;align-items:center;justify-content:space-between;margin-bottom:5px}
.gp-card-type-pill{font-size:10px;font-weight:600;padding:2px 8px;border-radius:20px;color:white}
.gp-card-vues{font-size:11px;color:#94a3b8;display:flex;align-items:center;gap:2px}
.gp-card-price{font-size:17px;font-weight:700;color:#042C53;margin-bottom:2px;line-height:1}
.gp-card-price small{font-size:11px;color:#94a3b8;font-weight:400}
.gp-card-title{font-size:13px;font-weight:600;color:#1e293b;margin-bottom:3px;line-height:1.4}
.gp-card-loc{font-size:11px;color:#94a3b8;margin-bottom:8px;display:flex;align-items:center;gap:3px}
.gp-card-chips{display:flex;gap:4px;flex-wrap:wrap;margin-bottom:10px}
.gp-chip{font-size:10px;background:#f8fafc;color:#64748b;padding:2px 7px;border-radius:4px;font-weight:500;border:0.5px solid #e8edf2;white-space:nowrap}
.gp-chip.green{background:#EAF3DE;color:#27500A;border-color:#C0DD97}
.gp-chip.blue{background:#E6F1FB;color:#185FA5;border-color:#B5D4F4}
.gp-card-footer{margin-top:auto;padding-top:8px;border-top:0.5px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between}
.gp-card-agent{display:flex;align-items:center;gap:6px}
.gp-agent-avatar{width:22px;height:22px;border-radius:50%;background:#042C53;color:white;display:flex;align-items:center;justify-content:center;font-size:9px;font-weight:600;flex-shrink:0;overflow:hidden}
.gp-agent-avatar img{width:100%;height:100%;object-fit:cover}
.gp-agent-name{font-size:11px;color:#64748b;font-weight:400}
.gp-card-surface{font-size:10px;color:#94a3b8;background:#f8fafc;padding:2px 7px;border-radius:4px;border:0.5px solid #e8edf2}
.gp-empty{text-align:center;padding:4rem 2rem;color:#94a3b8}
.gp-empty h3{font-size:15px;color:#64748b;margin-bottom:8px;font-weight:600}
.gp-pagination{margin-top:2rem;display:flex;justify-content:center}
#gp-vue-carte{display:none}
#gp-carte-principale{height:560px;border-radius:12px;overflow:hidden;border:0.5px solid #e8edf2}

@media(max-width:960px){.gp-cards-grid{grid-template-columns:1fr}.gp-card{grid-template-columns:150px 1fr}}
@media(max-width:640px){
    .gp-hero h1{font-size:1.75rem}.gp-hero-content{padding:2.5rem 1.5rem}
    .gp-hero-search{flex-direction:column}.gp-hs-field{border-right:none;border-bottom:0.5px solid #e2e8f0}
    .gp-hs-field:last-of-type{border-bottom:none}
    .gp-hero-search-btn{padding:12px;border-radius:6px;margin:3px;justify-content:center}
    .gp-stats-strip{flex-wrap:wrap}
    .gp-stat{min-width:50%}
    .gp-listings,.gp-results-bar,.gp-active-filters{padding:0 1rem}
    .gp-card{grid-template-columns:1fr}.gp-card-img{min-height:180px}
    .gp-sidebar{width:100%}
}
</style>

<div class="gp-overlay" id="gpOverlay" onclick="gpCloseSidebar()"></div>
<div class="gp-sidebar" id="gpSidebar">
    <div class="gp-sb-head">
        <h3>Filtres avancés</h3>
        <button class="gp-sb-close" onclick="gpCloseSidebar()">×</button>
    </div>
    <div class="gp-sb-body">
        <form method="GET" action="{{ route('annonces.index') }}" id="gpSidebarForm">
            @if(request('type'))<input type="hidden" name="type" value="{{ request('type') }}">@endif
            @if(request('ville'))<input type="hidden" name="ville" value="{{ request('ville') }}">@endif
            @if(request('prix_max'))<input type="hidden" name="prix_max" value="{{ request('prix_max') }}">@endif
            <div class="gp-sb-group">
                <span class="gp-sb-lbl">Chambres</span>
                <select name="nb_chambres" class="gp-sb-select">
                    <option value="">Toutes</option>
                    <option value="1" {{ request('nb_chambres')=='1'?'selected':'' }}>1 et +</option>
                    <option value="2" {{ request('nb_chambres')=='2'?'selected':'' }}>2 et +</option>
                    <option value="3" {{ request('nb_chambres')=='3'?'selected':'' }}>3 et +</option>
                    <option value="4" {{ request('nb_chambres')=='4'?'selected':'' }}>4 et +</option>
                </select>
            </div>
            <div class="gp-sb-group">
                <span class="gp-sb-lbl">État du bien</span>
                <select name="etat_bien" class="gp-sb-select">
                    <option value="">Tous</option>
                    <option value="neuf" {{ request('etat_bien')=='neuf'?'selected':'' }}>Neuf</option>
                    <option value="bon_etat" {{ request('etat_bien')=='bon_etat'?'selected':'' }}>Bon état</option>
                    <option value="a_renover" {{ request('etat_bien')=='a_renover'?'selected':'' }}>À rénover</option>
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
                    <input type="checkbox" name="prix_negotiable" value="1" id="sbN" class="gp-sb-pill-chk" {{ request('prix_negotiable')?'checked':'' }}>
                    <label for="sbN" class="gp-sb-pill-lbl">Prix négociable</label>
                </div>
            </div>
            <div class="gp-sb-foot" style="padding:0;border:none;margin-top:.5rem">
                <button type="submit" class="gp-sb-apply">Appliquer</button>
                <a href="{{ route('annonces.index') }}" class="gp-sb-reset">Tout réinitialiser</a>
            </div>
        </form>
    </div>
</div>

<div class="gp-hero">
    <div class="gp-hero-img"></div>
    <div class="gp-hero-bg"></div>
    <div class="gp-hero-content">
        <div class="gp-hero-pill"><div class="gp-hero-pill-dot"></div>N°1 immobilier gabonais</div>
        <h1>Trouvez votre bien<br>immobilier au <em>Gabon</em></h1>
        <p>Location, vente et commerces à Libreville, Port-Gentil et partout au Gabon.</p>
        <div class="gp-type-tabs" id="gpTypeTabs">
            <button class="gp-type-tab {{ !request('type')||request('type')==='location'?'active':'' }}" onclick="gpSetType('location',this)">Louer</button>
            <button class="gp-type-tab {{ in_array(request('type'),['vente_maison','vente_terrain'])?'active':'' }}" onclick="gpSetType('vente_maison',this)">Acheter</button>
            <button class="gp-type-tab {{ request('type')==='commerce'?'active':'' }}" onclick="gpSetType('commerce',this)">Commerce</button>
        </div>
        <form method="GET" action="{{ route('annonces.index') }}" class="gp-hero-search">
            <input type="hidden" name="type" id="gpTypeInput" value="{{ request('type','location') }}">
            <div class="gp-hs-field">
                <span class="gp-hs-label">Ville</span>
                <select name="ville" class="gp-hs-select">
                    <option value="">Toutes</option>
                    @foreach(['Libreville','Port-Gentil','Franceville','Oyem','Moanda','Lambaréné','Tchibanga'] as $v)
                        <option value="{{ $v }}" {{ request('ville')==$v?'selected':'' }}>{{ $v }}</option>
                    @endforeach
                </select>
            </div>
            <div class="gp-hs-field">
                <span class="gp-hs-label">Prix max (FCFA)</span>
                <input type="number" name="prix_max" class="gp-hs-input" placeholder="Illimité" value="{{ request('prix_max') }}">
            </div>
            <button type="submit" class="gp-hero-search-btn">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                Rechercher
            </button>
        </form>
    </div>
</div>

<div class="gp-stats-strip">
    <div class="gp-stat"><div class="gp-stat-num">{{ $annonces->total() }}</div><div class="gp-stat-lbl">Annonces actives</div></div>
    <div class="gp-stat"><div class="gp-stat-num">7</div><div class="gp-stat-lbl">Villes</div></div>
    <div class="gp-stat"><div class="gp-stat-num">{{ \App\Models\User::count() }}+</div><div class="gp-stat-lbl">Utilisateurs</div></div>
    <div class="gp-stat"><div class="gp-stat-num">100%</div><div class="gp-stat-lbl">Gabonais</div></div>
</div>

@php
    $nbFiltres = collect([request('nb_chambres'),request('etat_bien'),request('meuble'),request('parking'),request('titre_foncier'),request('prix_negotiable'),request('superficie_min')])->filter()->count();
@endphp

<div class="gp-results-bar">
    <div class="gp-results-left">
        <button class="gp-btn-filtres" onclick="gpOpenSidebar()">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="6" x2="20" y2="6"/><line x1="8" y1="12" x2="16" y2="12"/><line x1="11" y1="18" x2="13" y2="18"/></svg>
            Filtres avancés
            @if($nbFiltres > 0)<span class="gp-filtres-badge">{{ $nbFiltres }}</span>@endif
        </button>
        <span class="gp-results-count">
            {{ $annonces->total() }} annonce(s)
            @if(request('ville'))<span style="color:#185FA5"> à {{ request('ville') }}</span>@endif
        </span>
    </div>
    <div class="gp-results-right">
        <form method="GET" action="{{ route('annonces.index') }}" id="formTri">
            @foreach(request()->except('tri') as $k=>$v)<input type="hidden" name="{{ $k }}" value="{{ $v }}">@endforeach
            <select name="tri" class="gp-tri-select" onchange="document.getElementById('formTri').submit()">
                <option value="" {{ !request('tri')?'selected':'' }}>Plus récent</option>
                <option value="prix_asc" {{ request('tri')=='prix_asc'?'selected':'' }}>Prix croissant</option>
                <option value="prix_desc" {{ request('tri')=='prix_desc'?'selected':'' }}>Prix décroissant</option>
                <option value="plus_vus" {{ request('tri')=='plus_vus'?'selected':'' }}>Plus vus</option>
            </select>
        </form>
        <div class="gp-vue-toggle">
            <button type="button" class="gp-vue-btn active" id="gpBtnGrille" onclick="gpSetVue('grille')">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                Grille
            </button>
            <button type="button" class="gp-vue-btn" id="gpBtnCarte" onclick="gpSetVue('carte')">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7M9 20l6-3M9 20V7M15 17l5.447 2.724A1 1 0 0021 18.882V8.118a1 1 0 00-.553-.894L15 5"/></svg>
                Carte
            </button>
        </div>
    </div>
</div>

@if($nbFiltres > 0)
<div class="gp-active-filters">
    <span style="font-size:11px;color:#94a3b8;font-weight:500">Filtres :</span>
    @if(request('nb_chambres'))<span class="gp-af-chip">{{ request('nb_chambres') }}+ ch. <a href="{{ route('annonces.index',request()->except('nb_chambres')) }}">×</a></span>@endif
    @if(request('etat_bien'))<span class="gp-af-chip">{{ str_replace('_',' ',request('etat_bien')) }} <a href="{{ route('annonces.index',request()->except('etat_bien')) }}">×</a></span>@endif
    @if(request('meuble'))<span class="gp-af-chip">Meublé <a href="{{ route('annonces.index',request()->except('meuble')) }}">×</a></span>@endif
    @if(request('parking'))<span class="gp-af-chip">Parking <a href="{{ route('annonces.index',request()->except('parking')) }}">×</a></span>@endif
    @if(request('titre_foncier'))<span class="gp-af-chip">Titre foncier <a href="{{ route('annonces.index',request()->except('titre_foncier')) }}">×</a></span>@endif
    @if(request('prix_negotiable'))<span class="gp-af-chip">Négociable <a href="{{ route('annonces.index',request()->except('prix_negotiable')) }}">×</a></span>@endif
    @if(request('superficie_min'))<span class="gp-af-chip">Min {{ request('superficie_min') }}m² <a href="{{ route('annonces.index',request()->except('superficie_min')) }}">×</a></span>@endif
    <a href="{{ route('annonces.index') }}" style="font-size:11px;color:#94a3b8;font-weight:500;text-decoration:none;margin-left:2px">Tout effacer</a>
</div>
@endif

<div class="gp-listings">
    @if($annonces->isEmpty())
        <div class="gp-empty">
            <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" style="margin-bottom:1rem"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            <h3>Aucune annonce trouvée</h3>
            <p style="font-size:13px;margin-bottom:1.5rem">Modifiez vos critères ou <a href="#" onclick="gpOpenSidebar();return false;" style="color:#185FA5;text-decoration:none;font-weight:500">ajustez les filtres</a></p>
        </div>
    @else
        <div id="gpVueGrille">
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
                            @if($photos->count()>1)
                                <button onclick="event.preventDefault();gpSlide('{{ $annonce->id }}',-1)" class="gp-carr-btn gp-carr-prev">‹</button>
                                <button onclick="event.preventDefault();gpSlide('{{ $annonce->id }}',1)" class="gp-carr-btn gp-carr-next">›</button>
                                <div class="gp-carr-dots" id="gpDots-{{ $annonce->id }}">
                                    @foreach($photos as $p)<div class="gp-carr-dot {{ $loop->first?'active':'' }}"></div>@endforeach
                                </div>
                            @endif
                        @else
                            <div class="gp-card-no-img"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="3"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg></div>
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
                            <span class="gp-card-vues"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>{{ $annonce->vues??0 }}</span>
                        </div>
                        <div class="gp-card-price">
                            {{ number_format($annonce->prix,0,',',' ') }} FCFA
                            @if($annonce->type=='location')<small>/mois</small>@endif
                        </div>
                        <div class="gp-card-title">{{ $annonce->titre }}</div>
                        <div class="gp-card-loc"><svg width="10" height="10" viewBox="0 0 24 24" fill="#94a3b8"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>{{ $annonce->quartier }}, {{ $annonce->ville }}</div>
                        <div class="gp-card-chips">
                            @if($annonce->nb_chambres)<span class="gp-chip">{{ $annonce->nb_chambres }} ch.</span>@endif
                            @if($annonce->superficie)<span class="gp-chip">{{ $annonce->superficie }} m²</span>@endif
                            @if($annonce->meuble)<span class="gp-chip green">Meublé</span>@endif
                            @if($annonce->parking)<span class="gp-chip blue">Parking</span>@endif
                            @if($annonce->prix_negotiable)<span class="gp-chip">Négociable</span>@endif
                        </div>
                        <div class="gp-card-footer">
                            <div class="gp-card-agent">
                                <div class="gp-agent-avatar">@if($annonce->user->avatar)<img src="{{ asset('storage/'.$annonce->user->avatar) }}" alt="">@else{{ strtoupper(substr($nomContact,0,1)) }}@endif</div>
                                <span class="gp-agent-name">{{ Str::limit($nomContact,16) }}</span>
                            </div>
                            @if($annonce->superficie)<span class="gp-card-surface">{{ $annonce->superficie }} m²</span>@endif
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            <div class="gp-pagination">{{ $annonces->withQueryString()->links() }}</div>
        </div>
        <div id="gp-vue-carte"><div id="gp-carte-principale"></div></div>
    @endif
</div>

<script>
function gpOpenSidebar(){document.getElementById('gpSidebar').classList.add('open');document.getElementById('gpOverlay').classList.add('open');document.body.style.overflow='hidden'}
function gpCloseSidebar(){document.getElementById('gpSidebar').classList.remove('open');document.getElementById('gpOverlay').classList.remove('open');document.body.style.overflow=''}
document.addEventListener('keydown',function(e){if(e.key==='Escape')gpCloseSidebar()});
function gpSetType(type,btn){document.getElementById('gpTypeInput').value=type;document.querySelectorAll('.gp-type-tab').forEach(function(b){b.classList.remove('active')});btn.classList.add('active')}
var gpPos={};
function gpSlide(id,dir){var c=document.getElementById('gpCarr-'+id);if(!c)return;var imgs=c.querySelectorAll('img'),total=imgs.length;if(!gpPos[id])gpPos[id]=0;gpPos[id]=(gpPos[id]+dir+total)%total;c.style.transform='translateX(-'+(gpPos[id]*100)+'%)';document.querySelectorAll('#gpDots-'+id+' .gp-carr-dot').forEach(function(d,i){d.classList.toggle('active',i===gpPos[id])})}
document.addEventListener('DOMContentLoaded',function(){document.querySelectorAll('.gp-carrousel-inner').forEach(function(c){var id=c.id.replace('gpCarr-','');if(c.querySelectorAll('img').length>1){setInterval(function(){gpSlide(id,1)},4500)}})});
var gpCarteInit=false;
function gpSetVue(vue){document.getElementById('gpVueGrille').style.display=vue==='grille'?'block':'none';document.getElementById('gp-vue-carte').style.display=vue==='carte'?'block':'none';document.getElementById('gpBtnGrille').classList.toggle('active',vue==='grille');document.getElementById('gpBtnCarte').classList.toggle('active',vue==='carte');if(vue==='carte'&&!gpCarteInit){gpInitCarte();gpCarteInit=true}}
function gpInitCarte(){var data={!! $annoncesCarteJson !!};var carte=L.map('gp-carte-principale').setView([0.4162,9.4673],12);L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{attribution:'© OpenStreetMap'}).addTo(carte);data.forEach(function(a){if(!a.lat||!a.lng)return;var c=a.type==='location'?'#1D9E75':a.type==='commerce'?'#534AB7':'#185FA5';var ico=L.divIcon({html:'<div style="background:'+c+';color:white;padding:3px 7px;border-radius:5px;font-size:10px;font-weight:600;white-space:nowrap;box-shadow:0 1px 6px rgba(0,0,0,.2);">'+new Intl.NumberFormat('fr').format(a.prix)+' FCFA</div>',iconSize:[85,22],iconAnchor:[42,11],className:''});L.marker([a.lat,a.lng],{icon:ico}).addTo(carte).bindPopup('<div style="font-family:sans-serif;min-width:160px;">'+(a.photo?'<img src="'+a.photo+'" style="width:100%;height:80px;object-fit:cover;border-radius:5px;margin-bottom:7px;">':'')+'<strong style="color:#042C53;font-size:12px;">'+a.titre+'</strong><br><span style="color:#185FA5;font-weight:600;">'+new Intl.NumberFormat('fr').format(a.prix)+' FCFA</span><br><small style="color:#94a3b8;">📍 '+a.quartier+', '+a.ville+'</small><br><a href="'+a.url+'" style="display:block;margin-top:6px;background:#042C53;color:white;padding:5px 10px;border-radius:5px;text-decoration:none;font-size:11px;font-weight:600;text-align:center;">Voir l\'annonce</a></div>')})}
function gpToggleFav(btn,id){@auth fetch('/favoris/'+id+'/toggle',{method:'POST',headers:{'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content,'Accept':'application/json'}}).then(function(r){return r.json()}).then(function(d){if(d.status==='added'){btn.innerHTML='♥';btn.classList.add('active')}else{btn.innerHTML='♡';btn.classList.remove('active')}});@else window.location.href='{{ route("login") }}';@endauth}
</script>
@endsection