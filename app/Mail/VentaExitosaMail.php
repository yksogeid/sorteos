<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Venta;

class VentaExitosaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $venta;
    public $tickets;

    public function __construct(Venta $venta, $tickets)
    {
        $this->venta = $venta;
        $this->tickets = $tickets;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmación de Compra - Gana con Kelvin',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.venta_exitosa',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
