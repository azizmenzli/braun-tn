<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Utilisateurs</title>
    <link rel="shortcut icon" href="assets/img/logo/favicon.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- css links -->
    @include('dashboard.components.style')
</head>

<body class="bg-slate-100">
    <div class="tp-main-wrapper h-screen" x-data="{ sideMenu: false }">
        @include('dashboard.components.sideleft')

        <!-- Overlay pour le menu mobile -->
        <div class="fixed inset-0 z-40 bg-black/70 transition-all duration-300" 
             :class="sideMenu ? 'visible opacity-100' : 'invisible opacity-0'" 
             x-on:click="sideMenu = !sideMenu"
             x-show="sideMenu"
             x-transition></div>

        <div class="tp-main-content lg:ml-[250px] xl:ml-[300px] w-[calc(100%-300px)]" x-data="{ searchOverlay: false }">
            @include('dashboard.components.header')

            <main class="body-content px-4 py-6 sm:px-8 sm:py-8">
                <!-- En-tête -->
                <div class="flex flex-col sm:flex-row justify-between mb-6 sm:mb-10">
                    <h1 class="text-2xl sm:text-[28px] font-semibold mb-4 sm:mb-0">Gestion des Utilisateurs</h1>
                </div>

                <!-- Message de succès -->
                @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-3 text-green-600" aria-hidden="true"></i>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                </div>
                @endif

                <!-- Formulaire d'ajout -->
                <div class="bg-white p-6 rounded-md shadow-sm mb-8" id="addUserForm">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6 pb-3 border-b">Ajouter un nouvel utilisateur</h2>
                    <form class="space-y-4" action="{{ route('dashboard.users.store') }}" method="POST">
                        @csrf
                        
                        <!-- Nom complet -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                Nom complet <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" placeholder="Entrez le nom complet"
                                class="w-full h-11 rounded-md border border-gray-300 px-4 text-base focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                                value="{{ old('name') }}" required aria-describedby="name-error">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600" id="name-error">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                Adresse email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" id="email" placeholder="Entrez l'adresse email"
                                class="w-full h-11 rounded-md border border-gray-300 px-4 text-base focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                                value="{{ old('email') }}" required aria-describedby="email-error">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600" id="email-error">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Mot de passe -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                Mot de passe <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" name="password" id="password" placeholder="Entrez un mot de passe"
                                    class="w-full h-11 rounded-md border border-gray-300 px-4 text-base pr-10 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                                    required aria-describedby="password-error">
                                <button type="button"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                    onclick="togglePasswordVisibility('password')" aria-label="Afficher/Masquer le mot de passe">
                                    <i class="far fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600" id="password-error">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Type utilisateur -->
                        <div>
                            <label for="utype" class="block text-sm font-medium text-gray-700 mb-1">
                                Type d'utilisateur
                            </label>
                            <select name="utype" id="utype"
                                class="w-full h-11 rounded-md border border-gray-300 px-4 text-base bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                <option value="USR" {{ old('utype', 'USR') === 'USR' ? 'selected' : '' }}>Utilisateur (Client)</option>
                                <option value="ADM" {{ old('utype') === 'ADM' ? 'selected' : '' }}>Administrateur</option>
                            </select>
                        </div>
                        
                        <!-- Bouton soumission -->
                        <div class="pt-2">
                            <button type="submit"
                                class="inline-flex items-center px-6 py-2 bg-black text-white hover:bg-gray-800 rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                <i class="fas fa-save mr-2"></i> Enregistrer
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Liste des utilisateurs -->
                <div class="bg-white p-6 rounded-md shadow-sm">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-6 gap-4">
                        <h2 class="text-xl font-semibold text-gray-800">Liste des utilisateurs</h2>
                        
                        <!-- Formulaire de recherche -->
                        <form action="{{ url()->current() }}" method="GET" class="w-full md:w-auto">
                            <div class="relative flex">
                                <input type="text" placeholder="Rechercher par nom ou email..." name="search" value="{{ request('search') }}"
                                    class="w-full h-11 rounded-l-md border border-gray-300 px-4 text-base focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                <button type="submit"
                                    class="px-4 py-2 bg-indigo-600 text-white rounded-r-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors text-sm font-medium">
                                    Rechercher
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Tableau des utilisateurs -->
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">#</th>
                                    <th scope="col" class="px-6 py-3">Nom</th>
                                    <th scope="col" class="px-6 py-3">Email</th>
                                    <th scope="col" class="px-6 py-3">Type</th>
                                    <th scope="col" class="px-6 py-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($users as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->utype == 'ADM' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ $user->utype == 'ADM' ? 'Administrateur' : 'Utilisateur' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <div class="flex justify-end items-center space-x-2">
                                            <!-- Bouton Modifier -->
                                            <button type="button"
                                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors"
                                                data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}" aria-label="Modifier {{ $user->name }}">
                                                <i class="fas fa-edit mr-1"></i> Modifier
                                            </button>

                                            <!-- Bouton Supprimer -->
                                            <button type="button"
                                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors"
                                                data-bs-toggle="modal" data-bs-target="#deleteUserModal{{ $user->id }}" aria-label="Supprimer {{ $user->name }}">
                                                <i class="fas fa-trash-alt mr-1"></i> Supprimer
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500">
                                        Aucun utilisateur trouvé{{ request('search') ? ' pour "' . request('search') . '"' : '' }}.
                                        @if(!request('search'))
                                            <a href="#addUserForm" class="text-indigo-600 hover:text-indigo-800 font-medium ml-1">Ajouter un utilisateur</a>.
                                        @endif
                                    </td>
                                </tr>
                                @endforelse  
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if ($users->hasPages())
                        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                            {{ $users->links() }}
                        </div>
                    @endif
                </div>
            </main>
        </div>
    </div>

    <!-- Modales -->
    @foreach($users as $user)
    <!-- Modale Modifier -->
    <div class="modal fade fixed inset-0 z-50 overflow-y-auto" id="editUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $user->id }}" aria-hidden="true">
        <div class="flex items-center justify-center min-h-screen p-4 text-center">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:align-middle sm:max-w-lg sm:w-full">
                <form action="{{ route('dashboard.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                            Modifier l'utilisateur
                        </h3>

                        <div class="space-y-4">
                            <!-- Champ Nom -->
                            <div>
                                <label for="edit-name-{{ $user->id }}" class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                                <input type="text" id="edit-name-{{ $user->id }}" name="name"
                                    value="{{ old('name', $user->name) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150"
                                    required>
                            </div>

                            <!-- Champ Email -->
                            <div>
                                <label for="edit-email-{{ $user->id }}" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" id="edit-email-{{ $user->id }}" name="email"
                                    value="{{ old('email', $user->email) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150"
                                    required>
                            </div>

                            <!-- Champ Type -->
                            <div>
                                <label for="edit-utype-{{ $user->id }}" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                                <select id="edit-utype-{{ $user->id }}" name="utype"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 bg-white">
                                    <option value="USR" {{ old('utype', $user->utype) === 'USR' ? 'selected' : '' }}>Utilisateur</option>
                                    <option value="ADM" {{ old('utype', $user->utype) === 'ADM' ? 'selected' : '' }}>Administrateur</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-white hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Enregistrer
                        </button>
                        <button type="button" data-bs-dismiss="modal"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-gray-700 hover:bg-gray-50 focus:ring-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Annuler
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modale Supprimer -->
    <div class="modal fade fixed inset-0 z-50 overflow-y-auto" id="deleteUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $user->id }}" aria-hidden="true">
        <div class="flex items-center justify-center min-h-screen p-4 text-center">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:align-middle sm:max-w-lg sm:w-full">
                <form action="{{ route('dashboard.users.destroy', $user->id) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <i class="fas fa-exclamation-triangle text-red-600"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Confirmer la suppression</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Êtes-vous sûr de vouloir supprimer l'utilisateur <span class="font-semibold">{{ $user->name }}</span> ? Cette action est irréversible.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-white hover:bg-red-700 focus:ring-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Supprimer
                        </button>
                        <button type="button" data-bs-dismiss="modal"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-gray-700 hover:bg-gray-50 focus:ring-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Annuler
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    @include('dashboard.components.js')

    <script>
        function togglePasswordVisibility(fieldId) {
            const field = document.getElementById(fieldId);
            const button = field.nextElementSibling;
            const icon = button.querySelector('i');

            if (!field || !icon) return;

            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
                button.setAttribute('aria-label', 'Masquer le mot de passe');
            } else {
                field.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
                button.setAttribute('aria-label', 'Afficher le mot de passe');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('input[type="password"]').forEach(field => {
                const button = field.nextElementSibling;
                if (button && button.tagName === 'BUTTON') {
                    const icon = button.querySelector('i');
                    if(icon) {
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                }
            });
        });
    </script>
</body>
</html>