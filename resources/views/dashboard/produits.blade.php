<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des produits - Braun</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="../assets/img/logo/favicon.png" type="image/x-icon">
 
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-100 h-screen" x-data="{ sideMenu: false }">
   
            <!-- table -->
             
    <div class="tp-main-wrapper bg-slate-100 h-screen" x-data="{ sideMenu: false }">
        @include('dashboard.components.sideleft')
 
        <div class="fixed top-0 left-0 w-full h-full z-40 bg-black/70 transition-all duration-300" :class="sideMenu ? 'visible opacity-1' : '  invisible opacity-0 '" x-on:click="sideMenu = ! sideMenu"> </div>
 
        <div class="tp-main-content lg:ml-[250px] xl:ml-[300px] w-[calc(100% - 300px)]"  x-data="{ searchOverlay: false }">
 
            @include('dashboard.components.header')
 
            <div class="body-content px-8 py-8 bg-slate-100">
                <div class="flex justify-between mb-10">
                    <div class="page-title">
                        <h3 class="mb-0 text-[28px]">Commandes</h3>
                        <ul class="text-tiny font-medium flex items-center space-x-3 text-text3">
                            <li class="breadcrumb-item text-muted">
                                <a href="product-list.html" class="text-hover-primary"> Accueil</a>
                            </li>
                            <li class="breadcrumb-item flex items-center">
                                <span class="inline-block bg-text3/60 w-[4px] h-[4px] rounded-full"></span>
                            </li>
                            <li class="breadcrumb-item text-muted">Liste commandes</li>
                                           
                        </ul>
                    </div>
                </div>
 
                <!-- table -->
                <div class="bg-white rounded-t-md rounded-b-md shadow-xs py-4">
                    @if(session('success'))
                    <div class="flex items-center p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
                        <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <span class="sr-only">Succès</span>
                        <div>
                            <span class="font-medium">Succès!</span>   {{ session('success') }} .
                        </div>
                    </div>
                    @endif
                <form method="GET" action="{{ route('dashboard.produits.index') }}">
                    <div class="search-box flex items-center justify-between px-8 py-8">
                        <div class="relative w-full max-w-md">
                            <input name="search" class="w-full h-11 pl-12 pr-4 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" type="text" placeholder="Recherche un produit par nom" value="{{ request('search') }}">
                            <button type="submit" class="absolute top-1/2 left-4 transform -translate-y-1/2 text-gray-500 hover:text-blue-600">
                                <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 17C13.4183 17 17 13.4183 17 9C17 4.58172 13.4183 1 9 1C4.58172 1 1 4.58172 1 9C1 13.4183 4.58172 17 9 17Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M18.9999 19L14.6499 14.65" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="flex justify-end space-x-6">
                            <div class="mr-3 flex items-center space-x-3">
                                <span class="text-xs">Status : </span>
                                <select name="stock_filter" onchange="this.form.submit()" class="border rounded p-1 text-sm">
                                    <option value="">Tous les produits</option>
                                    <option value="low_stock" {{ request('stock_filter') == 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                                    <option value="out_of_stock" {{ request('stock_filter') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                                </select>
                            </div>
                            <div class="flex">
                                <a href="{{ route('dashboard.produits.add') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">Ajouter Produit</a>
                            </div>
                        </div>
                    </div>
                </form>
               
                <div class="relative overflow-x-auto mx-8">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="bg-white text-xs text-gray-700 uppercase">
                            <tr class="border-b border-gray-200">
                                <th class="py-3 w-8">
                                    <div class="flex items-center -translate-y-[3px]">
                                        <input id="selectAllProduct" type="checkbox" class="hidden">
                                        <label for="selectAllProduct" class="relative inline-block w-4 h-4 border border-gray-300 rounded-sm cursor-pointer after:content-[''] after:absolute after:top-[3px] after:left-[5px] after:w-[5px] after:h-[8px] after:border after:border-black after:border-t-0 after:border-l-0 after:rotate-45 after:opacity-0 checked:after:opacity-100"></label>
                                    </div>
                                </th>
                                <th class="pr-8 py-3">Produit</th>
                                <th class="px-3 py-3 text-right">Catégorie</th>
                                <th class="px-3 py-3 text-right">SKU</th>
                                <th class="px-3 py-3 text-right">Prix</th>
                                <th class="px-3 py-3 text-right">Stock</th>
 
                                <th class="px-3 py-3 text-right">Statut</th>
                                <th class="px-3 py-3 text-right"></th>
                                <th class="px-3 py-3 text-right"></th>
                                <th class="px-9 py-3 text-right"></th>
                                <th class="px-9 py-3 text-right">Date Ajouter</th>
 
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            @php
                                $links = $product->additional_links ? json_decode($product->additional_links, true) : [];
                                $firstLink = count($links) > 0 ? $links[0]['url'] : '#';
                            @endphp
                            <tr class="bg-white border-b border-gray-200 last:border-0 text-sm"
                                x-data="{
                                    showEditModal: false,
                                    showDeleteModal: false,
                                    productData: {
                                        id: {{ $product->id }},
                                        name: '{{ addslashes($product->name) }}',
                                        sku: '{{ addslashes($product->SKU) }}',
                                        regular_price: '{{ $product->regular_price }}',
                                        sale_price: '{{ $product->sale_price }}',
                                        quantity: '{{ $product->quantity }}',
                                        description: `{{ addslashes($product->description) }}`,
                                        specifications: @json($product->specifications ?? [])
                                    },
                                    addSpecification() {
                                        this.productData.specifications.push({name: '', icon: ''});
                                    },
                                    removeSpecification(index) {
                                        this.productData.specifications.splice(index, 1);
                                    }
                                }">
                           
                                <!-- Checkbox -->
                                <td class="pr-3 py-4">
                                    <div class="flex items-center">
                                        <input id="product-{{ $product->id }}" type="checkbox" class="hidden peer">
                                        <label for="product-{{ $product->id }}" class="w-4 h-4 border border-gray-300 rounded-sm cursor-pointer relative peer-checked:after:opacity-100 after:content-[''] after:absolute after:top-[3px] after:left-[5px] after:w-[5px] after:h-[8px] after:border-r-2 after:border-b-2 after:border-black after:rotate-45 after:opacity-0"></label>
                                    </div>
                                </td>
                           
                                <!-- Product name & image -->
                                <td class="pr-8 py-5">
                                    <div class="flex items-center gap-4">
                                        <img src="{{ $firstLink }}" class="w-14 h-14 object-cover rounded-md" alt="{{ $product->name }}">
                                        <a href="{{ url('/produit/'.$product->id) }}" target="_blank" class="hover:text-blue-600 font-medium">
                                            {{ $product->name }}
                                        </a>
                                    </div>
                                </td>
                           
                                <!-- Catégorie -->
                                <td class="px-3 py-3 text-right text-gray-700">
                                    {{ $product->category->name ?? 'N/A' }}
                                </td>
                               
                                <!-- SKU -->
                                <td class="px-3 py-3 text-right text-gray-700">
                                    {{ $product->SKU ?? 'N/A' }}
                                </td>
                               
                                <!-- Prix -->
                                <td class="px-3 py-3 text-right text-gray-700">
                                    {{ $product->regular_price }} DT
                                    @if($product->sale_price)
                                        <span class="ml-2 line-through text-red-500">{{ $product->sale_price }} DT</span>
                                    @endif
                                </td>
                                <td class="px-3 py-3 text-right text-gray-700">
                                    @php
                                        $quantity = $product->quantity ?? 0;
                                    @endphp
                               
                                    @if ($quantity > 10)
                                        <span class="inline-block px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">
                                            En stock ({{ $quantity }})
                                        </span>
                                    @elseif ($quantity > 0)
                                        <span class="inline-block px-2 py-1 text-xs font-semibold text-yellow-700 bg-yellow-100 rounded-full">
                                            Stock faible ({{ $quantity }})
                                        </span>
                                    @else
                                        <span class="inline-block px-2 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">
                                            Rupture
                                        </span>
                                    @endif
                                </td>
                               
                                <!-- Status -->
                                <td class="px-3 py-3 text-right">
                                    <span class="text-xs px-3 py-1 rounded-md bg-green-100 text-green-800 font-medium">
                                        {{ $product->status }}
                                    </span>
                                </td>
                           
                                <!-- Bouton Modifier -->
                                <td class="px-6 py-3 text-right">
                                    <button
                                    class="edit-btn w-10 h-10 bg-green-500 text-white rounded-md hover:bg-green-600 transition"
                                    data-target="edit-modal-{{ $product->id }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                </td>
                           
                                <!-- Bouton Supprimer -->
                                <td class="px-6 py-3 text-right">
                                    <button
                                    class="delete-btn w-10 h-10 bg-white border border-gray-300 text-gray-600 rounded-md hover:bg-red-500 hover:border-red-500 hover:text-white transition"
                                    data-target="delete-modal-{{ $product->id }}">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
</td>
                           
 
<td class="px-3 py-3 text-right">
<span class="text-xs px-3 py-1 rounded-md bg-blue-100 text-blue-800 font-medium">
    {{ \Carbon\Carbon::parse($product->created_at)->translatedFormat('d F Y à H:i') }}
 
</span>
</td>
 
 
                                <!-- Bouton Voir -->
                                <td class="px-6 py-3 text-right">
                                    <a href="{{ url('/produit/'.$product->id) }}" target="_blank">
                                        <button class="w-10 h-10 bg-white border border-gray-300 text-gray-600 rounded-md hover:bg-blue-500 hover:border-blue-500 hover:text-white transition">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </a>
                                </td>
                           
<!-- Modal Modifier -->
 
 
<!-- Modal Supprimer -->
<div id="delete-modal-{{ $product->id }}" class="modal hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md mx-4 relative">
          <!-- Bouton de fermeture -->
          <button onclick="document.getElementById('deleteModal').classList.add('hidden')" class="absolute top-2 right-2 text-gray-500 hover:text-red-600 text-xl">&times;</button>
 
          <!-- Contenu -->
          <h2 class="text-xl font-bold text-red-600 mb-4">Confirmer la suppression</h2>
          <p class="text-gray-700 mb-6">
              Êtes-vous sûr de vouloir supprimer le produit <strong>{{ $product->name }}</strong> (SKU : {{ $product->SKU }}) ?
              Cette action est irréversible.
          </p>
 
          <!-- Actions -->
          <div class="flex justify-end space-x-3">
              <button onclick="document.getElementById('deleteModal').classList.add('hidden')" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Annuler</button>
 
              <form action="{{ route('dashboard.produits.destroy', $product->id) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Supprimer</button>
              </form>
        <button class="close-modal absolute top-2 right-2 text-gray-500 hover:text-black" data-target="delete-modal-{{ $product->id }}">✕</button>
    </div>
</div>
<script>
    document.querySelectorAll('.edit-btn, .delete-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const modalId = this.getAttribute('data-target');
            document.getElementById(modalId).classList.remove('hidden');
        });
    });
 
    document.querySelectorAll('.close-modal').forEach(btn => {
        btn.addEventListener('click', function () {
            const modalId = this.getAttribute('data-target');
            document.getElementById(modalId).classList.add('hidden');
        });
    });
 
    // Fermer la modale en cliquant à l'extérieur
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                modal.classList.add('hidden');
            }
        });
    });
</script>
                               
                            </tr>
                            @endforeach
                            </tbody>
                           
                    </table>
                    <div class="px-8 py-4">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
 
 
</body>
</html>
<script>
    // Fonction pour ouvrir le modal d'édition
    function openEditModal(productId) {
        window.location.href = `/dashboard/produits/${productId}/edit`;
    }

    // Ajouter les écouteurs d'événements aux boutons d'édition
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-target').replace('edit-modal-', '');
            openEditModal(productId);
        });
    });
</script>