<?php

namespace App\Classes;

use App\Models\AppSettingsModel;
use Illuminate\Support\Facades\Config;

class Email
{
    public static function configMailer()
    {
        $smtpSettings = AppSettingsModel::first();
        Config::set('mail.transport', 'smtp');
        Config::set('mail.host', $smtpSettings->mailer_host);
        Config::set('mail.port', $smtpSettings->mailer_port);
        Config::set('mail.encryption', $smtpSettings->mailer_encryption);
        Config::set('mail.username', $smtpSettings->mailer_user);
        Config::set('mail.password', $smtpSettings->mailer_password);
    }
//=============================[fila do despacho]====================================
    // public function reportMail($data)
    // {
    //     Email::configMailer();

    //     Mail::to($data['email'])->send(new reportMail($data));
    // }
//=============================[Info_login]==========================================
    // public function info_login($info){
    //     Mail::to($info['email'])->send(new InfoLoginMail($info));
    // }
    //=============================[Warning]=============================================
    // public function warnings($info){
    //     $users = User::where('notification', 1)->get();
    //         foreach($users as $user){
    //             if (!empty($user->email)) {
    //                 $info['name'] = $user->name;
    //                 Mail::to($user->email)->send(new WarningMail($info));
    //             }
    //         }
    // }
    //=============================[Cmt Request Dispatch]=================================
    // public function cmt_message($info){
    //     $user = User::find($info['user']);
    //         if (!empty($user->email && $user->notification == 1)) {
    //             $info['name'] = $user->name;
    //             Mail::to($user->email)->send(new CmtReqDispatchMail($info));
    //         }
    // }
}
