<?php

namespace App\Listeners;

use App\Events\notificationNewRequest;

class sendNotificationNewRequest
{
    public function handle(notificationNewRequest $data)
    {
        echo $data . "send";
    }
}
