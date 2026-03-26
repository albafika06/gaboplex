<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription — GaboPlex</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
    *{box-sizing:border-box;margin:0;padding:0}
    body{font-family:'Plus Jakarta Sans','Segoe UI',sans-serif;height:100vh;display:flex;overflow:hidden}
    .auth-left{
        width:50%;position:relative;overflow:hidden;
        display:flex;flex-direction:column;justify-content:flex-end;
        padding:3rem;background:#0a2540;
    }
    .auth-left-bg{
        position:absolute;inset:0;
        background-image:url('https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=1200&q=80');
        background-size:cover;background-position:center right;z-index:0;
    }
    .auth-left-overlay{position:absolute;inset:0;background:linear-gradient(160deg,rgba(10,37,64,.25) 0%,rgba(10,37,64,.88) 100%);z-index:1}
    .auth-left-content{position:relative;z-index:2}
    .auth-left-logo{position:absolute;top:2rem;left:3rem;z-index:3;font-size:20px;font-weight:800;color:white;text-decoration:none;letter-spacing:-.5px}
    .auth-left-logo span{color:#60a5fa}
    .auth-back-btn{
        position:absolute;top:2rem;right:2rem;z-index:3;
        display:inline-flex;align-items:center;gap:6px;
        padding:7px 14px;border-radius:8px;
        background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.2);
        color:rgba(255,255,255,.85);font-size:13px;font-weight:600;
        text-decoration:none;transition:all .2s;
        font-family:'Plus Jakarta Sans','Segoe UI',sans-serif;
    }
    .auth-back-btn:hover{background:rgba(255,255,255,.2);color:white}
    .auth-left-tagline{font-size:1.8rem;font-weight:800;color:white;line-height:1.25;margin-bottom:.75rem;letter-spacing:-.5px}
    .auth-left-tagline em{color:#60a5fa;font-style:normal}
    .auth-left-sub{font-size:13px;color:rgba(255,255,255,.6);line-height:1.7;max-width:340px;margin-bottom:1.5rem}
    .auth-perks{display:flex;flex-direction:column;gap:10px}
    .auth-perk{display:flex;align-items:center;gap:10px;font-size:13px;color:rgba(255,255,255,.8)}
    .auth-perk-icon{width:26px;height:26px;border-radius:50%;background:rgba(59,130,246,.2);border:1px solid rgba(59,130,246,.3);display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .auth-right{
        width:50%;background:white;
        display:flex;flex-direction:column;justify-content:center;
        padding:3rem 4rem;overflow-y:auto;
    }
    .auth-form-title{font-size:26px;font-weight:800;color:#0a2540;margin-bottom:5px;letter-spacing:-.5px}
    .auth-form-sub{font-size:14px;color:#94a3b8;margin-bottom:1.75rem}
    .auth-field{margin-bottom:14px}
    .auth-field label{display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px}
    .auth-input{width:100%;padding:12px 14px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:14px;color:#1e293b;outline:none;transition:border-color .2s,box-shadow .2s;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif;background:white}
    .auth-input:focus{border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.08)}
    .auth-input.error{border-color:#ef4444}
    .auth-err{font-size:12px;color:#ef4444;margin-top:5px;font-weight:500}
    .auth-row{display:grid;grid-template-columns:1fr 1fr;gap:12px}
    .auth-btn{width:100%;background:#0a2540;color:white;border:none;padding:14px;border-radius:10px;font-size:15px;font-weight:700;cursor:pointer;transition:background .2s;margin-top:4px;font-family:'Plus Jakarta Sans','Segoe UI',sans-serif}
    .auth-btn:hover{background:#0f3460}
    .auth-divider{display:flex;align-items:center;gap:12px;margin:18px 0}
    .auth-divider-line{flex:1;height:1px;background:#e8edf2}
    .auth-divider-txt{font-size:13px;color:#94a3b8}
    .auth-link-row{text-align:center;font-size:14px;color:#64748b}
    .auth-link-row a{color:#2563eb;font-weight:600;text-decoration:none}
    .auth-link-row a:hover{color:#1d4ed8}
    .auth-errors-box{background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:12px 14px;margin-bottom:1.25rem}
    .auth-errors-box p{font-size:13px;color:#991b1b;font-weight:500;margin-bottom:2px}
    .auth-cgu{font-size:12px;color:#94a3b8;text-align:center;margin-top:10px;line-height:1.6}
    @media(max-width:768px){
        body{overflow:auto;flex-direction:column;height:auto}
        .auth-left{width:100%;min-height:260px;padding:2rem}
        .auth-back-btn{top:1.25rem;right:1.25rem}
        .auth-left-logo{top:1.25rem;left:1.5rem}
        .auth-right{width:100%;padding:2rem 1.5rem}
        .auth-row{grid-template-columns:1fr}
    }
    </style>
</head>
<body>
    <div class="auth-left">
        <div class="auth-left-bg"></div>
        <div class="auth-left-overlay"></div>
        <a href="{{ route('home') }}" class="auth-left-logo">Gabo<span>Plex</span></a>
        <a href="{{ route('home') }}" class="auth-back-btn">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            Retour à l'accueil
        </a>
        <div class="auth-left-content">
            <div class="auth-left-tagline">Rejoignez la communauté<br>immobilière <em>gabonaise</em></div>
            <div class="auth-left-sub">Créez votre compte gratuitement et commencez à publier ou à trouver votre bien idéal.</div>
            <div class="auth-perks">
                <div class="auth-perk"><div class="auth-perk-icon"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#60a5fa" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg></div>1 annonce gratuite à la création du compte</div>
                <div class="auth-perk"><div class="auth-perk-icon"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#60a5fa" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg></div>Sauvegardez vos annonces favorites</div>
                <div class="auth-perk"><div class="auth-perk-icon"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#60a5fa" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg></div>Alertes pour ne manquer aucune annonce</div>
                <div class="auth-perk"><div class="auth-perk-icon"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#60a5fa" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg></div>Messagerie directe avec les propriétaires</div>
            </div>
        </div>
    </div>

    <div class="auth-right">
        <div class="auth-form-title">Créer un compte</div>
        <div class="auth-form-sub">Gratuit et sans engagement</div>

        @if($errors->any())
            <div class="auth-errors-box">
                @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="auth-field">
                <label for="name">Nom complet</label>
                <input id="name" type="text" name="name" class="auth-input {{ $errors->has('name') ? 'error':'' }}"
                       value="{{ old('name') }}" required autofocus placeholder="Jean-Pierre Mba">
                @error('name')<div class="auth-err">{{ $message }}</div>@enderror
            </div>
            <div class="auth-field">
                <label for="email">Adresse email</label>
                <input id="email" type="email" name="email" class="auth-input {{ $errors->has('email') ? 'error':'' }}"
                       value="{{ old('email') }}" required placeholder="vous@email.com">
                @error('email')<div class="auth-err">{{ $message }}</div>@enderror
            </div>
            <div class="auth-row">
                <div class="auth-field">
                    <label for="password">Mot de passe</label>
                    <input id="password" type="password" name="password" class="auth-input {{ $errors->has('password') ? 'error':'' }}"
                           required placeholder="8 caractères min.">
                    @error('password')<div class="auth-err">{{ $message }}</div>@enderror
                </div>
                <div class="auth-field">
                    <label for="password_confirmation">Confirmer</label>
                    <input id="password_confirmation" type="password" name="password_confirmation"
                           class="auth-input" required placeholder="Répéter">
                </div>
            </div>
            <button type="submit" class="auth-btn">Créer mon compte gratuitement</button>
        </form>

        <div class="auth-cgu">En créant un compte, vous acceptez nos <a href="#" style="color:#2563eb;text-decoration:none">conditions d'utilisation</a>.</div>
        <div class="auth-divider"><div class="auth-divider-line"></div><span class="auth-divider-txt">ou</span><div class="auth-divider-line"></div></div>
        <div class="auth-link-row">Déjà inscrit ? <a href="{{ route('login') }}">Se connecter</a></div>
    </div>
</body>
</html>