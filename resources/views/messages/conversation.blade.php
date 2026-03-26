@extends('layouts.app')
@section('title', 'Conversation — ' . $interlocuteur->name)
@section('content')
<style>
.cv-wrap{max-width:860px;margin:0 auto;padding:1.75rem 1.5rem}
.cv-back{display:inline-flex;align-items:center;gap:5px;color:#64748b;text-decoration:none;font-size:13px;margin-bottom:1.25rem;transition:color .2s}
.cv-back:hover{color:#042C53}
.cv-grid{display:grid;grid-template-columns:1fr 280px;gap:1.25rem;align-items:start}
@media(max-width:800px){.cv-grid{grid-template-columns:1fr}}

/* HEADER CONVERSATION */
.cv-head{background:white;border:0.5px solid #e8edf2;border-radius:12px;padding:1rem 1.25rem;margin-bottom:1rem;display:flex;align-items:center;gap:.75rem}
.cv-avatar{width:42px;height:42px;border-radius:50%;background:#042C53;color:white;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:600;flex-shrink:0;overflow:hidden}
.cv-avatar img{width:100%;height:100%;object-fit:cover}
.cv-head-name{font-size:14px;font-weight:600;color:#042C53}
.cv-head-sub{font-size:12px;color:#94a3b8}

/* MESSAGES */
.cv-messages{background:white;border:0.5px solid #e8edf2;border-radius:12px;padding:1.25rem;min-height:400px;max-height:500px;overflow-y:auto;display:flex;flex-direction:column;gap:.75rem;margin-bottom:1rem}
.cv-msg{display:flex;flex-direction:column;max-width:75%}
.cv-msg.moi{align-self:flex-end;align-items:flex-end}
.cv-msg.lui{align-self:flex-start;align-items:flex-start}
.cv-msg-bubble{padding:.65rem .9rem;border-radius:12px;font-size:13px;line-height:1.6;word-break:break-word}
.cv-msg.moi .cv-msg-bubble{background:#042C53;color:white;border-radius:12px 12px 2px 12px}
.cv-msg.lui .cv-msg-bubble{background:#f1f5f9;color:#1e293b;border-radius:12px 12px 12px 2px}
.cv-msg-time{font-size:10px;color:#94a3b8;margin-top:3px;padding:0 4px}
.cv-empty{text-align:center;padding:2rem;font-size:13px;color:#94a3b8;flex:1;display:flex;align-items:center;justify-content:center;flex-direction:column;gap:8px}

/* FORM RÉPONSE */
.cv-reply{background:white;border:0.5px solid #e8edf2;border-radius:12px;padding:1rem}
.cv-reply-area{width:100%;border:0.5px solid #e2e8f0;border-radius:8px;padding:10px 12px;font-size:13px;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif;color:#1e293b;resize:none;outline:none;transition:border-color .2s;background:white}
.cv-reply-area:focus{border-color:#185FA5}
.cv-reply-footer{display:flex;justify-content:space-between;align-items:center;margin-top:.65rem;flex-wrap:wrap;gap:8px}
.cv-btn{padding:8px 18px;border-radius:8px;font-size:13px;font-weight:500;border:0.5px solid #e2e8f0;background:white;color:#475569;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:5px;transition:all .15s;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif}
.cv-btn.primary{background:#042C53;color:white;border-color:#042C53}
.cv-btn.primary:hover{background:#185FA5}
.cv-btn.success{background:#EAF3DE;color:#27500A;border-color:#C0DD97}

/* SIDEBAR */
.cv-side-block{background:white;border:0.5px solid #e8edf2;border-radius:12px;padding:1rem;margin-bottom:1rem}
.cv-side-title{font-size:11px;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.4px;margin-bottom:.75rem}

/* CONTRAT BANNER */
.cv-contrat-banner{background:#EAF3DE;border:0.5px solid #C0DD97;border-radius:10px;padding:.9rem 1rem;margin-bottom:1rem}
.cv-contrat-banner.en_attente{background:#FAEEDA;border-color:#FAC775}

/* SCORE */
.cv-score-bar{height:5px;background:#f1f5f9;border-radius:3px;overflow:hidden;margin:6px 0}
.cv-score-fill{height:100%;border-radius:3px}
</style>

<div class="cv-wrap">
    <a href="{{ route('messages.index') }}" class="cv-back">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Mes messages
    </a>

    <div class="cv-grid">

        <!-- GAUCHE — CONVERSATION -->
        <div>
            {{-- HEADER --}}
            <div class="cv-head">
                <div class="cv-avatar">
                    @if($interlocuteur->avatar ?? null)
                        <img src="{{ asset('storage/'.$interlocuteur->avatar) }}" alt="">
                    @else
                        {{ strtoupper(substr($interlocuteur->name, 0, 1)) }}
                    @endif
                </div>
                <div>
                    <div class="cv-head-name">{{ $interlocuteur->name }}</div>
                    <div class="cv-head-sub">
                        À propos de : <a href="{{ route('annonces.show', $annonce) }}" style="color:#185FA5;text-decoration:none">{{ Str::limit($annonce->titre, 40) }}</a>
                    </div>
                </div>
                <div style="margin-left:auto">
                    <span style="padding:2px 9px;border-radius:20px;font-size:11px;font-weight:500;background:{{ $badgeInter['bg'] }};color:{{ $badgeInter['color'] }}">
                        Score {{ $scoreInter }}/100
                    </span>
                </div>
            </div>

            {{-- BANNIÈRE CONTRAT EXISTANT --}}
            @if($contrat)
                <div class="cv-contrat-banner {{ $contrat->statut === 'en_attente' ? 'en_attente' : '' }}">
                    <div style="font-size:13px;font-weight:600;color:{{ $contrat->statut === 'actif' ? '#27500A' : '#633806' }};margin-bottom:4px">
                        @if($contrat->statut === 'actif')
                            ✓ Contrat actif — suivi des paiements en cours
                        @else
                            ⏳ Contrat proposé — en attente de confirmation
                        @endif
                    </div>
                    <div style="font-size:12px;color:#64748b;margin-bottom:.5rem">
                        {{ number_format($contrat->type === 'location' ? $contrat->montant_mensuel : $contrat->montant_total, 0, ',', ' ') }} FCFA
                        @if($contrat->type === 'location')
                            /mois
                        @endif
                        · Début {{ $contrat->date_debut->format('d/m/Y') }}
                    </div>
                    <a href="{{ route('contrats.show', $contrat) }}" class="cv-btn" style="font-size:12px">
                        Voir le contrat →
                    </a>
                </div>
            @endif

            {{-- MESSAGES --}}
            <div class="cv-messages" id="cvMessages">
                @if($messages->isEmpty())
                    <div class="cv-empty">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        <span>Commencez la conversation</span>
                    </div>
                @else
                    @foreach($messages as $msg)
                        @php $estMoi = $msg->sender_id === Auth::id(); @endphp
                        <div class="cv-msg {{ $estMoi ? 'moi' : 'lui' }}">
                            <div class="cv-msg-bubble">{{ $msg->contenu }}</div>
                            <div class="cv-msg-time">{{ $msg->created_at->format('d/m à H:i') }}</div>
                        </div>
                    @endforeach
                @endif
            </div>

            {{-- FORMULAIRE RÉPONSE --}}
            @if(!$contrat || $contrat->statut !== 'termine')
                <div class="cv-reply">
                    <form method="POST" action="{{ route('messages.repondre', [$annonce->id, $interlocuteur->id]) }}">
                        @csrf
                        <textarea
                            name="contenu"
                            class="cv-reply-area"
                            rows="3"
                            placeholder="Écrivez votre message..."
                            required
                        ></textarea>
                        <div class="cv-reply-footer">
                            <div style="font-size:11px;color:#94a3b8">
                                {{ $interlocuteur->name }} sera notifié(e) par email
                            </div>
                            <button type="submit" class="cv-btn primary">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                                Envoyer
                            </button>
                        </div>
                    </form>
                </div>
            @endif
        </div>

        <!-- DROITE — SIDEBAR -->
        <div>

            {{-- ANNONCE --}}
            <div class="cv-side-block">
                <div class="cv-side-title">Annonce</div>
                @php $photo = $annonce->photos->first(); @endphp
                @if($photo)
                    <img src="{{ asset('storage/'.$photo->url) }}" alt="" style="width:100%;height:120px;object-fit:cover;border-radius:8px;margin-bottom:.75rem">
                @endif
                <div style="font-size:13px;font-weight:600;color:#042C53;margin-bottom:3px">{{ $annonce->titre }}</div>
                <div style="font-size:12px;color:#94a3b8;margin-bottom:.75rem">📍 {{ $annonce->quartier }}, {{ $annonce->ville }}</div>
                <div style="font-size:16px;font-weight:700;color:#185FA5;margin-bottom:.75rem">
                    {{ number_format($annonce->prix,0,',',' ') }} FCFA
                    @if($annonce->type==='location')
                        <span style="font-size:11px;color:#94a3b8;font-weight:400">/mois</span>
                    @endif
                </div>
                <a href="{{ route('annonces.show', $annonce) }}" class="cv-btn" style="width:100%;justify-content:center;font-size:12px">
                    Voir l'annonce
                </a>
            </div>

            {{-- SCORE INTERLOCUTEUR --}}
            <div class="cv-side-block">
                <div class="cv-side-title">Réputation</div>
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:5px">
                    <span style="font-size:13px;font-weight:500;color:#042C53">{{ $interlocuteur->name }}</span>
                    <span style="font-size:16px;font-weight:700;color:#185FA5">{{ $scoreInter }}<span style="font-size:11px;color:#94a3b8;font-weight:400">/100</span></span>
                </div>
                <div class="cv-score-bar">
                    <div class="cv-score-fill" style="width:{{ $scoreInter }}%;background:{{ $scoreInter >= 75 ? '#185FA5' : ($scoreInter >= 60 ? '#1D9E75' : ($scoreInter >= 40 ? '#BA7517' : '#A32D2D')) }}"></div>
                </div>
                <span style="padding:2px 9px;border-radius:20px;font-size:11px;font-weight:500;background:{{ $badgeInter['bg'] }};color:{{ $badgeInter['color'] }}">
                    {{ $badgeInter['label'] }}
                </span>
            </div>

            {{-- PROPOSER UN CONTRAT --}}
            @if(!$contrat)
                <div class="cv-side-block" style="border-color:#C0DD97;background:#f8fff5">
                    <div class="cv-side-title" style="color:#27500A">Formaliser l'accord</div>
                    <p style="font-size:12px;color:#64748b;line-height:1.6;margin-bottom:.75rem">
                        Vous êtes d'accord ? Créez un contrat GaboPlex pour sécuriser l'accord, suivre les paiements et construire votre score.
                    </p>
                    <form method="POST" action="{{ route('contrats.proposer', $annonce) }}">
                        @csrf
                        <input type="hidden" name="type" value="{{ $annonce->type === 'location' ? 'location' : 'vente' }}">

                        <div style="margin-bottom:.6rem">
                            <label style="font-size:11px;font-weight:500;color:#475569;text-transform:uppercase;letter-spacing:.3px;display:block;margin-bottom:4px">
                                @if($annonce->type === 'location')Loyer mensuel (FCFA)
                             @else
                                 Montant total (FCFA)
                             @endif
                            </label>
                            <input type="number"
                                name="{{ $annonce->type === 'location' ? 'montant_mensuel' : 'montant_total' }}"
                                value="{{ $annonce->prix }}"
                                style="width:100%;padding:8px 10px;border:0.5px solid #e2e8f0;border-radius:7px;font-size:13px;font-family:inherit;outline:none"
                                required>
                        </div>

                        @if($annonce->type === 'location')
                        <div style="margin-bottom:.6rem">
                            <label style="font-size:11px;font-weight:500;color:#475569;text-transform:uppercase;letter-spacing:.3px;display:block;margin-bottom:4px">Caution (FCFA)</label>
                            <input type="number" name="caution" value="{{ $annonce->caution ?? '' }}"
                                style="width:100%;padding:8px 10px;border:0.5px solid #e2e8f0;border-radius:7px;font-size:13px;font-family:inherit;outline:none">
                        </div>
                        @endif

                        <div style="margin-bottom:.75rem">
                            <label style="font-size:11px;font-weight:500;color:#475569;text-transform:uppercase;letter-spacing:.3px;display:block;margin-bottom:4px">Date de début</label>
                            <input type="date" name="date_debut" value="{{ date('Y-m-d') }}"
                                style="width:100%;padding:8px 10px;border:0.5px solid #e2e8f0;border-radius:7px;font-size:13px;font-family:inherit;outline:none"
                                required>
                        </div>

                        <button type="submit" class="cv-btn success" style="width:100%;justify-content:center">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/></svg>
                            Proposer un contrat
                        </button>
                    </form>
                </div>
            @endif

        </div>
    </div>
</div>

<script>
// Auto-scroll vers le bas des messages
var msgs = document.getElementById('cvMessages');
if (msgs) msgs.scrollTop = msgs.scrollHeight;
</script>
@endsection