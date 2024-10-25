<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MailTextoSimple extends Mailable
{
    use Queueable, SerializesModels;

    public $mensaje;
    public $asunto;

    public function __construct($mensaje, $asunto)
    {
        $this->mensaje = $mensaje;
        $this->asunto = $asunto;
    }

    public function build()
    {
        return $this->text('emails.plantilla_vacia')
                    ->subject($this->asunto)
                    ->with(['mensaje' => $this->mensaje]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Mail Texto Simple',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
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
