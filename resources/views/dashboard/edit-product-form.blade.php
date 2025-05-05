<form id="editProductForm" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Nom du produit</label>
                <input type="text" class="form-control" name="name" value="{{ $product->name }}" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">SKU</label>
                <input type="text" class="form-control" name="sku" value="{{ $product->sku }}" required>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Prix régulier (DT)</label>
                <input type="number" step="0.01" class="form-control" name="regular_price" value="{{ $product->regular_price }}" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Prix promotionnel (DT)</label>
                <input type="number" step="0.01" class="form-control" name="sale_price" value="{{ $product->sale_price }}">
            </div>
        </div>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" name="description" rows="3" required>{{ $product->description }}</textarea>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Catégorie</label>
                <select class="form-control" name="category_id" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Statut</label>
                <select class="form-control" name="status" required>
                    <option value="published" {{ $product->status == 'published' ? 'selected' : '' }}>Publié</option>
                    <option value="draft" {{ $product->status == 'draft' ? 'selected' : '' }}>Brouillon</option>
                </select>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Quantité</label>
                <input type="number" class="form-control" name="quantity" value="{{ $product->quantity }}" required>
            </div>
        </div>
    </div>
    
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </div>
</form>