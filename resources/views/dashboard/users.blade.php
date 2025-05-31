<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gestion des Utilisateurs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome optimisé -->
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"></noscript>
    <link rel="shortcut icon" href="../assets/img/logo/favicon.png" type="image/x-icon">
 
</head>
<body class="bg-slate-100">
   
    <div class="tp-main-wrapper bg-slate-100 h-screen" x-data="{ sideMenu: false }">
        @include('dashboard.components.sideleft')
 
        <div class="fixed top-0 left-0 w-full h-full z-40 bg-black/70 transition-all duration-300" :class="sideMenu ? 'visible opacity-1' : '  invisible opacity-0 '" x-on:click="sideMenu = ! sideMenu"> </div>
 
        <div class="tp-main-content lg:ml-[250px] xl:ml-[300px] w-[calc(100% - 300px)]"  x-data="{ searchOverlay: false }">
 
            @include('dashboard.components.header')
 
            <div class="body-content px-8 py-8 bg-slate-100">
               
 
                <!-- table -->
                <div class="bg-white rounded-t-md rounded-b-md shadow-xs py-4">
                 
 
            <main class="body-content px-4 py-6 sm:px-8 sm:py-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
                    <div>
                        <h3 class="text-3xl font-bold text-gray-800">Equipes</h3>
                        <ul class="text-sm font-medium flex items-center space-x-2 text-gray-500 mt-1">
                            <li>
                                <a href="{{ route('dashboard.home') }}" class="hover:text-blue-600">Tableau de bord</a>
                            </li>
                            <li><i class="fas fa-chevron-right text-xs"></i></li>
                            <li class="text-gray-500"> <a href="{{ route('dashboard.users.index') }}" class="hover:text-blue-600">Equipes </a></li>
                        </ul>
                    </div>
                </div>
 
                @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-3 text-green-600 flex-shrink-0"></i>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                </div>
                @endif
 
                <!-- Formulaire Ajout Utilisateur -->
                <div class="bg-white p-6 rounded-md shadow-sm mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6 pb-3 border-b">Ajouter un nouvel utilisateur</h2>
                    <form class="space-y-4" action="{{ route('dashboard.users.store') }}" method="POST">
                        @csrf
                        <!-- Nom -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                Nom complet <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" required placeholder="Entrez le nom complet"
                                   value="{{ old('name') }}"
                                   class="w-full h-11 rounded-md border border-gray-300 px-4 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                            @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
 
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                Adresse email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" id="email" required placeholder="Entrez l'adresse email"
                                   value="{{ old('email') }}"
                                   class="w-full h-11 rounded-md border border-gray-300 px-4 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                            @error('email') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
 
                        <!-- Mot de passe -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                Mot de passe <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" name="password" id="password" required placeholder="Entrez un mot de passe"
                                       class="w-full h-11 rounded-md border border-gray-300 px-4 pr-10 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                        onclick="togglePasswordVisibility('password')" aria-label="Afficher/Masquer mot de passe">
                                    <i class="far fa-eye"></i>
                                </button>
                            </div>
                            @error('password') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
 
                        <!-- Type utilisateur -->
                        <div>
                            <label for="utype" class="block text-sm font-medium text-gray-700 mb-1">Type d'utilisateur</label>
                            <select name="utype" id="utype"
                                    class="w-full h-11 rounded-md border border-gray-300 px-4 bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                <option value="USR" {{ old('utype', 'USR') == 'USR' ? 'selected' : '' }}>Utilisateur (Client)</option>
                                <option value="ADM" {{ old('utype') == 'ADM' ? 'selected' : '' }}>Administrateur</option>
                            </select>
                        </div>
 
                        <!-- Bouton -->
                        <div class="pt-2">
                            <button type="submit"
                                    class="inline-flex items-center px-6 py-2.5 bg-black text-white hover:bg-gray-800 rounded-md transition-colors focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                <i class="fas fa-save mr-2"></i> Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
 
                <!-- Liste des utilisateurs -->
                <div class="bg-white p-6 rounded-md shadow-sm">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 mb-6">
                        <h2 class="text-xl font-semibold text-gray-800">Liste des utilisateurs</h2>
                        <form action="{{ url()->current() }}" method="GET" class="w-full md:w-auto min-w-[250px]">
                            <div class="relative flex">
                                <input type="text" name="search" value="{{ request('search') }}"
                                       placeholder="Rechercher par nom ou email..."
                                       class="w-full h-11 rounded-l-md border border-gray-300 px-4 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                <button type="submit"
                                        class="px-4 py-2 bg-indigo-600 text-white rounded-r-lg hover:bg-indigo-700 text-sm font-medium">
                                    <i class="fas fa-search mr-1"></i> Rechercher
                                </button>
                            </div>
                        </form>
                    </div>
 
                    <!-- Tableau -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3">#</th>
                                    <th class="px-4 py-3">Nom</th>
                                    <th class="px-4 py-3">Email</th>
                                    <th class="px-4 py-3">Type</th>
                                    <th class="px-4 py-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($users as $user)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-4">{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                                    <td class="px-4 py-4 font-medium text-gray-900">{{ $user->name }}</td>
                                    <td class="px-4 py-4">{{ $user->email }}</td>
                                    <td class="px-4 py-4">
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->utype == 'ADM' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ $user->utype == 'ADM' ? 'Administrateur' : 'Utilisateur' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-right">
                                        <div class="flex justify-end space-x-2">
                                            <button onclick="openEditModal('{{ $user->id }}', '{{ $user->name }}', '{{ $user->email }}', '{{ $user->utype }}')"
                                                    class="flex items-center justify-center w-10 h-10 bg-blue-600 text-white rounded-md hover:bg-blue-700"
                                                    title="Modifier l'utilisateur">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                </svg>
                                            </button>
                                            <button onclick="deleteUser('{{ $user->id }}')"
                                                    class="flex items-center justify-center w-10 h-10 bg-red-600 text-white rounded-md hover:bg-red-700"
                                                    title="Supprimer l'utilisateur">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                                </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-4 text-center text-gray-500">Aucun utilisateur trouvé</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
 
                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </main>
        </div>
    </div>
        </div>
    </div>
   
    <!-- Modal de modification -->
    <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Modifier l'utilisateur</h3>
                <form id="editForm" class="space-y-4">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nom</label>
                        <input type="text" name="name" id="edit_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="edit_email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Type d'utilisateur</label>
                        <select name="utype" id="edit_utype" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="USR">Utilisateur</option>
                            <option value="ADM">Administrateur</option>
                        </select>
                    </div>
                    <div class="flex justify-end space-x-3 mt-4">
                        <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Annuler</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Enregistrer</button>
                    </div>
                </form>
    </div>
        </div>
    </div>
   
    <script>
        function togglePasswordVisibility(id) {
            const input = document.getElementById(id);
            input.type = input.type === 'password' ? 'text' : 'password';
        }

        function openEditModal(id, name, email, utype) {
            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editForm').action = `/dashboard/users/${id}`;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_utype').value = utype;
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        document.getElementById('editForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Récupérer les valeurs du formulaire
            const formData = new FormData();
            formData.append('_method', 'PUT');
            formData.append('name', document.getElementById('edit_name').value);
            formData.append('email', document.getElementById('edit_email').value);
            formData.append('utype', document.getElementById('edit_utype').value);
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(this.action, {
                method: 'POST', // On utilise POST car Laravel attend une requête POST pour les requêtes PUT
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    let errorMessage = 'Une erreur est survenue';
                    if (data.message) {
                        errorMessage = data.message;
                    } else if (data.errors) {
                        errorMessage = Object.values(data.errors).flat().join('\n');
                    }
                    alert(errorMessage);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Une erreur est survenue lors de la modification de l\'utilisateur');
            });
        });

        function deleteUser(id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch(`/dashboard/users/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        alert(data.message || 'Une erreur est survenue lors de la suppression de l\'utilisateur');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Une erreur est survenue lors de la suppression de l\'utilisateur');
                });
            }
        }
    </script>
        @include('dashboard.components.js')
 
</body>
</html>