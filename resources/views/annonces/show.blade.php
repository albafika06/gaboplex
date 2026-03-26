@extends('layouts.app')
@section('title', $annonce->titre)
@section('content')
<style>
.sd-wrap{max-width:1180px;margin:0 auto;padding:1.75rem 1.5rem}
.sd-back{display:inline-flex;align-items:center;gap:5px;color:#64748b;text-decoration:none;font-size:13px;margin-bottom:1.25rem;font-weight:400;transition:color .2s}
.sd-back:hover{color:#042C53}
.sd-grid{display:grid;grid-template-columns:1fr 340px;gap:1.75rem;align-items:start}
.sd-gallery{background:white;border:0.5px solid #e8edf2;border-radius:14px;overflow:hidden;margin-bottom:1.25rem}
.sd-gallery-main{position:relative;height:420px;overflow:hidden;background:#f1f5f9}
.sd-gallery-main img{width:100%;height:100%;object-fit:cover;display:block;transition:opacity .25s}
.sd-no-photo{height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;color:#cbd5e1;gap:10px;font-size:13px}
.sd-nav-btn{position:absolute;top:50%;transform:translateY(-50%);background:rgba(255,255,255,.9);border:none;border-radius:50%;width:36px;height:36px;display:flex;align-items:center;justify-content:center;cursor:pointer;box-shadow:0 1px 8px rgba(0,0,0,.12);font-size:18px;color:#042C53;transition:all .15s;z-index:3}
.sd-nav-btn:hover{background:#042C53;color:white}
.sd-nav-prev{left:12px}.sd-nav-next{right:12px}
.sd-counter{position:absolute;bottom:12px;right:12px;background:rgba(0,0,0,.5);color:white;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:500;z-index:3}
.sd-badges{position:absolute;top:12px;left:12px;display:flex;gap:5px;z-index:3}
.sd-type-pill{padding:3px 10px;border-radius:20px;font-size:10px;font-weight:600;color:white}
.sd-verifie-pill{background:white;color:#185FA5;padding:3px 10px;border-radius:20px;font-size:10px;font-weight:600;border:0.5px solid #B5D4F4}
.sd-thumbs{display:flex;gap:6px;padding:10px;overflow-x:auto;background:white}
.sd-thumb{width:68px;height:52px;border-radius:7px;overflow:hidden;cursor:pointer;border:2px solid transparent;flex-shrink:0;transition:border-color .2s}
.sd-thumb img{width:100%;height:100%;object-fit:cover}
.sd-thumb.active{border-color:#185FA5}
.sd-block{background:white;border:0.5px solid #e8edf2;border-radius:14px;padding:1.25rem;margin-bottom:1.25rem}
.sd-block-title{font-size:13px;font-weight:600;color:#042C53;margin-bottom:1rem;padding-bottom:8px;border-bottom:0.5px solid #f1f5f9;display:flex;align-items:center;gap:7px}
.sd-chips{display:flex;flex-wrap:wrap;gap:7px}
.sd-chip{display:inline-flex;align-items:center;gap:5px;padding:6px 12px;border-radius:8px;font-size:12px;font-weight:500;background:#f8fafc;border:0.5px solid #e8edf2;color:#374151}
.sd-chip svg{width:12px;height:12px;flex-shrink:0}
.sd-chip.green{background:#EAF3DE;border-color:#C0DD97;color:#27500A}
.sd-chip.blue{background:#E6F1FB;border-color:#B5D4F4;color:#185FA5}
.sd-chip.amber{background:#FAEEDA;border-color:#FAC775;color:#633806}
.sd-calc{background:#E6F1FB;border:0.5px solid #B5D4F4;border-radius:8px;padding:.9rem 1.1rem;margin-top:1rem}
.sd-calc-lbl{font-size:10px;font-weight:600;color:#185FA5;text-transform:uppercase;letter-spacing:.5px;margin-bottom:8px}
.sd-calc-row{display:flex;justify-content:space-between;font-size:12px;color:#475569;padding:4px 0;border-bottom:0.5px solid #bfdbfe}
.sd-calc-total{display:flex;justify-content:space-between;font-size:13px;font-weight:700;color:#042C53;padding-top:8px;margin-top:2px;border-top:1px solid #B5D4F4}
.sd-info-grid{display:grid;grid-template-columns:1fr 1fr;gap:8px}
.sd-info-item{background:#f8fafc;border-radius:8px;padding:.85rem}
.sd-info-lbl{font-size:10px;color:#94a3b8;text-transform:uppercase;letter-spacing:.4px;font-weight:500;margin-bottom:3px}
.sd-info-val{font-size:13px;font-weight:600;color:#0f172a}
.sd-map-container{border-radius:8px;overflow:hidden;height:260px}
.sd-owner-bar{background:#FAEEDA;border:0.5px solid #FAC775;border-radius:10px;padding:.9rem 1.1rem;display:flex;align-items:center;justify-content:space-between;gap:10px;flex-wrap:wrap;margin-bottom:1.25rem}
.sd-owner-bar p{font-size:13px;color:#633806;font-weight:500;margin:0}
.sd-owner-btns{display:flex;gap:7px}
.sd-btn-edit{padding:6px 14px;border-radius:7px;background:#BA7517;color:white;text-decoration:none;font-size:12px;font-weight:600;transition:background .2s}
.sd-btn-edit:hover{background:#854F0B;color:white}
.sd-btn-del{padding:6px 14px;border-radius:7px;background:#A32D2D;color:white;border:none;font-size:12px;font-weight:600;cursor:pointer;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif;transition:background .2s}
.sd-btn-del:hover{background:#791F1F}
.sd-price-box{background:white;border:0.5px solid #e8edf2;border-radius:14px;padding:1.25rem;margin-bottom:.9rem;position:sticky;top:68px}
.sd-price-head{display:flex;align-items:flex-start;justify-content:space-between;gap:8px;margin-bottom:.9rem}
.sd-price-badges{display:flex;flex-wrap:wrap;gap:5px;margin-bottom:7px}
.sd-price-amount{font-size:1.75rem;font-weight:700;color:#042C53;line-height:1}
.sd-price-amount span{font-size:13px;color:#94a3b8;font-weight:400}
.sd-neg-pill{display:inline-block;padding:2px 9px;border-radius:20px;background:#EAF3DE;color:#27500A;font-size:11px;font-weight:500;border:0.5px solid #C0DD97;margin-top:5px}
.sd-prop-title{font-size:15px;font-weight:600;color:#042C53;margin-bottom:5px;line-height:1.35}
.sd-prop-loc{font-size:12px;color:#64748b;display:flex;align-items:center;gap:4px;margin-bottom:.9rem}
.sd-prop-stats{display:flex;gap:1rem;padding-top:.9rem;border-top:0.5px solid #f1f5f9;flex-wrap:wrap}
.sd-prop-stat{font-size:11px;color:#94a3b8;display:flex;align-items:center;gap:3px}
.sd-fav-btn{width:36px;height:36px;border-radius:50%;background:#f8fafc;border:0.5px solid #e2e8f0;cursor:pointer;font-size:16px;display:flex;align-items:center;justify-content:center;transition:all .15s;flex-shrink:0}
.sd-fav-btn:hover{border-color:#fecdd3;background:#fff1f2}
.sd-fav-btn.active{background:#fff1f2;border-color:#fecdd3;color:#e11d48}
.sd-contact-box{background:white;border:0.5px solid #e8edf2;border-radius:14px;padding:1.25rem;margin-bottom:.9rem}
.sd-contact-title{font-size:13px;font-weight:600;color:#042C53;margin-bottom:1rem}
.sd-agent-row{display:flex;align-items:center;gap:10px;margin-bottom:1rem;padding-bottom:1rem;border-bottom:0.5px solid #f1f5f9}
.sd-avatar{width:42px;height:42px;border-radius:50%;background:#042C53;color:white;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:600;flex-shrink:0;overflow:hidden}
.sd-avatar img{width:100%;height:100%;object-fit:cover}
.sd-agent-name{font-size:13px;font-weight:600;color:#0f172a}
.sd-agent-since{font-size:11px;color:#94a3b8;margin-top:1px}
.sd-btn-wa{display:flex;align-items:center;justify-content:center;gap:8px;width:100%;background:#25D366;color:white;padding:12px;border-radius:10px;text-decoration:none;font-size:13px;font-weight:600;margin-bottom:8px;transition:background .2s}
.sd-btn-wa:hover{background:#1da851;color:white}
.sd-no-wa{background:#f8fafc;border:0.5px solid #e8edf2;border-radius:8px;padding:10px;text-align:center;font-size:12px;color:#94a3b8;margin-bottom:8px}
.sd-sep{display:flex;align-items:center;gap:8px;margin:12px 0}
.sd-sep-line{flex:1;height:0.5px;background:#e8edf2}
.sd-sep-txt{font-size:11px;color:#94a3b8;white-space:nowrap}
.sd-field{margin-bottom:8px}
.sd-input{width:100%;padding:10px 12px;border:0.5px solid #e2e8f0;border-radius:8px;font-size:13px;color:#1e293b;outline:none;transition:border-color .2s;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif;background:white;box-sizing:border-box}
.sd-input:focus{border-color:#185FA5}
.sd-btn-send{width:100%;background:#042C53;color:white;border:none;padding:12px;border-radius:10px;font-size:13px;font-weight:600;cursor:pointer;transition:background .2s;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif}
.sd-btn-send:hover{background:#185FA5}
.sd-report{text-align:center;margin-top:10px}
.sd-report a{font-size:11px;color:#cbd5e1;text-decoration:none}
.sd-report a:hover{color:#94a3b8}
@media(max-width:900px){.sd-grid{grid-template-columns:1fr}.sd-price-box{position:static}}
@media(max-width:640px){.sd-wrap{padding:1rem}.sd-gallery-main{height:260px}.sd-price-amount{font-size:1.4rem}.sd-info-grid{grid-template-columns:1fr}}
</style>

<div class="sd-wrap">
    <a href="{{ route('annonces.index') }}" class="sd-back">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Retour aux annonces
    </a>

    @auth
        @if(Auth::id()===$annonce->user_id)
            <div class="sd-owner-bar">
                <p>Vous êtes le propriétaire de cette annonce</p>
                <div class="sd-owner-btns">
                    <a href="{{ route('annonces.edit',$annonce) }}" class="sd-btn-edit">Modifier</a>
                    <form method="POST" action="{{ route('annonces.destroy',$annonce) }}" onsubmit="return confirm('Supprimer ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="sd-btn-del">Supprimer</button>
                    </form>
                </div>
            </div>
        @endif
    @endauth

    <div class="sd-grid">
        <div>
            @php $photos=$annonce->photos;$nbPhotos=$photos->count(); @endphp
            <div class="sd-gallery">
                <div class="sd-gallery-main">
                    @if($nbPhotos>0)
                        <img id="sdImg" src="{{ asset('storage/'.$photos->first()->url) }}" alt="{{ $annonce->titre }}">
                        @if($nbPhotos>1)
                            <button class="sd-nav-btn sd-nav-prev" onclick="sdNav(-1)">‹</button>
                            <button class="sd-nav-btn sd-nav-next" onclick="sdNav(1)">›</button>
                            <div class="sd-counter"><span id="sdIdx">1</span>/{{ $nbPhotos }}</div>
                        @endif
                    @else
                        <div class="sd-no-photo"><svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="3"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>Pas de photo</div>
                    @endif
                    <div class="sd-badges">
                        @php $typeLabel=match($annonce->type){'location'=>'Location','vente_maison'=>'Vente','vente_terrain'=>'Terrain','commerce'=>'Commerce',default=>$annonce->type}; @endphp
                        <span class="sd-type-pill badge-{{ $annonce->type }}">{{ $typeLabel }}</span>
                        @if($annonce->verifie)<span class="sd-verifie-pill">✓ Vérifié</span>@endif
                    </div>
                </div>
                @if($nbPhotos>1)
                    <div class="sd-thumbs">
                        @foreach($photos as $p)
                            <div class="sd-thumb {{ $loop->first?'active':'' }}" onclick="sdGo({{ $loop->index }})" id="sdT{{ $loop->index }}">
                                <img src="{{ asset('storage/'.$p->url) }}" alt="">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            @if($annonce->nb_chambres||$annonce->nb_sdb||$annonce->superficie||$annonce->meuble||$annonce->parking||$annonce->charges_incluses||$annonce->titre_foncier||$annonce->prix_negotiable||$annonce->etat_bien)
            <div class="sd-block">
                <div class="sd-block-title"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>Caractéristiques</div>
                <div class="sd-chips">
                    @if($annonce->nb_chambres)<div class="sd-chip"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 4v16M22 4v16M2 8h20"/></svg>{{ $annonce->nb_chambres }} chambre{{ $annonce->nb_chambres>1?'s':'' }}</div>@endif
                    @if($annonce->nb_sdb)<div class="sd-chip">{{ $annonce->nb_sdb }} salle{{ $annonce->nb_sdb>1?'s':'' }} de bain</div>@endif
                    @if($annonce->superficie)<div class="sd-chip">{{ $annonce->superficie }} m²</div>@endif
                    @if($annonce->meuble)<div class="sd-chip green"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg>Meublé</div>@endif
                    @if($annonce->parking)<div class="sd-chip blue">Parking</div>@endif
                    @if($annonce->charges_incluses)<div class="sd-chip green">Charges incluses</div>@endif
                    @if($annonce->titre_foncier)<div class="sd-chip green">Titre foncier</div>@endif
                    @if($annonce->prix_negotiable)<div class="sd-chip amber">Prix négociable</div>@endif
                    @if($annonce->etat_bien)<div class="sd-chip">{{ match($annonce->etat_bien){'neuf'=>'Neuf','bon_etat'=>'Bon état','a_renover'=>'À rénover',default=>$annonce->etat_bien} }}</div>@endif
                    @if($annonce->disponible_le)<div class="sd-chip">Dispo le {{ $annonce->disponible_le->format('d/m/Y') }}</div>@endif
                </div>
                @if($annonce->type==='location'&&$annonce->caution)
                    <div class="sd-calc">
                        <div class="sd-calc-lbl">Budget à l'entrée</div>
                        <div class="sd-calc-row"><span>1er loyer</span><span style="font-weight:600">{{ number_format($annonce->prix,0,',',' ') }} FCFA</span></div>
                        <div class="sd-calc-row"><span>Caution</span><span style="font-weight:600">{{ number_format($annonce->caution,0,',',' ') }} FCFA</span></div>
                        <div class="sd-calc-total"><span>Total</span><span style="color:#185FA5">{{ number_format($annonce->prix+$annonce->caution,0,',',' ') }} FCFA</span></div>
                    </div>
                @endif
            </div>
            @endif

            <div class="sd-block">
                <div class="sd-block-title"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2"><line x1="17" y1="10" x2="3" y2="10"/><line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="14" x2="3" y2="14"/><line x1="17" y1="18" x2="3" y2="18"/></svg>Description</div>
                <p style="font-size:13px;color:#475569;line-height:1.8;white-space:pre-line">{{ $annonce->description }}</p>
            </div>

            <div class="sd-block">
                <div class="sd-block-title"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>Informations</div>
                <div class="sd-info-grid">
                    <div class="sd-info-item"><div class="sd-info-lbl">Type</div><div class="sd-info-val">{{ match($annonce->type){'location'=>'Location','vente_maison'=>'Vente maison','vente_terrain'=>'Terrain','commerce'=>'Commerce',default=>$annonce->type} }}</div></div>
                    @if($annonce->sous_type)<div class="sd-info-item"><div class="sd-info-lbl">Sous-type</div><div class="sd-info-val">{{ ucfirst($annonce->sous_type) }}</div></div>@endif
                    <div class="sd-info-item"><div class="sd-info-lbl">Ville</div><div class="sd-info-val">{{ $annonce->ville }}</div></div>
                    <div class="sd-info-item"><div class="sd-info-lbl">Quartier</div><div class="sd-info-val">{{ $annonce->quartier }}</div></div>
                    <div class="sd-info-item"><div class="sd-info-lbl">Référence</div><div class="sd-info-val">#{{ str_pad($annonce->id,5,'0',STR_PAD_LEFT) }}</div></div>
                    <div class="sd-info-item"><div class="sd-info-lbl">Publié le</div><div class="sd-info-val">{{ $annonce->created_at->format('d/m/Y') }}</div></div>
                    <div class="sd-info-item"><div class="sd-info-lbl">Vues</div><div class="sd-info-val">{{ number_format($annonce->vues,0,',',' ') }}</div></div>
                    @if($annonce->superficie)<div class="sd-info-item"><div class="sd-info-lbl">Superficie</div><div class="sd-info-val">{{ $annonce->superficie }} m²</div></div>@endif
                </div>
            </div>

            <div class="sd-block">
                <div class="sd-block-title"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>Localisation — {{ $annonce->quartier }}, {{ $annonce->ville }}</div>
                @if($annonce->latitude&&$annonce->longitude)
                    <div class="sd-map-container" id="sdCarte"></div>
                    <script>document.addEventListener('DOMContentLoaded',function(){var c=L.map('sdCarte').setView([{{ $annonce->latitude }},{{ $annonce->longitude }}],15);L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{attribution:'© OpenStreetMap'}).addTo(c);var ico=L.divIcon({html:'<div style="background:#185FA5;width:12px;height:12px;border-radius:50%;border:2px solid white;box-shadow:0 1px 6px rgba(0,0,0,.3);"></div>',iconSize:[16,16],iconAnchor:[8,8],className:''});L.marker([{{ $annonce->latitude }},{{ $annonce->longitude }}],{icon:ico}).addTo(c).bindPopup('<strong style="color:#042C53">{{ addslashes($annonce->titre) }}</strong><br><span style="color:#185FA5;font-weight:600">{{ number_format($annonce->prix,0,","," ") }} FCFA</span>').openPopup()});</script>
                @else
                    <div style="padding:1.5rem;text-align:center;color:#94a3b8;font-size:12px;background:#f8fafc;border-radius:8px">Position GPS non définie</div>
                @endif
            </div>
        </div>

        <div>
            <div class="sd-price-box">
                <div class="sd-price-head">
                    <div>
                        <div class="sd-price-badges">
                            @php $typeColor=match($annonce->type){'location'=>'#1D9E75','vente_maison'=>'#185FA5','vente_terrain'=>'#BA7517','commerce'=>'#534AB7',default=>'#64748b'}; @endphp
                            <span class="sd-type-pill" style="background:{{ $typeColor }}">{{ $typeLabel }}</span>
                            @if($annonce->verifie)<span class="sd-verifie-pill">✓ Vérifié</span>@endif
                        </div>
                        <div class="sd-price-amount">
                            {{ number_format($annonce->prix,0,',',' ') }} FCFA
                            @if($annonce->type==='location')<span>/mois</span>@endif
                        </div>
                        @if($annonce->prix_negotiable)<div class="sd-neg-pill">Prix négociable</div>@endif
                    </div>
                    @auth
                        @if(Auth::id()!==$annonce->user_id)
                            <button type="button" class="sd-fav-btn {{ $estFavori?'active':'' }}" id="sdFavBtn" onclick="sdToggleFav({{ $annonce->id }})">{{ $estFavori?'♥':'♡' }}</button>
                        @endif
                    @endauth
                </div>
                <div class="sd-prop-title">{{ $annonce->titre }}</div>
                <div class="sd-prop-loc"><svg width="12" height="12" viewBox="0 0 24 24" fill="#94a3b8"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>{{ $annonce->quartier }}, {{ $annonce->ville }}</div>
                <div class="sd-prop-stats">
                    @if($annonce->nb_chambres)<div class="sd-prop-stat">{{ $annonce->nb_chambres }} ch.</div>@endif
                    @if($annonce->nb_sdb)<div class="sd-prop-stat">{{ $annonce->nb_sdb }} sdb</div>@endif
                    @if($annonce->superficie)<div class="sd-prop-stat">{{ $annonce->superficie }} m²</div>@endif
                    <div class="sd-prop-stat">{{ $annonce->vues }} vues</div>
                </div>
            </div>

            <div class="sd-contact-box">
                <div class="sd-contact-title">Contacter le propriétaire</div>
                @php
                    $nomAffiche  = $annonce->nom_affiche ?: $annonce->user->name;
                    $scoreProp   = $annonce->user->score ?? 30;
                    $badgeProp   = \App\Services\ScoreService::badge($scoreProp);
                    $scorePropBg = match(true){ $scoreProp>=75=>'#185FA5',$scoreProp>=60=>'#1D9E75',$scoreProp>=40=>'#BA7517',default=>'#A32D2D' };
                @endphp
                {{-- SCORE PROPRIÉTAIRE --}}
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.75rem">
                    <span style="font-size:12px;color:#94a3b8">Réputation GaboPlex</span>
                    <div style="display:flex;align-items:center;gap:6px">
                        <span style="font-size:14px;font-weight:700;color:{{ $scorePropBg }}">{{ $scoreProp }}/100</span>
                        <span style="padding:2px 8px;border-radius:20px;font-size:10px;font-weight:600;background:{{ $badgeProp['bg'] }};color:{{ $badgeProp['color'] }}">{{ $badgeProp['label'] }}</span>
                    </div>
                </div>
                <div style="height:4px;background:#f1f5f9;border-radius:2px;overflow:hidden;margin-bottom:.75rem">
                    <div style="height:100%;width:{{ $scoreProp }}%;background:{{ $scorePropBg }};border-radius:2px"></div>
                </div>
                <div class="sd-agent-row">
                    <div class="sd-avatar">@if($annonce->user->avatar)<img src="{{ asset('storage/'.$annonce->user->avatar) }}" alt="">@else{{ strtoupper(substr($nomAffiche,0,1)) }}@endif</div>
                    <div><div class="sd-agent-name">{{ $nomAffiche }}</div><div class="sd-agent-since">Membre depuis {{ $annonce->user->created_at->format('M Y') }}</div></div>
                </div>
                @php $waRaw=$annonce->whatsapp?:($annonce->user->whatsapp??null)?:($annonce->user->telephone??null); @endphp
                @if($waRaw)
                    @php $num=preg_replace('/[^0-9]/','', $waRaw);$num=ltrim($num,'0');if(str_starts_with($num,'241'))$num=substr($num,3);$num='241'.$num;$msg=urlencode('Bonjour, je suis intéressé(e) par votre annonce "'.$annonce->titre.'" sur GaboPlex. Est-elle toujours disponible ?'); @endphp
                    <a href="https://wa.me/{{ $num }}?text={{ $msg }}" target="_blank" class="sd-btn-wa">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="white"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a8.2 8.2 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413z"/><path d="M12.05 23.9h-.004a11.87 11.87 0 01-6.05-1.655l-.433-.257-4.494 1.179 1.197-4.375-.282-.449A11.845 11.845 0 01.157 11.9C.16 5.35 5.495.01 12.05.01c3.18 0 6.163 1.238 8.41 3.487a11.82 11.82 0 013.483 8.412c-.003 6.552-5.338 11.89-11.893 11.99z"/></svg>
                        WhatsApp · {{ $nomAffiche }}
                    </a>
                @else
                    <div class="sd-no-wa">Aucun numéro WhatsApp renseigné</div>
                @endif
                <div class="sd-sep"><div class="sd-sep-line"></div><span class="sd-sep-txt">ou envoyer un message</span><div class="sd-sep-line"></div></div>
                @guest
                <div style="background:#E6F1FB;border:0.5px solid #B5D4F4;border-radius:10px;padding:1rem;text-align:center;margin-bottom:.75rem">
                    <p style="font-size:13px;color:#185FA5;margin-bottom:.75rem">Connectez-vous pour envoyer un message au propriétaire</p>
                    <a href="{{ route('login') }}?redirect={{ urlencode(request()->fullUrl()) }}" style="display:inline-block;background:#042C53;color:white;padding:9px 20px;border-radius:8px;text-decoration:none;font-size:13px;font-weight:600">Se connecter</a>
                    <a href="{{ route('register') }}" style="display:inline-block;margin-left:8px;background:white;color:#042C53;padding:9px 20px;border-radius:8px;text-decoration:none;font-size:13px;font-weight:500;border:0.5px solid #e2e8f0">S'inscrire</a>
                </div>
                @endguest
                @auth
                <form method="POST" action="{{ route('messages.store',$annonce) }}">
                    @csrf
                    <div class="sd-field"><input type="text" name="expediteur_nom" class="sd-input" placeholder="Votre nom *" required value="{{ Auth::check()?Auth::user()->name:old('expediteur_nom') }}"></div>
                    <div class="sd-field"><input type="email" name="expediteur_email" class="sd-input" placeholder="Votre email *" required value="{{ Auth::check()?Auth::user()->email:old('expediteur_email') }}"></div>
                    <div class="sd-field"><textarea name="contenu" class="sd-input" rows="4" placeholder="Votre message *" required style="resize:vertical">{{ old('contenu') }}</textarea></div>
                    <button type="submit" class="sd-btn-send">Envoyer le message</button>
                </form>
                @endauth
                <div class="sd-report"><a href="#">Signaler cette annonce</a></div>
            </div>
        </div>
    </div>
</div>

<script>
var sdPhotos=[@foreach($annonce->photos as $p)'{{ asset('storage/'.$p->url) }}',@endforeach];
var sdCur=0;
function sdGo(i){sdCur=i;var img=document.getElementById('sdImg');if(img){img.style.opacity='0';setTimeout(function(){img.src=sdPhotos[sdCur];img.style.opacity='1'},150)}var ctr=document.getElementById('sdIdx');if(ctr)ctr.textContent=sdCur+1;document.querySelectorAll('.sd-thumb').forEach(function(t,j){t.classList.toggle('active',j===sdCur)})}
function sdNav(d){sdGo((sdCur+d+sdPhotos.length)%sdPhotos.length)}
document.addEventListener('keydown',function(e){if(sdPhotos.length>1){if(e.key==='ArrowLeft')sdNav(-1);if(e.key==='ArrowRight')sdNav(1)}});
function sdToggleFav(id){@auth var btn=document.getElementById('sdFavBtn');fetch('/favoris/'+id+'/toggle',{method:'POST',headers:{'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content,'Accept':'application/json'}}).then(function(r){return r.json()}).then(function(d){if(d.status==='added'){btn.innerHTML='♥';btn.classList.add('active')}else{btn.innerHTML='♡';btn.classList.remove('active')}});@else window.location.href='{{ route("login") }}';@endauth}
</script>
@endsection