<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Confirmation de commande - Braun TN</title>
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Confirmation de commande</h1>
            <p>Merci pour votre commande chez Braun TN</p>
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
            <h3>Informations de livraison:</h3>
            <p><strong>Nom:</strong> {{ $order->name }}</p>
            <p><strong>Email:</strong> {{ $order->email }}</p>
            <p><strong>Téléphone:</strong> {{ $order->phone }}</p>
            <p><strong>Adresse:</strong> {{ $order->address }}</p>
            @if($order->notes)
                <p><strong>Notes:</strong> {{ $order->notes }}</p>
            @endif
        </div>

        <div class="footer">
            <p>Si vous avez des questions concernant votre commande, n'hésitez pas à nous contacter.</p>
            <p>Email: contact@braun.tn</p>
            <p>Téléphone: +216 XX XXX XXX</p>
        </div>
    </div>
</body>
</html> 