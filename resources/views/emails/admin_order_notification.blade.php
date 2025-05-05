<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nouvelle commande - Braun TN</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .order-details {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 30px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #666;
            font-size: 14px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Nouvelle commande reçue</h1>
            <p>Une nouvelle commande a été passée sur Braun TN</p>
        </div>

        <div class="order-details">
            <h2>Détails de la commande #{{ $order->id }}</h2>
            <p><strong>Date:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Total:</strong> {{ number_format($order->total, 2) }} DT</p>
            
            <h3>Produits commandés:</h3>
            <ul>
                @foreach($order->products as $product)
                    <li>
                        {{ $product->name }} - 
                        Quantité: {{ $product->pivot->quantity }} - 
                        Prix: {{ number_format($product->price * $product->pivot->quantity, 2) }} DT
                    </li>
                @endforeach
            </ul>
        </div>

        <div>
            <h3>Informations client:</h3>
            <p><strong>Nom:</strong> {{ $order->name }}</p>
            <p><strong>Email:</strong> {{ $order->email }}</p>
            <p><strong>Téléphone:</strong> {{ $order->phone }}</p>
            <p><strong>Adresse:</strong> {{ $order->address }}</p>
            @if($order->notes)
                <p><strong>Notes:</strong> {{ $order->notes }}</p>
            @endif
        </div>

        <div class="text-center">
            <a href="{{ route('dashboard.orders.show', $order->id) }}" class="button">
                Voir la commande dans le dashboard
            </a>
        </div>

        <div class="footer">
            <p>Cette notification a été envoyée automatiquement par le système.</p>
        </div>
    </div>
</body>
</html> 