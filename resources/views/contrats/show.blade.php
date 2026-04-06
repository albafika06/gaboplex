@extends('layouts.app')
@section('title', 'Contrat — ' . $contrat->annonce->titre)
@section('content')
<style>
.cs-wrap{max-width:1050px;margin:0 auto;padding:1.75rem 1.5rem}
.cs-back{display:inline-flex;align-items:center;gap:5px;color:#64748b;text-decoration:none;font-size:13px;margin-bottom:1.25rem;transition:color .2s}
.cs-back:hover{color:#042C53}
.cs-grid{display:grid;grid-template-columns:1fr 320px;gap:1.5rem;align-items:start}
@media(max-width:900px){.cs-grid{grid-template-columns:1fr}}

/* BLOCKS */
.cs-block{background:white;border:0.5px solid #e8edf2;border-radius:12px;padding:1.1rem 1.25rem;margin-bottom:1rem}
.cs-block-title{font-size:13px;font-weight:600;color:#042C53;margin-bottom:1rem;padding-bottom:.6rem;border-bottom:0.5px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;gap:8px}
.cs-block-title span{font-size:11px;font-weight:400;color:#94a3b8}

/* INFOS CONTRAT */
.cs-info-grid{display:grid;grid-template-columns:1fr 1fr;gap:8px}
.cs-info-item{background:#f8fafc;border-radius:8px;padding:.65rem .85rem}
.cs-info-lbl{font-size:10px;color:#94a3b8;text-transform:uppercase;letter-spacing:.3px;font-weight:500;margin-bottom:2px}
.cs-info-val{font-size:13px;font-weight:600;color:#042C53}

/* PAIEMENTS */
.cs-pay-list{display:flex;flex-direction:column;gap:8px}
.cs-pay-item{border:0.5px solid #e8edf2;border-radius:10px;overflow:hidden}
.cs-pay-head{display:flex;align-items:center;justify-content:space-between;padding:.75rem 1rem;cursor:pointer;user-select:none}
.cs-pay-head:hover{background:#f8fafc}
.cs-pay-periode{font-size:13px;font-weight:600;color:#042C53}
.cs-pay-montant{font-size:13px;font-weight:600}
.cs-pay-status{padding:2px 9px;border-radius:20px;font-size:10px;font-weight:600}
.ps-complet{background:#EAF3DE;color:#27500A}
.ps-partiel{background:#FAEEDA;color:#633806}
.ps-en_attente{background:#f1f5f9;color:#64748b}
.ps-retard{background:#FCEBEB;color:#791F1F}
.ps-avance{background:#E6F1FB;color:#0C447C}
.cs-pay-body{padding:.75rem 1rem;border-top:0.5px solid #f8fafc;display:none}
.cs-pay-body.open{display:block}
.cs-pay-row{display:flex;justify-content:space-between;font-size:12px;padding:4px 0;border-bottom:0.5px solid #f8fafc}
.cs-pay-row:last-child{border-bottom:none}
.cs-confirm-btns{display:flex;gap:6px;margin-top:.75rem;flex-wrap:wrap}

/* FORMULAIRE PAIEMENT */
.cs-pay-form{background:#f8fafc;border-radius:10px;padding:1rem;margin-top:.75rem}
.cs-field{margin-bottom:.75rem}
.cs-label{display:block;font-size:11px;font-weight:500;color:#475569;text-transform:uppercase;letter-spacing:.4px;margin-bottom:5px}
.cs-input{width:100%;padding:10px 12px;border:0.5px solid #e2e8f0;border-radius:8px;font-size:13px;color:#1e293b;background:white;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif;outline:none;transition:border-color .2s}
.cs-input:focus{border-color:#185FA5}
.cs-modes{display:flex;gap:6px}
.cs-mode{flex:1;padding:8px;border:0.5px solid #e2e8f0;border-radius:8px;text-align:center;cursor:pointer;transition:all .15s;background:white}
.cs-mode.selected{border-color:#185FA5;background:#E6F1FB}
.cs-mode-name{font-size:11px;font-weight:500;color:#1e293b}
.cs-mode-sub{font-size:10px;color:#94a3b8}

/* SCORE INTERLOCUTEUR */
.cs-score-box{background:white;border:0.5px solid #e8edf2;border-radius:12px;padding:1.1rem 1.25rem;margin-bottom:1rem}
.cs-score-row{display:flex;align-items:center;gap:10px;margin-bottom:.75rem}
.cs-avatar{width:42px;height:42px;border-radius:50%;background:#042C53;color:white;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:600;flex-shrink:0;overflow:hidden}
.cs-avatar img{width:100%;height:100%;object-fit:cover}
.cs-score-num{font-size:20px;font-weight:700}
.cs-score-bar{height:5px;background:#f1f5f9;border-radius:3px;overflow:hidden;margin-bottom:5px}
.cs-score-fill{height:100%;border-radius:3px}
.cs-score-badge{display:inline-block;padding:2px 9px;border-radius:20px;font-size:11px;font-weight:500}

/* BOUTONS */
.cs-btn{padding:8px 16px;border-radius:8px;font-size:13px;font-weight:500;border:0.5px solid #e2e8f0;background:white;color:#475569;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:5px;transition:all .15s;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif}
.cs-btn:hover{border-color:#94a3b8;color:#042C53}
.cs-btn.primary{background:#042C53;color:white;border-color:#042C53}
.cs-btn.primary:hover{background:#185FA5}
.cs-btn.success{background:#EAF3DE;color:#27500A;border-color:#C0DD97}
.cs-btn.warn{background:#FAEEDA;color:#633806;border-color:#FAC775}
.cs-btn.danger{background:#FCEBEB;color:#791F1F;border-color:#F7C1C1}
.cs-btn:disabled{opacity:.4;cursor:not-allowed}

/* FERMETURE CONTRAT */
.cs-fermer-form{background:#f8fafc;border-radius:10px;padding:1rem;margin-top:.75rem}
.cs-stars{display:flex;gap:6px;margin-bottom:.75rem}
.cs-star{font-size:22px;cursor:pointer;color:#e2e8f0;transition:color .15s}
.cs-star.active{color:#FAC775}
</style>

<div class="cs-wrap">
    <a href="{{ route('contrats.index') }}" class="cs-back">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Mes contrats
    </a>

    @php
        $interlocuteur = $estLocataire ? $contrat->proprietaire : $contrat->locataire;
        $scoreInter    = $interlocuteur->score ?? 30;
        $badgeInter    = \App\Services\ScoreService::badge($scoreInter);
        $barColor      = match(true) { $scoreInter >= 75 => '#185FA5', $scoreInter >= 60 => '#1D9E75', $scoreInter >= 40 => '#BA7517', default => '#A32D2D' };
        $periodeActuelle = \Carbon\Carbon::now()->format('Y-m');
    @endphp

    <div class="cs-grid">

        <!-- GAUCHE -->
        <div>
            <!-- INFOS CONTRAT -->
            <div class="cs-block">
                <div class="cs-block-title">
                    Détails du contrat
                    @php
                        $statusClass = match($contrat->statut){ 'actif'=>'ps-complet','en_attente'=>'ps-partiel','litige'=>'ps-retard',default=>'ps-en_attente' };
                    @endphp
                    <span class="cs-pay-status {{ $statusClass }}">{{ $contrat->statut_label }}</span>
                </div>
                <div class="cs-info-grid">
                    <div class="cs-info-item">
                        <div class="cs-info-lbl">Type</div>
                        <div class="cs-info-val">{{ ucfirst($contrat->type) }}</div>
                    </div>
                    <div class="cs-info-item">
                        <div class="cs-info-lbl">{{ $contrat->type === 'location' ? 'Loyer mensuel' : 'Montant total' }}</div>
                        <div class="cs-info-val">{{ number_format($contrat->type === 'location' ? $contrat->montant_mensuel : $contrat->montant_total, 0, ',', ' ') }} FCFA</div>
                    </div>
                    @if($contrat->caution)
                        <div class="cs-info-item">
                            <div class="cs-info-lbl">Caution</div>
                            <div class="cs-info-val">{{ number_format($contrat->caution, 0, ',', ' ') }} FCFA</div>
                        </div>
                    @endif
                    <div class="cs-info-item">
                        <div class="cs-info-lbl">Début</div>
                        <div class="cs-info-val">{{ $contrat->date_debut->format('d/m/Y') }}</div>
                    </div>
                    @if($contrat->solde_restant > 0)
                        <div class="cs-info-item" style="border-left:3px solid #A32D2D">
                            <div class="cs-info-lbl">Dette totale</div>
                            <div class="cs-info-val" style="color:#A32D2D">{{ number_format($contrat->solde_restant, 0, ',', ' ') }} FCFA</div>
                        </div>
                    @endif
                    @if($contrat->credit_avance > 0)
                        <div class="cs-info-item" style="border-left:3px solid #1D9E75">
                            <div class="cs-info-lbl">Avance payée</div>
                            <div class="cs-info-val" style="color:#1D9E75">{{ number_format($contrat->credit_avance, 0, ',', ' ') }} FCFA</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- HISTORIQUE PAIEMENTS -->
            <div class="cs-block">
                <div class="cs-block-title">Historique des paiements <span>{{ $contrat->paiements->count() }} entrée(s)</span></div>
                @if($contrat->paiements->isEmpty())
                    <div style="text-align:center;padding:1.5rem;font-size:13px;color:#94a3b8">Aucun paiement enregistré pour l'instant</div>
                @else
                    <div class="cs-pay-list">
                        @foreach($contrat->paiements->sortByDesc('date_echeance') as $paiement)
                            @php
                                $psClass = match($paiement->statut){ 'complet'=>'ps-complet','partiel'=>'ps-partiel','retard'=>'ps-retard','avance'=>'ps-avance',default=>'ps-en_attente' };
                                $psLabel = match($paiement->statut){ 'complet'=>'Soldé','partiel'=>'Partiel','retard'=>'En retard','avance'=>'Avance','en_attente'=>'En attente',default=>$paiement->statut };
                                $montantColor = match($paiement->statut){ 'complet','avance' => '#1D9E75', 'retard' => '#A32D2D', default => '#BA7517' };
                            @endphp
                            <div class="cs-pay-item" id="pay-{{ $paiement->id }}">
                                <div class="cs-pay-head" onclick="togglePay({{ $paiement->id }})">
                                    <div style="display:flex;align-items:center;gap:10px">
                                        <span class="cs-pay-periode">{{ $paiement->periode_label }}</span>
                                        <span class="cs-pay-status {{ $psClass }}">{{ $psLabel }}</span>
                                        @if($paiement->litige)
                                            <span class="cs-pay-status ps-retard">⚠ Litige</span>
                                        @endif
                                    </div>
                                    <div style="display:flex;align-items:center;gap:10px">
                                        <span class="cs-pay-montant" style="color:{{ $montantColor }}">{{ number_format($paiement->montant_paye, 0, ',', ' ') }} / {{ number_format($paiement->montant_du, 0, ',', ' ') }} FCFA</span>
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                                    </div>
                                </div>
                                <div class="cs-pay-body" id="payBody-{{ $paiement->id }}">
                                    <div class="cs-pay-row"><span style="color:#94a3b8">Montant dû</span><span style="font-weight:500">{{ number_format($paiement->montant_du, 0, ',', ' ') }} FCFA</span></div>
                                    <div class="cs-pay-row"><span style="color:#94a3b8">Payé</span><span style="font-weight:500;color:#1D9E75">{{ number_format($paiement->montant_paye, 0, ',', ' ') }} FCFA</span></div>
                                    @if($paiement->montant_restant > 0)
                                        <div class="cs-pay-row"><span style="color:#94a3b8">Reste</span><span style="font-weight:500;color:#A32D2D">{{ number_format($paiement->montant_restant, 0, ',', ' ') }} FCFA</span></div>
                                    @endif
                                    <div class="cs-pay-row"><span style="color:#94a3b8">Mode</span><span>{{ $paiement->mode_label }}</span></div>
                                    <div class="cs-pay-row"><span style="color:#94a3b8">Confirmé locataire</span><span>{{ $paiement->confirme_locataire ? '✓ Oui' : '✗ Non' }}</span></div>
                                    <div class="cs-pay-row"><span style="color:#94a3b8">Confirmé propriétaire</span><span>{{ $paiement->confirme_proprietaire ? '✓ Oui' : '✗ Non' }}</span></div>
                                    @if($paiement->date_paiement)
                                        <div class="cs-pay-row"><span style="color:#94a3b8">Date paiement</span><span>{{ $paiement->date_paiement->format('d/m/Y à H:i') }}</span></div>
                                    @endif
                                    @if($paiement->preuve_url)
                                        <div style="margin-top:.5rem"><a href="{{ asset('storage/'.$paiement->preuve_url) }}" target="_blank" class="cs-btn" style="font-size:11px">Voir la preuve</a></div>
                                    @endif

                                    {{-- Propriétaire : confirmer ou infirmer --}}
                                    @if(!$estLocataire && $paiement->confirme_locataire && !$paiement->confirme_proprietaire)
                                        <div class="cs-confirm-btns">
                                            <form method="POST" action="{{ route('paiements.confirmer', $paiement) }}">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="confirme" value="1">
                                                <button type="submit" class="cs-btn success">✓ Confirmer la réception</button>
                                            </form>
                                            <form method="POST" action="{{ route('paiements.confirmer', $paiement) }}">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="confirme" value="0">
                                                <button type="submit" class="cs-btn danger">✗ Je n'ai pas reçu</button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- FORMULAIRE PAIEMENT (locataire uniquement) --}}
            @if($estLocataire && $contrat->statut === 'actif')
                <div class="cs-block" id="payer">
                    <div class="cs-block-title">Déclarer un paiement</div>
                    <form method="POST" action="{{ route('contrats.paiement', $contrat) }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="periode" value="{{ $periodeActuelle }}">
                        <div class="cs-pay-form">
                            <div class="cs-field">
                                <label class="cs-label">Montant payé (FCFA) <span style="color:#A32D2D">*</span></label>
                                <input type="number" name="montant_paye" class="cs-input" placeholder="Ex: 200 000" min="1" required
                                    value="{{ old('montant_paye', $contrat->montant_mensuel) }}">
                                @if($contrat->solde_restant > 0)
                                    <div style="font-size:11px;color:#A32D2D;margin-top:4px">
                                        Dette en cours : {{ number_format($contrat->solde_restant, 0, ',', ' ') }} FCFA
                                    </div>
                                @endif
                            </div>
                            <div class="cs-field">
                                <label class="cs-label">Mode de paiement <span style="color:#A32D2D">*</span></label>
                                <div class="cs-modes" id="csModes">
                                    <div class="cs-mode selected" onclick="selectMode(this,'cash')">
                                        <div class="cs-mode-name">Cash</div>
                                        <div class="cs-mode-sub">+3 pts</div>
                                    </div>
                                    <div class="cs-mode" onclick="selectMode(this,'airtel_money')">
                                        <div class="cs-mode-name">Airtel Money</div>
                                        <div class="cs-mode-sub">+6 pts auto</div>
                                    </div>
                                    <div class="cs-mode" onclick="selectMode(this,'moov_money')">
                                        <div class="cs-mode-name">Moov Money</div>
                                        <div class="cs-mode-sub">+6 pts auto</div>
                                    </div>
                                </div>
                                <input type="hidden" name="mode" id="modeInput" value="cash">
                            </div>
                            <div class="cs-field">
                                <label class="cs-label">Joindre une preuve (optionnel)</label>
                                <input type="file" name="preuve" class="cs-input" accept="image/*">
                                <div style="font-size:11px;color:#94a3b8;margin-top:4px">Photo du reçu ou capture d'écran du transfert</div>
                            </div>
                            <button type="submit" class="cs-btn primary" style="width:100%">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg>
                                Déclarer ce paiement
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            {{-- FERMER LE CONTRAT --}}
            @if($contrat->statut === 'actif' && $contrat->solde_restant === 0)
                @php
                    $aDejaNote = $estLocataire ? !is_null($contrat->note_proprietaire) : !is_null($contrat->note_locataire);
                @endphp
                @if(!$aDejaNote)
                    <div class="cs-block">
                        <div class="cs-block-title">Terminer le contrat</div>
                        <p style="font-size:13px;color:#64748b;margin-bottom:1rem">Tout est soldé. Laissez un avis sur {{ $interlocuteur->name }} pour fermer le contrat et mettre à jour vos scores.</p>
                        <form method="POST" action="{{ route('contrats.fermer', $contrat) }}">
                            @csrf
                            <div class="cs-fermer-form">
                                <div class="cs-field">
                                    <label class="cs-label">Votre note pour {{ $interlocuteur->name }}</label>
                                    <div class="cs-stars" id="csStars">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="cs-star" data-note="{{ $i }}" onclick="setNote({{ $i }})">★</span>
                                        @endfor
                                    </div>
                                    <input type="hidden" name="note" id="noteInput" value="">
                                </div>
                                <div class="cs-field">
                                    <label class="cs-label">Commentaire (optionnel)</label>
                                    <textarea name="avis" class="cs-input" rows="3" placeholder="Décrivez votre expérience..."></textarea>
                                </div>
                                <button type="submit" class="cs-btn primary" id="fermerBtn" disabled style="width:100%">
                                    Laisser l'avis et fermer le contrat
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                    <div style="background:#EAF3DE;border:0.5px solid #C0DD97;border-radius:10px;padding:.9rem 1.1rem;font-size:13px;color:#27500A">
                        ✓ Vous avez déjà laissé votre avis. En attente de l'avis de l'autre partie pour fermer le contrat.
                    </div>
                @endif
            @endif
        </div>

        <!-- DROITE -->
        <div>
            {{-- ANNONCE --}}
            <div class="cs-block">
                <div class="cs-block-title">Annonce concernée</div>
                @php $photo = $contrat->annonce->photos->first(); @endphp
                @if($photo)
                    <img src="{{ str_starts_with($photo->url, 'http') ? $photo->url : asset('storage/'.$photo->url) }}" alt="" style="width:100%;height:140px;object-fit:cover;border-radius:8px;margin-bottom:.75rem">
                @endif
                <div style="font-size:14px;font-weight:600;color:#042C53;margin-bottom:4px">{{ $contrat->annonce->titre }}</div>
                <div style="font-size:12px;color:#94a3b8;margin-bottom:.75rem">📍 {{ $contrat->annonce->quartier }}, {{ $contrat->annonce->ville }}</div>
                <a href="{{ route('annonces.show', $contrat->annonce) }}" class="cs-btn" style="width:100%;justify-content:center">Voir l'annonce</a>
            </div>

            {{-- SCORE INTERLOCUTEUR --}}
            <div class="cs-score-box">
                <div class="cs-score-row">
                    <div class="cs-avatar">
                        @if($interlocuteur->avatar)
                            <img src="{{ asset('storage/'.$interlocuteur->avatar) }}" alt="">
                        @else
                            {{ strtoupper(substr($interlocuteur->name, 0, 1)) }}
                        @endif
                    </div>
                    <div style="flex:1">
                        <div style="font-size:13px;font-weight:600;color:#042C53">{{ $interlocuteur->name }}</div>
                        <div style="font-size:11px;color:#94a3b8">{{ $estLocataire ? 'Propriétaire' : 'Locataire' }}</div>
                    </div>
                    <div class="cs-score-num" style="color:{{ $barColor }}">{{ $scoreInter }}<span style="font-size:12px;color:#94a3b8;font-weight:400">/100</span></div>
                </div>
                <div class="cs-score-bar"><div class="cs-score-fill" style="width:{{ $scoreInter }}%;background:{{ $barColor }}"></div></div>
                <span class="cs-score-badge" style="background:{{ $badgeInter['bg'] }};color:{{ $badgeInter['color'] }}">{{ $badgeInter['label'] }}</span>
            </div>

            {{-- MON SCORE --}}
            @php
                $monScore = Auth::user()->score ?? 30;
                $monBadge = \App\Services\ScoreService::badge($monScore);
                $monBarColor = match(true){ $monScore >= 75 => '#185FA5', $monScore >= 60 => '#1D9E75', $monScore >= 40 => '#BA7517', default => '#A32D2D' };
            @endphp
            <div class="cs-score-box">
                <div style="font-size:11px;color:#94a3b8;text-transform:uppercase;letter-spacing:.4px;margin-bottom:.75rem;font-weight:500">Mon score</div>
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.5rem">
                    <span class="cs-score-badge" style="background:{{ $monBadge['bg'] }};color:{{ $monBadge['color'] }}">{{ $monBadge['label'] }}</span>
                    <span style="font-size:20px;font-weight:700;color:{{ $monBarColor }}">{{ $monScore }}/100</span>
                </div>
                <div class="cs-score-bar"><div class="cs-score-fill" style="width:{{ $monScore }}%;background:{{ $monBarColor }}"></div></div>
                <div style="font-size:11px;color:#94a3b8;margin-top:6px">
                    Payez via Airtel ou Moov pour gagner +6 pts par mois
                </div>
            </div>

            {{-- EN ATTENTE DE CONFIRMATION --}}
            @if($contrat->statut === 'en_attente')
                @php
                    $dejaConfirme = $estLocataire ? $contrat->confirme_locataire : $contrat->confirme_proprietaire;
                @endphp
                <div class="cs-block" style="border-color:#FAC775;background:#FAEEDA">
                    <div style="font-size:13px;font-weight:600;color:#633806;margin-bottom:.5rem">Accord en attente</div>
                    <div style="font-size:12px;color:#854F0B;margin-bottom:.75rem;line-height:1.6">
                        @if($dejaConfirme)
                            Vous avez confirmé. En attente de confirmation de {{ $interlocuteur->name }}.
                        @else
                            {{ $interlocuteur->name }} a proposé ce contrat. Confirmez-vous l'accord ?
                        @endif
                    </div>
                    @if(!$dejaConfirme)
                        <form method="POST" action="{{ route('contrats.confirmer', $contrat) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="cs-btn success" style="width:100%;justify-content:center">
                                ✓ Confirmer l'accord
                            </button>
                        </form>
                    @endif
                </div>
            @endif
        </div>

    </div>
</div>

<script>
function togglePay(id) {
    var body = document.getElementById('payBody-'+id);
    body.classList.toggle('open');
}

function selectMode(el, mode) {
    document.querySelectorAll('.cs-mode').forEach(function(m){ m.classList.remove('selected'); });
    el.classList.add('selected');
    document.getElementById('modeInput').value = mode;
}

function setNote(n) {
    document.getElementById('noteInput').value = n;
    document.querySelectorAll('.cs-star').forEach(function(s, i) {
        s.classList.toggle('active', i < n);
    });
    document.getElementById('fermerBtn').disabled = false;
}
</script>
@endsection