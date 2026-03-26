<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family:'Segoe UI',sans-serif; background:#f0f4f8; margin:0; padding:0; }
        .wrapper { max-width:560px; margin:2rem auto; background:white; border-radius:16px; border:1px solid #e8edf2; overflow:hidden; }
        .header { background:#0a2540; padding:1.5rem 2rem; }
        .header-logo { color:white; font-size:1.2rem; font-weight:800; }
        .header-logo span { color:#3b82f6; }
        .body { padding:2rem; }
        .icon { font-size:3rem; text-align:center; margin-bottom:1rem; }
        h2 { color:#0a2540; font-size:1.2rem; font-weight:800; text-align:center; margin-bottom:0.5rem; }
        .subtitle { color:#94a3b8; font-size:0.875rem; text-align:center; margin-bottom:1.5rem; }
        .detail-box { background:#f0fdf4; border:1px solid #bbf7d0; border-radius:12px; padding:1.2rem; margin-bottom:1.5rem; }
        .detail-row { display:flex; justify-content:space-between; padding:5px 0; font-size:0.87rem; border-bottom:1px solid #dcfce7; }
        .detail-row:last-child { border-bottom:none; }
        .detail-key { color:#64748b; }
        .detail-val { font-weight:700; color:#0a2540; }
        .btn { display:block; background:#3b82f6; color:white; text-decoration:none; padding:14px 24px; border-radius:10px; font-weight:700; font-size:0.95rem; text-align:center; margin-bottom:1.5rem; }
        .note { background:#fffbeb; border:1px solid #fde68a; border-radius:8px; padding:10px 14px; font-size:0.78rem; color:#92400e; }
        .footer { padding:1rem 2rem; border-top:1px solid #f1f5f9; font-size:0.75rem; color:#94a3b8; text-align:center; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <div class="header-logo">Gabo<span>Plex</span></div>
    </div>
    <div class="body">
        <div class="icon">✅</div>
        <h2>Paiement confirmé !</h2>
        <p class="subtitle">Votre annonce est maintenant en cours de validation par notre équipe.</p>

        <div class="detail-box">
            <div class="detail-row">
                <span class="detail-key">Offre</span>
                <span class="detail-val">{{ $offre }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-key">Montant payé</span>
                <span class="detail-val">{{ number_format($montant, 0, ',', ' ') }} FCFA</span>
            </div>
            <div class="detail-row">
                <span class="detail-key">Annonce</span>
                <span class="detail-val">{{ $annonce->titre }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-key">Expire le</span>
                <span class="detail-val">{{ $expire }}</span>
            </div>
        </div>

        <a href="{{ route('annonces.show', $annonce->id) }}" class="btn">Voir mon annonce →</a>

        <div class="note">
            ⏳ Votre annonce sera visible après validation par notre équipe (sous 24h). Vous recevrez un second email de confirmation.
        </div>
    </div>
    <div class="footer">© {{ date('Y') }} GaboPlex — La référence immobilière au Gabon</div>
</div>
</body>
</html>