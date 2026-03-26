<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"></head>
<body style="margin:0;padding:0;background:#f8fafc;font-family:'Segoe UI',Arial,sans-serif">
<div style="max-width:560px;margin:40px auto;background:white;border-radius:12px;overflow:hidden;border:1px solid #e2e8f0">
    <div style="background:#042C53;padding:28px 32px;text-align:center">
        <div style="font-size:22px;font-weight:700;color:white;letter-spacing:-.5px">Gabo<span style="color:#85B7EB">Plex</span></div>
    </div>
    <div style="padding:32px">
        <div style="font-size:18px;font-weight:700;color:#042C53;margin-bottom:8px">📋 Nouvelle proposition de contrat</div>
        <p style="font-size:14px;color:#475569;line-height:1.7;margin-bottom:16px">
            Bonjour <strong>{{ $contrat->proprietaire->name }}</strong>,<br>
            <strong>{{ $contrat->locataire->name }}</strong> souhaite formaliser un accord avec vous via GaboPlex.
        </p>
        <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:16px;margin-bottom:16px">
            <div style="font-weight:700;color:#042C53;margin-bottom:6px">{{ $contrat->annonce->titre }}</div>
            <div style="font-size:13px;color:#94a3b8;margin-bottom:10px">📍 {{ $contrat->annonce->quartier }}, {{ $contrat->annonce->ville }}</div>
            <div style="display:flex;gap:20px;font-size:13px">
                <div>
                    <div style="color:#94a3b8;font-size:10px;text-transform:uppercase;letter-spacing:.5px;margin-bottom:2px">Type</div>
                    <div style="font-weight:600;color:#042C53">{{ ucfirst($contrat->type) }}</div>
                </div>
                <div>
                    <div style="color:#94a3b8;font-size:10px;text-transform:uppercase;letter-spacing:.5px;margin-bottom:2px">Montant</div>
                    <div style="font-weight:600;color:#185FA5">
                        {{ number_format($contrat->type==='location'?$contrat->montant_mensuel:$contrat->montant_total,0,',',' ') }} FCFA
                        @if($contrat->type==='location')/mois@endif
                    </div>
                </div>
                <div>
                    <div style="color:#94a3b8;font-size:10px;text-transform:uppercase;letter-spacing:.5px;margin-bottom:2px">Début</div>
                    <div style="font-weight:600;color:#042C53">{{ $contrat->date_debut->format('d/m/Y') }}</div>
                </div>
            </div>
        </div>
        <p style="font-size:13px;color:#475569;line-height:1.6;margin-bottom:20px">
            Connectez-vous à GaboPlex pour consulter les détails et confirmer ou refuser cette proposition.
        </p>
        <a href="{{ route('contrats.show', $contrat) }}" style="display:block;text-align:center;background:#042C53;color:white;padding:13px;border-radius:8px;text-decoration:none;font-weight:600;font-size:14px">
            Voir la proposition de contrat
        </a>
    </div>
    <div style="background:#f8fafc;padding:16px;text-align:center;font-size:11px;color:#94a3b8;border-top:1px solid #e2e8f0">
        © {{ date('Y') }} GaboPlex — La référence immobilière au Gabon
    </div>
</div>
</body>
</html>