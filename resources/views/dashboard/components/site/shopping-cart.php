 <!-- Shopping Cart Button -->
<li>
<button id="cartToggle" class="block py-2 px-3 text-black hover:bg-black hover:text-white rounded-full flex items-center relative">
  <i class="fas fa-shopping-cart mr-2 text-xl"></i> <!-- Icône du panier -->
  <span class="cart-count absolute top-3 right-3 translate-x-1/2 -translate-y-1/2 bg-red-600 text-white text-xs font-bold w-5 h-5 flex items-center justify-center rounded-full">0</span>
</button>


</li>

<!-- Shopping Cart Modal -->
<div id="cartModal" class="fixed inset-0 z-50 overflow-hidden hidden">
  <div class="absolute inset-0 overflow-hidden">
    <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
      <div class="w-screen max-w-md">
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
  PAYER - <span id="cart-checkout-price">0.00</span> DT
</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  const Cart = {
    getCart() {
      return JSON.parse(localStorage.getItem('cart')) || [];
    },

    saveCart(cart) {
      localStorage.setItem('cart', JSON.stringify(cart));
    },

    addItem(id, name, price, image = '/placeholder.jpg') {
      const cart = this.getCart();
      const existing = cart.find(p => p.id === id);
      if (existing) {
        existing.quantity += 1;
      } else {
        cart.push({ id, name, price, quantity: 1, image });
      }
      this.saveCart(cart);
      this.updateUI();
    },

    removeItem(id) {
      let cart = this.getCart().filter(p => p.id !== id);
      this.saveCart(cart);
      this.updateUI();
    },

    updateQuantity(id, qty) {
      const cart = this.getCart();
      const item = cart.find(p => p.id === id);
      if (item) {
        item.quantity = Math.max(1, qty);
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

    updateUI() {
      const cart = this.getCart();
      const $items = document.getElementById('cart-items');
      const $count = document.querySelector('.cart-count');
      const $totalItems = document.getElementById('cart-total-items');
      const $totalPrice = document.getElementById('cart-total-price');
      const $checkoutPrice = document.getElementById('cart-checkout-price');

      $count.textContent = $totalItems.textContent = this.getTotalItems();
      $totalPrice.textContent = this.getTotalPrice().toFixed(3) + ' DT';
      $checkoutPrice.textContent = this.getTotalPrice().toFixed(3);

      $items.innerHTML = '';

      if (cart.length === 0) {
        $items.innerHTML = '<p class="text-center text-gray-500 py-6">Votre panier est vide.</p>';
        return;
      }

      cart.forEach(item => {
        const li = document.createElement('li');
        li.className = 'py-6 flex relative';
        li.innerHTML = `
          <div class="w-24 h-24 flex-shrink-0 border rounded-md overflow-hidden">
            <img src="${item.image}" class="w-full h-full object-cover object-center" alt="${item.name}">
          </div>
          <div class="ml-4 flex-1 flex flex-col">
            <div class="flex justify-between text-base font-medium text-gray-900">
              <div>
                <h3>${item.name}</h3>
                <p>${item.price.toFixed(3)} DT</p>
              </div>
              <button class="remove-item text-red-500" data-id="${item.id}">


                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 7h12M9 7V4h6v3m2 0v12a2 2 0 01-2 2H8a2 2 0 01-2-2V7z"/>
                </svg>
              </button>
            </div>
            <div class="flex justify-between items-center mt-2 text-sm rounded-full">
              <div class="flex border border-gray-300">
                <button class="decrease-quantity px-2" data-id="${item.id}">-</button>
                <input type="text" class="w-10 text-center quantity-input border-x" value="${item.quantity}" data-id="${item.id}">
                <button class="increase-quantity px-2" data-id="${item.id}">+</button>
              </div>
              <span class="font-bold text-gray-900">${(item.price * item.quantity).toFixed(3)} DT</span>
            </div>
          </div>
        `;
        $items.appendChild(li);
      });
    }
  };

  function addToCart(id, name, price, image = '/placeholder.jpg') {
    Cart.addItem(id, name, price, image);
    toggleCart();
  }

  function toggleCart() {
    const modal = document.getElementById('cartModal');
    modal.classList.toggle('hidden');
    document.body.classList.toggle('overflow-hidden');
  }

  document.addEventListener('DOMContentLoaded', () => {
    Cart.updateUI();

    document.getElementById('cartToggle')?.addEventListener('click', toggleCart);
    document.getElementById('closeCart')?.addEventListener('click', toggleCart);

    document.addEventListener('click', e => {
      const id = e.target.dataset.id;
      if (e.target.classList.contains('remove-item')) {
  Cart.removeItem(parseInt(id));
}


      if (e.target.classList.contains('decrease-quantity')) {
        const item = Cart.getCart().find(p => p.id == id);
        if (item && item.quantity > 1) {
          Cart.updateQuantity(item.id, item.quantity - 1);
        }
      }

      if (e.target.classList.contains('increase-quantity')) {
        const item = Cart.getCart().find(p => p.id == id);
        if (item) {
          Cart.updateQuantity(item.id, item.quantity + 1);
        }
      }
    });

    document.addEventListener('change', e => {
      if (e.target.classList.contains('quantity-input')) {
        const id = e.target.dataset.id;
        const qty = parseInt(e.target.value) || 1;
        Cart.updateQuantity(parseInt(id), qty);
      }
    });
  });

  function removeProduct(button) {
    const productElement = button.closest('.product');
    productElement.remove();
  }
</script>
