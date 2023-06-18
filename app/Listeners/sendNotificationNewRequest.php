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
            'request_id' => $response->data['request_id'],
            'title' => $response->data['title'],
            'messege' => $response->data['messege'],
            'size' => $response->data['size'],
            'delivery' => $response->data['delivery'],
            'centervertical' => $response->data['centervertical'],
            'user_destination' => $response->data['user_destination'],
        ];
        NotificationModel::create($notification);
        return true;
    }
}
