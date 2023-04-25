<?php

namespace App\Classes;

use App\Mail\LoginUserMail;
use App\Mail\TwoFactorCheckMail;
use App\Models\AppSettingsModel;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class Email
{
    //------------------------------------
    // CONFIGURANDO SMTP
    //------------------------------------
    public static function configMailer()
    {
        $smtpSettings = AppSettingsModel::first();
        Config::set('mail.mailers.smtp.transport', 'smtp');
        Config::set('mail.mailers.smtp.host', $smtpSettings->mailer_host);
        Config::set('mail.mailers.smtp.port', $smtpSettings->mailer_port);
        Config::set('mail.mailers.smtp.encryption', $smtpSettings->mailer_encryption);
        Config::set('mail.mailers.smtp.username', $smtpSettings->mailer_email);
        Config::set('mail.mailers.smtp.password', Tools::hash($smtpSettings->mailer_password, 'decrypt'));
    }
    //------------------------------------
    // ENVIANDO E-MAIL
    //------------------------------------
    // ENVIO DE LOGIN E SENHA PARA USUÁRIO DO APP
    public static function LoginUser($data, $email)
    {
        Email::configMailer();
        Mail::to($email)->send(new LoginUserMail($data));
    }
    // ENVIO DE LOGIN E SENHA PARA USUÁRIO DO APP
    public static function TwoFactorCheck($data, $email)
    {
        Email::configMailer();
        Mail::to($email)->send(new TwoFactorCheckMail($data));
    }
}
