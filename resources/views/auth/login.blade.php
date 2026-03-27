<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — GaboPlex</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
    *{box-sizing:border-box;margin:0;padding:0}
    body{font-family:'Plus Jakarta Sans','Segoe UI',sans-serif;height:100vh;display:flex;overflow:hidden}

    /* ── GAUCHE 50% ── */
    .auth-left{
        width:50%;position:relative;overflow:hidden;
        display:flex;flex-direction:column;justify-content:flex-end;
        padding:3rem;background:#0a2540;
    }
    .auth-left-bg{
        position:absolute;inset:0;
        background-image:url('https://images.unsplash.com/photo-1486325212027-8081e485255e?w=1200&q=80');
        background-size:cover;background-position:center;z-index:0;
    }
    .auth-left-overlay{
        position:absolute;inset:0;
        background:linear-gradient(160deg,rgba(10,37,64,.25) 0%,rgba(10,37,64,.88) 100%);
        z-index:1;
    }
    .auth-left-content{position:relative;z-index:2}
    .auth-left-logo{
        position:absolute;top:2rem;left:3rem;z-index:3;
        font-size:20px;font-weight:800;color:white;
        text-decoration:none;letter-spacing:-.5px;
    }
    .auth-left-logo span{color:#60a5fa}
    /* Bouton retour */
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
    .auth-left-tagline{font-size:1.9rem;font-weight:800;color:white;line-height:1.25;margin-bottom:.75rem;letter-spacing:-.5px}
    .auth-left-tagline em{color:#60a5fa;font-style:normal}
    .auth-left-sub{font-size:13px;color:rgba(255,255,255,.6);line-height:1.7;max-width:340px;margin-bottom:1.5rem}
    .auth-left-stats{display:flex;gap:2rem}
    .auth-stat-n{font-size:1.4rem;font-weight:800;color:white;line-height:1}
    .auth-stat-l{font-size:10px;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:1px;margin-top:3px;font-weight:600}

    /* ── DROITE 50% ── */
    .auth-right{
        width:50%;background:white;
        display:flex;flex-direction:column;justify-content:center;
        padding:3rem 4rem;overflow-y:auto;
    }
    .auth-form-title{font-size:26px;font-weight:800;color:#0a2540;margin-bottom:5px;letter-spacing:-.5px}
    .auth-form-sub{font-size:14px;color:#94a3b8;margin-bottom:2rem}
    .auth-field{margin-bottom:16px}
    .auth-field label{display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px}
    .auth-input{
        width:100%;padding:12px 14px;border:1.5px solid #e2e8f0;border-radius:10px;
        font-size:14px;color:#1e293b;outline:none;
        transition:border-color .2s,box-shadow .2s;
        font-family:'Plus Jakarta Sans','Segoe UI',sans-serif;background:white;
    }
    .auth-input:focus{border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.08)}
    .auth-input.error{border-color:#ef4444}
    .auth-err{font-size:12px;color:#ef4444;margin-top:5px;font-weight:500}
    .auth-forgot{font-size:13px;color:#2563eb;text-decoration:none;font-weight:500}
    .auth-forgot:hover{color:#1d4ed8}
    .auth-btn{
        width:100%;background:#0a2540;color:white;border:none;
        padding:14px;border-radius:10px;font-size:15px;font-weight:700;
        cursor:pointer;transition:background .2s;margin-top:4px;
        font-family:'Plus Jakarta Sans','Segoe UI',sans-serif;
    }
    .auth-btn:hover{background:#0f3460}
    .auth-divider{display:flex;align-items:center;gap:12px;margin:20px 0}
    .auth-divider-line{flex:1;height:1px;background:#e8edf2}
    .auth-divider-txt{font-size:13px;color:#94a3b8}
    .auth-link-row{text-align:center;font-size:14px;color:#64748b}
    .auth-link-row a{color:#2563eb;font-weight:600;text-decoration:none}
    .auth-link-row a:hover{color:#1d4ed8}
    .auth-errors-box{background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:12px 14px;margin-bottom:1.5rem}
    .auth-errors-box p{font-size:13px;color:#991b1b;font-weight:500;margin-bottom:2px}
    .auth-success-box{background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:12px 14px;margin-bottom:1.5rem;font-size:13px;color:#166534;font-weight:500}

    @media(max-width:768px){
        body{overflow:auto;flex-direction:column;height:auto}
        .auth-left{width:100%;min-height:280px;padding:2rem}
        .auth-back-btn{top:1.25rem;right:1.25rem}
        .auth-left-logo{top:1.25rem;left:1.5rem}
        .auth-right{width:100%;padding:2rem 1.5rem}
    }
    </style>
</head>
<body>
    <!-- GAUCHE -->
    <div class="auth-left">
        <div class="auth-left-bg"></div>
        <div class="auth-left-overlay"></div>
        <a href="{{ route('home') }}" class="auth-left-logo">Gabo<span>Plex</span></a>
        <a href="{{ route('home') }}" class="auth-back-btn">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            Retour à l'accueil
        </a>
        <div class="auth-left-content">
            <div class="auth-left-tagline">L'immobilier au <em>Gabon</em>,<br>simplifié.</div>
            <div class="auth-left-sub">Location, vente et commerces à Libreville, Port-Gentil et partout au Gabon. Trouvez votre bien idéal parmi nos annonces vérifiées.</div>
            <div class="auth-left-stats">
                <div><div class="auth-stat-n">{{ \App\Models\Annonce::where('statut','active')->count() }}+</div><div class="auth-stat-l">Annonces actives</div></div>
                <div><div class="auth-stat-n">7</div><div class="auth-stat-l">Villes couvertes</div></div>
                <div><div class="auth-stat-n">100%</div><div class="auth-stat-l">Gabonais</div></div>
            </div>
        </div>
    </div>

    <!-- DROITE -->
    <div class="auth-right">
        <div class="auth-form-title">Bon retour 👋</div>
        <div class="auth-form-sub">Connectez-vous à votre compte GaboPlex</div>

        @if($errors->any())
            <div class="auth-errors-box">
                @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
            </div>
        @endif
        @if(session('status'))
            <div class="auth-success-box">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="auth-field">
                <label for="email">Adresse email</label>
                <input id="email" type="email" name="email"
                       class="auth-input {{ $errors->has('email') ? 'error':'' }}"
                       value="{{ old('email') }}" required autofocus autocomplete="username"
                       placeholder="vous@email.com">
                @error('email')<div class="auth-err">{{ $message }}</div>@enderror
            </div>
            <div class="auth-field">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px">
                    <label for="password" style="margin:0">Mot de passe</label>
                    @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="auth-forgot">Mot de passe oublié ?</a>
                    @endif
                </div>
                <input id="password" type="password" name="password"
                       class="auth-input {{ $errors->has('password') ? 'error':'' }}"
                       required autocomplete="current-password" placeholder="••••••••">
                @error('password')<div class="auth-err">{{ $message }}</div>@enderror
            </div>
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:16px">
                <input type="checkbox" name="remember" id="remember" style="accent-color:#0a2540;width:15px;height:15px;cursor:pointer">
                <label for="remember" style="font-size:13px;color:#64748b;cursor:pointer">Se souvenir de moi</label>
            </div>
            <button type="submit" class="auth-btn">Se connecter</button>
        </form>

        <div class="auth-divider">
            <div class="auth-divider-line"></div>
            <span class="auth-divider-txt">ou</span>
            <div class="auth-divider-line"></div>
        </div>
        <div class="auth-link-row">Pas encore de compte ? <a href="{{ route('register') }}">S'inscrire gratuitement</a></div>
    </div>
</body>
</html>
