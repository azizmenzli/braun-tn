<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Braun TN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    @include('dashboard.components.site.nav')

    <main class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">Finaliser votre commande</h1>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold mb-4">Détails de la commande</h2>
                <div class="space-y-4">
                    @foreach($products as $item)
                        <div class="flex justify-between items-center border-b pb-4">
                            <div>
                                <p class="font-medium">{{ $item['product']->name }}</p>
                                <p class="text-sm text-gray-500">Quantité: {{ $item['quantity'] }}</p>
                            </div>
                            <p class="font-medium">{{ number_format($item['product']->price * $item['quantity'], 2) }} DT</p>
                        </div>
                    @endforeach
                    <div class="flex justify-between items-center pt-4 border-t">
                        <p class="font-bold">Total</p>
                        <p class="font-bold">{{ number_format($total, 2) }} DT</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold mb-4">Informations de livraison</h2>
                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nom complet</label>
                            <input type="text" name="name" id="name" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                            <input type="tel" name="phone" id="phone" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">Adresse</label>
                            <textarea name="address" id="address" rows="3" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                        </div>
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700">Notes (optionnel)</label>
                            <textarea name="notes" id="notes" rows="2"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                        </div>
                        <div class="pt-4">
                            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                                Confirmer la commande
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>

    @include('dashboard.components.site.footer')
</body>
</html>