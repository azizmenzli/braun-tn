<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Constantes pour le mode de paiement
    const MODE_PAIEMENT_ESPECE = 'espece';
    const MODE_PAIEMENT_CARTE = 'carte';

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

    // Méthode pour vérifier si le paiement est par carte
    public function isCardPayment()
    {
        return $this->mode_paiement === self::MODE_PAIEMENT_CARTE;
    }

    // Méthode pour vérifier si le paiement est en espèces
    public function isCashPayment()
    {
        return $this->mode_paiement === self::MODE_PAIEMENT_ESPECE;
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_produit');
    }
}