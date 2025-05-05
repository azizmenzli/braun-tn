<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	 <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>


 
<body class="bg-black">

  @include('dashboard.components.site.nav')
  <div class="py-16">
  @include('dashboard.components.site.counter')
  </div>
  
    <div class="container mx-auto px-4 py-2 max-w-6xl bg-white rounded-lg">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Colonne gauche - Images -->
 
           <!-- Swiper container -->
<div class="w-full md:w-1/2 bg-white rounded-lg relative">
  @php
  $links = $product->additional_links ? json_decode($product->additional_links, true) : [];
  $firstLink = count($links) > 0 ? $links[0]['url'] : '#';
  $currency = session('currency', 'DT'); // ici tu peux changer dynamiquement avec la session
@endphp

    <!-- Badge promo -->
    @if ($product->sale_price > 0 && $product->regular_price > 0)
    @php
        $discount = round(100 - ($product->sale_price / $product->regular_price * 100));
    @endphp
    <span class="absolute top-2 right-2 bg-red-500 text-white text-xs px-3 py-1 rounded-full z-10">
        -{{ $discount }}%
    </span>
@endif  
    @if ($product->additional_links)
    @php
        $images = json_decode($product->additional_links, true);
    @endphp

    <div class="swiper mySwiper rounded-lg overflow-hidden">
        <div class="swiper-wrapper">
            @foreach ($images as $img)
                <div class="swiper-slide">
                    <img src="{{ $img['url'] }}" alt="Vue Produit" class="w-full h-auto rounded-lg">
                </div>
            @endforeach
        </div>
        <div class="swiper-pagination mt-4 text-black"></div>
    </div>
@endif

  </div>
  
            
            <!-- Colonne droite - Détails produit -->
            <div class="w-full md:w-1/2">
                <div class="bg-white p-0">
                    <!-- Titre et promo -->
                    <h1 class="text-3xl font-bold text-black mb-2"> {{ $product->category->name ?? 'N/A' }}</h1>
					<h2 class="text-3xl font-bold text-black mb-2">{{ $product->name }}</h2>
                    
                    
                    <!-- Prix -->
                    <div class="flex items-center mb-4">
                        <span class="text-2xl font-bold text-black"> {{ number_format($product->sale_price > 0 ? $product->sale_price : $product->regular_price, 2) }} DT</span>
                        @if($product->sale_price > 0)
                        <span class="text-lg text-gray-500 line-through ml-2"> {{ number_format($product->regular_price, 2) }} DT</span>
                        @endif

                      </div>
                    
                    <!-- Description -->
                    <p class="text-black mb-6">
                      {{ $product->desciption
                      }} 
                    </p>
                    
                    <!-- Catégories -->
                    <div class="space-y-2 mb-6"> 
                      @if ($product->specifications)
                          @php
                              $specs = json_decode($product->specifications, true);
                          @endphp
                  
                          @foreach ($specs as $spec)
                              <div class="flex items-center">
                                  <img src="{{ asset('storage/' . ($spec['icon'] ?? 'default-icon.png')) }}" alt="{{ $spec['name'] }}" class="w-5 h-5 mr-2">
                                  <span class="text-sm text-black">{{ $spec['name'] }}</span>
                              </div>
                          @endforeach
                      @else
                          <div class="text-sm text-gray-500">Aucune spécification disponible.</div>
                      @endif
                  </div>
                  
                    
                    <!-- Sélecteur de quantité -->
                    <div class="flex items-center gap-4 mb-6">
  
                        <!-- Sélecteur de quantité -->
                        <div class="flex border border-gray-300 rounded-full bg-white">
                          <button class="px-3 py-1 bg-white hover:bg-gray-200 text-gray-600 rounded-full" id="decrement">
                            <i class="fas fa-minus"></i>
                          </button>
                          <input type="text" value="1" class="w-12 text-center border-x border-gray-300" id="quantity">
                          <button class="px-3 py-1 bg-white hover:bg-gray-200 text-gray-600 rounded-full" id="increment">
                            <i class="fas fa-plus"></i>
                          </button>
                        </div>
                      
                        <!-- Bouton d'action -->
                        <button 
  class="bg-black text-white py-2 px-5 rounded-full font-medium transition duration-200 flex items-center justify-center" 
   onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->sale_price ?? $product->regular_price }},'{{ $firstLink }}')"
>
  <i class="fas fa-shopping-cart mr-2"></i>
  Ajouter au panier
</button>

                        
                      </div>
                      
                </div>
            </div>


        </div>
    </div>
<!--
<div class="container mx-auto p-8 max-w-6xl bg-white rounded-lg">
  <div class="relative w-full h-0" style="padding-bottom: 56.25%;">
    <iframe
      class="absolute top-0 left-0 w-full h-full rounded-lg"
      src="https://www.youtube.com/embed/WW5-e5BRA30?autoplay=1&mute=1"
      title="YouTube video player"
      frameborder="0"
      allow="autoplay; encrypted-media"
      allowfullscreen
    ></iframe>
  </div>
</div>
-->
<br><br>
    <script>
        // Gestion de la quantité
        document.getElementById('increment').addEventListener('click', () => {
            const el = document.getElementById('quantity');
            el.value = parseInt(el.value) + 1;
        });
        
        document.getElementById('decrement').addEventListener('click', () => {
            const el = document.getElementById('quantity');
            if (parseInt(el.value) > 1) {
                el.value = parseInt(el.value) - 1;
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
      const swiper = new Swiper(".mySwiper", {
        loop: true,
        pagination: {
          el: ".swiper-pagination",
          clickable: true,
        },
        effect: "slide", 
      });
    </script>
    
</body>
</html>