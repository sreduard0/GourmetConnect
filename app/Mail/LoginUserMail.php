<?php

namespace App\Mail;

use App\Models\AppSettingsModel;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LoginUserMail extends Mailable
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
            subject:'Login de acesso',
        );}

    public function content(): Content
    {

        return new Content(
            view:'Mail.login-user',
        );
    }
}
