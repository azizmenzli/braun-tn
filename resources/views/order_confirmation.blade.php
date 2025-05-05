<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de commande - Braun TN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    @include('dashboard.components.site.nav')

    <main class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-8 text-center">
            <div class="mb-6">
                <i class="fas fa-check-circle text-green-500 text-6xl"></i>
            </div>
            
            <h1 class="text-3xl font-bold mb-4">Commande confirmée !</h1>
            <p class="text-gray-600 mb-6">Merci pour votre commande. Nous avons bien reçu votre demande et nous la traiterons dans les plus brefs délais.</p>
            
            <div class="bg-gray-50 rounded-lg p-6 mb-8">
                <h2 class="text-xl font-bold mb-4">Détails de votre commande</h2>
                <div class="space-y-2 text-left">
                    <p><span class="font-medium">Numéro de commande:</span> #{{ $order->id }}</p>
                    <p><span class="font-medium">Date:</span> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                    <p><span class="font-medium">Total:</span> {{ number_format($order->total, 2) }} DT</p>
                </div>
            </div>
            
            <div class="space-y-4">
                <p class="text-gray-600">Un email de confirmation a été envoyé à <span class="font-medium">{{ $order->email }}</span></p>
                <p class="text-gray-600">Nous vous contacterons bientôt pour confirmer les détails de livraison.</p>
            </div>
            
            <div class="mt-8">
                <a href="{{ route('index') }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded">
                    Retour à l'accueil
                </a>
            </div>
        </div>
    </main>

    @include('dashboard.components.site.footer')
</body>
</html> 