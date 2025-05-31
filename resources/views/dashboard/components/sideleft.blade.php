<aside class="w-[300px] lg:w-[250px] xl:w-[300px] border-r border-gray overflow-y-scroll sidebar-scrollbar fixed left-0 top-0 h-full bg-white z-50 transition-transform duration-300" :class="sideMenu ? 'translate-x-[0px]' : ' -translate-x-[300px] lg:translate-x-[0]'">
    <div class="">
        <div class="py-4 pb-8 px-8 border-b border-gray h-[78px]">
            <a href="">
                <img class="w-[100px] h-[50px]" src="https://res.cloudinary.com/ddi29nbzl/image/upload/v1745420211/braun.tn/logo/vfqv40by0uco5dvofusj.png" alt="">
            </a>
        </div>
        <div class="px-4 py-5" x-data="{nav:null}">
            <ul>
                <li>
                    <a 
                    @click="nav !== 0 ? nav = 0 : nav = null" 
                    :class="nav == 0 ? 'bg-themeLight hover:bg-themeLight text-theme' : ''"
                    href="{{ route('dashboard.home') }}" 
                    class="group rounded-md relative text-black text-lg font-medium inline-flex items-center w-full transition-colors ease-in-out duration-300 px-5 py-[9px] mb-2 hover:bg-gray sidebar-link-active"

                    >
                        <span class="inline-block  mr-[10px] text-xl" >
                            <svg class="-translate-y-[4px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16">
                                <path fill="currentColor" d="M7,0H4A4,4,0,0,0,0,4V7a4,4,0,0,0,4,4H7a4,4,0,0,0,4-4V4A4,4,0,0,0,7,0ZM9,7A2,2,0,0,1,7,9H4A2,2,0,0,1,2,7V4A2,2,0,0,1,4,2H7A2,2,0,0,1,9,4Z"/>
                                <path fill="currentColor" d="M20,0H17a4,4,0,0,0-4,4V7a4,4,0,0,0,4,4h3a4,4,0,0,0,4-4V4A4,4,0,0,0,20,0Zm2,7a2,2,0,0,1-2,2H17a2,2,0,0,1-2-2V4a2,2,0,0,1,2-2h3a2,2,0,0,1,2,2Z"/>
                                <path fill="currentColor" d="M7,13H4a4,4,0,0,0-4,4v3a4,4,0,0,0,4,4H7a4,4,0,0,0,4-4V17A4,4,0,0,0,7,13Zm2,7a2,2,0,0,1-2,2H4a2,2,0,0,1-2-2V17a2,2,0,0,1,2-2H7a2,2,0,0,1,2,2Z"/>
                                <path fill="currentColor" d="M20,13H17a4,4,0,0,0-4,4v3a4,4,0,0,0,4,4h3a4,4,0,0,0,4-4V17A4,4,0,0,0,20,13Zm2,7a2,2,0,0,1-2,2H17a2,2,0,0,1-2-2V17a2,2,0,0,1,2-2h3a2,2,0,0,1,2,2Z"/></svg>
                        </span>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a 
                    href="categories" 
                    class="group rounded-md relative text-black text-lg font-medium inline-flex items-center w-full transition-colors ease-in-out duration-300 px-5 py-[9px] mb-3 hover:bg-gray sidebar-link-active">
                        <span class="inline-block translate-y-[1px] mr-[10px] text-xl">
                            <svg class="-translate-y-[4px]"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16">
                                <path fill="currentColor" d="M22.713,4.077A2.993,2.993,0,0,0,20.41,3H4.242L4.2,2.649A3,3,0,0,0,1.222,0H1A1,1,0,0,0,1,2h.222a1,1,0,0,1,.993.883l1.376,11.7A5,5,0,0,0,8.557,19H19a1,1,0,0,0,0-2H8.557a3,3,0,0,1-2.82-2h11.92a5,5,0,0,0,4.921-4.113l.785-4.354A2.994,2.994,0,0,0,22.713,4.077ZM21.4,6.178l-.786,4.354A3,3,0,0,1,17.657,13H5.419L4.478,5H20.41A1,1,0,0,1,21.4,6.178Z"/><circle fill="currentColor" cx="7" cy="22" r="2"/><circle fill="currentColor" cx="17" cy="22" r="2"/></svg>
                        </span>
                        Categories

                    </a>
                </li>
                <li>
                    <a 
                    @click="nav !== 1 ? nav = 1 : nav = null"  
                    :class="nav == 1 ? 'bg-themeLight hover:bg-themeLight text-theme' : ''" 
                    href="javascript:void(0);" 
                    class="group rounded-md relative text-black text-lg font-medium inline-flex items-center w-full transition-colors ease-in-out duration-300 px-5 py-[9px] mb-3 hover:bg-gray sidebar-link-active">
                        <span class="inline-block translate-y-[1px] mr-[10px] text-xl" >
                            <svg class="-translate-y-[4px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16">
                                <path fill="currentColor" d="M23.621,6.836l-1.352-2.826c-.349-.73-.99-1.296-1.758-1.552L14.214,.359c-1.428-.476-3-.476-4.428,0L3.49,2.458c-.769,.256-1.41,.823-1.759,1.554L.445,6.719c-.477,.792-.567,1.742-.247,2.609,.309,.84,.964,1.49,1.802,1.796l-.005,6.314c-.002,2.158,1.372,4.066,3.418,4.748l4.365,1.455c.714,.238,1.464,.357,2.214,.357s1.5-.119,2.214-.357l4.369-1.457c2.043-.681,3.417-2.585,3.419-4.739l.005-6.32c.846-.297,1.508-.946,1.819-1.79,.317-.858,.228-1.799-.198-2.499ZM10.419,2.257c1.02-.34,2.143-.34,3.162,0l4.248,1.416-5.822,1.95-5.834-1.95,4.246-1.415ZM2.204,7.666l1.327-2.782c.048,.025,7.057,2.373,7.057,2.373l-1.621,3.258c-.239,.398-.735,.582-1.173,.434l-5.081-1.693c-.297-.099-.53-.325-.639-.619-.109-.294-.078-.616,.129-.97Zm3.841,12.623c-1.228-.409-2.052-1.554-2.051-2.848l.005-5.648,3.162,1.054c1.344,.448,2.792-.087,3.559-1.371l.278-.557-.005,10.981c-.197-.04-.391-.091-.581-.155l-4.366-1.455Zm11.897-.001l-4.37,1.457c-.19,.063-.384,.115-.581,.155l.005-10.995,.319,.64c.556,.928,1.532,1.459,2.561,1.459,.319,0,.643-.051,.96-.157l3.161-1.053-.005,5.651c0,1.292-.826,2.435-2.052,2.844Zm4-11.644c-.105,.285-.331,.504-.619,.6l-5.118,1.706c-.438,.147-.934-.035-1.136-.365l-1.655-3.323s7.006-2.351,7.054-2.377l1.393,2.901c.157,.261,.186,.574,.081,.859Z"/></svg>
                        </span>
                        Produits

                        <span class="absolute right-4 top-[52%] transition-transform duration-300 origin-center w-4 h-4" :class="nav == 1 ? 'translate-y-[-10px] rotate-90' : 'translate-y-[-10px]'">
                            <svg class="-translate-y-[5px]"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16"><path fill="currentColor" d="M15.4,9.88,10.81,5.29a1,1,0,0,0-1.41,0,1,1,0,0,0,0,1.42L14,11.29a1,1,0,0,1,0,1.42L9.4,17.29a1,1,0,0,0,1.41,1.42l4.59-4.59A3,3,0,0,0,15.4,9.88Z"/></svg>
                        </span>
                    </a>
                    <ul x-show="nav == 1" class="pl-[42px] pr-[20px] pb-3">
                        <li>
                            <a href="{{ route('dashboard.produits.add') }}" class="block font-normal w-full text-[#6D6F71] hover:text-theme nav-dot">Ajouter</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.produits.index') }}" class="block font-normal w-full text-[#6D6F71] hover:text-theme nav-dot">Listes</a>
                        </li>
                       
                    </ul>
                </li>
                
                <li class="hidden">
                    <a 
                    @click="nav !== 3 ? nav = 3 : nav = null" 
                    :class="nav == 3 ? 'bg-themeLight hover:bg-themeLight text-theme' : ''" 
                    href="javascript:void(0);" 
                    class="group rounded-md relative text-black text-lg font-medium inline-flex items-center w-full transition-colors ease-in-out duration-300 px-5 py-[9px] mb-3 hover:bg-gray sidebar-link-active">
                        <span class="inline-block translate-y-[1px] mr-[10px] text-xl">
                            <svg class="-translate-y-[4px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16">
                                <path fill="currentColor" d="M12,16a4,4,0,1,1,4-4A4,4,0,0,1,12,16Zm0-6a2,2,0,1,0,2,2A2,2,0,0,0,12,10Zm6,13A6,6,0,0,0,6,23a1,1,0,0,0,2,0,4,4,0,0,1,8,0,1,1,0,0,0,2,0ZM18,8a4,4,0,1,1,4-4A4,4,0,0,1,18,8Zm0-6a2,2,0,1,0,2,2A2,2,0,0,0,18,2Zm6,13a6.006,6.006,0,0,0-6-6,1,1,0,0,0,0,2,4,4,0,0,1,4,4,1,1,0,0,0,2,0ZM6,8a4,4,0,1,1,4-4A4,4,0,0,1,6,8ZM6,2A2,2,0,1,0,8,4,2,2,0,0,0,6,2ZM2,15a4,4,0,0,1,4-4A1,1,0,0,0,6,9a6.006,6.006,0,0,0-6,6,1,1,0,0,0,2,0Z"/></svg>
                        </span>
                        Clients

                        <span class="absolute right-4 top-[52%] transition-transform duration-300 origin-center w-4 h-4" :class="nav == 3 ? 'translate-y-[-10px] rotate-90' : 'translate-y-[-10px]'">
                            <svg class="-translate-y-[5px]"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16"><path fill="currentColor" d="M15.4,9.88,10.81,5.29a1,1,0,0,0-1.41,0,1,1,0,0,0,0,1.42L14,11.29a1,1,0,0,1,0,1.42L9.4,17.29a1,1,0,0,0,1.41,1.42l4.59-4.59A3,3,0,0,0,15.4,9.88Z"/></svg>
                        </span>
                    </a>
                    <ul x-show="nav == 3" class="pl-[42px] pr-[20px] pb-3">
                        <li>
                            <a href="{{ route('dashboard.clients.index') }}" class="block font-normal w-full text-[#6D6F71] hover:text-theme nav-dot">Listes</a>
                        </li>
                         
                    </ul>
                </li>

                
                <li>
                    <a 
                    @click="nav !== 4 ? nav = 4 : nav = null" 
                    :class="nav == 4 ? 'bg-themeLight hover:bg-themeLight text-theme' : ''"
                    href="javascript:void(0);" 
                    class="group rounded-md relative text-black text-lg font-medium inline-flex items-center w-full transition-colors ease-in-out duration-300 px-5 py-[9px] mb-3 hover:bg-gray sidebar-link-active">
                        <span class="inline-block translate-y-[1px] mr-[10px] text-xl">
                            <svg class="-translate-y-[4px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16"><path fill="currentColor" d="m11.349,24H0V3C0,1.346,1.346,0,3,0h12c1.654,0,3,1.346,3,3v5.059c-.329-.036-.662-.059-1-.059s-.671.022-1,.059V3c0-.552-.448-1-1-1H3c-.552,0-1,.448-1,1v19h7.518c.506.756,1.125,1.429,1.831,2Zm0-14h-7.349v2h5.518c.506-.756,1.125-1.429,1.831-2Zm-7.349,7h4c0-.688.084-1.356.231-2h-4.231v2Zm20,0c0,3.859-3.141,7-7,7s-7-3.141-7-7,3.141-7,7-7,7,3.141,7,7Zm-2,0c0-2.757-2.243-5-5-5s-5,2.243-5,5,2.243,5,5,5,5-2.243,5-5ZM14,5H4v2h10v-2Zm5.589,9.692l-3.228,3.175-1.63-1.58-1.393,1.436,1.845,1.788c.314.315.733.489,1.179.489s.865-.174,1.173-.482l3.456-3.399-1.402-1.426Z"/></svg>
                        </span>
                        Commandes

                        <span class="absolute right-4 top-[52%] transition-transform duration-300 origin-center w-4 h-4" :class="nav == 4 ? 'translate-y-[-10px] rotate-90' : 'translate-y-[-10px]'">
                            <svg class="-translate-y-[5px]"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16"><path fill="currentColor" d="M15.4,9.88,10.81,5.29a1,1,0,0,0-1.41,0,1,1,0,0,0,0,1.42L14,11.29a1,1,0,0,1,0,1.42L9.4,17.29a1,1,0,0,0,1.41,1.42l4.59-4.59A3,3,0,0,0,15.4,9.88Z"/></svg>
                        </span>
                    </a>
                    <ul x-show="nav == 4" class="pl-[42px] pr-[20px] pb-3">
                        <li>
                            <a href="{{ route('dashboard.commandes.groupedOrders') }}" class="block font-normal w-full text-[#6D6F71] hover:text-theme nav-dot">Listes</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.clients.index') }}" class="block font-normal w-full text-[#6D6F71] hover:text-theme nav-dot">Clients</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.transactions.index') }}" class="block font-normal w-full text-[#6D6F71] hover:text-theme nav-dot">Transactions</a>
                        </li>
                    </ul>
                </li>
          <li>
                    <a 
                    href="{{ route('dashboard.users.index') }}" 
                    class="group rounded-md relative text-black text-lg font-medium inline-flex items-center w-full transition-colors ease-in-out duration-300 px-5 py-[9px] mb-3 hover:bg-gray sidebar-link-active">
                        <span class="inline-block translate-y-[1px] mr-[10px] text-xl">
                            <svg class="w-6 h-6 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4H6Zm7.25-2.095c.478-.86.75-1.85.75-2.905a5.973 5.973 0 0 0-.75-2.906 4 4 0 1 1 0 5.811ZM15.466 20c.34-.588.535-1.271.535-2v-1a5.978 5.978 0 0 0-1.528-4H18a4 4 0 0 1 4 4v1a2 2 0 0 1-2 2h-4.535Z" clip-rule="evenodd"/>
                              </svg>
                              
                        </span>
                        Equipes
                    </a>
                </li>
                <li>
                    <a 
                    href="{{ route('dashboard.traffic') }}" 
                    class="group rounded-md relative text-black text-lg font-medium inline-flex items-center w-full transition-colors ease-in-out duration-300 px-5 py-[9px] mb-3 hover:bg-gray sidebar-link-active">
                        <span class="inline-block translate-y-[1px] mr-[10px] text-xl">
                            <svg class="w-6 h-6 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v15a1 1 0 0 0 1 1h15M8 16l2.5-5.5 3 3L17.273 7 20 9.667"/>
                              </svg>
                               
                        </span>
                        Traffic
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.profile') }}"
                    class="group rounded-md relative text-black text-lg font-medium inline-flex items-center w-full transition-colors ease-in-out duration-300 px-5 py-[9px] mb-3 hover:bg-gray sidebar-link-active">
                        <span class="inline-block translate-y-[1px] mr-[10px] text-xl">
                            <svg class="-translate-y-[4px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16"><path fill="currentColor" d="m12,0C5.383,0,0,5.383,0,12s5.383,12,12,12,12-5.383,12-12S18.617,0,12,0Zm-4,21.164v-.164c0-2.206,1.794-4,4-4s4,1.794,4,4v.164c-1.226.537-2.578.836-4,.836s-2.774-.299-4-.836Zm9.925-1.113c-.456-2.859-2.939-5.051-5.925-5.051s-5.468,2.192-5.925,5.051c-2.47-1.823-4.075-4.753-4.075-8.051C2,6.486,6.486,2,12,2s10,4.486,10,10c0,3.298-1.605,6.228-4.075,8.051Zm-5.925-15.051c-2.206,0-4,1.794-4,4s1.794,4,4,4,4-1.794,4-4-1.794-4-4-4Zm0,6c-1.103,0-2-.897-2-2s.897-2,2-2,2,.897,2,2-.897,2-2,2Z"/></svg>
                        </span>
                        Profil
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.demandes.index') }}"
                    class="group rounded-md relative text-black text-lg font-medium inline-flex items-center w-full transition-colors ease-in-out duration-300 px-5 py-[9px] mb-3 hover:bg-gray sidebar-link-active">
                        <span class="inline-block translate-y-[1px] mr-[10px] text-xl">
                            <svg class="w-6 h-6 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17 6h-2V5h1a1 1 0 1 0 0-2h-2a1 1 0 0 0-1 1v2h-.541A5.965 5.965 0 0 1 14 10v4a1 1 0 1 1-2 0v-4c0-2.206-1.794-4-4-4-.075 0-.148.012-.22.028C7.686 6.022 7.596 6 7.5 6A4.505 4.505 0 0 0 3 10.5V16a1 1 0 0 0 1 1h7v3a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-3h5a1 1 0 0 0 1-1v-6c0-2.206-1.794-4-4-4Zm-9 8.5H7a1 1 0 1 1 0-2h1a1 1 0 1 1 0 2Z"/>
                              </svg>
                              
                        </span>
                        Contact
                    </a>
                </li>
                <li>
                    <a 
                    href="{{ route('dashboard.conversion') }}" 
                    class="group rounded-md relative text-black text-lg font-medium inline-flex items-center w-full transition-colors ease-in-out duration-300 px-5 py-[9px] mb-3 hover:bg-gray sidebar-link-active">
                        <span class="inline-block translate-y-[1px] mr-[10px] text-xl">
                            <svg class="w-6 h-6 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
                                <path stroke="currentColor" stroke-width="2" d="M12 6v6l4 2"/>
                            </svg>
                        </span>
                        Conversion
                    </a>
                </li>
            </ul>
         


        </div>
    </div>

</aside>
