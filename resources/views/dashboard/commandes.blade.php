<!DOCTYPE html>
<html lang="en">

 <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Braun - Commandes</title>
    <link rel="shortcut icon" href="assets/img/logo/favicon.png" type="image/x-icon">

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
                                <a href="product-list.html" class="text-hover-primary"> Accueil</a>
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
                    <div class="tp-search-box flex items-center justify-between px-8 py-8 flex-wrap">
                        <div class="search-input relative">
                            <input class="input h-[44px] w-full pl-14" type="text" placeholder="Rechercher par identifiant de commande">
                            <button class="absolute top-1/2 left-5 translate-y-[-50%] hover:text-theme">
                                <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 17C13.4183 17 17 13.4183 17 9C17 4.58172 13.4183 1 9 1C4.58172 1 1 4.58172 1 9C1 13.4183 4.58172 17 9 17Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M18.9999 19L14.6499 14.65" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="flex justify-end space-x-6">
                            <div class="search-select mr-3 flex items-center space-x-3 ">
                                
                            </div>
                        </div>
                    </div>
                    <div class="relative overflow-x-auto  mx-8">
                        <table class="w-[1500px] 2xl:w-full text-base text-left text-gray-500">
                            <thead class="bg-white">
                                <tr class="border-b border-gray6 text-tiny">
                                    
                                    <th class="py-3 uppercase font-semibold">#REF</th>
                                    <th class="py-3 uppercase font-semibold">Date de commande</th>
                                     <th class="py-3 uppercase font-semibold">Client</th>
                                     <th class="py-3 uppercase font-semibold">Gouvernorat </th>
                                    <th class="py-3 uppercase font-semibold">Adresse</th>
                                    <th class="py-3 uppercase font-semibold">Montant Total</th>
                                    <th class="py-3 uppercase font-semibold">Statut</th>
                                    <th class="py-3 uppercase font-semibold">Modifier Statut</th>
                                    <th class="py-3 uppercase font-semibold">Détails de commande</th>
                                    <th class="py-3 uppercase font-semibold text-end">Action</th>
                                    <th class="py-3 uppercase font-semibold text-end">Invoice</th>
                                </tr>
                            </thead>
                        
                            <tbody>


                                @foreach($groupedOrders as $red_order => $ordersGroup)

                                <tr class="bg-white border-b border-gray6 last:border-0 text-start">
                                   
                                    <td class="px-3 py-3">#{{ $red_order }}</td>
                                    <td class="px-3 py-3">{{ \Carbon\Carbon::parse($ordersGroup[0]->date_order)->format('d, M, Y \à H\hi') }}</td>
                                    <td class="px-3 py-3">
                                        <a href="#" class="flex items-center space-x-5 text-hover-primary text-heading">
                                             <span class="font-medium">{{ $ordersGroup[0]->nom }} {{ $ordersGroup[0]->prenom }}</span>
                                        </a>
                                    </td>
                                   
                                    <td class="px-3 py-3">{{ $ordersGroup[0]->gouvernorat }}</td>

                                    <td class="px-3 py-3">{{ $ordersGroup[0]->adress }}</td>
                                    <td class="px-3 py-3">{{ $ordersGroup->sum('total') }} DT</td>
                                    <td class="px-3 py-3">
                                        @if($ordersGroup[0]->status === 'pending')
                                            <span class="inline-block px-2 py-1 text-sm font-medium text-yellow-800 bg-yellow-100 rounded">
                                                En attente
                                            </span>
                                        @elseif($ordersGroup[0]->status === 'delivered')
                                            <span class="inline-block px-2 py-1 text-sm font-medium text-green-800 bg-green-100 rounded">
                                                Envoyée
                                            </span>
                                        @elseif($ordersGroup[0]->status === 'canceled')
                                            <span class="inline-block px-2 py-1 text-sm font-medium text-red-800 bg-red-100 rounded">
                                                Annulée
                                            </span>
                                        @else
                                            <span class="inline-block px-2 py-1 text-sm font-medium text-gray-800 bg-gray-100 rounded">
                                                {{ $ordersGroup[0]->status }}
                                            </span>
                                        @endif
                                    </td>
                                    
                                    <td class="px-3 py-3">
                                        <form action="{{ route('admin.updateStatusOrder', $ordersGroup[0]->red_order) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-4">
                                                 <select name="status" id="status" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                                    <option value="encours" {{ $ordersGroup[0]->status == 'encours' ? 'selected' : '' }}>En attente</option>
                                                    <option value="traité" {{ $ordersGroup[0]->status == 'traité' ? 'selected' : '' }}>Envoyée</option>
                                                    <option value="annulé" {{ $ordersGroup[0]->status == 'annulé' ? 'selected' : '' }}>Annulée</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 text-sm">
                                                Mettre à jour
                                            </button>
                                        </form>
                                        
                
                                                    </td>
                                    
                                    <td class="px-9 py-3 text-end">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('commandes.show', $red_order) }}" class="px-3 h-10 bg-success text-white rounded-md hover:bg-green-600" target="_blanks">View</a>
                                        </div>
                                    </td>
                                    <td class="px-9 py-3 text-end">
                                        <div class="flex justify-end space-x-2">
                                            <button class="px-3 h-10 bg-gray text-black rounded-md hover:bg-theme hover:text-white">
                                                <svg class="-translate-y-px" width="16" height="16" viewBox="0 0 32 32">
                                                    <path fill="currentColor" d="..."></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                    </div>
                    <div class="flex justify-between items-center flex-wrap mx-8">
                        <p class="mb-0 text-tiny">Showing 10 items of 120</p>
                        <div class="pagination py-3 flex justify-end items-center sm:mx-8">
                            <a href="#" class="inline-block rounded-md w-10 h-10 text-center leading-[33px] border border-gray mr-2 last:mr-0 hover:bg-theme hover:text-white hover:border-theme">
                                <svg class="-translate-y-[2px] -translate-x-px" width="12" height="12" viewBox="0 0 12 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.9209 1.50495C11.9206 1.90264 11.7623 2.28392 11.4809 2.56495L3.80895 10.237C3.57673 10.4691 3.39252 10.7447 3.26684 11.0481C3.14117 11.3515 3.07648 11.6766 3.07648 12.005C3.07648 12.3333 3.14117 12.6585 3.26684 12.9618C3.39252 13.2652 3.57673 13.5408 3.80895 13.773L11.4709 21.435C11.7442 21.7179 11.8954 22.0968 11.892 22.4901C11.8885 22.8834 11.7308 23.2596 11.4527 23.5377C11.1746 23.8158 10.7983 23.9735 10.405 23.977C10.0118 23.9804 9.63285 23.8292 9.34995 23.556L1.68795 15.9C0.657711 14.8677 0.0791016 13.4689 0.0791016 12.0105C0.0791016 10.552 0.657711 9.15322 1.68795 8.12095L9.35995 0.443953C9.56973 0.234037 9.83706 0.0910666 10.1281 0.0331324C10.4192 -0.0248017 10.7209 0.00490445 10.9951 0.118492C11.2692 0.232079 11.5036 0.424443 11.6684 0.671242C11.8332 0.918041 11.9211 1.20818 11.9209 1.50495Z" fill="currentColor"/>
                                </svg>  
                            </a>
                            <a href="#" class="inline-block rounded-md w-10 h-10 text-center leading-[33px] border border-gray mr-2 last:mr-0 hover:bg-theme hover:text-white hover:border-theme">2</a>
                            <a href="#" class="inline-block rounded-md w-10 h-10 text-center leading-[33px] border mr-2 last:mr-0 text-white bg-theme border-theme hover:bg-theme hover:text-white hover:border-theme">3</a>
                            <a href="#" class="inline-block rounded-md w-10 h-10 text-center leading-[33px] border border-gray mr-2 last:mr-0 hover:bg-theme hover:text-white hover:border-theme">4</a>
                            <a href="#" class="inline-block rounded-md w-10 h-10 text-center leading-[33px] border border-gray mr-2 last:mr-0 hover:bg-theme hover:text-white hover:border-theme">
                                <svg class="-translate-y-px" width="12" height="12" viewBox="0 0 12 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0.0790405 22.5C0.0793906 22.1023 0.237656 21.7211 0.519041 21.44L8.19104 13.768C8.42326 13.5359 8.60747 13.2602 8.73314 12.9569C8.85882 12.6535 8.92351 12.3284 8.92351 12C8.92351 11.6717 8.85882 11.3465 8.73314 11.0432C8.60747 10.7398 8.42326 10.4642 8.19104 10.232L0.52904 2.56502C0.255803 2.28211 0.104612 1.90321 0.108029 1.50992C0.111447 1.11662 0.269201 0.740401 0.547313 0.462289C0.825425 0.184177 1.20164 0.0264236 1.59494 0.0230059C1.98823 0.0195883 2.36714 0.17078 2.65004 0.444017L10.312 8.10502C11.3423 9.13728 11.9209 10.5361 11.9209 11.9945C11.9209 13.4529 11.3423 14.8518 10.312 15.884L2.64004 23.556C2.43056 23.7656 2.16368 23.9085 1.87309 23.9666C1.58249 24.0247 1.2812 23.9954 1.00723 23.8824C0.733259 23.7695 0.498891 23.5779 0.333699 23.3319C0.168506 23.0858 0.0798928 22.7964 0.0790405 22.5Z" fill="currentColor"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('dashboard.components.js')

    
</body>

 </html>