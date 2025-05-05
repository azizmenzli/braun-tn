<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier - Braun TN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    @include('dashboard.components.site.nav')

    <main class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">Votre Panier</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(count($products) > 0)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produit</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Prix</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Quantité</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($products as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $item['product']->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">
                                    {{ number_format($item['product']->price, 2) }} DT
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">
                                    <form action="{{ route('cart.update', $item['product']->id) }}" method="POST" class="flex items-center justify-end">
                                        @csrf
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="w-16 text-center border rounded">
                                        <button type="submit" class="ml-2 text-blue-600 hover:text-blue-800">
                                            <i class="fas fa-sync"></i>
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-900">
                                    {{ number_format($item['product']->price * $item['quantity'], 2) }} DT
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <form action="{{ route('cart.remove', $item['product']->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right text-sm font-medium text-gray-500">
                                Total
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-medium text-gray-900">
                                {{ number_format($total, 2) }} DT
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mt-8 flex justify-between">
                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                        Vider le panier
                    </button>
                </form>
                <a href="{{ route('checkout') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Passer la commande
                </a>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <p class="text-gray-600">Votre panier est vide</p>
                <a href="{{ route('index') }}" class="mt-4 inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Continuer vos achats
                </a>
            </div>
        @endif
    </main>

    @include('dashboard.components.site.footer')
</body>
</html> 