<footer class="bg-gray-800 text-white mt-12">
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-xl font-bold mb-4">Braun TN</h3>
                <p class="text-gray-400">Votre destination pour des produits de qualité.</p>
            </div>
            
            <div>
                <h3 class="text-xl font-bold mb-4">Liens Rapides</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('index') }}" class="text-gray-400 hover:text-white">Accueil</a></li>
                    <li><a href="{{ route('categories') }}" class="text-gray-400 hover:text-white">Catégories</a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-white">Contact</a></li>
                </ul>
            </div>
            
            <div>
                <h3 class="text-xl font-bold mb-4">Contact</h3>
                <ul class="space-y-2">
                    <li class="text-gray-400">Email: contact@braun.tn</li>
                    <li class="text-gray-400">Téléphone: +216 XX XXX XXX</li>
                </ul>
            </div>
        </div>
        
        <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
            <p>&copy; {{ date('Y') }} Braun TN. Tous droits réservés.</p>
        </div>
    </div>
</footer>