@extends('layouts.app')
@section('title', 'Administration — GaboPlex')
@section('content')
<style>
.adm-layout{display:grid;grid-template-columns:220px 1fr;min-height:calc(100vh - 64px)}
.adm-sidebar{background:#0a2540;padding:1.5rem 0}
.adm-sidebar-title{font-size:10px;font-weight:700;color:rgba(255,255,255,.3);text-transform:uppercase;letter-spacing:1.5px;padding:0 1.25rem;margin-bottom:.75rem}
.adm-nav-item{display:flex;align-items:center;gap:10px;padding:10px 1.25rem;font-size:13px;font-weight:500;color:rgba(255,255,255,.55);cursor:pointer;text-decoration:none;transition:all .15s;position:relative;margin-bottom:2px}
.adm-nav-item:hover{background:rgba(255,255,255,.06);color:rgba(255,255,255,.9)}
.adm-nav-item.active{background:rgba(255,255,255,.1);color:white}
.adm-nav-item svg{width:15px;height:15px;flex-shrink:0}
.adm-nav-badge{margin-left:auto;padding:1px 8px;border-radius:20px;font-size:10px;font-weight:700}
.adm-nb-red{background:#fee2e2;color:#991b1b}
.adm-nb-blue{background:#dbeafe;color:#1e40af}
.adm-nav-sep{height:1px;background:rgba(255,255,255,.06);margin:10px 1.25rem}

.adm-main{background:#f8fafc;padding:2rem}
.adm-page{display:none}
.adm-page.active{display:block}
.adm-page-title{font-size:20px;font-weight:800;color:#0a2540;letter-spacing:-.5px;margin-bottom:1.5rem}

/* KPIS */
.adm-kpis{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:2rem}
.adm-kpi{background:white;border:1px solid #e8edf2;border-radius:12px;padding:1.25rem}
.adm-kpi-n{font-size:26px;font-weight:800;color:#0a2540;line-height:1;margin-bottom:4px}
.adm-kpi-l{font-size:12px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.5px}
.adm-kpi-delta{font-size:12px;font-weight:600;margin-top:4px}
.adm-kpi-delta.up{color:#059669}
.adm-kpi-delta.warn{color:#d97706}

/* FILTERS / SEARCH */
.adm-toolbar{display:flex;align-items:center;gap:10px;margin-bottom:1.25rem;flex-wrap:wrap}
.adm-filter-btn{padding:6px 14px;border-radius:20px;border:1.5px solid #e2e8f0;background:white;font-size:12px;font-weight:600;color:#64748b;cursor:pointer;transition:all .15s;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif}
.adm-filter-btn:hover{border-color:#0a2540;color:#0a2540}
.adm-filter-btn.active{background:#0a2540;color:white;border-color:#0a2540}
.adm-search{flex:1;max-width:280px;padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:13px;outline:none;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif;background:white;color:#1e293b;transition:border-color .2s}
.adm-search:focus{border-color:#2563eb}

/* TABLE */
.adm-table-wrap{background:white;border:1px solid #e8edf2;border-radius:14px;overflow:hidden}
.adm-table{width:100%;border-collapse:collapse}
.adm-table th{padding:10px 14px;text-align:left;font-size:11px;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:.5px;background:#f8fafc;border-bottom:1px solid #e8edf2}
.adm-table td{padding:12px 14px;font-size:13px;border-bottom:1px solid #f8fafc;color:#1e293b;vertical-align:middle}
.adm-table tr:last-child td{border-bottom:none}
.adm-table tr:hover td{background:#fafbff}
.adm-thumb{width:48px;height:38px;border-radius:6px;object-fit:cover;background:#f1f5f9;display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0}
.adm-thumb img{width:100%;height:100%;object-fit:cover}
.adm-ann-name{font-weight:600;color:#0a2540;max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.adm-ann-sub{font-size:11px;color:#94a3b8;margin-top:1px}
.pill{padding:2px 9px;border-radius:20px;font-size:11px;font-weight:700;display:inline-block}
.p-wait{background:#fef9c3;color:#854d0e}
.p-active{background:#dcfce7;color:#166534}
.p-rej{background:#fee2e2;color:#991b1b}
.p-loc{background:#e0f2fe;color:#0369a1}
.p-vent{background:#dbeafe;color:#1d4ed8}
.p-com{background:#ede9fe;color:#5b21b6}
.adm-actions{display:flex;gap:5px;align-items:center}
.adm-act{padding:5px 10px;border-radius:6px;font-size:11px;font-weight:700;border:1px solid #e2e8f0;background:white;cursor:pointer;transition:all .15s;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif;text-decoration:none;color:#475569}
.adm-act:hover{border-color:#94a3b8;color:#0a2540}
.adm-act-ok{border-color:#bbf7d0;color:#166534;background:#f0fdf4}
.adm-act-ok:hover{background:#dcfce7}
.adm-act-rej{border-color:#fecaca;color:#dc2626;background:#fef2f2}
.adm-act-rej:hover{background:#fee2e2}
.adm-act-del{border-color:#fecaca;color:#dc2626;background:white}
.adm-act-del:hover{background:#fef2f2}
.adm-act-blue{border-color:#bfdbfe;color:#1d4ed8;background:#eff6ff}
.adm-act-blue:hover{background:#dbeafe}

/* USERS TABLE */
.adm-avatar{width:32px;height:32px;border-radius:50%;background:#0a2540;color:white;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;flex-shrink:0;overflow:hidden}
.adm-avatar img{width:100%;height:100%;object-fit:cover}

/* PAGINATION */
.adm-pagination{padding:1rem 1.25rem;display:flex;justify-content:flex-end}

@media(max-width:900px){.adm-layout{grid-template-columns:1fr}.adm-sidebar{display:none}.adm-kpis{grid-template-columns:repeat(2,1fr)}}
</style>

@php
    $annoncesEnAttente = \App\Models\Annonce::where('statut','en_attente')->count();
    $contactsNonLus   = \App\Models\Contact::where('lu',false)->count();
    $messagesNonLus   = \App\Models\Message::where('lu',false)->count();
    $totalUsers       = \App\Models\User::count();
    $totalAnnonces    = \App\Models\Annonce::count();
    $totalActives     = \App\Models\Annonce::where('statut','active')->count();
    $totalPaiements   = \App\Models\Paiement::where('statut','complete')->sum('montant');
@endphp

<div class="adm-layout">

    <!-- SIDEBAR -->
    <div class="adm-sidebar">
        <div class="adm-sidebar-title">Administration</div>

        <a href="#" class="adm-nav-item active" onclick="admPage('dashboard',this)">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            Tableau de bord
        </a>
        <a href="#" class="adm-nav-item" onclick="admPage('annonces',this)">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
            Annonces
            @if($annoncesEnAttente > 0)
                <span class="adm-nav-badge adm-nb-red">{{ $annoncesEnAttente }}</span>
            @endif
        </a>
        <a href="#" class="adm-nav-item" onclick="admPage('users',this)">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
            Utilisateurs
            <span class="adm-nav-badge adm-nb-blue">{{ $totalUsers }}</span>
        </a>
        <a href="#" class="adm-nav-item" onclick="admPage('paiements',this)">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
            Paiements
        </a>
        <a href="#" class="adm-nav-item" onclick="admPage('messages',this)">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
            Messages
            @if($messagesNonLus > 0)
                <span class="adm-nav-badge adm-nb-red">{{ $messagesNonLus }}</span>
            @endif
        </a>

        <div class="adm-nav-sep"></div>
        <a href="{{ route('annonces.index') }}" class="adm-nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
            Voir le site
        </a>
    </div>

    <!-- MAIN -->
    <div class="adm-main">

        <!-- ── DASHBOARD ── -->
        <div class="adm-page active" id="adm-dashboard">
            <div class="adm-page-title">Vue d'ensemble</div>
            <div class="adm-kpis">
                <div class="adm-kpi">
                    <div class="adm-kpi-n" style="color:#059669">{{ $totalActives }}</div>
                    <div class="adm-kpi-l">Annonces actives</div>
                    <div class="adm-kpi-delta up">↑ {{ $totalAnnonces }} total</div>
                </div>
                <div class="adm-kpi">
                    <div class="adm-kpi-n" style="color:#d97706">{{ $annoncesEnAttente }}</div>
                    <div class="adm-kpi-l">En attente</div>
                    @if($annoncesEnAttente > 0)<div class="adm-kpi-delta warn">Action requise</div>@endif
                </div>
                <div class="adm-kpi">
                    <div class="adm-kpi-n">{{ $totalUsers }}</div>
                    <div class="adm-kpi-l">Utilisateurs</div>
                    <div class="adm-kpi-delta up">↑ Actifs</div>
                </div>
                <div class="adm-kpi">
                    <div class="adm-kpi-n" style="color:#2563eb">{{ number_format($totalPaiements,0,',',' ') }}</div>
                    <div class="adm-kpi-l">FCFA encaissés</div>
                    <div class="adm-kpi-delta up">Paiements confirmés</div>
                </div>
            </div>

            @if($annoncesEnAttente > 0)
                <div style="background:#fffbeb;border:1px solid #fde68a;border-radius:12px;padding:1rem 1.25rem;margin-bottom:1.5rem;display:flex;align-items:center;gap:10px">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <span style="font-size:13px;color:#92400e;font-weight:500">{{ $annoncesEnAttente }} annonce(s) en attente de validation.</span>
                    <button onclick="admPage('annonces',document.querySelector('[onclick*=annonces]'))" style="padding:6px 14px;border-radius:8px;background:#d97706;color:white;border:none;font-size:12px;font-weight:700;cursor:pointer;margin-left:auto">Valider maintenant</button>
                </div>
            @endif

            <!-- Annonces récentes -->
            <div style="font-size:14px;font-weight:700;color:#0a2540;margin-bottom:1rem">Dernières annonces soumises</div>
            <div class="adm-table-wrap">
                <table class="adm-table">
                    <thead><tr><th>Annonce</th><th>Auteur</th><th>Type</th><th>Statut</th><th>Date</th><th>Actions</th></tr></thead>
                    <tbody>
                        @foreach(\App\Models\Annonce::with(['user','photos'])->orderByDesc('created_at')->take(8)->get() as $ann)
                        @php $photo = $ann->photos->first(); @endphp
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:10px">
                                    <div class="adm-thumb">
                                        @if($photo)<img src="{{ str_starts_with($photo->url, 'http') ? $photo->url : asset('storage/'.$photo->url) }}" alt="">
                                        @else<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="3"/></svg>@endif
                                    </div>
                                    <div>
                                        <div class="adm-ann-name">{{ $ann->titre }}</div>
                                        <div class="adm-ann-sub">{{ $ann->quartier }}, {{ $ann->ville }} · {{ number_format($ann->prix,0,',',' ') }} FCFA</div>
                                    </div>
                                </div>
                            </td>
                            <td style="color:#475569">{{ $ann->user->name }}</td>
                            <td><span class="pill {{ match($ann->type){'location'=>'p-loc','vente_maison'=>'p-vent','commerce'=>'p-com',default=>'p-loc'} }}">{{ match($ann->type){'location'=>'Location','vente_maison'=>'Vente','vente_terrain'=>'Terrain','commerce'=>'Commerce',default=>$ann->type} }}</span></td>
                            <td><span class="pill {{ match($ann->statut){'active'=>'p-active','en_attente'=>'p-wait','rejetee'=>'p-rej',default=>'p-wait'} }}">{{ match($ann->statut){'active'=>'Active','en_attente'=>'En attente','rejetee'=>'Rejetée',default=>'Expirée'} }}</span></td>
                            <td style="color:#94a3b8;font-size:12px">{{ $ann->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="adm-actions">
                                    <a href="{{ route('annonces.show',$ann) }}" class="adm-act adm-act-blue">Voir</a>
                                    @if($ann->statut === 'en_attente')
                                        <form method="POST" action="{{ route('admin.annonces.valider',$ann) }}" style="display:inline">@csrf<button type="submit" class="adm-act adm-act-ok">Valider</button></form>
                                        <button onclick="admReject({{ $ann->id }})" class="adm-act adm-act-rej">Rejeter</button>
                                    @endif
                                    <form method="POST" action="{{ route('admin.annonces.destroy',$ann) }}" style="display:inline" onsubmit="return confirm('Supprimer ?')">@csrf @method('DELETE')<button type="submit" class="adm-act adm-act-del">✕</button></form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ── ANNONCES ── -->
        <div class="adm-page" id="adm-annonces">
            <div class="adm-page-title">Gestion des annonces</div>
            <div class="adm-toolbar">
                <button class="adm-filter-btn active" onclick="admAnnFilter('',this)">Toutes</button>
                <button class="adm-filter-btn" onclick="admAnnFilter('en_attente',this)">En attente @if($annoncesEnAttente > 0)<span style="background:#fee2e2;color:#991b1b;padding:1px 6px;border-radius:20px;font-size:10px;margin-left:4px">{{ $annoncesEnAttente }}</span>@endif</button>
                <button class="adm-filter-btn" onclick="admAnnFilter('active',this)">Actives</button>
                <button class="adm-filter-btn" onclick="admAnnFilter('rejetee',this)">Rejetées</button>
                <input class="adm-search" id="admAnnSearch" placeholder="Rechercher une annonce..." oninput="admAnnSearch(this.value)">
            </div>
            <div class="adm-table-wrap">
                <table class="adm-table">
                    <thead><tr><th>Annonce</th><th>Auteur</th><th>Type</th><th>Prix</th><th>Statut</th><th>Date</th><th>Actions</th></tr></thead>
                    <tbody id="admAnnTbody">
                        @foreach(\App\Models\Annonce::with(['user','photos'])->orderByDesc('created_at')->get() as $ann)
                        @php $photo = $ann->photos->first(); @endphp
                        <tr data-statut="{{ $ann->statut }}" data-search="{{ strtolower($ann->titre.' '.$ann->ville.' '.$ann->user->name) }}">
                            <td>
                                <div style="display:flex;align-items:center;gap:10px">
                                    <div class="adm-thumb">
                                        @if($photo)<img src="{{ str_starts_with($photo->url, 'http') ? $photo->url : asset('storage/'.$photo->url) }}" alt="">
                                        @else<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="3"/></svg>@endif
                                    </div>
                                    <div><div class="adm-ann-name">{{ $ann->titre }}</div><div class="adm-ann-sub">{{ $ann->quartier }}, {{ $ann->ville }}</div></div>
                                </div>
                            </td>
                            <td style="color:#475569;font-size:12px">{{ $ann->user->name }}</td>
                            <td><span class="pill {{ match($ann->type){'location'=>'p-loc','vente_maison'=>'p-vent','commerce'=>'p-com',default=>'p-loc'} }}">{{ match($ann->type){'location'=>'Location','vente_maison'=>'Vente','commerce'=>'Commerce',default=>$ann->type} }}</span></td>
                            <td style="font-weight:600;color:#0a2540">{{ number_format($ann->prix,0,',',' ') }}</td>
                            <td><span class="pill {{ match($ann->statut){'active'=>'p-active','en_attente'=>'p-wait','rejetee'=>'p-rej',default=>'p-wait'} }}">{{ match($ann->statut){'active'=>'Active','en_attente'=>'En attente','rejetee'=>'Rejetée',default=>'Expirée'} }}</span></td>
                            <td style="color:#94a3b8;font-size:12px">{{ $ann->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="adm-actions">
                                    <a href="{{ route('annonces.show',$ann) }}" class="adm-act adm-act-blue">Voir</a>
                                    @if($ann->statut==='en_attente')
                                        <form method="POST" action="{{ route('admin.annonces.valider',$ann) }}" style="display:inline">@csrf<button type="submit" class="adm-act adm-act-ok">✓</button></form>
                                        <button onclick="admReject({{ $ann->id }})" class="adm-act adm-act-rej">✗</button>
                                    @endif
                                    @if(!$ann->verifie)
                                        <form method="POST" action="{{ route('admin.annonces.verifier',$ann) }}" style="display:inline">@csrf<button type="submit" class="adm-act" style="border-color:#bfdbfe;color:#1d4ed8">⊙</button></form>
                                    @endif
                                    <form method="POST" action="{{ route('admin.annonces.destroy',$ann) }}" style="display:inline" onsubmit="return confirm('Supprimer ?')">@csrf @method('DELETE')<button type="submit" class="adm-act adm-act-del">✕</button></form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ── UTILISATEURS ── -->
        <div class="adm-page" id="adm-users">
            <div class="adm-page-title">Utilisateurs inscrits</div>
            <div class="adm-toolbar">
                <input class="adm-search" placeholder="Rechercher un utilisateur..." oninput="admUserSearch(this.value)">
            </div>
            <div class="adm-table-wrap">
                <table class="adm-table">
                    <thead><tr><th>Utilisateur</th><th>Email</th><th>Annonces</th><th>Rôle</th><th>Inscription</th></tr></thead>
                    <tbody id="admUserTbody">
                        @foreach(\App\Models\User::withCount('annonces')->orderByDesc('created_at')->get() as $u)
                        <tr data-search="{{ strtolower($u->name.' '.$u->email) }}">
                            <td>
                                <div style="display:flex;align-items:center;gap:10px">
                                    <div class="adm-avatar">
                                        @if($u->avatar)<img src="{{ asset('storage/'.$u->avatar) }}" alt="">
                                        @else{{ strtoupper(substr($u->name,0,1)) }}@endif
                                    </div>
                                    <span style="font-weight:600;color:#0a2540">{{ $u->name }}</span>
                                </div>
                            </td>
                            <td style="color:#64748b;font-size:12px">{{ $u->email }}</td>
                            <td style="font-weight:600;color:#0a2540">{{ $u->annonces_count }}</td>
                            <td><span class="pill {{ $u->is_admin ? 'p-wait':'p-active' }}">{{ $u->is_admin ? 'Admin':'Membre' }}</span></td>
                            <td style="color:#94a3b8;font-size:12px">{{ $u->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ── PAIEMENTS ── -->
        <div class="adm-page" id="adm-paiements">
            <div class="adm-page-title">Historique des paiements</div>
            <div class="adm-table-wrap">
                <table class="adm-table">
                    <thead><tr><th>Utilisateur</th><th>Annonce</th><th>Offre</th><th>Montant</th><th>Mode</th><th>Statut</th><th>Date</th></tr></thead>
                    <tbody>
                        @foreach(\App\Models\Paiement::with(['user','annonce'])->orderByDesc('created_at')->get() as $p)
                        @php $sc=match($p->statut??''){'complete'=>['Confirmé','p-active'],'en_attente'=>['En attente','p-wait'],default=>['Échoué','p-rej']}; @endphp
                        <tr>
                            <td style="font-weight:500">{{ $p->user->name ?? '—' }}</td>
                            <td style="color:#64748b;font-size:12px;max-width:160px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $p->annonce?->titre ?? '—' }}</td>
                            <td>{{ match($p->offre??''){'boost_14j'=>'Boost 14j','premium_30j'=>'Premium 30j','pass_annuel'=>'Pro annuel',default=>'—'} }}</td>
                            <td style="font-weight:700;color:#0a2540">{{ number_format($p->montant,0,',',' ') }} FCFA</td>
                            <td style="color:#64748b;font-size:12px">{{ match($p->mode_paiement??''){'airtel_money'=>'Airtel','moov_money'=>'Moov','carte'=>'Visa/MC',default=>'—'} }}</td>
                            <td><span class="pill {{ $sc[1] }}">{{ $sc[0] }}</span></td>
                            <td style="color:#94a3b8;font-size:12px">{{ $p->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ── MESSAGES ── -->
        <div class="adm-page" id="adm-messages">
            <div class="adm-page-title">Messages reçus</div>
            <div class="adm-table-wrap">
                <table class="adm-table">
                    <thead><tr><th>De</th><th>Annonce</th><th>Message</th><th>Lu</th><th>Date</th></tr></thead>
                    <tbody>
                        @foreach(\App\Models\Message::with('annonce')->orderByDesc('created_at')->take(50)->get() as $msg)
                        <tr style="{{ !$msg->lu ? 'background:#fafbff;font-weight:500':'' }}">
                            <td>
                                <div style="font-weight:600;color:#0a2540">{{ $msg->expediteur_nom }}</div>
                                <div style="font-size:11px;color:#94a3b8">{{ $msg->expediteur_email }}</div>
                            </td>
                            <td style="color:#64748b;font-size:12px;max-width:160px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $msg->annonce?->titre ?? '—' }}</td>
                            <td style="font-size:12px;color:#475569;max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $msg->contenu }}</td>
                            <td><span class="pill {{ $msg->lu ? 'p-active':'p-wait' }}">{{ $msg->lu ? 'Lu':'Non lu' }}</span></td>
                            <td style="color:#94a3b8;font-size:12px">{{ $msg->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- MODAL REJET -->
<div style="position:fixed;inset:0;background:rgba(10,37,64,.45);z-index:3000;display:none;align-items:center;justify-content:center" id="admRejOverlay">
    <div style="background:white;border-radius:16px;padding:1.75rem;width:440px;max-width:95vw">
        <div style="font-size:16px;font-weight:700;color:#0a2540;margin-bottom:1rem">Motif de rejet</div>
        <form method="POST" id="admRejForm">
            @csrf
            <textarea name="motif" id="admRejMotif" rows="3" placeholder="Expliquez pourquoi l'annonce est rejetée..." style="width:100%;padding:11px 14px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:14px;outline:none;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif;resize:vertical;color:#1e293b;margin-bottom:12px"></textarea>
            <div style="display:flex;gap:10px">
                <button type="button" onclick="document.getElementById('admRejOverlay').style.display='none'" style="flex:1;padding:11px;border-radius:10px;border:1.5px solid #e2e8f0;background:white;font-size:13px;font-weight:600;cursor:pointer;color:#64748b;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif">Annuler</button>
                <button type="submit" style="flex:1;padding:11px;border-radius:10px;border:none;background:#dc2626;color:white;font-size:13px;font-weight:700;cursor:pointer;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif">Rejeter l'annonce</button>
            </div>
        </form>
    </div>
</div>

<script>
function admPage(page, el) {
    document.querySelectorAll('.adm-page').forEach(function(p){p.classList.remove('active')});
    document.querySelectorAll('.adm-nav-item').forEach(function(n){n.classList.remove('active')});
    document.getElementById('adm-'+page).classList.add('active');
    if(el) el.classList.add('active');
}
function admAnnFilter(statut, btn) {
    document.querySelectorAll('#adm-annonces .adm-filter-btn').forEach(function(b){b.classList.remove('active')});
    btn.classList.add('active');
    document.querySelectorAll('#admAnnTbody tr').forEach(function(tr){
        tr.style.display = (!statut || tr.dataset.statut===statut) ? '':'none';
    });
}
function admAnnSearch(q) {
    q = q.toLowerCase();
    document.querySelectorAll('#admAnnTbody tr').forEach(function(tr){
        tr.style.display = tr.dataset.search.includes(q) ? '':'none';
    });
}
function admUserSearch(q) {
    q = q.toLowerCase();
    document.querySelectorAll('#admUserTbody tr').forEach(function(tr){
        tr.style.display = tr.dataset.search.includes(q) ? '':'none';
    });
}
function admReject(id) {
    document.getElementById('admRejOverlay').style.display = 'flex';
    document.getElementById('admRejForm').action = '/admin/annonces/'+id+'/rejeter';
}
document.addEventListener('keydown',function(e){
    if(e.key==='Escape') document.getElementById('admRejOverlay').style.display='none';
});
@if(request('page'))
document.addEventListener('DOMContentLoaded',function(){
    var p = '{{ request("page") }}';
    var el = document.querySelector('[onclick*="admPage(\''+p+'\'"]');
    if(el) admPage(p, el);
});
@endif
</script>
@endsection