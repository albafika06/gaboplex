<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"></head>
<body style="margin:0;padding:0;background:#f8fafc;font-family:'Segoe UI',Arial,sans-serif">
<div style="max-width:560px;margin:40px auto;background:white;border-radius:12px;overflow:hidden;border:1px solid #e2e8f0">
    <div style="background:#042C53;padding:28px 32px;text-align:center">
        <div style="font-size:22px;font-weight:700;color:white;letter-spacing:-.5px">Gabo<span style="color:#85B7EB">Plex</span></div>
    </div>
    <div style="padding:32px">
        <div style="font-size:18px;font-weight:700;color:#042C53;margin-bottom:8px">🎉 Votre annonce a été validée !</div>
        <p style="font-size:14px;color:#475569;line-height:1.7;margin-bottom:16px">
            Bonjour <strong>{{ $annonce->user->name }}</strong>,<br>
            Bonne nouvelle ! Votre annonce est maintenant en ligne et visible par tous les visiteurs de GaboPlex.
        </p>
        <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:16px;margin-bottom:20px">
            <div style="font-weight:600;color:#042C53;margin-bottom:4px">{{ $annonce->titre }}</div>
            <div style="font-size:13px;color:#94a3b8">📍 {{ $annonce->quartier }}, {{ $annonce->ville }}</div>
            <div style="font-size:15px;font-weight:700;color:#185FA5;margin-top:6px">{{ number_format($annonce->prix,0,',',' ') }} FCFA</div>
        </div>
        <a href="{{ route('annonces.show', $annonce) }}" style="display:block;text-align:center;background:#042C53;color:white;padding:13px;border-radius:8px;text-decoration:none;font-weight:600;font-size:14px">
            Voir mon annonce en ligne
        </a>
        <p style="font-size:12px;color:#94a3b8;text-align:center;margin-top:20px">
            Téléchargez votre pancarte QR Code depuis votre dashboard pour afficher votre annonce physiquement.
        </p>
    </div>
    <div style="background:#f8fafc;padding:16px;text-align:center;font-size:11px;color:#94a3b8;border-top:1px solid #e2e8f0">
        © {{ date('Y') }} GaboPlex — La référence immobilière au Gabon
    </div>
</div>
</body>
</html>