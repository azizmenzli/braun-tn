<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Commander</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
     <link rel="shortcut icon" href="https://res.cloudinary.com/dlhonl1wo/image/upload/v1747046500/favicon_tvqtpu.png" type="image/x-icon">
 
 
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .payment-method {
            transition: all 0.3s ease;
        }
        .payment-method.active {
            border-color: #10B981;
            background-color: #F0FDF4;
        }
    </style>
</head>
<body class="py-20 md:py-16 bg-black py-20 md:py-14">
    <!-- Header -->
    @include('dashboard.components.site.nav')
   
    <div class="container mx-auto flex flex-col px-4 py-12 lg:flex-row gap-6">
        <!-- Left Form Section -->
        <div class="w-full lg:w-2/3 bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Informations personnelles</h2>
            @if(session('success'))
            <div class="bg-green-100 border-t-4 border-green-500 text-green-700 px-4 py-3 mb-4" role="alert">
                <p class="font-bold">Succès</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif
            <form class="space-y-4" action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
                @csrf
                <input type="hidden" name="products" id="productsData">
               
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">Nom*</label>
                        <input type="text" id="nom" name="nom" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                    </div>
                   
                    <div>
                        <label for="prenom" class="block text-sm font-medium text-gray-700 mb-1">Prénom*</label>
                        <input type="text" id="prenom" name="prenom" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                    </div>
                </div>
               
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email*</label>
                    <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                </div>
               
                <div>
                    <label for="telephone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone*</label>
                    <input type="tel"
                    id="telephone"
                    name="telephone"
                    pattern="[0-9]{8}"
                    title="Entrez exactement 8 chiffres (ex: 12345678)"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-transparent"
                    maxlength="8"
                    required>
             
                    <p class="text-xs text-gray-500 mt-1">Format: 12345678</p>
                </div>
               
                <div>
                    <label for="gouvernorat" class="block text-sm font-medium text-gray-700 mb-1">Gouvernorat*</label>
                    <select id="gouvernorat" name="gouvernorat" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                        <option value="">Sélectionnez un gouvernorat</option>
                        <option value="Ariana">Ariana</option>
                        <option value="Béja">Béja</option>
                        <option value="Ben Arous">Ben Arous</option>
                        <option value="Bizerte">Bizerte</option>
                        <option value="Gabès">Gabès</option>
                        <option value="Gafsa">Gafsa</option>
                        <option value="Jendouba">Jendouba</option>
                        <option value="Kairouan">Kairouan</option>
                        <option value="Kasserine">Kasserine</option>
                        <option value="Kébili">Kébili</option>
                        <option value="Le Kef">Le Kef</option>
                        <option value="Mahdia">Mahdia</option>
                        <option value="La Manouba">La Manouba</option>
                        <option value="Médenine">Médenine</option>
                        <option value="Monastir">Monastir</option>
                        <option value="Nabeul">Nabeul</option>
                        <option value="Sfax">Sfax</option>
                        <option value="Sidi Bouzid">Sidi Bouzid</option>
                        <option value="Siliana">Siliana</option>
                        <option value="Sousse">Sousse</option>
                        <option value="Tataouine">Tataouine</option>
                        <option value="Tozeur">Tozeur</option>
                        <option value="Tunis">Tunis</option>
                        <option value="Zaghouan">Zaghouan</option>
                    </select>
                </div>
               
                <div>
                    <label for="adress" class="block text-sm font-medium text-gray-700 mb-1">Adresse*</label>
                    <textarea id="adress" name="adress" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-transparent" required></textarea>
                </div>
               
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sexe *</label>
                    <div class="flex space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="sex" value="male" class="h-4 w-4 text-green-600 focus:ring-green-500">
                            <span class="ml-2 text-gray-700">Homme</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="sex" value="female" class="h-4 w-4 text-green-600 focus:ring-green-500">
                            <span class="ml-2 text-gray-700">Femme</span>
                        </label>
                         
                    </div>
                </div>
               
                <div>
                    <label for="date_naissance" class="block text-sm font-medium text-gray-700 mb-1">Date de naissance *</label>
                    <input type="date" id="date_naissance" name="date_naissance" max="{{ date('Y-m-d') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                </div>
               
                <div class="pt-4">
                    <h3 class="text-lg font-medium text-gray-800 mb-3">Méthode de paiement*</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                     
                       
                        <div class="payment-method border rounded-lg p-4 cursor-pointer" data-value="espece">
                            <div class="flex items-center space-x-3">
                                <input type="radio" name="mode_paiement" value="espece" class="h-4 w-4 text-green-600 focus:ring-green-500" checked>
                                <div>
                                    <span class="font-medium">Paiement à la livraison</span>
                                    <p class="text-sm text-gray-500">Espèce</p>
                                </div>
                            </div>
                        </div>
                        <div class="payment-method border rounded-lg p-4 cursor-pointer" data-value="carte">
                            <div class="flex items-center space-x-3">
                                <input type="radio" name="mode_paiement" value="carte" class="h-4 w-4 text-green-600 focus:ring-green-500">
                                <div>
                                    <span class="font-medium">Paiement par carte</span>
                                    <p class="text-sm text-gray-500">Carte</p>
                                </div>
                            </div>

    </div>


                        
                    </div>
                </div>
               
                <button style="background: linear-gradient(50deg, #a28147, #c19b56)" type="submit" class="w-full hover:bg-gray-800 text-white font-semibold py-3 px-4 rounded-full transition duration-200 mt-6 flex items-center justify-center">
                    <span id="submitText">Passer la commande</span>
                    <svg id="submitSpinner" class="animate-spin -mr-1 ml-2 h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </form>
        </div>
       
        <!-- Right Cart Section -->
        <div class="w-full lg:w-1/3 bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Votre commande</h2>
           
            <div id="checkout-items" class="space-y-4 max-h-96 overflow-y-auto">
                <!-- Items will be added dynamically -->
            </div>
           
            <div class="pt-4 space-y-3 border-t mt-4">
                <div class="flex justify-between">
                    <span class="text-gray-600">Sous-total:</span>
                    <span id="checkout-subtotal" class="font-medium">0.00 TND</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Livraison:</span>
                    <span id="checkout-shipping" class="font-medium">8.00 TND</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Timbre Fiscal:</span>
                    <span id="checkout-tax" class="font-medium">1.00 TND</span>
                </div>
                <div class="flex justify-between border-t pt-3 mt-2">
                    <span class="text-lg font-bold text-gray-800">Total:</span>
                    <span id="checkout-total" class="text-lg font-bold text-black">9.00 TND</span>
                </div>
            </div>
        </div>
    </div>
    @include('dashboard.components.site.footer')
 
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const checkoutItemsContainer = document.getElementById('checkout-items');
            const productsDataInput = document.getElementById('productsData');
       
            // Formatage des données
            const productsData = cart.map(item => ({
                product_id: parseInt(item.id),
                quantity: parseInt(item.quantity),
                price: parseFloat(item.price)
            }));
       
            // Validation des données
            const isValid = productsData.every(p =>
                !isNaN(p.product_id) &&
                !isNaN(p.quantity) && p.quantity > 0 &&
                !isNaN(p.price) && p.price > 0
            );
       
            if (!isValid) {
                console.error('Données de produit invalides:', productsData);
                alert('Certains produits ont des données invalides');
                return;
            }
       
            productsDataInput.value = JSON.stringify(productsData);
       
            const calculateTotals = () => {
                const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                const shipping = 8.00;
                const tax = 1.00;
                const total = subtotal + shipping + tax;
       
                document.getElementById('checkout-subtotal').textContent = subtotal.toFixed(2) + ' DT';
                document.getElementById('checkout-shipping').textContent = shipping.toFixed(2) + ' DT';
                document.getElementById('checkout-tax').textContent = tax.toFixed(2) + ' DT';
                document.getElementById('checkout-total').textContent = total.toFixed(2) + ' DT';
            };
       
            // Affichage des produits
            if (cart.length === 0) {
                checkoutItemsContainer.innerHTML = `
                    <div class="text-center py-8">
                        <p class="text-gray-500">Votre panier est vide</p>
                    </div>
                `;
                return;
            }
       
            checkoutItemsContainer.innerHTML = cart.map(item => `
                <div class="flex border-b pb-4">
                    <img src="${item.image || '/images/placeholder-product.png'}"
                         alt="${item.name}"
                         class="w-16 h-16 object-cover rounded-md">
                    <div class="ml-4 flex-1">
                        <h4 class="font-medium">${item.name}</h4>
                        <p class="text-bold font-bold mt-1">${parseFloat(item.price).toFixed(2)} DT</p>
                        <div class="flex justify-between mt-2">
                            <div class="flex items-center text-sm rounded-full">
                                <div class="flex border border-gray-300">
                                    <button class="decrease-quantity px-2" data-id="${item.id}">-</button>
                                    <input type="text" class="w-10 text-center quantity-input border-x" value="${item.quantity}" data-id="${item.id}">
                                    <button class="increase-quantity px-2" data-id="${item.id}">+</button>
                                </div>
                            </div>
                            <span class="font-bold">
                                ${(item.price * item.quantity).toFixed(2)} DT
                            </span>
                        </div>
                    </div>
                </div>
            `).join('');
       
            calculateTotals();
       
            // Gestion des boutons + -
            const attachQuantityListeners = () => {
                document.querySelectorAll('.increase-quantity').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const id = btn.dataset.id;
                        const item = cart.find(p => p.id === id);
                        if (item) {
                            item.quantity++;
                            localStorage.setItem('cart', JSON.stringify(cart));
                            location.reload();
                        }
                    });
                });
       
                document.querySelectorAll('.decrease-quantity').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const id = btn.dataset.id;
                        const item = cart.find(p => p.id === id);
                        if (item && item.quantity > 1) {
                            item.quantity--;
                            localStorage.setItem('cart', JSON.stringify(cart));
                            location.reload();
                        }
                    });
                });
       
                document.querySelectorAll('.quantity-input').forEach(input => {
                    input.addEventListener('change', () => {
                        const id = input.dataset.id;
                        const value = parseInt(input.value);
                        if (!isNaN(value) && value > 0) {
                            const item = cart.find(p => p.id === id);
                            if (item) {
                                item.quantity = value;
                                localStorage.setItem('cart', JSON.stringify(cart));
                                location.reload();
                            }
                        } else {
                            alert('Quantité invalide');
                            input.value = cart.find(p => p.id === id)?.quantity || 1;
                        }
                    });
                });
            };
       
            attachQuantityListeners();
       
            // Gestion de la soumission du formulaire
            const form = document.getElementById('checkoutForm');
            form.addEventListener('submit', function(e) {
                if (cart.length === 0) {
                    e.preventDefault();
                    alert('Votre panier est vide');
                    return;
                }
       
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <span>Traitement en cours...</span>
                    <svg class="animate-spin ml-2 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                `;
            });
        });
        </script>
       
</body>
</html>