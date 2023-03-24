<?php

namespace App\Listeners;

use App\Events\notificationNewRequest;
use App\Models\NotificationModel;

class sendNotificationNewRequest
{
    public function handle(notificationNewRequest $response)
    {
        $notification = [
            'notify' => $response->data['notify'],
            'type' => $response->data['type'],
            'title' => $response->data['title'],
            'messege' => $response->data['messege'],
            'size' => $response->data['size'],
            'centervertical' => $response->data['centervertical'],
            'user_destination' => $response->data['user_destination'],
        ];
        NotificationModel::create($notification);
        return true;
    }
}
