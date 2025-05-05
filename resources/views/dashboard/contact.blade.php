<!DOCTYPE html>
<html lang="en">

 <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Braun Tunisie -lsite de Contact</title>
    <link rel="shortcut icon" href="assets/img/logo/favicon.png" type="image/x-icon">

    <!-- css links -->
    @include('dashboard.components.style')

</head>
<body>

    <div class="tp-main-wrapper bg-slate-100 h-screen" x-data="{ sideMenu: false }">
        @include('dashboard.components.sideleft')


        <div class="fixed top-0 left-0 w-full h-full z-40 bg-black/70 transition-all duration-300" :class="sideMenu ? 'visible opacity-1' : '  invisible opacity-0 '" x-on:click="sideMenu = ! sideMenu"> </div>

        <div class="tp-main-content lg:ml-[250px] xl:ml-[300px] w-[calc(100% - 300px)]"  x-data="{ searchOverlay: false }">

            @include('dashboard.components.style')


            <div class="body-content px-8 py-8 ">
                <div class="flex justify-between mb-10">
                    <div class="page-title">
                        <h3 class="mb-0 text-[28px]">Contact</h3>
                    </div>
                </div>
                 
               

            <div class="flex justify-between mb-10">
                <div class="page-title">
                    <h3 class="mb-0 text-[28px]">Contact</h3>
                    <ul class="text-tiny font-medium flex items-center space-x-3 text-text3">
                        <li class="breadcrumb-item text-muted">
                            <a href="product-list.html" class="text-hover-primary">  </a>
                        </li>
                        <li class="breadcrumb-item flex items-center">
                            <span class="inline-block bg-text3/60 w-[4px] h-[4px] rounded-full"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Contact</li>
                                       
                    </ul>
                </div>
            </div>

            <!-- table -->
            <div class="bg-white rounded-t-md rounded-b-md shadow-xs py-4">
                <div class="tp-search-box flex items-center justify-between px-8 py-8">
                    <div class="search-input relative">
                        <input class="input h-[44px] w-full pl-14" type="text" placeholder="Search by product name">
                        <button class="absolute top-1/2 left-5 translate-y-[-50%] hover:text-theme">
                            <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 17C13.4183 17 17 13.4183 17 9C17 4.58172 13.4183 1 9 1C4.58172 1 1 4.58172 1 9C1 13.4183 4.58172 17 9 17Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M18.9999 19L14.6499 14.65" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="flex justify-end space-x-6">
                        <div class="search-select mr-3 flex items-center space-x-3 ">
                            <span class="text-tiny inline-block leading-none -translate-y-[2px]">Status : </span>
                            <select>
                                <option>Active</option>
                                <option>In Active</option>
                                <option>Scheduled</option>
                                <option>Low Stock</option>
                                <option>Out of Stock</option>
                            </select>
                        </div>
                        <div class="product-add-btn flex ">
                            <a href="add-product.html" class="tp-btn">Add Product</a>
                        </div>
                    </div>
                </div>
                <div class="relative overflow-x-auto  mx-8">
                    <table class="w-full text-base text-left text-gray-500">
                        
                        <thead class="bg-white">
                            <tr class="border-b border-gray6 text-tiny">
                                <th scope="col" class=" py-3 text-tiny text-text2 uppercase font-semibold w-[3%]">
                                    <div class="tp-checkbox -translate-y-[3px]">
                                        <input id="selectAllProduct" type="checkbox">
                                        <label for="selectAllProduct"></label>
                                    </div>
                                </th>
                                <th scope="col" class="pr-8 py-3 text-tiny text-text2 uppercase font-semibold">
                                    Product 
                                </th>
                                <th scope="col" class="px-3 py-3 text-tiny text-text2 uppercase font-semibold w-[170px] text-end">
                                    SKU
                                </th>
                                <th scope="col" class="px-3 py-3 text-tiny text-text2 uppercase font-semibold w-[170px] text-end">
                                    QTY
                                </th>
                                <th scope="col" class="px-3 py-3 text-tiny text-text2 uppercase font-semibold w-[170px] text-end">
                                    Price
                                </th>
                                <th scope="col" class="px-3 py-3 text-tiny text-text2 uppercase font-semibold w-[170px] text-end">
                                    Rating
                                </th>
                                <th scope="col" class="px-3 py-3 text-tiny text-text2 uppercase font-semibold w-[170px] text-end">
                                    Status
                                </th>
                                <th scope="col" class="px-9 py-3 text-tiny text-text2 uppercase  font-semibold w-[12%] text-end">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($demandes as $demande)
                            <tr class="bg-white border-b border-gray6 last:border-0 text-start mx-9">
                                <td  class="pr-3  whitespace-nowrap">
                                    <span class="font-medium text-heading text-hover-primary transition">  {{ $demande->id }}
                                    </span> </td>
                                <td  class="pr-8 py-5 whitespace-nowrap">
                             <span class="font-medium text-heading text-hover-primary transition">{{ $demande->name }}</span>
                               
                                </td>
                                <td class="px-3 py-3 font-normal text-[#55585B] text-end">
                                    {{ $demande->sujet }}
                                </td>
                                <td class="px-3 py-3 font-normal text-[#55585B] text-end">
                                    {{ $demande->email }}
                                </td>
                                <td class="px-3 py-3 font-normal text-[#55585B] text-end">
                                    {{ $demande->phone }}
                                </td>
                               
                                <td class="px-3 py-3 text-end">
                                    <span class="text-[11px]  text-success px-3 py-1 rounded-md leading-none bg-success/10 font-medium text-end">{{ $demande->message }}</span>
                                </td>
                                 
                            </tr>
                            @endforeach                          
                          
                        </tbody>
                    </table>
                </div>
               
                </div>

                
            </div>


        </div>
    </div>

               @include('dashboard.components.js')

</body>

 </html>