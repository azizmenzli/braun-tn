<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demande_revendeur extends Model
{
    use HasFactory;
 // Définir le nom exact de la table
 protected $table = 'demande_revendeur';

 protected $fillable = ['name', 'sujet', 'email', 'phone', 'message'];
}