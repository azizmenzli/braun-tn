<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from html.hixstudio.net/ebazer/category.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 19 Apr 2025 11:45:34 GMT -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Braun - Categories</title>
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

    <!--  -->
    <div class="tp-main-wrapper bg-slate-100 h-screen" x-data="{ sideMenu: false }">
        @include('dashboard.components.sideleft')

        <div class="fixed top-0 left-0 w-full h-full z-40 bg-black/70 transition-all duration-300" :class="sideMenu ? 'visible opacity-1' : '  invisible opacity-0 '" x-on:click="sideMenu = ! sideMenu"> </div>

        <div class="tp-main-content lg:ml-[250px] xl:ml-[300px] w-[calc(100% - 300px)]"  x-data="{ searchOverlay: false }">

            @include('dashboard.components.header')

            <div class="body-content px-8 py-8 bg-slate-100">
                <div class="grid grid-cols-12">
                    <div class="col-span-10">
                        <div class="flex justify-between mb-10 items-end">
                            <div class="page-title">
                                <h3 class="mb-0 text-[28px]">Catégorie</h3>
                                <ul class="text-tiny font-medium flex items-center space-x-3 text-text3">
                                    <li class="breadcrumb-item text-muted">
                                        <a href="product-list.html" class="text-hover-primary"> Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item flex items-center">
                                        <span class="inline-block bg-text3/60 w-[4px] h-[4px] rounded-full"></span>
                                    </li>
                                    <li class="breadcrumb-item text-muted">Catégorie</li> 
                                    <li class="breadcrumb-item flex items-center">
                                        <span class="inline-block bg-text3/60 w-[4px] h-[4px] rounded-full"></span>
                                    </li>
                                    <li class="breadcrumb-item text-muted"> Nouveau Categorie</li> 
                                   
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!--  -->
                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12 lg:col-span-4">
                        <div class="mb-6 bg-white px-8 py-8 rounded-md">
                            @if(session('success'))
                            <div class="alert alert-success mb-4 p-4 rounded-md bg-green-100 border border-green-200 text-green-700">
                                {{ session('success') }}
                            </div>
                        @endif
                        
                        @if(session('error'))
                            <div class="alert alert-danger mb-4 p-4 rounded-md bg-red-100 border border-red-200 text-red-700">
                                {{ session('error') }}
                            </div>
                        @endif
                            <form action="{{ route('dashboard.categories.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                
                                 <!--<div class="mb-4">
                                    <label class="block mb-2 text-base text-black">Category Image</label>
                                    <div class="text-center mb-2">
                                        <img id="imagePreview" class="w-[100px] h-auto mx-auto" src="{{ asset('assets/img/icons/upload.png') }}" alt="">
                                    </div>
                                    <span class="text-tiny text-center w-full inline-block mb-3">Image size must be less than 2Mb</span>
                                    <input type="file" name="image" id="categoryImage" class="hidden" accept="image/png, image/jpeg">
                                    <button type="button" onclick="document.getElementById('categoryImage').click()" 
                                            class="w-full py-2 px-4 bg-gray-100 rounded-md hover:bg-gray-200">
                                        Upload Image
                                    </button>
                                    @error('image') 
                                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                                    @enderror
                                </div>-->
                                
                                <div class="mb-4">
                                    <label class="block mb-2 text-base text-black">Nom de la catégorie</label>
                                    <input id="categoryName" name="name" value="{{ old('name') }}"
       class="input w-full h-[44px] rounded-md border border-gray6 px-6 text-base"
       type="text" placeholder="Nom de la catégorie" required>
                                    @error('name') 
                                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label class="block mb-2 text-base text-black">Slug</label>
                                    <input id="categorySlug" name="slug" value="{{ old('slug') }}"
       class="input w-full h-[44px] rounded-md border border-gray6 px-6 text-base"
       type="text" placeholder="Slug" required>
                                    @error('slug') 
                                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label class="block mb-2 text-base text-black">Parent Category (optional)</label>
                                    <select name="parent_id" class="w-full h-[44px] rounded-md border border-gray6 px-4">
                                        <option value="">Aucune catégorie parente</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('parent_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('parent_id') 
                                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                                    @enderror
                                </div>
                                
                                <button type="submit" class="tp-btn px-7 py-2 bg-blue-500 text-white hover:bg-blue-600">
                                    Enregistrer
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="col-span-12 lg:col-span-8">
                        <div class="bg-white px-8 py-4 rounded-md">
                            <div class="overflow-x-auto">
                                <table class="w-full text-base text-left text-gray-500">
                                    <thead class="bg-gray-50">
                                        <tr class="border-b border-gray6 text-tiny">
                                            <th class="py-3 text-tiny text-text2 uppercase font-semibold">ID</th>
                                            <th class="px-3 py-3 text-tiny text-text2 uppercase font-semibold">Name</th>
                                           <!-- <th class="px-3 py-3 text-tiny text-text2 uppercase font-semibold">Image</th>
                                           --> <th class="px-3 py-3 text-tiny text-text2 uppercase font-semibold">Slug</th>
                                            <th class="px-3 py-3 text-tiny text-text2 uppercase font-semibold">Parent</th>
                                            <th class="px-3 py-3 text-tiny text-text2 uppercase font-semibold">Produits</th>
                                            <th class="px-3 py-3 text-tiny text-text2 uppercase font-semibold text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($categories as $category)
                                        <tr class="bg-white border-b border-gray6 last:border-0">
                                            <td class="px-3 py-4 font-normal text-[#55585B]">#{{ $category->id }}</td>
                                            <td class="pr-8 py-4 whitespace-nowrap">
                                                <span class="font-medium text-heading">{{ $category->name }}</span>
                                            </td>
                                           <!-- <td class="px-3 py-4">
                                                <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="w-10 h-10 rounded-full">
                                            </td>-->
                                            <td class="px-3 py-4 font-normal text-[#55585B]">{{ $category->slug }}</td>
                                            <td class="px-3 py-4 font-normal text-[#55585B]">
                                                {{ $category->parent ? $category->parent->name : '-' }}
                                            </td>
                                            <td class="px-3 py-4 font-normal text-[#55585B]">
                                                {{ $category->products_count }}
                                            </td>
                                            <td class="px-3 py-4 text-end">
                                                <div class="flex items-center justify-end space-x-2">
                                                    <button data-modal-target="editCategoryModal-{{ $category->id }}" 
                                                        data-modal-toggle="editCategoryModal-{{ $category->id }}"
                                                        class="w-10 h-10 leading-10 text-tiny bg-success text-white rounded-md hover:bg-green-600">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                    
                                                    <form action="{{ route('dashboard.categories.destroy', $category->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="w-10 h-10 leading-[33px] text-tiny bg-white border border-gray text-slate-600 rounded-md hover:bg-danger hover:border-danger hover:text-white"
                                                                onclick="return confirm('Are you sure you want to delete this category?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                    <div id="editCategoryModal-{{ $category->id }}" tabindex="-1" aria-hidden="true"
                                                        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto h-[100vh] bg-black bg-opacity-40 flex items-center justify-center">
                                                       <div class="bg-white w-full max-w-lg rounded-lg shadow p-6 relative">
                                                           <button type="button" class="absolute top-3 right-3 text-gray-500 hover:text-gray-900" data-modal-hide="editCategoryModal-{{ $category->id }}">
                                                               <i class="fas fa-times"></i>
                                                           </button>
                                           
                                                           <form action="{{ route('dashboard.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                                                               @csrf
                                                               @method('PUT')
                                           
                                                               <div class="mb-4 text-center">
                                                                   <img id="imagePreview{{ $category->id }}" class="w-[100px] h-auto mx-auto mb-2"
                                                                        src="{{ $category->image_url ?? asset('assets/img/icons/upload.png') }}" alt="">
                                                                   <input type="file" name="image" id="categoryImage{{ $category->id }}" class="hidden" accept="image/png, image/jpeg">
                                                                   <button type="button" onclick="document.getElementById('categoryImage{{ $category->id }}').click()"
                                                                           class="w-full py-2 px-4 bg-gray-100 rounded-md hover:bg-gray-200">
                                                                       Upload Image
                                                                   </button>
                                                                   @error('image') 
                                                                       <span class="text-red-500 text-sm">{{ $message }}</span> 
                                                                   @enderror
                                                               </div>
                                           
                                                               <div class="mb-4">
                                                                   <label class="block mb-1 text-base text-black">Nom de la catégorie</label>
                                                                   <input name="name" value="{{ $category->name }}"
                                                                       class="input w-full h-[44px] rounded-md border border-gray6 px-4 text-base"
                                                                       type="text" required>
                                                               </div>
                                           
                                                               <div class="mb-4">
                                                                   <label class="block mb-1 text-base text-black">Slug</label>
                                                                   <input name="slug" value="{{ $category->slug }}"
                                                                       class="input w-full h-[44px] rounded-md border border-gray6 px-4 text-base"
                                                                       type="text" required>
                                                               </div>
                                           
                                                               <div class="mb-4">
                                                                   <label class="block mb-1 text-base text-black">Catégorie parente</label>
                                                                   <select name="parent_id" class="w-full h-[44px] rounded-md border border-gray6 px-4">
                                                                       <option value="">Aucune</option>
                                                                       @foreach($categories as $cat)
                                                                           @if($cat->id != $category->id)
                                                                               <option value="{{ $cat->id }}" {{ $category->parent_id == $cat->id ? 'selected' : '' }}>
                                                                                   {{ $cat->name }}
                                                                               </option>
                                                                           @endif
                                                                       @endforeach
                                                                   </select>
                                                               </div>
                                           
                                                               <button type="submit" class="tp-btn px-7 py-2 bg-blue-500 text-white hover:bg-blue-600 w-full mt-2">
                                                                   Mettre à jour
                                                               </button>
                                                           </form>
                                                       </div>
                                                   </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!--
                            <div class="flex justify-between items-center mt-4">
                                <div>
                                    Affichage {{ $categories->firstItem() }} to {{ $categories->lastItem() }} de {{ $categories->total() }} categories
                                </div>
                                <div class="pagination py-3 flex justify-end items-center">
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

                        -->
                        </div>
                    </div>
                </div>
                
                <script>
                    // Image preview functionality
                    document.getElementById('categoryImage').addEventListener('change', function(e) {
                        const file = e.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(event) {
                                document.getElementById('imagePreview').src = event.target.result;
                            };
                            reader.readAsDataURL(file);
                        }
                    });
                </script>

<script>
    function generateSlug(text) {
        return text
            .toLowerCase()
            .trim()
            .replace(/[\s\W-]+/g, '-') // remplace espaces et caractères spéciaux par des tirets
            .replace(/^-+|-+$/g, '');  // supprime les tirets au début/fin
    }

    document.getElementById('categoryName').addEventListener('input', function () {
        const nameValue = this.value;
        const slugValue = generateSlug(nameValue);
        document.getElementById('categorySlug').value = slugValue;
    });
</script>

            </div>
        </div>
    </div>

       @include('dashboard.components.js')

    
</body>

<!-- Mirrored from html.hixstudio.net/ebazer/category.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 19 Apr 2025 11:45:34 GMT -->
</html>