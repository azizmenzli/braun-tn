 
function previewImage(input) {
  const file = input.files[0];
  if (file) {
    const reader = new FileReader();
    const img = input.nextElementSibling;

    reader.onload = function (e) {
      img.src = e.target.result;
      img.classList.remove("hidden");
    };
    reader.readAsDataURL(file);
  }
}
 
 
// Auto-generate slug from product name
document.querySelector('input[name="name"]').addEventListener('input', function() {
    const slugInput = document.querySelector('input[name="slug"]');
    const name = this.value.trim().toLowerCase();
    const slug = name.replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
    slugInput.value = slug;
});

// SKU validation
document.getElementById('sku-input').addEventListener('blur', function() {
    const sku = this.value;
    if (sku) {
        fetch("{{ route('dashboard.validate.sku') }}", {
method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ SKU: sku })
        })
        .then(response => response.json())
        .then(data => {
            const messageElement = document.getElementById('sku-validation-message');
            if (data.valid) {
                messageElement.textContent = 'SKU disponible';
                messageElement.className = 'text-tiny text-green-500';
            } else {
                messageElement.textContent = 'SKU déjà utilisé';
                messageElement.className = 'text-tiny text-red-500';
            }
        });
    }
});

// Image preview
document.getElementById('product-image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            document.getElementById('image-preview').src = event.target.result;
        };
        reader.readAsDataURL(file);
    }
});

// Gallery images preview
document.getElementById('product-gallery').addEventListener('change', function(e) {
    const files = e.target.files;
    const galleryPreview = document.getElementById('gallery-preview');
    galleryPreview.innerHTML = '';
    
    for (let i = 0; i < files.length; i++) {
        const reader = new FileReader();
        reader.onload = function(event) {
            const img = document.createElement('img');
            img.src = event.target.result;
            img.className = 'w-full h-auto rounded-md';
            galleryPreview.appendChild(img);
        };
        reader.readAsDataURL(files[i]);
    }
});

// Load subcategories when main category changes
document.getElementById('category-select').addEventListener('change', function() {
    const categoryId = this.value;
    const subcategorySelect = document.getElementById('subcategory-select');
    
    subcategorySelect.innerHTML = '<option value="">Sélectionnez une sous-catégorie</option>';
    
    if (categoryId) {
        fetch(`/dashbaord/categories/${categoryId}/subcategories`)
            .then(response => response.json())
            .then(data => {
                data.forEach(subcategory => {
                    const option = document.createElement('option');
                    option.value = subcategory.id;
                    option.textContent = subcategory.name;
                    subcategorySelect.appendChild(option);
                });
            });
    }
});

// Load attribute values when attribute changes
document.getElementById('attribut-select').addEventListener('change', function() {
    const attributId = this.value;
    const valuesContainer = document.getElementById('attribute-values-container');
    
    valuesContainer.innerHTML = '';
    
    if (attributId) {
        fetch(`/admin/attributs/${attributId}/values`)
            .then(response => response.json())
            .then(data => {
                data.values.forEach(value => {
                    const div = document.createElement('div');
                    div.className = 'flex items-center';
                    
                    const input = document.createElement('input');
                    input.type = 'checkbox';
                    input.name = 'value_attribut[]';
                    input.value = value;
                    input.id = `value-${value}`;
                    input.className = 'mr-2';
                    
                    const label = document.createElement('label');
                    label.htmlFor = `value-${value}`;
                    label.textContent = value;
                    
                    div.appendChild(input);
                    div.appendChild(label);
                    valuesContainer.appendChild(div);
                });
            });
    }
});
 





function isImage(url) {
  return /\.(jpeg|jpg|gif|png|webp|svg|bmp)$/i.test(url);
}

function displayLinks(value) {
  const container = document.getElementById('links-preview');
  container.innerHTML = ''; // reset

  const links = value.split(',').map(link => link.trim()).filter(link => link.length > 0);

  links.forEach(link => {
    const href = link.startsWith('http') ? link : `https://${link}`;

    if (isImage(href)) {
      // Si c'est une image
      const img = document.createElement('img');
      img.src = href;
      img.alt = "Image prévisualisée";
      img.className = "max-w-[200px] rounded-md border border-gray-300 shadow";
      container.appendChild(img);
    } else {
      // Sinon c'est un lien classique
      const a = document.createElement('a');
      a.href = href;
      a.target = '_blank';
      a.rel = 'noopener noreferrer';
      a.className = "text-blue-600 hover:underline block";
      a.textContent = href;
      container.appendChild(a);
    }
  });
}
 


//prix


 
    document.addEventListener('DOMContentLoaded', function () {
        const regularInput = document.querySelector('input[name="regular_price"]');
        const saleInput = document.querySelector('input[name="sale_price"]');

        function validatePrices() {
            const regular = parseFloat(regularInput.value);
            const sale = parseFloat(saleInput.value);

            if (!isNaN(regular) && !isNaN(sale)) {
                if (sale >= regular) {
                    saleInput.setCustomValidity("Le prix promo doit être inférieur au prix régulier.");
                } else {
                    saleInput.setCustomValidity("");
                }
            } else {
                saleInput.setCustomValidity("");
            }
        }

        regularInput.addEventListener('input', validatePrices);
        saleInput.addEventListener('input', validatePrices);
    });
 
