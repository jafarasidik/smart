<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class KirimNotulensiMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $notulensi;

    /**
     * Create a new message instance.
     */
    public function __construct($notulensi)
    {
        $this->notulensi = $notulensi;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Notulensi Rapat: ' . $this->notulensi->rapat->nama,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.notulensi', // Diarahkan ke file resources/views/emails/notulensi.blade.php
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];

        // Validasi: Jika file di database terisi dan file fisiknya ada di folder public/file/
        if ($this->notulensi->file && file_exists(public_path('file/' . $this->notulensi->file))) {
            $attachments[] = Attachment::fromPath(public_path('file/' . $this->notulensi->file));
        }

        return $attachments;
    }
}
