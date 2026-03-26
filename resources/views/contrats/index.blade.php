@extends('layouts.app')
@section('title', 'Mes contrats')
@section('content')
<style>
.ct-wrap{max-width:1100px;margin:0 auto;padding:1.75rem 1.5rem}
.ct-header{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:1.75rem;flex-wrap:wrap;gap:1rem}
.ct-header h1{font-size:20px;font-weight:700;color:#042C53;letter-spacing:-.5px}
.ct-header p{font-size:13px;color:#94a3b8;margin-top:2px;font-weight:400}

/* SCORE BOX */
.ct-score-box{background:white;border:0.5px solid #e8edf2;border-radius:14px;padding:1.25rem;margin-bottom:1.75rem;display:flex;align-items:center;gap:1.5rem;flex-wrap:wrap}
.ct-score-circle{width:72px;height:72px;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-direction:column;flex-shrink:0;border:3px solid #185FA5}
.ct-score-num{font-size:22px;font-weight:700;color:#042C53;line-height:1}
.ct-score-max{font-size:10px;color:#94a3b8;font-weight:400}
.ct-score-bar-wrap{flex:1;min-width:200px}
.ct-score-badge{display:inline-block;padding:3px 12px;border-radius:20px;font-size:12px;font-weight:600;margin-bottom:6px}
.ct-score-bar{height:6px;background:#f1f5f9;border-radius:3px;overflow:hidden;margin-bottom:6px}
.ct-score-bar-fill{height:100%;border-radius:3px;transition:width .8s ease}
.ct-score-desc{font-size:12px;color:#94a3b8}
.ct-score-history{flex:1;min-width:200px}
.ct-score-history-title{font-size:11px;font-weight:500;color:#94a3b8;text-transform:uppercase;letter-spacing:.4px;margin-bottom:.5rem}
.ct-score-event{display:flex;align-items:center;gap:8px;font-size:12px;padding:4px 0;border-bottom:0.5px solid #f1f5f9}
.ct-score-event:last-child{border-bottom:none}
.ct-score-pts{font-weight:600;min-width:40px;text-align:right;font-size:11px}

/* TABS */
.ct-tabs{display:flex;border-bottom:0.5px solid #e8edf2;margin-bottom:1.5rem}
.ct-tab{padding:9px 20px;font-size:13px;font-weight:500;color:#94a3b8;border:none;background:transparent;cursor:pointer;border-bottom:2px solid transparent;margin-bottom:-1px;transition:all .15s;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif;display:flex;align-items:center;gap:6px}
.ct-tab:hover{color:#042C53}
.ct-tab.active{color:#042C53;border-bottom-color:#042C53}
.ct-tab-badge{padding:1px 7px;border-radius:20px;font-size:10px;font-weight:600;background:#f1f5f9;color:#64748b}
.ct-tab.active .ct-tab-badge{background:#042C53;color:white}

/* LISTE */
.ct-list{display:flex;flex-direction:column;gap:10px}
.ct-card{background:white;border:0.5px solid #e8edf2;border-radius:12px;overflow:hidden;transition:box-shadow .2s}
.ct-card:hover{box-shadow:0 3px 16px rgba(0,0,0,.06)}
.ct-card-head{display:flex;align-items:center;gap:1rem;padding:1rem 1.25rem;border-bottom:0.5px solid #f8fafc;flex-wrap:wrap}
.ct-card-img{width:64px;height:52px;border-radius:8px;overflow:hidden;background:#f1f5f9;flex-shrink:0;display:flex;align-items:center;justify-content:center}
.ct-card-img img{width:100%;height:100%;object-fit:cover}
.ct-card-info{flex:1;min-width:0}
.ct-card-title{font-size:14px;font-weight:600;color:#042C53;margin-bottom:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.ct-card-sub{font-size:12px;color:#94a3b8}
.ct-card-status{padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;flex-shrink:0}
.s-actif{background:#EAF3DE;color:#27500A}
.s-en_attente{background:#FAEEDA;color:#633806}
.s-litige{background:#FCEBEB;color:#791F1F}
.s-termine{background:#f1f5f9;color:#64748b}
.s-annule{background:#f1f5f9;color:#64748b}
.ct-card-body{padding:1rem 1.25rem;display:grid;grid-template-columns:repeat(4,1fr);gap:.75rem}
@media(max-width:640px){.ct-card-body{grid-template-columns:1fr 1fr}}
.ct-kpi{background:#f8fafc;border-radius:8px;padding:.6rem .75rem}
.ct-kpi-lbl{font-size:10px;color:#94a3b8;text-transform:uppercase;letter-spacing:.3px;font-weight:500;margin-bottom:2px}
.ct-kpi-val{font-size:13px;font-weight:600;color:#042C53}
.ct-card-foot{display:flex;align-items:center;justify-content:space-between;padding:.75rem 1.25rem;border-top:0.5px solid #f8fafc;background:#fafbff;flex-wrap:wrap;gap:8px}
.ct-btn{padding:6px 14px;border-radius:7px;font-size:12px;font-weight:500;border:0.5px solid #e2e8f0;background:white;color:#475569;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:4px;transition:all .15s;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif}
.ct-btn:hover{border-color:#94a3b8;color:#042C53}
.ct-btn.primary{background:#042C53;color:white;border-color:#042C53}
.ct-btn.primary:hover{background:#185FA5;border-color:#185FA5}
.ct-btn.warn{background:#FAEEDA;color:#633806;border-color:#FAC775}
.ct-btn.danger{background:#FCEBEB;color:#791F1F;border-color:#F7C1C1}

/* ALERTE PAIEMENT */
.ct-alerte{background:#FAEEDA;border:0.5px solid #FAC775;border-radius:10px;padding:.75rem 1rem;margin-bottom:.75rem;display:flex;align-items:center;gap:8px;font-size:13px;color:#633806}
.ct-alerte.danger{background:#FCEBEB;border-color:#F7C1C1;color:#791F1F}
.ct-alerte.success{background:#EAF3DE;border-color:#C0DD97;color:#27500A}

/* EMPTY */
.ct-empty{text-align:center;padding:3rem 2rem;background:white;border:0.5px solid #e8edf2;border-radius:12px;color:#94a3b8}
.ct-empty h3{font-size:14px;color:#64748b;margin-bottom:6px;font-weight:600}
</style>

<div class="ct-wrap">
    <div class="ct-header">
        <div>
            <h1>Mes contrats</h1>
            <p>Suivi de vos locations et ventes en cours</p>
        </div>
    </div>

    <!-- SCORE BOX -->
    @php
        $user  = Auth::user();
        $score = $user->score ?? 30;
        $barColor = match(true) {
            $score >= 90 => '#042C53',
            $score >= 75 => '#185FA5',
            $score >= 60 => '#1D9E75',
            $score >= 40 => '#BA7517',
            default      => '#A32D2D',
        };
        $scoreDesc = match(true) {
            $score >= 90 => 'Profil Elite — accès à toutes les annonces',
            $score >= 75 => 'Profil de confiance — les propriétaires vous choisissent en premier',
            $score >= 60 => 'Profil fiable — badge visible sur vos messages',
            $score >= 40 => 'Profil actif — continuez à payer à temps pour monter',
            default      => 'Profil basique — complétez votre profil pour monter rapidement',
        };
    @endphp

    <div class="ct-score-box">
        <div class="ct-score-circle" style="border-color:{{ $barColor }}">
            <div class="ct-score-num" style="color:{{ $barColor }}">{{ $score }}</div>
            <div class="ct-score-max">/100</div>
        </div>
        <div class="ct-score-bar-wrap">
            <span class="ct-score-badge" style="background:{{ $badge['bg'] }};color:{{ $badge['color'] }}">{{ $badge['label'] }}</span>
            <div class="ct-score-bar">
                <div class="ct-score-bar-fill" style="width:{{ $score }}%;background:{{ $barColor }}"></div>
            </div>
            <div class="ct-score-desc">{{ $scoreDesc }}</div>
            @if($score < 60)
                <div style="font-size:11px;color:#185FA5;margin-top:5px">
                    → Payez votre prochain loyer via Airtel Money pour gagner +6 pts d'un coup
                </div>
            @endif
        </div>
        @if($scoreHistorique->isNotEmpty())
            <div class="ct-score-history">
                <div class="ct-score-history-title">Derniers mouvements</div>
                @foreach($scoreHistorique->take(5) as $evt)
                    <div class="ct-score-event">
                        <span style="flex:1;color:var(--color-text-secondary,#64748b)">{{ Str::limit($evt->detail ?? $evt->action, 32) }}</span>
                        <span class="ct-score-pts" style="color:{{ $evt->points >= 0 ? '#1D9E75' : '#A32D2D' }}">{{ $evt->points >= 0 ? '+' : '' }}{{ $evt->points }} pts</span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- TABS -->
    <div class="ct-tabs">
        <button class="ct-tab active" id="tabLoc" onclick="ctTab('loc', this)">
            En tant que locataire
            <span class="ct-tab-badge">{{ $contratsLocataire->count() }}</span>
        </button>
        <button class="ct-tab" id="tabProp" onclick="ctTab('prop', this)">
            En tant que propriétaire
            <span class="ct-tab-badge">{{ $contratsProprietaire->count() }}</span>
        </button>
    </div>

    <!-- PANEL LOCATAIRE -->
    <div id="panelLoc">
        @if($contratsLocataire->isEmpty())
            <div class="ct-empty">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" style="margin-bottom:.9rem"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                <h3>Aucun contrat de location</h3>
                <p style="font-size:12px;margin-bottom:1rem">Trouvez un logement et proposez un contrat au propriétaire</p>
                <a href="{{ route('annonces.location') }}" class="ct-btn primary">Chercher un logement</a>
            </div>
        @else
            <div class="ct-list">
                @foreach($contratsLocataire as $contrat)
                    @include('contrats._card', ['contrat' => $contrat, 'role' => 'locataire'])
                @endforeach
            </div>
        @endif
    </div>

    <!-- PANEL PROPRIÉTAIRE -->
    <div id="panelProp" style="display:none">
        @if($contratsProprietaire->isEmpty())
            <div class="ct-empty">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" style="margin-bottom:.9rem"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                <h3>Aucun contrat propriétaire</h3>
                <p style="font-size:12px">Vos contrats avec vos locataires apparaîtront ici</p>
            </div>
        @else
            <div class="ct-list">
                @foreach($contratsProprietaire as $contrat)
                    @include('contrats._card', ['contrat' => $contrat, 'role' => 'proprietaire'])
                @endforeach
            </div>
        @endif
    </div>
</div>

<script>
function ctTab(id, btn) {
    document.querySelectorAll('.ct-tab').forEach(function(b){ b.classList.remove('active'); });
    btn.classList.add('active');
    document.getElementById('panelLoc').style.display  = id === 'loc'  ? 'block' : 'none';
    document.getElementById('panelProp').style.display = id === 'prop' ? 'block' : 'none';
}
</script>
@endsection