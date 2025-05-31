 <!-- Navbar Desktop -->
 @include('dashboard.components.site.button-letral')
<nav class="bg-white fixed z-20 top-0 start-0 border-b border-gray-200 hidden w-full md:flex">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-center mx-auto p-4">
    <div class="items-center justify-center hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
      <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-white md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white">
        <!-- ... other nav items ... -->
        <li>
          <a href="{{ route('index') }}"
             class="block py-2 px-3 rounded-full transition
             {{ request()->routeIs('index') ? 'bg-black text-white' : 'text-black hover:bg-black hover:text-white' }}">
            Accueil
          </a>
        </li>
        <li>
          <a href="{{ route('devenir-revendeur.store') }}"
             class="block py-2 px-3 rounded-full transition
             {{ request()->routeIs('devenir-revendeur.store') ? 'bg-black text-white' : 'text-black hover:bg-black hover:text-white' }}">
            Contact
          </a>
        </li>
        <a href="{{ route('index') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
          <img src="https://res.cloudinary.com/ddi29nbzl/image/upload/v1745420211/braun.tn/logo/vfqv40by0uco5dvofusj.png" class="h-8" alt="Logo">
        </a>
        <li>
          <a href="{{ route('politique-de-remboursement') }}"
             class="block py-2 px-3 rounded-full transition
             {{ request()->routeIs('politique-de-remboursement') ? 'bg-black text-white' : 'text-black hover:bg-black hover:text-white' }}">
            Remboursement
          </a>
        </li>
        <li class="hidden sm:block">
          <!-- MODIFIED ID HERE -->
          <button id="desktopCartToggle" class="py-2 px-3 text-black hover:bg-black hover:text-white rounded-full flex items-center relative">
            <i class="fas fa-shopping-cart mr-2 text-xl"></i>
            <span class="cart-count-mobile absolute top-3 right-3 translate-x-1/2 -translate-y-1/2 bg-red-600 text-white text-xs font-bold w-5 h-5 flex items-center justify-center rounded-full">0</span>
          </button>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Navbar Mobile -->
<nav class="bg-white fixed w-full z-20 top-0 start-0 border-b border-gray-200 md:hidden">
  <div class="max-w-screen-xl flex items-center justify-between mx-auto p-4">
    <a href="{{ route('index') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
      <img src="https://res.cloudinary.com/ddi29nbzl/image/upload/v1745420211/braun.tn/logo/vfqv40by0uco5dvofusj.png" class="h-8" alt="Logo" />
    </a>
    <div class="flex items-center space-x-4">
      <!-- ID is correct here: mobileCartToggle -->
      <button id="mobileCartToggle" class="p-2 text-black hover:text-black relative md:hidden">
        <i class="fas fa-shopping-cart text-xl"></i>
        <span class="cart-count-mobile absolute -top-1 -right-1 bg-red-600 text-white text-xs font-bold w-5 h-5 flex items-center justify-center rounded-full">0</span>
      </button>
      <button id="mobile-menu-button" class="p-2 text-sm text-gray-500 rounded-lg hover:bg-gray-100">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
    </div>
  </div>
  <div id="mobile-menu" class="hidden px-4 pb-4">
    <!-- ... mobile menu items ... -->
    <ul class="flex flex-col space-y-2 font-medium">
      <li>
        <a href="{{ route('index') }}"
           class="block py-2 px-3 rounded-full transition
           {{ request()->routeIs('index') ? 'bg-black text-white' : 'text-black hover:bg-black hover:text-white' }}">
          Accueil
        </a>
      </li>
      <li>
        <a href="{{ route('politique-de-remboursement') }}"
           class="block py-2 px-3 rounded-full transition
           {{ request()->routeIs('politique-de-remboursement') ? 'bg-black text-white' : 'text-black hover:bg-black hover:text-white' }}">
          Remboursement
        </a>
      </li>
      <li>
        <a href="{{ route('devenir-revendeur.store') }}"
           class="block py-2 px-3 rounded-full transition
           {{ request()->routeIs('devenir-revendeur.store') ? 'bg-black text-white' : 'text-black hover:bg-black hover:text-white' }}">
          Contact
        </a>
      </li>
    </ul>
  </div>
</nav>

<!-- Script pour toggle menu mobile (Keep this as is) -->
<script>
  const menuButton = document.getElementById('mobile-menu-button');
  const mobileMenu = document.getElementById('mobile-menu');
  if (menuButton && mobileMenu) { // Check if elements exist
    menuButton.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });
  }
</script>

