<?php

namespace App\Classes;

use App\Mail\reportMail;
use Illuminate\Support\Facades\Mail;

class Email
{
//=============================[fila do despacho]====================================
    public function reportMail($data)
    {
        Mail::to($data['email'])->send(new reportMail($data));
    }
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
    //=============================[]======================================
    //=============================[]======================================
    //=============================[]======================================
    //=============================[]======================================
    //=============================[]======================================
    //=============================[]======================================
    //=============================[]======================================
    //=============================[]======================================
    //=============================[]======================================
    //=============================[]======================================
    //=============================[]======================================
    //=============================[]======================================
    //=============================[]======================================
    //=============================[]======================================
    //=============================[]======================================
    //=============================[]======================================
    //=============================[]======================================
    //=============================[]======================================
}