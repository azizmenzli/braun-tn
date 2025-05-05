<!DOCTYPE html>
<html lang="fr">

 <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BRaun-Traffic</title>
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
    
</head>
<body>
    @include('dashboard.components.sideleft')

       
    <div class="tp-main-wrapper bg-slate-100 h-screen" x-data="{ sideMenu: false }">
         

        <div class="fixed top-0 left-0 w-full h-full z-40 bg-black/70 transition-all duration-300" :class="sideMenu ? 'visible opacity-1' : '  invisible opacity-0 '" x-on:click="sideMenu = ! sideMenu"> </div>

        <div class="tp-main-content lg:ml-[250px] xl:ml-[300px] w-[calc(100% - 300px)]"  x-data="{ searchOverlay: false }">
            @include('dashboard.components.header')

           
            <div class="body-content px-8 py-8 ">
                <div class="flex justify-between mb-10">
                    <div class="page-title">
                        <h3 class="mb-0 text-[28px]">Traffic</h3>
                    </div>
                </div>
                <div class="p-6 space-y-8">
                    <!-- Statistiques de base -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white rounded-xl p-6 text-center transition-transform hover:scale-105">
                            <div class="flex items-center justify-center mb-4 text-blue-600 text-4xl">
                                <i class="fas fa-users"></i>
                            </div>
                            <h2 class="text-lg font-semibold text-gray-700 mb-2">Visiteurs aujourd'hui</h2>
                            <p class="text-4xl text-blue-600 font-bold">{{ $todayVisitors }}</p>
                            <div class="mt-3 text-sm text-gray-500 flex items-center justify-center">
                                <i class="fas fa-calendar-day mr-1"></i> {{ now()->format('d M Y') }}
                            </div>
                        </div>
                        
                        <div class="bg-white rounded-xl shadow-lg p-6 text-center transition-transform hover:scale-105">
                            <div class="flex items-center justify-center mb-4 text-green-600 text-4xl">
                                <i class="fas fa-user-clock"></i>
                            </div>
                            <h2 class="text-lg font-semibold text-gray-700 mb-2">Visiteurs hier</h2>
                            <p class="text-4xl text-green-600 font-bold">{{ $yesterdayVisitors }}</p>
                            <div class="mt-3 text-sm text-gray-500 flex items-center justify-center">
                                <i class="fas fa-calendar-minus mr-1"></i> {{ now()->subDay()->format('d M Y') }}
                            </div>
                        </div>
                        
                        <div class="bg-white rounded-xl shadow-lg p-6 text-center transition-transform hover:scale-105">
                            <div class="flex items-center justify-center mb-4 text-red-600 text-4xl">
                                <i class="fas fa-user-check"></i>
                            </div>
                            <h2 class="text-lg font-semibold text-gray-700 mb-2">Visiteurs en ligne</h2>
                            <p class="text-4xl text-red-600 font-bold">{{ $onlineVisitors }}</p>
                            <div class="mt-3 text-sm text-gray-500 flex items-center justify-center">
                                <i class="fas fa-clock mr-1"></i> Dernières 5 minutes
                            </div>
                        </div>
                    </div>
                
                    <!-- Pages les plus visitées -->
                    <div class="bg-white rounded-xl shadow-lg p-6 transition-transform hover:scale-[1.005]">
                        <h2 class="text-xl font-bold mb-6 flex items-center gap-3 text-indigo-700">
                            <i class="fas fa-chart-line text-indigo-500 p-2 bg-indigo-100 rounded-full"></i>
                            Top 10 des pages visitées
                        </h2>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <i class="fas fa-file-alt mr-2"></i>Page
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <i class="fas fa-eye mr-2"></i>Visites
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($mostVisitedPages as $page)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <i class="fas fa-link text-gray-400 mr-3"></i>
                                                <div class="text-sm font-medium text-gray-900">{{ $page->visited_page }}</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 flex items-center">
                                                <i class="fas fa-chart-bar text-blue-400 mr-2"></i>
                                                {{ $page->visits }}
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                
                    <!-- Systèmes d'exploitation -->
                    <div class="bg-white rounded-xl shadow-lg p-6 transition-transform hover:scale-[1.005]">
                        <h2 class="text-xl font-bold mb-6 flex items-center gap-3 text-purple-700">
                            <i class="fas fa-desktop text-purple-500 p-2 bg-purple-100 rounded-full"></i>
                            Systèmes d'exploitation les plus utilisés
                        </h2>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <i class="fas fa-laptop-code mr-2"></i>Système
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <i class="fas fa-users mr-2"></i>Utilisateurs
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($topOS as $os)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @if(str_contains(strtolower($os->os ?? ''), 'windows'))
                                                    <i class="fab fa-windows text-blue-500 mr-3"></i>
                                                @elseif(str_contains(strtolower($os->os ?? ''), 'mac'))
                                                    <i class="fab fa-apple text-gray-700 mr-3"></i>
                                                @elseif(str_contains(strtolower($os->os ?? ''), 'linux'))
                                                    <i class="fab fa-linux text-orange-500 mr-3"></i>
                                                @elseif(str_contains(strtolower($os->os ?? ''), 'android'))
                                                    <i class="fab fa-android text-green-500 mr-3"></i>
                                                @elseif(str_contains(strtolower($os->os ?? ''), 'ios'))
                                                    <i class="fab fa-apple text-gray-500 mr-3"></i>
                                                @else
                                                    <i class="fas fa-question-circle text-gray-400 mr-3"></i>
                                                @endif
                                                <div class="text-sm font-medium text-gray-900">{{ $os->os ?? 'Inconnu' }}</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 flex items-center">
                                                <i class="fas fa-user text-purple-400 mr-2"></i>
                                                {{ $os->count }}
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                 <!-- content here -->
            </div>
        </div>
    </div>

    @include('dashboard.components.js')
 
     
    
</body>

 </html>