<!-- Shopping Cart Modal (Keep this HTML as is) -->
<div id="cartModal" class="fixed inset-0 z-50 overflow-hidden hidden">
  <!-- ... modal content ... -->
  <div class="absolute inset-0 bg-black bg-opacity-50 transition-opacity" id="cartBackdrop"></div>
  <div class="fixed inset-y-0 right-0 max-w-full flex">
    <div class="w-screen max-w-md transform transition-transform">
      <div class="h-full flex flex-col bg-white shadow-xl">
        <div class="flex-1 py-6 overflow-y-auto px-4 sm:px-6">
          <div class="flex items-start justify-between">
            <h2 class="text-lg font-medium text-gray-900">Panier (<span id="cart-total-items">0</span> produits)</h2>
            <button id="closeCart" type="button" class="-mr-2 p-2 text-gray-400 hover:text-gray-500">
              <span class="sr-only">Fermer</span>
              <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
          <div class="mt-8">
            <div class="flow-root">
              <ul id="cart-items" class="-my-6 divide-y divide-gray-200">
                <!-- Cart items will be dynamically added here -->
              </ul>
            </div>
          </div>
        </div>
        <div class="border-t border-gray-200 py-6 px-4 sm:px-6">
          <div class="flex justify-between text-base font-medium text-gray-900 mb-2">
            <p>Total</p>
            <p id="cart-total-price">0.00 DT</p>
          </div>
          <div class="text-center mb-4">
            <a href="#" class="text-sm text-gray-500 hover:text-gray-700">TVA incluse et frais de port à ajouter</a>
          </div>
          <div class="mt-6">
          <a href="/checkout" class="flex justify-center items-center px-6 py-3 border border-transparent rounded-full shadow-sm text-base font-semibold text-white bg-black hover:bg-black w-full">
            <span>PAYER</span>
            <span id="cart-checkout-price" class="ml-2">0.00 DT</span> DT
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Bouton flottant du panier -->
<!-- MODIFIED: Added 'hidden' class -->
<div id="floating-cart-button" class="fixed left-4 bottom-4 z-40 transition-all duration-300 hidden">
  <button id="floating-cart-button-btn" class="bg-white text-black px-6 py-3 rounded-full shadow-lg font-medium flex items-center relative hover:bg-white">
    <span id="floating-button-text">Payer la commande</span>
    <!-- Note: id="floating-button-count" is also class="cart-count-mobile", so its text gets updated by the main Cart.updateUI -->
    <span id="floating-button-count" class="cart-count-mobile absolute -top-1 -right-1 bg-red-600 text-white text-xs font-bold w-5 h-5 flex items-center justify-center rounded-full">0</span>
  </button>
</div>

