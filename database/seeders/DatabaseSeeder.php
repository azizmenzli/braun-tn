<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@braun.tn',
            'password' => bcrypt('password123'),
            'utype' => 'ADM'
        ]);

        // Create sample categories
        $categories = [
            ['name' => 'Electronics', 'slug' => 'electronics'],
            ['name' => 'Clothing', 'slug' => 'clothing'],
            ['name' => 'Home', 'slug' => 'home']
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create sample products
        $products = [
            [
                'name' => 'Smartphone',
                'slug' => 'smartphone',
                'category_id' => 1,
                'regular_price' => 999.99,
                'sale_price' => 899.99,
                'SKU' => 'SPH001',
                'stock_status' => 'instock',
                'quantity' => 100
            ],
            [
                'name' => 'Laptop',
                'slug' => 'laptop',
                'category_id' => 1,
                'regular_price' => 1499.99,
                'sale_price' => 1299.99,
                'SKU' => 'LPT001',
                'stock_status' => 'instock',
                'quantity' => 50
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        // Create sample orders
        $orders = [
            [
                'red_order' => 'ORD001',
                'nom' => 'John',
                'prenom' => 'Doe',
                'email' => 'john@example.com',
                'telephone' => '123456789',
                'adress' => '123 Main St',
                'sex' => 'male',
                'date_naissance' => '1990-01-01',
                'date_order' => Carbon::now()->subDays(2),
                'id_produit' => 1,
                'prix_produit' => 899.99,
                'quantite_produit' => 1,
                'mode_paiement' => 'carte',
                'source_commande' => 'web',
                'status' => 'delivered'
            ],
            [
                'red_order' => 'ORD002',
                'nom' => 'Jane',
                'prenom' => 'Smith',
                'email' => 'jane@example.com',
                'telephone' => '987654321',
                'adress' => '456 Oak St',
                'sex' => 'female',
                'date_naissance' => '1995-05-15',
                'date_order' => Carbon::now()->subDays(1),
                'id_produit' => 2,
                'prix_produit' => 1299.99,
                'quantite_produit' => 1,
                'mode_paiement' => 'espace',
                'source_commande' => 'web',
                'status' => 'pending'
            ]
        ];

        foreach ($orders as $order) {
            Order::create($order);
        }
    }
}
