<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de votre commande</title>
    <style type="text/css">
        body, table, td, th { font-family: Arial, Helvetica, sans-serif; font-size: 14px; }
        /* Basic reset for some clients */
        #outlook a {padding:0;}
        body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;}
        .ExternalClass {width:100%;}
        .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;}
        img {outline:none; text-decoration:none; -ms-interpolation-mode: bicubic;}
        a img {border:none;}
        p {margin: 0 0 1em 0;}
        table {mso-table-lspace:0pt; mso-table-rspace:0pt; border-collapse: collapse;} /* mso for Outlook */
        table td {border-collapse: collapse;}

        /* Responsive Styles - Some clients support this, Gmail app often does not in <style> block */
        @media only screen and (max-width: 600px) {
            .confirmation-container-table {
                width: 100% !important;
                max-width: 100% !important;
            }
            .responsive-text-sm {
                font-size: 13px !important;
                line-height: 18px !important;
            }
            .responsive-text-xl {
                font-size: 18px !important;
                line-height: 26px !important;
            }
             .responsive-text-2xl {
                font-size: 22px !important;
                line-height: 30px !important;
            }
            .responsive-padding {
                padding: 10px !important;
            }
            .responsive-hide {
                display: none !important;
            }
            .responsive-stack-column {
                display: block !important;
                width: 100% !important;
                text-align: left !important;
            }
        }
    </style>
</head>
<body style="background-color: #f7fafc; color: #2d3748; font-family: Arial, Helvetica, sans-serif; margin: 0; padding: 0;">

@php
    // Assuming your PHP variables are set as before
    $nom = $orders[0]->nom ?? 'Client';
    $prenom = $orders[0]->prenom ?? '';
    $refOrder = $orders[0]->red_order ?? 'N/A';
    $email = $orders[0]->email ?? 'N/A';
    $telephone = $orders[0]->telephone ?? 'N/A';
    $adress = $orders[0]->adress ?? 'N/A';
    $modePaiement = $orders[0]->mode_paiement ?? 'N/A';

    $totalProduits = 0;
    foreach ($orders as $order) {
        $totalProduits += ($order->quantite_produit ?? 0) * ($order->prix_produit ?? 0);
    }
    $fraisLivraison = 8;
    $timbreFiscal = 1;
    $totalGeneral = $totalProduits + $fraisLivraison + $timbreFiscal;
@endphp

