<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de commande</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="shortcut icon" href="https://res.cloudinary.com/dlhonl1wo/image/upload/v1747046500/favicon_tvqtpu.png" type="image/x-icon">

</head>
<body class="bg-gray-50 font-sans">
    <!-- En-tête -->
    @include('dashboard.components.site.nav')

    <main class="container mx-auto px-4 py-40 max-w-4xl">
        <!-- Section confirmation -->
        <section class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex items-center mb-6">
                <div class="bg-green-100 p-3 rounded-full mr-4">
                    <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Merci pour votre commande, {{ $orders->first()->nom }} {{ $orders->first()->prenom }} !</h1>
                    <p class="text-gray-600 mt-1">Votre commande a été enregistrée avec succès.</p>
                </div>
            </div>

            <div class="border-t border-b border-gray-200 py-4 mb-6">
                <div class="flex flex-wrap justify-between items-center">
                    <div class="mb-4 md:mb-0">
                        <p class="text-gray-500 text-sm">Numéro de commande</p>
                        <p class="font-semibold">{{ $orders->first()->red_order }}</p>
                    </div>
                    <div class="mb-4 md:mb-0">
                        <p class="text-gray-500 text-sm">Date</p>
                        <p class="font-semibold">{{ now()->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="mb-4 md:mb-0">
                        <p class="text-gray-500 text-sm">Total</p>
                        <p class="font-semibold text-green-600">
                            {{ number_format($orders->sum(function($order) { 
                                return $order->quantite_produit * $order->prix_produit; 
                            }), 2) }} DT
                        </p>
                    </div>
                    <div class="mb-4 md:mb-0">
                        <p class="text-gray-500 text-sm">Méthode de paiement</p>
                        <p class="font-semibold capitalize">{{ $orders->first()->mode_paiement }}</p>
                    </div>
                </div>
            </div>

            <h2 class="text-xl font-bold text-gray-800 mb-4">Détails de la commande</h2>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produit</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Quantité</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Prix unitaire</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($orders as $order)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $order->product->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">
                                {{ $order->quantite_produit }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">
                                {{ number_format($order->prix_produit, 2) }} DT
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-900">
                                {{ number_format($order->quantite_produit * $order->prix_produit, 2) }} DT
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right text-sm font-medium text-gray-500">
                                Sous-total
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-medium text-gray-900">
                                {{ number_format($orders->sum(function($order) { 
                                    return $order->quantite_produit * $order->prix_produit; 
                                }), 2) }} DT
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right text-sm font-medium text-gray-500">
                                Frais de livraison
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-medium text-gray-900">
                                8.00 DT
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right text-sm font-medium text-gray-500">
                                Taxe
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-medium text-gray-900">
                                1.00 DT
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right text-sm font-bold text-gray-700">
                                Total
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-bold text-green-600">
                                {{ number_format($orders->sum(function($order) { 
                                    return $order->quantite_produit * $order->prix_produit; 
                                }) + 9, 2) }} DT
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </section>

        <!-- Section informations client -->
        <section class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Informations client</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-medium text-gray-700 mb-2">Coordonnées</h3>
                    <p class="text-gray-600">{{ $orders->first()->nom }} {{ $orders->first()->prenom }}</p>
                    <p class="text-gray-600">{{ $orders->first()->email }}</p>
                    <p class="text-gray-600">{{ $orders->first()->telephone }}</p>
                </div>
                
                <div>
                    <h3 class="text-lg font-medium text-gray-700 mb-2">Adresse de livraison</h3>
                    <p class="text-gray-600">{{ $orders->first()->adress }}</p>
                    <p class="text-gray-600">{{ $orders->first()->gouvernorat }}</p>
                </div>
            </div>
        </section>

        <!-- Boutons d'action -->
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="{{ url('/') }}" class="flex-1 bg-black hover:bg-black text-white font-medium py-3 px-6 rounded-full text-center transition duration-200">
                Retour à l'accueil
            </a>
            <a href="#" class="flex-1 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium py-3 px-6 rounded-full text-center transition duration-200">
                Voir mes commandes
            </a>
        </div>
    </main>

    <!-- Script pour vider le panier -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Vider le panier après confirmation de commande
            if (localStorage.getItem('cart')) {
                localStorage.removeItem('cart');
                // Vous pourriez aussi rafraîchir le compteur du panier si nécessaire
                if (typeof updateCartIcon === 'function') {
                    updateCartIcon();
                }
            }
        });
    </script>
</body>
</html>