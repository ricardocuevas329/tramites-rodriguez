<?php

namespace App\Mail;

use App\Models\External\Protocolar\TramiteKardexExternalDocument;
use App\Models\Protocolar\Kardex;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Headers;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class SendKardexEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public $client,
    )
    {

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
           from: new Address("admin@noreply.com", "Admin"),
           /*  replyTo: [
                new Address($this->destinatarios[0], "Test Name"),
            ],*/
            subject: 'Nuevo Trámite',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.registerkardex',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
       // return [];
        return [];
    }
}
