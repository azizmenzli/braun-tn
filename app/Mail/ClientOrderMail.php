<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ClientOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $orders; // Assurez-vous d'utiliser la variable 'orders' pour stocker les commandes

    /**
     * Create a new message instance.
     */
    public function __construct($orders) // Passez le tableau des commandes ici
    {
        $this->orders = $orders; // Assurez-vous de l'assigner correctement
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Votre commande a été reçue'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email_client_order', // Indiquez la vue correcte pour l'email client
            with: ['orders' => $this->orders] // Passez la variable 'orders' à la vue
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
