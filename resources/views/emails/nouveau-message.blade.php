<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"></head>
<body style="margin:0;padding:0;background:#f8fafc;font-family:'Segoe UI',Arial,sans-serif">
<div style="max-width:560px;margin:40px auto;background:white;border-radius:12px;overflow:hidden;border:1px solid #e2e8f0">
    <div style="background:#042C53;padding:28px 32px;text-align:center">
        <div style="font-size:22px;font-weight:700;color:white;letter-spacing:-.5px">Gabo<span style="color:#85B7EB">Plex</span></div>
    </div>
    <div style="padding:32px">
        <div style="font-size:18px;font-weight:700;color:#042C53;margin-bottom:8px">💬 Nouveau message</div>
        <p style="font-size:14px;color:#475569;line-height:1.7;margin-bottom:16px">
            <strong>{{ $expediteur->name }}</strong> vous a envoyé un message concernant votre annonce.
        </p>
        <div style="background:#f8fafc;border-left:3px solid #185FA5;border-radius:0 8px 8px 0;padding:14px 16px;margin-bottom:16px">
            <div style="font-size:13px;color:#475569;line-height:1.6;font-style:italic">"{{ $contenu }}"</div>
        </div>
        <div style="background:#f1f5f9;border-radius:8px;padding:12px;margin-bottom:20px;font-size:12px;color:#64748b">
            📍 Annonce : <strong style="color:#042C53">{{ $annonce->titre }}</strong>
        </div>
        <a href="{{ route('messages.index') }}" style="display:block;text-align:center;background:#042C53;color:white;padding:13px;border-radius:8px;text-decoration:none;font-weight:600;font-size:14px">
            Répondre dans GaboPlex
        </a>
        <p style="font-size:11px;color:#94a3b8;text-align:center;margin-top:16px">
            Répondez directement dans l'application pour garder une trace de votre conversation.
        </p>
    </div>
    <div style="background:#f8fafc;padding:16px;text-align:center;font-size:11px;color:#94a3b8;border-top:1px solid #e2e8f0">
        © {{ date('Y') }} GaboPlex — La référence immobilière au Gabon
    </div>
</div>
</body>
</html>