<table width="100%" border="0" cellpadding="0" cellspacing="0" style="background-color: #f7fafc;">
    <tr>
        <td align="center">
            <table class="confirmation-container-table" width="896" border="0" cellpadding="0" cellspacing="0" style="max-width: 896px; margin-top: 40px; margin-bottom: 40px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">
                <tr>
                    <td align="left" style="padding: 24px;" class="responsive-padding">
                        <h1 style="font-size: 24px; line-height: 32px; font-weight: 700; margin-bottom: 8px; color: #2d3748;" class="responsive-text-2xl">
                            Merci pour votre commande, {{ $nom }} {{ $prenom }} !
                        </h1>
                        <p style="margin-bottom: 24px; color: #718096; font-size: 14px; line-height: 20px;" class="responsive-text-sm">
                            Nous avons bien reçu votre commande. Voici les détails :
                        </p>

                        <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-bottom: 24px; font-size: 14px; line-height: 20px; border: 1px solid #e2e8f0;">
                            <tr>
                                <th style="padding: 8px; text-align: left; font-weight: 600; background-color: #f7fafc; border-bottom: 1px solid #e2e8f0; color: #2d3748;" class="responsive-text-sm">Référence de commande</th>
                                <td style="padding: 8px; text-align: left; border-bottom: 1px solid #e2e8f0; color: #2d3748;" class="responsive-text-sm">{{ $refOrder }}</td>
                            </tr>
                            <tr>
                                <th style="padding: 8px; text-align: left; font-weight: 600; background-color: #f7fafc; border-bottom: 1px solid #e2e8f0; color: #2d3748;" class="responsive-text-sm">Email</th>
                                <td style="padding: 8px; text-align: left; border-bottom: 1px solid #e2e8f0; color: #2d3748;" class="responsive-text-sm">{{ $email }}</td>
                            </tr>
                            <tr>
                                <th style="padding: 8px; text-align: left; font-weight: 600; background-color: #f7fafc; border-bottom: 1px solid #e2e8f0; color: #2d3748;" class="responsive-text-sm">Téléphone</th>
                                <td style="padding: 8px; text-align: left; border-bottom: 1px solid #e2e8f0; color: #2d3748;" class="responsive-text-sm">{{ $telephone }}</td>
                            </tr>
                            <tr>
                                <th style="padding: 8px; text-align: left; font-weight: 600; background-color: #f7fafc; border-bottom: 1px solid #e2e8f0; color: #2d3748;" class="responsive-text-sm">Adresse</th>
                                <td style="padding: 8px; text-align: left; border-bottom: 1px solid #e2e8f0; color: #2d3748;" class="responsive-text-sm">{{ $adress }}</td>
                            </tr>
                            <tr>
                                <th style="padding: 8px; text-align: left; font-weight: 600; background-color: #f7fafc; color: #2d3748;" class="responsive-text-sm">Mode de paiement</th> <td style="padding: 8px; text-align: left; color: #2d3748;" class="responsive-text-sm">{{ $modePaiement }}</td>
                            </tr>
                        </table>

                        <h2 style="font-size: 20px; line-height: 28px; font-weight: 600; margin-bottom: 16px; color: #2d3748;" class="responsive-text-xl">
                            Produits :
                        </h2>

                        <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-bottom: 24px; font-size: 14px; line-height: 20px; border: 1px solid #e2e8f0;">
                            <thead style="background-color: #edf2f7;">
                                <tr>
                                    <th style="padding: 8px; border: 1px solid #e2e8f0; text-align: left; font-weight: 600; color: #2d3748;" class="responsive-text-sm">Produit</th>
                                    <th style="padding: 8px; border: 1px solid #e2e8f0; text-align: left; font-weight: 600; color: #2d3748;" class="responsive-text-sm">Quantité</th>
                                    <th style="padding: 8px; border: 1px solid #e2e8f0; text-align: left; font-weight: 600; color: #2d3748;" class="responsive-text-sm">Prix unitaire (DT)</th>
                                    <th style="padding: 8px; border: 1px solid #e2e8f0; text-align: left; font-weight: 600; color: #2d3748;" class="responsive-text-sm">Total (DT)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr>
                                    <td style="padding: 8px; border: 1px solid #e2e8f0; text-align: left; color: #2d3748;" class="responsive-text-sm">{{ $order->product->name ?? 'Produit inconnu' }}</td>
                                    <td style="padding: 8px; border: 1px solid #e2e8f0; text-align: left; color: #2d3748;" class="responsive-text-sm">{{ $order->quantite_produit ?? 0 }}</td>
                                    <td style="padding: 8px; border: 1px solid #e2e8f0; text-align: left; color: #2d3748;" class="responsive-text-sm">{{ $order->prix_produit ?? 0 }} DT</td>
                                    <td style="padding: 8px; border: 1px solid #e2e8f0; text-align: left; color: #2d3748;" class="responsive-text-sm">{{ ($order->quantite_produit ?? 0) * ($order->prix_produit ?? 0) }} DT</td>
                                </tr>
                                @endforeach

                                <tr>
                                    <td colspan="3" style="padding: 8px; border: 1px solid #e2e8f0; text-align: right; font-weight: 600; background-color: #f7fafc; color: #2d3748;" class="responsive-text-sm">Frais de livraison</td>
                                    <td style="padding: 8px; border: 1px solid #e2e8f0; text-align: left; color: #2d3748;" class="responsive-text-sm">{{ $fraisLivraison }} DT</td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="padding: 8px; border: 1px solid #e2e8f0; text-align: right; font-weight: 600; background-color: #f7fafc; color: #2d3748;" class="responsive-text-sm">Timbre fiscal</td>
                                    <td style="padding: 8px; border: 1px solid #e2e8f0; text-align: left; color: #2d3748;" class="responsive-text-sm">{{ $timbreFiscal }} DT</td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="padding: 8px; border: 1px solid #e2e8f0; text-align: right; font-weight: 700; background-color: #edf2f7; color: #2d3748;" class="responsive-text-sm">Total général</td>
                                    <td style="padding: 8px; border: 1px solid #e2e8f0; text-align: left; font-weight: 700; color: #38a169;" class="responsive-text-sm">{{ $totalGeneral }} DT</td>
                                </tr>
                            </tbody>
                        </table>

                        <p style="font-size: 14px; line-height: 20px; color: #718096; margin-bottom: 0;" class="responsive-text-sm">
                            Nous vous contacterons pour plus d'informations.
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

</body>
</html>