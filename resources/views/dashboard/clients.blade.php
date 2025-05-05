<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from html.hixstudio.net/ebazer/customer-list.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 19 Apr 2025 11:45:34 GMT -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listes de clients</title>
    <link rel="shortcut icon" href="assets/img/logo/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="assets/img/logo/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/choices.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/apexcharts.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/quill.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/rangeslider.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
 
    <!-- css links -->
    @include('dashboard.components.style')

</head>
<body>

    <!--  -->
    <div class="tp-main-wrapper bg-slate-100 h-screen" x-data="{ sideMenu: false }">
        @include('dashboard.components.sideleft')

        <div class="fixed top-0 left-0 w-full h-full z-40 bg-black/70 transition-all duration-300" :class="sideMenu ? 'visible opacity-1' : '  invisible opacity-0 '" x-on:click="sideMenu = ! sideMenu"> </div>

        <div class="tp-main-content lg:ml-[250px] xl:ml-[300px] w-[calc(100% - 300px)]" x-data="{ searchOverlay: false }">
            @include('dashboard.components.header')
        
            <div class="body-content px-8 py-8 bg-slate-100">
                <div class="flex justify-between mb-10">
                    <div class="page-title">
                        <h3 class="mb-0 text-[28px]">Clients</h3>
                        <ul class="text-tiny font-medium flex items-center space-x-3 text-text3">
                            <li class="breadcrumb-item text-muted">
                                <a href=" " class="text-hover-primary">Accueil</a>
                            </li>
                            <li class="breadcrumb-item flex items-center">
                                <span class="inline-block bg-text3/60 w-[4px] h-[4px] rounded-full"></span>
                            </li>
                            <li class="breadcrumb-item text-muted">Liste des clients</li>
                        </ul>
                    </div>
                </div>
        
                <!-- table -->
                <div class="bg-white rounded-t-md rounded-b-md shadow-xs py-4">
                    <div class="tp-search-box flex items-center justify-between px-8 py-8">
                        <div class="search-input relative">
                            <input class="input h-[44px] w-full pl-14" type="text" placeholder="Rechercher par nom de client">
                            <button class="absolute top-1/2 left-5 translate-y-[-50%] hover:text-theme">
                                <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 17C13.4183 17 17 13.4183 17 9C17 4.58172 13.4183 1 9 1C4.58172 1 1 4.58172 1 9C1 13.4183 4.58172 17 9 17Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M18.9999 19L14.6499 14.65" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="flex justify-end space-x-6">
                            <div class="search-select mr-3 flex items-center space-x-3 ">
                                <span class="text-tiny inline-block leading-none -translate-y-[2px]">Trier par : </span>
                                <select>
                                    <option>Commandes (décroissant)</option>
                                    <option>Commandes (croissant)</option>
                                    <option>Date récente</option>
                                    <option>Date ancienne</option>
                                </select>
                            </div>
                            <div class="product-add-btn flex ">
                                <a href="#" class="tp-btn bg-info/10 text-info hover:text-white hover:bg-theme">
                                    <span class="mr-2">
                                        <svg width="15" height="15" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 512.056 512.056">
                                            <path fill="currentColor" d="M426.635,188.224C402.969,93.946,307.358,36.704,213.08,60.37C139.404,78.865,85.907,142.542,80.395,218.303 C28.082,226.93-7.333,276.331,1.294,328.644c7.669,46.507,47.967,80.566,95.101,80.379h80v-32h-80c-35.346,0-64-28.654-64-64 c0-35.346,28.654-64,64-64c8.837,0,16-7.163,16-16c-0.08-79.529,64.327-144.065,143.856-144.144 c68.844-0.069,128.107,48.601,141.424,116.144c1.315,6.744,6.788,11.896,13.6,12.8c43.742,6.229,74.151,46.738,67.923,90.479 c-5.593,39.278-39.129,68.523-78.803,68.721h-64v32h64c61.856-0.187,111.848-50.483,111.66-112.339 C511.899,245.194,476.655,200.443,426.635,188.224z"/>
                                            <path fill="currentColor" d="M245.035,253.664l-64,64l22.56,22.56l36.8-36.64v153.44h32v-153.44l36.64,36.64l22.56-22.56l-64-64 C261.354,247.46,251.276,247.46,245.035,253.664z"/>
                                        </svg>
                                    </span>   
                                    Exporter
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="relative overflow-x-auto mx-8">
                        <table class="w-full text-base text-left text-gray-500">
                            <thead class="bg-white">
                                <tr class="border-b border-gray6 text-tiny">
                                    <th scope="col" class="py-3 text-tiny text-text2 uppercase font-semibold w-[3%]">
                                        <div class="tp-checkbox -translate-y-[3px]">
                                            <input id="selectAllProduct" type="checkbox">
                                            <label for="selectAllProduct"></label>
                                        </div>
                                    </th>
                                    <th scope="col" class="pr-8 py-3 text-tiny text-text2 uppercase font-semibold">
                                        Client
                                    </th>
                                    <th scope="col" class="px-3 py-3 text-tiny text-text2 uppercase font-semibold text-end">
                                        Email
                                    </th>
                                    <th scope="col" class="px-3 py-3 text-tiny text-text2 uppercase font-semibold text-end">
                                        Téléphone
                                    </th>
                                    <th scope="col" class="px-3 py-3 text-tiny text-text2 uppercase font-semibold w-[200px] text-end">
                                        Commandes
                                    </th>
                                    <th scope="col" class="px-3 py-3 text-tiny text-text2 uppercase font-semibold w-[250px] text-end">
                                        Dernière commande
                                    </th>
                                    <th scope="col" class="px-9 py-3 text-tiny text-text2 uppercase font-semibold w-[12%] text-end">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($clients as $client)
                                <tr class="bg-white border-b border-gray6 last:border-0 text-start mx-9">
                                    <td class="pr-3 whitespace-nowrap">
                                        <div class="tp-checkbox">
                                            <input id="client-{{ $loop->index }}" type="checkbox">
                                            <label for="client-{{ $loop->index }}"></label>
                                        </div>
                                    </td>
                                    <td class="pr-8 py-5 whitespace-nowrap">
                                        <div class="flex items-center space-x-5 text-heading">
                                            <div class="w-[40px] h-[40px] rounded-full bg-gray-100 flex items-center justify-center">
                                                <span class="text-lg font-medium">{{ substr($client->prenom, 0, 1) }}{{ substr($client->nom, 0, 1) }}</span>
                                            </div>
                                            <span class="font-medium">{{ $client->prenom }} {{ $client->nom }}</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 text-end">
                                        {{ $client->email }}
                                    </td>
                                    <td class="px-3 py-3 text-end">
                                        {{ $client->telephone }}
                                    </td>
                                    <td class="px-3 py-3 text-end">
                                        <span class="text-[11px] text-info px-3 py-1 rounded-md leading-none bg-info/10 font-medium">
                                            {{ $client->nombre_commandes }} commande(s)
                                        </span>
                                    </td>
                                    <td class="px-3 py-3 font-normal text-[#55585B] text-end">
                                        {{ \Carbon\Carbon::parse($client->derniere_commande)->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-9 py-3 text-end">
                                        <div class="flex items-center justify-end space-x-2">
                                            <div class="relative" x-data="{ editTooltip: false }">
  
                                                <a href="{{ route('commandes.client', ['email' => $client->email]) }}" 
                                                   class="w-10 h-10 leading-10 text-tiny bg-success text-white rounded-md hover:bg-green-600"
                                                   x-on:mouseenter="editTooltip = true" x-on:mouseleave="editTooltip = false">
                                                    <svg class="-translate-y-px" height="12" viewBox="0 0 512 512" width="12" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill="currentColor" d="M496 384H64V80c0-8.84-7.16-16-16-16H16C7.16 64 0 71.16 0 80v336c0 17.67 14.33 32 32 32h464c8.84 0 16-7.16 16-16v-32c0-8.84-7.16-16-16-16zM464 96H345.94c-1.79 0-3.57-.59-5.03-1.69L297.69 50.34c-1.66-1.11-3.68-1.69-5.69-1.69H112c-8.84 0-16 7.16-16 16v288h384V112c0-8.84-7.16-16-16-16z"/>
                                                    </svg>
                                                </a>
                                                <div x-show="editTooltip" class="flex flex-col items-center z-50 absolute left-1/2 -translate-x-1/2 bottom-full mb-1">
                                                    <span class="relative z-10 p-2 text-tiny leading-none font-medium text-white whitespace-no-wrap w-max bg-slate-800 rounded py-1 px-2 inline-block">Voir commandes</span>
                                                    <div class="w-3 h-3 -mt-2 rotate-45 bg-black"></div>
                                                </div>
                                            </div>
                                            <div class="relative" x-data="{ deleteTooltip: false }">
                                                <button 
                                                    class="w-10 h-10 leading-[33px] text-tiny bg-white border border-gray text-slate-600 rounded-md hover:bg-danger hover:border-danger hover:text-white"
                                                    x-on:mouseenter="deleteTooltip = true" x-on:mouseleave="deleteTooltip = false">
                                                    <svg class="-translate-y-px" width="13" height="13" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M19.0697 4.23C17.4597 4.07 15.8497 3.95 14.2297 3.86V3.85L14.0097 2.55C13.8597 1.63 13.6397 0.25 11.2997 0.25H8.67967C6.34967 0.25 6.12967 1.57 5.96967 2.54L5.75967 3.82C4.82967 3.88 3.89967 3.94 2.96967 4.03L0.929669 4.23C0.509669 4.27 0.209669 4.64 0.249669 5.05C0.289669 5.46 0.649669 5.76 1.06967 5.72L3.10967 5.52C8.34967 5 13.6297 5.2 18.9297 5.73C18.9597 5.73 18.9797 5.73 19.0097 5.73C19.3897 5.73 19.7197 5.44 19.7597 5.05C19.7897 4.64 19.4897 4.27 19.0697 4.23Z" fill="currentColor"/>
                                                        <path d="M17.2297 7.14C16.9897 6.89 16.6597 6.75 16.3197 6.75H3.67975C3.33975 6.75 2.99975 6.89 2.76975 7.14C2.53975 7.39 2.40975 7.73 2.42975 8.08L3.04975 18.34C3.15975 19.86 3.29975 21.76 6.78975 21.76H13.2097C16.6997 21.76 16.8398 19.87 16.9497 18.34L17.5697 8.09C17.5897 7.73 17.4597 7.39 17.2297 7.14ZM11.6597 16.75H8.32975C7.91975 16.75 7.57975 16.41 7.57975 16C7.57975 15.59 7.91975 15.25 8.32975 15.25H11.6597C12.0697 15.25 12.4097 15.59 12.4097 16C12.4097 16.41 12.0697 16.75 11.6597 16.75ZM12.4997 12.75H7.49975C7.08975 12.75 6.74975 12.41 6.74975 12C6.74975 11.59 7.08975 11.25 7.49975 11.25H12.4997C12.9097 11.25 13.2497 11.59 13.2497 12C13.2497 12.41 12.9097 12.75 12.4997 12.75Z" fill="currentColor"/>
                                                    </svg>
                                                </button>
                                                <div x-show="deleteTooltip" class="flex flex-col items-center z-50 absolute left-1/2 -translate-x-1/2 bottom-full mb-1">
                                                    <span class="relative z-10 p-2 text-tiny leading-none font-medium text-white whitespace-no-wrap w-max bg-slate-800 rounded py-1 px-2 inline-block">Supprimer</span>
                                                    <div class="w-3 h-3 -mt-2 rotate-45 bg-black"></div>
                                                </div>
                                            </div>
                                        </div>  
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="flex justify-between items-center flex-wrap mx-8">
                        <p class="mb-0 text-tiny">Affichage de {{ $clients->count() }} clients</p>
                        <div class="pagination py-3 flex justify-end items-center mx-8">
                            <!-- Pagination links would go here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    @include('dashboard.components.js')

    
</body>

<!-- Mirrored from html.hixstudio.net/ebazer/customer-list.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 19 Apr 2025 11:45:35 GMT -->
</html>