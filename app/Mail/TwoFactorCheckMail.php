<?php

namespace App\Mail;

use App\Models\AppSettingsModel;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TwoFactorCheckMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public function __construct($values)
    {
        $this->data = $values;
    }
    public function envelope(): Envelope
    {
        $app_settings = AppSettingsModel::first();
        return new Envelope(
            from:new Address($app_settings->mailer_email, $app_settings->establishment_name),
            subject:'Código de verificação',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view:'Mail.two-factor-check',
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
