<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"></head>
<body style="margin:0;padding:0;background:#f8fafc;font-family:'Segoe UI',Arial,sans-serif">
<div style="max-width:560px;margin:40px auto;background:white;border-radius:12px;overflow:hidden;border:1px solid #e2e8f0">
    <div style="background:#042C53;padding:28px 32px;text-align:center">
        <div style="font-size:22px;font-weight:700;color:white;letter-spacing:-.5px">Gabo<span style="color:#85B7EB">Plex</span></div>
    </div>
    <div style="padding:32px">
        <div style="font-size:18px;font-weight:700;color:#042C53;margin-bottom:8px">💰 Paiement à confirmer</div>
        <p style="font-size:14px;color:#475569;line-height:1.7;margin-bottom:16px">
            Bonjour <strong>{{ $contrat->proprietaire->name }}</strong>,<br>
            <strong>{{ $contrat->locataire->name }}</strong> déclare vous avoir remis un paiement en cash. Veuillez confirmer la réception.
        </p>
        <div style="background:#FAEEDA;border:1px solid #FAC775;border-radius:10px;padding:16px;margin-bottom:16px">
            <div style="font-size:13px;color:#633806;margin-bottom:6px;font-weight:600">Détails du paiement déclaré :</div>
            <div style="font-size:20px;font-weight:700;color:#042C53;margin-bottom:4px">
                {{ number_format($paiement->montant_paye,0,',',' ') }} FCFA
            </div>
            <div style="font-size:13px;color:#854F0B">
                Période : {{ $paiement->periode_label ?? $paiement->periode }}
                · Mode : {{ $paiement->mode_label }}
            </div>
            @if($paiement->montant_restant > 0)
                <div style="font-size:12px;color:#A32D2D;margin-top:6px">
                    ⚠ Reste dû : {{ number_format($paiement->montant_restant,0,',',' ') }} FCFA
                </div>
            @endif
        </div>
        <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:14px;margin-bottom:20px">
            <div style="font-weight:600;color:#042C53;font-size:13px;margin-bottom:3px">{{ $contrat->annonce->titre }}</div>
            <div style="font-size:12px;color:#94a3b8">📍 {{ $contrat->annonce->quartier }}, {{ $contrat->annonce->ville }}</div>
        </div>
        <p style="font-size:13px;color:#475569;line-height:1.6;margin-bottom:20px">
            Connectez-vous pour confirmer la réception ou signaler un problème. La confirmation permet de mettre à jour le score des deux parties.
        </p>
        <a href="{{ route('contrats.show', $contrat) }}" style="display:block;text-align:center;background:#1D9E75;color:white;padding:13px;border-radius:8px;text-decoration:none;font-weight:600;font-size:14px">
            Confirmer la réception du paiement
        </a>
    </div>
    <div style="background:#f8fafc;padding:16px;text-align:center;font-size:11px;color:#94a3b8;border-top:1px solid #e2e8f0">
        © {{ date('Y') }} GaboPlex — La référence immobilière au Gabon
    </div>
</div>
</body>
</html>