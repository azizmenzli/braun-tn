<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Braun - Commandes de {{ $client->prenom }} {{ $client->nom }}</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/logo/favicon.png') }}" type="image/x-icon">

    <!-- css links -->
    @include('dashboard.components.style')
</head>

<body>
    <div class="tp-main-wrapper bg-slate-100 min-h-screen" x-data="{ sideMenu: false }">
        @include('dashboard.components.sideleft')

        <!-- Overlay -->
        <div class="fixed inset-0 z-40 bg-black bg-opacity-70 transition-all duration-300" :class="sideMenu ? 'visible opacity-100' : 'invisible opacity-0'" x-on:click="sideMenu = false"></div>

        <div class="tp-main-content lg:ml-[250px] xl:ml-[300px] w-[calc(100%-300px)]" x-data="{ searchOverlay: false }">
            @include('dashboard.components.header')

            <div class="body-content px-8 py-8">
                <div class="flex justify-between items-center mb-10">
                    <div class="page-title">
                        <h3 class="text-[28px] font-bold mb-0">Commandes de {{ $client->prenom }} {{ $client->nom }}</h3>
                    </div>
                </div>

            
                <div class="space-y-6">

                    <div class="bg-white p-6 rounded-xl shadow-md">
                        <p><strong>Email :</strong> {{ $client->email }}</p>
                        <p><strong>Téléphone :</strong> {{ $client->telephone }}</p>
                    </div>

                    @forelse($orders as $redOrder => $orderGroup)
                        <div class="bg-white rounded-xl shadow-md p-6">
                            <div class="mb-4">
                                <h4 class="text-xl font-semibold">Commande n° {{ $redOrder }}</h4>
                                <p class="text-gray-500 text-sm">Date : {{ $orderGroup->first()->date_order }}</p>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="min-w-full text-sm text-left text-gray-500">
                                    <thead class="text-xs uppercase bg-gray-100 text-gray-700">
                                        <tr>
                                            <th class="px-4 py-3">Produit</th>
                                            <th class="px-4 py-3">Image</th>
                                            <th class="px-4 py-3">Quantité</th>
                                            <th class="px-4 py-3">Prix</th>
                                            <th class="px-4 py-3">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($orderGroup as $order)
                                            <tr>
                                                <td class="px-4 py-3 font-medium">{{ $order->product_name }}</td>
                                                <td class="px-4 py-3">
                                                   
                                                </td>
                                                <td class="px-4 py-3">{{ $order->quantite_produit }}</td>
                                                <td class="px-4 py-3">{{ number_format($order->prix_produit, 2) }} DT</td>
                                                <td class="px-4 py-3">{{ number_format($order->prix_produit * $order->quantite_produit, 2) }} DT</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="text-right mt-4 font-bold text-lg">
                                Total commande :
                                {{ number_format($orderGroup->sum(fn($item) => $item->prix_produit * $item->quantite_produit), 2) }} DT
                            </div>
                        </div>
                    @empty
                        <div class="bg-white p-6 rounded-xl shadow-md text-center text-gray-500">
                            Aucune commande trouvée pour ce client.
                        </div>
                    @endforelse

                </div>
            

            </div>
        </div>
    </div>

    @include('dashboard.components.js')
</body>

</html>
