<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un produit</title>
    <link rel="shortcut icon" href="assets/img/logo/favicon.png" type="image/x-icon">

    <!-- css links -->
    <link rel="stylesheet" href="{{ asset('assets/css/perfect-scrollbar.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/choices.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/apexcharts.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/quill.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/rangeslider.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">

    @include('dashboard.components.js')
 
</head>

<body>

    <!-- Main Wrapper -->
    <div class="tp-main-wrapper bg-slate-100 h-screen" x-data="{ sideMenu: false }">
        @include('dashboard.components.sideleft')
<!--
        <div class="fixed top-0 left-0 w-full h-full z-40 bg-black/70 transition-all duration-300" 
             :class="sideMenu ? 'visible opacity-1' : 'invisible opacity-0'" 
             x-on:click="sideMenu = ! sideMenu">
        </div>
    -->
        <div class="tp-main-content lg:ml-[250px] xl:ml-[300px] w-[calc(100% - 300px)]" x-data="{ searchOverlay: false }">

            @include('dashboard.components.header')

            <div class="body-content px-8 py-8 bg-slate-100">
                <div class="grid grid-cols-12">
                    <div class="col-span-12 2xl:col-span-10">
                        <div class="flex justify-between mb-10 items-end flex-wrap">
                            <div class="page-title mb-6 sm:mb-0">
                                <h3 class="mb-0 text-[28px]">Ajouter un produit</h3>
                                <ul class="text-tiny font-medium flex items-center space-x-3 text-text3">
                                    <li class="breadcrumb-item text-muted">
                                        <a href="{{ route('dashboard.ajouter-produits') }}" class="text-hover-primary"> Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item flex items-center">
                                        <span class="inline-block bg-text3/60 w-[4px] h-[4px] rounded-full"></span>
                                    </li>
                                    <li class="breadcrumb-item text-muted">Ajouter un produit</li>          
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add Product Form -->
                <div class="grid grid-cols-12">
                    <div class="col-span-12 2xl:col-span-10">
                        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('dashboard.ajouter-produits') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="grid grid-cols-12 gap-6 mb-6">
        <div class="col-span-12 xl:col-span-8 2xl:col-span-9">
            <div class="mb-6 bg-white px-8 py-8 rounded-md">    
                <h4 class="text-[22px]">Informations générales</h4>
                

                   <!-- Product SKU -->
                   <div class="mb-5">
                    <p class="mb-0 text-base text-black">SKU <span class="text-red">*</span></p>
                    <input name="sku" class="input w-full h-[44px] rounded-md border border-gray6 px-6 text-base" 
                           type="text" placeholder="SKU" value="{{ old('sku') }}" required>
                    @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Product Name -->
                <div class="mb-5">
                    <p class="mb-0 text-base text-black">Nom du produit <span class="text-red">*</span></p>
                    <input name="name" class="input w-full h-[44px] rounded-md border border-gray6 px-6 text-base" 
                           type="text" placeholder="Nom du produit" value="{{ old('name') }}" required>
                    @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Product Description -->
                <div class="mb-5">
                    <p class="mb-0 text-base text-black">Description du produit <span class="text-red">*</span></p>
                    <textarea name="description" class="input w-full min-h-[200px] rounded-md border border-gray6 px-6 py-3 text-base" 
                              placeholder="Description complète" required>{{ old('description') }}</textarea>
                    @error('description')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                
                <!-- Icon -->
             <!-- Icon -->
<div id="specifications-list" class="space-y-4">
    <div class="specification-item flex items-center gap-4">
        <div class="flex items-center gap-2 w-1/4">
            <input type="file" name="specifications[0][icon]" accept="image/*" class="icon-input border border-gray-300 p-2 rounded-md" onchange="previewImage(this)" required />
            <img src="" alt="Aperçu" class="h-10 w-10 object-cover rounded hidden" />
        </div>
        <input type="text" name="specifications[0][name]" placeholder="Nom de la spécification *" class="name-input border border-gray-300 p-2 rounded-md w-2/4" required />
    </div>
</div>

<button
    type="button"
    onclick="addSpecification()"
    class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition"
>
    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
    </svg>
    Ajouter une spécification
</button>
                
<script>
function addSpecification() {
    const container = document.getElementById('specifications-list');
    const index = container.children.length;
    
    const div = document.createElement('div');
    div.className = 'specification-item flex items-center gap-4';
    div.innerHTML = `
        <div class="flex items-center gap-2 w-1/4">
            <input type="file" name="specifications[${index}][icon]" accept="image/*" class="icon-input border border-gray-300 p-2 rounded-md" onchange="previewImage(this)" />
            <img src="" alt="Aperçu" class="h-10 w-10 object-cover rounded hidden" />
        </div>
        <input type="text" name="specifications[${index}][name]" placeholder="Nom de la spécification" class="name-input border border-gray-300 p-2 rounded-md w-2/4" />
        <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
        </button>
    `;
    
    container.appendChild(div);
}

