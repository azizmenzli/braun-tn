<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des produits - Braun</title>
    <link rel="stylesheet" href="{{ asset('assets/css/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/choices.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/apexcharts.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/quill.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/rangeslider.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
 </head>
<body class="bg-slate-100 h-screen" x-data="{ sideMenu: false, showEditModal: false, showDeleteModal: false, currentProductId: null }">

<!-- Sidebar -->
@include('dashboard.components.sideleft')

<!-- Overlay -->
<div class="fixed inset-0 bg-black/50 z-40 transition-opacity duration-300" 
     x-show="sideMenu" 
     x-transition.opacity 
     @click="sideMenu = false"></div>

<!-- Main Content -->
<div class="lg:ml-[250px] xl:ml-[300px] p-8">
    @include('dashboard.components.header')

    <div class="mb-6">
        <h1 class="text-2xl font-semibold mb-1">Liste des produits</h1>
        <nav class="text-sm text-gray-600 flex items-center gap-2">
            <a href="#" class="hover:text-blue-600">Home</a>
            <span class="w-1 h-1 bg-gray-400 rounded-full"></span>
            <span>Liste des produits</span>
        </nav>
    </div>

    @if(session('status'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('status') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div class="relative w-full sm:max-w-xs">
                <input type="text" placeholder="Rechercher un produit" class="w-full pl-10 pr-4 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
                <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <select class="border rounded px-3 py-1 text-sm">
                    <option>Active</option>
                    <option>Inactive</option>
                    <option>Scheduled</option>
                    <option>Low Stock</option>
                    <option>Out of Stock</option>
                </select>
                <a href="{{ route('dashboard.ajouter-produits') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">Ajouter produit</a>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase border-b bg-gray-50">
                    <tr>
                        <th class="px-4 py-3"><input type="checkbox"></th>
                        <th class="px-4 py-3">Produit</th>
                        <th class="px-4 py-3 text-right">SKU</th>
                        <th class="px-4 py-3 text-right">Catégorie</th>
                        <th class="px-4 py-3 text-right">Prix</th>
                        <th class="px-4 py-3 text-right">Statut</th>
                        <th class="px-4 py-3 text-right">Modifier</th>
                        <th class="px-4 py-3 text-right">Supprimer</th>
                        <th class="px-4 py-3 text-right">Détail</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-4 py-3"><input type="checkbox"></td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-4">
                                <img src="{{ $product->additional_links }}" class="w-14 h-14 object-cover rounded-md" alt="{{ $product->name }}">
                                <span>{{ $product->name }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-right">{{ $product->SKU ?? 'N/A' }}</td>
                        <td class="px-4 py-3 text-right">{{ $product->category->name ?? 'N/A' }}</td>
                        <td class="px-4 py-3 text-right">
                            {{ $product->regular_price }} DT
                            @if($product->sale_price)
                                <span class="ml-2 line-through text-red-500">{{ $product->sale_price }} DT</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">{{ $product->status }}</td>
                        <td class="px-4 py-3 text-right">
                            <button @click="showEditModal = true; currentProductId = {{ $product->id }}" class="text-blue-600 hover:text-blue-800"> </button>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <button @click="showDeleteModal = true; currentProductId = {{ $product->id }}" class="text-red-600 hover:text-red-800"> </button>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="#" class="text-gray-600 hover:text-black"> </a>
                        </td>
                    </tr>
                    <div x-show="showEditModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
                        <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6" @click.away="showEditModal = false">
                            <h2 class="text-xl font-semibold mb-4">Modifier Produit</h2>
                            <form :action="`/produits/${currentProductId}`" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="space-y-4">
                                    <input name="name" type="text" placeholder="Nom du produit" class="w-full border px-3 py-2 rounded">
                                    <input name="sku" type="text" placeholder="SKU" class="w-full border px-3 py-2 rounded">
                                    <input name="regular_price" type="number" placeholder="Prix" class="w-full border px-3 py-2 rounded">
                                    <input name="quantity" type="number" placeholder="Quantité" class="w-full border px-3 py-2 rounded">
                                </div>
                                <div class="mt-6 flex justify-end gap-2">
                                    <button type="button" @click="showEditModal = false" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Annuler</button>
                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Enregistrer</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- MODAL DELETE -->
                    <div x-show="showDeleteModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
                        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6" @click.away="showDeleteModal = false">
                            <h2 class="text-lg font-semibold mb-4">Supprimer ce produit ?</h2>
                            <p class="mb-6">Êtes-vous sûr de vouloir supprimer ce produit ? Cette action est irréversible.</p>
                            <form :action="`/produits/${currentProductId}`" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="flex justify-end gap-2">
                                    <button type="button" @click="showDeleteModal = false" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Annuler</button>
                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Supprimer</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL EDIT -->

@include('dashboard.components.js')

</body>
</html>
