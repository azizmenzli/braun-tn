<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Braun Tunisie - Login</title>
    <link rel="shortcut icon" href="assets/img/logo/favicon.png" type="image/x-icon">

    <!-- CSS links -->
    @include('dashboard.components.style')
</head>

<body class="bg-gray-100">

    <div class="h-screen flex items-center justify-center">
        <div class="bg-white shadow-lg rounded-md w-full sm:w-[500px] p-8">
            
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800">Se connecter</h2>
            </div>
            
            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded-md mb-5">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-3 rounded-md mb-5">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                
                <div class="mb-5">
                    <label for="email" class="text-sm font-medium text-gray-600">Email <span class="text-red-500">*</span></label>
                    <input class="w-full h-12 px-4 mt-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                           type="email" name="email" id="email" placeholder="Entrez votre email" required>
                </div>
                
                <div class="mb-5">
                    <label for="password" class="text-sm font-medium text-gray-600">Mot de passe <span class="text-red-500">*</span></label>
                    <input class="w-full h-12 px-4 mt-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                           type="password" name="password" id="password" placeholder="Entrez votre mot de passe" required>
                </div>

                <div class="flex items-center justify-between mb-5">
                    <a href="forgot" class="text-sm font-medium text-blue-600 hover:underline">Mot de passe oublié ?</a>
                </div>

                <button type="submit" class="w-full h-12 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Se connecter
                </button>
            </form>

        </div>
    </div>

    @include('dashboard.components.js')

</body>

</html>
