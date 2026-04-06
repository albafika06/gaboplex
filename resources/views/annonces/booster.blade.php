@extends('layouts.app')
@section('title', 'Booster mon annonce — GaboPlex')
@section('content')
<style>
.bst-wrap{max-width:820px;margin:2.5rem auto;padding:0 1.5rem}
.bst-back{display:inline-flex;align-items:center;gap:6px;color:#64748b;text-decoration:none;font-size:13px;margin-bottom:1.5rem;font-weight:500;transition:color .2s}
.bst-back:hover{color:#0a2540}
.bst-header{margin-bottom:2rem}
.bst-header h1{font-size:22px;font-weight:800;color:#0a2540;letter-spacing:-.5px;margin-bottom:6px}
.bst-header p{font-size:14px;color:#64748b}

/* ANNONCE PREVIEW */
.bst-preview{background:white;border:1px solid #e8edf2;border-radius:14px;padding:1.25rem;margin-bottom:2rem;display:flex;gap:1rem;align-items:center}
.bst-preview-img{width:90px;height:70px;border-radius:8px;background:#f1f5f9;overflow:hidden;flex-shrink:0;display:flex;align-items:center;justify-content:center}
.bst-preview-img img{width:100%;height:100%;object-fit:cover}
.bst-preview-type{padding:2px 9px;border-radius:20px;font-size:11px;font-weight:700;color:white;margin-bottom:5px;display:inline-block}
.bst-preview-title{font-size:15px;font-weight:700;color:#0a2540}
.bst-preview-loc{font-size:12px;color:#94a3b8;margin-top:2px}
.bst-preview-price{font-size:16px;font-weight:800;color:#2563eb;margin-left:auto;white-space:nowrap;flex-shrink:0}

/* OFFRES */
.bst-offres-title{font-size:15px;font-weight:700;color:#0a2540;margin-bottom:1rem}
.bst-offres{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:2rem}
.bst-offre-radio{display:none}
.bst-offre-lbl{display:block;border:1.5px solid #e2e8f0;border-radius:14px;padding:1.25rem;cursor:pointer;transition:all .2s;position:relative}
.bst-offre-radio:checked + .bst-offre-lbl{border-color:#2563eb;background:#f0f7ff}
.bst-offre-lbl:hover{border-color:#93c5fd}
.bst-offre-badge{display:inline-block;padding:2px 8px;border-radius:20px;font-size:10px;font-weight:800;margin-bottom:10px}
.ob-boost{background:#fef9c3;color:#a16207}
.ob-premium{background:#eff6ff;color:#1d4ed8}
.ob-pro{background:#0a2540;color:#ffd700}
.bst-offre-icon{font-size:1.6rem;margin-bottom:8px}
.bst-offre-name{font-size:15px;font-weight:800;color:#0a2540;margin-bottom:4px}
.bst-offre-prix{font-size:1.1rem;font-weight:800;color:#2563eb;margin-bottom:10px}
.bst-offre-prix small{font-size:12px;color:#94a3b8;font-weight:400}
.bst-offre-features{list-style:none;padding:0}
.bst-offre-features li{font-size:12px;color:#475569;padding:3px 0;display:flex;align-items:center;gap:6px}
.bst-offre-features li::before{content:'✓';color:#059669;font-weight:700;flex-shrink:0}
.bst-pop-badge{position:absolute;top:-10px;left:50%;transform:translateX(-50%);background:#2563eb;color:white;padding:3px 12px;border-radius:20px;font-size:11px;font-weight:700;white-space:nowrap}

/* PAIEMENT */
.bst-pay-title{font-size:15px;font-weight:700;color:#0a2540;margin-bottom:1rem}
.bst-pay-methods{display:grid;grid-template-columns:repeat(3,1fr);gap:10px;margin-bottom:2rem}
.bst-pay-radio{display:none}
.bst-pay-lbl{display:flex;flex-direction:column;align-items:center;gap:6px;padding:1rem;border:1.5px solid #e2e8f0;border-radius:12px;cursor:pointer;transition:all .2s;text-align:center}
.bst-pay-radio:checked + .bst-pay-lbl{border-color:#2563eb;background:#eff6ff}
.bst-pay-lbl:hover{border-color:#93c5fd}
.bst-pay-logo{width:48px;height:28px;display:flex;align-items:center;justify-content:center}
.bst-pay-name{font-size:12px;font-weight:700;color:#374151}
.bst-pay-sub{font-size:10px;color:#94a3b8}

/* TOTAL */
.bst-total{background:#f8fafc;border:1px solid #e8edf2;border-radius:12px;padding:1.25rem;margin-bottom:1.5rem}
.bst-total-row{display:flex;justify-content:space-between;font-size:14px;color:#475569;padding:5px 0;border-bottom:1px solid #f1f5f9}
.bst-total-row:last-child{border-bottom:none;font-weight:800;font-size:16px;color:#0a2540;padding-top:10px;margin-top:4px;border-top:2px solid #e2e8f0}
.bst-submit{width:100%;background:#0a2540;color:white;border:none;padding:15px;border-radius:12px;font-size:15px;font-weight:700;cursor:pointer;transition:background .2s;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif;display:flex;align-items:center;justify-content:center;gap:8px}
.bst-submit:hover{background:#0f3460}
.bst-info{background:#eff6ff;border:1px solid #bfdbfe;border-radius:10px;padding:12px 14px;font-size:13px;color:#1e40af;margin-bottom:1.5rem;display:flex;gap:8px;align-items:flex-start}

@media(max-width:640px){.bst-offres{grid-template-columns:1fr}.bst-pay-methods{grid-template-columns:1fr}.bst-wrap{padding:1rem}}
</style>

<div class="bst-wrap">
    <a href="{{ route('dashboard') }}" class="bst-back">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Retour au dashboard
    </a>

    <div class="bst-header">
        <h1>Booster mon annonce</h1>
        <p>Augmentez la visibilité de votre annonce avec une offre payante</p>
    </div>

    <!-- APERÇU ANNONCE -->
    <div class="bst-preview">
        @php $photo = $annonce->photos->first(); @endphp
        <div class="bst-preview-img">
            @if($photo)
                <img src="{{ str_starts_with($photo->url, 'http') ? $photo->url : asset('storage/'.$photo->url) }}" alt="{{ $annonce->titre }}">
            @else
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="3"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
            @endif
        </div>
        <div>
            @php $typeLabel = match($annonce->type){'location'=>'Location','vente_maison'=>'Vente','vente_terrain'=>'Terrain','commerce'=>'Commerce',default=>$annonce->type}; @endphp
            <span class="bst-preview-type badge-{{ $annonce->type }}">{{ $typeLabel }}</span>
            <div class="bst-preview-title">{{ $annonce->titre }}</div>
            <div class="bst-preview-loc">📍 {{ $annonce->quartier }}, {{ $annonce->ville }}</div>
        </div>
        <div class="bst-preview-price">
            {{ number_format($annonce->prix,0,',',' ') }} FCFA
            @if($annonce->type === 'location')<small style="font-size:11px;color:#94a3b8;font-weight:400">/mois</small>@endif
        </div>
    </div>

    <form method="POST" action="{{ route('annonces.booster.pay', $annonce) }}" id="bstForm">
        @csrf

        <!-- CHOIX OFFRE -->
        <div class="bst-offres-title">Choisissez votre offre</div>
        <div class="bst-offres">
            <div>
                <input type="radio" name="offre" value="boost_14j" id="bo1" class="bst-offre-radio" checked>
                <label for="bo1" class="bst-offre-lbl">
                    <span class="bst-offre-badge ob-boost">🚀 Boost</span>
                    <div class="bst-offre-name">Boost</div>
                    <div class="bst-offre-prix">2 000 <small>FCFA</small></div>
                    <ul class="bst-offre-features">
                        <li>Badge doré "Boost"</li>
                        <li>Priorité dans les résultats</li>
                        <li>Stats de vues</li>
                        <li>Valable 14 jours</li>
                    </ul>
                </label>
            </div>
            <div style="position:relative">
                <input type="radio" name="offre" value="premium_30j" id="bo2" class="bst-offre-radio">
                <label for="bo2" class="bst-offre-lbl">
                    <span class="bst-pop-badge">⭐ Populaire</span>
                    <span class="bst-offre-badge ob-premium">💎 Premium</span>
                    <div class="bst-offre-name">Premium</div>
                    <div class="bst-offre-prix">5 000 <small>FCFA</small></div>
                    <ul class="bst-offre-features">
                        <li>Badge bleu "Premium"</li>
                        <li>Tête de liste garantie</li>
                        <li>Page d'accueil</li>
                        <li>Stats avancées · 30j</li>
                    </ul>
                </label>
            </div>
            <div>
                <input type="radio" name="offre" value="pass_annuel" id="bo3" class="bst-offre-radio">
                <label for="bo3" class="bst-offre-lbl">
                    <span class="bst-offre-badge ob-pro">👑 Pro</span>
                    <div class="bst-offre-name">Pro annuel</div>
                    <div class="bst-offre-prix">25 000 <small>FCFA/an</small></div>
                    <ul class="bst-offre-features">
                        <li>Annonces illimitées</li>
                        <li>Badge "Pro" doré</li>
                        <li>Tout Premium inclus</li>
                        <li>Valable 1 an</li>
                    </ul>
                </label>
            </div>
        </div>

        <!-- MODE DE PAIEMENT -->
        <div class="bst-pay-title">Mode de paiement</div>
        <div class="bst-pay-methods">
            <div>
                <input type="radio" name="mode_paiement" value="airtel_money" id="bpm1" class="bst-pay-radio" checked>
                <label for="bpm1" class="bst-pay-lbl">
                    <div class="bst-pay-logo">
                        <svg viewBox="0 0 60 28" width="48" height="24" xmlns="http://www.w3.org/2000/svg">
                            <rect width="60" height="28" rx="4" fill="#E4002B"/>
                            <text x="30" y="19" text-anchor="middle" fill="white" font-size="10" font-family="Arial" font-weight="bold">AIRTEL</text>
                        </svg>
                    </div>
                    <div class="bst-pay-name">Airtel Money</div>
                    <div class="bst-pay-sub">Gabon · Immédiat</div>
                </label>
            </div>
            <div>
                <input type="radio" name="mode_paiement" value="moov_money" id="bpm2" class="bst-pay-radio">
                <label for="bpm2" class="bst-pay-lbl">
                    <div class="bst-pay-logo">
                        <svg viewBox="0 0 60 28" width="48" height="24" xmlns="http://www.w3.org/2000/svg">
                            <rect width="60" height="28" rx="4" fill="#00A651"/>
                            <text x="30" y="19" text-anchor="middle" fill="white" font-size="10" font-family="Arial" font-weight="bold">MOOV</text>
                        </svg>
                    </div>
                    <div class="bst-pay-name">Moov Money</div>
                    <div class="bst-pay-sub">Gabon · Immédiat</div>
                </label>
            </div>
            <div>
                <input type="radio" name="mode_paiement" value="carte" id="bpm3" class="bst-pay-radio">
                <label for="bpm3" class="bst-pay-lbl">
                    <div class="bst-pay-logo">
                        <svg viewBox="0 0 60 28" width="48" height="24" xmlns="http://www.w3.org/2000/svg">
                            <rect width="60" height="28" rx="4" fill="#1A1F71"/>
                            <text x="30" y="19" text-anchor="middle" fill="white" font-size="10" font-family="Arial" font-weight="bold">VISA</text>
                        </svg>
                    </div>
                    <div class="bst-pay-name">Visa / Mastercard</div>
                    <div class="bst-pay-sub">Carte bancaire</div>
                </label>
            </div>
        </div>

        <!-- TOTAL -->
        <div class="bst-total">
            <div class="bst-total-row"><span>Offre sélectionnée</span><span id="bstOffreName">Boost 14 jours</span></div>
            <div class="bst-total-row"><span>Durée</span><span id="bstDuree">14 jours</span></div>
            <div class="bst-total-row"><span>Total à payer</span><span id="bstTotal">2 000 FCFA</span></div>
        </div>

        <div class="bst-info">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:1px"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            Vous serez redirigé vers CinetPay pour finaliser le paiement de manière sécurisée. Votre annonce sera boostée immédiatement après confirmation.
        </div>

        <button type="submit" class="bst-submit">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            Payer et booster maintenant
        </button>
    </form>
</div>

<script>
var offres = {
    'boost_14j':   {name:'Boost 14 jours', duree:'14 jours', prix:'2 000 FCFA'},
    'premium_30j': {name:'Premium 30 jours', duree:'30 jours', prix:'5 000 FCFA'},
    'pass_annuel': {name:'Pro annuel', duree:'1 an', prix:'25 000 FCFA'},
};
document.querySelectorAll('input[name="offre"]').forEach(function(r){
    r.addEventListener('change', function(){
        var o = offres[this.value];
        if (o) {
            document.getElementById('bstOffreName').textContent = o.name;
            document.getElementById('bstDuree').textContent = o.duree;
            document.getElementById('bstTotal').textContent = o.prix;
        }
    });
});
</script>
@endsection