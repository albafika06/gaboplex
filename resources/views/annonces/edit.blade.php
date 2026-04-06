@extends('layouts.app')
@section('title', 'Modifier l\'annonce — ' . $annonce->titre)
@section('content')
<style>
/* Réutilise les mêmes styles que create.blade.php */
.wz-page{display:grid;grid-template-columns:280px 1fr;min-height:calc(100vh - 64px)}
@media(max-width:900px){.wz-page{grid-template-columns:1fr}.wz-sidebar{display:none}}
.wz-sidebar{position:relative;overflow:hidden;display:flex;flex-direction:column;justify-content:flex-end;padding:2rem;background:#0a2540}
.wz-sidebar-bg{position:absolute;inset:0;background-image:url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=800&q=80');background-size:cover;background-position:center;opacity:.3}
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
.wz-sidebar-tip{background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);border-radius:10px;padding:10px 12px;font-size:12px;color:rgba(255,255,255,.55);line-height:1.6}
.wz-sidebar-tip strong{color:rgba(255,255,255,.8);font-weight:600}
.wz-main{padding:2rem;overflow-y:auto;background:#f8fafc}
.wz-wrap{max-width:760px;margin:0 auto}

/* CARD PANELS */
.wz-card{background:white;border:1px solid #e8edf2;border-radius:16px;overflow:hidden}
.wz-panel{display:none}
.wz-panel.active{display:block}
.wz-hero{position:relative;height:110px;overflow:hidden}
.wz-hero-img{position:absolute;inset:0;background-size:cover;background-position:center}
.wz-hero-overlay{position:absolute;inset:0;background:linear-gradient(180deg,rgba(10,37,64,.25) 0%,rgba(10,37,64,.82) 100%)}
.wz-hero-content{position:relative;z-index:2;padding:.9rem 1.5rem;display:flex;flex-direction:column;justify-content:flex-end;height:100%}
.wz-hero-title{font-size:16px;font-weight:800;color:white}
.wz-hero-sub{font-size:12px;color:rgba(255,255,255,.6);margin-top:2px}
.wz-hero-1{background-image:url('https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=900&q=70')}
.wz-hero-2{background-image:url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=900&q=70')}
.wz-hero-3{background-image:url('https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=900&q=70')}
.wz-hero-4{background-image:url('https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=900&q=70')}
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

/* PILLS */
.wz-pills{display:flex;flex-wrap:wrap;gap:8px}
.wz-pill-chk{display:none}
.wz-pill-lbl{padding:7px 14px;border-radius:30px;border:1.5px solid #e2e8f0;background:white;font-size:13px;font-weight:600;color:#64748b;cursor:pointer;transition:all .15s;user-select:none}
.wz-pill-chk:checked+.wz-pill-lbl{background:#0a2540;color:white;border-color:#0a2540}

/* PHOTOS */
.wz-drop{border:2px dashed #e2e8f0;border-radius:12px;padding:2rem;text-align:center;cursor:pointer;transition:all .2s;background:#fafbfc}
.wz-drop:hover{border-color:#2563eb;background:#f0f7ff}
.wz-photos-existing{display:flex;flex-wrap:wrap;gap:10px;margin-bottom:1rem}
.wz-thumb-ex{position:relative;width:88px;height:88px;border-radius:10px;overflow:hidden;border:1.5px solid #e2e8f0}
.wz-thumb-ex img{width:100%;height:100%;object-fit:cover}
.wz-thumb-del-chk{display:none}
.wz-thumb-del-lbl{position:absolute;top:3px;right:3px;background:rgba(239,68,68,.9);color:white;border-radius:50%;width:20px;height:20px;cursor:pointer;font-size:11px;display:flex;align-items:center;justify-content:center}
.wz-thumb-del-chk:checked ~ .wz-thumb-del-lbl{background:#dc2626}
.wz-thumb-del-chk:checked ~ img{opacity:.4;filter:grayscale(1)}
.wz-thumb-del-overlay{display:none}
.wz-thumb-del-chk:checked ~ .wz-thumb-del-overlay{display:flex;position:absolute;inset:0;background:rgba(220,38,38,.3);align-items:center;justify-content:center;font-size:20px;color:white}
.wz-photos-preview{display:flex;flex-wrap:wrap;gap:10px;margin-top:1rem}
.wz-thumb{position:relative;width:88px;height:88px;border-radius:10px;overflow:hidden;border:1.5px solid #e2e8f0}
.wz-thumb img{width:100%;height:100%;object-fit:cover}
.wz-thumb-del-btn{position:absolute;top:3px;right:3px;background:rgba(239,68,68,.9);color:white;border:none;border-radius:50%;width:20px;height:20px;cursor:pointer;font-size:11px;display:flex;align-items:center;justify-content:center}

/* MAP */
.wz-map-hint{background:#eff6ff;border:1px solid #bfdbfe;border-radius:8px;padding:9px 13px;font-size:12px;color:#1d4ed8;margin-bottom:10px;display:flex;align-items:center;gap:6px}
#wz-map-container{height:240px;border-radius:10px;overflow:hidden;border:1px solid #e2e8f0}

/* BTNS */
.wz-btn-prev{padding:10px 22px;border-radius:10px;border:1.5px solid #e2e8f0;background:white;color:#64748b;font-size:13px;font-weight:700;cursor:pointer;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif;transition:all .15s}
.wz-btn-prev:hover{border-color:#94a3b8;color:#0a2540}
.wz-btn-next{padding:10px 24px;border-radius:10px;border:none;background:#0a2540;color:white;font-size:13px;font-weight:700;cursor:pointer;display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif;transition:background .2s}
.wz-btn-next:hover{background:#0f3460}
.wz-btn-submit{padding:10px 24px;border-radius:10px;border:none;background:#059669;color:white;font-size:13px;font-weight:700;cursor:pointer;display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif;transition:background .2s}
.wz-btn-submit:hover{background:#047857}
.wz-step-info{font-size:12px;color:#94a3b8}

/* WA */
.wz-wa-wrap{position:relative}
.wz-wa-wrap .wz-input{padding-left:46px}
.wz-wa-icon{position:absolute;left:13px;top:50%;transform:translateY(-50%);width:22px;height:22px;pointer-events:none}
</style>

<div class="wz-page">

    <!-- SIDEBAR -->
    <div class="wz-sidebar">
        <div class="wz-sidebar-bg"></div>
        <div class="wz-sidebar-overlay"></div>
        <a href="{{ route('home') }}" class="wz-sidebar-logo">Gabo<span>Plex</span></a>
        <a href="{{ route('dashboard') }}" class="wz-sidebar-back">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            Retour
        </a>
        <div class="wz-sidebar-content">
            <div class="wz-sidebar-steps" id="wzSidebarSteps">
                <div class="wz-ss-item"><div class="wz-ss-num ss-active" id="wss-1">1</div><span class="wz-ss-lbl ss-active" id="wssl-1">Type &amp; localisation</span></div>
                <div class="wz-ss-item"><div class="wz-ss-num ss-todo" id="wss-2">2</div><span class="wz-ss-lbl ss-todo" id="wssl-2">Détails du bien</span></div>
                <div class="wz-ss-item"><div class="wz-ss-num ss-todo" id="wss-3">3</div><span class="wz-ss-lbl ss-todo" id="wssl-3">Contact &amp; WhatsApp</span></div>
                <div class="wz-ss-item"><div class="wz-ss-num ss-todo" id="wss-4">4</div><span class="wz-ss-lbl ss-todo" id="wssl-4">Photos</span></div>
            </div>
            <div class="wz-sidebar-tip" id="wzSidebarTip">
                <strong>Modification</strong> — Modifiez les informations de votre annonce. Elle sera resoumise à validation.
            </div>
        </div>
    </div>

    <!-- MAIN -->
    <div class="wz-main">
    <div class="wz-wrap">

        <form method="POST" action="{{ route('annonces.update', $annonce) }}" enctype="multipart/form-data" id="wzForm">
            @csrf @method('PUT')

            <!-- ══ ÉTAPE 1 — TYPE & LOCALISATION ══ -->
            <div class="wz-card wz-panel active" id="wp-1">
                <div class="wz-hero"><div class="wz-hero-img wz-hero-1"></div><div class="wz-hero-overlay"></div><div class="wz-hero-content"><div class="wz-hero-title">Type &amp; localisation</div><div class="wz-hero-sub">Étape 1 / 4 — Type et emplacement du bien</div></div></div>
                <div class="wz-body">
                    <div class="wz-group">
                        <label class="wz-label">Type d'annonce <em>*</em></label>
                        <select name="type" class="wz-select" required>
                            <option value="location"     {{ $annonce->type === 'location'     ? 'selected':'' }}>Location</option>
                            <option value="vente_maison" {{ $annonce->type === 'vente_maison' ? 'selected':'' }}>Vente maison / villa</option>
                            <option value="vente_terrain"{{ $annonce->type === 'vente_terrain'? 'selected':'' }}>Vente terrain</option>
                            <option value="commerce"     {{ $annonce->type === 'commerce'     ? 'selected':'' }}>Commerce</option>
                        </select>
                    </div>
                    <div class="wz-group">
                        <label class="wz-label">Sous-type</label>
                        <input type="text" name="sous_type" class="wz-input" placeholder="Ex: appartement, villa, bureau..." value="{{ old('sous_type', $annonce->sous_type) }}">
                    </div>
                    <div class="wz-row">
                        <div class="wz-group">
                            <label class="wz-label">Ville <em>*</em></label>
                            <select name="ville" class="wz-select" required>
                                @foreach(['Libreville','Port-Gentil','Franceville','Oyem','Moanda','Lambaréné','Tchibanga'] as $v)
                                    <option value="{{ $v }}" {{ old('ville',$annonce->ville) === $v ? 'selected':'' }}>{{ $v }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="wz-group">
                            <label class="wz-label">Quartier <em>*</em></label>
                            <input type="text" name="quartier" class="wz-input" placeholder="Ex: Batterie IV, Akanda..." value="{{ old('quartier', $annonce->quartier) }}" required>
                        </div>
                    </div>

                    <!-- CARTE GPS -->
                    <div class="wz-group">
                        <label class="wz-label">Position GPS (optionnel)</label>
                        <div class="wz-map-hint">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>
                            Cliquez sur la carte pour placer le marqueur. Coordonnées actuelles conservées si non modifiées.
                        </div>
                        <div id="wz-map-container"></div>
                        <input type="hidden" name="latitude"  id="wzLat" value="{{ old('latitude',  $annonce->latitude) }}">
                        <input type="hidden" name="longitude" id="wzLng" value="{{ old('longitude', $annonce->longitude) }}">
                    </div>
                </div>
                <div class="wz-footer">
                    <div></div>
                    <div style="display:flex;align-items:center;gap:12px">
                        <span class="wz-step-info">1 / 4</span>
                        <button type="button" class="wz-btn-next" onclick="wzGo(2)">Suivant <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg></button>
                    </div>
                </div>
            </div>

            <!-- ══ ÉTAPE 2 — DÉTAILS ══ -->
            <div class="wz-card wz-panel" id="wp-2">
                <div class="wz-hero"><div class="wz-hero-img wz-hero-2"></div><div class="wz-hero-overlay"></div><div class="wz-hero-content"><div class="wz-hero-title">Informations du bien</div><div class="wz-hero-sub">Étape 2 / 4 — Titre, description, prix et caractéristiques</div></div></div>
                <div class="wz-body">
                    <div class="wz-group">
                        <label class="wz-label">Titre <em>*</em></label>
                        <input type="text" name="titre" class="wz-input" placeholder="Ex: Belle villa F4 à Batterie IV" value="{{ old('titre', $annonce->titre) }}" required>
                    </div>
                    <div class="wz-group">
                        <label class="wz-label">Description <em>*</em></label>
                        <textarea name="description" class="wz-textarea" required>{{ old('description', $annonce->description) }}</textarea>
                    </div>
                    <div class="wz-row">
                        <div class="wz-group">
                            <label class="wz-label">Prix (FCFA) <em>*</em></label>
                            <input type="number" name="prix" class="wz-input" value="{{ old('prix', $annonce->prix) }}" min="0" required>
                        </div>
                        <div class="wz-group">
                            <label class="wz-label">Superficie (m²)</label>
                            <input type="number" name="superficie" class="wz-input" value="{{ old('superficie', $annonce->superficie) }}" min="0">
                        </div>
                    </div>
                    <div class="wz-row">
                        <div class="wz-group">
                            <label class="wz-label">Chambres</label>
                            <select name="nb_chambres" class="wz-select">
                                <option value="">--</option>
                                @for($i=1;$i<=10;$i++)
                                    <option value="{{ $i }}" {{ old('nb_chambres',$annonce->nb_chambres) == $i ? 'selected':'' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="wz-group">
                            <label class="wz-label">Salles de bain</label>
                            <select name="nb_sdb" class="wz-select">
                                <option value="">--</option>
                                @for($i=1;$i<=5;$i++)
                                    <option value="{{ $i }}" {{ old('nb_sdb',$annonce->nb_sdb) == $i ? 'selected':'' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="wz-row">
                        <div class="wz-group">
                            <label class="wz-label">État du bien</label>
                            <select name="etat_bien" class="wz-select">
                                <option value="">-- Choisir --</option>
                                <option value="neuf"      {{ old('etat_bien',$annonce->etat_bien) === 'neuf'      ? 'selected':'' }}>Neuf</option>
                                <option value="bon_etat"  {{ old('etat_bien',$annonce->etat_bien) === 'bon_etat'  ? 'selected':'' }}>Bon état</option>
                                <option value="a_renover" {{ old('etat_bien',$annonce->etat_bien) === 'a_renover' ? 'selected':'' }}>À rénover</option>
                            </select>
                        </div>
                        <div class="wz-group">
                            <label class="wz-label">Caution (FCFA)</label>
                            <input type="number" name="caution" class="wz-input" value="{{ old('caution', $annonce->caution) }}" min="0" placeholder="0">
                        </div>
                    </div>
                    <div class="wz-group">
                        <label class="wz-label">Disponible le</label>
                        <input type="date" name="disponible_le" class="wz-input" value="{{ old('disponible_le', $annonce->disponible_le?->format('Y-m-d')) }}">
                    </div>
                    <div class="wz-group">
                        <label class="wz-label">Options</label>
                        <div class="wz-pills">
                            <input type="checkbox" name="meuble" value="1" id="wpm" class="wz-pill-chk" {{ old('meuble',$annonce->meuble) ? 'checked':'' }}>
                            <label for="wpm" class="wz-pill-lbl">Meublé</label>
                            <input type="checkbox" name="parking" value="1" id="wpp" class="wz-pill-chk" {{ old('parking',$annonce->parking) ? 'checked':'' }}>
                            <label for="wpp" class="wz-pill-lbl">Parking</label>
                            <input type="checkbox" name="titre_foncier" value="1" id="wptf" class="wz-pill-chk" {{ old('titre_foncier',$annonce->titre_foncier) ? 'checked':'' }}>
                            <label for="wptf" class="wz-pill-lbl">Titre foncier</label>
                            <input type="checkbox" name="prix_negotiable" value="1" id="wpn" class="wz-pill-chk" {{ old('prix_negotiable',$annonce->prix_negotiable) ? 'checked':'' }}>
                            <label for="wpn" class="wz-pill-lbl">Prix négociable</label>
                            <input type="checkbox" name="charges_incluses" value="1" id="wpc" class="wz-pill-chk" {{ old('charges_incluses',$annonce->charges_incluses) ? 'checked':'' }}>
                            <label for="wpc" class="wz-pill-lbl">Charges incluses</label>
                        </div>
                    </div>
                </div>
                <div class="wz-footer">
                    <button type="button" class="wz-btn-prev" onclick="wzGo(1)">← Retour</button>
                    <div style="display:flex;align-items:center;gap:12px">
                        <span class="wz-step-info">2 / 4</span>
                        <button type="button" class="wz-btn-next" onclick="wzGo(3)">Suivant <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg></button>
                    </div>
                </div>
            </div>

            <!-- ══ ÉTAPE 3 — CONTACT ══ -->
            <div class="wz-card wz-panel" id="wp-3">
                <div class="wz-hero"><div class="wz-hero-img wz-hero-3"></div><div class="wz-hero-overlay"></div><div class="wz-hero-content"><div class="wz-hero-title">Contact &amp; WhatsApp</div><div class="wz-hero-sub">Étape 3 / 4 — Coordonnées de contact</div></div></div>
                <div class="wz-body">
                    <div class="wz-group">
                        <label class="wz-label">Nom affiché sur l'annonce</label>
                        <input type="text" name="nom_affiche" class="wz-input" placeholder="Ex: Jean Mba ou Agence Prestige" value="{{ old('nom_affiche', $annonce->nom_affiche) }}">
                        <div style="font-size:12px;color:#94a3b8;margin-top:5px">Laissez vide pour afficher votre nom de profil</div>
                    </div>
                    <div class="wz-group">
                        <label class="wz-label">Numéro WhatsApp</label>
                        <div class="wz-wa-wrap">
                            <svg class="wz-wa-icon" viewBox="0 0 24 24" fill="#25D366"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a8.2 8.2 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            <input type="text" name="whatsapp" class="wz-input" placeholder="Ex: 07 12 34 56" value="{{ old('whatsapp', $annonce->whatsapp) }}">
                        </div>
                        <div style="background:#fffbeb;border:1px solid #fde68a;border-radius:8px;padding:9px 12px;margin-top:8px;font-size:12px;color:#92400e;display:flex;gap:8px">
                            <span>⚠️</span> Le numéro doit avoir WhatsApp actif. Les visiteurs vous contacteront directement via WhatsApp.
                        </div>
                    </div>
                </div>
                <div class="wz-footer">
                    <button type="button" class="wz-btn-prev" onclick="wzGo(2)">← Retour</button>
                    <div style="display:flex;align-items:center;gap:12px">
                        <span class="wz-step-info">3 / 4</span>
                        <button type="button" class="wz-btn-next" onclick="wzGo(4)">Suivant <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg></button>
                    </div>
                </div>
            </div>

            <!-- ══ ÉTAPE 4 — PHOTOS ══ -->
            <div class="wz-card wz-panel" id="wp-4">
                <div class="wz-hero"><div class="wz-hero-img wz-hero-4"></div><div class="wz-hero-overlay"></div><div class="wz-hero-content"><div class="wz-hero-title">Photos</div><div class="wz-hero-sub">Étape 4 / 4 — Gérez les photos de votre annonce</div></div></div>
                <div class="wz-body">

                    @if($annonce->photos->isNotEmpty())
                        <div class="wz-group">
                            <label class="wz-label">Photos actuelles — cochez pour supprimer</label>
                            <div class="wz-photos-existing">
                                @foreach($annonce->photos as $photo)
                                    <div class="wz-thumb-ex">
                                        <img src="{{ str_starts_with($photo->url, 'http') ? $photo->url : asset('storage/'.$photo->url) }}" alt="">
                                        <input type="checkbox" name="supprimer_photos[]" value="{{ $photo->id }}" id="del_{{ $photo->id }}" class="wz-thumb-del-chk">
                                        <label for="del_{{ $photo->id }}" class="wz-thumb-del-lbl" title="Supprimer cette photo">✕</label>
                                        <label for="del_{{ $photo->id }}" class="wz-thumb-del-overlay">🗑</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="wz-group">
                        <label class="wz-label">Ajouter de nouvelles photos</label>
                        <div class="wz-drop" id="wzDrop" onclick="document.getElementById('wzPhotos').click()">
                            <div style="font-size:2rem;margin-bottom:8px">📷</div>
                            <div style="font-size:13px;color:#64748b;font-weight:600">Cliquer pour ajouter des photos</div>
                            <div style="font-size:12px;color:#94a3b8;margin-top:4px">JPG, PNG — max 2 Mo par photo</div>
                        </div>
                        <input type="file" name="photos[]" id="wzPhotos" multiple accept="image/*" style="display:none" onchange="wzPreviewPhotos(this)">
                        <div class="wz-photos-preview" id="wzPreview"></div>
                    </div>
                </div>
                <div class="wz-footer">
                    <button type="button" class="wz-btn-prev" onclick="wzGo(3)">← Retour</button>
                    <div style="display:flex;align-items:center;gap:12px">
                        <span class="wz-step-info">4 / 4</span>
                        <button type="submit" class="wz-btn-submit">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg>
                            Enregistrer les modifications
                        </button>
                    </div>
                </div>
            </div>

        </form>

    </div>
    </div>
</div>

<script>
var wzStep = 1;

function wzUpdateSidebar(s) {
    var tips = [
        "Mettez à jour le type et la localisation de votre bien.",
        "Modifiez le titre, la description et les caractéristiques.",
        "Vérifiez votre numéro WhatsApp et le nom affiché.",
        "Ajoutez ou supprimez des photos de votre annonce."
    ];
    for (var i = 1; i <= 4; i++) {
        var n = document.getElementById('wss-'+i), l = document.getElementById('wssl-'+i);
        if (!n || !l) continue;
        n.className = 'wz-ss-num ' + (i < s ? 'ss-done' : i === s ? 'ss-active' : 'ss-todo');
        l.className = 'wz-ss-lbl ' + (i < s ? 'ss-done' : i === s ? 'ss-active' : 'ss-todo');
        n.innerHTML = i < s ? '✓' : String(i);
    }
    var t = document.getElementById('wzSidebarTip');
    if (t) t.innerHTML = '<strong>Étape ' + s + '</strong> — ' + tips[s - 1];
}

function wzGo(n) {
    wzUpdateSidebar(n);
    document.getElementById('wp-' + wzStep).classList.remove('active');
    wzStep = n;
    document.getElementById('wp-' + wzStep).classList.add('active');
    window.scrollTo({top: 0, behavior: 'smooth'});
}

// CARTE GPS
document.addEventListener('DOMContentLoaded', function() {
    @if($annonce->latitude && $annonce->longitude)
        var lat0 = {{ $annonce->latitude }}, lng0 = {{ $annonce->longitude }};
    @else
        var lat0 = 0.4162, lng0 = 9.4673;
    @endif

    var map = L.map('wz-map-container').setView([lat0, lng0], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {attribution:'© OpenStreetMap'}).addTo(map);

    var marker = null;
    @if($annonce->latitude && $annonce->longitude)
        marker = L.marker([lat0, lng0]).addTo(map);
    @endif

    map.on('click', function(e) {
        if (marker) map.removeLayer(marker);
        marker = L.marker([e.latlng.lat, e.latlng.lng]).addTo(map);
        document.getElementById('wzLat').value = e.latlng.lat.toFixed(6);
        document.getElementById('wzLng').value = e.latlng.lng.toFixed(6);
    });
});

// PREVIEW PHOTOS
function wzPreviewPhotos(input) {
    var container = document.getElementById('wzPreview');
    container.innerHTML = '';
    Array.from(input.files).forEach(function(file) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var div = document.createElement('div');
            div.className = 'wz-thumb';
            div.innerHTML = '<img src="' + e.target.result + '" alt="">';
            container.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
}

// Drag & drop
var drop = document.getElementById('wzDrop');
drop.addEventListener('dragover', function(e) { e.preventDefault(); this.classList.add('dragover'); });
drop.addEventListener('dragleave', function() { this.classList.remove('dragover'); });
drop.addEventListener('drop', function(e) {
    e.preventDefault(); this.classList.remove('dragover');
    var input = document.getElementById('wzPhotos');
    input.files = e.dataTransfer.files;
    wzPreviewPhotos(input);
});
</script>
@endsection