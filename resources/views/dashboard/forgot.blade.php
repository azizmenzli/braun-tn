<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réinitialiser le mot de passe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Réinitialisation du mot de passe</h1>
            <p class="text-gray-600 text-sm">Entrez votre adresse email pour recevoir un lien de réinitialisation.</p>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md mb-5">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                    <div>
                        <p class="font-medium">{{ session('success') }}</p>
                        <p class="text-sm mt-1">Si vous ne recevez pas l'email dans les prochaines minutes :</p>
                        <ul class="text-sm list-disc list-inside mt-1">
                            <li>Vérifiez votre dossier spam</li>
                            <li>Assurez-vous d'avoir saisi la bonne adresse email</li>
                            <li>Réessayez dans quelques minutes</li>
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md mb-5">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>
                                @if(str_contains($error, 'passwords.throttled'))
                                    Veuillez attendre 30 secondes avant de réessayer.
                                @else
                                    {{ $error }}
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Adresse email</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-gray-400"></i>
                    </div>
                    <input type="email" name="email" id="email" required
                           class="pl-10 w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="votre@email.com"
                           value="{{ old('email') }}">
                </div>
                @error('email')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between items-center">
                <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:text-blue-800">
                    <i class="fas fa-arrow-left mr-1"></i> Retour à la connexion
                </a>
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-150 flex items-center">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Envoyer le lien
                </button>
            </div>
        </form>
    </div>

</body>
</html>