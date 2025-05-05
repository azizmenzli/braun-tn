<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * Les attributs assignables en masse.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'regular_price',
        'sale_price',
        'SKU',
        'stock_status',
        'quantity',
        'images',            // JSON d’images supplémentaires
        'category_id',
        'sous_categorie_id',
        'specifications',    // JSON contenant les spécifications (name + icon)
        'additional_links',  // JSON de liens (manuels, vidéos, etc.)
        'status',            // publié ou brouillon
        'type',              // physique, digital, etc.
        'order'              // ordre d’affichage
    ];
    protected $casts = [
        'specifications' => 'array',
        'additional_links' => 'array',
    ];
    /**
     * Relations
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function sousCategorie()
    {
        return $this->belongsTo(Category::class, 'sous_categorie_id');
    }
/*
    public function attribut()
    {
        return $this->belongsTo(Attribut::class, 'attribut_id');
    }
*/
   

    public function images()
    {
        return $this->hasMany(Image::class); // à adapter selon ton modèle Image
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)
                    ->withPivot('quantity', 'price');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)
                    ->withPivot('prix_produit', 'quantite_produit');
        // ou cette ligne selon ce que tu veux :
        // return $this->hasMany(Order::class, 'id_produit');
    }

    /**
     * Accessor utile
     */
    public function isInStock()
    {
        return $this->stock_status === 'instock';
    }
}
