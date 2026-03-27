<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'GaboPlex') }} — @yield('title', 'Immobilier au Gabon')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --navy:      #042C53;
            --navy-mid:  #0a2540;
            --blue:      #185FA5;
            --blue-l:    #378ADD;
            --blue-xl:   #E6F1FB;
            --green:     #27500A;
            --green-bg:  #EAF3DE;
            --amber:     #633806;
            --amber-bg:  #FAEEDA;
            --red:       #A32D2D;
            --red-bg:    #FCEBEB;
            --gray-50:   #f8fafc;
            --gray-100:  #f1f5f9;
            --gray-200:  #e2e8f0;
            --gray-300:  #cbd5e1;
            --gray-400:  #94a3b8;
            --gray-500:  #64748b;
            --gray-700:  #334155;
            --gray-800:  #1e293b;
            --radius-xs: 4px;
            --radius-sm: 6px;
            --radius:    8px;
            --radius-md: 10px;
            --radius-lg: 12px;
            --radius-xl: 16px;
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family:'Plus Jakarta Sans', 'Segoe UI', sans-serif;
            background:#f8fafc;
            color:var(--gray-800);
            line-height:1.6;
            font-size:14px;
        }

        /* ══ NAVBAR ══════════════════════════════════════════════════════════ */
        .gp-nav {
            background:white;
            border-bottom:0.5px solid var(--gray-200);
            height:58px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding:0 1.75rem;
            position:sticky;
            top:0;
            z-index:1000;
        }
        .gp-nav-logo {
            display:flex; align-items:center; gap:6px;
            text-decoration:none; flex-shrink:0;
        }
        .gp-nav-logo-text {
            font-size:17px; font-weight:700; color:var(--navy);
            letter-spacing:-0.5px;
        }
        .gp-nav-logo-text span { color:var(--blue-l); }
        .gp-nav-logo-sub {
            font-size:10px; color:var(--gray-400); font-weight:500;
            text-transform:uppercase; letter-spacing:1px; margin-top:1px;
        }
        .gp-nav-links {
            display:flex; align-items:center; gap:1px; flex:1;
            margin:0 1.5rem;
        }
        .gp-nav-link {
            padding:5px 10px; border-radius:var(--radius-sm);
            font-size:13px; font-weight:400; color:var(--gray-500);
            text-decoration:none; transition:all 0.15s; white-space:nowrap;
        }
        .gp-nav-link:hover { color:var(--navy); background:var(--gray-100); }
        .gp-nav-link.active { color:var(--navy); font-weight:600; }
        .gp-nav-right {
            display:flex; align-items:center; gap:6px; flex-shrink:0;
        }
        .gp-nav-icon-btn {
            position:relative; display:flex; align-items:center; gap:5px;
            padding:5px 9px; border-radius:var(--radius-sm);
            font-size:13px; font-weight:400; color:var(--gray-500);
            text-decoration:none; transition:all 0.15s;
        }
        .gp-nav-icon-btn:hover { color:var(--navy); background:var(--gray-100); }
        .gp-notif {
            position:absolute; top:-4px; right:-4px;
            background:var(--red); color:white;
            width:16px; height:16px; border-radius:50%;
            font-size:9px; font-weight:700;
            display:flex; align-items:center; justify-content:center;
            border:1.5px solid white;
        }
        .gp-btn-outline {
            padding:6px 14px; border-radius:var(--radius);
            border:0.5px solid var(--gray-300);
            font-size:13px; font-weight:500; color:var(--gray-700);
            background:white; cursor:pointer; text-decoration:none;
            transition:all 0.15s; white-space:nowrap;
            font-family:'Plus Jakarta Sans','Segoe UI',sans-serif;
        }
        .gp-btn-outline:hover { border-color:var(--gray-400); background:var(--gray-50); color:var(--navy); }
        .gp-btn-primary {
            padding:7px 16px; border-radius:var(--radius);
            border:none; background:var(--navy);
            font-size:13px; font-weight:600; color:white;
            cursor:pointer; text-decoration:none;
            transition:background 0.15s; white-space:nowrap;
            font-family:'Plus Jakarta Sans','Segoe UI',sans-serif;
            display:inline-flex; align-items:center; gap:5px;
        }
        .gp-btn-primary:hover { background:#0a2540; color:white; }
        .gp-btn-admin {
            padding:5px 12px; border-radius:var(--radius);
            border:0.5px solid #B5D4F4;
            background:var(--blue-xl); color:var(--blue);
            font-size:13px; font-weight:500; cursor:pointer;
            text-decoration:none; position:relative;
            transition:all 0.15s; white-space:nowrap;
        }
        .gp-btn-admin:hover { background:#B5D4F4; }
        .gp-hamburger {
            display:none; flex-direction:column; gap:4px;
            cursor:pointer; padding:8px; border:none; background:transparent;
        }
        .gp-hamburger span {
            display:block; width:20px; height:1.5px;
            background:var(--gray-700); border-radius:2px; transition:all 0.3s;
        }

        /* Mobile */
        @media (max-width:768px) {
            .gp-nav { padding:0 1rem; }
            .gp-nav-links {
                display:none; position:absolute;
                top:58px; left:0; right:0;
                background:white; flex-direction:column;
                padding:0.5rem; gap:1px; margin:0;
                border-bottom:0.5px solid var(--gray-200);
                box-shadow:0 8px 24px rgba(0,0,0,0.06);
                z-index:999;
            }
            .gp-nav-links.open { display:flex; }
            .gp-nav-link { width:100%; padding:9px 12px; }
            .gp-nav-right .gp-btn-outline,
            .gp-nav-right .gp-btn-admin { display:none; }
            .gp-hamburger { display:flex; }
            .gp-nav-logo-sub { display:none; }
        }

        /* ══ FLASH ═══════════════════════════════════════════════════════════ */
        .gp-flash {
            padding:10px 18px; margin:0.75rem 1.75rem;
            border-radius:var(--radius); font-size:13px; font-weight:500;
            display:flex; align-items:center; gap:7px;
        }
        .gp-flash-success { background:#EAF3DE; color:var(--green); border:0.5px solid #C0DD97; }
        .gp-flash-error   { background:var(--red-bg); color:var(--red); border:0.5px solid #F7C1C1; }
        .gp-flash-info    { background:var(--blue-xl); color:var(--blue); border:0.5px solid #B5D4F4; }

        /* ══ BADGES TYPE ═════════════════════════════════════════════════════ */
        .badge-location      { background:#1D9E75; }
        .badge-vente_maison  { background:#185FA5; }
        .badge-vente_terrain { background:#BA7517; }
        .badge-commerce      { background:#534AB7; }

        /* ══ FOOTER ══════════════════════════════════════════════════════════ */
        .gp-footer {
            background:var(--navy);
            color:rgba(255,255,255,0.45);
            padding:3rem 1.75rem 0;
            margin-top:5rem;
        }
        .gp-footer-inner {
            max-width:1200px; margin:0 auto;
            display:grid;
            grid-template-columns:2fr 1fr 1fr 1fr;
            gap:3rem;
            padding-bottom:2.5rem;
        }
        .gp-footer-brand .logo-txt {
            font-size:17px; font-weight:700; color:white;
            letter-spacing:-0.5px; margin-bottom:10px;
        }
        .gp-footer-brand .logo-txt span { color:var(--blue-l); }
        .gp-footer-brand p { font-size:13px; color:rgba(255,255,255,0.35); line-height:1.7; max-width:260px; }
        .gp-footer-col h4 {
            font-size:10px; font-weight:600; color:rgba(255,255,255,0.55);
            text-transform:uppercase; letter-spacing:1.5px; margin-bottom:14px;
        }
        .gp-footer-col a {
            display:block; color:rgba(255,255,255,0.35);
            text-decoration:none; font-size:13px;
            margin-bottom:9px; transition:color 0.2s;
        }
        .gp-footer-col a:hover { color:rgba(255,255,255,0.8); }
        .gp-footer-bottom {
            border-top:0.5px solid rgba(255,255,255,0.08);
            padding:1.25rem 0;
            text-align:center; font-size:12px;
            color:rgba(255,255,255,0.25);
        }
        .gp-footer-bottom strong { color:var(--blue-l); font-weight:500; }

        @media (max-width:768px) {
            .gp-footer-inner { grid-template-columns:1fr 1fr; gap:2rem; }
            .gp-flash { margin:0.5rem 1rem; }
        }
        @media (max-width:480px) {
            .gp-footer-inner { grid-template-columns:1fr; }
        }
    </style>
</head>
<body>

<nav class="gp-nav">
    <a href="{{ route('home') }}" class="gp-nav-logo">
        <div>
            <div class="gp-nav-logo-text">Gabo<span>Plex</span></div>
            <div class="gp-nav-logo-sub">Immobilier au Gabon</div>
        </div>
    </a>

    <button class="gp-hamburger" onclick="gpToggleMenu()" id="gpHamburger">
        <span></span><span></span><span></span>
    </button>

    <div class="gp-nav-links" id="gpNavLinks">
        <a href="{{ route('annonces.index') }}"
           class="gp-nav-link {{ request()->routeIs('annonces.index') && !request('type') ? 'active' : '' }}">
            Annonces
        </a>
        <a href="{{ route('annonces.location') }}"
           class="gp-nav-link {{ request()->routeIs('annonces.location') ? 'active' : '' }}">
            Location
        </a>
        <a href="{{ route('annonces.vente') }}"
           class="gp-nav-link {{ request()->routeIs('annonces.vente') ? 'active' : '' }}">
            Vente
        </a>
        <a href="{{ route('annonces.commerces') }}"
           class="gp-nav-link {{ request()->routeIs('annonces.commerces') ? 'active' : '' }}">
            Commerces
        </a>
        <a href="{{ route('apropos') }}" class="gp-nav-link">À propos</a>

        @auth
            @if(Auth::user()->is_admin)
                @php
                    $annoncesEnAttente = \App\Models\Annonce::where('statut','en_attente')->count();
                    $contactsNonLus    = \App\Models\Contact::where('lu',false)->count();
                    $totalNotifs       = $annoncesEnAttente + $contactsNonLus;
                @endphp
                <a href="{{ route('admin.dashboard') }}" class="gp-btn-admin">
                    ⚙ Admin
                    @if($totalNotifs > 0)
                        <span class="gp-notif">{{ $totalNotifs > 9 ? '9+' : $totalNotifs }}</span>
                    @endif
                </a>
            @endif
            <a href="{{ route('profile.show') }}" class="gp-nav-link">Mon profil</a>
            <a href="{{ route('dashboard') }}" class="gp-nav-link">Mon espace</a>
            <a href="{{ route('favoris.index') }}" class="gp-nav-icon-btn">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                Favoris
            </a>
            @php
                // Messages non lus reçus (nouveau système messagerie interne)
                $messagesNonLus = \App\Models\Message::where('receiver_id', Auth::id())
                    ->where('lu', false)->count();
                // Fallback ancien système
                if ($messagesNonLus === 0) {
                    $messagesNonLus = \App\Models\Message::whereHas('annonce', function($q) {
                        $q->where('user_id', Auth::id());
                    })->whereNull('sender_id')->where('lu', false)->count();
                }
            @endphp
            <a href="{{ route('messages.index') }}" class="gp-nav-icon-btn">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                Messages
                @if($messagesNonLus > 0)
                    <span class="gp-notif">{{ $messagesNonLus > 9 ? '9+' : $messagesNonLus }}</span>
                @endif
            </a>
        @endauth
    </div>

    <div class="gp-nav-right">
        @auth
            @php
                $scoreUser = Auth::user()->score ?? 30;
                $scoreBg = match(true) { $scoreUser >= 75 => '#185FA5', $scoreUser >= 60 => '#1D9E75', $scoreUser >= 40 => '#BA7517', default => '#A32D2D' };
            @endphp
            <a href="{{ route('contrats.index') }}" style="display:inline-flex;align-items:center;gap:6px;padding:5px 12px;border-radius:20px;border:0.5px solid #e2e8f0;background:white;text-decoration:none;font-size:12px;font-weight:600;color:#042C53;transition:all .15s" title="Mon score GaboPlex">
                <span style="width:8px;height:8px;border-radius:50%;background:{{ $scoreBg }};flex-shrink:0"></span>
                {{ $scoreUser }}/100
            </a>
            <a href="{{ route('annonces.create') }}" class="gp-btn-primary">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Publier
            </a>
            <form method="POST" action="{{ route('logout') }}" style="display:inline">
                @csrf
                <button type="submit" class="gp-btn-outline" style="cursor:pointer;">Déconnexion</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="gp-btn-outline">Connexion</a>
            <a href="{{ route('register') }}" class="gp-btn-primary">S'inscrire</a>
        @endauth
    </div>
</nav>

@if(session('success'))
    <div class="gp-flash gp-flash-success">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg>
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="gp-flash gp-flash-error">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
        {{ session('error') }}
    </div>
@endif
@if(session('info'))
    <div class="gp-flash gp-flash-info">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        {{ session('info') }}
    </div>
@endif

<main>@yield('content')</main>

<footer class="gp-footer">
    <div class="gp-footer-inner">
        <div class="gp-footer-brand">
            <div class="logo-txt">Gabo<span>Plex</span></div>
            <p>La référence immobilière au Gabon. Trouvez votre bien idéal parmi nos annonces vérifiées.</p>
        </div>
        <div class="gp-footer-col">
            <h4>Navigation</h4>
            <a href="{{ route('annonces.index') }}">Toutes les annonces</a>
            <a href="{{ route('annonces.location') }}">Location</a>
            <a href="{{ route('annonces.vente') }}">Vente</a>
            <a href="{{ route('annonces.commerces') }}">Commerces</a>
        </div>
        <div class="gp-footer-col">
            <h4>Villes</h4>
            <a href="{{ route('annonces.index', ['ville'=>'Libreville']) }}">Libreville</a>
            <a href="{{ route('annonces.index', ['ville'=>'Port-Gentil']) }}">Port-Gentil</a>
            <a href="{{ route('annonces.index', ['ville'=>'Franceville']) }}">Franceville</a>
            <a href="{{ route('annonces.index', ['ville'=>'Oyem']) }}">Oyem</a>
        </div>
        <div class="gp-footer-col">
            <h4>GaboPlex</h4>
            <a href="{{ route('apropos') }}">À propos</a>
            <a href="{{ route('apropos') }}">Contact</a>
            @guest
                <a href="{{ route('register') }}">S'inscrire</a>
                <a href="{{ route('login') }}">Connexion</a>
            @endguest
            @auth
                <a href="{{ route('annonces.create') }}">Publier une annonce</a>
                <a href="{{ route('favoris.index') }}">Mes favoris</a>
                <a href="{{ route('dashboard') }}">Mon espace</a>
            @endauth
        </div>
    </div>
    <div class="gp-footer-bottom">
        &copy; {{ date('Y') }} <strong>GaboPlex</strong> — La référence immobilière au Gabon
    </div>
</footer>

<script>
function gpToggleMenu() {
    document.getElementById('gpNavLinks').classList.toggle('open');
}
document.addEventListener('click', function(e) {
    var nav = document.getElementById('gpNavLinks');
    var btn = document.getElementById('gpHamburger');
    if (nav && btn && !nav.contains(e.target) && !btn.contains(e.target)) {
        nav.classList.remove('open');
    }
});
</script>
</body>
</html>