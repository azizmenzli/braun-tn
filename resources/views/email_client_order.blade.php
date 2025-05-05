<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de votre commande</title>
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

@php
    $totalProduits = 0;
    foreach ($orders as $order) {
        $totalProduits += $order->quantite_produit * $order->prix_produit;
    }
    $fraisLivraison = 8;
    $timbreFiscal = 1;
    $totalGeneral = $totalProduits + $fraisLivraison + $timbreFiscal;
@endphp

<div class="max-w-4xl mx-auto my-10 bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-2">Merci pour votre commande, {{ $orders[0]->nom }} {{ $orders[0]->prenom }} !</h1>
    <p class="mb-6 text-gray-600">Nous avons bien reçu votre commande. Voici les détails :</p>

    <table class="w-full mb-6 text-sm border border-gray-300">
        <tbody>
            <tr class="border-b">
                <th class="text-left p-2 font-semibold bg-gray-100">Référence de commande</th>
                <td class="p-2">{{ $orders[0]->red_order }}</td>
            </tr>
            <tr class="border-b">
                <th class="text-left p-2 font-semibold bg-gray-100">Email</th>
                <td class="p-2">{{ $orders[0]->email }}</td>
            </tr>
            <tr class="border-b">
                <th class="text-left p-2 font-semibold bg-gray-100">Téléphone</th>
                <td class="p-2">{{ $orders[0]->telephone }}</td>
            </tr>
            <tr class="border-b">
                <th class="text-left p-2 font-semibold bg-gray-100">Adresse</th>
                <td class="p-2">{{ $orders[0]->adress }}</td>
            </tr>
            <tr>
                <th class="text-left p-2 font-semibold bg-gray-100">Mode de paiement</th>
                <td class="p-2">{{ $orders[0]->mode_paiement }}</td>
            </tr>
        </tbody>
    </table>

    <h2 class="text-xl font-semibold mb-4">Produits :</h2>

    <table class="w-full text-sm border border-gray-300 mb-6">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-2 border border-gray-300 text-left">Produit</th>
                <th class="p-2 border border-gray-300 text-left">Quantité</th>
                <th class="p-2 border border-gray-300 text-left">Prix unitaire (DT)</th>
                <th class="p-2 border border-gray-300 text-left">Total (DT)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td class="p-2 border border-gray-300">{{ $order->id_produit }}</td>
                    <td class="p-2 border border-gray-300">{{ $order->quantite_produit }}</td>
                    <td class="p-2 border border-gray-300">{{ $order->prix_produit }} DT</td>
                    <td class="p-2 border border-gray-300">{{ $order->quantite_produit * $order->prix_produit }} DT</td>
                </tr>
            @endforeach

            <tr>
                <td colspan="3" class="p-2 text-right font-semibold border border-gray-300 bg-gray-100">Frais de livraison</td>
                <td class="p-2 border border-gray-300">{{ $fraisLivraison }} DT</td>
            </tr>
            <tr>
                <td colspan="3" class="p-2 text-right font-semibold border border-gray-300 bg-gray-100">Timbre fiscal</td>
                <td class="p-2 border border-gray-300">{{ $timbreFiscal }} DT</td>
            </tr>
            <tr>
                <td colspan="3" class="p-2 text-right font-bold border border-gray-300 bg-gray-200">Total général</td>
                <td class="p-2 border border-gray-300 font-bold text-green-600">{{ $totalGeneral }} DT</td>
            </tr>
        </tbody>
    </table>

    <p class="text-sm text-gray-600">Nous vous contacterons pour plus d'informations.</p>
</div>

</body>
</html>
