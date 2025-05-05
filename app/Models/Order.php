<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'red_order', 'nom', 'prenom', 'email', 'telephone', 'gouvernorat', 'adress',
        'sex', 'date_naissance', 'date_order', 'status', 'id_produit',
        'prix_produit', 'quantite_produit', 'mode_paiement', 'source_commande',
        'ip_client', 'device_client', 'date_shipping', 'code_compagnie'
    ];

    protected $casts = [
        'date_order' => 'datetime',
        'date_naissance' => 'date',
        'prix_produit' => 'decimal:2',
        'date_shipping' => 'datetime',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_produit');
    }
    
 

}