<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from html.hixstudio.net/ebazer/edit-product.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 19 Apr 2025 11:45:34 GMT -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>braun -Modifier produit</title>
    <link rel="shortcut icon" href="assets/img/logo/favicon.png" type="image/x-icon">

    <!-- css links -->
    @include('dashboard.components.style')

</head>
<body>

    <!--  -->
    <div class="tp-main-wrapper bg-slate-100 h-screen" x-data="{ sideMenu: false }">
        @include('dashboard.components.sideleft')
 

        <div class="fixed top-0 left-0 w-full h-full z-40 bg-black/70 transition-all duration-300" :class="sideMenu ? 'visible opacity-1' : '  invisible opacity-0 '" x-on:click="sideMenu = ! sideMenu"> </div>

        <div class="tp-main-content lg:ml-[250px] xl:ml-[300px] w-[calc(100% - 300px)]"  x-data="{ searchOverlay: false }">

            @include('dashboard.components.header')


            <div class="body-content px-8 py-8 bg-slate-100">
                <div class="grid grid-cols-12">
                    <div class="col-span-12 2xl:col-span-10">
                        <div class="flex justify-between mb-10 items-end flex-wrap">
                            <div class="page-title mb-6 sm:mb-0">
                                <h3 class="mb-0 text-[28px]">Edit Product</h3>
                                <ul class="text-tiny font-medium flex items-center space-x-3 text-text3">
                                    <li class="breadcrumb-item text-muted">
                                        <a href="product-list.html" class="text-hover-primary"> Home</a>
                                    </li>
                                    <li class="breadcrumb-item flex items-center">
                                        <span class="inline-block bg-text3/60 w-[4px] h-[4px] rounded-full"></span>
                                    </li>
                                    <li class="breadcrumb-item text-muted">Edit Product</li>          
                                </ul>
                            </div>
                            <div class="mb-2 flex sm:justify-end items-center flex-wrap">
                                <button class="tp-btn px-10 py-2 mr-2 sm:mb-0 mb-2">Save</button>
                                <button class="tp-btn px-10 py-2 border border-[#dfdfdf] bg-transparent text-black hover:text-white hover:bg-danger hover:border-danger">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- add product -->
                <div class="grid grid-cols-12">
                    <div class="col-span-12 2xl:col-span-10" x-data="{ addProductTab: 1 }">
                        <div class=" mb-3 hidden" >
                            <div class="flex items-center bg-white rounded-md px-4 py-3">
                                <button 
                                    class="text-base  py-1 px-5 rounded-md border-b border-transparent " 
                                    @click="addProductTab = 1"
                                    :class="addProductTab == 1 ? 'bg-theme text-white' : ' bg-white text-textBody'">
                                    
                                    General
                                </button>
                                <button 
                                    class="text-base  py-1 px-5 rounded-md" 
                                    @click="addProductTab = 2"
                                    :class="addProductTab == 2 ? 'bg-theme text-white' : 'text-textBody bg-white'">
                                    Advanced
                                </button>
                            </div>
                        </div>
                        <div class="">
                            <!-- general tab content -->
                            <div class="" x-show="addProductTab === 1">
                                <div class="grid grid-cols-12 gap-6 mb-6">
                                    <div class="col-span-12 xl:col-span-8 2xl:col-span-9 ">
                                        <div class="mb-6 bg-white px-8 py-8 rounded-md">    
                                            <h4 class="text-[22px]">General</h4>        
                                            <!-- input -->
                                            <div class="mb-5">
                                                <p class="mb-0 text-base text-black">Product Name <span class="text-red">*</span></p>
                                                <input class="input w-full h-[44px] rounded-md border border-gray6 px-6 text-base" type="text" placeholder="Product name">
                                                <span class="text-tiny">A product name is required and recommended to be unique.</span>
                                            </div>
                                            <div class="mb-5">
                                                <p class="mb-0 text-base text-black">Description</p>
                                                <div class="min-h-[200px]" id="editor">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-white px-8 py-8 rounded-md mb-6">
                                             
                                             <h4 class="text-[22px]">Details</h4> 
                                             <!-- tax vat -->
                                             <div class="grid sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-x-6">
        
                                                <div class="mb-5">
                                                    <p class="mb-0 text-base text-black">Base Price <span class="text-red">*</span></p>
                                                    <input class="input w-full h-[44px] rounded-md border border-gray6 px-6 text-base" type="text" placeholder="Product price">
                                                    <span class="text-tiny leading-4">Set the base price of product.</span>
                                                </div>
                                                <!-- input -->
                                                <div class="mb-5">
                                                    <p class="mb-0 text-base text-black">SKU <span class="text-red">*</span></p>
                                                    <input class="input w-full h-[44px] rounded-md border border-gray6 px-6 text-base" type="text" placeholder="SKU">
                                                    <span class="text-tiny leading-4">Enter the product SKU.</span>
                                                </div>
                                                <!-- input -->
                                                <div class="mb-5">
                                                    <p class="mb-0 text-base text-black">Qantity <span class="text-red">*</span></p>
                                                    <input class="input w-full h-[44px] rounded-md border border-gray6 px-6 text-base" type="text" placeholder="Qantity">
                                                    <span class="text-tiny leading-4">Enter the product quantity.</span>
                                                </div>
                                                <!-- input -->
                                                <div class="mb-5">
                                                    <p class="mb-0 text-base text-black">VAT Ammount (%)</p>
                                                    <input class="input w-full h-[44px] rounded-md border border-gray6 px-6 text-base" type="text" placeholder="VAT">
                                                    <span class="text-tiny leading-4">Set the product VAT about.</span>
                                                </div>
                                            </div>
        
                                            <!-- discount -->
                                            <div class="" x-data="{ priceData: 3 }">
                                                <p class="mb-0 text-base text-black">Discount Type <span class="text-red">*</span></p>
                                                <div class="flex items-center sm:space-x-3 flex-wrap mb-5">
                                                    <div class="tp-checkbox-secondary mb-4">
                                                        <label 
                                                        for="noDiscount"
                                                        class="border border-gray6 px-4 sm:px-10 py-5 rounded-md hover:cursor-pointer"  
                                                        x-on:click="priceData = 3"
                                                        >
                                                            <small class="flex items-center">
                                                                <input id="noDiscount" type="radio" name="priceDiscount">
                                                                <span class="text-base font-medium">No Discount</span>
                                                            </small>
                                                        </label>
                                                    </div>
                                                    <div class="tp-checkbox-secondary mb-4">
                                                        <label 
                                                        for="percentDiscount"
                                                        class="border border-gray6 px-4 sm:px-10 py-5 rounded-md hover:cursor-pointer"  
                                                        x-on:click="priceData = 1"
                                                        >
                                                            <small class="flex items-center">
                                                                <input id="percentDiscount" type="radio" name="priceDiscount">
                                                                <span class="text-base font-medium">Percent Discount</span>
                                                            </small>
                                                        </label>
                                                    </div>
                                                    <div class="tp-checkbox-secondary mb-4">
                                                        <label 
                                                        for="fixedDiscount"
                                                        class="border border-gray6 px-4 sm:px-10 py-5 rounded-md hover:cursor-pointer" 
                                                        x-on:click="priceData = 2"
                                                        >
                                                            <small class="flex items-center">
                                                                <input id="fixedDiscount" type="radio" name="priceDiscount">
                                                                <span class="text-base font-medium">Fixed Discount</span>
                                                            </small>
                                                        </label>
                                                    </div>
                                                </div>
    
                                                <div class="mb-5 mx-6" x-show="priceData === 1">
                                                    <p class="mb-0 text-base text-black">Price <span class="text-red">*</span></p>
                                                    <input class="input w-full h-[44px] rounded-md border border-gray6 px-6 text-base" type="text" placeholder="Price">
                                                </div>
                                                <div class="mb-5 mx-6" x-show="priceData === 2">
                                                    <p class="mb-2 text-base text-black">Percent <span class="text-red">*</span></p>
                                                    <input type="text" id="example_id" name="example_name" value="" />
                                                </div>
                                                
                                                <!-- range slider -->
                                                <div class="mt-10 hidden">
                                                    <div class="w-full">
                                                        <div class="relative h-5 w-full" id="my-slider" data-se-min="00" data-se-step="1" data-se-min-value="0" data-se-max-value="40" data-se-max="100" >
                                                          <div class="slider-touch-left w-5 h-5 rounded-md absolute z-10 hover:cursor-pointer">
                                                            <span class="block w-full h-full bg-white rounded-full shadow-sm"></span>
                                                          </div>
                                                          <div class="slider-touch-right w-5 h-5 rounded-md absolute z-10 hover:cursor-pointer">
                                                            <span class="block w-full h-full bg-white rounded-full shadow-sm"></span>
                                                          </div>
                                                          <div class="slider-line absolute w-[calc(100%-5rem)] h-1 left-[18px] top-[7px] rounded bg-[#f9f9f9] overflow-hidden">
                                                            <span class="block h-full w-0 bg-theme"></span>
                                                          </div>
                                                        </div>
                                                    </div>
                                                    <div id="result" class="">Min: 0 Max: 100</div>
                                                </div>

                                            </div>
                                            
                                           
                                        </div>

                                        <div class="bg-white px-8 py-8 rounded-md mb-6">
                                            <h4 class="text-[22px]">Shipping</h4> 
                                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                                                 <!-- input -->
                                                 <div class="mb-5">
                                                    <p class="mb-0 text-base text-black">Width(Inch)</p>
                                                    <input class="input w-full h-[44px] rounded-md border border-gray6 px-6 text-base" type="text" placeholder="Width">
                                                    <span class="text-tiny">Set the product width.</span>
                                                </div>
                                                 <!-- input -->
                                                 <div class="mb-5">
                                                    <p class="mb-0 text-base text-black">Height(Inch)</p>
                                                    <input class="input w-full h-[44px] rounded-md border border-gray6 px-6 text-base" type="text" placeholder="Height">
                                                    <span class="text-tiny">Set the product height.</span>
                                                </div>
                                                 <!-- input -->
                                                 <div class="mb-5">
                                                    <p class="mb-0 text-base text-black">Weight(KG)</p>
                                                    <input class="input w-full h-[44px] rounded-md border border-gray6 px-6 text-base" type="text" placeholder="Weight">
                                                    <span class="text-tiny">Set the product weight.</span>
                                                </div>
                                            </div>
                                            <!-- input -->
                                            <div class="mb-5">
                                               <p class="mb-0 text-base text-black">Shipping Cost</p>
                                               <input class="input w-full h-[44px] rounded-md border border-gray6 px-6 text-base" type="text" placeholder="Cost">
                                               <span class="text-tiny">Set the product shipping cost.</span>
                                           </div>
                                        </div>
                                    </div>
                                    <div class="col-span-12 xl:col-span-4 2xl:col-span-3 ">
                                        <div class="bg-white px-8 py-8 rounded-md mb-6">
                                            <p class="mb-2 text-base text-black">Upload Image</p>
                                            <div class="text-center">
                                                <img class="w-[100px] h-auto mx-auto" src="assets/img/icons/upload.png" alt="">
                                            </div>
                                            <span class="text-tiny text-center w-full inline-block mb-3">Image size must be less than 5Mb</span>
                                            <div class="">
                                                <form action="#">
                                                    <input type="file" id="productImage" class="hidden">
                                                    <label for="productImage" class="text-tiny w-full inline-block py-1 px-4 rounded-md border border-gray6 text-center hover:cursor-pointer hover:bg-theme hover:text-white hover:border-theme transition">Upload Image</label>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="bg-white px-8 py-8 rounded-md mb-6">
                                            <p class="mb-5 text-base text-black">Product Details</p>
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-5">
                                                <div class="category-select select-bordered">
                                                    <h5 class="text-tiny mb-1">Category</h5>
                                                    <select>
                                                        <option value="">Electronics</option>
                                                        <option value="">Fashion</option>
                                                        <option value="">Jewellery</option>
                                                        <option value="">Beauty</option>
                                                        <option value="">Grocery</option>
                                                    </select>
                                                </div>
                                                <div class="sub-category-select select-bordered">
                                                    <h5 class="text-tiny mb-1">Sub Category</h5>
                                                    <select>
                                                        <option value="">Electronics</option>
                                                        <option value="">Fashion</option>
                                                        <option value="">Jewellery</option>
                                                        <option value="">Beauty</option>
                                                        <option value="">Grocery</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-5">
                                                <p class="mb-0 text-base text-black">Tags</p>
                                                <input type="text" id="tag-input1" class="hidden">
                                            </div>
                                        </div>
                                        <div class="bg-white px-8 py-8 rounded-md">
                                            <p class="mb-5 text-base text-black">Product Attribute</p>
                                            <div class="">
                                                <div class="mb-5">
                                                    <p class="mb-0 text-base text-black">Size</p>
                                                    <input class="input w-full h-[44px] rounded-md border border-gray6 px-6 text-base" type="text" placeholder="Size">
                                                </div>
                                                <div class="mb-5">
                                                    <p class="mb-0 text-base text-black">Color</p>
                                                    <input class="input w-full h-[44px] rounded-md border border-gray6 px-6 text-base" type="text" placeholder="Hex Code Here">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <button class="tp-btn px-10 py-2 mb-2">Save</button>
                                    <button class="tp-btn px-10 py-2 border border-[#dfdfdf] bg-transparent text-black hover:text-white hover:bg-danger hover:border-danger">Cancel</button>
                                </div>
                            </div>
                            <!-- general tab content -->
                            <div class="" x-show="addProductTab === 2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('dashboard.components.js')

    
</body>

<!-- Mirrored from html.hixstudio.net/ebazer/edit-product.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 19 Apr 2025 11:45:34 GMT -->
</html>