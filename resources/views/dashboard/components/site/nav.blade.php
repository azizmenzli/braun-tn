<!-- Navbar Desktop -->
@include('dashboard.components.site.button-letral')
<nav class="bg-white fixed z-20 top-0 start-0 border-b border-gray-200 hidden w-full md:flex">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-center mx-auto p-4">
    <!-- Navbar links -->
    <div class="items-center justify-center hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
      <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-white md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white">
        <li>
          <a href="{{ route('index') }}" class="block py-2 px-3 text-white bg-black rounded-full">Accueil</a>
        </li>
        <li>
          <a href="{{ route('devenir-revendeur.store') }}" class="block py-2 px-3 text-black hover:bg-black hover:text-white rounded-full">Contact</a>
        </li>
        <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
          <img src="https://res.cloudinary.com/ddi29nbzl/image/upload/v1745420211/braun.tn/logo/vfqv40by0uco5dvofusj.png" class="h-8" alt="Logo">
        </a>
         
        <li>
          <a href="{{ route('politique-de-remboursement') }}" class="block py-2 px-3 text-black hover:bg-black hover:text-white rounded-full">Remboursement</a>
        </li>
        @include('dashboard.components.site.shopping-cart')


      </ul>
    </div>
  </div>
</nav>

<!-- Navbar Mobile -->
<nav class="bg-white fixed w-full z-20 top-0 start-0 border-b border-gray-200 md:hidden">
  <div class="max-w-screen-xl flex items-center justify-between mx-auto p-4">
    <!-- Logo à gauche -->
    <a href="{{ route('index') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
      <img src="https://res.cloudinary.com/ddi29nbzl/image/upload/v1745420211/braun.tn/logo/vfqv40by0uco5dvofusj.png" class="h-8" alt="Logo" />
    </a>

    <!-- Zone icônes (panier + menu) -->
    <div class="flex items-center space-x-4">
      <!-- Icône panier -->
      <button id="mobileCartToggle" class="text-gray-700 hover:text-black">
        <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-white md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white">
         
          @include('dashboard.components.site.shopping-cart')
  
  
        </ul>
      </button>

      <!-- Bouton menu -->
      <button id="mobile-menu-button" class="p-2 text-sm text-gray-500 rounded-lg hover:bg-gray-100">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
    </div>
  </div>

  <!-- Menu mobile caché par défaut -->
  <div id="mobile-menu" class="hidden px-4 pb-4">
    <ul class="flex flex-col space-y-2 font-medium">
      <li><a href="{{ route('index') }}" class="block py-2 px-3 rounded-full bg-black text-white">Accueil</a></li>
      <li><a href="{{ route('politique-de-remboursement') }}" class="block py-2 px-3 rounded-full hover:bg-black hover:text-white text-black">Remboursement</a></li>
      <li><a href="{{ route('devenir-revendeur.store') }}]" class="block py-2 px-3 rounded-full hover:bg-black hover:text-white text-black">Contact</a></li>
    </ul>
  </div>
</nav>
<script>
  const menuButton = document.getElementById('mobile-menu-button');
  const mobileMenu = document.getElementById('mobile-menu');

  menuButton.addEventListener('click', () => {
    mobileMenu.classList.toggle('hidden');
  });
</script>

<nav class="bg-white shadow-lg">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <div class="flex items-center">
                <a href="{{ route('index') }}" class="text-2xl font-bold text-gray-800">
                    Braun TN
                </a>
            </div>
            
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('index') }}" class="text-gray-600 hover:text-gray-800">Accueil</a>
                <a href="{{ route('categories') }}" class="text-gray-600 hover:text-gray-800">Catégories</a>
                <a href="{{ route('contact') }}" class="text-gray-600 hover:text-gray-800">Contact</a>
                
                @auth
                    <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-800">Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-gray-800">Déconnexion</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-800">Connexion</a>
                @endauth
                
                <a href="{{ route('cart.index') }}" class="relative">
                    <i class="fas fa-shopping-cart text-gray-600 hover:text-gray-800"></i>
                    @if(session('cart'))
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                            {{ count(session('cart')) }}
                        </span>
                    @endif
                </a>
            </div>
            
            <div class="md:hidden">
                <button class="text-gray-600 hover:text-gray-800 focus:outline-none">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </div>
</nav>
