<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Découvrez tous nos produits dans la catégorie {{ $category->name }}. Produits de qualité à prix compétitifs.">
    <meta name="keywords" content="Produits, {{ $category->name }}">
    <meta name="author" content="Ton Nom">
    <title>{{ $category->name }}</title>

    <!-- Open Graph / SEO -->
    <meta property="og:title" content="{{ $category->name }} | Produits" />
    <meta property="og:description" content="Découvrez tous nos produits dans la catégorie {{ $category->name }}." />
    <meta property="og:type" content="website" />
    <link rel="shortcut icon" href="assets/img/logo/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	 <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
     <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-black flex flex-col min-h-screen">

    @include('dashboard.components.site.nav')
    <div class="py-14">
    @include('dashboard.components.site.counter')
    </div>
    <main class="container mx-auto px-4 max-w-4xl">
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-2">
            
            @forelse($products as $product)
            @php
                $links = $product->additional_links ? json_decode($product->additional_links, true) : [];
                $firstLink = count($links) > 0 ? $links[0]['url'] : '#';
                $currency = session('currency', 'DT'); // ici tu peux changer dynamiquement avec la session
            @endphp

            <div class="bg-white border border-gray-200 rounded-lg shadow-sm flex flex-col relative overflow-hidden">
                <a href="{{ url('/produit/'.$product->id) }}" target="_blank" name="image">
                    <img class="rounded-t-lg w-full h-60 object-cover" src="{{ $firstLink }}" alt="Image du produit {{ $product->name }}" name="image">
                </a>

                <div class="p-4 flex flex-col flex-grow">
                   @if($product->sale_price && $product->regular_price)
    @php
        $discount = (($product->regular_price - $product->sale_price) / $product->regular_price) * 100;
    @endphp
    <span class="absolute top-2 right-2 bg-red-500 text-white text-[10px] sm:text-xs md:text-sm px-1 sm:px-2 py-0.5 sm:py-1 rounded-full">
        -{{ round($discount) }}%
    </span>
@endif

                    <div class="text-center mb-4">
                        <a href="{{ route('category.show', ['categoryId' => $category->id]) }}">
                            <h6 class="text-lg font-semibold text-black">{{ $product->category->name ?? 'N/A' }}</h6>
                        </a>
                        <a href="{{ url('/produit/'.$product->id) }}" target="_blank">
                            <h5 class="text-xl font-bold text-black">{{ $product->name }}</h5>
                        </a>
                    </div>

                    <div class="text-center mb-4">
                        <p class="text-lg text-gray-600">
                            @if($product->sale_price && $product->regular_price)
                                <span class="line-through mr-2 text-gray-500">{{ number_format($product->regular_price, 2) }} {{ $currency }}</span>
                            @endif
                            <span class="text-xl font-bold text-black">{{ number_format($product->sale_price ?? $product->regular_price, 2) }} {{ $currency }}</span>
                        </p>
                    </div>
                    

                    <div class="space-y-2 mb-10">
                        @if ($product->specifications)
                            @php
                                $specs = json_decode($product->specifications, true);
                            @endphp
                            <ul class="list-none space-y-2">
                                @foreach ($specs as $spec)
                                    <li class="flex items-center">
                                        <img 
                                            src="{{ asset('storage/' . ($spec['icon'] ?? 'default-icon.png')) }}" 
                                            alt="{{ $spec['name'] }}"
                                            class="w-4 h-4 mr-2 sm:w-5 sm:h-5 md:w-6 md:h-6"
                                        >
                                        <span class="text-xs sm:text-sm md:text-base text-black">
                                            {{ $spec['name'] }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-sm text-gray-500">Aucune spécification disponible.</div>
                        @endif
                    </div>
                  

                    <div class="flex justify-center mt-auto">
                        <a href="javascript:void(0);"
                        class="absolute bottom-0 right-0 hover:text-white text-white font-medium py-2 px-4 md:px-6 rounded-tl-lg transition duration-300 text-sm md:text-base"
                        style="background: linear-gradient(50deg, #a28147, #c19b56);"
                        onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->sale_price ?? $product->regular_price }},'{{ $firstLink }}')">
                        Ajouter au panier
                     </a>
                     
                    </div>
                </div>
            </div>

            @empty
            <div class="col-span-4 text-center text-white">
                <p class="text-lg">Aucun produit trouvé dans cette catégorie.</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
        <div class="flex justify-center mt-8">
            <div class="bg-white p-4 rounded-lg">
                {{ $products->links() }}
            </div>
        </div>
        @endif
    </main>

</body>
</html>
