<?php

namespace App\Http\Controllers;

use App\Models\AppSettingsModel;
use App\Models\NotificationModel;
use Illuminate\Http\Response;

class NotificationController extends Controller
{
// NOTIFICAÇÃO
    public function notification()
    {

        $app_config = AppSettingsModel::select('logo_url')->first();
        $response = new Response();
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $notification = NotificationModel::where('notify', 1)->first();
        if ($notification) {
            if ($notification->user_destination == null || $notification->user_destination !== session('user')['id']) {
                $notification['icon'] = $app_config->logo_url;
                $response->setContent('data: ' . json_encode($notification) . "\n\n");
                $response->send();

                $notification = NotificationModel::where('notify', 1)->first();
                $notification->notify = 0;
                $notification->save();
            } else {
                $notification = null;
                $response->setContent('data: ' . json_encode($notification) . "\n\n");
                $response->send();

            }
        } else {
            $notification = null;
            $response->setContent('data: ' . json_encode($notification) . "\n\n");
            $response->send();
        }

    }
    public function notification_check($id)
    {
        NotificationModel::find($id)->delete();
        return true;
    }
}
