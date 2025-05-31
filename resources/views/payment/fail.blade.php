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
    <div class="bg-white p-8 rounded shadow-md text-center max-w-md mx-auto text-black">
      <div class="text-red-500 text-6xl mb-4">❌</div>
      <h1 class="text-2xl font-bold text-red-600 mb-2">Échec du paiement</h1>
      <p class="text-gray-700 mb-6">
        Une erreur est survenue. Veuillez réessayer ou contacter le support.
      </p>
      <a href="{{ route('index') }}" 
         class="inline-block bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700 transition">
         Retour à l'accueil
      </a>
  </div>
  </div>

  @include('dashboard.components.site.footer')

</body>
</html>
