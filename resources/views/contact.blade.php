<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contactez notre service après-vente | Braun Tunisie</title>

  <!-- Balises SEO -->
  <meta name="description" content="Contactez le service après-vente de Braun Tunisie. Réparations, assistance et support pour vos appareils partout en Tunisie.">
  <meta name="keywords" content="Braun Tunisie, service après-vente, support, contact, réparation, SAV Braun">
  <meta name="author" content="Braun Tunisie">
  <meta name="robots" content="index, follow">

  <!-- Open Graph -->
  <meta property="og:title" content="Service Après-Vente Braun Tunisie">
  <meta property="og:description" content="Obtenez une assistance rapide pour vos produits Braun. Contactez notre SAV où que vous soyez en Tunisie.">
  <meta property="og:image" content="https://braun.tn/assets/img/contact-thumbnail.jpg"> <!-- Remplace par une URL réelle -->
  <meta property="og:url" content="https://braun.tn/contact">
  <meta property="og:type" content="website">
  <meta property="og:locale" content="fr_FR">

  <!-- Favicon -->
  <link rel="icon" href="/favicon.ico" type="image/x-icon">

  <!-- Tailwind & FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
   <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>
<body class="bg-black text-white">
  @include('dashboard.components.site.nav')
<div class="py-16">
  @include('dashboard.components.site.counter')
</div>
  <section class="container mx-auto px-4 py-0">
    <h1 class="text-3xl md:text-4xl font-bold text-center mb-12">Notre Service Après-Vente</h1>

    <div class="flex flex-col lg:flex-row gap-8">
      <!-- Colonne Gauche -->
      <div class="w-full lg:w-1/2 bg-white p-8 rounded-lg shadow-md text-gray-800">
        <p class="mb-8">Nous réparons tous les appareils de la marque Braun où que vous soyez en Tunisie. Contactez par téléphone notre Service Après-Vente pour la démarche à suivre.</p>

        <div class="space-y-6 mb-8">
          <div class="flex items-start">
            <div class="p-3 mr-4"><i class="fas fa-phone-alt text-black text-xl"></i></div>
            <div>
              <h3 class="font-medium">Téléphone</h3>
              <p>+216 98 148 479</p>
            </div>
          </div>

          <div class="flex items-start">
            <div class="p-3 mr-4"><i class="fas fa-envelope text-black text-xl"></i></div>
            <div>
              <h3 class="font-medium">Email</h3>
              <p>contact@braun.tn</p>
            </div>
          </div>

          <div class="flex items-start">
            <div class="p-3 mr-4"><i class="fas fa-map-marker-alt text-black text-xl"></i></div>
            <div>
              <h3 class="font-medium">Adresse</h3>
              <p>54 rue de Mercure, Ben Arous ZI 2013</p>
            </div>
          </div>
        </div>
        @if(session('success'))
        <div class="bg-green-100 border-t-4 border-green-500 text-green-700 px-4 py-3 mb-4" role="alert">
            <p class="font-bold">Succès</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif
    
    
        <!-- Formulaire -->
        <form class="space-y-4" action="{{ route('devenir-revendeur.store') }}" method="post">
          @csrf
          <input type="text" placeholder="Nom complet" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="email" name="email" placeholder="Email" class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
            <input type="tel" name="phone" placeholder="Téléphone" class="w-full px-4 py-2 border border-gray-300 rounded-md">
          </div>
          <select class="w-full px-4 py-2 border border-gray-300 rounded-md" name="sujet" required>
            <option value="">Sélectionnez un sujet</option>
            <option value="question">Question générale</option>
            <option value="support">Support technique</option>
            <option value="partnership">Partenariat</option>
          </select>
          <textarea rows="4" placeholder="Message" name="message" class="w-full px-4 py-2 border border-gray-300 rounded-md" required></textarea>
          <button type="submit" class="w-full bg-black hover:bg-gray-900 text-white font-semibold py-3 rounded-md transition duration-300">Envoyer le message</button>
        </form>
        
      </div>

      <!-- Colonne Droite -->
      <div class="w-full lg:w-1/2">
        <div class="rounded-lg overflow-hidden shadow-md">
          <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3196.952014306546!2d10.229783575300493!3d36.74772287065682!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12fd3641f4084b61%3A0x8d4a619e582d706a!2sGEI%20G%C3%A9n%C3%A9rale%20d'Équipement%20Industriel!5e0!3m2!1sfr!2stn!4v1745404518687!5m2!1sfr!2stn"
            width="100%"
            height="500"
            style="border:0;"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
          </iframe>
        </div>
      </div>
    </div>
  </section>

  <footer class="text-center py-6 text-sm text-gray-400">
    &copy; 2025 Braun Tunisie. Tous droits réservés.
  </footer>
</body>
</html>
