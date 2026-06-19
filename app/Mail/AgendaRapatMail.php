<?php

namespace App\Mail;

use App\Models\Rapat;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AgendaRapatMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $rapat;
    public $namaPeserta;
    public $linkAbsen;

    /**
     * Create a new message instance.
     */
    public function __construct(Rapat $rapat, $namaPeserta, $linkAbsen)
    {
        $this->rapat = $rapat;
        $this->namaPeserta = $namaPeserta;
        $this->linkAbsen = $linkAbsen;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            // Menggunakan nama rapat dinamis pada subjek email
            subject: 'Undangan Rapat: ' . $this->rapat->nama,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.agenda_rapat', // Pastikan file ini ada di resources/views/emails/agenda_rapat.blade.php
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
