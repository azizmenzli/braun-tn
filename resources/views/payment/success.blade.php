<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  
  <title> Votre paiement a été effectué avec succès</title>
  
  <!-- SEO meta tags -->
  <meta name="description" content="Découvrez la politique de remboursement de Braun Tunisie : 90 jours d'essai pour les épilateurs Silk-épil. Remboursement sous forme de bon d'achat." />
  <meta name="keywords" content="Braun, remboursement, épilateur, Silk-épil, Tunisie, essai, garantie, retour, politique de retour" />
  <meta name="author" content="Braun Tunisie" />
  <link rel="canonical" href="https://www.braun.tn/politique-de-remboursement" />
  <link rel="shortcut icon" href="https://res.cloudinary.com/dlhonl1wo/image/upload/v1747046500/favicon_tvqtpu.png" type="image/x-icon" />
  
  <!-- Open Graph -->
  <meta property="og:title" content="Politique de remboursement | Braun Tunisie" />
  <meta property="og:description" content="90 jours d'essai sur les épilateurs Silk-épil. Remboursement garanti en bon d'achat. Conditions simples et claires." />
  <meta property="og:type" content="website" />
  <meta property="og:url" content="https://www.braun.tn/politique-de-remboursement" />
  <meta property="og:image" content="https://www.braun.tn/images/seo/politique-remboursement.jpg" />
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #111111, #222222);
      min-height: 100vh;
    }
  </style>
</head>
<body class="flex flex-col min-h-screen">

  @include('dashboard.components.site.nav')

  <div class="flex-grow flex items-center justify-center px-4 py-20">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-10 text-center">
      <div class="mb-6">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-green-100 text-green-600 mx-auto text-5xl shadow-md">
          <i class="fas fa-check-circle"></i>
        </div>
      </div>
      <h2 class="text-3xl font-extrabold text-green-700 mb-4">Merci pour votre paiement !</h2>
      <p class="text-gray-700 mb-8 text-lg">
        Votre paiement a été effectué avec succès.
      </p>
      <a href="{{ route('index') }}" 
         class="inline-block bg-green-600 hover:bg-green-700 transition text-white font-semibold px-8 py-3 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
        Retour à l'accueil
      </a>
    </div>
  </div>

  @include('dashboard.components.site.footer')

</body>
</html>