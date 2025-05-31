<!DOCTYPE html>
<html lang="fr">

<!-- Mirrored from html.hixstudio.net/ebazer/edit-product.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 19 Apr 2025 11:45:34 GMT -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Modifier le produit</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <!-- css links -->
    @include('dashboard.components.style')

</head>
<body class="bg-slate-100">

    <!--  -->
    <div class="tp-main-wrapper bg-slate-100 h-screen" x-data="{ sideMenu: false }">
        @include('dashboard.components.sideleft')
 

        <div class="fixed top-0 left-0 w-full h-full z-40 bg-black/70 transition-all duration-300" :class="sideMenu ? 'visible opacity-1' : '  invisible opacity-0 '" x-on:click="sideMenu = ! sideMenu"> </div>

        <div class="tp-main-content lg:ml-[250px] xl:ml-[300px] w-[calc(100% - 300px)]"  x-data="{ searchOverlay: false }">

            @include('dashboard.components.header')


            <div class="body-content px-8 py-8 bg-slate-100">
                <div class="bg-white rounded-md shadow-sm p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-semibold text-gray-800">Modifier le produit</h1>
                        <a href="{{ route('dashboard.produits.index') }}" class="text-blue-600 hover:text-blue-800">
                            <i class="fas fa-arrow-left mr-2"></i>Retour à la liste
                        </a>
                    </div>

                    <form id="editProductForm" class="space-y-6">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nom du produit -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nom du produit <span class="text-red-500">*</span></label>
                                <input type="text" name="name" value="{{ $product->name }}" required
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- SKU -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">SKU <span class="text-red-500">*</span></label>
                                <input type="text" name="SKU" value="{{ $product->SKU }}" required
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Prix régulier -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Prix régulier (DT) <span class="text-red-500">*</span></label>
                                <input type="number" step="0.01" name="regular_price" value="{{ $product->regular_price }}" required
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                            <!-- Prix promotionnel -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Prix promotionnel (DT)</label>
                                <input type="number" step="0.01" name="sale_price" value="{{ $product->sale_price }}"
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Catégorie -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Catégorie <span class="text-red-500">*</span></label>
                                <select name="category_id" required
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                            </div>
        
                            <!-- Quantité -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Quantité <span class="text-red-500">*</span></label>
                                <input type="number" name="quantity" value="{{ $product->quantity }}" required min="0"
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                                </div>
    
                            <!-- Statut -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Statut <span class="text-red-500">*</span></label>
                                <select name="status" required
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="published" {{ $product->status == 'published' ? 'selected' : '' }}>Publié</option>
                                    <option value="draft" {{ $product->status == 'draft' ? 'selected' : '' }}>Brouillon</option>
                                </select>
                                                </div>
                                                
                            <!-- Type -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Type <span class="text-red-500">*</span></label>
                                <select name="type" required
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="simple" {{ $product->type == 'simple' ? 'selected' : '' }}>Simple</option>
                                    <option value="variable" {{ $product->type == 'variable' ? 'selected' : '' }}>Variable</option>
                                </select>
                                                        </div>
                                                </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description <span class="text-red-500">*</span></label>
                            <textarea name="description" rows="4" required
                                      class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $product->description }}</textarea>
                                            </div>
                                            
                        <!-- Images -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Images du produit</label>
                            <div class="mt-2">
                                <textarea name="image_links" rows="3" 
                                          placeholder="Entrez les liens des images séparés par des virgules"
                                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $product->additional_links ? collect(json_decode($product->additional_links, true))->pluck('url')->implode(', ') : '' }}</textarea>
                                <p class="mt-1 text-sm text-gray-500">Entrez les URLs des images séparées par des virgules</p>
                                        </div>

                            <!-- Aperçu des images -->
                            <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4" id="imagePreview">
                                @php
                                    $links = $product->additional_links ? json_decode($product->additional_links, true) : [];
                                @endphp
                                @foreach($links as $link)
                                    <div class="relative group">
                                        <img src="{{ $link['url'] }}" alt="Image produit" class="w-full h-32 object-cover rounded-lg">
                                    </div>
                                @endforeach
                                            </div>
                                        </div>

                        <!-- Spécifications -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Spécifications</label>
                            <div id="specifications-container" class="space-y-4">
                                @php
                                    $specifications = $product->specifications ? json_decode($product->specifications, true) : [];
                                @endphp
                                @foreach($specifications as $index => $spec)
                                    <div class="specification-item border rounded-lg p-4 bg-gray-50">
                                        <div class="flex justify-between items-start mb-2">
                                            <div class="flex-1 mr-4">
                                                <input type="text" name="specifications[{{ $index }}][name]" 
                                                       value="{{ $spec['name'] }}" required
                                                       placeholder="Nom de la spécification"
                                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            </div>
                                            <button type="button" onclick="removeSpecification(this)" 
                                                    class="text-red-500 hover:text-red-700">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        <div class="flex items-center">
                                            @if(isset($spec['icon']))
                                                <img src="{{ asset('storage/' . $spec['icon']) }}" 
                                                     alt="Icon" class="w-8 h-8 object-contain mr-2">
                                            @endif
                                            <input type="file" name="specifications[{{ $index }}][icon]" 
                                                   accept="image/*"
                                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" onclick="addSpecification()" 
                                    class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                <i class="fas fa-plus mr-2"></i>Ajouter une spécification
                            </button>
                        </div>

                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('dashboard.produits.index') }}"
                               class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                                Annuler
                            </a>
                            <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Enregistrer les modifications
                            </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('dashboard.components.js')

    <script>
        document.getElementById('editProductForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch('{{ route("dashboard.produits.update", $product->id) }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur réseau');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    window.location.href = '{{ route("dashboard.produits.index") }}';
                } else {
                    alert(data.message || 'Une erreur est survenue lors de la modification du produit');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Une erreur est survenue lors de la modification du produit');
            });
        });

        // Fonction pour ajouter une nouvelle spécification
        function addSpecification() {
            const container = document.getElementById('specifications-container');
            const index = container.children.length;
            
            const div = document.createElement('div');
            div.className = 'specification-item border rounded-lg p-4 bg-gray-50';
            div.innerHTML = `
                <div class="flex justify-between items-start mb-2">
                    <div class="flex-1 mr-4">
                        <input type="text" name="specifications[${index}][name]" required
                               placeholder="Nom de la spécification"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <button type="button" onclick="removeSpecification(this)" 
                            class="text-red-500 hover:text-red-700">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <div class="flex items-center">
                    <input type="file" name="specifications[${index}][icon]" 
                           accept="image/*"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
            `;
            
            container.appendChild(div);
        }

        // Fonction pour supprimer une spécification
        function removeSpecification(button) {
            button.closest('.specification-item').remove();
        }

        // Ajouter cette fonction pour la prévisualisation des images
        document.querySelector('textarea[name="image_links"]').addEventListener('input', function(e) {
            const links = e.target.value.split(',').map(link => link.trim()).filter(link => link);
            const previewContainer = document.getElementById('imagePreview');
            previewContainer.innerHTML = '';
            
            links.forEach(link => {
                const div = document.createElement('div');
                div.className = 'relative group';
                div.innerHTML = `
                    <img src="${link}" alt="Image produit" class="w-full h-32 object-cover rounded-lg"
                         onerror="this.src='https://via.placeholder.com/150?text=Image+non+disponible'">
                `;
                previewContainer.appendChild(div);
            });
        });
    </script>

    
</body>

<!-- Mirrored from html.hixstudio.net/ebazer/edit-product.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 19 Apr 2025 11:45:34 GMT -->
</html>