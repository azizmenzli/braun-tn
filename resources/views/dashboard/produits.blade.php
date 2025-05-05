<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des produits - Braun</title>
    <link rel="stylesheet" href="{{ asset('assets/css/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/choices.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/apexcharts.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/quill.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/rangeslider.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body>

    <div class="tp-main-wrapper bg-slate-100 h-screen" x-data="{ sideMenu: false }">
        
        @include('dashboard.components.sideleft')

        <div class="tp-main-content lg:ml-[250px] xl:ml-[300px] w-[calc(100% - 300px)]" x-data="{ searchOverlay: false }">
            @include('dashboard.components.header')
            
            <div class="body-content px-8 py-8 bg-slate-100">
                <div class="flex justify-between mb-10">
                    <div class="page-title">
                        <h3 class="mb-0 text-[28px]">Products</h3>
                        <ul class="text-tiny font-medium flex items-center space-x-3 text-text3">
                            <li class="breadcrumb-item text-muted">
                                <a href="product-list.html" class="text-hover-primary"> Home</a>
                            </li>
                            <li class="breadcrumb-item flex items-center">
                                <span class="inline-block bg-text3/60 w-[4px] h-[4px] rounded-full"></span>
                            </li>
                            <li class="breadcrumb-item text-muted">Liste de produits</li>                       
                        </ul>
                    </div>
                </div>

                <!-- table -->
                <div class="bg-white rounded-t-md rounded-b-md shadow-xs py-4">
                    <div class="tp-search-box flex items-center justify-between px-8 py-8">
                        <div class="search-input relative">
                            <input class="input h-[44px] w-full pl-14" type="text" placeholder="Search by product name">
                            <button class="absolute top-1/2 left-5 translate-y-[-50%] hover:text-theme">
                                <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 17C13.4183 17 17 13.4183 17 9C17 4.58172 13.4183 1 9 1C4.58172 1 1 4.58172 1 9C1 13.4183 4.58172 17 9 17Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M18.9999 19L14.6499 14.65" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="flex justify-end space-x-6">
                            <div class="search-select mr-3 flex items-center space-x-3 ">
                                <span class="text-tiny inline-block leading-none -translate-y-[2px]">Status : </span>
                                <select>
                                    <option>Active</option>
                                    <option>In Active</option>
                                    <option>Scheduled</option>
                                    <option>Low Stock</option>
                                    <option>Out of Stock</option>
                                </select>
                            </div>
                            <div class="product-add-btn flex ">
                                <a href="add-product.html" class="tp-btn">Add Product</a>
                            </div>
                        </div>
                    </div>
                    <div class="relative overflow-x-auto mx-8">
                        <table class="w-full text-base text-left text-gray-500">
                            <thead class="bg-white">
                                <tr class="border-b border-gray6 text-tiny">
                                    <th class="py-3 w-[3%]">
                                        <div class="tp-checkbox -translate-y-[3px]">
                                            <input id="selectAllProduct" type="checkbox">
                                            <label for="selectAllProduct"></label>
                                        </div>
                                    </th>
                                    <th class="pr-8 py-3">Produit</th>
                                    <th class="px-3 py-3 w-[170px] text-end">Catégorie</th>
                                    <th class="px-3 py-3 w-[170px] text-end">SKU</th>
                                    <th class="px-3 py-3 w-[170px] text-end">Prix</th>
                                    <th class="px-3 py-3 w-[170px] text-end">Statut</th>
                                    <th class="px-3 py-3 w-[170px] text-end">Modifier</th>
                                    <th class="px-3 py-3 w-[170px] text-end">Supprimer</th>
                                    <th class="px-9 py-3 w-[12%] text-end">Détail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                @php
                                    $links = $product->additional_links ? json_decode($product->additional_links, true) : [];
                                    $firstLink = count($links) > 0 ? $links[0]['url'] : '#';
                                    $currency = session('currency', 'DT');
                                @endphp
                                <tr class="bg-white border-b border-gray6 last:border-0" 
                                    x-data="{ 
                                        showEditModal: false, 
                                        showDeleteModal: false,
                                        productData: {
                                            id: {{ $product->id }},
                                            name: '{{ $product->name }}',
                                            sku: '{{ $product->SKU }}',
                                            regular_price: '{{ $product->regular_price }}',
                                            quantity: '{{ $product->quantity }}'
                                        }
                                    }">
                                    <td class="pr-3">
                                        <div class="tp-checkbox">
                                            <input id="product-{{ $product->id }}" type="checkbox">
                                            <label for="product-{{ $product->id }}"></label>
                                        </div>
                                    </td>
                                    <td class="pr-8 py-5">
                                        <div class="flex items-center gap-4">
                                            <img src="{{ $firstLink }}" class="w-14 h-14 object-cover rounded-md" alt="{{ $product->name }}">
                                            <a href="{{ url('/produit/'.$product->id) }}" target="_blank"><span>{{ $product->name }}</span></a>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 text-end">{{ $product->category->name ?? 'N/A' }}</td>
                                    <td class="px-3 py-3 text-end">{{ $product->SKU ?? 'N/A' }}</td>
                                    <td class="px-3 py-3 text-end">
                                        {{ $product->regular_price }} DT
                                        @if($product->sale_price)
                                            <span class="ml-2 line-through text-red-500">{{ $product->sale_price }} DT</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-3 text-end">
                                        <span class="text-[11px] text-success px-3 py-1 rounded-md bg-success/10 font-medium">{{ $product->status }}</span>
                                    </td>
                                    <td class="px-9 py-3 text-end">
                                        <button @click="showEditModal = true"
                                                class="w-10 h-10 text-tiny bg-success text-white rounded-md hover:bg-green-600">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                    </td>
                                    <td class="px-9 py-3 text-end">
                                        <button @click="showDeleteModal = true"
                                                class="w-10 h-10 text-tiny bg-white border border-gray text-slate-600 rounded-md hover:bg-danger hover:border-danger hover:text-white">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                    <td class="px-9 py-3 text-end">
                                        <a href="{{ url('/produit/'.$product->id) }}" target="_blank">
                                            <button class="w-10 h-10 text-tiny bg-white border border-gray text-slate-600 rounded-md hover:bg-info hover:border-info hover:text-white">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                        </a>
                                    </td>

                                    <!-- Edit Modal for this product -->
                                    <div x-show="showEditModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
                                        <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6" @click.away="showEditModal = false">
                                            <h2 class="text-xl font-semibold mb-4">Modifier Produit</h2>
                                            <form :action="'/produits/' + productData.id" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="space-y-4">
                                                    <input x-model="productData.name" name="name" type="text" placeholder="Nom du produit" class="w-full border px-3 py-2 rounded">
                                                    <input x-model="productData.sku" name="sku" type="text" placeholder="SKU" class="w-full border px-3 py-2 rounded">
                                                    <input x-model="productData.regular_price" name="regular_price" type="number" placeholder="Prix" class="w-full border px-3 py-2 rounded">
                                                    <input x-model="productData.quantity" name="quantity" type="number" placeholder="Quantité" class="w-full border px-3 py-2 rounded">
                                                </div>
                                                <div class="mt-6 flex justify-end gap-2">
                                                    <button type="button" @click="showEditModal = false" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Annuler</button>
                                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Enregistrer</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Delete Modal for this product -->
                                    <div x-show="showDeleteModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
                                        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6" @click.away="showDeleteModal = false">
                                            <h2 class="text-lg font-semibold mb-4">Supprimer ce produit ?</h2>
                                            <p class="mb-6">Êtes-vous sûr de vouloir supprimer ce produit ? Cette action est irréversible.</p>
                                            <form :action="'/produits/' + productData.id" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="flex justify-end gap-2">
                                                    <button type="button" @click="showDeleteModal = false" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Annuler</button>
                                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Supprimer</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('dashboard.components.js')
 
</body>
</html>