<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Styles CSS (vérifiez les chemins) -->
    <link rel="stylesheet" href="{{ asset('assets/css/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/choices.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/apexcharts.css') }}"> 
    <link rel="stylesheet" href="{{ asset('assets/css/quill.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/rangeslider.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="{{ asset('assets/img/logo/favicon.png') }}" type="image/x-icon">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        // Couleurs personnalisées si besoin
                    }
                }
            }
        }
    </script>
    <style>
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #888; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #555; }
        /* Badges up/down arrows */
        .badge .fas.up { color: #10B981; }
        .badge .fas.down { color: #EF4444; }
        /* Traffic source bars */
        .traffic-bar-bg { background-color: rgba(var(--bar-color-rgb), 0.1); }
        .traffic-bar-fg { background-color: rgb(var(--bar-color-rgb)); }
    </style>
</head>
<body class="bg-slate-100">

    <div class="tp-main-wrapper min-h-screen flex" x-data="{ sideMenu: false }">
        @include('dashboard.components.sideleft') {{-- Assurez-vous que ce chemin est correct --}}

        <!-- Overlay for mobile menu -->
        <div class="fixed inset-0 z-40 bg-black/70 transition-opacity duration-300 lg:hidden"
             :class="sideMenu ? 'opacity-100 visible' : 'opacity-0 invisible'"
             x-on:click="sideMenu = false">
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 tp-main-content lg:ml-[250px] xl:ml-[300px]" x-data="{ searchOverlay: false }">
            @include('dashboard.components.header') {{-- Assurez-vous que ce chemin est correct --}}

            <main class="body-content px-6 py-8 md:px-8 md:py-10">
                <div class="flex flex-wrap justify-between items-center mb-8 gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
                        <p class="text-gray-600 mt-1">Bienvenue
                            <span class="font-semibold text-indigo-600">{{ Auth::user()->name ?? 'Utilisateur' }}</span>
                            sur votre tableau de bord.
                        </p>
                    </div>
                    <div>
                        <a href="{{ url('ajouter-produits') }}" {{-- ou route('nom.de.la.route') --}}
                           class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-5 rounded-lg shadow-md transition duration-150 ease-in-out flex items-center">
                           <i class="fas fa-plus mr-2"></i> Ajouter Produits
                        </a>
                    </div>
                </div>

                <!-- Filtre de Date -->
                <div class="mb-6">
                    <form method="GET" action="{{ url()->current() }}" class="flex flex-wrap items-end gap-4" style="    display: flex
!important;
    justify-content: flex-end !important;">
                        <div>
                            <label for="date_start" class="block text-sm font-medium text-gray-700">Date de début :</label>
                            <input type="date" name="date_start" id="date_start" value="{{ request('date_start') }}"
                                   class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="date_end" class="block text-sm font-medium text-gray-700">Date de fin :</label>
                            <input type="date" name="date_end" id="date_end" value="{{ request('date_end') }}"
                                   class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-150 ease-in-out">
                            Filtrer
                        </button>
                        <a href="{{ url()->current() }}"
                           class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg shadow-md transition duration-150 ease-in-out">
                            Réinitialiser
                        </a>
                       
                    </form>
                     @if(request('date_start'))
                        <p class="text-sm text-gray-600 mt-2">
                            Affichage des données pour la période du {{ \Carbon\Carbon::parse(request('date_start'))->format('d/m/Y') }}
                            @if(request('date_end'))
                                au {{ \Carbon\Carbon::parse(request('date_end'))->format('d/m/Y') }}.
                            @else
                                (journée entière).
                            @endif
                        </p>
                    @endif
                </div>

                
                <!-- Stats Cards Row 1 -->
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-6">
                    <!-- Card 1: Total Commandes reçues -->
                    <div class="bg-white p-6 rounded-xl shadow-lg flex justify-between items-start">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">
                                Total Commandes
                                @if(request('date_start')) (période) @endif
                            </p>
                            <h3 class="text-2xl font-bold text-gray-900">{{ number_format($totalOrders, 0, ',', ' ') }}</h3>
                            @if(isset($orderPercentage) && !request('date_start'))
                            <div class="badge mt-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $orderPercentage >= 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ number_format($orderPercentage, 2, ',', ' ') }}%
                                <i class="fas {{ $orderPercentage >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} ml-1"></i>
                                <span class="ml-1 text-xs">(vs sem. précédente)</span>
                            </div>
                            @endif
                        </div>
                        <div class="flex items-center justify-center h-12 w-12 rounded-full bg-green-500 text-white shrink-0">
                            <i class="fas fa-shopping-cart text-xl"></i>
                        </div>
                    </div>

                    <!-- Card 2: Montant total -->
                    <div class="bg-white p-6 rounded-xl shadow-lg flex justify-between items-start">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">
                                Montant total
                                @if(request('date_start')) (période) @endif
                            </p>
                            <h3 class="text-2xl font-bold text-gray-900">{{ number_format($totalAmount, 2, ',', ' ') }} DT</h3>
                        </div>
                        <div class="flex items-center justify-center h-12 w-12 rounded-full bg-purple-500 text-white shrink-0">
                            <i class="fas fa-money-bill-wave text-xl"></i>
                        </div>
                    </div>

                    <!-- Card 3: Nouveaux clients -->
                    <div class="bg-white p-6 rounded-xl shadow-lg flex justify-between items-start">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">
                                Clients uniques
                                @if(request('date_start')) (période) @else (total) @endif
                            </p>
                            <h3 class="text-2xl font-bold text-gray-900">{{ number_format($totalClients, 0, ',', ' ') }}</h3>
                        </div>
                        <div class="flex items-center justify-center h-12 w-12 rounded-full bg-blue-500 text-white shrink-0">
                            <i class="fas fa-user-friends text-xl"></i>
                        </div>
                    </div>

                    <!-- Card 4: Commandes en attente -->
                    <div class="bg-white p-6 rounded-xl shadow-lg flex justify-between items-start">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">
                                Commandes en attente
                                @if(request('date_start')) (période) @endif
                            </p>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $statusData['encours']['order_count'] ?? 0 }}</h3>
                        </div>
                        <div class="flex items-center justify-center h-12 w-12 rounded-full bg-yellow-500 text-white shrink-0">
                            <i class="fas fa-clock text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Stats Cards Row 2 -->
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-10">
                    <!-- Card 5: Commandes annulées -->
                    <div class="bg-white p-6 rounded-xl shadow-lg flex justify-between items-start">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">
                                Commandes annulées
                                @if(request('date_start')) (période) @endif
                            </p>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $statusData['annulé']['order_count'] ?? 0 }}</h3>
                        </div>
                        <div class="flex items-center justify-center h-12 w-12 rounded-full bg-red-500 text-white shrink-0">
                            <i class="fas fa-times-circle text-xl"></i>
                        </div>
                    </div>

                    <!-- Card 6: Montant des commandes annulées -->
                    <div class="bg-white p-6 rounded-xl shadow-lg flex justify-between items-start">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">
                                Montant commandes annulées
                                @if(request('date_start')) (période) @endif
                            </p>
                            <h3 class="text-2xl font-bold text-gray-900">{{ number_format($statusData['annulé']['total_amount'] ?? 0, 2, ',', ' ') }} DT</h3>
                        </div>
                        <div class="flex items-center justify-center h-12 w-12 rounded-full bg-pink-500 text-white shrink-0">
                             <i class="fas fa-ban text-xl"></i>
                        </div>
                    </div>

                    <!-- Card 7: Commandes livrées -->
                    <div class="bg-white p-6 rounded-xl shadow-lg flex justify-between items-start">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">
                                Commandes livrées
                                @if(request('date_start')) (période) @endif
                            </p>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $statusData['traité']['order_count'] ?? 0 }}</h3>
                        </div>
                        <div class="flex items-center justify-center h-12 w-12 rounded-full bg-teal-500 text-white shrink-0">
                            <i class="fas fa-check-circle text-xl"></i>
                        </div>
                    </div>

                    <!-- Card 8: Montant des commandes livrées -->
                    <div class="bg-white p-6 rounded-xl shadow-lg flex justify-between items-start">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">
                                Montant commandes livrées
                                @if(request('date_start')) (période) @endif
                            </p>
                            <h3 class="text-2xl font-bold text-gray-900">{{ number_format($statusData['traité']['total_amount'] ?? 0, 2, ',', ' ') }} DT</h3>
                        </div>
                        <div class="flex items-center justify-center h-12 w-12 rounded-full bg-sky-500 text-white shrink-0">
                            <i class="fas fa-truck text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 mb-10">
                    <div class="lg:col-span-3 bg-white p-6 rounded-xl shadow-lg">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">
                            Statistiques de ventes
                            @if(request('date_start'))
                                ({{ \Carbon\Carbon::parse(request('date_start'))->format('Y') }})
                            @else
                                (Année en cours)
                            @endif
                        </h2>
                        <div class="min-h-[350px]"><canvas id="salesStatics"></canvas></div>
                        <script>
                            const ventesData = @json($ventesParMois ?? []); // Assurer que la variable existe
                            const produitsData = @json($produitsParMois ?? []); // Assurer que la variable existe
                        </script>
                    </div>
                    <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-lg">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">
                            Catégories les plus vendues
                            @if(request('date_start')) (période) @endif
                        </h2>
                        <div class="flex justify-center items-center min-h-[350px]">
                            <canvas id="earningStatics" class="max-w-[300px] max-h-[300px]"></canvas>
                        </div>
                        <script>
                            const labelsCategorie = @json($labelsCategorie ?? []); // Assurer que la variable existe
                            const dataCategorie = @json($dataCategorie ?? []); // Assurer que la variable existe
                        </script>
                    </div>
                </div>

                <!-- Data Tables & Info Section -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">
                    <!-- Distribution par sexe -->
                       <!--<div class="bg-white p-6 rounded-xl shadow-lg">
                        <h2 class="text-xl font-semibold text-gray-800 mb-6">
                            Distribution par sexe
                           
                        </h2>
                        <div class="space-y-4">
                          <table class="w-full text-sm text-left text-gray-600">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-4 py-3">Sexe</th>
                                        <th scope="col" class="px-4 py-3 text-right">Nombre (Commandes Uniques)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table> 
                        </div>
                    </div>-->

                    <!-- TOP SKU Vente -->
                    <div class="lg:col-span-4 bg-white p-6 rounded-xl shadow-lg">
                        <h2 class="text-xl font-semibold text-gray-800 mb-6">
                            TOP 10 SKU Vente
                            @if(request('date_start')) (période) @endif
                        </h2>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-600">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-4 py-3">SKU</th>
                                        <th scope="col" class="px-4 py-3 text-center">Quantité Vendue</th>
                                        <th scope="col" class="px-4 py-3 text-right">CA (DT)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($topSKU as $sku)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-4 py-3 font-medium text-gray-900">{{ $sku->SKU }}</td>
                                        <td class="px-4 py-3 text-center">{{ $sku->total_quantity_sold }}</td>
                                        <td class="px-4 py-3 text-right">{{ number_format($sku->total_revenue, 2, ',', ' ') }}</td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="3" class="px-4 py-3 text-center text-gray-500">Aucune donnée SKU disponible.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                 <!-- Second Row of Data Tables & Info -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">
                    <!-- Distribution par âge -->
                    <div class="bg-white p-6 rounded-xl shadow-lg">
                        <h2 class="text-xl font-semibold text-gray-800 mb-6">
                            Distribution par âge (Clients uniques)
                            @if(request('date_start')) (période) @endif
                        </h2>
                        <ul class="space-y-3">
                            @php $hasAgeData = false; @endphp
                            @foreach ($ageDistribution as $ageRange => $count)
                                @if($count > 0)
                                    @php $hasAgeData = true; @endphp
                                    <li class="flex justify-between items-center p-3 bg-gray-50 rounded-md hover:bg-gray-100">
                                        <span class="text-sm font-medium text-gray-700">{{ $ageRange }} ans</span>
                                        <span class="text-sm text-gray-900 font-semibold">{{ $count }} personne{{ $count > 1 ? 's' : '' }}</span>
                                    </li>
                                @endif
                            @endforeach
                            @if(!$hasAgeData)
                                <li class="p-3 text-center text-gray-500">Aucune donnée d'âge pertinente pour la période.</li>
                            @endif
                        </ul>
                    </div>

                    <!-- Top 10 Commandes (par CA) -->
                    <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-lg">
                        <h2 class="text-xl font-semibold text-gray-800 mb-6">
                            Top 10 Commandes (par CA)
                            @if(request('date_start')) (période) @endif
                        </h2>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-600">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-4 py-3">Référence</th>
                                        <th scope="col" class="px-4 py-3">Nom du client</th>
                                        <th scope="col" class="px-4 py-3 text-right">CA (DT)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($topOrders as $order)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-4 py-3 font-medium text-gray-900">{{ $order->reference_commande }}</td>
                                        <td class="px-4 py-3">{{ $order->nom_client }}</td>
                                        <td class="px-4 py-3 text-right">{{ number_format($order->chiffre_affaires, 2, ',', ' ') }}</td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="3" class="px-4 py-3 text-center text-gray-500">Aucune commande à afficher pour cette période.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <!-- Traffic Source & Weekly Comparison Section -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">
                    <!-- Traffics Source -->
                    <div class="lg:col-span-1 bg-white p-6 rounded-xl shadow-lg">
                        <h2 class="text-xl font-semibold text-gray-800 mb-6">
                            Sources de Traffic
                            @if(request('date_start')) (période) @endif
                        </h2>
                        @php
                            $sourceColors = [
                                'Facebook' => ['hex' => '#3b5998', 'rgb' => '59, 89, 152'],
                                'YouTube' => ['hex' => '#FF0000', 'rgb' => '255, 0, 0'],
                                'WhatsApp' => ['hex' => '#25D366', 'rgb' => '37, 211, 102'],
                                'Instagram' => ['hex' => '#E4405F', 'rgb' => '228, 64, 95'],
                                'Tiktok' => ['hex' => '#000000', 'rgb' => '0, 0, 0'],
                                'Autres' => ['hex' => '#737373', 'rgb' => '115, 115, 115'],
                            ];
                        @endphp
                        <div class="space-y-5">
                            @forelse ($sourceDataPercent as $source => $percent)
                                @php
                                    $colorInfo = $sourceColors[$source] ?? $sourceColors['Autres'];
                                @endphp
                                <div class="bar">
                                    <div class="flex justify-between items-center mb-1">
                                        <h5 class="text-sm font-medium text-gray-700">{{ $source }}</h5>
                                        <span class="text-sm text-gray-600">{{ $percent }}%</span>
                                    </div>
                                    <div class="relative h-2.5 w-full rounded traffic-bar-bg" style="--bar-color-rgb: {{ $colorInfo['rgb'] }};">
                                        <div class="absolute top-0 left-0 h-full rounded traffic-bar-fg"
                                             style="width: {{ $percent }}%; --bar-color-rgb: {{ $colorInfo['rgb'] }};">
                                        </div>
                                    </div>
                                </div>
                            @empty
                            <p class="text-center text-gray-500">Aucune donnée de source de traffic pour cette période.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Comparaison des Commandes (Hebdomadaire sur plusieurs mois) -->
                    <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-lg">
                        <h2 class="text-xl font-semibold text-gray-800 mb-6">
                            Comparaison Commandes Hebdomadaires (6 derniers mois de réf.)
                            @if(request('date_start')) (période filtrée) @endif
                        </h2>
                        <div class="space-y-6">
                             @php
                                $lastWeekMap = collect($lastWeekData)->keyBy(0); // Clé par "Mois Année"
                            @endphp
                            @forelse($thisWeekData as $dataPoint)
                                @php
                                    $moisAnnee = $dataPoint[0]; // Format "M Y" ex: "Jan 2023"
                                    $commandesSemaineActuelle = $dataPoint[1];
                                    // Rechercher les données de la semaine dernière pour le même mois/année
                                    $commandesSemaineDerniere = $lastWeekMap->get($moisAnnee)[1] ?? 0;

                                    $total = max($commandesSemaineActuelle + $commandesSemaineDerniere, 1);
                                    $percentActuelle = $total > 0 ? round(($commandesSemaineActuelle / $total) * 100) : 0;
                                    $percentDerniere = $total > 0 ? round(($commandesSemaineDerniere / $total) * 100) : 0;
                                @endphp
                                <div>
                                    <h5 class="text-sm font-semibold text-gray-700 mb-2">{{ $moisAnnee }}</h5>
                                    <div class="space-y-2">
                                        <div>
                                            <div class="mb-1 flex justify-between">
                                                <span class="text-xs text-blue-600 font-medium">Sem. actuelle réf. ({{ $commandesSemaineActuelle }})</span>
                                                <span class="text-xs text-blue-600 font-medium">{{ $percentActuelle }}%</span>
                                            </div>
                                            <div class="relative h-2 w-full bg-blue-100 rounded-full">
                                                <div class="absolute top-0 left-0 h-full rounded-full bg-blue-500" style="width: {{ $percentActuelle }}%;"></div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="mb-1 flex justify-between">
                                                <span class="text-xs text-red-600 font-medium">Sem. précédente réf. ({{ $commandesSemaineDerniere }})</span>
                                                <span class="text-xs text-red-600 font-medium">{{ $percentDerniere }}%</span>
                                            </div>
                                            <div class="relative h-2 w-full bg-red-100 rounded-full">
                                                <div class="absolute top-0 left-0 h-full rounded-full bg-red-500" style="width: {{ $percentDerniere }}%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                            <p class="text-center text-gray-500">Aucune donnée de comparaison hebdomadaire pour cette période.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Distribution par âge et catégorie -->
                <div class="bg-white p-6 rounded-xl shadow-lg mb-10">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">
                        Distribution des commandes par âge et catégorie
                        @if(request('date_start')) (période) @endif
                    </h2>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-600">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3">Catégorie</th>
                                    @foreach(array_keys($ageDistribution) as $ageRange)
                                        <th scope="col" class="px-4 py-3 text-center">{{ $ageRange }} ans</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ageCategoryData as $category => $ageData)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-4 py-3 font-medium text-gray-900">{{ $category }}</td>
                                        @foreach($ageData as $ageRange => $count)
                                            <td class="px-4 py-3 text-center">
                                                @if($count > 0)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        {{ $count }}
                                                    </span>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ count($ageDistribution) + 1 }}" class="px-4 py-3 text-center text-gray-500">
                                            Aucune donnée disponible pour cette période.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Full Width Tables Section -->
                <div class="grid grid-cols-1 lg:grid-cols-1 gap-6 mb-6">
                     <!-- État de commande par mois -->
                     <div class="bg-white p-6 rounded-xl shadow-lg">
                        <h2 class="text-xl font-semibold text-gray-800 mb-6">
                            État des commandes par mois
                            @if(request('date_start'))
                                ({{ \Carbon\Carbon::parse(request('date_start'))->format('Y') }})
                            @else
                                (Année en cours)
                            @endif
                        </h2>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-600">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-4 py-3">Mois</th>
                                        <th scope="col" class="px-4 py-3 text-center">Totales</th>
                                        <th scope="col" class="px-4 py-3 text-center">En Attente</th>
                                        <th scope="col" class="px-4 py-3 text-center">Livrées</th>
                                        <th scope="col" class="px-4 py-3 text-center">Annulées</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php $moisNoms = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc']; @endphp
                                    @foreach($moisNoms as $i => $moisNom)
                                    @php $moisIndex = $i + 1; // Les mois dans la BDD sont 1-12 @endphp
                                    <tr class="bg-white border-b hover:bg-gray-50 {{ $loop->even ? 'bg-gray-50' : '' }}">
                                        <td class="px-4 py-3 font-medium text-gray-900">{{ $moisNom }}</td>
                                        <td class="px-4 py-3 text-center">{{ $monthlyTotalOrders[$moisIndex] ?? 0 }}</td>
                                        <td class="px-4 py-3 text-center">{{ $monthlyPendingOrders[$moisIndex] ?? 0 }}</td>
                                        <td class="px-4 py-3 text-center">{{ $monthlyDeliveredOrders[$moisIndex] ?? 0 }}</td>
                                        <td class="px-4 py-3 text-center">{{ $monthlyCanceledOrders[$moisIndex] ?? 0 }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Commande par Mode de paiement -->
                    <div class="bg-white p-6 rounded-xl shadow-lg">
                        <h2 class="text-xl font-semibold text-gray-800 mb-6">
                            Commandes par Mode de Paiement
                            @if(request('date_start')) (période) @endif
                        </h2>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-600">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-4 py-3">Mode de Paiement</th>
                                        <th scope="col" class="px-4 py-3 text-right">Nombre de Commandes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($paymentData as $mode => $count)
                                    <tr class="bg-white border-b hover:bg-gray-50 {{ $loop->even ? 'bg-gray-50' : '' }}">
                                        <td class="px-4 py-3 font-medium text-gray-900">{{ $mode }}</td>
                                        <td class="px-4 py-3 text-right">{{ $count }}</td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="2" class="px-4 py-3 text-center text-gray-500">Aucune donnée de mode de paiement pour cette période.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Commande par Gouvernorat -->
                    <div class="bg-white p-6 rounded-xl shadow-lg">
                        <h2 class="text-xl font-semibold text-gray-800 mb-6">
                            Commandes par Gouvernorat
                            @if(request('date_start')) (période) @endif
                        </h2>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-600">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-4 py-3">Gouvernorat</th>
                                        <th scope="col" class="px-4 py-3 text-right">Nombre de Commandes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($stats as $stat) {{-- $stats est maintenant $statsByGouvernorat du contrôleur --}}
                                    <tr class="bg-white border-b hover:bg-gray-50 {{ $loop->even ? 'bg-gray-50' : '' }}">
                                        <td class="px-4 py-3 font-medium text-gray-900">{{ $stat->gouvernorat ?? 'Non spécifié' }}</td>
                                        <td class="px-4 py-3 text-right">{{ $stat->nombre_commandes }}</td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="2" class="px-4 py-3 text-center text-gray-500">Aucune donnée de gouvernorat pour cette période.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Statistiques de retour/traffic -->
                <div class="bg-white p-6 rounded-xl shadow-lg mb-10">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">
                        Analyse des sources de traffic et taux de retour
                        @if(request('date_start')) (période) @endif
                    </h2>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-600">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3">Source</th>
                                    <th scope="col" class="px-4 py-3 text-center">Total Commandes</th>
                                    <th scope="col" class="px-4 py-3 text-center">Commandes Traitées</th>
                                    <th scope="col" class="px-4 py-3 text-center">Commandes Annulées</th>
                                    <th scope="col" class="px-4 py-3 text-center">En Attente</th>
                                    <th scope="col" class="px-4 py-3 text-center">Taux de Complétion</th>
                                    <th scope="col" class="px-4 py-3 text-center">Taux d'Annulation</th>
                                    <th scope="col" class="px-4 py-3 text-center">CA Réalisé</th>
                                    <th scope="col" class="px-4 py-3 text-center">CA Perdu</th>
                                    <th scope="col" class="px-4 py-3 text-center">Panier Moyen</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($trafficReturnData as $stat)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-4 py-3 font-medium text-gray-900">{{ $stat['source'] }}</td>
                                        <td class="px-4 py-3 text-center">{{ $stat['total_orders'] }}</td>
                                        <td class="px-4 py-3 text-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                {{ $stat['completed_orders'] }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                {{ $stat['canceled_orders'] }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                {{ $stat['pending_orders'] }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                {{ $stat['completion_rate'] }}%
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                {{ $stat['cancel_rate'] }}%
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-center font-medium text-green-600">
                                            {{ number_format($stat['completed_revenue'], 2, ',', ' ') }} DT
                                        </td>
                                        <td class="px-4 py-3 text-center font-medium text-red-600">
                                            {{ number_format($stat['canceled_revenue'], 2, ',', ' ') }} DT
                                        </td>
                                        <td class="px-4 py-3 text-center font-medium text-blue-600">
                                            {{ number_format($stat['avg_order_value'], 2, ',', ' ') }} DT
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="px-4 py-3 text-center text-gray-500">
                                            Aucune donnée disponible pour cette période.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

   
     <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Sales Statics Chart (Ventes et Produits par mois)
            const salesCtx = document.getElementById('salesStatics');
            if (salesCtx && typeof ventesData !== 'undefined' && typeof produitsData !== 'undefined') {
                new Chart(salesCtx.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'],
                        datasets: [{
                            label: 'Ventes (Commandes)',
                            data: ventesData, // Vient de @json($ventesParMois)
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }, {
                            label: 'Produits Vendus (Uniques)',
                            data: produitsData, // Vient de @json($produitsParMois)
                            backgroundColor: 'rgba(255, 99, 132, 0.6)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: { y: { beginAtZero: true } }
                    }
                });
            }

            // Earning Statics Chart (Catégories les plus vendues)
            const earningCtx = document.getElementById('earningStatics');
            if (earningCtx && typeof labelsCategorie !== 'undefined' && typeof dataCategorie !== 'undefined' && labelsCategorie.length > 0) {
                new Chart(earningCtx.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: labelsCategorie, // Vient de @json($labelsCategorie)
                        datasets: [{
                            label: 'Ventes par Catégorie',
                            data: dataCategorie, // Vient de @json($dataCategorie)
                            backgroundColor: [ // Ajoutez plus de couleurs si vous avez plus de catégories
                                'rgba(255, 99, 132, 0.7)', 'rgba(54, 162, 235, 0.7)',
                                'rgba(255, 206, 86, 0.7)', 'rgba(75, 192, 192, 0.7)',
                                'rgba(153, 102, 255, 0.7)', 'rgba(255, 159, 64, 0.7)',
                                'rgba(199, 199, 199, 0.7)', 'rgba(83, 102, 255, 0.7)',
                                'rgba(100, 233, 100, 0.7)', 'rgba(240, 150, 240, 0.7)'
                            ],
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                    }
                });
            } else if (earningCtx) {
                earningCtx.getContext('2d').fillText("Aucune donnée de catégorie pour cette période.", earningCtx.width/2 - 70, earningCtx.height/2);
            }
        });
    </script>


     @include('dashboard.components.js')  
</body>
</html>