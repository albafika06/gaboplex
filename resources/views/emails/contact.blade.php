<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background:#f8f9fa; margin:0; padding:20px; color:#333; }
        .container { max-width:600px; margin:0 auto; background:white; border-radius:12px; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,0.08); }
        .header { background:linear-gradient(135deg, #1a5276, #2e86c1); padding:30px; text-align:center; }
        .header h1 { color:white; margin:0; font-size:1.4rem; }
        .header span { color:#f39c12; }
        .body { padding:30px; }
        .badge { background:#fef9e7; color:#f39c12; padding:4px 12px; border-radius:20px; font-size:0.8rem; font-weight:600; display:inline-block; margin-bottom:16px; border:1px solid #f39c12; }
        .info-row { display:flex; gap:8px; margin-bottom:10px; font-size:0.9rem; align-items:center; }
        .info-label { color:#777; min-width:80px; font-weight:600; }
        .info-value { color:#333; }
        .message-box { background:#f8f9fa; border-left:4px solid #f39c12; padding:16px; border-radius:0 8px 8px 0; margin:20px 0; }
        .message-box p { margin:0; line-height:1.7; color:#555; }
        .btn { display:inline-block; background:#1a5276; color:white; padding:12px 28px; border-radius:8px; text-decoration:none; font-weight:600; margin-top:20px; }
        .footer { background:#f8f9fa; padding:20px; text-align:center; font-size:0.8rem; color:#aaa; border-top:1px solid #eee; }
        .footer strong { color:#f39c12; }
    </style>
</head>
<body>
    <div class="container">

        <!-- HEADER -->
        <div class="header">
            <h1>Immo<span>Gabon</span></h1>
            <p style="color:rgba(255,255,255,0.85); margin:8px 0 0; font-size:0.95rem;">
                Nouveau message de contact
            </p>
        </div>

        <!-- BODY -->
        <div class="body">

            <div class="badge">Message de contact</div>

            <p style="color:#555; margin-bottom:20px;">
                Un visiteur vous a envoyé un message depuis la page <strong>À propos</strong> d'ImmoGabon.
            </p>

            <!-- INFOS EXPÉDITEUR -->
            <div style="background:#f8f9fa; padding:16px; border-radius:8px; margin-bottom:20px;">
                <div class="info-row">
                    <span class="info-label">Nom :</span>
                    <span class="info-value">{{ $nom }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email :</span>
                    <span class="info-value">{{ $email }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Sujet :</span>
                    <span class="info-value">{{ $sujet }}</span>
                </div>
            </div>

            <!-- MESSAGE -->
            <p style="font-weight:600; color:#333; margin-bottom:8px;">Message :</p>
            <div class="message-box">
                <p>{{ $message }}</p>
            </div>

            <!-- RÉPONDRE -->
            <a href="mailto:{{ $email }}" class="btn">
                Répondre à {{ $nom }}
            </a>

        </div>

        <!-- FOOTER -->
        <div class="footer">
            <p>© {{ date('Y') }} <strong>ImmoGabon</strong> — La référence immobilière au Gabon</p>
            <p style="margin-top:4px;">Message reçu depuis la page À propos.</p>
        </div>

    </div>
</body>
</html>