function previewImage(input) {
    const img = input.nextElementSibling;
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
            img.classList.remove('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>


            </div>

            <div class="bg-white px-8 py-8 rounded-md mb-6">
                <h4 class="text-[22px]">Détails du produit</h4> 
                <div class="mb-5">
                    <p class="mb-0 text-base text-black">Quantité
                        <span class="text-red">*</span></p>
                    <input name="quantity" class="input w-full h-[44px] rounded-md border border-gray6 px-6 text-base" 
                           type="number" step="0.01" placeholder="Quantité
" value="{{ old('quantity') }}" required>
                    @error('quantity')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Regular Price -->
                <!-- Prix régulier -->
<div class="mb-5">
    <p class="mb-0 text-base text-black">Prix régulier <span class="text-red">*</span></p>
    <input id="regular_price" name="regular_price"
           class="input w-full h-[44px] rounded-md border border-gray6 px-6 text-base" 
           type="number" step="0.01" placeholder="Prix régulier" 
           value="{{ old('regular_price') }}" required>
    @error('regular_price')
        <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror
</div>

<!-- Prix promo -->
<div class="mb-5">
    <p class="mb-0 text-base text-black">Prix promo</p>
    <input id="sale_price" name="sale_price"
           class="input w-full h-[44px] rounded-md border border-gray6 px-6 text-base" 
           type="number" step="0.01" placeholder="Prix promo" 
           value="{{ old('sale_price') }}">
    <span id="price-error" class="text-red-500 text-sm hidden">Le prix promo doit être inférieur au prix régulier.</span>
    @error('sale_price')
        <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror
</div>


                <!-- Additional Links -->
                <div class="mb-5">
                    <p class="mb-0 text-base text-black">Liens supplémentaires (séparés par des virgules)</p>
                    <input 
                      name="additional_links" 
                      class="input w-full h-[44px] rounded-md border border-gray6 px-6 text-base" 
                      type="text" 
                      placeholder="Ex: https://exemple.com, https://res.cloudinary.com/..."
                      value="{{ old('additional_links') }}"
                      oninput="displayLinks(this.value)"
                    >
                    @error('additional_links')
                      <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                    <div id="links-preview" class="mt-3 space-y-2"></div>
                </div>
                
                <!-- Product Status -->
                <div class="mb-5">
                    <p class="mb-0 text-base text-black">Statut du produit <span class="text-red">*</span></p>
                    <select name="status" class="input w-full h-[44px] rounded-md border border-gray6 px-6 text-base" required>
                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Publié</option>
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Brouillon</option>
                    </select>
                    @error('status')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Product Type -->
                <div class="mb-5">
                    <p class="mb-0 text-base text-black">Type du produit <span class="text-red">*</span></p>
                    <select name="type" class="input w-full h-[44px] rounded-md border border-gray6 px-6 text-base" required>
                        <option value="simple" {{ old('type') == 'simple' ? 'selected' : '' }}>Simple</option>
                        <option value="variable" {{ old('type') == 'variable' ? 'selected' : '' }}>Variable</option>
                    </select>
                    @error('type')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Sidebar with other fields like categories -->
        <div class="col-span-12 xl:col-span-4 2xl:col-span-3">
            <div class="bg-white px-8 py-8 rounded-md mb-6">
                <p class="mb-5 text-base text-black">Catégories</p>
                <div class="mb-5">
                    <p class="mb-0 text-base text-black">Catégorie principale <span class="text-red">*</span></p>
                    <select name="category_id" class="input w-full h-[44px] rounded-md border border-gray6 px-6 text-base" required>
                        <option value="">Sélectionnez une catégorie</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Subcategory -->
                <div class="mb-5">
                    <p class="mb-0 text-base text-black">Sous-catégorie</p>
                    <select name="sous_categorie_id" class="input w-full h-[44px] rounded-md border border-gray6 px-6 text-base">
                        <option value="11">-- Choisir une sous-catégorie --</option>
                        
                    </select>
                    @error('sous_categorie_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- Form Buttons -->
    <div class="flex justify-end space-x-4">
        <button type="submit" name="status" value="published" class="tp-btn px-10 py-2 bg-blue-600 text-white hover:bg-blue-700">
            Publier le produit
        </button>
        <button type="submit" name="status" value="draft" class="tp-btn px-10 py-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">
            Enregistrer comme brouillon
        </button>
    </div>
</form>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const regularInput = document.getElementById('regular_price');
        const saleInput = document.getElementById('sale_price');
        const errorText = document.getElementById('price-error');

        function validatePrices() {
            const regular = parseFloat(regularInput.value);
            const sale = parseFloat(saleInput.value);

            if (!isNaN(regular) && !isNaN(sale)) {
                if (sale >= regular) {
                    saleInput.classList.add('border-red-500');
                    errorText.classList.remove('hidden');
                } else {
                    saleInput.classList.remove('border-red-500');
                    errorText.classList.add('hidden');
                }
            } else {
                saleInput.classList.remove('border-red-500');
                errorText.classList.add('hidden');
            }
        }

        regularInput.addEventListener('input', validatePrices);
        saleInput.addEventListener('input', validatePrices);
    });
</script>

             
                    </div>
                </div>
            </div>
        </div>
    </div>

 
