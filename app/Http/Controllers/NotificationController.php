<?php

namespace App\Http\Controllers;

use App\Events\notificationNewRequest;

class NotificationController extends Controller
{
// NOTIFICAÇÃO
    public function notification()
    {

        event(new notificationNewRequest('HOPEE'));

        // $response = new Response();
        // $response->headers->set('Content-Type', 'text/event-stream');
        // $response->headers->set('Cache-Control', 'no-cache');

        // $data = [
        //     'notify' => false,
        //     'type' => 'bootbox',
        //     'title' => 'Teste',
        //     'messege' => '1234',
        //     'size' => 'small',
        //     'centervertical' => true,
        // ];

        // $response->setContent('data: ' . json_encode($data) . "\n\n");
        // $response->send();
    }
}
