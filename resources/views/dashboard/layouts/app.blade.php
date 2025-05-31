<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>
    <!-- Scripts -->
    <script>
        // Fonction pour rafraîchir le token CSRF
        function refreshCsrfToken() {
            fetch('/csrf-token')
                .then(response => response.json())
                .then(data => {
                    document.querySelector('meta[name="csrf-token"]').setAttribute('content', data.token);
                    // Mettre à jour tous les formulaires avec le nouveau token
                    document.querySelectorAll('form').forEach(form => {
                        const tokenInput = form.querySelector('input[name="_token"]');
                        if (tokenInput) {
                            tokenInput.value = data.token;
                        }
                    });
                });
        }

        // Rafraîchir le token toutes les 30 minutes
        setInterval(refreshCsrfToken, 30 * 60 * 1000);

        // Rafraîchir le token avant chaque soumission de formulaire
        document.addEventListener('submit', function(e) {
            if (e.target.tagName === 'FORM') {
                refreshCsrfToken();
            }
        });
    </script>
</body>
</html> 