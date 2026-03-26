@extends('layouts.app')

@section('title', 'À propos de GaboPlex')

@section('content')
<style>
/* ══ HERO À PROPOS ═══════════════════════════════════════════════════════════ */
.ap-hero{
    position:relative;background:#0a2540;padding:6rem 2rem;
    text-align:center;overflow:hidden;
}
.ap-hero-bg{
    position:absolute;inset:0;
    background-image:url('https://images.unsplash.com/photo-1486325212027-8081e485255e?w=1600&q=80');
    background-size:cover;background-position:center;z-index:0;
}
.ap-hero-overlay{
    position:absolute;inset:0;
    background:linear-gradient(180deg,rgba(10,37,64,.75) 0%,rgba(10,37,64,.95) 100%);
    z-index:1;
}
.ap-hero-content{position:relative;z-index:2;max-width:700px;margin:0 auto}
.ap-hero-pill{
    display:inline-flex;align-items:center;gap:6px;
    background:rgba(59,130,246,.15);border:1px solid rgba(59,130,246,.3);
    color:#93c5fd;padding:5px 16px;border-radius:30px;
    font-size:12px;font-weight:600;letter-spacing:.5px;margin-bottom:1.5rem;
}
.ap-hero h1{font-size:3rem;font-weight:800;color:white;line-height:1.2;margin-bottom:1rem;letter-spacing:-1px}
.ap-hero h1 em{color:#60a5fa;font-style:normal}
.ap-hero p{font-size:16px;color:rgba(255,255,255,.65);line-height:1.8;max-width:560px;margin:0 auto}

/* STATS */
.ap-stats{background:white;border-bottom:1px solid #e2e8f0;padding:2rem;display:flex;justify-content:center;gap:6rem;flex-wrap:wrap}
.ap-stat{text-align:center}
.ap-stat-n{font-size:2.5rem;font-weight:800;color:#0a2540;line-height:1}
.ap-stat-l{font-size:12px;color:#94a3b8;text-transform:uppercase;letter-spacing:1.5px;margin-top:6px;font-weight:600}

/* ══ SECTIONS ═══════════════════════════════════════════════════════════════ */
.ap-section{max-width:1100px;margin:0 auto;padding:5rem 1.5rem}
.ap-section-sm{max-width:800px;margin:0 auto;padding:4rem 1.5rem}

/* MISSION */
.ap-mission-grid{display:grid;grid-template-columns:1fr 1fr;gap:4rem;align-items:center}
.ap-mission-img{border-radius:20px;overflow:hidden;height:420px;position:relative;background:#0a2540}
.ap-mission-img-bg{position:absolute;inset:0;background-image:url('https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=800&q=80');background-size:cover;background-position:center;opacity:.7}
.ap-mission-img-overlay{position:absolute;inset:0;background:linear-gradient(180deg,transparent 50%,rgba(10,37,64,.9) 100%)}
.ap-mission-img-caption{position:absolute;bottom:1.5rem;left:1.5rem;right:1.5rem;z-index:2}
.ap-mission-img-caption h3{font-size:18px;font-weight:700;color:white;margin-bottom:4px}
.ap-mission-img-caption p{font-size:13px;color:rgba(255,255,255,.7)}
.ap-eyebrow{font-size:12px;font-weight:700;color:#2563eb;text-transform:uppercase;letter-spacing:1px;margin-bottom:12px}
.ap-section-title{font-size:2rem;font-weight:800;color:#0a2540;line-height:1.2;margin-bottom:1rem;letter-spacing:-.5px}
.ap-section-title em{color:#2563eb;font-style:normal}
.ap-section-body{font-size:15px;color:#475569;line-height:1.85;margin-bottom:1.5rem}
.ap-values{display:flex;flex-direction:column;gap:14px;margin-top:1.5rem}
.ap-value{display:flex;align-items:flex-start;gap:12px}
.ap-value-icon{width:36px;height:36px;border-radius:10px;background:#eff6ff;border:1px solid #bfdbfe;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px}
.ap-value-title{font-size:14px;font-weight:700;color:#0a2540;margin-bottom:3px}
.ap-value-text{font-size:13px;color:#64748b;line-height:1.6}

/* OFFRES / COMMENT ÇA MARCHE */
.ap-bg-gray{background:#f8fafc;padding:5rem 2rem}
.ap-steps{display:grid;grid-template-columns:repeat(4,1fr);gap:1.5rem;max-width:1100px;margin:0 auto}
.ap-step{background:white;border:1px solid #e8edf2;border-radius:16px;padding:1.5rem;text-align:center;position:relative}
.ap-step-num{width:44px;height:44px;border-radius:50%;background:#0a2540;color:white;display:flex;align-items:center;justify-content:center;font-size:16px;font-weight:800;margin:0 auto 1rem}
.ap-step-title{font-size:15px;font-weight:700;color:#0a2540;margin-bottom:8px}
.ap-step-text{font-size:13px;color:#64748b;line-height:1.6}
.ap-step-arrow{position:absolute;right:-20px;top:50%;transform:translateY(-50%);color:#e2e8f0;font-size:24px;z-index:2}

/* OFFRES */
.ap-offres{display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;max-width:1100px;margin:0 auto}
.ap-offre{background:white;border:1px solid #e8edf2;border-radius:16px;padding:1.5rem;text-align:center;transition:box-shadow .2s,transform .2s}
.ap-offre:hover{box-shadow:0 8px 32px rgba(0,0,0,.08);transform:translateY(-3px)}
.ap-offre-icon{font-size:2rem;margin-bottom:12px}
.ap-offre-name{font-size:16px;font-weight:800;color:#0a2540;margin-bottom:4px}
.ap-offre-price{font-size:1.4rem;font-weight:800;color:#2563eb;margin-bottom:12px}
.ap-offre-price small{font-size:13px;color:#94a3b8;font-weight:500}
.ap-offre-features{list-style:none;padding:0;text-align:left}
.ap-offre-features li{font-size:13px;color:#475569;padding:4px 0;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:6px}
.ap-offre-features li:last-child{border-bottom:none}
.ap-offre-features li::before{content:'✓';color:#059669;font-weight:700;flex-shrink:0}
.ap-offre-features li.na::before{content:'○';color:#cbd5e1}
.ap-offre.featured{border:2px solid #2563eb}
.ap-featured-badge{background:#2563eb;color:white;font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;display:inline-block;margin-bottom:12px}

/* ÉQUIPE / CONTACT */
.ap-contact{background:#0a2540;padding:5rem 2rem;text-align:center}
.ap-contact h2{font-size:2rem;font-weight:800;color:white;margin-bottom:1rem;letter-spacing:-.5px}
.ap-contact p{font-size:15px;color:rgba(255,255,255,.65);max-width:500px;margin:0 auto 2rem;line-height:1.7}
.ap-contact-btns{display:flex;gap:12px;justify-content:center;flex-wrap:wrap}
.ap-btn-white{padding:14px 28px;border-radius:10px;background:white;color:#0a2540;font-size:14px;font-weight:700;text-decoration:none;border:none;cursor:pointer;transition:all .2s}
.ap-btn-white:hover{background:#f1f5f9}
.ap-btn-outline-white{padding:14px 28px;border-radius:10px;background:transparent;color:white;font-size:14px;font-weight:700;text-decoration:none;border:2px solid rgba(255,255,255,.3);transition:all .2s}
.ap-btn-outline-white:hover{background:rgba(255,255,255,.08);color:white;border-color:rgba(255,255,255,.5)}
.ap-contact-info{display:flex;gap:3rem;justify-content:center;margin-top:3rem;flex-wrap:wrap}
.ap-contact-item{text-align:center}
.ap-contact-item-icon{width:44px;height:44px;border-radius:50%;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.15);display:flex;align-items:center;justify-content:center;margin:0 auto 8px}
.ap-contact-item-label{font-size:11px;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:1px;margin-bottom:4px;font-weight:600}
.ap-contact-item-val{font-size:14px;color:white;font-weight:500}

/* VILLES */
.ap-villes{background:white;padding:4rem 2rem;border-top:1px solid #e8edf2}
.ap-villes-inner{max-width:1100px;margin:0 auto;text-align:center}
.ap-villes-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-top:2rem}
.ap-ville-card{background:#f8fafc;border:1px solid #e8edf2;border-radius:12px;padding:1.25rem;text-align:center;text-decoration:none;transition:all .2s}
.ap-ville-card:hover{background:#0a2540;border-color:#0a2540}
.ap-ville-card:hover .ap-ville-name{color:white}
.ap-ville-card:hover .ap-ville-count{color:rgba(255,255,255,.6)}
.ap-ville-name{font-size:15px;font-weight:700;color:#0a2540;margin-bottom:4px}
.ap-ville-count{font-size:12px;color:#94a3b8}

@media(max-width:900px){.ap-mission-grid{grid-template-columns:1fr}.ap-steps{grid-template-columns:1fr 1fr}.ap-offres{grid-template-columns:1fr 1fr}.ap-step-arrow{display:none}.ap-villes-grid{grid-template-columns:1fr 1fr}}
@media(max-width:600px){.ap-hero h1{font-size:2rem}.ap-stats{gap:2rem}.ap-steps{grid-template-columns:1fr}.ap-offres{grid-template-columns:1fr}.ap-section{padding:3rem 1rem}.ap-section-title{font-size:1.5rem}.ap-villes-grid{grid-template-columns:1fr 1fr}}
</style>

<!-- HERO -->
<div class="ap-hero">
    <div class="ap-hero-bg"></div>
    <div class="ap-hero-overlay"></div>
    <div class="ap-hero-content">
        <div class="ap-hero-pill">
            <span style="width:6px;height:6px;background:#3b82f6;border-radius:50%"></span>
            La référence immobilière gabonaise
        </div>
        <h1>À propos de <em>GaboPlex</em></h1>
        <p>Une plateforme 100% gabonaise, créée pour simplifier l'accès à l'immobilier partout au Gabon.</p>
    </div>
</div>

<!-- STATS -->
<div class="ap-stats">
    <div class="ap-stat">
        <div class="ap-stat-n">{{ $stats['annonces'] }}+</div>
        <div class="ap-stat-l">Annonces actives</div>
    </div>
    <div class="ap-stat">
        <div class="ap-stat-n">{{ $stats['users'] }}+</div>
        <div class="ap-stat-l">Utilisateurs inscrits</div>
    </div>
    <div class="ap-stat">
        <div class="ap-stat-n">{{ $stats['villes'] }}</div>
        <div class="ap-stat-l">Villes couvertes</div>
    </div>
    <div class="ap-stat">
        <div class="ap-stat-n">100%</div>
        <div class="ap-stat-l">Made in Gabon</div>
    </div>
</div>

<!-- MISSION -->
<div class="ap-section">
    <div class="ap-mission-grid">
        <div class="ap-mission-img">
            <div class="ap-mission-img-bg"></div>
            <div class="ap-mission-img-overlay"></div>
            <div class="ap-mission-img-caption">
                <h3>Libreville, Gabon</h3>
                <p>Notre marché principal, avec des milliers de biens disponibles</p>
            </div>
        </div>
        <div>
            <div class="ap-eyebrow">Notre mission</div>
            <div class="ap-section-title">L'immobilier gabonais,<br><em>accessible à tous</em></div>
            <div class="ap-section-body">
                GaboPlex est né d'un constat simple : trouver ou publier un bien immobilier au Gabon était compliqué, peu transparent et souvent peu fiable. Nous avons créé une plateforme qui change ça.
            </div>
            <div class="ap-section-body">
                Que vous cherchiez à louer un appartement à Libreville, vendre une villa à Port-Gentil, ou trouver un local commercial à Franceville — GaboPlex vous connecte directement avec les bons interlocuteurs.
            </div>
            <div class="ap-values">
                <div class="ap-value">
                    <div class="ap-value-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg>
                    </div>
                    <div>
                        <div class="ap-value-title">Transparence totale</div>
                        <div class="ap-value-text">Chaque annonce est vérifiée par notre équipe avant publication. Aucune mauvaise surprise.</div>
                    </div>
                </div>
                <div class="ap-value">
                    <div class="ap-value-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </div>
                    <div>
                        <div class="ap-value-title">Sécurité & confiance</div>
                        <div class="ap-value-text">Contact direct via WhatsApp, messagerie interne, et modération active des annonces frauduleuses.</div>
                    </div>
                </div>
                <div class="ap-value">
                    <div class="ap-value-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
                    </div>
                    <div>
                        <div class="ap-value-title">Rapidité & simplicité</div>
                        <div class="ap-value-text">Publiez une annonce en 5 minutes, trouvez un bien en quelques clics. Pas de complications.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- COMMENT ÇA MARCHE -->
<div class="ap-bg-gray">
    <div style="max-width:1100px;margin:0 auto;text-align:center;margin-bottom:3rem">
        <div class="ap-eyebrow" style="text-align:center">Processus simple</div>
        <div class="ap-section-title" style="margin-bottom:.5rem">Comment ça marche ?</div>
        <p style="font-size:15px;color:#64748b;max-width:500px;margin:0 auto">Publier ou trouver un bien en 4 étapes simples</p>
    </div>
    <div class="ap-steps">
        <div class="ap-step">
            <div class="ap-step-num">1</div>
            <div class="ap-step-title">Créez votre compte</div>
            <div class="ap-step-text">Inscription gratuite en 30 secondes. Pas de carte bancaire requise.</div>
            <div class="ap-step-arrow">→</div>
        </div>
        <div class="ap-step">
            <div class="ap-step-num">2</div>
            <div class="ap-step-title">Publiez ou cherchez</div>
            <div class="ap-step-text">Publiez votre annonce avec photos et localisation, ou utilisez nos filtres pour trouver le bien idéal.</div>
            <div class="ap-step-arrow">→</div>
        </div>
        <div class="ap-step">
            <div class="ap-step-num">3</div>
            <div class="ap-step-title">Contactez directement</div>
            <div class="ap-step-text">WhatsApp, messagerie interne ou formulaire de contact — choisissez votre mode de communication.</div>
            <div class="ap-step-arrow">→</div>
        </div>
        <div class="ap-step">
            <div class="ap-step-num">4</div>
            <div class="ap-step-title">Concluez l'affaire</div>
            <div class="ap-step-text">Visitez, négociez et signez. GaboPlex vous accompagne jusqu'à la conclusion.</div>
        </div>
    </div>
</div>

<!-- OFFRES -->
<div class="ap-section">
    <div style="text-align:center;margin-bottom:3rem">
        <div class="ap-eyebrow" style="text-align:center">Nos offres</div>
        <div class="ap-section-title" style="margin-bottom:.5rem">Publiez selon vos besoins</div>
        <p style="font-size:15px;color:#64748b;max-width:500px;margin:0 auto">Une annonce gratuite pour commencer, des offres payantes pour plus de visibilité.</p>
    </div>
    <div class="ap-offres">
        <div class="ap-offre">
            <div class="ap-offre-icon">🆓</div>
            <div class="ap-offre-name">Gratuit</div>
            <div class="ap-offre-price">0 <small>FCFA</small></div>
            <ul class="ap-offre-features">
                <li>1 annonce à vie</li>
                <li>Visible après validation</li>
                <li class="na">Ordre normal</li>
                <li class="na">Pas de badge</li>
            </ul>
        </div>
        <div class="ap-offre">
            <div class="ap-offre-icon">🚀</div>
            <div class="ap-offre-name">Boost</div>
            <div class="ap-offre-price">2 000 <small>FCFA</small></div>
            <ul class="ap-offre-features">
                <li>Badge doré "Boost"</li>
                <li>Priorité dans les résultats</li>
                <li>Stats de vues</li>
                <li>Valable 14 jours</li>
            </ul>
        </div>
        <div class="ap-offre featured">
            <div class="ap-featured-badge">⭐ Populaire</div>
            <div class="ap-offre-icon">💎</div>
            <div class="ap-offre-name">Premium</div>
            <div class="ap-offre-price">5 000 <small>FCFA</small></div>
            <ul class="ap-offre-features">
                <li>Badge bleu "Premium"</li>
                <li>Tête de liste garantie</li>
                <li>Affiché en page d'accueil</li>
                <li>Stats avancées · 30 jours</li>
            </ul>
        </div>
        <div class="ap-offre">
            <div class="ap-offre-icon">👑</div>
            <div class="ap-offre-name">Pro annuel</div>
            <div class="ap-offre-price">25 000 <small>FCFA/an</small></div>
            <ul class="ap-offre-features">
                <li>Annonces illimitées</li>
                <li>Badge "Pro" doré</li>
                <li>Tout Premium inclus</li>
                <li>Valable 1 an</li>
            </ul>
        </div>
    </div>
</div>

<!-- VILLES -->
<div class="ap-villes">
    <div class="ap-villes-inner">
        <div class="ap-eyebrow">Couverture nationale</div>
        <div class="ap-section-title">Présents dans tout le Gabon</div>
        <p style="font-size:15px;color:#64748b;max-width:500px;margin:0 auto">De Libreville à Tchibanga, nous couvrons les principales villes du pays.</p>
        <div class="ap-villes-grid">
            @php
                $villes = ['Libreville', 'Port-Gentil', 'Franceville', 'Oyem', 'Moanda', 'Lambaréné', 'Tchibanga', 'Mouila'];
            @endphp
            @foreach($villes as $ville)
                @php
                    $count = \App\Models\Annonce::where('statut','active')->where('ville',$ville)->count();
                @endphp
                <a href="{{ route('annonces.index', ['ville' => $ville]) }}" class="ap-ville-card">
                    <div class="ap-ville-name">{{ $ville }}</div>
                    <div class="ap-ville-count">{{ $count }} annonce{{ $count > 1 ? 's':'' }}</div>
                </a>
            @endforeach
        </div>
    </div>
</div>

<!-- CONTACT / CTA -->
<div class="ap-contact">
    <h2>Une question ? Contactez-nous</h2>
    <p>Notre équipe est disponible pour vous aider à publier votre annonce ou à trouver le bien idéal.</p>
    <div class="ap-contact-btns">
        <a href="{{ route('annonces.create') }}" class="ap-btn-white">Publier une annonce</a>
        <a href="{{ route('annonces.index') }}" class="ap-btn-outline-white">Voir les annonces</a>
    </div>
    <div class="ap-contact-info">
        <div class="ap-contact-item">
            <div class="ap-contact-item-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,.7)" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            </div>
            <div class="ap-contact-item-label">Email</div>
            <div class="ap-contact-item-val">contact@gaboplex.ga</div>
        </div>
        <div class="ap-contact-item">
            <div class="ap-contact-item-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="#25D366"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            </div>
            <div class="ap-contact-item-label">WhatsApp</div>
            <div class="ap-contact-item-val">+241 XX XXX XXX</div>
        </div>
        <div class="ap-contact-item">
            <div class="ap-contact-item-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,.7)" stroke-width="2"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
            </div>
            <div class="ap-contact-item-label">Adresse</div>
            <div class="ap-contact-item-val">Libreville, Gabon</div>
        </div>
    </div>
</div>

@endsection