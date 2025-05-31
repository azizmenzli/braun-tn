<!DOCTYPE html>
<html lang="fr">

 <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Braun - Commandes</title>
    <link rel="shortcut icon" href="../assets/img/logo/favicon.png" type="image/x-icon">

    <!-- css links -->
    <link rel="stylesheet" href="{{ asset('assets/css/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/choices.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/apexcharts.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/quill.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/rangeslider.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body>

    <div class="tp-main-wrapper bg-slate-100 h-screen" x-data="{ sideMenu: false }">
        @include('dashboard.components.sideleft')

        <div class="fixed top-0 left-0 w-full h-full z-40 bg-black/70 transition-all duration-300" :class="sideMenu ? 'visible opacity-1' : '  invisible opacity-0 '" x-on:click="sideMenu = ! sideMenu"> </div>

        <div class="tp-main-content lg:ml-[250px] xl:ml-[300px] w-[calc(100% - 300px)]"  x-data="{ searchOverlay: false }">
 
            @include('dashboard.components.header')

            <div class="body-content px-8 py-8 bg-slate-100">
                <div class="flex justify-between mb-10">
                    <div class="page-title">
                        <h3 class="mb-0 text-[28px]">Commandes</h3>
                        <ul class="text-tiny font-medium flex items-center space-x-3 text-text3">
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('dashboard.home') }}"" class="text-hover-primary"> Accueil</a>
                            </li>
                            <li class="breadcrumb-item flex items-center">
                                <span class="inline-block bg-text3/60 w-[4px] h-[4px] rounded-full"></span>
                            </li>
                            <li class="breadcrumb-item text-muted">Liste commandes</li>
                                           
                        </ul>
                    </div>
                </div>

                <!-- table -->
                <div class="bg-white rounded-t-md rounded-b-md shadow-xs py-4">
                    @if(session('success'))
                    <div class="flex items-center p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
                        <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <span class="sr-only">Succès</span>
                        <div>
                            <span class="font-medium">Succès!</span>   {{ session('success') }} .
                        </div>
                    </div>
                    @endif
                
                    <div class="tp-search-box flex items-center justify-between px-8 py-8 flex-wrap">
                        <div class="search-input relative">
                        <form action="{{ route('dashboard.commandes.groupedOrders') }}" method="GET">
                                <input class="input h-[44px] w-full pl-14" type="text" name="search" placeholder="Rechercher par identifiant de commande" value="{{ request('search') }}">
                                <button class="absolute top-1/2 left-5 translate-y-[-50%] hover:text-theme">
                                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9 17C13.4183 17 17 13.4183 17 9C17 4.58172 13.4183 1 9 1C4.58172 1 1 4.58172 1 9C1 13.4183 4.58172 17 9 17Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M18.9999 19L14.6499 14.65" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                        <div class="flex justify-end gap-4 px-8 pb-4">
                            <button onclick="exportTableToCSV('commandes.csv')" class="px-4 py-2 bg-green-500 text-white rounded">Exporter CSV</button>
                            <button onclick="exportTableToPDF()" class="px-4 py-2 bg-red-500 text-white rounded">Exporter PDF</button>
                        </div>
                        </div>
                        
                    <!-- Bulk Status Update Form -->
                    <div class="px-8 py-4 bg-gray-50 border-b">
                        <form id="bulkStatusForm" action="{{ route('dashboard.commandes.updateBulkStatus') }}" method="POST" class="flex items-center gap-4">
                            @csrf
                            <select name="status" class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                <option value="">Sélectionner un statut</option>
                                <option value="encours">En attente</option>
                                <option value="traite">Envoyée</option>
                                <option value="annule">Annulée</option>
                            </select>
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 text-sm">
                                Mettre à jour les commandes sélectionnées
                            </button>
                        </form>
                    </div>
                
                    <div class="relative overflow-x-auto mx-8">
                    <table class="min-w-full divide-y divide-gray-200 rounded-lg overflow-hidden shadow bg-white">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-3 py-3 text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    </th>
                                    <th class="px-3 py-3 text-xs font-semibold text-gray-700 uppercase tracking-wider">#REF</th>
                                    <th class="px-3 py-3 text-xs font-semibold text-gray-700 uppercase tracking-wider">Date de commande</th>
                                    <th class="px-3 py-3 text-xs font-semibold text-gray-700 uppercase tracking-wider">Client</th>
                                    <th class="px-3 py-3 text-xs font-semibold text-gray-700 uppercase tracking-wider">Téléphone</th>
                                    <th class="px-3 py-3 text-xs font-semibold text-gray-700 uppercase tracking-wider">E-mail</th>
                                    <th class="px-3 py-3 text-xs font-semibold text-gray-700 uppercase tracking-wider">Gouvernorat</th>
                                    <th class="px-3 py-3 text-xs font-semibold text-gray-700 uppercase tracking-wider">Mode de paiement</th>
                                    <th class="px-3 py-3 text-xs font-semibold text-gray-700 uppercase tracking-wider">Statut de paiement</th>
                                    <th class="px-3 py-3 text-xs font-semibold text-gray-700 uppercase tracking-wider">Adresse</th>
                                    <th class="px-3 py-3 text-xs font-semibold text-gray-700 uppercase tracking-wider">Total</th>
                                    <th class="px-3 py-3 text-xs font-semibold text-gray-700 uppercase tracking-wider">Statut</th>
                                    <th class="px-3 py-3 text-xs font-semibold text-gray-700 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($groupedOrders as $red_order => $ordersGroup)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-3 py-3">
                                            <input type="checkbox" name="selected_orders[]" value="{{ $red_order }}" class="order-checkbox rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        </td>
                                        <td class="px-3 py-3 font-semibold text-blue-600">
                                            <a href="{{ route('dashboard.commandes.show', $red_order) }}" class="hover:underline">#{{ $red_order }}</a>
                                        </td>
                                        <td class="px-3 py-3 text-gray-600">
                                            <a href="{{ route('dashboard.commandes.show', $red_order) }}" class="hover:underline">
                                                {{ \Carbon\Carbon::parse($ordersGroup[0]->date_order)->format('d/m/Y H:i') }}
                                            </a>
                                        </td>
                                        <td class="px-3 py-3">{{ $ordersGroup[0]->nom }} {{ $ordersGroup[0]->prenom }}</td>
                                        <td class="px-3 py-3">{{ $ordersGroup[0]->telephone }}</td>
                                        <td class="px-3 py-3">{{ $ordersGroup[0]->email }}</td>
                                        <td class="px-3 py-3">{{ $ordersGroup[0]->gouvernorat }}</td>
                                        <td class="px-3 py-3">
                                            @if(isset($ordersGroup[0]->mode_paiement))
                                                @if($ordersGroup[0]->mode_paiement === 'carte')
                                                    <span class="inline-block px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded">Carte bancaire</span>
                                                @elseif($ordersGroup[0]->mode_paiement === 'espece')
                                                    <span class="inline-block px-2 py-1 text-xs font-medium text-gray-800 bg-gray-100 rounded">Espèces</span>
                                                @else
                                                    <span class="inline-block px-2 py-1 text-xs font-medium text-gray-800 bg-gray-100 rounded">{{ $ordersGroup[0]->mode_paiement }}</span>
                                                @endif
                                            @else
                                                <span class="inline-block px-2 py-1 text-xs font-medium text-gray-800 bg-gray-100 rounded">Non défini</span>
                                            @endif
                                        </td>
                                        <td class="px-3 py-3">
                                            @if(isset($ordersGroup[0]->mode_paiement) && $ordersGroup[0]->mode_paiement === 'carte')
                                                @if(isset($ordersGroup[0]->payment_status))
                                                    @if($ordersGroup[0]->payment_status === 'success')
                                                        <span class="inline-block px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded">Payé</span>
                                                    @elseif($ordersGroup[0]->payment_status === 'pending')
                                                        <span class="inline-block px-2 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded">En attente</span>
                                                    @elseif($ordersGroup[0]->payment_status === 'failed')
                                                        <span class="inline-block px-2 py-1 text-xs font-medium text-red-800 bg-red-100 rounded">Échoué</span>
                                                    @else
                                                        <span class="inline-block px-2 py-1 text-xs font-medium text-gray-800 bg-gray-100 rounded">Non initié</span>
                                                    @endif
                                                @else
                                                    <span class="inline-block px-2 py-1 text-xs font-medium text-gray-800 bg-gray-100 rounded">Non initié</span>
                                                @endif
                                            @else
                                                <span class="inline-block px-2 py-1 text-xs font-medium text-gray-800 bg-gray-100 rounded">Espèce</span>
                                            @endif
                                        </td>
                                        <td class="px-3 py-3">{{ $ordersGroup[0]->adress }}</td>
                                        <td class="px-3 py-3 font-semibold text-green-700">
                                            <a href="{{ route('dashboard.commandes.show', $red_order) }}" class="hover:underline">
                                                {{ $ordersGroup->sum('total') }} DT
                                            </a>
                                        </td>
                                        <td class="px-1 py-3">
                                            <a href="{{ route('dashboard.commandes.show', $red_order) }}">
                                                @if($ordersGroup[0]->status === 'encours')
                                                    <span class="bg-amber-100 text-amber-800 text-xs font-medium px-2 py-1 rounded-full">En attente</span>
                                                @elseif($ordersGroup[0]->status === 'traité')
                                                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full">Envoyée</span>
                                                @elseif($ordersGroup[0]->status === 'annulé')
                                                    <span class="bg-red-100 text-red-800 text-xs font-medium px-2 py-1 rounded-full">Annulée</span>
                                                @else
                                                    <span class="inline-block px-2 py-1 text-xs font-medium text-gray-800 bg-gray-100 rounded">{{ $ordersGroup[0]->status }}</span>
                                                @endif
                                            </a>
                                        </td>
                                        <td class="px-3 py-3 text-end">
                                            <div class="flex justify-end space-x-2">
                                                <a href="{{ route('dashboard.commandes.show', $red_order) }}"
                                                   class="flex items-center justify-center w-8 h-8 bg-green-600 text-white rounded-md hover:bg-green-700"
                                                   target="_blank" title="Voir la commande">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12s-3.75 6.75-9.75 6.75S2.25 12 2.25 12z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                </a>
                                                <a href="{{ route('dashboard.commandes.export.pdf', $red_order) }}"
                                                   target="_blank"
                                                   class="flex items-center justify-center w-8 h-8 bg-red-600 text-white rounded-md hover:bg-red-700"
                                                   title="Exporter en PDF">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a.75.75 0 00-.75-.75h-1.5V6a.75.75 0 00-.75-.75H8.25a.75.75 0 00-.75.75v4.875H6a.75.75 0 00-.75.75v2.625a.75.75 0 00.75.75h1.5V18a.75.75 0 00.75.75h9a.75.75 0 00.75-.75v-3h1.5a.75.75 0 00.75-.75z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                    </div>
                
                    <!-- Pagination -->
                    <div class="flex justify-end px-8 py-4">
                        {{ $orders->links() }}
                    </div>
                </div>
                
                   
                   
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
                
                <script>
                    function exportTableToCSV(filename) {
                        const rows = document.querySelectorAll("table tr");
                        let csv = [];
                
                        rows.forEach(row => {
                            let cols = Array.from(row.querySelectorAll("td, th"))
                                            .map(col => `"${col.innerText.replace(/"/g, '""')}"`);
                            csv.push(cols.join(","));
                        });
                
                        const blob = new Blob([csv.join("\n")], { type: "text/csv;charset=utf-8;" });
                        const link = document.createElement("a");
                
                        if (navigator.msSaveBlob) { // IE 10+
                            navigator.msSaveBlob(blob, filename);
                        } else {
                            link.href = URL.createObjectURL(blob);
                            link.setAttribute("download", filename);
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);
                        }
                    }
                
                    async function exportTableToPDF() {
                        const { jsPDF } = window.jspdf;
                        const doc = new jsPDF();
                
                        const table = document.querySelector("table");
                        const rows = [...table.querySelectorAll("tr")].map(row => {
                            return [...row.querySelectorAll("td, th")].map(cell => cell.innerText);
                        });
                
                        doc.autoTable({
                            head: [rows[0]],
                            body: rows.slice(1),
                            startY: 20,
                            styles: { fontSize: 8 },
                            headStyles: { fillColor: [41, 128, 185] }
                        });
                
                        doc.save("commandes.pdf");
                    }

                    // Add new script for bulk selection
                    document.addEventListener('DOMContentLoaded', function() {
                        const selectAllCheckbox = document.getElementById('selectAll');
                        const orderCheckboxes = document.querySelectorAll('.order-checkbox');
                        const bulkStatusForm = document.getElementById('bulkStatusForm');

                        if (!selectAllCheckbox || !bulkStatusForm) {
                            console.error('Required elements not found');
                            return;
                        }

                        // Handle "Select All" checkbox
                        selectAllCheckbox.addEventListener('change', function() {
                            orderCheckboxes.forEach(checkbox => {
                                checkbox.checked = this.checked;
                            });
                        });

                        // Handle individual checkboxes
                        orderCheckboxes.forEach(checkbox => {
                            checkbox.addEventListener('change', function() {
                                const allChecked = Array.from(orderCheckboxes).every(cb => cb.checked);
                                selectAllCheckbox.checked = allChecked;
                            });
                        });

                        // Handle bulk status update form submission
                        bulkStatusForm.addEventListener('submit', function(e) {
                            e.preventDefault();
                            const selectedOrders = Array.from(orderCheckboxes)
                                .filter(cb => cb.checked)
                                .map(cb => cb.value);

                            if (selectedOrders.length === 0) {
                                alert('Veuillez sélectionner au moins une commande');
                                return;
                            }

                            const formData = new FormData(this);
                            selectedOrders.forEach(orderId => {
                                formData.append('order_ids[]', orderId);
                            });

                            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                            if (!csrfToken) {
                                console.error('CSRF token not found');
                                alert('Erreur de sécurité. Veuillez rafraîchir la page.');
                                return;
                            }

                            fetch(this.action, {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => {
                                if (!response.ok) {
                                    return response.json().then(data => {
                                        throw new Error(data.message || 'Une erreur est survenue');
                                    });
                                }
                                return response.json();
                            })
                            .then(data => {
                                if (data.success) {
                                    window.location.reload();
                                } else {
                                    alert(data.message || 'Une erreur est survenue lors de la mise à jour des statuts');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert(error.message || 'Une erreur est survenue lors de la mise à jour des statuts');
                            });
                        });

                        function openEditModal(redOrder, nom, prenom, email, telephone, gouvernorat, adress, status) {
                            document.getElementById('editModal').classList.remove('hidden');
                            document.getElementById('editForm').action = `/dashboard/commandes/${redOrder}`;
                            document.getElementById('edit_nom').value = nom;
                            document.getElementById('edit_prenom').value = prenom;
                            document.getElementById('edit_email').value = email;
                            document.getElementById('edit_telephone').value = telephone;
                            document.getElementById('edit_gouvernorat').value = gouvernorat;
                            document.getElementById('edit_adress').value = adress;
                            document.getElementById('edit_status').value = status;
                        }

                        function closeEditModal() {
                            document.getElementById('editModal').classList.add('hidden');
                        }

                        document.getElementById('editForm').addEventListener('submit', function(e) {
                            e.preventDefault();
                            const formData = new FormData(this);
                            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                            fetch(this.action, {
                                method: 'PUT',
                                body: formData,
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => {
                                if (!response.ok) {
                                    return response.json().then(data => {
                                        throw new Error(data.message || 'Une erreur est survenue');
                                    });
                                }
                                return response.json();
                            })
                            .then(data => {
                                if (data.success) {
                                    window.location.reload();
                                } else {
                                    alert(data.message || 'Une erreur est survenue lors de la modification de la commande');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert(error.message || 'Une erreur est survenue lors de la modification de la commande');
                            });
                        });

                        function deleteOrder(redOrder) {
                            if (confirm('Êtes-vous sûr de vouloir supprimer cette commande ?')) {
                                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                                fetch(`/dashboard/commandes/${redOrder}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': csrfToken,
                                        'Accept': 'application/json'
                                    }
                                })
                                .then(response => {
                                    if (!response.ok) {
                                        return response.json().then(data => {
                                            throw new Error(data.message || 'Une erreur est survenue');
                                        });
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    if (data.success) {
                                        window.location.reload();
                                    } else {
                                        alert(data.message || 'Une erreur est survenue lors de la suppression de la commande');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    alert(error.message || 'Une erreur est survenue lors de la suppression de la commande');
                                });
                            }
                        }

                        // Expose functions to window scope
                        window.openEditModal = openEditModal;
                        window.closeEditModal = closeEditModal;
                        window.deleteOrder = deleteOrder;
                    });
                </script>
                
                </div>
            </div>
        </div>
    </div>

    @include('dashboard.components.js')

    <!-- Modal de modification -->
    <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Modifier la commande</h3>
                <form id="editForm" class="space-y-4">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nom</label>
                        <input type="text" name="nom" id="edit_nom" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Prénom</label>
                        <input type="text" name="prenom" id="edit_prenom" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="edit_email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Téléphone</label>
                        <input type="text" name="telephone" id="edit_telephone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Gouvernorat</label>
                        <input type="text" name="gouvernorat" id="edit_gouvernorat" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Adresse</label>
                        <input type="text" name="adress" id="edit_adress" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Statut</label>
                        <select name="status" id="edit_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="encours">En attente</option>
                            <option value="traite">Envoyée</option>
                            <option value="annule">Annulée</option>
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
    
</body>

 </html>