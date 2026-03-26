@php
    $photo       = $contrat->annonce->photos->first();
    $estLocataire = $role === 'locataire';
    $interlocuteur = $estLocataire ? $contrat->proprietaire : $contrat->locataire;
    $scoreInter  = $interlocuteur->score ?? 30;
    $barColor    = match(true) { $scoreInter >= 75 => '#185FA5', $scoreInter >= 60 => '#1D9E75', $scoreInter >= 40 => '#BA7517', default => '#A32D2D' };

    // Paiement du mois en cours
    $periodeActuelle = \Carbon\Carbon::now()->format('Y-m');
    $paiementMois = $contrat->paiements->firstWhere('periode', $periodeActuelle);

    $statusClass = match($contrat->statut) {
        'actif'      => 's-actif',
        'en_attente' => 's-en_attente',
        'litige'     => 's-litige',
        'termine'    => 's-termine',
        default      => 's-annule',
    };
@endphp

<div class="ct-card">
    {{-- ALERTE PAIEMENT --}}
    @if($contrat->statut === 'actif' && $estLocataire)
        @if($paiementMois && $paiementMois->statut === 'en_attente' && $paiementMois->date_echeance->isPast())
            <div style="padding:.5rem 1.25rem 0">
                <div class="ct-alerte danger">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    Loyer de {{ \Carbon\Carbon::createFromFormat('Y-m', $periodeActuelle)->translatedFormat('F Y') }} en retard — {{ number_format($paiementMois->montant_restant, 0, ',', ' ') }} FCFA dus
                </div>
            </div>
        @elseif($paiementMois && $paiementMois->statut === 'en_attente')
            <div style="padding:.5rem 1.25rem 0">
                <div class="ct-alerte">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    Loyer de {{ \Carbon\Carbon::createFromFormat('Y-m', $periodeActuelle)->translatedFormat('F Y') }} dû — {{ number_format($paiementMois->montant_du, 0, ',', ' ') }} FCFA
                </div>
            </div>
        @elseif($paiementMois && $paiementMois->statut === 'partiel')
            <div style="padding:.5rem 1.25rem 0">
                <div class="ct-alerte">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    Reste à payer ce mois : {{ number_format($paiementMois->montant_restant, 0, ',', ' ') }} FCFA
                </div>
            </div>
        @elseif($paiementMois && $paiementMois->statut === 'complet')
            <div style="padding:.5rem 1.25rem 0">
                <div class="ct-alerte success">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg>
                    Loyer de {{ \Carbon\Carbon::createFromFormat('Y-m', $periodeActuelle)->translatedFormat('F Y') }} soldé
                </div>
            </div>
        @endif
    @endif

    {{-- ALERTE PROPRIÉTAIRE : paiement à confirmer --}}
    @if($contrat->statut === 'actif' && !$estLocataire)
        @php $aConfirmer = $contrat->paiements->where('confirme_locataire', true)->where('confirme_proprietaire', false)->count(); @endphp
        @if($aConfirmer > 0)
            <div style="padding:.5rem 1.25rem 0">
                <div class="ct-alerte warn">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    {{ $aConfirmer }} paiement(s) en attente de votre confirmation
                </div>
            </div>
        @endif
    @endif

    <div class="ct-card-head">
        <div class="ct-card-img">
            @if($photo)
                <img src="{{ asset('storage/'.$photo->url) }}" alt="">
            @else
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="3"/></svg>
            @endif
        </div>
        <div class="ct-card-info">
            <div class="ct-card-title">{{ $contrat->annonce->titre }}</div>
            <div class="ct-card-sub">
                📍 {{ $contrat->annonce->quartier }}, {{ $contrat->annonce->ville }}
                · {{ $estLocataire ? 'Propriétaire' : 'Locataire' }} :
                <strong>{{ $interlocuteur->name }}</strong>
                <span style="display:inline-flex;align-items:center;gap:3px;margin-left:4px;padding:1px 7px;border-radius:20px;font-size:10px;font-weight:500;background:#f1f5f9;color:#64748b">
                    Score {{ $scoreInter }}/100
                </span>
            </div>
        </div>
        <span class="ct-card-status {{ $statusClass }}">{{ $contrat->statut_label }}</span>
    </div>

    <div class="ct-card-body">
        <div class="ct-kpi">
            <div class="ct-kpi-lbl">{{ $contrat->type === 'location' ? 'Loyer mensuel' : 'Montant total' }}</div>
            <div class="ct-kpi-val">
                {{ number_format($contrat->type === 'location' ? $contrat->montant_mensuel : $contrat->montant_total, 0, ',', ' ') }} FCFA
            </div>
        </div>
        <div class="ct-kpi">
            <div class="ct-kpi-lbl">Début</div>
            <div class="ct-kpi-val">{{ $contrat->date_debut->format('d/m/Y') }}</div>
        </div>
        <div class="ct-kpi">
            <div class="ct-kpi-lbl">{{ $contrat->solde_restant > 0 ? 'Dette' : 'Avance' }}</div>
            <div class="ct-kpi-val" style="color:{{ $contrat->solde_restant > 0 ? '#A32D2D' : ($contrat->credit_avance > 0 ? '#1D9E75' : '#64748b') }}">
                @if($contrat->solde_restant > 0)
                    {{ number_format($contrat->solde_restant, 0, ',', ' ') }} FCFA
                @elseif($contrat->credit_avance > 0)
                    +{{ number_format($contrat->credit_avance, 0, ',', ' ') }} FCFA
                @else
                    À jour
                @endif
            </div>
        </div>
        <div class="ct-kpi">
            <div class="ct-kpi-lbl">Paiements</div>
            <div class="ct-kpi-val">{{ $contrat->paiements->where('statut', 'complet')->count() }} soldé(s)</div>
        </div>
    </div>

    <div class="ct-card-foot">
        <div style="display:flex;gap:6px;flex-wrap:wrap">
            <a href="{{ route('contrats.show', $contrat) }}" class="ct-btn primary">Voir le détail</a>

            {{-- Confirmer l'accord si en attente --}}
            @if($contrat->statut === 'en_attente')
                @php
                    $dejaConfirme = $estLocataire ? $contrat->confirme_locataire : $contrat->confirme_proprietaire;
                @endphp
                @if(!$dejaConfirme)
                    <form method="POST" action="{{ route('contrats.confirmer', $contrat) }}" style="display:inline">
                        @csrf @method('PATCH')
                        <button type="submit" class="ct-btn" style="background:#EAF3DE;color:#27500A;border-color:#C0DD97">
                            ✓ Confirmer l'accord
                        </button>
                    </form>
                @else
                    <span style="font-size:12px;color:#94a3b8;padding:6px 0">En attente de l'autre partie…</span>
                @endif
            @endif

            {{-- Déclarer un paiement si locataire + contrat actif --}}
            @if($contrat->statut === 'actif' && $estLocataire)
                <a href="{{ route('contrats.show', $contrat) }}#payer" class="ct-btn warn">Déclarer un paiement</a>
            @endif
        </div>
        <span style="font-size:11px;color:#94a3b8">{{ ucfirst($contrat->type) }} · depuis {{ $contrat->date_debut->diffForHumans() }}</span>
    </div>
</div>