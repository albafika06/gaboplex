@extends('layouts.app')
@section('title', 'Modifier mon profil')
@section('content')
<style>
.pe-wrap{max-width:760px;margin:0 auto;padding:2rem 1.5rem}
.pe-back{display:inline-flex;align-items:center;gap:6px;color:#64748b;text-decoration:none;font-size:13px;margin-bottom:1.5rem;font-weight:500;transition:color .2s}
.pe-back:hover{color:#0a2540}
.pe-title{font-size:22px;font-weight:800;color:#0a2540;letter-spacing:-.5px;margin-bottom:4px}
.pe-sub{font-size:14px;color:#94a3b8;margin-bottom:2rem}
.pe-block{background:white;border:1px solid #e8edf2;border-radius:16px;padding:1.5rem;margin-bottom:1.5rem}
.pe-block-title{font-size:14px;font-weight:700;color:#0a2540;margin-bottom:1.25rem;padding-bottom:10px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:8px}
.pe-field{margin-bottom:16px}
.pe-field label{display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px}
.pe-field .hint{font-size:12px;color:#94a3b8;margin-top:4px}
.pe-input{width:100%;padding:11px 14px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:14px;color:#1e293b;outline:none;transition:border-color .2s,box-shadow .2s;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif;background:white}
.pe-input:focus{border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.08)}
.pe-input.error{border-color:#ef4444}
.pe-err{font-size:12px;color:#ef4444;margin-top:5px;font-weight:500}
.pe-row{display:grid;grid-template-columns:1fr 1fr;gap:14px}
/* AVATAR */
.pe-avatar-row{display:flex;align-items:center;gap:1.25rem;margin-bottom:1.25rem}
.pe-avatar{width:70px;height:70px;border-radius:50%;background:#0a2540;color:white;display:flex;align-items:center;justify-content:center;font-size:1.5rem;font-weight:700;overflow:hidden;flex-shrink:0;border:3px solid #e2e8f0}
.pe-avatar img{width:100%;height:100%;object-fit:cover}
.pe-avatar-info h4{font-size:14px;font-weight:600;color:#0a2540;margin-bottom:3px}
.pe-avatar-info p{font-size:12px;color:#94a3b8}
/* WA BOX */
.pe-wa-note{background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:10px 14px;font-size:12px;color:#166534;margin-top:6px;display:flex;align-items:center;gap:6px}
/* PASSWORD */
.pe-pwd-toggle{position:relative}
.pe-pwd-toggle input{padding-right:42px}
.pe-pwd-eye{position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#94a3b8;padding:4px}
/* DANGER */
.pe-danger-block{background:#fef2f2;border:1px solid #fecaca;border-radius:16px;padding:1.5rem;margin-bottom:1.5rem}
.pe-danger-title{font-size:14px;font-weight:700;color:#991b1b;margin-bottom:6px}
.pe-danger-sub{font-size:13px;color:#b91c1c;margin-bottom:1rem;line-height:1.6}
.pe-btn-danger{padding:10px 20px;border-radius:10px;background:#dc2626;color:white;border:none;font-size:13px;font-weight:700;cursor:pointer;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif;transition:background .2s}
.pe-btn-danger:hover{background:#b91c1c}
/* ACTIONS */
.pe-actions{display:flex;gap:10px;justify-content:flex-end;flex-wrap:wrap}
.pe-btn-save{padding:12px 28px;border-radius:10px;background:#0a2540;color:white;border:none;font-size:14px;font-weight:700;cursor:pointer;transition:background .2s;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif}
.pe-btn-save:hover{background:#0f3460}
.pe-btn-cancel{padding:12px 20px;border-radius:10px;background:white;color:#64748b;border:1.5px solid #e2e8f0;font-size:14px;font-weight:600;cursor:pointer;text-decoration:none;transition:all .15s;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif}
.pe-btn-cancel:hover{border-color:#94a3b8;color:#0a2540}
.pe-errors-box{background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:12px 14px;margin-bottom:1.5rem}
.pe-errors-box p{font-size:13px;color:#991b1b;font-weight:500;margin-bottom:2px}
@media(max-width:600px){.pe-row{grid-template-columns:1fr}.pe-actions{flex-direction:column}}
</style>

<div class="pe-wrap">
    <a href="{{ route('profile.show') }}" class="pe-back">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Retour au profil
    </a>
    <div class="pe-title">Modifier mon profil</div>
    <div class="pe-sub">Mettez à jour vos informations personnelles</div>

    @if($errors->any())
        <div class="pe-errors-box">
            @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf @method('PATCH')

        <!-- INFOS PERSONNELLES -->
        <div class="pe-block">
            <div class="pe-block-title">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Informations personnelles
            </div>

            <!-- AVATAR -->
            <div class="pe-avatar-row">
                <div class="pe-avatar">
                    @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/'.Auth::user()->avatar) }}" alt="" id="avatarPreview">
                    @else
                        <span id="avatarInitial">{{ strtoupper(substr(Auth::user()->name,0,1)) }}</span>
                        <img src="" alt="" id="avatarPreview" style="display:none">
                    @endif
                </div>
                <div class="pe-avatar-info">
                    <h4>Photo de profil</h4>
                    <p>JPG, PNG — max 2 Mo</p>
                    <label style="display:inline-block;margin-top:6px;padding:6px 14px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:12px;font-weight:600;color:#475569;cursor:pointer;transition:all .15s">
                        Choisir une photo
                        <input type="file" name="avatar" accept="image/*" style="display:none" onchange="previewAvatar(this)">
                    </label>
                </div>
            </div>

            <div class="pe-field">
                <label for="name">Nom complet <span style="color:#dc2626">*</span></label>
                <input id="name" type="text" name="name"
                       class="pe-input {{ $errors->has('name') ? 'error':'' }}"
                       value="{{ old('name', Auth::user()->name) }}" required>
                @error('name')<div class="pe-err">{{ $message }}</div>@enderror
            </div>

            <div class="pe-field">
                <label for="email">Adresse email <span style="color:#dc2626">*</span></label>
                <input id="email" type="email" name="email"
                       class="pe-input {{ $errors->has('email') ? 'error':'' }}"
                       value="{{ old('email', Auth::user()->email) }}" required>
                @error('email')<div class="pe-err">{{ $message }}</div>@enderror
            </div>
        </div>

        <!-- WHATSAPP -->
        <div class="pe-block">
            <div class="pe-block-title">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="#25D366"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                Contact WhatsApp
            </div>
            <div class="pe-field">
                <label for="whatsapp">Numéro WhatsApp</label>
                <input id="whatsapp" type="tel" name="whatsapp"
                       class="pe-input {{ $errors->has('whatsapp') ? 'error':'' }}"
                       value="{{ old('whatsapp', Auth::user()->whatsapp) }}"
                       placeholder="Ex: 074 00 00 00">
                @error('whatsapp')<div class="pe-err">{{ $message }}</div>@enderror
                <div class="pe-wa-note">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M8 12l2 2 4-4"/></svg>
                    Votre numéro sera affiché sur vos annonces. Les acheteurs pourront vous contacter directement.
                </div>
            </div>
        </div>

        <!-- MOT DE PASSE -->
        <div class="pe-block">
            <div class="pe-block-title">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                Changer le mot de passe
            </div>
            <p style="font-size:13px;color:#94a3b8;margin-bottom:1rem">Laissez vide pour conserver votre mot de passe actuel.</p>

            <div class="pe-field">
                <label for="current_password">Mot de passe actuel</label>
                <div class="pe-pwd-toggle">
                    <input id="current_password" type="password" name="current_password"
                           class="pe-input {{ $errors->has('current_password') ? 'error':'' }}"
                           placeholder="Votre mot de passe actuel" autocomplete="current-password">
                    <button type="button" class="pe-pwd-eye" onclick="togglePwd('current_password',this)">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
                @error('current_password')<div class="pe-err">{{ $message }}</div>@enderror
            </div>

            <div class="pe-row">
                <div class="pe-field" style="margin:0">
                    <label for="password">Nouveau mot de passe</label>
                    <div class="pe-pwd-toggle">
                        <input id="password" type="password" name="password"
                               class="pe-input {{ $errors->has('password') ? 'error':'' }}"
                               placeholder="8 caractères min." autocomplete="new-password">
                        <button type="button" class="pe-pwd-eye" onclick="togglePwd('password',this)">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                    @error('password')<div class="pe-err">{{ $message }}</div>@enderror
                </div>
                <div class="pe-field" style="margin:0">
                    <label for="password_confirmation">Confirmer</label>
                    <input id="password_confirmation" type="password" name="password_confirmation"
                           class="pe-input" placeholder="Répéter" autocomplete="new-password">
                </div>
            </div>
        </div>

        <!-- ACTIONS -->
        <div class="pe-actions">
            <a href="{{ route('profile.show') }}" class="pe-btn-cancel">Annuler</a>
            <button type="submit" class="pe-btn-save">Enregistrer les modifications</button>
        </div>
    </form>

    <!-- SUPPRIMER COMPTE -->
    <div class="pe-danger-block" style="margin-top:2rem">
        <div class="pe-danger-title">Zone de danger</div>
        <div class="pe-danger-sub">La suppression de votre compte est irréversible. Toutes vos annonces et données seront définitivement effacées.</div>
        <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Supprimer définitivement votre compte ? Cette action est irréversible.')">
            @csrf @method('DELETE')
            <div class="pe-field">
                <label for="del_password" style="color:#991b1b">Confirmez votre mot de passe</label>
                <input id="del_password" type="password" name="password"
                       class="pe-input" placeholder="Votre mot de passe" style="border-color:#fecaca" required>
            </div>
            <button type="submit" class="pe-btn-danger">Supprimer mon compte</button>
        </form>
    </div>
</div>

<script>
function togglePwd(id, btn) {
    var input = document.getElementById(id);
    if (input.type === 'password') {
        input.type = 'text';
        btn.style.color = '#2563eb';
    } else {
        input.type = 'password';
        btn.style.color = '#94a3b8';
    }
}
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var preview = document.getElementById('avatarPreview');
            var initial = document.getElementById('avatarInitial');
            preview.src = e.target.result;
            preview.style.display = 'block';
            if (initial) initial.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection