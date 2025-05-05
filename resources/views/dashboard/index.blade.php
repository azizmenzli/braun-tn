<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="{{ asset('assets/css/perfect-scrollbar.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/choices.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/apexcharts.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/quill.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/rangeslider.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

   <link rel="shortcut icon" href="assets/img/logo/favicon.png" type="image/x-icon">

</head>
<body>

    <div class="tp-main-wrapper bg-slate-100 h-screen" x-data="{ sideMenu: false }">
        @include('dashboard.components.sideleft')

        <div class="fixed top-0 left-0 w-full h-full z-40 bg-black/70 transition-all duration-300" :class="sideMenu ? 'visible opacity-1' : '  invisible opacity-0 '" x-on:click="sideMenu = ! sideMenu"> </div>

        <div class="tp-main-content lg:ml-[250px] xl:ml-[300px] w-[calc(100% - 300px)]"  x-data="{ searchOverlay: false }">

            @include('dashboard.components.header')
            <div class="body-content px-8 py-8 bg-slate-100">
                <div class="flex justify-between items-end flex-wrap">
                    <div class="page-title mb-7">
                        <h3 class="mb-0 text-4xl">Dashboard</h3>
                        <p class="text-textBody m-0">Bienvenue <span class="badge space-x-1">
                            {{ Auth::user()->name ?? 'Utilisateur' }}</span> sur votre tableau de bord</p>
                    </div>
                    <div class=" mb-7">
                        <a href="ajouter-produits" class="tp-btn px-5 py-2">Ajouter  produits</a>
                    </div>
                </div>

                <!-- card -->
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-6">
                    <!-- Carte 1 - Total Commandes reçues -->
                    <div class="widget-item bg-white p-6 flex justify-between rounded-md">
                        <div>
                            <h4 class="text-xl font-semibold text-slate-700 mb-1 leading-none">{{ number_format($totalOrders, 2) }}</h4>
                            <p class="text-tiny leading-4">Total Commandes reçues</p>
                            <div class="badge space-x-1"> <span>{{ number_format($orderPercentage, 2) }}%</span> 
                                <i class="fas fa-arrow-up text-xs {{ $orderPercentage >= 0 ? 'up' : 'down' }}"></i>
                            </div>
                        </div>
                        <div>
                            <span class="text-lg text-white rounded-full flex items-center justify-center h-12 w-12 shrink-0 bg-success">
                                <i class="fas fa-shopping-cart text-xl"></i>
                            </span>
                        </div>
                    </div>
                
                    <!-- Carte 2 - Montant total -->
                    <div class="widget-item bg-white p-6 flex justify-between rounded-md">
                        <div>
                            <h4 class="text-xl font-semibold text-slate-700 mb-1 leading-none">{{ number_format($totalAmount, 2, ',', ' ') }} DT</h4>
                            <p class="text-tiny leading-4">Montant total</p>
                            <div class="badge space-x-1 text-purple bg-purple/10"><span>30%</span> 
                                <i class="fas fa-arrow-up text-xs"></i>
                            </div>
                        </div>
                        <div>
                            <span class="text-lg text-white rounded-full flex items-center justify-center h-12 w-12 shrink-0 bg-purple">
                                <i class="fas fa-money-bill-wave text-xl"></i>
                            </span>
                        </div>
                    </div>
                
                    <!-- Carte 3 - Nouveaux clients -->
                    <div class="widget-item bg-white p-6 flex justify-between rounded-md">
                        <div>
                            <h4 class="text-xl font-semibold text-slate-700 mb-1 leading-none">5.8K</h4>
                            <p class="text-tiny leading-4">Nouveaux clients ce mois-ci</p>
                            <div class="badge space-x-1 text-info bg-info/10"><span>13%</span> 
                                <i class="fas fa-arrow-up text-xs"></i>
                            </div>
                        </div>
                        <div>
                            <span class="text-lg text-white rounded-full flex items-center justify-center h-12 w-12 shrink-0 bg-info">
                                <i class="fas fa-user-friends text-xl"></i>
                            </span>
                        </div>
                    </div>
                
                    <!-- Carte 4 - Commandes en attente -->
                    <div class="widget-item bg-white p-6 flex justify-between rounded-md">
                        <div>
                            <h4 class="text-xl font-semibold text-slate-700 mb-1 leading-none">{{ $statusData['encours']['order_count'] }}</h4>
                            <p class="text-tiny leading-4">Commandes en attente</p>
                            <div class="badge space-x-1 text-warning bg-warning/10"><span>10%</span> 
                                <i class="fas fa-arrow-up text-xs"></i>
                            </div>
                        </div>
                        <div>
                            <span class="text-lg text-white rounded-full flex items-center justify-center h-12 w-12 shrink-0 bg-warning">
                                <i class="fas fa-clock text-xl"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-6">
                    <!-- Carte 1 - Commandes annulées -->
                    <div class="widget-item bg-white p-6 flex justify-between rounded-md">
                        <div>
                            <h4 class="text-xl font-semibold text-slate-700 mb-1 leading-none">{{ $statusData['annulé']['order_count'] }}</h4>
                            <p class="text-tiny leading-4">Commandes annulées</p>
                            <div class="badge space-x-1"> 
                                <span>10%</span>
                                <i class="fas fa-arrow-up text-xs"></i>
                            </div>
                        </div>
                        <div>
                            <span class="text-lg text-white rounded-full flex items-center justify-center h-12 w-12 shrink-0 bg-danger">
                                <i class="fas fa-times-circle text-xl"></i>
                            </span>
                        </div>
                    </div>
                
                    <!-- Carte 2 - Montant des commandes annulées -->
                    <div class="widget-item bg-white p-6 flex justify-between rounded-md">
                        <div>
                            <h4 class="text-xl font-semibold text-slate-700 mb-1 leading-none">{{ number_format($statusData['annulé']['total_amount'], 2, ',', ' ') }} DT</h4>
                            <p class="text-tiny leading-4">Montant des commandes annulées</p>
                            <div class="badge space-x-1 text-purple bg-purple/10">
                                <span>30%</span>
                                <i class="fas fa-arrow-up text-xs"></i>
                            </div>
                        </div>
                        <div>
                            <span class="text-lg text-white rounded-full flex items-center justify-center h-12 w-12 shrink-0 bg-purple">
                                <i class="fas fa-ban text-xl"></i>
                            </span>
                        </div>
                    </div>
                
                    <!-- Carte 3 - Commandes livrées -->
                    <div class="widget-item bg-white p-6 flex justify-between rounded-md">
                        <div>
                            <h4 class="text-xl font-semibold text-slate-700 mb-1 leading-none">{{ $statusData['traité']['order_count'] }}</h4>
                            <p class="text-tiny leading-4">Commandes livrées</p>
                            <div class="badge space-x-1 text-info bg-info/10">
                                <span>13%</span>
                                <i class="fas fa-arrow-up text-xs"></i>
                            </div>
                        </div>
                        <div>
                            <span class="text-lg text-white rounded-full flex items-center justify-center h-12 w-12 shrink-0 bg-success">
                                <i class="fas fa-check-circle text-xl"></i>
                            </span>
                        </div>
                    </div>
                
                    <!-- Carte 4 - Montant des commandes livrées -->
                    <div class="widget-item bg-white p-6 flex justify-between rounded-md">
                        <div>
                            <h4 class="text-xl font-semibold text-slate-700 mb-1 leading-none">{{ number_format($statusData['traité']['total_amount'], 2, ',', ' ') }} DT</h4>
                            <p class="text-tiny leading-4">Montant des commandes livrées</p>
                            <div class="badge space-x-1 text-warning bg-warning/10">
                                <span>10%</span>
                                <i class="fas fa-arrow-up text-xs"></i>
                            </div>
                        </div>
                        <div>
                            <span class="text-lg text-white rounded-full flex items-center justify-center h-12 w-12 shrink-0 bg-primary">
                                <i class="fas fa-truck text-xl"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <!-- card -->
                
                <!-- chart -->
                <div class="chart-main-wrapper mb-6 grid grid-cols-12 gap-6">
                    <div class=" col-span-12 2xl:col-span-7">
                        <div class="chart-single bg-white py-3 px-3 sm:py-10 sm:px-10 h-fit rounded-md">
                            <h3 class="text-xl">Statistiques de ventes</h3>
                            <div class="h-full w-full"><canvas id="salesStatics"></canvas></div>
                            <script>
                                const ventesData = @json($ventesParMois);
                                const produitsData = @json($produitsParMois);
                            </script>
                            
                        </div>
                    </div>
                    
                    <div class="col-span-12 md:col-span-6 2xl:col-span-5 space-y-6">
                        <div class="chart-widget bg-white p-4 sm:p-10 rounded-md">
                            <h3 class="text-xl mb-8">Catégorie la plus vendue</h3>
                            <div class="md:h-[252px] 2xl:h-[398px] w-full"><canvas class="mx-auto md:!w-[240px] md:!h-[240px] 2xl:!w-[360px] 2xl:!h-[360px] " id="earningStatics"></canvas></div>
                            <script>
                                const labelsCategorie = @json($labels);
                                const dataCategorie = @json($data);
                            </script>
                            
                        </div>
                        
                    </div>
                </div>

                <!-- new customers -->
                <div class="grid grid-cols-12 gap-6 mb-6">
                    <div class="bg-white p-8 col-span-12 xl:col-span-4 2xl:col-span-3 rounded-md">
                        <div class="flex items-center justify-between mb-8">
                            <h2 class="font-medium tracking-wide text-slate-700 text-lg mb-0 leading-none">
                                Distribution par sexe 
                            </h2>
                            <a href="transaction.html" class="leading-none text-base text-info border-b border-info border-dotted capitalize font-medium hover:text-info/60 hover:border-info/60"></a>
                        </div>
                        <div class="space-y-5">
                            
                            <table class="w-full text-base text-left text-gray-500">
                                <thead class="bg-white">
                                    <tr class="border-b border-gray6 text-tiny">
                                        
                                        <th scope="col" class="px-3 py-3 text-tiny text-text2 uppercase font-semibold">
                                            Sexe                                        </th>
                                        <th scope="col" class="px-3 py-3 text-tiny text-text2 uppercase font-semibold">
                                            Nombre de personnes
                                        </th>
                                        
                                      
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sexDistribution as $item)
                                    <tr class="bg-white border-b border-gray6 last:border-0 text-start">
                                       
                                        <td class="px-3 py-3 font-normal text-slate-600">
                                            @if($item['sex'] === 'male')
                        Homme
                    @elseif($item['sex'] === 'female')
                        Femme
                    @else
                        Autre
                    @endif
                                        </td>
                                        <td class="px-3 py-3 font-normal text-slate-600">
                                            {{ $item['count'] }}
                                        </td>
                                       
                                                                              
                                    </tr>
                                    @endforeach
             
                                </tbody>
                            </table>
                           
                        </div>
                    </div>

                    <div class="bg-white p-8 col-span-12 xl:col-span-8 2xl:col-span-6 rounded-md">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-medium tracking-wide text-slate-700 text-lg mb-0 leading-none">TOP SKU Vente</h3>
                            <a href="order-list.html" class="leading-none text-base text-info border-b border-info border-dotted capitalize font-medium hover:text-info/60 hover:border-info/60"></a>
                        </div>
                        
                        <!-- table -->
                        <div class="overflow-scroll 2xl:overflow-visible">
                            <div class="w-[700px] 2xl:w-full">
                                <table class="w-full text-base text-left text-gray-500">
                                    <thead class="bg-white">
                                        <tr class="border-b border-gray6 text-tiny">
                                            
                                            <th scope="col" class="px-3 py-3 text-tiny text-text2 uppercase font-semibold">
                                                SKU
                                            </th>
                                            <th scope="col" class="px-3 py-3 text-tiny text-text2 uppercase font-semibold">
                                                Quantité Vendue
                                            </th>
                                            <th scope="col" class="px-3 py-3 text-tiny text-text2 uppercase font-semibold">
                                                CA(DT)
                                            </th>
                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($topSKU as $sku)
                                        <tr class="bg-white border-b border-gray6 last:border-0 text-start">
                                           
                                            <td class="px-3 py-3 font-normal text-slate-600">
                                                {{ $sku->SKU }}
                                            </td>
                                            <td class="px-3 py-3 font-normal text-slate-600">
                                                {{ $sku->total_quantity_sold }}
                                            </td>
                                            <td class="px-3 py-3 font-normal text-slate-600">
                                                {{ number_format($sku->total_revenue, 2, ',', ' ') }} DT                                            </td>
                                            
                                        </tr>
                                        @endforeach
                 
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-8 col-span-12 xl:col-span-12 2xl:col-span-3 rounded-md">
                        <h3 class="font-medium tracking-wide text-slate-700 text-lg mb-7 leading-none">Traffics Source</h3>
                        @php
    // Associer une couleur par source
    $sourceColors = [
        'Facebook' => '#3b5998',
        'YouTube' => '#FF0000',
        'WhatsApp' => '#25D366',
        'Instagram' => '#C13584',
        'Others' => '#737373',
    ];
@endphp

<div class="space-y-4">
    @foreach ($sourceDataPercent as $source => $percent)
        @php
            $color = $sourceColors[$source] ?? '#737373';
        @endphp
        <div class="bar">
            <div class="flex justify-between items-center">
                <h5 class="text-tiny text-slate-700 mb-0">{{ $source }}</h5>
                <span class="text-tiny text-slate-700 mb-0">{{ $percent }}%</span>
            </div>
            <div class="relative h-2 w-full bg-[{{ $color }}/10] rounded">
                <div data-width="{{ $percent }}%" class="data-width absolute top-0 h-full rounded" style="width: {{ $percent }}%; background-color: {{ $color }}"></div>
            </div>
        </div>
    @endforeach
</div>

                    </div>
                </div>


                <div class="grid grid-cols-12 gap-6 mb-6">
                    <div class="bg-white p-8 col-span-12 xl:col-span-4 2xl:col-span-3 rounded-md">
                        <div class="flex items-center justify-between mb-8">
                            <h2 class="font-medium tracking-wide text-slate-700 text-lg mb-0 leading-none">
                                Distribution par âge
                            </h2>
                            <a href="transaction.html" class="leading-none text-base text-info border-b border-info border-dotted capitalize font-medium hover:text-info/60 hover:border-info/60"> </a>
                        </div>
                        <div class="space-y-5">
                        
                        
<ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-700">
    @foreach ($ageDistribution as $ageRange => $count)
    <li class="pb-3 sm:pb-4">
       <div class="flex items-center space-x-4 rtl:space-x-reverse">
          
          <div class="flex-1 min-w-0">
            
             <p class="text-lg text-gray-500 truncate dark:text-gray-400">
                {{ $ageRange }}
             </p>
          </div>
          <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
            {{ $count }} personnes
          </div>
       </div>
    </li>
    @endforeach
 
   
    
 </ul>
 
                            
                            
                           
                        </div>
                    </div>

                    <div class="bg-white p-8 col-span-12 xl:col-span-8 2xl:col-span-6 rounded-md">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-medium tracking-wide text-slate-700 text-lg mb-0 leading-none">Commandes</h3>
                            <a href="order-list.html" class="leading-none text-base text-info border-b border-info border-dotted capitalize font-medium hover:text-info/60 hover:border-info/60"></a>
                        </div>
                        
                        <!-- table -->
                        <div class="overflow-scroll 2xl:overflow-visible">
                            <div class="w-[700px] 2xl:w-full">
                                <table class="w-full text-base text-left text-gray-500">
                                    <thead class="bg-white">
                                        <tr class="border-b border-gray6 text-tiny">
                                            
                                            <th scope="col" class="px-3 py-3 text-tiny text-text2 uppercase font-semibold">
                                                Référence de la commande
                                            </th>
                                            <th scope="col" class="px-3 py-3 text-tiny text-text2 uppercase font-semibold">
                                                Nom du client
                                            </th>
                                            <th scope="col" class="px-3 py-3 text-tiny text-text2 uppercase font-semibold">
                                                CA (DT)
                                            </th>
                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($topOrders as $order)

                                        <tr class="bg-white border-b border-gray6 last:border-0 text-start">
                                           
                                            <td class="px-3 py-3 font-normal text-slate-600">
                                                {{ $order->reference_commande }}
                                            </td>
                                            <td class="px-3 py-3 font-normal text-slate-600">
                                                {{ $order->nom_client }}
                                            </td>
                                            <td class="px-3 py-3 font-normal text-slate-600">
                                                {{ number_format($order->chiffre_affaires, 3, ',', ' ') }} DT DT                                            </td>
                                            
                                        </tr>
                                        @endforeach
                 
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-8 col-span-12 xl:col-span-12 2xl:col-span-3 rounded-md">
                        <h3 class="font-medium tracking-wide text-slate-700 text-lg mb-7 leading-none">Comparaison des Commandes</h3>
                    
                        <div class="space-y-6">
                            @foreach($thisWeekData as $index => $dataPoint)
                                @php
                                    $mois = $dataPoint[0];
                                    $semaineActuelle = $dataPoint[1];
                                    $semaineDerniere = $lastWeekData[$index][1] ?? 0;
                                    $total = max($semaineActuelle, $semaineDerniere, 1); // éviter division par 0
                                    $percentActuelle = round(($semaineActuelle / $total) * 100);
                                    $percentDerniere = round(($semaineDerniere / $total) * 100);
                                @endphp
                    
                                <div>
                                    <h5 class="text-sm font-semibold text-slate-700 mb-2">{{ $mois }}</h5>
                    
                                    <div class="mb-1 flex justify-between">
                                        <span class="text-tiny text-slate-700">Cette Semaine ({{ $semaineActuelle }})</span>
                                        <span class="text-tiny text-slate-700">{{ $percentActuelle }}%</span>
                                    </div>
                                    <div class="relative h-2 w-full bg-blue-100 rounded">
                                        <div class="absolute top-0 left-0 h-full rounded bg-blue-500" style="width: {{ $percentActuelle }}%;"></div>
                                    </div>
                    
                                    <div class="mt-2 mb-1 flex justify-between">
                                        <span class="text-tiny text-slate-700">Semaine Dernière ({{ $semaineDerniere }})</span>
                                        <span class="text-tiny text-slate-700">{{ $percentDerniere }}%</span>
                                    </div>
                                    <div class="relative h-2 w-full bg-red-100 rounded">
                                        <div class="absolute top-0 left-0 h-full rounded bg-red-500" style="width: {{ $percentDerniere }}%;"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                </div>
                



                 



                <div class="chart-main-wrapper mb-6 grid grid-cols-12 gap-6">
                    <div class=" col-span-12 2xl:col-span-7">
                        <div class="chart-single bg-white py-3 px-3 sm:py-10 sm:px-10 h-fit rounded-md">
                            <h3 class="text-xl mb-8"> état de  commande par mois</h3>
                            <table class="w-full text-base text-left text-gray-500">
                                <thead class="bg-white">
                                    <tr class="border-b border-gray6 text-tiny">
                                        
                                        <th scope="col" class="px-3 py-3 text-tiny text-text2 uppercase font-semibold">
                                            Mois
                                        </th>
                                        <th scope="col" class="px-3 py-3 text-tiny text-text2 uppercase font-semibold">
                                            Commandes Totales
                                        </th>
                                        <th scope="col" class="px-3 py-3 text-tiny text-text2 uppercase font-semibold">
                                            En Attente
                                        </th>
                                        <th scope="col" class="px-3 py-3 text-tiny text-text2 uppercase font-semibold">
                                            Livrées
                                        </th>
                                        <th scope="col" class="px-3 py-3 text-tiny text-text2 uppercase font-semibold">
                                            Annulées
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $mois = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];
                                @endphp
                                           @foreach($mois as $i => $moisNom)


                                    <tr class="bg-white border-b border-gray6 last:border-0 text-start {{ $i % 2 === 0 ? 'bg-white' : 'bg-gray-50' }}">
                                       
                                        <td class="px-3 py-3 font-normal text-slate-600">
                                            {{ $moisNom }}
                                        </td>
                                        <td class="px-3 py-3 font-normal text-slate-600">
                                            {{ $monthlyTotalOrders[$i] ?? 0 }}
                                        </td>
                                        <td class="px-3 py-3 font-normal text-slate-600">
                                            {{ $monthlyPendingOrders[$i] ?? 0 }}</td>
                                            <td class="px-3 py-3 font-normal text-slate-600">
                                                {{ $monthlyDeliveredOrders[$i] ?? 0 }}</td>
                                                <td class="px-3 py-3 font-normal text-slate-600">
                                                    {{ $monthlyCanceledOrders[$i] ?? 0 }}</td>
                                    </tr>
                                    @endforeach
             
                                </tbody>
                            </table>
                            
                        </div>
                    </div>
                    
                    <div class="col-span-12 md:col-span-6 2xl:col-span-5 space-y-6">
                        <div class="chart-widget bg-white p-4 sm:p-10 rounded-md">
                            <h3 class="text-xl mb-8">Commande par Mode de paiment </h3>
                            <table class="w-full text-base text-left text-gray-500">
                                <thead class="bg-white">
                                    <tr class="border-b border-gray6 text-tiny">
                                        
                                        <th scope="col" class="px-3 py-3 text-tiny text-text2 uppercase font-semibold">
                                            Mode de Paiement
                                        </th>
                                        <th scope="col" class="px-3 py-3 text-tiny text-text2 uppercase font-semibold">
                                            Nombre de Commandes
                                        </th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                            @foreach($paymentData as $mode => $count)


                                    <tr class="bg-white border-b border-gray6 last:border-0 text-start {{ $i % 2 === 0 ? 'bg-white' : 'bg-gray-50' }}">
                                       
                                        <td class="px-3 py-3 font-normal text-slate-600">
                                            {{ $mode }}
                                        </td>
                                        <td class="px-3 py-3 font-normal text-slate-600">
                                            {{ $count }}
                                        </td>
                                        
                                    </tr>
                                    @endforeach
             
                                </tbody>
                            </table>
                        </div>
                        <div class="chart-widget bg-white p-4 sm:p-10 rounded-md">
                            <h3 class="text-xl mb-8">Commande par Gouvernorat</h3>
                            <table class="w-full text-base text-left text-gray-500">
                                <thead class="bg-white">
                                    <tr class="border-b border-gray6 text-tiny">
                                        
                                        <th scope="col" class="px-3 py-3 text-tiny text-text2 uppercase font-semibold">
                                            Gouvernorat
                                        </th>
                                        <th scope="col" class="px-3 py-3 text-tiny text-text2 uppercase font-semibold">
                                            Nombre de Commandes
                                        </th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                    @foreach($stats as $stat)


                                    <tr class="bg-white border-b border-gray6 last:border-0 text-start {{ $i % 2 === 0 ? 'bg-white' : 'bg-gray-50' }}">
                                       
                                        <td class="px-3 py-3 font-normal text-slate-600">
                                            {{ $stat->gouvernorat }}
                                        </td>
                                        <td class="px-3 py-3 font-normal text-slate-600">
                                            {{ $stat->nombre_commandes }}
                                        </td>
                                        
                                    </tr>
                                    @endforeach
             
                                </tbody>
                            </table>
                        </div>
                        
                        
                    </div>
                        
                    </div>
                    
                </div>
                <!-- table -->
                

            </div>
        </div>
    </div>


    
    @include('dashboard.components.js')
</body>

 






</html>