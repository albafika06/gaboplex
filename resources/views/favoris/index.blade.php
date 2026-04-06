@extends('layouts.app')
@section('title', 'Mes favoris')
@section('content')
<style>
.fv-wrap{max-width:1100px;margin:0 auto;padding:2rem 1.5rem}
.fv-header{margin-bottom:2rem}
.fv-header h1{font-size:22px;font-weight:800;color:#0a2540;letter-spacing:-.5px}
.fv-header p{font-size:14px;color:#94a3b8;margin-top:3px}
.fv-tabs{display:flex;border-bottom:1px solid #e8edf2;margin-bottom:2rem;gap:0}
.fv-tab{padding:10px 24px;font-size:14px;font-weight:600;color:#94a3b8;border:none;background:transparent;cursor:pointer;border-bottom:2px solid transparent;margin-bottom:-1px;transition:all .15s;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif;display:flex;align-items:center;gap:7px}
.fv-tab:hover{color:#0a2540}
.fv-tab.active{color:#0a2540;border-bottom-color:#0a2540}
.fv-tab-badge{padding:2px 8px;border-radius:20px;font-size:11px;font-weight:700;background:#f1f5f9;color:#64748b}
.fv-tab.active .fv-tab-badge{background:#0a2540;color:white}

/* ── LISTE FAVORIS ── */
.fv-list{display:flex;flex-direction:column;gap:12px}
.fv-card{display:flex;gap:0;background:white;border:1px solid #e8edf2;border-radius:14px;overflow:hidden;transition:box-shadow .2s}
.fv-card:hover{box-shadow:0 4px 20px rgba(0,0,0,.07)}
.fv-card-img{width:200px;flex-shrink:0;position:relative;overflow:hidden;background:#f1f5f9;display:flex;align-items:center;justify-content:center}
.fv-card-img img{width:100%;height:100%;object-fit:cover}
.fv-no-img{display:flex;flex-direction:column;align-items:center;justify-content:center;height:100%;color:#cbd5e1;font-size:12px;gap:6px;width:200px}
.fv-type-pill{position:absolute;top:10px;left:10px;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;color:white}
.fv-card-body{flex:1;padding:1.25rem;display:flex;flex-direction:column}
.fv-card-top{display:flex;align-items:flex-start;justify-content:space-between;gap:10px;margin-bottom:4px}
.fv-price{font-size:18px;font-weight:800;color:#0a2540;line-height:1}
.fv-price small{font-size:12px;color:#94a3b8;font-weight:500}
.fv-title{font-size:15px;font-weight:700;color:#1e293b;margin-bottom:4px}
.fv-loc{font-size:12px;color:#94a3b8;margin-bottom:10px;display:flex;align-items:center;gap:4px}
.fv-chips{display:flex;gap:6px;flex-wrap:wrap;margin-bottom:12px}
.fv-chip{padding:3px 9px;border-radius:6px;font-size:11px;font-weight:600;background:#f8fafc;color:#64748b;border:1px solid #e8edf2}
.fv-chip.green{background:#f0fdf4;color:#166534;border-color:#bbf7d0}
.fv-chip.blue{background:#eff6ff;color:#1d4ed8;border-color:#bfdbfe}
.fv-card-footer{margin-top:auto;display:flex;align-items:center;gap:8px}
.fv-btn-voir{padding:8px 16px;border-radius:8px;background:#0a2540;color:white;font-size:13px;font-weight:700;text-decoration:none;transition:background .2s}
.fv-btn-voir:hover{background:#0f3460;color:white}
.fv-btn-del{padding:8px 14px;border-radius:8px;background:white;color:#dc2626;border:1.5px solid #fecaca;font-size:13px;font-weight:600;cursor:pointer;transition:all .15s;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif}
.fv-btn-del:hover{background:#fef2f2}
.fv-save-date{font-size:11px;color:#94a3b8;margin-left:auto}

/* ── ALERTES ── */
.fv-alertes{display:flex;flex-direction:column;gap:12px}
.fv-alerte-card{display:flex;align-items:center;gap:1rem;background:white;border:1px solid #e8edf2;border-radius:14px;padding:1.25rem;transition:box-shadow .2s}
.fv-alerte-card:hover{box-shadow:0 4px 16px rgba(0,0,0,.06)}
.fv-alerte-icon{width:44px;height:44px;border-radius:50%;background:#eff6ff;border:1px solid #bfdbfe;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.fv-alerte-body{flex:1}
.fv-alerte-title{font-size:14px;font-weight:700;color:#0a2540;margin-bottom:3px;display:flex;align-items:center;gap:8px}
.fv-alerte-new{background:#eff6ff;color:#1d4ed8;padding:2px 8px;border-radius:20px;font-size:11px;font-weight:700}
.fv-alerte-sub{font-size:12px;color:#64748b}
.fv-btn-alerte-del{padding:7px 14px;border-radius:8px;background:white;color:#64748b;border:1.5px solid #e2e8f0;font-size:12px;font-weight:600;cursor:pointer;transition:all .15s;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif;flex-shrink:0}
.fv-btn-alerte-del:hover{border-color:#94a3b8;color:#0a2540}
.fv-alerte-new-btn{display:inline-flex;align-items:center;gap:7px;padding:10px 20px;border-radius:10px;background:#0a2540;color:white;font-size:13px;font-weight:700;border:none;cursor:pointer;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif;margin-bottom:1.5rem;transition:background .2s}
.fv-alerte-new-btn:hover{background:#0f3460}

/* MODAL NOUVELLE ALERTE */
.fv-overlay{position:fixed;inset:0;background:rgba(10,37,64,.45);z-index:2000;opacity:0;pointer-events:none;transition:opacity .3s}
.fv-overlay.open{opacity:1;pointer-events:all}
.fv-modal{position:fixed;top:50%;left:50%;transform:translate(-50%,-50%) scale(.95);background:white;border-radius:20px;width:480px;max-width:95vw;z-index:2001;opacity:0;pointer-events:none;transition:all .3s;padding:1.75rem}
.fv-modal.open{opacity:1;pointer-events:all;transform:translate(-50%,-50%) scale(1)}
.fv-modal-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem}
.fv-modal-head h3{font-size:18px;font-weight:700;color:#0a2540}
.fv-modal-close{width:32px;height:32px;border-radius:8px;border:1px solid #e2e8f0;background:white;cursor:pointer;font-size:20px;display:flex;align-items:center;justify-content:center;color:#64748b;line-height:1}
.fv-modal-close:hover{background:#f8fafc;color:#0a2540}
.fv-m-field{margin-bottom:14px}
.fv-m-label{display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px}
.fv-m-input,.fv-m-select{width:100%;padding:11px 14px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:14px;color:#1e293b;outline:none;transition:border-color .2s;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif;background:white}
.fv-m-input:focus,.fv-m-select:focus{border-color:#2563eb}
.fv-m-row{display:grid;grid-template-columns:1fr 1fr;gap:10px}
.fv-m-btn{width:100%;background:#0a2540;color:white;border:none;padding:13px;border-radius:10px;font-size:14px;font-weight:700;cursor:pointer;transition:background .2s;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif;margin-top:4px}
.fv-m-btn:hover{background:#0f3460}

/* EMPTY */
.fv-empty{text-align:center;padding:4rem 2rem;background:white;border:1px solid #e8edf2;border-radius:14px;color:#94a3b8}
.fv-empty h3{font-size:15px;color:#64748b;font-weight:600;margin-bottom:8px}

@media(max-width:640px){.fv-card{flex-direction:column}.fv-card-img{width:100%;height:180px}.fv-no-img{width:100%;height:180px}.fv-wrap{padding:1rem}}
</style>

<!-- MODAL NOUVELLE ALERTE -->
<div class="fv-overlay" id="fvOverlay" onclick="fvCloseModal()"></div>
<div class="fv-modal" id="fvModal">
    <div class="fv-modal-head">
        <h3>Créer une alerte</h3>
        <button class="fv-modal-close" onclick="fvCloseModal()">×</button>
    </div>
    <form method="POST" action="{{ route('alertes.store') }}">
        @csrf
        <div class="fv-m-row">
            <div class="fv-m-field">
                <label class="fv-m-label">Type d'annonce</label>
                <select name="type" class="fv-m-select">
                    <option value="">Tous les types</option>
                    <option value="location">Location</option>
                    <option value="vente_maison">Vente</option>
                    <option value="commerce">Commerce</option>
                </select>
            </div>
            <div class="fv-m-field">
                <label class="fv-m-label">Ville</label>
                <select name="ville" class="fv-m-select">
                    <option value="">Toutes les villes</option>
                    @foreach(['Libreville','Port-Gentil','Franceville','Oyem','Moanda','Lambaréné','Tchibanga'] as $v)
                        <option value="{{ $v }}">{{ $v }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="fv-m-row">
            <div class="fv-m-field">
                <label class="fv-m-label">Prix max (FCFA)</label>
                <input type="number" name="prix_max" class="fv-m-input" placeholder="Illimité" min="0">
            </div>
            <div class="fv-m-field">
                <label class="fv-m-label">Chambres min</label>
                <select name="nb_chambres" class="fv-m-select">
                    <option value="">Toutes</option>
                    <option value="1">1+</option>
                    <option value="2">2+</option>
                    <option value="3">3+</option>
                    <option value="4">4+</option>
                </select>
            </div>
        </div>
        <button type="submit" class="fv-m-btn">Créer l'alerte</button>
    </form>
</div>

<div class="fv-wrap">
    <div class="fv-header">
        <h1>Mes favoris & alertes</h1>
        <p>Retrouvez vos annonces sauvegardées et vos alertes de recherche</p>
    </div>

    <!-- TABS -->
    <div class="fv-tabs">
        <button class="fv-tab active" id="tabFav" onclick="fvTab('fav',this)">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
            Favoris
            <span class="fv-tab-badge">{{ $favoris->count() }}</span>
        </button>
        <button class="fv-tab" id="tabAl" onclick="fvTab('al',this)">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
            Alertes
            <span class="fv-tab-badge">{{ $alertes->count() }}</span>
        </button>
    </div>

    <!-- FAVORIS -->
    <div id="panelFav">
        @if($favoris->isEmpty())
            <div class="fv-empty">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" style="margin-bottom:1rem"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                <h3>Aucun favori pour l'instant</h3>
                <p style="font-size:13px;margin-bottom:1.5rem">Cliquez sur ♡ sur une annonce pour la sauvegarder</p>
                <a href="{{ route('annonces.index') }}" style="display:inline-block;background:#0a2540;color:white;padding:10px 24px;border-radius:10px;text-decoration:none;font-weight:700;font-size:13px">Parcourir les annonces</a>
            </div>
        @else
            <div class="fv-list">
                @foreach($favoris as $favori)
                    @php
                        $ann = $favori->annonce;
                        if(!$ann) continue;
                        $typeLabel = match($ann->type){'location'=>'Location','vente_maison'=>'Vente','vente_terrain'=>'Terrain','commerce'=>'Commerce',default=>$ann->type};
                        $photo = $ann->photos->first();
                    @endphp
                    <div class="fv-card">
                        <div class="fv-card-img" style="min-height:160px">
                            @if($photo)
                                <img src="{{ str_starts_with($photo->url, 'http') ? $photo->url : asset('storage/'.$photo->url) }}" alt="{{ $ann->titre }}">
                            @else
                                <div class="fv-no-img">
                                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="3"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                                </div>
                            @endif
                            <span class="fv-type-pill badge-{{ $ann->type }}">{{ $typeLabel }}</span>
                        </div>
                        <div class="fv-card-body">
                            <div class="fv-card-top">
                                <div class="fv-price">
                                    {{ number_format($ann->prix,0,',',' ') }} FCFA
                                    @if($ann->type==='location')<small>/mois</small>@endif
                                </div>
                            </div>
                            <div class="fv-title">{{ $ann->titre }}</div>
                            <div class="fv-loc">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="#94a3b8"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                                {{ $ann->quartier }}, {{ $ann->ville }}
                            </div>
                            <div class="fv-chips">
                                @if($ann->nb_chambres)<span class="fv-chip">{{ $ann->nb_chambres }} ch.</span>@endif
                                @if($ann->superficie)<span class="fv-chip">{{ $ann->superficie }} m²</span>@endif
                                @if($ann->meuble)<span class="fv-chip green">Meublé</span>@endif
                                @if($ann->parking)<span class="fv-chip blue">Parking</span>@endif
                            </div>
                            <div class="fv-card-footer">
                                <a href="{{ route('annonces.show',$ann) }}" class="fv-btn-voir">Voir l'annonce</a>
                                <form method="POST" action="{{ route('favoris.toggle',$ann) }}" style="display:inline">
                                    @csrf
                                    <button type="submit" class="fv-btn-del">Retirer</button>
                                </form>
                                <span class="fv-save-date">Ajouté le {{ $favori->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- ALERTES -->
    <div id="panelAl" style="display:none">
        <button class="fv-alerte-new-btn" onclick="fvOpenModal()">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Nouvelle alerte
        </button>

        @if($alertes->isEmpty())
            <div class="fv-empty">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" style="margin-bottom:1rem"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                <h3>Aucune alerte créée</h3>
                <p style="font-size:13px">Créez une alerte pour être notifié dès qu'une nouvelle annonce correspond à vos critères</p>
            </div>
        @else
            <div class="fv-alertes">
                @foreach($alertes as $alerte)
                    @php
                        $nbNew = \App\Models\Annonce::where('statut','active')
                            ->when($alerte->type, fn($q)=>$q->where('type',$alerte->type))
                            ->when($alerte->ville, fn($q)=>$q->where('ville',$alerte->ville))
                            ->when($alerte->prix_max, fn($q)=>$q->where('prix','<=',$alerte->prix_max))
                            ->when($alerte->nb_chambres, fn($q)=>$q->where('nb_chambres','>=',$alerte->nb_chambres))
                            ->where('created_at','>',$alerte->updated_at)
                            ->count();
                    @endphp
                    <div class="fv-alerte-card">
                        <div class="fv-alerte-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                        </div>
                        <div class="fv-alerte-body">
                            <div class="fv-alerte-title">
                                {{ $alerte->type ? match($alerte->type){'location'=>'Location','vente_maison'=>'Vente','commerce'=>'Commerce',default=>$alerte->type} : 'Tous types' }}
                                @if($alerte->ville) · {{ $alerte->ville }}@endif
                                @if($nbNew > 0)<span class="fv-alerte-new">{{ $nbNew }} nouvelles</span>@endif
                            </div>
                            <div class="fv-alerte-sub">
                                @if($alerte->prix_max)Max {{ number_format($alerte->prix_max,0,',',' ') }} FCFA · @endif
                                @if($alerte->nb_chambres){{ $alerte->nb_chambres }}+ chambres · @endif
                                Créée le {{ $alerte->created_at->format('d/m/Y') }}
                            </div>
                        </div>
                        <form method="POST" action="{{ route('alertes.destroy',$alerte) }}">
                            @csrf @method('DELETE')
                            <button type="submit" class="fv-btn-alerte-del">Supprimer</button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<script>
function fvTab(tab, btn) {
    document.querySelectorAll('.fv-tab').forEach(function(b){b.classList.remove('active')});
    btn.classList.add('active');
    document.getElementById('panelFav').style.display = tab==='fav' ? 'block':'none';
    document.getElementById('panelAl').style.display  = tab==='al'  ? 'block':'none';
}
function fvOpenModal(){document.getElementById('fvOverlay').classList.add('open');document.getElementById('fvModal').classList.add('open');document.body.style.overflow='hidden'}
function fvCloseModal(){document.getElementById('fvOverlay').classList.remove('open');document.getElementById('fvModal').classList.remove('open');document.body.style.overflow=''}
document.addEventListener('keydown',function(e){if(e.key==='Escape')fvCloseModal()});
@if(request('tab')==='alertes')
document.addEventListener('DOMContentLoaded',function(){fvTab('al',document.getElementById('tabAl'))});
@endif
</script>
@endsection