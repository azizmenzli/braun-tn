<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from html.hixstudio.net/ebazer/transaction.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 19 Apr 2025 11:45:35 GMT -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Braun -Transcation</title>
    <link rel="shortcut icon" href="assets/img/logo/favicon.png" type="image/x-icon">

    <!-- css links -->
    @include('dashboard.components.style')

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
                        <h3 class="mb-0 text-[28px]">Transaction</h3>
                        <ul class="text-tiny font-medium flex items-center space-x-3 text-text3">
                            <li class="breadcrumb-item text-muted">
                                <a href="product-list.html" class="text-hover-primary"> Home</a>
                            </li>
                            <li class="breadcrumb-item flex items-center">
                                <span class="inline-block bg-text3/60 w-[4px] h-[4px] rounded-full"></span>
                            </li>
                            <li class="breadcrumb-item text-muted">Transaction List</li>
                                           
                        </ul>
                    </div>
                </div>

                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12 2xl:col-span-9">
                        <!-- table -->
                        <div class="bg-white rounded-t-md rounded-b-md shadow-xs py-4">
                            <div class="tp-search-box flex items-center justify-between px-8 py-8 flex-wrap">
                                <div class="search-input relative">
                                    <input class="input h-[44px] w-full pl-14" type="text" placeholder="Search by ID">
                                    <button class="absolute top-1/2 left-5 translate-y-[-50%] hover:text-theme">
                                        <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9 17C13.4183 17 17 13.4183 17 9C17 4.58172 13.4183 1 9 1C4.58172 1 1 4.58172 1 9C1 13.4183 4.58172 17 9 17Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M18.9999 19L14.6499 14.65" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="flex justify-end space-x-6 flex-wrap">
                                    <div class="search-select mr-3 flex items-center space-x-3 ">
                                        <span class="text-tiny inline-block leading-none -translate-y-[2px]">Status : </span>
                                        <select>
                                            <option>Paid</option>
                                            <option>Cash</option>
                                            <option>Declined</option>
                                            <option>Pending</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="relative overflow-x-auto mx-8 mb-3">
                                <table class="w-[1099px] 3xl:text-red text-base text-left text-gray-500">
                                    
                                    <thead class="bg-white">
                                        <tr class="border-b border-gray6 text-tiny">
                                            <th scope="col" class="pr-8 py-3 text-tiny text-text2 uppercase font-semibold w-[12%]">
                                                Transaction ID 
                                            </th>
                                            <th scope="col" class="px-3 py-3 text-tiny text-text2 uppercase font-semibold">
                                                Method
                                            </th>
                                            <th scope="col" class="px-3 py-3 text-tiny text-text2 uppercase font-semibold w-[250px] text-end">
                                                Ammount
                                            </th>
                                            <th scope="col" class="px-3 py-3 text-tiny text-text2 uppercase font-semibold w-[250px] text-end">
                                                Date
                                            </th>
                                            <th scope="col" class="px-3 py-3 text-tiny text-text2 uppercase font-semibold w-[170px] text-end">
                                                Status
                                            </th>
                                            <th scope="col" class="px-3 py-3 text-tiny text-text2 uppercase font-semibold w-[170px] text-end">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="bg-white border-b border-gray6 last:border-0 text-start mx-9">
                                            <td class="px-3 py-3 font-normal text-[#55585B]">
                                                #479063DR 
                                            </td>
                                            <td class="px-3 py-3 font-normal text-[#55585B] text-end">
                                                <div class="flex items-center space-x-5">
                                                    <img class="max-w-[44px] border border-gray6" src="assets/img/payment/master-card.png" alt="">
                                                    <span class="font-medium text-heading">MasterCard</span>
                                                </div>
                                            </td>
                                            <td class="px-3 py-3 font-normal text-[#55585B] text-end">
                                                $1520.54
                                            </td>
                                            <td class="px-3 py-3 font-normal text-[#55585B] text-end">
                                                Jan 21, 2023 08:30 AM
                                            </td>
                                            <td class="px-3 py-3 text-end">
                                                <span class="text-[11px]  text-success px-3 py-1 rounded-md leading-none bg-success/10 font-medium text-end">Paid</span>
                                            </td>
                                            <td class="pl-9 py-3 text-end">
                                                <div class="flex items-center justify-end space-x-2">
                                                    <div class="relative" x-data="{ editTooltip: false }">
                                                        <button 
                                                        class="h-10 px-4 leading-10 text-tiny bg-white text-black border border-slate-300 rounded-md hover:bg-green-600 hover:text-white hover:border-green-600"
                                                        x-on:mouseenter="editTooltip = true" x-on:mouseleave="editTooltip = false"
                                                        >
                                                            View Details
                                                        </button>
                                                        <div x-show="editTooltip" class="flex flex-col items-center z-50 absolute left-1/2 -translate-x-1/2 bottom-full mb-1">
                                                            <span class="relative z-10 p-2 text-tiny leading-none font-medium text-white whitespace-no-wrap w-max bg-slate-800 rounded py-1 px-2 inline-block">Details</span>
                                                            <div class="w-3 h-3 -mt-2 rotate-45 bg-black"></div>
                                                        </div>
                                                    </div>                                            
                                                </div>  
                                            </td>
                                        </tr>                              
                                        <tr class="bg-white border-b border-gray6 last:border-0 text-start mx-9">
                                            <td class="px-3 py-3 font-normal text-[#55585B]">
                                                #94267415 
                                            </td>
                                            <td class="px-3 py-3 font-normal text-[#55585B] text-end">
                                                <div class="flex items-center space-x-5">
                                                    <img class="max-w-[44px] border border-gray6" src="assets/img/payment/visa.png" alt="">
                                                    <span class="font-medium text-heading">Visa</span>
                                                </div>
                                            </td>
                                            <td class="px-3 py-3 font-normal text-[#55585B] text-end">
                                                $2145.00
                                            </td>
                                            <td class="px-3 py-3 font-normal text-[#55585B] text-end">
                                                Jan 25, 2023 10:25 PM
                                            </td>
                                            <td class="px-3 py-3 text-end">
                                                <span class="text-[11px]  text-warning px-3 py-1 rounded-md leading-none bg-warning/10 font-medium text-end">Pending</span>
                                            </td>
                                            <td class="pl-9 py-3 text-end">
                                                <div class="flex items-center justify-end space-x-2">
                                                    <div class="relative" x-data="{ editTooltip: false }">
                                                        <button 
                                                        class="h-10 px-4 leading-10 text-tiny bg-white text-black border border-slate-300 rounded-md hover:bg-green-600 hover:text-white hover:border-green-600"
                                                        x-on:mouseenter="editTooltip = true" x-on:mouseleave="editTooltip = false"
                                                        >
                                                            View Details
                                                        </button>
                                                        <div x-show="editTooltip" class="flex flex-col items-center z-50 absolute left-1/2 -translate-x-1/2 bottom-full mb-1">
                                                            <span class="relative z-10 p-2 text-tiny leading-none font-medium text-white whitespace-no-wrap w-max bg-slate-800 rounded py-1 px-2 inline-block">Details</span>
                                                            <div class="w-3 h-3 -mt-2 rotate-45 bg-black"></div>
                                                        </div>
                                                    </div>                                            
                                                </div>  
                                            </td>
                                        </tr>                              
                                        <tr class="bg-white border-b border-gray6 last:border-0 text-start mx-9">
                                            <td class="px-3 py-3 font-normal text-[#55585B]">
                                                #36675705 
                                            </td>
                                            <td class="px-3 py-3 font-normal text-[#55585B] text-end">
                                                <div class="flex items-center space-x-5">
                                                    <img class="max-w-[44px] border border-gray6" src="assets/img/payment/paypal.png" alt="">
                                                    <span class="font-medium text-heading">PayPal</span>
                                                </div>
                                            </td>
                                            <td class="px-3 py-3 font-normal text-[#55585B] text-end">
                                                $1520.54
                                            </td>
                                            <td class="px-3 py-3 font-normal text-[#55585B] text-end">
                                                Jan 29, 2023 12:05 PM
                                            </td>
                                            <td class="px-3 py-3 text-end">
                                                <span class="text-[11px]  text-success px-3 py-1 rounded-md leading-none bg-success/10 font-medium text-end">Paid</span>
                                            </td>
                                            <td class="pl-9 py-3 text-end">
                                                <div class="flex items-center justify-end space-x-2">
                                                    <div class="relative" x-data="{ editTooltip: false }">
                                                        <button 
                                                        class="h-10 px-4 leading-10 text-tiny bg-white text-black border border-slate-300 rounded-md hover:bg-green-600 hover:text-white hover:border-green-600"
                                                        x-on:mouseenter="editTooltip = true" x-on:mouseleave="editTooltip = false"
                                                        >
                                                            View Details
                                                        </button>
                                                        <div x-show="editTooltip" class="flex flex-col items-center z-50 absolute left-1/2 -translate-x-1/2 bottom-full mb-1">
                                                            <span class="relative z-10 p-2 text-tiny leading-none font-medium text-white whitespace-no-wrap w-max bg-slate-800 rounded py-1 px-2 inline-block">Details</span>
                                                            <div class="w-3 h-3 -mt-2 rotate-45 bg-black"></div>
                                                        </div>
                                                    </div>                                            
                                                </div> 
                                            </td>
                                        </tr>                              
                                        <tr class="bg-white border-b border-gray6 last:border-0 text-start mx-9">
                                            <td class="px-3 py-3 font-normal text-[#55585B]">
                                                #11686375 
                                            </td>
                                            <td class="px-3 py-3 font-normal text-[#55585B] text-end">
                                                <div class="flex items-center space-x-5">
                                                    <img class="max-w-[44px] border border-gray6" src="assets/img/payment/american-express.png" alt="">
                                                    <span class="font-medium text-heading">AmericanExpress</span>
                                                </div>
                                            </td>
                                            <td class="px-3 py-3 font-normal text-[#55585B] text-end">
                                                $119.99
                                            </td>
                                            <td class="px-3 py-3 font-normal text-[#55585B] text-end">
                                                Feb 05, 2023 07:02 AM
                                            </td>
                                            <td class="px-3 py-3 text-end">
                                                <span class="text-[11px]  text-danger px-3 py-1 rounded-md leading-none bg-danger/10 font-medium text-end">Declined</span>
                                            </td>
                                            <td class="pl-9 py-3 text-end">
                                                <div class="flex items-center justify-end space-x-2">
                                                    <div class="relative" x-data="{ editTooltip: false }">
                                                        <button 
                                                        class="h-10 px-4 leading-10 text-tiny bg-white text-black border border-slate-300 rounded-md hover:bg-green-600 hover:text-white hover:border-green-600"
                                                        x-on:mouseenter="editTooltip = true" x-on:mouseleave="editTooltip = false"
                                                        >
                                                            View Details
                                                        </button>
                                                        <div x-show="editTooltip" class="flex flex-col items-center z-50 absolute left-1/2 -translate-x-1/2 bottom-full mb-1">
                                                            <span class="relative z-10 p-2 text-tiny leading-none font-medium text-white whitespace-no-wrap w-max bg-slate-800 rounded py-1 px-2 inline-block">Details</span>
                                                            <div class="w-3 h-3 -mt-2 rotate-45 bg-black"></div>
                                                        </div>
                                                    </div>                                            
                                                </div> 
                                            </td>
                                        </tr>  
                                        <tr class="bg-white border-b border-gray6 last:border-0 text-start mx-9">
                                            <td class="px-3 py-3 font-normal text-[#55585B]">
                                                #88812234 
                                            </td>
                                            <td class="px-3 py-3 font-normal text-[#55585B] text-end">
                                                <div class="flex items-center space-x-5">
                                                    <img class="max-w-[44px] border border-gray6" src="assets/img/payment/paypal.png" alt="">
                                                    <span class="font-medium text-heading">PayPal</span>
                                                </div>
                                            </td>
                                            <td class="px-3 py-3 font-normal text-[#55585B] text-end">
                                                $1520.54
                                            </td>
                                            <td class="px-3 py-3 font-normal text-[#55585B] text-end">
                                                Jan 29, 2023 12:05 PM
                                            </td>
                                            <td class="px-3 py-3 text-end">
                                                <span class="text-[11px]  text-success px-3 py-1 rounded-md leading-none bg-success/10 font-medium text-end">Paid</span>
                                            </td>
                                            <td class="pl-9 py-3 text-end">
                                                <div class="flex items-center justify-end space-x-2">
                                                    <div class="relative" x-data="{ editTooltip: false }">
                                                        <button 
                                                        class="h-10 px-4 leading-10 text-tiny bg-white text-black border border-slate-300 rounded-md hover:bg-green-600 hover:text-white hover:border-green-600"
                                                        x-on:mouseenter="editTooltip = true" x-on:mouseleave="editTooltip = false"
                                                        >
                                                            View Details
                                                        </button>
                                                        <div x-show="editTooltip" class="flex flex-col items-center z-50 absolute left-1/2 -translate-x-1/2 bottom-full mb-1">
                                                            <span class="relative z-10 p-2 text-tiny leading-none font-medium text-white whitespace-no-wrap w-max bg-slate-800 rounded py-1 px-2 inline-block">Details</span>
                                                            <div class="w-3 h-3 -mt-2 rotate-45 bg-black"></div>
                                                        </div>
                                                    </div>                                            
                                                </div> 
                                            </td>
                                        </tr> 
                                        <tr class="bg-white border-b border-gray6 last:border-0 text-start mx-9">
                                            <td class="px-3 py-3 font-normal text-[#55585B]">
                                                #19168064 
                                            </td>
                                            <td class="px-3 py-3 font-normal text-[#55585B] text-end">
                                                <div class="flex items-center space-x-5">
                                                    <img class="max-w-[44px] border border-gray6" src="assets/img/payment/master-card.png" alt="">
                                                    <span class="font-medium text-heading">MasterCard</span>
                                                </div>
                                            </td>
                                            <td class="px-3 py-3 font-normal text-[#55585B] text-end">
                                                $1520.54
                                            </td>
                                            <td class="px-3 py-3 font-normal text-[#55585B] text-end">
                                                Jan 21, 2023 08:30 AM
                                            </td>
                                            <td class="px-3 py-3 text-end">
                                                <span class="text-[11px]  text-success px-3 py-1 rounded-md leading-none bg-success/10 font-medium text-end">Paid</span>
                                            </td>
                                            <td class="pl-9 py-3 text-end">
                                                <div class="flex items-center justify-end space-x-2">
                                                    <div class="relative" x-data="{ editTooltip: false }">
                                                        <button 
                                                        class="h-10 px-4 leading-10 text-tiny bg-white text-black border border-slate-300 rounded-md hover:bg-green-600 hover:text-white hover:border-green-600"
                                                        x-on:mouseenter="editTooltip = true" x-on:mouseleave="editTooltip = false"
                                                        >
                                                            View Details
                                                        </button>
                                                        <div x-show="editTooltip" class="flex flex-col items-center z-50 absolute left-1/2 -translate-x-1/2 bottom-full mb-1">
                                                            <span class="relative z-10 p-2 text-tiny leading-none font-medium text-white whitespace-no-wrap w-max bg-slate-800 rounded py-1 px-2 inline-block">Details</span>
                                                            <div class="w-3 h-3 -mt-2 rotate-45 bg-black"></div>
                                                        </div>
                                                    </div>                                            
                                                </div>  
                                            </td>
                                        </tr>                              
                                        <tr class="bg-white border-b border-gray6 last:border-0 text-start mx-9">
                                            <td class="px-3 py-3 font-normal text-[#55585B]">
                                                #07081582 
                                            </td>
                                            <td class="px-3 py-3 font-normal text-[#55585B] text-end">
                                                <div class="flex items-center space-x-5">
                                                    <img class="max-w-[44px] border border-gray6" src="assets/img/payment/american-express.png" alt="">
                                                    <span class="font-medium text-heading">AmericanExpress</span>
                                                </div>
                                            </td>
                                            <td class="px-3 py-3 font-normal text-[#55585B] text-end">
                                                $119.99
                                            </td>
                                            <td class="px-3 py-3 font-normal text-[#55585B] text-end">
                                                Feb 05, 2023 07:02 AM
                                            </td>
                                            <td class="px-3 py-3 text-end">
                                                <span class="text-[11px]  text-danger px-3 py-1 rounded-md leading-none bg-danger/10 font-medium text-end">Declined</span>
                                            </td>
                                            <td class="pl-9 py-3 text-end">
                                                <div class="flex items-center justify-end space-x-2">
                                                    <div class="relative" x-data="{ editTooltip: false }">
                                                        <button 
                                                        class="h-10 px-4 leading-10 text-tiny bg-white text-black border border-slate-300 rounded-md hover:bg-green-600 hover:text-white hover:border-green-600"
                                                        x-on:mouseenter="editTooltip = true" x-on:mouseleave="editTooltip = false"
                                                        >
                                                            View Details
                                                        </button>
                                                        <div x-show="editTooltip" class="flex flex-col items-center z-50 absolute left-1/2 -translate-x-1/2 bottom-full mb-1">
                                                            <span class="relative z-10 p-2 text-tiny leading-none font-medium text-white whitespace-no-wrap w-max bg-slate-800 rounded py-1 px-2 inline-block">Details</span>
                                                            <div class="w-3 h-3 -mt-2 rotate-45 bg-black"></div>
                                                        </div>
                                                    </div>                                            
                                                </div> 
                                            </td>
                                        </tr> 
                                        <tr class="bg-white border-b border-gray6 last:border-0 text-start mx-9">
                                            <td class="px-3 py-3 font-normal text-[#55585B]">
                                                #79359901 
                                            </td>
                                            <td class="px-3 py-3 font-normal text-[#55585B] text-end">
                                                <div class="flex items-center space-x-5">
                                                    <img class="max-w-[44px] border border-gray6" src="assets/img/payment/visa.png" alt="">
                                                    <span class="font-medium text-heading">Visa</span>
                                                </div>
                                            </td>
                                            <td class="px-3 py-3 font-normal text-[#55585B] text-end">
                                                $2145.00
                                            </td>
                                            <td class="px-3 py-3 font-normal text-[#55585B] text-end">
                                                Jan 25, 2023 10:25 PM
                                            </td>
                                            <td class="px-3 py-3 text-end">
                                                <span class="text-[11px]  text-warning px-3 py-1 rounded-md leading-none bg-warning/10 font-medium text-end">Pending</span>
                                            </td>
                                            <td class="pl-9 py-3 text-end">
                                                <div class="flex items-center justify-end space-x-2">
                                                    <div class="relative" x-data="{ editTooltip: false }">
                                                        <button 
                                                        class="h-10 px-4 leading-10 text-tiny bg-white text-black border border-slate-300 rounded-md hover:bg-green-600 hover:text-white hover:border-green-600"
                                                        x-on:mouseenter="editTooltip = true" x-on:mouseleave="editTooltip = false"
                                                        >
                                                            View Details
                                                        </button>
                                                        <div x-show="editTooltip" class="flex flex-col items-center z-50 absolute left-1/2 -translate-x-1/2 bottom-full mb-1">
                                                            <span class="relative z-10 p-2 text-tiny leading-none font-medium text-white whitespace-no-wrap w-max bg-slate-800 rounded py-1 px-2 inline-block">Details</span>
                                                            <div class="w-3 h-3 -mt-2 rotate-45 bg-black"></div>
                                                        </div>
                                                    </div>                                            
                                                </div>  
                                            </td>
                                        </tr>                                                    
                                    </tbody>
                                </table>
                            </div>
                            <div class="flex justify-between items-center flex-wrap mx-8">
                                <p class="mb-0 text-tiny">Showing 10 Result of 20</p>
                                <div class="pagination py-3 flex justify-end items-center  mx-8">
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
                    <div class="col-span-12 md:col-span-6 2xl:col-span-3">
                        <div class="bg-white rounded-t-md rounded-b-md shadow-xs py-4">
                            <div class="px-8 py-8">
                                <h5 class="text-xl mb-12">Transaction Details</h5>
                                <div class="">
                                    <div class="mb-6">
                                        <h5 class="mb-0 text-base">Transaction ID:</h5>
                                        <p class="mb-0 text-tiny">#479063DR</p>
                                    </div>
                                    <div class="mb-6">
                                        <h5 class="mb-0 text-base">Customer:</h5>
                                        <p class="mb-0 text-tiny">Shahnewaz Sakil</p>
                                    </div>
                                    <div class="mb-6">
                                        <h5 class="mb-0 text-base">Date:</h5>
                                        <p class="mb-0 text-tiny">Jan 25, 2023</p>
                                    </div>
                                    <div class="mb-6">
                                        <h5 class="mb-0 text-base">Billing Address:</h5>
                                        <p class="mb-0 text-tiny">1947 Pursglove Court, Magnetic Springs</p>
                                    </div>
                                    <div class="mb-6">
                                        <h5 class="mb-0 text-base">Item List:</h5>
                                        <p class="mb-0 text-tiny ml-3">1. <a href="#" class="text-hover-primary">Whitetails Women's Open Sky</a> <span class="font-medium">(x2)</span></p>
                                        <p class="mb-0 text-tiny ml-3">2. <a href="#" class="text-hover-primary">Simple Modern School Boys</a><span class="font-medium">(x5)</span></p>
                                    </div>
                                    <div class="mb-6">
                                        <h5 class="mb-0 text-base">Total Ammount:</h5>
                                        <p class="mb-0 text-tiny"><span>Grand Total - </span> $4152.50</p>
                                    </div>
                                    <div class="mb-6">
                                        <h5 class="mb-0 text-base">Payment Method:</h5>
                                        <p class="mb-0 text-tiny">Master Card</p>
                                    </div>
                                    
                                </div>
                                <button class="text-black border border-gray6 px-5 py-2 hover:text-white hover:bg-info hover:border-info">
                                    <span class="mr-1">
                                        <svg class="-translate-y-px" width="18" height="18" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                            <path fill="currentColor" d="m10.9052 29.895h10.18c1.099 0 1.99-.8909 1.99-1.99v-5.92c0-1.099-.891-1.99-1.99-1.99h-10.18c-1.099 0-1.99.891-1.99 1.99v5.92c0 1.099.8909 1.99 1.99 1.99z"></path>
                                            <path fill="currentColor" d="m7.915 26.0044v-6.0093c0-.5522.4478-1 1-1h14.1602c.5522 0 1 .4478 1 1v6.0098h1.5498c2.7461 0 4.98-1.9873 4.98-4.4302v-6.9795c0-2.4375-2.2339-4.4204-4.98-4.4204h-19.2598c-2.7407 0-4.9702 1.9829-4.9702 4.4204v6.9795c0 2.4429 2.2295 4.4302 4.9937 4.4297z"></path>
                                            <path fill="currentColor" d="m11.8751 2.105c-1.1 0-2 .9-2 2v3.84c0 .8174.6627 1.48 1.48 1.48h9.27c.8174 0 1.48-.6626 1.48-1.48v-3.85c0-1.1-.89-1.99-2-1.99z"></path>
                                        </svg>
                                    </span> Print Details
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('dashboard.components.js')

    
</body>

<!-- Mirrored from html.hixstudio.net/ebazer/transaction.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 19 Apr 2025 11:45:36 GMT -->
</html>