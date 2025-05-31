<!DOCTYPE html>
<html lang="fr">
<head>
<script async src="https://www.googletagmanager.com/gtag/js?id=G-4S6PCWSS1T"></script>
 <script>   window.dataLayer = window.dataLayer || [];   function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());   gtag('config', 'G-4S6PCWSS1T');
  </script>
  <script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '699127362510982');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=699127362510982&ev=PageView&noscript=1"
/></noscript>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>{{ $category->meta_title ?? $category->name }}</title>
    <meta name="description" content="{{ $category->meta_description ?? 'Découvrez tous nos produits ' . $category->name . ' en Tunisie. Produits Braun de qualité à prix compétitifs. Livraison disponible partout en Tunisie.' }}">
    <meta name="keywords" content="{{ $category->meta_keywords ?? $category->name . ', Braun, Tunisie, ' . implode(', ', $products->take(5)->pluck('name')->toArray()) }}">
    <meta name="author" content="Braun Tunisie">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url('/categorie/'.$category->id) }}">

    <!-- Open Graph / SEO -->
    <meta property="og:title" content="{{ $category->meta_title ?? $category->name . ' - Produits Braun en Tunisie' }}" />
    <meta property="og:description" content="{{ $category->meta_description ?? 'Découvrez tous nos produits ' . $category->name . ' en Tunisie. Produits Braun de qualité à prix compétitifs.' }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url('/categorie/'.$category->id) }}" />
    <meta property="og:site_name" content="Braun Tunisie" />
    
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $category->meta_title ?? $category->name . ' - Produits Braun en Tunisie' }}">
    <meta name="twitter:description" content="{{ $category->meta_description ?? 'Découvrez tous nos produits ' . $category->name . ' en Tunisie.' }}">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="https://res.cloudinary.com/dlhonl1wo/image/upload/v1747046500/favicon_tvqtpu.png" type="image/x-icon">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
    <!-- Structured Data / JSON-LD -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "CollectionPage",
        "name": "{{ $category->name }}",
        "description": "{{ $category->meta_description ?? 'Découvrez tous nos produits ' . $category->name . ' en Tunisie. Produits Braun de qualité à prix compétitifs.' }}",
        "url": "{{ url('/categorie/'.$category->id) }}",
        "mainEntity": {
            "@type": "ItemList",
            "itemListElement": [
                @foreach($products as $index => $product)
                    {
                        "@type": "ListItem",
                        "position": {{ $index + 1 }},
                        "url": "{{ url('/produit/'.($product->sku ?? $product->id)) }}",
                        "item": {
                            "@type": "Product",
                            "name": "{{ $product->name }}",
                            "description": "{{ Str::limit(strip_tags($product->description ?? ''), 100) }}",
                            "sku": "{{ $product->SKU }}",
                            "brand": {
                                "@type": "Brand",
                                "name": "Braun"
                            },
                            @php
                                $links = $product->additional_links ? json_decode($product->additional_links, true) : [];
                                $firstLink = count($links) > 0 ? $links[0]['url'] : '#';
                            @endphp
                            "image": "{{ $firstLink }}",
                            "offers": {
                                "@type": "Offer",
                                "price": "{{ $product->sale_price ?? $product->regular_price }}",
                                "priceCurrency": "{{ session('currency', 'DT') }}",
                                "availability": "{{ $product->quantity > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' }}"
                            }
                        }
                    }@if(!$loop->last),@endif
                @endforeach
            ]
        }
    }
    </script>
</head>

<body class="py-20 md:py-16 bg-black flex flex-col min-h-screen">

    @include('dashboard.components.site.nav')
    
    <div class="">
        @include('dashboard.components.site.counter')
    </div>

    <main class="container mx-auto px-2 max-w-4xl py-4">
       <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-2">
            @forelse($products as $product)
                @php
                    $links = $product->additional_links ? json_decode($product->additional_links, true) : [];
                    $firstLink = count($links) > 0 ? $links[0]['url'] : '#';
                    $secondLink = count($links) > 1 ? $links[1]['url'] : $firstLink;
                    $currency = session('currency', 'DT');
                @endphp

                <div class="bg-white border border-gray-200 rounded-lg shadow-sm flex flex-col relative overflow-hidden">
                    <a href="{{ url('/produit/'.($product->sku ?? $product->id)) }}" name="image">
                        <div class="relative w-full h-60 group overflow-hidden rounded-t-lg">
                            <img src="{{ $firstLink }}"
                                 alt="Image principale du produit {{ $product->name }}"
                                 class="w-full h-60 object-cover absolute inset-0 transition-opacity duration-500 opacity-100 group-hover:opacity-0">
                        
                            <img src="{{ $secondLink }}"
                                 alt="Deuxième image du produit {{ $product->name }}"
                                 class="w-full h-60 object-cover absolute inset-0 transition-opacity duration-500 opacity-0 group-hover:opacity-100">
                        </div>
                    </a>

                    <div class="p-4 flex flex-col flex-grow">
                        @if($product->sale_price && $product->regular_price)
                            @php
                                $discount = (($product->regular_price - $product->sale_price) / $product->regular_price) * 100;
                            @endphp
                            <span class="absolute top-2 right-2 text-white text-xs px-1 py-3 rounded-full z-10 h-[40px] w-[40px]" style="background: linear-gradient(50deg, #a28147, #c19b56);">
                                -{{ round($discount) }}%
                            </span>
                        @endif

                        <div class="text-center mb-4">
                            <a href="{{ route('category.show', ['categoryId' => $category->id]) }}">
                                <h6 class="text-lg font-semibold text-black">{{ $product->category->name ?? 'N/A' }}</h6>
                            </a>
                            <a href="{{ url('/produit/'.($product->sku ?? $product->id)) }}">
                                <h5 class="text-xl font-bold text-black">{{ $product->name }}</h5>
                            </a>
                        </div>

                        <div class="text-center mb-4">
                            <p class="text-lg text-gray-600">
                                @if($product->sale_price && $product->regular_price)
                                    <span class="line-through mr-2 text-gray-500">{{ number_format($product->regular_price) }} {{ $currency }}</span>
                                @endif
                                <span class="text-xl font-bold text-black">{{ number_format($product->sale_price ?? $product->regular_price) }} {{ $currency }}</span>
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
        </div></a>

        <!-- Pagination -->
        @if($products->hasPages())
            <div class="flex justify-center mt-8">
                <div class="bg-white p-4 rounded-lg">
                    {{ $products->links() }}
                </div>
            </div>
        @endif
    </main>
    @include('dashboard.components.site.footer')

</body>
</html>