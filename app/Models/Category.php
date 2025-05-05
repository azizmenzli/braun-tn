<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'image', 'parent_id'];

    // Relation pour obtenir les sous-catégories (catégories enfants)
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Relation pour obtenir la catégorie parente
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function products()
{
    return $this->hasMany(Product::class);
} 

public function subCategories()
{
    return $this->hasMany(Category::class, 'parent_id');
    return $this->belongsTo(SubCategory::class);

}

 
  
}
