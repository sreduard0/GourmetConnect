<?php

namespace App\Http\Controllers;

use App\Classes\Tools;
use App\Models\AppSettingsModel;
use App\Models\NotificationModel;
use App\Models\RequestsItemsModel;
use App\Models\RequestsModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NotificationController extends Controller
{
// FERRAMENTAS
    private $Tools;
    public function __construct()
    {
        $this->Tools = new Tools;
    }
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
    public function new_request_notification(Request $request)
    {
        $requests = RequestsItemsModel::with('product', 'additionals')->where('request_id', $this->Tools->hash($request->get('id'), 'decrypt'))->where('status', 2)->orderBy('product_id', 'desc')->get();
        $items = [];
        foreach ($requests as $item) {

            if ($item->additionals != '[]' || $item->observation) {
                $items[] = [
                    'name' => $item->product->name,
                    'additionals' => $item->additionals,
                    'observation' => $item->observation,
                    'amount' => '1',
                ];

            } else {
                if (isset($count[$item->product->id])) {
                    $count[$item->product->id]++;
                } else {
                    $count[$item->product->id] = 1;
                }

                $items[$item->product->id . 'item'] = [
                    'name' => $item->product->name,
                    'additionals' => [],
                    'observation' => '',
                    'amount' => $count[$item->product->id],
                ];
            }
        }

        $data = [
            'items' => $items,
            'command' => RequestsModel::find($this->Tools->hash($request->get('id'), 'decrypt')),

        ];
        return json_encode($data);
    }
    public function notification_check($id)
    {
        NotificationModel::find($id)->delete();
        return true;
    }
}
