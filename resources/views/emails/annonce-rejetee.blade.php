<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"></head>
<body style="margin:0;padding:0;background:#f8fafc;font-family:'Segoe UI',Arial,sans-serif">
<div style="max-width:560px;margin:40px auto;background:white;border-radius:12px;overflow:hidden;border:1px solid #e2e8f0">
    <div style="background:#042C53;padding:28px 32px;text-align:center">
        <div style="font-size:22px;font-weight:700;color:white;letter-spacing:-.5px">Gabo<span style="color:#85B7EB">Plex</span></div>
    </div>
    <div style="padding:32px">
        <div style="font-size:18px;font-weight:700;color:#791F1F;margin-bottom:8px">Annonce non publiée</div>
        <p style="font-size:14px;color:#475569;line-height:1.7;margin-bottom:16px">
            Bonjour <strong>{{ $annonce->user->name }}</strong>,<br>
            Après examen, votre annonce n'a pas pu être publiée. Voici le motif communiqué par notre équipe :
        </p>
        <div style="background:#FCEBEB;border:1px solid #F7C1C1;border-radius:10px;padding:16px;margin-bottom:16px">
            <div style="font-size:13px;font-weight:600;color:#791F1F;margin-bottom:4px">Motif de rejet :</div>
            <div style="font-size:14px;color:#A32D2D;line-height:1.6">{{ $motif }}</div>
        </div>
        <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:14px;margin-bottom:20px">
            <div style="font-weight:600;color:#042C53;margin-bottom:3px">{{ $annonce->titre }}</div>
            <div style="font-size:12px;color:#94a3b8">📍 {{ $annonce->quartier }}, {{ $annonce->ville }}</div>
        </div>
        <p style="font-size:13px;color:#475569;line-height:1.6;margin-bottom:20px">
            Vous pouvez corriger votre annonce et la resoumettre depuis votre espace personnel.
        </p>
        <a href="{{ route('dashboard') }}" style="display:block;text-align:center;background:#042C53;color:white;padding:13px;border-radius:8px;text-decoration:none;font-weight:600;font-size:14px">
            Modifier mon annonce
        </a>
    </div>
    <div style="background:#f8fafc;padding:16px;text-align:center;font-size:11px;color:#94a3b8;border-top:1px solid #e2e8f0">
        © {{ date('Y') }} GaboPlex — La référence immobilière au Gabon
    </div>
</div>
</body>
</html>