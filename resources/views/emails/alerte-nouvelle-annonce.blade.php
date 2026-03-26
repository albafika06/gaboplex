<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"></head>
<body style="margin:0;padding:0;background:#f8fafc;font-family:'Segoe UI',Arial,sans-serif">
<div style="max-width:560px;margin:40px auto;background:white;border-radius:12px;overflow:hidden;border:1px solid #e2e8f0">
    <div style="background:#042C53;padding:28px 32px;text-align:center">
        <div style="font-size:22px;font-weight:700;color:white;letter-spacing:-.5px">Gabo<span style="color:#85B7EB">Plex</span></div>
    </div>
    <div style="padding:32px">
        <div style="display:inline-block;background:#E6F1FB;color:#0C447C;padding:3px 12px;border-radius:20px;font-size:11px;font-weight:600;margin-bottom:14px">🔔 Nouvelle annonce</div>
        <div style="font-size:17px;font-weight:700;color:#042C53;margin-bottom:8px">Une annonce correspond à votre alerte</div>
        <p style="font-size:14px;color:#475569;line-height:1.7;margin-bottom:20px">
            Bonjour <strong>{{ $alerte->user->name }}</strong>,<br>
            Une nouvelle annonce vient d'être publiée et correspond à votre alerte
            @if($alerte->ville) pour <strong>{{ $alerte->ville }}</strong>@endif.
        </p>
        <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:16px;margin-bottom:20px">
            <div style="font-weight:700;color:#042C53;font-size:15px;margin-bottom:5px">{{ $annonce->titre }}</div>
            <div style="font-size:13px;color:#94a3b8;margin-bottom:8px">📍 {{ $annonce->quartier }}, {{ $annonce->ville }}</div>
            <div style="font-size:17px;font-weight:700;color:#185FA5">
                {{ number_format($annonce->prix,0,',',' ') }} FCFA
                @if($annonce->type==='location')<span style="font-size:12px;color:#94a3b8;font-weight:400">/mois</span>@endif
            </div>
            @if($annonce->nb_chambres || $annonce->superficie)
                <div style="margin-top:8px;font-size:12px;color:#64748b">
                    @if($annonce->nb_chambres){{ $annonce->nb_chambres }} chambre(s)  @endif
                    @if($annonce->superficie)· {{ $annonce->superficie }} m²@endif
                </div>
            @endif
        </div>
        <a href="{{ route('annonces.show', $annonce) }}" style="display:block;text-align:center;background:#042C53;color:white;padding:13px;border-radius:8px;text-decoration:none;font-weight:600;font-size:14px">
            Voir cette annonce
        </a>
        <p style="font-size:11px;color:#94a3b8;text-align:center;margin-top:20px;line-height:1.6">
            Vous recevez cet email car vous avez créé une alerte sur GaboPlex.<br>
            <a href="{{ route('favoris.index') }}" style="color:#185FA5;text-decoration:none">Gérer mes alertes</a>
        </p>
    </div>
    <div style="background:#f8fafc;padding:16px;text-align:center;font-size:11px;color:#94a3b8;border-top:1px solid #e2e8f0">
        © {{ date('Y') }} GaboPlex — La référence immobilière au Gabon
    </div>
</div>
</body>
</html>