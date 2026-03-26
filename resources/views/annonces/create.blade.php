@extends('layouts.app')

@section('title', 'Publier une annonce — GaboPlex')

@section('content')
<style>
*{box-sizing:border-box}
.wz-page{display:grid;grid-template-columns:280px 1fr;min-height:calc(100vh - 64px)}
@media(max-width:900px){.wz-page{grid-template-columns:1fr}.wz-sidebar{display:none}}
.wz-sidebar{position:relative;overflow:hidden;display:flex;flex-direction:column;justify-content:flex-end;padding:2rem;background:#0a2540}
.wz-sidebar-bg{position:absolute;inset:0;background-image:url('https://images.unsplash.com/photo-1582268611958-ebfd161ef9cf?w=800&q=80');background-size:cover;background-position:center;opacity:.3}
.wz-sidebar-overlay{position:absolute;inset:0;background:linear-gradient(180deg,rgba(10,37,64,.2) 0%,rgba(10,37,64,.95) 100%)}
.wz-sidebar-logo{position:absolute;top:1.5rem;left:2rem;z-index:3;font-size:18px;font-weight:800;color:white;text-decoration:none;letter-spacing:-.5px}
.wz-sidebar-logo span{color:#60a5fa}
.wz-sidebar-back{position:absolute;top:1.5rem;right:1.5rem;z-index:3;display:inline-flex;align-items:center;gap:5px;padding:6px 12px;border-radius:8px;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.15);color:rgba(255,255,255,.8);font-size:12px;font-weight:600;text-decoration:none;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif}
.wz-sidebar-back:hover{background:rgba(255,255,255,.18);color:white}
.wz-sidebar-content{position:relative;z-index:2}
.wz-sidebar-steps{display:flex;flex-direction:column;gap:8px;margin-bottom:1.5rem}
.wz-ss-item{display:flex;align-items:center;gap:10px}
.wz-ss-num{width:26px;height:26px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;flex-shrink:0;transition:all .3s}
.wz-ss-num.ss-done{background:#059669;color:white}
.wz-ss-num.ss-active{background:white;color:#0a2540}
.wz-ss-num.ss-todo{background:rgba(255,255,255,.1);color:rgba(255,255,255,.35);border:1px solid rgba(255,255,255,.15)}
.wz-ss-lbl{font-size:12px;font-weight:600;transition:color .3s}
.wz-ss-lbl.ss-done{color:rgba(255,255,255,.45)}
.wz-ss-lbl.ss-active{color:white}
.wz-ss-lbl.ss-todo{color:rgba(255,255,255,.3)}
.wz-ss-check{margin-left:auto;flex-shrink:0}
.wz-sidebar-tip{background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);border-radius:10px;padding:10px 12px;font-size:12px;color:rgba(255,255,255,.55);line-height:1.6}
.wz-sidebar-tip strong{color:rgba(255,255,255,.8);font-weight:600}
.wz-main{padding:2rem;overflow-y:auto;background:#f8fafc}
.wz-wrap{max-width:760px;margin:0 auto}
@media(max-width:900px){.wz-main{padding:1rem}}
.wz-guide{display:none}

/* STEPPER */
.wz-stepper{display:flex;align-items:center;background:white;border:1px solid #e8edf2;border-radius:14px;padding:.9rem 1.5rem;margin-bottom:1.25rem;overflow-x:auto;gap:0}
.wz-step-item{display:flex;align-items:center;flex:1;min-width:0}
.wz-sc{width:28px;height:28px;border-radius:50%;flex-shrink:0;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;border:2px solid #e2e8f0;color:#94a3b8;background:white;transition:all .25s}
.wz-sc.active{background:#0a2540;border-color:#0a2540;color:white}
.wz-sc.done{background:#059669;border-color:#059669;color:white;font-size:10px}
.wz-sl{font-size:11px;font-weight:600;color:#94a3b8;margin-left:6px;white-space:nowrap}
.wz-sl.active{color:#0a2540}
.wz-sl.done{color:#059669}
.wz-line{flex:1;height:2px;background:#e2e8f0;margin:0 8px;min-width:8px;transition:background .25s}
.wz-line.done{background:#059669}

/* CARD */
.wz-card{background:white;border:1px solid #e8edf2;border-radius:16px;overflow:hidden}
.wz-panel{display:none}
.wz-panel.active{display:block}

/* HERO IMAGE PAR ÉTAPE */
.wz-hero{position:relative;height:120px;overflow:hidden}
.wz-hero-img{position:absolute;inset:0;background-size:cover;background-position:center}
.wz-hero-overlay{position:absolute;inset:0;background:linear-gradient(180deg,rgba(10,37,64,.25) 0%,rgba(10,37,64,.82) 100%)}
.wz-hero-content{position:relative;z-index:2;padding:1rem 1.5rem;display:flex;flex-direction:column;justify-content:flex-end;height:100%}
.wz-hero-title{font-size:17px;font-weight:800;color:white;letter-spacing:-.3px}
.wz-hero-sub{font-size:12px;color:rgba(255,255,255,.65);margin-top:2px}

/* Images par étape */
.wz-hero-1{background-image:url('https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=900&q=80')}
.wz-hero-2{background-image:url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=900&q=80')}
.wz-hero-3{background-image:url('https://images.unsplash.com/photo-1600566753376-12c8ab7fb75b?w=900&q=80')}
.wz-hero-4{background-image:url('https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=900&q=80')}
.wz-hero-5{background-image:url('https://images.unsplash.com/photo-1551836022-deb4988cc6c0?w=900&q=80')}
.wz-hero-6{background-image:url('https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=900&q=80')}

.wz-body{padding:1.5rem}
.wz-footer{display:flex;justify-content:space-between;align-items:center;padding:1rem 1.5rem;border-top:1px solid #f1f5f9}

/* CHAMPS */
.wz-group{margin-bottom:1.1rem}
.wz-label{display:block;font-size:12px;font-weight:700;color:#374151;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px}
.wz-label em{color:#ef4444;font-style:normal}
.wz-input,.wz-select,.wz-textarea{width:100%;padding:11px 14px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:14px;color:#1e293b;outline:none;transition:border-color .2s,box-shadow .2s;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif;background:white}
.wz-input:focus,.wz-select:focus,.wz-textarea:focus{border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.07)}
.wz-textarea{resize:vertical;min-height:110px}
.wz-row{display:grid;grid-template-columns:1fr 1fr;gap:1rem}
@media(max-width:560px){.wz-row{grid-template-columns:1fr}}

/* TYPE SELECTOR */
.wz-types{display:grid;grid-template-columns:repeat(3,1fr);gap:10px;margin-bottom:1.25rem}
.wz-type-radio{display:none}
.wz-type-lbl{display:flex;flex-direction:column;align-items:center;gap:8px;padding:1.1rem .75rem;border:1.5px solid #e2e8f0;border-radius:12px;cursor:pointer;transition:all .2s;text-align:center}
.wz-type-lbl:hover{border-color:#2563eb;background:#f8fbff}
.wz-type-radio:checked+.wz-type-lbl{border-color:#2563eb;background:#eff6ff}
.wz-type-icon{font-size:1.75rem}
.wz-type-name{font-size:13px;font-weight:700;color:#0a2540}
.wz-type-sub{font-size:11px;color:#94a3b8}

/* PILLS OPTIONS */
.wz-pills{display:flex;flex-wrap:wrap;gap:8px}
.wz-pill-chk{display:none}
.wz-pill-lbl{padding:7px 14px;border-radius:30px;border:1.5px solid #e2e8f0;background:white;font-size:13px;font-weight:600;color:#64748b;cursor:pointer;transition:all .15s;user-select:none}
.wz-pill-chk:checked+.wz-pill-lbl{background:#0a2540;color:white;border-color:#0a2540}
.wz-pill-lbl:hover{border-color:#0a2540;color:#0a2540}

/* PHOTOS */
.wz-drop{border:2px dashed #e2e8f0;border-radius:12px;padding:2.5rem;text-align:center;cursor:pointer;transition:all .2s;background:#fafbfc}
.wz-drop:hover,.wz-drop.dragover{border-color:#2563eb;background:#f0f7ff}
.wz-drop-icon{font-size:2rem;margin-bottom:8px}
.wz-drop-text{font-size:13px;color:#64748b;font-weight:600}
.wz-drop-sub{font-size:12px;color:#94a3b8;margin-top:4px}
.wz-photos-preview{display:flex;flex-wrap:wrap;gap:10px;margin-top:1rem}
.wz-thumb{position:relative;width:88px;height:88px;border-radius:10px;overflow:hidden;border:1.5px solid #e2e8f0}
.wz-thumb img{width:100%;height:100%;object-fit:cover}
.wz-thumb-del{position:absolute;top:3px;right:3px;background:rgba(239,68,68,.9);color:white;border:none;border-radius:50%;width:20px;height:20px;cursor:pointer;font-size:11px;display:flex;align-items:center;justify-content:center}
.wz-thumb-num{position:absolute;bottom:3px;left:3px;background:rgba(10,37,64,.7);color:white;border-radius:4px;width:18px;height:18px;font-size:10px;font-weight:700;display:flex;align-items:center;justify-content:center}
.wz-photos-count{font-size:12px;color:#2563eb;font-weight:600;margin-top:8px}

/* MAP */
.wz-map-hint{background:#eff6ff;border:1px solid #bfdbfe;border-radius:8px;padding:9px 13px;font-size:12px;color:#1d4ed8;margin-bottom:10px;display:flex;align-items:center;gap:6px}
#wz-map-container{height:240px;border-radius:10px;overflow:hidden;border:1px solid #e2e8f0}

/* WA input */
.wz-wa-wrap{position:relative}
.wz-wa-wrap .wz-input{padding-left:46px}
.wz-wa-icon{position:absolute;left:13px;top:50%;transform:translateY(-50%);width:22px;height:22px;pointer-events:none}
.wz-wa-note{display:flex;align-items:flex-start;gap:8px;background:#fffbeb;border:1px solid #fde68a;border-radius:8px;padding:9px 12px;margin-top:8px;font-size:12px;color:#92400e}

/* OFFRES */
.wz-offres{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:1.25rem}
.wz-offre-radio{display:none}
.wz-offre-lbl{display:block;border:1.5px solid #e2e8f0;border-radius:12px;padding:1.1rem;cursor:pointer;transition:all .2s;position:relative}
.wz-offre-radio:checked+.wz-offre-lbl{border-color:#2563eb;background:#f0f7ff}
.wz-offre-lbl:hover{border-color:#93c5fd}
.wz-offre-badge{position:absolute;top:10px;right:10px;padding:2px 8px;border-radius:20px;font-size:10px;font-weight:800}
.ob-free{background:#f1f5f9;color:#64748b}
.ob-boost{background:#fef9c3;color:#a16207}
.ob-premium{background:#eff6ff;color:#1d4ed8}
.ob-pro{background:#0a2540;color:#ffd700}
.wz-offre-icon{font-size:1.4rem;margin-bottom:5px}
.wz-offre-name{font-size:14px;font-weight:800;color:#0a2540;margin-bottom:2px}
.wz-offre-prix{font-size:1rem;font-weight:800;color:#2563eb;margin-bottom:8px}
.wz-offre-prix small{font-size:11px;color:#94a3b8;font-weight:500}
.wz-offre-features{list-style:none;padding:0;margin:0}
.wz-offre-features li{font-size:12px;color:#475569;padding:2px 0;padding-left:14px;position:relative}
.wz-offre-features li::before{content:'✓';position:absolute;left:0;color:#059669;font-weight:700}
.wz-offre-features li.na::before{content:'○';color:#cbd5e1}

/* PAIEMENT */
.wz-pay-methods{display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin-top:10px}
.wz-pay-radio{display:none}
.wz-pay-lbl{display:flex;flex-direction:column;align-items:center;gap:5px;padding:12px 8px;border:1.5px solid #e2e8f0;border-radius:10px;cursor:pointer;transition:all .2s;text-align:center}
.wz-pay-radio:checked+.wz-pay-lbl{border-color:#2563eb;background:#eff6ff}
.wz-pay-logo{font-size:1.4rem}
.wz-pay-name{font-size:11px;font-weight:700;color:#374151}

/* RECAP */
.wz-recap-card{background:#f8fafc;border:1px solid #e8edf2;border-radius:10px;padding:1.1rem;margin-bottom:1rem}
.wz-recap-row{display:flex;justify-content:space-between;font-size:13px;padding:5px 0;border-bottom:1px solid #f1f5f9}
.wz-recap-row:last-child{border-bottom:none}
.wz-recap-key{color:#64748b}
.wz-recap-val{font-weight:700;color:#0a2540;text-align:right;max-width:60%}
.wz-offre-recap{background:white;border:2px solid #2563eb;border-radius:10px;padding:1rem;display:flex;align-items:center;gap:10px;margin-bottom:1rem}
.wz-pay-info{background:#eff6ff;border:1px solid #bfdbfe;border-radius:10px;padding:11px 14px;font-size:13px;color:#1e40af;margin-bottom:1rem;display:flex;gap:8px;align-items:flex-start}

/* ALERTS */
.wz-alert-warn{background:#fffbeb;border:1px solid #fde68a;border-radius:10px;padding:11px 14px;font-size:13px;color:#92400e;margin-bottom:1.25rem;display:flex;gap:8px;align-items:flex-start}

/* BTNS */
.wz-btn-prev{padding:10px 22px;border-radius:10px;border:1.5px solid #e2e8f0;background:white;color:#64748b;font-size:13px;font-weight:700;cursor:pointer;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif;transition:all .15s}
.wz-btn-prev:hover{border-color:#94a3b8;color:#0a2540}
.wz-btn-next{padding:10px 24px;border-radius:10px;border:none;background:#0a2540;color:white;font-size:13px;font-weight:700;cursor:pointer;display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif;transition:background .2s}
.wz-btn-next:hover{background:#0f3460}
.wz-btn-submit{padding:10px 24px;border-radius:10px;border:none;background:#059669;color:white;font-size:13px;font-weight:700;cursor:pointer;display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif;transition:background .2s}
.wz-btn-submit:hover{background:#047857}

/* SPINNER */
.wz-spinner{display:none;text-align:center;padding:2rem}
.wz-spinner-ring{width:36px;height:36px;border:3px solid #e2e8f0;border-top-color:#2563eb;border-radius:50%;animation:spin .8s linear infinite;margin:0 auto 1rem}
@keyframes spin{to{transform:rotate(360deg)}}

/* GUIDE */
.wz-guide{position:sticky;top:1.5rem}
.wz-guide-card{background:#0a2540;border-radius:16px;padding:1.5rem;color:white}
.wz-guide-step{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;color:rgba(255,255,255,.4);margin-bottom:4px}
.wz-guide-title{font-size:15px;font-weight:800;margin-bottom:1.25rem}
.wz-guide-content{display:none}
.wz-guide-content.active{display:block}
.wz-guide-tip{display:flex;align-items:flex-start;gap:10px;margin-bottom:12px}
.wz-guide-dot{width:24px;height:24px;border-radius:50%;background:rgba(59,130,246,.2);border:1px solid rgba(59,130,246,.3);display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px}
.wz-guide-dot svg{width:12px;height:12px;stroke:#60a5fa}
.wz-guide-text{font-size:12px;color:rgba(255,255,255,.72);line-height:1.55}
.wz-guide-text strong{color:white}
.wz-guide-progress{margin-top:1.5rem}
.wz-guide-progress-lbl{font-size:10px;color:rgba(255,255,255,.35);margin-bottom:6px}
.wz-guide-bar{background:rgba(255,255,255,.1);border-radius:99px;height:4px}
.wz-guide-fill{background:#2563eb;height:4px;border-radius:99px;transition:width .4s}
</style>

<!-- ══ OVERLAY PAIEMENT ══ -->
<div class="wz-wrap" style="padding:0 1.5rem 2rem">

{{-- Flash erreurs --}}
@if($errors->any())
    <div class="wz-alert-warn" style="max-width:1100px;margin:1.5rem auto 0">
        <span>⚠️</span>
        <div>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
    </div>
@endif

</div>

<div class="wz-page">

<!-- ══ SIDEBAR GAUCHE ══ -->
<div class="wz-sidebar">
    <div class="wz-sidebar-bg"></div>
    <div class="wz-sidebar-overlay"></div>
    <a href="{{ route('home') }}" class="wz-sidebar-logo">Gabo<span>Plex</span></a>
    <a href="{{ route('annonces.index') }}" class="wz-sidebar-back">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Retour
    </a>
    <div class="wz-sidebar-content">
        <div class="wz-sidebar-steps" id="wzSidebarSteps">
            <div class="wz-ss-item"><div class="wz-ss-num ss-active" id="wss-1">1</div><span class="wz-ss-lbl ss-active" id="wssl-1">Type &amp; localisation</span></div>
            <div class="wz-ss-item"><div class="wz-ss-num ss-todo" id="wss-2">2</div><span class="wz-ss-lbl ss-todo" id="wssl-2">Détails du bien</span></div>
            <div class="wz-ss-item"><div class="wz-ss-num ss-todo" id="wss-3">3</div><span class="wz-ss-lbl ss-todo" id="wssl-3">Contact &amp; WhatsApp</span></div>
            <div class="wz-ss-item"><div class="wz-ss-num ss-todo" id="wss-4">4</div><span class="wz-ss-lbl ss-todo" id="wssl-4">Photos</span></div>
            <div class="wz-ss-item"><div class="wz-ss-num ss-todo" id="wss-5">5</div><span class="wz-ss-lbl ss-todo" id="wssl-5">Offre &amp; paiement</span></div>
            <div class="wz-ss-item"><div class="wz-ss-num ss-todo" id="wss-6">6</div><span class="wz-ss-lbl ss-todo" id="wssl-6">Récapitulatif</span></div>
        </div>
        <div class="wz-sidebar-tip" id="wzSidebarTip">
            <strong>Conseil</strong> — Choisissez le bon type d'annonce pour toucher les bons acheteurs ou locataires.
        </div>
    </div>
</div>

<!-- ══ CONTENU PRINCIPAL ══ -->
<div class="wz-main">
<div class="wz-wrap">

        <!-- STEPPER MOBILE (caché sur desktop) -->
        <div class="wz-stepper" style="display:none" id="wzStepperMobile">
            <div class="wz-step-item"><div class="wz-sc active" id="wsc-1">1</div><span class="wz-sl active" id="wsl-1">Type</span></div>
            <div class="wz-line" id="wline-1"></div>
            <div class="wz-step-item"><div class="wz-sc" id="wsc-2">2</div><span class="wz-sl" id="wsl-2">Détails</span></div>
            <div class="wz-line" id="wline-2"></div>
            <div class="wz-step-item"><div class="wz-sc" id="wsc-3">3</div><span class="wz-sl" id="wsl-3">Contact</span></div>
            <div class="wz-line" id="wline-3"></div>
            <div class="wz-step-item"><div class="wz-sc" id="wsc-4">4</div><span class="wz-sl" id="wsl-4">Photos</span></div>
            <div class="wz-line" id="wline-4"></div>
            <div class="wz-step-item"><div class="wz-sc" id="wsc-5">5</div><span class="wz-sl" id="wsl-5">Offre</span></div>
            <div class="wz-line" id="wline-5"></div>
            <div class="wz-step-item"><div class="wz-sc" id="wsc-6">6</div><span class="wz-sl" id="wsl-6">Récap</span></div>
        </div>

        @if($aDejaGratuite)
            <div class="wz-alert-warn" style="margin-bottom:1rem">
                <span>⚠️</span>
                <div><strong>Annonce gratuite déjà utilisée.</strong> Choisissez une offre payante à l'étape 5.</div>
            </div>
        @endif

        <form method="POST" action="{{ route('annonces.store') }}" enctype="multipart/form-data" id="wzForm">
            @csrf

            <!-- ══ ÉTAPE 1 ══ -->
            <div class="wz-card wz-panel active" id="wp-1">
                <div class="wz-hero"><div class="wz-hero-img wz-hero-1"></div><div class="wz-hero-overlay"></div><div class="wz-hero-content"><div class="wz-hero-title">Type d'annonce</div><div class="wz-hero-sub">Étape 1 / 6 — Que souhaitez-vous publier ?</div></div></div>
                <div class="wz-body">
                    <div class="wz-types">
                        <div><input type="radio" name="type" value="location" id="wt-loc" class="wz-type-radio" {{ old('type','location')==='location'?'checked':'' }} required><label for="wt-loc" class="wz-type-lbl"><span class="wz-type-icon">🏠</span><span class="wz-type-name">Location</span><span class="wz-type-sub">Appartement, maison</span></label></div>
                        <div><input type="radio" name="type" value="vente_maison" id="wt-vm" class="wz-type-radio" {{ old('type')==='vente_maison'?'checked':'' }}><label for="wt-vm" class="wz-type-lbl"><span class="wz-type-icon">🏡</span><span class="wz-type-name">Vente</span><span class="wz-type-sub">Maison, villa</span></label></div>
                        <div><input type="radio" name="type" value="commerce" id="wt-co" class="wz-type-radio" {{ old('type')==='commerce'?'checked':'' }}><label for="wt-co" class="wz-type-lbl"><span class="wz-type-icon">🏢</span><span class="wz-type-name">Commerce</span><span class="wz-type-sub">Bureau, boutique</span></label></div>
                    </div>

                    <div id="st-loc" style="display:none" class="wz-group"><label class="wz-label">Type de location</label><select name="sous_type_loc" class="wz-select"><option value="">-- Choisir --</option><option value="appartement" {{ old('sous_type')==='appartement'?'selected':'' }}>Appartement</option><option value="maison" {{ old('sous_type')==='maison'?'selected':'' }}>Maison / Villa</option><option value="studio" {{ old('sous_type')==='studio'?'selected':'' }}>Studio</option><option value="chambre" {{ old('sous_type')==='chambre'?'selected':'' }}>Chambre</option></select></div>
                    <div id="st-vm" style="display:none" class="wz-group"><label class="wz-label">Type de bien</label><select name="sous_type_vente" class="wz-select"><option value="">-- Choisir --</option><option value="maison" {{ old('sous_type')==='maison'?'selected':'' }}>Maison / Villa</option><option value="immeuble" {{ old('sous_type')==='immeuble'?'selected':'' }}>Immeuble</option></select></div>
                    <div id="st-co" style="display:none" class="wz-group"><label class="wz-label">Type de local</label><select name="sous_type_com" class="wz-select"><option value="">-- Choisir --</option><option value="bureau" {{ old('sous_type')==='bureau'?'selected':'' }}>Bureau</option><option value="boutique" {{ old('sous_type')==='boutique'?'selected':'' }}>Boutique</option><option value="entrepot" {{ old('sous_type')==='entrepot'?'selected':'' }}>Entrepôt</option><option value="restaurant" {{ old('sous_type')==='restaurant'?'selected':'' }}>Restaurant / Maquis</option></select></div>
                    <input type="hidden" name="sous_type" id="wzSousType">

                    <div class="wz-row">
                        <div class="wz-group"><label class="wz-label">Ville <em>*</em></label><select name="ville" class="wz-select" required><option value="">-- Choisir --</option>@foreach(['Libreville','Port-Gentil','Franceville','Oyem','Moanda','Lambaréné','Tchibanga'] as $v)<option value="{{ $v }}" {{ old('ville','Libreville')===$v?'selected':'' }}>{{ $v }}</option>@endforeach</select></div>
                        <div class="wz-group"><label class="wz-label">Quartier <em>*</em></label><input type="text" name="quartier" class="wz-input" placeholder="Ex: Batterie IV, Akanda..." value="{{ old('quartier') }}" required></div>
                    </div>
                </div>
                <div class="wz-footer"><div></div><button type="button" class="wz-btn-next" onclick="wzGo(2)">Suivant <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg></button></div>
            </div>

            <!-- ══ ÉTAPE 2 ══ -->
            <div class="wz-card wz-panel" id="wp-2">
                <div class="wz-hero"><div class="wz-hero-img wz-hero-2"></div><div class="wz-hero-overlay"></div><div class="wz-hero-content"><div class="wz-hero-title">Informations du bien</div><div class="wz-hero-sub">Étape 2 / 6 — Décrivez votre bien</div></div></div>
                <div class="wz-body">
                    <div class="wz-group"><label class="wz-label">Titre <em>*</em></label><input type="text" name="titre" class="wz-input" placeholder="Ex: Belle villa F4 à Batterie IV" value="{{ old('titre') }}" required></div>
                    <div class="wz-group"><label class="wz-label">Description <em>*</em></label><textarea name="description" class="wz-textarea" placeholder="Décrivez le bien : pièces, état, équipements...">{{ old('description') }}</textarea></div>
                    <div class="wz-row">
                        <div class="wz-group"><label class="wz-label">Prix (FCFA) <em>*</em></label><input type="number" name="prix" class="wz-input" placeholder="Ex: 150 000" value="{{ old('prix') }}" min="0" required></div>
                        <div class="wz-group"><label class="wz-label">Superficie (m²)</label><input type="number" name="superficie" class="wz-input" placeholder="Ex: 120" value="{{ old('superficie') }}" min="0"></div>
                    </div>
                    <div class="wz-row">
                        <div class="wz-group"><label class="wz-label">Chambres</label><select name="nb_chambres" class="wz-select"><option value="">--</option>@for($i=1;$i<=10;$i++)<option value="{{ $i }}" {{ old('nb_chambres')==$i?'selected':'' }}>{{ $i }}</option>@endfor</select></div>
                        <div class="wz-group"><label class="wz-label">Salles de bain</label><select name="nb_sdb" class="wz-select"><option value="">--</option>@for($i=1;$i<=5;$i++)<option value="{{ $i }}" {{ old('nb_sdb')==$i?'selected':'' }}>{{ $i }}</option>@endfor</select></div>
                    </div>
                    <div class="wz-group"><label class="wz-label">État du bien</label><select name="etat_bien" class="wz-select"><option value="">-- Choisir --</option><option value="neuf" {{ old('etat_bien')==='neuf'?'selected':'' }}>Neuf</option><option value="bon_etat" {{ old('etat_bien')==='bon_etat'?'selected':'' }}>Bon état</option><option value="a_renover" {{ old('etat_bien')==='a_renover'?'selected':'' }}>À rénover</option></select></div>
                    <div class="wz-group">
                        <label class="wz-label">Options</label>
                        <div class="wz-pills">
                            <input type="checkbox" name="meuble" value="1" id="wpm" class="wz-pill-chk" {{ old('meuble')?'checked':'' }}><label for="wpm" class="wz-pill-lbl">Meublé</label>
                            <input type="checkbox" name="parking" value="1" id="wpp" class="wz-pill-chk" {{ old('parking')?'checked':'' }}><label for="wpp" class="wz-pill-lbl">Parking</label>
                            <input type="checkbox" name="titre_foncier" value="1" id="wptf" class="wz-pill-chk" {{ old('titre_foncier')?'checked':'' }}><label for="wptf" class="wz-pill-lbl" id="lbl-tf">Titre foncier</label>
                            <input type="checkbox" name="prix_negotiable" value="1" id="wpn" class="wz-pill-chk" {{ old('prix_negotiable')?'checked':'' }}><label for="wpn" class="wz-pill-lbl" id="lbl-neg">Prix négociable</label>
                            <input type="checkbox" name="charges_incluses" value="1" id="wpc" class="wz-pill-chk" {{ old('charges_incluses')?'checked':'' }}><label for="wpc" class="wz-pill-lbl" id="lbl-charges">Charges incluses</label>
                        </div>
                    </div>
                    <div id="fields-loc" style="display:none">
                        <div class="wz-row">
                            <div class="wz-group"><label class="wz-label">Caution (FCFA)</label><input type="number" name="caution" class="wz-input" placeholder="Ex: 300 000" value="{{ old('caution') }}" min="0"></div>
                            <div class="wz-group"><label class="wz-label">Disponible le</label><input type="date" name="disponible_le" class="wz-input" value="{{ old('disponible_le') }}"></div>
                        </div>
                    </div>
                    <div class="wz-group">
                        <label class="wz-label">Position GPS <span style="color:#94a3b8;text-transform:none;font-weight:400">(optionnel)</span></label>
                        <div class="wz-map-hint"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg> Cliquez sur la carte pour placer votre bien</div>
                        <div id="wz-map-container"></div>
                        <input type="hidden" name="latitude" id="wzLat">
                        <input type="hidden" name="longitude" id="wzLng">
                    </div>
                </div>
                <div class="wz-footer"><button type="button" class="wz-btn-prev" onclick="wzGo(1)">← Retour</button><button type="button" class="wz-btn-next" onclick="wzGo(3)">Suivant <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg></button></div>
            </div>

            <!-- ══ ÉTAPE 3 ══ -->
            <div class="wz-card wz-panel" id="wp-3">
                <div class="wz-hero"><div class="wz-hero-img wz-hero-3"></div><div class="wz-hero-overlay"></div><div class="wz-hero-content"><div class="wz-hero-title">Informations de contact</div><div class="wz-hero-sub">Étape 3 / 6 — Comment vous contacter ?</div></div></div>
                <div class="wz-body">
                    <div class="wz-group"><label class="wz-label">Nom affiché</label><input type="text" name="nom_affiche" class="wz-input" placeholder="Votre nom ou agence" value="{{ old('nom_affiche', auth()->user()->name) }}"><div style="font-size:12px;color:#94a3b8;margin-top:4px">Laissez vide pour utiliser votre nom de compte</div></div>
                    <div class="wz-group">
                        <label class="wz-label">Numéro WhatsApp <em>*</em></label>
                        <div class="wz-wa-wrap">
                            <svg class="wz-wa-icon" viewBox="0 0 24 24" fill="#25D366"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            <input type="text" name="whatsapp" class="wz-input" placeholder="Ex: 077 123 456" value="{{ old('whatsapp', auth()->user()->whatsapp ?? '') }}" required>
                        </div>
                        <div class="wz-wa-note"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:1px"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg><span>Ce numéro doit avoir <strong>WhatsApp actif</strong>. Les contacts se feront via WhatsApp.</span></div>
                    </div>
                </div>
                <div class="wz-footer"><button type="button" class="wz-btn-prev" onclick="wzGo(2)">← Retour</button><button type="button" class="wz-btn-next" onclick="wzGo(4)">Suivant <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg></button></div>
            </div>

            <!-- ══ ÉTAPE 4 ══ -->
            <div class="wz-card wz-panel" id="wp-4">
                <div class="wz-hero"><div class="wz-hero-img wz-hero-4"></div><div class="wz-hero-overlay"></div><div class="wz-hero-content"><div class="wz-hero-title">Photos du bien</div><div class="wz-hero-sub">Étape 4 / 6 — Les photos font tout</div></div></div>
                <div class="wz-body">
                    <div class="wz-drop" id="wzDrop" onclick="document.getElementById('wzPhotosInput').click()">
                        <div class="wz-drop-icon">📸</div>
                        <div class="wz-drop-text">Glissez vos photos ici ou cliquez pour choisir</div>
                        <div class="wz-drop-sub">Max 10 photos · JPG, PNG · 2MB max par photo</div>
                    </div>
                    <input type="file" id="wzPhotosInput" multiple accept="image/*" style="display:none" onchange="wzAddPhotos(this)">
                    <div class="wz-photos-count" id="wzPhotosCount"></div>
                    <div class="wz-photos-preview" id="wzPhotosPreview"></div>
                    <div id="wzPhotosContainer"></div>
                </div>
                <div class="wz-footer"><button type="button" class="wz-btn-prev" onclick="wzGo(3)">← Retour</button><button type="button" class="wz-btn-next" onclick="wzGo(5)">Suivant <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg></button></div>
            </div>

            <!-- ══ ÉTAPE 5 ══ -->
            <div class="wz-card wz-panel" id="wp-5">
                <div class="wz-hero"><div class="wz-hero-img wz-hero-5"></div><div class="wz-hero-overlay"></div><div class="wz-hero-content"><div class="wz-hero-title">Choisissez votre offre</div><div class="wz-hero-sub">Étape 5 / 6 — Boostez votre visibilité</div></div></div>
                <div class="wz-body">
                    @if($aDejaGratuite)<div class="wz-alert-warn" style="margin-bottom:1.25rem"><span>⚠️</span><div>Votre annonce gratuite est déjà utilisée.</div></div>@endif
                    <div class="wz-offres">
                        <div><input type="radio" name="offre" value="gratuit" id="wo-gra" class="wz-offre-radio" {{ !$aDejaGratuite?'checked':'' }} {{ $aDejaGratuite?'disabled':'' }}><label for="wo-gra" class="wz-offre-lbl" style="{{ $aDejaGratuite?'opacity:.4;cursor:not-allowed':'' }}"><span class="wz-offre-badge ob-free">Gratuit</span><div class="wz-offre-icon">🆓</div><div class="wz-offre-name">Gratuit</div><div class="wz-offre-prix">0 FCFA</div><ul class="wz-offre-features"><li>1 annonce à vie</li><li>Visible après validation</li><li class="na">Ordre normal</li><li class="na">Pas de badge</li></ul></label></div>
                        <div><input type="radio" name="offre" value="boost_14j" id="wo-boo" class="wz-offre-radio" {{ $aDejaGratuite?'checked':'' }}><label for="wo-boo" class="wz-offre-lbl"><span class="wz-offre-badge ob-boost">⚡ Boost</span><div class="wz-offre-icon">🚀</div><div class="wz-offre-name">Boost 14 jours</div><div class="wz-offre-prix">2 000 <small>FCFA</small></div><ul class="wz-offre-features"><li>Badge doré "Boost"</li><li>Priorité résultats</li><li>Stats de vues</li><li>14 jours</li></ul></label></div>
                        <div><input type="radio" name="offre" value="premium_30j" id="wo-pre" class="wz-offre-radio"><label for="wo-pre" class="wz-offre-lbl"><span class="wz-offre-badge ob-premium">⭐ Premium</span><div class="wz-offre-icon">💎</div><div class="wz-offre-name">Premium 30 jours</div><div class="wz-offre-prix">5 000 <small>FCFA</small></div><ul class="wz-offre-features"><li>Badge bleu "Premium"</li><li>Tête de liste</li><li>Page d'accueil</li><li>Stats avancées · 30j</li></ul></label></div>
                        <div><input type="radio" name="offre" value="pass_annuel" id="wo-pro" class="wz-offre-radio"><label for="wo-pro" class="wz-offre-lbl"><span class="wz-offre-badge ob-pro">👑 Pro</span><div class="wz-offre-icon">🏆</div><div class="wz-offre-name">Pass Pro annuel</div><div class="wz-offre-prix">25 000 <small>FCFA/an</small></div><ul class="wz-offre-features"><li>Annonces illimitées</li><li>Badge "Pro" doré</li><li>Tout Premium inclus</li><li>1 an</li></ul></label></div>
                    </div>
                    <div id="wzPaySection" style="display:none">
                        <label class="wz-label" style="margin-bottom:10px">Mode de paiement</label>
                        <div class="wz-pay-methods">
                            <div><input type="radio" name="mode_paiement" value="airtel_money" id="wpm-a" class="wz-pay-radio" checked><label for="wpm-a" class="wz-pay-lbl"><svg class="wz-pay-logo" viewBox="0 0 40 24" style="width:48px;height:28px"><rect width="40" height="24" rx="4" fill="#FF0000"/><text x="20" y="11" font-family="Arial" font-weight="900" font-size="7" fill="white" text-anchor="middle">AIRTEL</text><text x="20" y="20" font-family="Arial" font-weight="700" font-size="6" fill="white" text-anchor="middle">MONEY</text></svg><span class="wz-pay-name">Airtel Money</span></label></div>
                            <div><input type="radio" name="mode_paiement" value="moov_money" id="wpm-m" class="wz-pay-radio"><label for="wpm-m" class="wz-pay-lbl"><svg class="wz-pay-logo" viewBox="0 0 40 24" style="width:48px;height:28px"><rect width="40" height="24" rx="4" fill="#0066CC"/><text x="20" y="11" font-family="Arial" font-weight="900" font-size="7" fill="white" text-anchor="middle">MOOV</text><text x="20" y="20" font-family="Arial" font-weight="700" font-size="6" fill="#FFD700" text-anchor="middle">MONEY</text></svg><span class="wz-pay-name">Moov Money</span></label></div>
                            <div><input type="radio" name="mode_paiement" value="carte" id="wpm-c" class="wz-pay-radio"><label for="wpm-c" class="wz-pay-lbl"><svg viewBox="0 0 48 28" style="width:54px;height:28px"><rect width="48" height="28" rx="4" fill="#1A1F71"/><text x="16" y="18" font-family="Arial" font-weight="900" font-size="10" fill="white" text-anchor="middle" font-style="italic">VISA</text><circle cx="36" cy="14" r="7" fill="#EB001B" opacity=".9"/><circle cx="43" cy="14" r="7" fill="#F79E1B" opacity=".9"/></svg><span class="wz-pay-name">Visa / Mastercard</span></label></div>
                        </div>
                        <div style="display:flex;align-items:center;gap:7px;margin-top:10px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;padding:9px 13px;font-size:12px;color:#166534"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>Paiement sécurisé via <strong style="margin-left:3px">CinetPay</strong></div>
                    </div>
                </div>
                <div class="wz-footer"><button type="button" class="wz-btn-prev" onclick="wzGo(4)">← Retour</button><button type="button" class="wz-btn-next" onclick="wzGo(6)">Suivant <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg></button></div>
            </div>

            <!-- ══ ÉTAPE 6 ══ -->
            <div class="wz-card wz-panel" id="wp-6">
                <div class="wz-hero"><div class="wz-hero-img wz-hero-6"></div><div class="wz-hero-overlay"></div><div class="wz-hero-content"><div class="wz-hero-title">Récapitulatif</div><div class="wz-hero-sub">Étape 6 / 6 — Vérifiez avant de soumettre</div></div></div>
                <div class="wz-body">
                    <div class="wz-recap-card" id="wzRecapInfos"></div>
                    <div class="wz-offre-recap" id="wzRecapOffre"></div>
                    <div id="wzRecapPayInfo" style="display:none" class="wz-pay-info"><span>💳</span><div>Après soumission, vous serez redirigé vers <strong>CinetPay</strong> pour finaliser le paiement.</div></div>
                    <div class="wz-spinner" id="wzSpinner"><div class="wz-spinner-ring"></div><div style="font-size:13px;color:#64748b;font-weight:600">Redirection vers CinetPay...</div></div>
                </div>
                <div class="wz-footer" id="wzRecapFooter">
                    <button type="button" class="wz-btn-prev" onclick="wzGo(5)">← Retour</button>
                    <button type="submit" class="wz-btn-submit" onclick="wzSubmit()">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg>
                        Soumettre l'annonce
                    </button>
                </div>
            </div>

        </form>
    </div>

    <!-- ══ GUIDE ══ -->
    <div class="wz-guide">
        <div class="wz-guide-card">
            <div class="wz-guide-step">Guide — Étape <span id="wzGuideNum">1</span> / 6</div>
            <div class="wz-guide-title" id="wzGuideTitle">Type & localisation</div>

            <div class="wz-guide-content active" id="wg-1">
                <div class="wz-guide-tip"><div class="wz-guide-dot"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg></div><div class="wz-guide-text"><strong>Location</strong> — Prix mensuel. Appartements, maisons, studios.</div></div>
                <div class="wz-guide-tip"><div class="wz-guide-dot"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg></div><div class="wz-guide-text"><strong>Vente</strong> — Prix de vente total. Maisons, villas, immeubles.</div></div>
                <div class="wz-guide-tip"><div class="wz-guide-dot"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/></svg></div><div class="wz-guide-text">Choisissez la <strong>ville et le quartier exact</strong> pour être trouvé facilement.</div></div>
            </div>
            <div class="wz-guide-content" id="wg-2">
                <div class="wz-guide-tip"><div class="wz-guide-dot"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="6" x2="20" y2="6"/><line x1="4" y1="12" x2="20" y2="12"/></svg></div><div class="wz-guide-text"><strong>Titre accrocheur</strong> — Ex: "Villa F4 avec jardin à Akanda".</div></div>
                <div class="wz-guide-tip"><div class="wz-guide-dot"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/></svg></div><div class="wz-guide-text"><strong>Prix en FCFA</strong> obligatoire. Cochez "Prix négociable" si vous acceptez les offres.</div></div>
                <div class="wz-guide-tip"><div class="wz-guide-dot"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13z"/></svg></div><div class="wz-guide-text">Placez un <strong>marqueur GPS</strong> pour apparaître dans la vue carte.</div></div>
            </div>
            <div class="wz-guide-content" id="wg-3">
                <div class="wz-guide-tip"><div class="wz-guide-dot"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div><div class="wz-guide-text"><strong>Nom affiché</strong> — Votre vrai nom ou celui de votre agence.</div></div>
                <div class="wz-guide-tip"><div class="wz-guide-dot"><svg viewBox="0 0 24 24" fill="none" stroke="#25D366" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07"/></svg></div><div class="wz-guide-text"><strong>WhatsApp obligatoire</strong> — Le numéro doit avoir WhatsApp actif.</div></div>
            </div>
            <div class="wz-guide-content" id="wg-4">
                <div class="wz-guide-tip"><div class="wz-guide-dot"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/></svg></div><div class="wz-guide-text"><strong>5+ photos</strong> = 5× plus de contacts. Première photo = photo principale.</div></div>
                <div class="wz-guide-tip"><div class="wz-guide-dot"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/></svg></div><div class="wz-guide-text">Prenez les photos en <strong>pleine journée</strong> avec bonne lumière.</div></div>
            </div>
            <div class="wz-guide-content" id="wg-5">
                <div class="wz-guide-tip"><div class="wz-guide-dot"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg></div><div class="wz-guide-text"><strong>Gratuit</strong> — 1 annonce à vie. Pour commencer sans frais.</div></div>
                <div class="wz-guide-tip"><div class="wz-guide-dot"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg></div><div class="wz-guide-text"><strong>Boost 2 000 FCFA</strong> — Tête de liste pendant 14 jours.</div></div>
                <div class="wz-guide-tip"><div class="wz-guide-dot"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg></div><div class="wz-guide-text"><strong>Pro 25 000 FCFA/an</strong> — Annonces illimitées. Meilleur rapport qualité/prix.</div></div>
            </div>
            <div class="wz-guide-content" id="wg-6">
                <div class="wz-guide-tip"><div class="wz-guide-dot"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg></div><div class="wz-guide-text">Vérifiez toutes les informations avant de soumettre.</div></div>
                <div class="wz-guide-tip"><div class="wz-guide-dot"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg></div><div class="wz-guide-text">Votre annonce sera <strong>validée sous 24h</strong> après paiement confirmé.</div></div>
            </div>

            <div class="wz-guide-progress">
                <div class="wz-guide-progress-lbl">Progression</div>
                <div class="wz-guide-bar"><div class="wz-guide-fill" id="wzGuideFill" style="width:16.6%"></div></div>
            </div>
        </div>
    </div>

</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>

<script>
var wzCur=1,wzMapInit=false,wzFiles=[];
var wzTitles=['','Type & localisation','Informations du bien','Contact WhatsApp','Photos du bien','Offre & paiement','Récapitulatif'];
var wzOffres={gratuit:{name:'Annonce gratuite',prix:'0 FCFA',icon:'🆓'},boost_14j:{name:'Boost 14 jours',prix:'2 000 FCFA',icon:'🚀'},premium_30j:{name:'Premium 30 jours',prix:'5 000 FCFA',icon:'💎'},pass_annuel:{name:'Pass Pro annuel',prix:'25 000 FCFA',icon:'👑'}};
var wzPayLabels={airtel_money:'Airtel Money',moov_money:'Moov Money',carte:'Visa/Mastercard'};

function wzUpdateSidebar(s){
    var tips=["Choisissez le bon type pour toucher les bons acheteurs.","Un titre précis et des photos de qualité multiplient les contacts.","Le numéro WhatsApp permet un contact direct avec les visiteurs.","Des photos de qualité multiplient par 3 les prises de contact.","L\'offre Boost ou Premium augmente fortement la visibilité.","Vérifiez toutes les informations avant de soumettre."];
    for(var i=1;i<=6;i++){var n=document.getElementById('wss-'+i),l=document.getElementById('wssl-'+i);if(!n||!l)continue;n.className='wz-ss-num '+(i<s?'ss-done':i===s?'ss-active':'ss-todo');l.className='wz-ss-lbl '+(i<s?'ss-done':i===s?'ss-active':'ss-todo');n.innerHTML=i<s?'✓':String(i);}
    var t=document.getElementById('wzSidebarTip');if(t)t.innerHTML='<strong>Conseil</strong> — '+tips[s-1];
}
function wzGo(n){wzUpdateSidebar(n);
    if(n>wzCur&&!wzValidate(wzCur))return;
    var prev=wzCur;
    document.getElementById('wp-'+prev).classList.remove('active');
    var sc=document.getElementById('wsc-'+prev);
    sc.classList.remove('active');sc.classList.add('done');sc.textContent='✓';
    document.getElementById('wsl-'+prev).classList.remove('active');document.getElementById('wsl-'+prev).classList.add('done');
    if(prev<6)document.getElementById('wline-'+prev).classList.add('done');
    wzCur=n;
    document.getElementById('wp-'+n).classList.add('active');
    document.getElementById('wsc-'+n).classList.remove('done');document.getElementById('wsc-'+n).classList.add('active');document.getElementById('wsc-'+n).textContent=n;
    document.getElementById('wsl-'+n).classList.remove('done');document.getElementById('wsl-'+n).classList.add('active');
    document.querySelectorAll('.wz-guide-content').forEach(function(g){g.classList.remove('active')});
    document.getElementById('wg-'+n).classList.add('active');
    document.getElementById('wzGuideNum').textContent=n;
    document.getElementById('wzGuideTitle').textContent=wzTitles[n];
    document.getElementById('wzGuideFill').style.width=(n/6*100)+'%';
    if(n===2&&!wzMapInit)wzInitMap();
    if(n===5)wzUpdatePay();
    if(n===6)wzFillRecap();
    window.scrollTo({top:0,behavior:'smooth'});
}

function wzValidate(n){
    if(n===1){
        if(!document.querySelector('input[name="type"]:checked')){alert('Choisissez un type d\'annonce.');return false}
        if(!document.querySelector('select[name="ville"]').value){alert('Choisissez une ville.');return false}
        if(!document.querySelector('input[name="quartier"]').value.trim()){alert('Saisissez un quartier.');return false}
        wzConsolideSousType();
    }
    if(n===2){
        if(!document.querySelector('input[name="titre"]').value.trim()){alert('Saisissez un titre.');return false}
        if(!document.querySelector('textarea[name="description"]').value.trim()){alert('Saisissez une description.');return false}
        if(!document.querySelector('input[name="prix"]').value){alert('Saisissez un prix.');return false}
    }
    if(n===3){if(!document.querySelector('input[name="whatsapp"]').value.trim()){alert('Saisissez votre numéro WhatsApp.');return false}}
    if(n===5){
        var o=document.querySelector('input[name="offre"]:checked');
        if(!o){alert('Choisissez une offre.');return false}
        if({{ $aDejaGratuite?'true':'false' }}&&o.value==='gratuit'){alert('Choisissez une offre payante.');return false}
    }
    return true;
}

function wzConsolideSousType(){
    var t=document.querySelector('input[name="type"]:checked')?.value||'';
    var v='';
    if(t==='location')v=document.querySelector('select[name="sous_type_loc"]').value;
    else if(t==='vente_maison')v=document.querySelector('select[name="sous_type_vente"]').value;
    else if(t==='commerce')v=document.querySelector('select[name="sous_type_com"]').value;
    document.getElementById('wzSousType').value=v;
}

function wzUpdateSousType(){
    var t=document.querySelector('input[name="type"]:checked')?.value||'';
    document.getElementById('st-loc').style.display=t==='location'?'block':'none';
    document.getElementById('st-vm').style.display=t==='vente_maison'?'block':'none';
    document.getElementById('st-co').style.display=t==='commerce'?'block':'none';
    document.getElementById('fields-loc').style.display=t==='location'?'block':'none';
    document.getElementById('lbl-tf').style.display=t==='vente_maison'?'inline-flex':'none';
    document.getElementById('lbl-neg').style.display=t!=='location'?'inline-flex':'none';
    document.getElementById('lbl-charges').style.display=t==='location'?'inline-flex':'none';
}
document.querySelectorAll('input[name="type"]').forEach(function(r){r.addEventListener('change',wzUpdateSousType)});
wzUpdateSousType();

function wzUpdatePay(){
    var o=document.querySelector('input[name="offre"]:checked')?.value||'';
    document.getElementById('wzPaySection').style.display=o==='gratuit'?'none':'block';
}
document.querySelectorAll('input[name="offre"]').forEach(function(r){r.addEventListener('change',wzUpdatePay)});

function wzInitMap(){
    wzMapInit=true;
    setTimeout(function(){
        var c=L.map('wz-map-container').setView([0.4162,9.4673],12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{attribution:'© OpenStreetMap'}).addTo(c);
        var m=null;
        c.on('click',function(e){
            if(m)c.removeLayer(m);
            var ico=L.divIcon({html:'<div style="background:#2563eb;width:14px;height:14px;border-radius:50%;border:3px solid white;box-shadow:0 2px 6px rgba(0,0,0,.3)"></div>',iconSize:[20,20],iconAnchor:[10,10],className:''});
            m=L.marker(e.latlng,{icon:ico}).addTo(c);
            document.getElementById('wzLat').value=e.latlng.lat.toFixed(7);
            document.getElementById('wzLng').value=e.latlng.lng.toFixed(7);
        });
    },150);
}

var wzDrop=document.getElementById('wzDrop');
wzDrop.addEventListener('dragover',function(e){e.preventDefault();wzDrop.classList.add('dragover')});
wzDrop.addEventListener('dragleave',function(){wzDrop.classList.remove('dragover')});
wzDrop.addEventListener('drop',function(e){e.preventDefault();wzDrop.classList.remove('dragover');wzAddFiles(e.dataTransfer.files)});
function wzAddPhotos(inp){wzAddFiles(inp.files);inp.value=''}
function wzAddFiles(files){
    Array.from(files).forEach(function(f){
        if(wzFiles.length>=10)return;
        if(!wzFiles.some(function(x){return x.name===f.name&&x.size===f.size}))wzFiles.push(f);
    });
    wzRenderPhotos();
}
function wzDelPhoto(i){wzFiles.splice(i,1);wzRenderPhotos()}
function wzRenderPhotos(){
    var prev=document.getElementById('wzPhotosPreview'),cnt=document.getElementById('wzPhotosCount');
    prev.innerHTML='';cnt.textContent=wzFiles.length?wzFiles.length+' photo(s) sélectionnée(s)':'';
    wzFiles.forEach(function(f,i){
        var r=new FileReader();r.onload=function(e){
            var d=document.createElement('div');d.className='wz-thumb';
            d.innerHTML='<img src="'+e.target.result+'" alt=""><button type="button" class="wz-thumb-del" onclick="wzDelPhoto('+i+')">×</button><span class="wz-thumb-num">'+(i+1)+'</span>';
            prev.appendChild(d);
        };r.readAsDataURL(f);
    });
    var c=document.getElementById('wzPhotosContainer');c.innerHTML='';
    var inp=document.createElement('input');inp.type='file';inp.name='photos[]';inp.multiple=true;inp.style.display='none';c.appendChild(inp);
    var dt=new DataTransfer();wzFiles.forEach(function(f){dt.items.add(f)});inp.files=dt.files;
}

function wzFillRecap(){
    var t=document.querySelector('input[name="type"]:checked')?.value||'';
    var v=document.querySelector('select[name="ville"]').value;
    var q=document.querySelector('input[name="quartier"]').value;
    var ti=document.querySelector('input[name="titre"]').value;
    var p=document.querySelector('input[name="prix"]').value;
    var wa=document.querySelector('input[name="whatsapp"]').value;
    var o=document.querySelector('input[name="offre"]:checked')?.value||'gratuit';
    var mp=document.querySelector('input[name="mode_paiement"]:checked')?.value||'';
    var tl={location:'Location',vente_maison:'Vente',commerce:'Commerce'};
    document.getElementById('wzRecapInfos').innerHTML=
        wR('Type',tl[t]||t)+wR('Localisation',q+', '+v)+wR('Titre',ti)+
        wR('Prix',parseInt(p||0).toLocaleString('fr-FR')+' FCFA')+
        wR('WhatsApp',wa)+wR('Photos',wzFiles.length+' photo(s)');
    var of=wzOffres[o]||wzOffres.gratuit;
    document.getElementById('wzRecapOffre').innerHTML='<span style="font-size:1.5rem;flex-shrink:0">'+of.icon+'</span><div><div style="font-size:14px;font-weight:700;color:#0a2540">'+of.name+'</div><div style="font-size:13px;font-weight:700;color:#2563eb">'+of.prix+(o!=='gratuit'?' · '+(wzPayLabels[mp]||''):'')+'</div></div>';
    document.getElementById('wzRecapPayInfo').style.display=o!=='gratuit'?'flex':'none';
}
function wR(k,v){return'<div class="wz-recap-row"><span class="wz-recap-key">'+k+'</span><span class="wz-recap-val">'+v+'</span></div>'}

function wzSubmit(){
    var o=document.querySelector('input[name="offre"]:checked')?.value||'gratuit';
    if(o!=='gratuit'){document.getElementById('wzRecapFooter').style.display='none';document.getElementById('wzSpinner').style.display='block'}
}
</script>

</div>{{-- /wz-wrap --}}
</div>{{-- /wz-main --}}
</div>{{-- /wz-page --}}

@endsection