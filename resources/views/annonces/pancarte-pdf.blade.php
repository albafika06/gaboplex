<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            background: white;
            color: #1e293b;
        }

        /* PAGE CENTRÉE */
        .page {
            width: 100%;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 30px 20px;
        }

        /* CARTE PRINCIPALE */
        .carte {
            width: 400px;
            border: 2px solid {{ $couleur }};
            border-radius: 16px;
            overflow: hidden;
            margin: 0 auto;
        }

        /* HEADER */
        .header {
            background: {{ $couleur }};
            padding: 18px 24px 16px;
            text-align: center;
        }
        .logo {
            font-size: 26px;
            font-weight: 900;
            color: white;
            letter-spacing: -1px;
        }
        .logo span {
            color: rgba(255,255,255,0.7);
        }
        .header-sub {
            font-size: 11px;
            color: rgba(255,255,255,0.75);
            margin-top: 4px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .verifie-badge {
            display: inline-block;
            background: rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.4);
            color: white;
            padding: 3px 12px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
            margin-top: 8px;
            letter-spacing: 0.5px;
        }

        /* TYPE BADGE */
        .type-row {
            background: #f8fafc;
            padding: 10px 24px;
            text-align: center;
            border-bottom: 1px solid #e8edf2;
        }
        .type-pill {
            display: inline-block;
            background: {{ $couleur }};
            color: white;
            padding: 4px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        /* QR CODE */
        .qr-section {
            padding: 24px;
            text-align: center;
            background: white;
        }
        .qr-hint {
            font-size: 11px;
            color: #94a3b8;
            margin-bottom: 14px;
            letter-spacing: 0.3px;
        }
        .qr-img {
            width: 200px;
            height: 200px;
            border: 6px solid #f1f5f9;
            border-radius: 12px;
            display: block;
            margin: 0 auto;
        }
        .qr-url {
            font-size: 10px;
            color: {{ $couleur }};
            margin-top: 10px;
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        /* SÉPARATEUR */
        .sep {
            height: 1px;
            background: #e8edf2;
            margin: 0 24px;
        }

        /* INFOS */
        .infos {
            padding: 18px 24px;
            background: white;
        }
        .prix {
            font-size: 28px;
            font-weight: 900;
            color: #042C53;
            letter-spacing: -1px;
            line-height: 1;
            margin-bottom: 4px;
        }
        .prix small {
            font-size: 14px;
            color: #94a3b8;
            font-weight: 400;
            letter-spacing: 0;
        }
        .titre {
            font-size: 14px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 5px;
            line-height: 1.3;
        }
        .localisation {
            font-size: 12px;
            color: #64748b;
            margin-bottom: 12px;
        }
        .chips {
            display: block;
            margin-bottom: 12px;
        }
        .chip {
            display: inline-block;
            background: #f1f5f9;
            color: #475569;
            padding: 3px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            margin-right: 5px;
            margin-bottom: 4px;
        }

        /* WHATSAPP */
        .wa-section {
            background: #EAF3DE;
            padding: 12px 24px;
            display: block;
        }
        .wa-row {
            display: block;
            text-align: center;
        }
        .wa-label {
            font-size: 10px;
            color: #27500A;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
            margin-bottom: 3px;
        }
        .wa-num {
            font-size: 18px;
            font-weight: 900;
            color: #27500A;
            letter-spacing: 1px;
        }

        /* FOOTER */
        .footer {
            background: #042C53;
            padding: 10px 24px;
            text-align: center;
        }
        .footer-txt {
            font-size: 10px;
            color: rgba(255,255,255,0.5);
            letter-spacing: 0.5px;
        }
        .footer-site {
            font-size: 12px;
            color: rgba(255,255,255,0.85);
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        /* NOTE BAS DE PAGE */
        .note {
            width: 400px;
            margin: 20px auto 0;
            text-align: center;
            font-size: 10px;
            color: #94a3b8;
            line-height: 1.6;
        }
    </style>
</head>
<body>
<div class="page">

    <div class="carte">

        <!-- EN-TÊTE -->
        <div class="header">
            <div class="logo">Gabo<span>Plex</span></div>
            <div class="header-sub">Immobilier au Gabon</div>
            <div class="verifie-badge">✓ Annonce vérifiée par GaboPlex</div>
        </div>

        <!-- TYPE -->
        <div class="type-row">
            <span class="type-pill">{{ $typeLabel }}</span>
        </div>

        <!-- QR CODE -->
        <div class="qr-section">
            <div class="qr-hint">Scannez pour voir les photos et les détails</div>
            <img src="{{ $qrBase64 }}" class="qr-img" alt="QR Code GaboPlex">
            <div class="qr-url">gaboplex.ga/annonces/{{ str_pad($annonce->id, 5, '0', STR_PAD_LEFT) }}</div>
        </div>

        <div class="sep"></div>

        <!-- INFOS -->
        <div class="infos">
            <div class="prix">
                {{ $prixFormate }} FCFA
                @if($suffixPrix)<small> {{ $suffixPrix }}</small>@endif
            </div>
            <div class="titre">{{ $annonce->titre }}</div>
            <div class="localisation">📍 {{ $annonce->quartier }}, {{ $annonce->ville }}</div>

            <div class="chips">
                @if($annonce->nb_chambres)
                    <span class="chip">{{ $annonce->nb_chambres }} chambre{{ $annonce->nb_chambres > 1 ? 's' : '' }}</span>
                @endif
                @if($annonce->superficie)
                    <span class="chip">{{ $annonce->superficie }} m²</span>
                @endif
                @if($annonce->meuble)
                    <span class="chip">Meublé</span>
                @endif
                @if($annonce->parking)
                    <span class="chip">Parking</span>
                @endif
                @if($annonce->titre_foncier)
                    <span class="chip">Titre foncier</span>
                @endif
                @if($annonce->verifie)
                    <span class="chip" style="background:#EAF3DE;color:#27500A">✓ Vérifié</span>
                @endif
            </div>
        </div>

        <!-- WHATSAPP -->
        @if($whatsapp)
            <div class="wa-section">
                <div class="wa-row">
                    <div class="wa-label">Contactez directement sur WhatsApp</div>
                    <div class="wa-num">{{ $whatsapp }}</div>
                </div>
            </div>
        @endif

        <!-- FOOTER -->
        <div class="footer">
            <div class="footer-site">www.gaboplex.ga</div>
            <div class="footer-txt">Scannez le QR code pour voir toutes les photos</div>
        </div>

    </div>

    <!-- NOTE -->
    <div class="note">
        Imprimez cette pancarte et collez-la sur votre portail.<br>
        Les passants scannent et arrivent directement sur votre annonce.<br>
        <strong>Réf. GP-{{ str_pad($annonce->id, 5, '0', STR_PAD_LEFT) }}</strong>
    </div>

</div>
</body>
</html>