<!-- Main Cart Script (Consolidated) -->
<script>
  // Global toggleCart function (defined once)
  function toggleCart() {
    const modal = document.getElementById('cartModal');
    const backdrop = document.getElementById('cartBackdrop');

    if (!modal || !backdrop) {
      console.error("Cart modal or backdrop element not found.");
      return;
    }

    if (modal.classList.contains('hidden')) {
      modal.classList.remove('hidden');
      document.body.style.overflow = 'hidden'; // Prevent background scroll
      setTimeout(() => { // Allow modal to be displayed before starting opacity transition
        backdrop.classList.remove('opacity-0'); // Should be initial state if hidden
        backdrop.classList.add('opacity-50');
        // For the panel itself, if you want a slide-in, you'd add classes here
        modal.querySelector('.transform')?.classList.remove('translate-x-full'); // Example for slide
      }, 10);
    } else {
      backdrop.classList.remove('opacity-50');
      backdrop.classList.add('opacity-0');
       modal.querySelector('.transform')?.classList.add('translate-x-full'); // Example for slide
      setTimeout(() => {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto'; // Restore scroll
      }, 300); // Match transition duration
    }
  }

  const Cart = {
    getCart() {
      return JSON.parse(localStorage.getItem('cart')) || [];
    },

    saveCart(cart) {
      localStorage.setItem('cart', JSON.stringify(cart));
    },

    addItem(id, name, price, image = '/placeholder.jpg') { // Ensure ID is a number if you compare with === later
      const cart = this.getCart();
      const existing = cart.find(p => p.id === id);
      if (existing) {
        existing.quantity += 1;
      } else {
        cart.push({ id, name, price, quantity: 1, image });
      }
      this.saveCart(cart);
      this.updateUI();
      if (typeof this.animateCartButton === 'function') {
        this.animateCartButton(); // Call animation
      }
    },

    removeItem(id) { // Ensure id is the correct type (number) for comparison
      let cart = this.getCart().filter(p => p.id !== id);
      this.saveCart(cart);
      this.updateUI();
    },

    updateQuantity(id, qty) { // Ensure id is the correct type
      const cart = this.getCart();
      const item = cart.find(p => p.id === id);
      if (item) {
        item.quantity = Math.max(1, qty); // Prevent quantity < 1
        this.saveCart(cart);
        this.updateUI();
      }
    },

    getTotalItems() {
      return this.getCart().reduce((sum, i) => sum + i.quantity, 0);
    },

    getTotalPrice() {
      return this.getCart().reduce((sum, i) => sum + i.price * i.quantity, 0);
    },

    animateCartButton() {
      const btn = document.getElementById('floating-cart-button-btn');
      if (btn) {
          btn.classList.add('pulse-animation');
          setTimeout(() => {
            btn.classList.remove('pulse-animation');
          }, 500); // Duration of pulse animation
      }
    },

    updateUI() {
      const cart = this.getCart();
      const totalItems = this.getTotalItems();
      const totalPrice = this.getTotalPrice();

      // Update all cart counters (including floating button badge and navbar badges)
      document.querySelectorAll('.cart-count, .cart-count-mobile').forEach(el => {
        el.textContent = totalItems;
      });

      // --- Floating Button Logic ---
      const floatingButtonContainer = document.getElementById('floating-cart-button');
      const floatingButtonText = document.getElementById('floating-button-text');
      // floating-button-count span's text is already updated by '.cart-count-mobile' selector

      if (floatingButtonContainer && floatingButtonText) {
        if (totalItems > 0) {
          floatingButtonContainer.classList.remove('hidden');
          floatingButtonText.textContent = 'Payer la commande'; // Or 'Voir le panier'
          // Attach click listener to the button itself or the container
          // The main toggleCart function is globally available
          floatingButtonContainer.onclick = toggleCart; // Use the global toggleCart
        } else {
          floatingButtonContainer.classList.add('hidden');
          floatingButtonText.textContent = 'Ajouter au panier'; // Reset text (optional)
          floatingButtonContainer.onclick = null; // Remove listener when hidden
        }
      }
      // --- End Floating Button Logic ---

      // Update modal information (if elements exist)
      const cartTotalItemsEl = document.getElementById('cart-total-items');
      const cartTotalPriceEl = document.getElementById('cart-total-price');
      const cartCheckoutPriceEl = document.getElementById('cart-checkout-price');

      if (cartTotalItemsEl) cartTotalItemsEl.textContent = totalItems;
      if (cartTotalPriceEl) cartTotalPriceEl.textContent = totalPrice.toFixed(3) + ' DT';
      if (cartCheckoutPriceEl) cartCheckoutPriceEl.textContent = totalPrice.toFixed(3);


      // Render cart items in the modal
      const cartItemsContainer = document.getElementById('cart-items');
      if (cartItemsContainer) {
        cartItemsContainer.innerHTML = ''; // Clear previous items

        if (cart.length === 0) {
          cartItemsContainer.innerHTML = `
            <div class="flex flex-col items-center justify-center py-10 text-gray-500">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9h14l-2-9M9 21a1 1 0 100-2 1 1 0 000 2zm6 0a1 1 0 100-2 1 1 0 000 2z" />
              </svg>
              <p class="text-lg font-medium">Votre panier est vide.</p>
            </div>
          `;
        } else {
          cart.forEach(item => {
            const li = document.createElement('li');
            li.className = 'py-6 flex relative';
            li.innerHTML = `
              <div class="w-24 h-24 flex-shrink-0 border border-gray-200 rounded-md overflow-hidden">
                <img src="${item.image}" class="w-full h-full object-cover object-center" alt="${item.name}">
              </div>
              <div class="ml-4 flex-1 flex flex-col">
                <div class="flex justify-between text-base font-medium text-gray-900">
                  <div>
                    <h3 class="text-sm sm:text-base">${item.name}</h3>
                    <p class="text-sm text-gray-700">${item.price.toFixed(3)} DT</p>
                  </div>
                  <button class="remove-item text-red-500 hover:text-red-700 p-1 -mr-1" data-id="${item.id}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                  </button>
                </div>
                <div class="flex justify-between items-center mt-2 text-sm">
                  <div class="flex border border-gray-300 rounded-md overflow-hidden items-center">
                    <button class="decrease-quantity px-2 py-1 text-gray-700 hover:bg-gray-100" data-id="${item.id}">-</button>
                    <input type="text" class="w-10 text-center quantity-input border-l border-r border-gray-300 py-1 text-sm" value="${item.quantity}" data-id="${item.id}" readonly>
                    <button class="increase-quantity px-2 py-1 text-gray-700 hover:bg-gray-100" data-id="${item.id}">+</button>
                  </div>
                  <span class="font-bold text-gray-900 text-sm sm:text-base">${(item.price * item.quantity).toFixed(3)} DT</span>
                </div>
              </div>
            `;
            cartItemsContainer.appendChild(li);
          });
        }
      }
    }
  };

  // Initialize cart functionality
  function initCart() {
    Cart.updateUI(); // Initial UI setup

    // Desktop cart toggle (ID corrected)
    document.getElementById('desktopCartToggle')?.addEventListener('click', function(e) {
      e.stopPropagation();
      toggleCart();
    });

    // Mobile cart toggle
    document.getElementById('mobileCartToggle')?.addEventListener('click', function(e) {
      e.stopPropagation();
      toggleCart();
    });

    // Close button for modal
    document.getElementById('closeCart')?.addEventListener('click', toggleCart);

    // Close when clicking on backdrop
    document.getElementById('cartBackdrop')?.addEventListener('click', toggleCart);

    // Handle cart item interactions (remove, increase/decrease quantity)
    document.addEventListener('click', function(e) {
      const target = e.target;
      const itemIdStr = target.dataset.id || target.closest('[data-id]')?.dataset.id;

      if (!itemIdStr) return; // No data-id found on target or its relevant parents

      const itemId = parseInt(itemIdStr); // Ensure it's a number for Cart methods

      if (isNaN(itemId)) return; // Not a valid number

      if (target.closest('.remove-item')) {
        Cart.removeItem(itemId);
      } else if (target.classList.contains('decrease-quantity')) {
        const item = Cart.getCart().find(p => p.id === itemId);
        if (item && item.quantity > 1) {
          Cart.updateQuantity(itemId, item.quantity - 1);
        }
      } else if (target.classList.contains('increase-quantity')) {
        const item = Cart.getCart().find(p => p.id === itemId);
        if (item) {
          Cart.updateQuantity(itemId, item.quantity + 1);
        }
      }
    });

    // Handle quantity input changes (though it's readonly, good to have if you remove readonly)
    // document.addEventListener('change', function(e) {
    //   if (e.target.classList.contains('quantity-input')) {
    //     const id = parseInt(e.target.dataset.id);
    //     const qty = parseInt(e.target.value) || 1;
    //     if (!isNaN(id)) Cart.updateQuantity(id, qty);
    //   }
    // });

    // Touch support for mobile cart toggle (optional, click usually works)
    // document.addEventListener('touchend', function(e) {
    //   if (e.target.id === 'mobileCartToggle' || e.target.closest('#mobileCartToggle')) {
    //     e.preventDefault(); // May not be necessary if click works
    //     toggleCart();
    //   }
    // }, { passive: false }); // passive:false if preventDefault is used
  }

  // Initialize when DOM is loaded
  if (document.readyState !== 'loading') {
    initCart();
  } else {
    document.addEventListener('DOMContentLoaded', initCart);
  }

  // Public function to add items to cart (callable from product pages, etc.)
  window.addToCart = function(id, name, price, image = '/placeholder.jpg') {
    Cart.addItem(id, name, parseFloat(price), image); // Ensure price is a number
    // Automatically open the cart modal if it's closed after adding an item
    if (document.getElementById('cartModal')?.classList.contains('hidden')) {
      toggleCart();
    }
  };

</script>

<!-- Styles for Floating Button and Pulse Animation (Keep this style block) --> 
<style>
  #floating-cart-button {
    transition: transform 0.3s ease, opacity 0.3s ease;
    animation: jump-shake 0.8s infinite;
  }

  /* Style quand le bouton est caché */
  #floating-cart-button.hidden {
    opacity: 0;
    transform: translateY(100%);
    pointer-events: none;
  }

  /* Effet hover quand visible */
  #floating-cart-button:not(.hidden):hover {
    transform: translateY(-3px);
  }

  /* Animation jump + shake */
  @keyframes jump-shake {
    0%   { transform: translateY(0) rotate(0deg); }
    20%  { transform: translateY(-8px) rotate(-4deg); }
    40%  { transform: translateY(0) rotate(4deg); }
    60%  { transform: translateY(-5px) rotate(-2deg); }
    80%  { transform: translateY(0) rotate(2deg); }
    100% { transform: translateY(0) rotate(0deg); }
  }

  @media (max-width: 768px) {
    #floating-cart-button {
      display: none;
    }
  }
</style>