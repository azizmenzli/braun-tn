<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from html.hixstudio.net/ebazer/order-details.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 19 Apr 2025 11:45:35 GMT -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Braun - Détails de la commande #{{ $red_order }} </title>
    <link rel="shortcut icon" href="assets/img/logo/favicon.png" type="image/x-icon">

    <!-- css links -->
    <link rel="stylesheet" href="{{ asset('assets/css/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/choices.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/apexcharts.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/quill.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/rangeslider.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
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
                        <h3 class="mb-0 text-[28px]">Détails de la commande</h3>
                        <ul class="text-tiny font-medium flex items-center space-x-3 text-text3">
                            <li class="breadcrumb-item text-muted">
                                <a href="" class="text-hover-primary">commandes</a>
                            </li>
                            <li class="breadcrumb-item flex items-center">
                                <span class="inline-block bg-text3/60 w-[4px] h-[4px] rounded-full"></span>
                            </li>
                            <li class="breadcrumb-item text-muted">Détails de la commande #{{ $red_order }}</li>
                        </ul>
                    </div>
                </div>
            
                <!-- table -->
                <div class="">
                    <div class="flex items-center flex-wrap justify-between px-8 mb-6 bg-white rounded-t-md rounded-b-md shadow-xs py-6">
                        <div class="relative">
                            <h5 class="font-normal mb-0">Numéro de commande : #{{ $red_order }}</h5>
                            <p class="mb-0 text-tiny">Commande créée : {{ $orders->first()->date_order }}</p>
                        </div>
                        <div class="flex sm:justify-end flex-wrap sm:space-x-6 mt-5 md:mt-0">
                            <div class="search-select mr-3 flex items-center space-x-3 ">
                                <span class="text-tiny inline-block leading-none -translate-y-[2px]">Changer le statut :{{ $orders->first()->status }} </span>
                               
                            </div>
                            <div class="product-add-btn flex ">
                                <a href="#" class="tp-btn">Sauvegarder</a>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 2xl:grid-cols-3 gap-6 mb-6">
                        <div class="bg-white rounded-t-md rounded-b-md shadow-xs px-8 py-8">
                            <h5>Détails du client</h5>
            
                            <div class="relative overflow-x-auto ">
                                <table class="w-[400px] sm:w-full text-base text-left text-gray-500">
                                    <tbody>
                                        <tr class="bg-white border-b border-gray6 last:border-0 text-start mx-9">
                                            <td class="py-3 font-normal text-[#55585B] w-[50%]">
                                                Nom et  prenom
                                            </td>
                                            <td class="py-3 whitespace-nowrap ">
                                                <div class="flex items-center justify-end space-x-5 text-end text-heading text-hover-primary">
                                                    <span class="font-medium">{{ $orders->first()->prenom }} {{ $orders->first()->nom }}</span>
                                                </div>
                                            </td>                                            
                                        </tr>                                                           
                                        <tr class="bg-white border-b border-gray6 last:border-0 text-start mx-9">
                                            <td class="py-3 font-normal text-[#55585B] w-[50%]">
                                                Email
                                            </td>
                                            <td class="py-3 text-end">
                                                <a href="mailto:{{ $orders->first()->email }}">{{ $orders->first()->email }}</a>
                                            </td>                                            
                                        </tr>                                                           
                                        <tr class="bg-white border-b border-gray6 last:border-0 text-start mx-9">
                                            <td class="py-3 font-normal text-[#55585B] w-[50%]">
                                                Télephone
                                            </td>
                                            <td class="py-3 text-end">
                                                <a href="tel:{{ $orders->first()->telephone }}">{{ $orders->first()->telephone }}</a>
                                            </td>  
                                                                                      
                                        </tr>  
                                         
                                                                                             
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="bg-white rounded-t-md rounded-b-md shadow-xs px-8 py-8">
                            <h5>Récapitulatif de la commande</h5>
            
                            <div class="relative overflow-x-auto ">
                                <table class="w-[400px] sm:w-full text-base text-left text-gray-500">
                                    <tbody>
                                        <tr class="bg-white border-b border-gray6 last:border-0 text-start mx-9">
                                            <td class="py-3 font-normal text-[#55585B] w-[50%]">
                                                Date de commande
                                            </td>
                                            <td class="py-3 whitespace-nowrap text-end">
                                                {{ $orders->first()->date_order }}
                                            </td>                                            
                                        </tr>                                                           
                                        <tr class="bg-white border-b border-gray6 last:border-0 text-start mx-9">
                                            <td class="py-3 font-normal text-[#55585B] w-[50%]">
                                                Date de commande
                                            </td>
                                            <td class="py-3 text-end">
                                                {{ $orders->first()->mode_paiement }}
                                                
                                            </td>                                            
                                        </tr>                                                           
                                        <tr class="bg-white border-b border-gray6 last:border-0 text-start mx-9">
                                            <td class="py-3 font-normal text-[#55585B] w-[50%]">
                                                Status
                                            </td>
                                            <td class="py-3 text-end">
                                                {{ $orders->first()->status }}
                                            </td>                                            
                                        </tr>                                                           
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="bg-white rounded-t-md rounded-b-md shadow-xs px-8 py-8">
                            <h5>Livrer à</h5>
            
                            <div class="relative overflow-x-auto ">
                                <table class="w-[400px] sm:w-full text-base text-left text-gray-500">
                                    <tbody>
                                        <tr class="bg-white border-b border-gray6 last:border-0 text-start mx-9">
                                            <td class="py-3 font-normal text-[#55585B] w-[40%]">
                                                Address
                                            </td>
                                            <td class="py-3 text-end">
                                                {{ $orders->first()->adress }}
                                            </td>                                            
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-12 gap-6">
                        <div class="col-span-12 2xl:col-span-8">
                            <div class="bg-white rounded-t-md rounded-b-md shadow-xs py-8">
                                <div class="relative overflow-x-auto mx-8">
                                    <table class="w-[975px] md:w-full text-base text-left text-gray-500">
                                        <thead class="bg-white">
                                            <tr class="border-b border-gray6 text-tiny">
                                                <th scope="col" class="pr-8 py-3 text-tiny text-text2 uppercase font-semibold">
                                                    Produits 
                                                </th>
                                                <th scope="col" class="px-3 py-3 text-tiny text-text2 uppercase font-semibold w-[170px] text-end">
                                                    Prix ​​unitaire
                                                </th>
                                                <th scope="col" class="px-3 py-3 text-tiny text-text2 uppercase font-semibold w-[170px] text-end">
                                                    Quantité
                                                </th>
                                                <th scope="col" class="px-3 py-3 text-tiny text-text2 uppercase font-semibold w-[170px] text-end">
                                                    Total
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orders as $order)
                                            <tr class="bg-white border-b border-gray6 last:border-0 text-start mx-9">
                                                <td class="pr-8 py-5 whitespace-nowrap">
                                                    <a href="#" class="flex items-center space-x-5">
                                                        @if(isset($order->product_image))
                                                        <img class="w-[40px] h-[40px] rounded-md" src="{{ asset('storage/'.$order->product_image) }}" alt="{{ $order->product_name }}">
                                                        @else
                                                        <img class="w-[40px] h-[40px] rounded-md" src="{{ asset('assets/img/product/default-product.jpg') }}" alt="Default product image">
                                                        @endif
                                                        <span class="font-medium text-heading text-hover-primary transition">{{ $order->product_name }}</span>
                                                    </a>
                                                </td>
                                                <td class="px-3 py-3 font-normal text-[#55585B] text-end">
                                                     {{ number_format($order->prix_produit, 2) }} DT
                                                </td>
                                                <td class="px-3 py-3 font-normal text-[#55585B] text-end">
                                                    {{ $order->quantite_produit }}
                                                </td>
                                                <td class="px-3 py-3 font-normal text-[#55585B] text-end">
                                                    {{ number_format($order->subtotal, 2) }} DT
                                                </td>
                                            </tr>
                                            @endforeach                                         
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 2xl:col-span-4">
                            <div class="bg-white rounded-t-md rounded-b-md shadow-xs py-8 px-8">
                                <h5>Prix ​​de la commande</h5>
                                <div class="relative overflow-x-auto">
                                    <table class="w-full text-base text-left text-gray-500">
                                        <tbody>
                                            <tr class="bg-white border-b border-gray6 last:border-0 text-start mx-9">
                                                <td class="pr-3 py-3 pt-6 font-normal text-[#55585B] text-start">
                                                    Subtotal
                                                </td>
                                                <td class="px-3 py-3 pt-6 font-normal text-[#55585B] text-end">
                                                    ${{ number_format($totalSubtotal, 2) }}
                                                </td>
                                            </tr>                                          
                                            <tr class="bg-white border-b border-gray6 last:border-0 text-start mx-9">
                                                <td class="pr-3 py-3 font-normal text-[#55585B] text-start">
                                                    Frais d'expédition :
                                                </td>
                                                <td class="px-3 py-3 font-normal text-[#55585B] text-end">
                                                     {{ number_format($frais_livraison, 2) }}DT
                                                </td>
                                            </tr>
                                            <tr class="bg-white border-b border-gray6 last:border-0 text-start mx-9">
                                                <td class="pr-3 py-3 font-normal text-[#55585B] text-start">
                                                    Timber fiscal :
                                                </td>
                                                <td class="px-3 py-3 font-normal text-[#55585B] text-end">
                                                     {{ number_format($frais_fiscal, 2) }} DT
                                                </td>
                                            </tr>                                          
                                            <tr class="bg-white border-b border-gray6 last:border-0 text-start mx-9">
                                                <td class="pr-3 py-3 font-normal text-[#55585B] text-start">
                                                    Total:
                                                </td>
                                                <td class="px-3 py-3 text-[#55585B] text-end text-lg font-semibold">
                                                     {{ number_format($grandTotal, 2) }} DT
                                                </td>
                                            </tr>                                          
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    @include('dashboard.components.js')

    
</body>

<!-- Mirrored from html.hixstudio.net/ebazer/order-details.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 19 Apr 2025 11:45:35 GMT -->
</html>