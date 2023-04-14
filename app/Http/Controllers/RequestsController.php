<?php

namespace App\Http\Controllers;

use App\Classes\Tools;
use App\Events\notificationNewRequest;
use App\Models\AdditionalItemModel;
use App\Models\DeliveryAddressModel;
use App\Models\ItemModel;
use App\Models\PaymentMethodsModel;
use App\Models\RequestAdditionalItemModal;
use App\Models\RequestsItemsModel;
use App\Models\RequestsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequestsController extends Controller
{
// FERRAMENTAS
    private $Tools;
    public function __construct()
    {
        $this->Tools = new Tools;
    }
// PEDIDO DO CLIENTE
    public function add_item_request(Request $request)
    {
        $data = $request->all();
        if (isset($data['client_id'])) {
            $request = RequestsModel::select('id')->where('id', $this->Tools->hash($data['client_id'], 'decrypt'))->where('status', 1)->first();
        } else {
            $request = RequestsModel::select('id')->where('table', $data['table'])->where('client_name', $data['client'])->where('status', 1)->first();
        }
        $product = ItemModel::select('value')->find($this->Tools->hash($data['item'], 'decrypt'));

        for ($i = 1; $i <= $data['amount']; $i++) {
            $requestItems[] = [
                'request_id' => $request->id,
                'product_id' => $this->Tools->hash($data['item'], 'decrypt'),
                'status' => 1,
                'value' => $product->value,
                'waiter' => session('user')['name'],
            ];
        }
        if (isset($requestItems)) {
            RequestsItemsModel::insert($requestItems);
        }
        return 'success';
    }
    public function send_item_request(Request $request)
    {
        $data = $request->all();
        if (isset($data['client_id'])) {
            $request = RequestsModel::select('id')->where('id', $this->Tools->hash($data['client_id'], 'decrypt'))->where('status', 1)->first();
        } else {
            $request = RequestsModel::select('id')->where('table', $data['table'])->where('client_name', strtoupper($data['client']))->where('status', 1)->first();
        }
        if (RequestsItemsModel::where('request_id', $request->id)->where('status', 1)->update(['waiter' => session('user')['name'], 'status' => 2])) {
            if (!isset($data['client_id'])) {
                event(new notificationNewRequest([
                    'notify' => 1,
                    'type' => 'bootbox',
                    'title' => 'NOVO PEDIDO',
                    'request_id' => $this->Tools->hash($request->id, 'encrypt'),
                    'messege' => 'Há um novo pedido na MESA #' . $data['table'] . ' para ' . strtoupper($data['client']),
                    'size' => 'large',
                    'centervertical' => 1,
                    'user_destination' => session('user')['id'],
                ]));
            }

            return 'success';
        } else {
            return 'not-send';
        }
    }
    public function delete_item_request(Request $request)
    {
        $data = $request->all();
        if (RequestsItemsModel::where('id', $this->Tools->hash($data['item'], 'decrypt'))->delete()) {
            return 'success';
        } else {
            return 'not-delete';
        }
    }
    public function additionals_items_request(Request $request)
    {
        $data = $request->all();
        $itemsCheck = RequestAdditionalItemModal::where('item_id', $this->Tools->hash($data['request_id'], 'decrypt'))->get();
        $items = AdditionalItemModel::where('item_id', $this->Tools->hash($data['item'], 'decrypt'))->get();
        $item = RequestsItemsModel::select('observation', 'value')->find($this->Tools->hash($data['request_id'], 'decrypt'));

        $additionalItems['observation'] = $item->observation;
        $additionalItems['items'] = [];
        foreach ($items as $item) {
            if ($item->status == 1) {
                $additionalItems['items'][$item->id] = [
                    'id' => $item->id,
                    'name' => $item->name,
                    'value' => $item->value,
                    'check' => '',
                ];
            }
            foreach ($itemsCheck as $itemCheck) {
                if ($item->id === $itemCheck->additional_id) {
                    $additionalItems['items'][$item->id] = [
                        'id' => $item->id,
                        'name' => $item->name,
                        'value' => $item->value,
                        'check' => 'checked',
                    ];
                }
            }
        }
        return $additionalItems;
    }
    public function save_obs_item_request(Request $request)
    {
        $inputs = $request->all();
        if (isset($inputs['additionals'])) {
            foreach ($inputs['additionals'] as $input) {
                if ($input['check'] == 'true') {
                    $additional = AdditionalItemModel::select('value')->find($input['id']);
                    $additionals = [
                        'additional_id' => $input['id'],
                        'item_id' => $this->Tools->hash($inputs['id'], 'decrypt'),
                        'value' => $additional->value,
                    ];
                    RequestAdditionalItemModal::updateOrCreate(['additional_id' => $input['id'], 'item_id' => $this->Tools->hash($inputs['id'], 'decrypt')], $additionals);
                } else {
                    RequestAdditionalItemModal::where('additional_id', $input['id'])->where('item_id', $this->Tools->hash($inputs['id'], 'decrypt'))->delete();
                }
            }
        }
        $observation = RequestsItemsModel::find($this->Tools->hash($inputs['id'], 'decrypt'));
        $observation->observation = $inputs['obs'];
        $observation->value = $this->Tools->sum_values_item_number($this->Tools->hash($inputs['id'], 'decrypt'));
        $observation->save();
        return 'success';

    }
    public function print_request(Request $request)
    {
        if ($request->get('id') != 'all') {
            $command = RequestsModel::with('address')->find($this->Tools->hash($request->get('id'), 'decrypt'));
            $requests = RequestsItemsModel::where('request_id', $this->Tools->hash($request->get('id'), 'decrypt'))->where('status', 2)->orderBy('product_id', 'asc')->get();

            if ($command && count($requests) > 0) {
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
                    'command' => $command,
                    'requests' => $items,
                ];
                return view('app.component.cupom-request', $data);
            } else {
                return 'not-exists';
            }
        } else {
            if ($request->get('delivery') == 1) {
                $commands = RequestsModel::with('address')->where('status', 1)->where('delivery', 1)->get();
            } else {
                $commands = RequestsModel::where('status', 1)->where('delivery', 0)->get();
            }
            $items = [];
            foreach ($commands as $command) {
                $requests = RequestsItemsModel::where('request_id', $command->id)->where('status', 2)->orderBy('product_id', 'asc')->get();
                if (count($requests) > 0) {
                    $items[$command->id] = [];
                    $items[$command->id]['command'] = $command;
                    foreach ($requests as $item) {
                        if ($item->additionals != '[]' || $item->observation) {
                            $items[$command->id][] = [
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
                            $items[$command->id][$item->product->id . 'item'] = [
                                'name' => $item->product->name,
                                'additionals' => [],
                                'observation' => '',
                                'amount' => $count[$item->product->id],
                            ];
                        }
                    }
                }
            }

            if (count($items) > 0) {
                $data = [
                    'requests' => $items,
                ];
                return view('app.component.cupom-request', $data);
            } else {
                return 'not-exists';
            }

        }
    }
    public function delete_request(Request $request)
    {
        DeliveryAddressModel::where('request_id', $this->Tools->hash($request->get('id'), 'decrypt'))->delete();
        RequestsItemsModel::where('request_id', $this->Tools->hash($request->get('id'), 'decrypt'))->delete();
        RequestsModel::find($this->Tools->hash($request->get('id'), 'decrypt'))->delete();
    }
    public function print_confirm(Request $request)
    {
        if ($request->get('id') != 'all') {
            RequestsItemsModel::where('request_id', $this->Tools->hash($request->get('id'), 'decrypt'))->where('status', 2)->update(['status' => 3]);
            RequestsModel::where('id', $this->Tools->hash($request->get('id'), 'decrypt'))->where('delivery', 1)->update(['status' => 2]);
        } else {
            RequestsItemsModel::where('status', 2)->update(['status' => 3]);
            RequestsModel::where('id', $this->Tools->hash($request->get('id'), 'decrypt'))->where('delivery', 1)->update(['status' => 2]);
        }
    }
    public function sum_requests_client(Request $request)
    {
        $location = DeliveryAddressModel::where('request_id', $this->Tools->hash($request->get('id'), 'decrypt'))->first();
        if ($location) {
            return $this->Tools->sum_values_requests($this->Tools->hash($request->get('id'), 'decrypt'), $location->delivery_value);
        } else {
            return $this->Tools->sum_values_requests($this->Tools->hash($request->get('id'), 'decrypt'));
        }
    }
// INFORMAÇÕES DO PEDIDO
    public function client_table(Request $request)
    {
        $table = $request->all();
        $requests = RequestsModel::select('client_name')->where('table', $table['number'])->where('status', 1)->where('delivery', 0)->get();
        $clients = [];
        foreach ($requests as $client) {
            $clients[] = $client->client_name;
        }
        return $clients;
    }
    public function requests_client_view(Request $request)
    {
        $id = $request->get('id');

        $requestData = RequestsModel::find($this->Tools->hash($id, 'decrypt'));
        $requestItems = RequestsItemsModel::where('request_id', $this->Tools->hash($id, 'decrypt'))->where('status', 2)->exists();
        $data = [
            'table' => $requestData->table,
            'client' => $requestData->client_name,
            'total' => $this->Tools->sum_values_requests($this->Tools->hash($id, 'decrypt')),
            'pending' => $requestItems,
        ];
        return $data;
    }
    public function request_finish($id)
    {
        if (RequestsModel::find($this->Tools->hash($id, 'decrypt'))) {
            return 'true';
        }
    }
    public function view_item_request(Request $request)
    {
        $data = RequestsItemsModel::with('product', 'additionals')->find($this->Tools->hash($request->get('id'), 'decrypt'));
        $data->value = $this->Tools->sum_values_item($this->Tools->hash($request->get('id'), 'decrypt'));
        return $data;
    }
// PAGAMENTO
    public function finalize_payment(Request $request)
    {
        $data = $request->all();

        // ENVIA DADOS PARA A RECEITA
        // RETORNA SE DEU CERTO

        // FINALIZA ITENS NO SISTEMA
        //  PAGAMENTO DIVIDIDO
        if ($data['split_payment']['active'] == 'true') {
            RequestsItemsModel::whereIn('id', $data['split_payment']['items'])->update(['status' => 4, 'payment_method' => $data['method']]);
            if (RequestsItemsModel::where('request_id', $this->Tools->hash($data['id'], 'decrypt'))->where('status', 3)->count() < 1) {
                RequestsModel::find($this->Tools->hash($data['id'], 'decrypt'))->update(['status' => 2]);
                RequestsItemsModel::where('request_id', $this->Tools->hash($data['id'], 'decrypt'))->where('status', 2)->delete();
            }

            return 'split_success';
        } else {
            if (RequestsItemsModel::where('request_id', $this->Tools->hash($data['id'], 'decrypt'))->where('status', 3)->update(['status' => 4, 'payment_method' => $data['method']])) {
                RequestsModel::find($this->Tools->hash($data['id'], 'decrypt'))->update(['status' => 2]);
                RequestsItemsModel::where('request_id', $this->Tools->hash($data['id'], 'decrypt'))->where('status', 2)->delete();
            }
            return 'success';

        }
    }
    public function tax_coupon(Request $request)
    {
        $data = $request->all();

        if ($data['split_payment']['active'] == 'true') {
            $requests = RequestsItemsModel::with('additionals')->whereIn('id', $data['split_payment']['items'])->where('status', 4)->where('print', null)->orderBy('product_id', 'asc')->get();
            RequestsItemsModel::whereIn('id', $data['split_payment']['items'])->where('status', 4)->where('print', null)->update(['print' => 1]);
        } else {
            $requests = RequestsItemsModel::with('additionals')->where('request_id', $this->Tools->hash($data['id'], 'decrypt'))->where('status', 4)->where('print', null)->orderBy('product_id', 'asc')->get();
            RequestsItemsModel::where('request_id', $this->Tools->hash($data['id'], 'decrypt'))->where('status', 4)->where('print', null)->update(['print' => 1]);
        }

        if ($data['action'] == 'not') {
            return false;
        }

        $method = PaymentMethodsModel::select('name')->find($data['method']);
        $items = [];
        foreach ($requests as $item) {
            if (isset($total)) {
                $total += $this->Tools->sum_values_item_number($item->id);
            } else {
                $total = $this->Tools->sum_values_item_number($item->id);
            }
            if ($item->additionals != '[]' || $item->observation) {
                $items[] = [
                    'name' => $item->product->name,
                    'val_un' => 'R$' . number_format($item->product->value, 2, ',', '.'),
                    'val_total' => 'R$' . number_format($item->product->value, 2, ',', '.'),
                    'additionals' => $item->additionals,
                    'amount' => '1',
                ];

            } else {
                if (isset($count[$item->product->id])) {
                    $count[$item->product->id]++;
                } else {
                    $count[$item->product->id] = 1;
                }
                if (isset($sum[$item->product->id])) {
                    $sum[$item->product->id] += $item->product->value;
                } else {
                    $sum[$item->product->id] = $item->product->value;
                }

                $items[$item->product->id . 'item'] = [
                    'name' => $item->product->name,
                    'val_un' => 'R$' . number_format($item->product->value, 2, ',', '.'),
                    'val_total' => 'R$' . number_format($sum[$item->product->id], 2, ',', '.'),
                    'additionals' => [],
                    'amount' => $count[$item->product->id],
                ];
            }
        }
        $response = [
            'command' => RequestsModel::find($this->Tools->hash($data['id'], 'decrypt')),
            'items' => $items,
            'total' => 'R$' . number_format($total, 2, ',', '.'),
            'method' => $method,

        ];

        switch ($data['action']) {
            case 'email':
                # code...
                break;
            case 'whatsapp':
                # code...
                break;
            case 'print':
                return view('app.component.non-tax-coupon', $response);
                break;
        }
    }
// TABELAS
    public function request_client_table(Request $request)
    {
        $requestData = $request->all();
        $columns = array(
            0 => 'id',
            1 => 'product_id',
            2 => 'value',
            3 => 'status',
            4 => 'id',
        );

        if ($requestData['columns'][1]['search']['value'] && $requestData['columns'][2]['search']['value']) {
            $request = RequestsModel::where('table', $requestData['columns'][1]['search']['value'])
                ->where('client_name', $requestData['columns'][2]['search']['value'])
                ->where('status', 1)->first();
            if (empty($request)) {
                $request = new RequestsModel();
                $request->table = $requestData['columns'][1]['search']['value'];
                $request->client_name = $requestData['columns'][2]['search']['value'];
                $request->status = 1;
                $request->save();
            }

            $items = RequestsItemsModel::with('product')->where('request_id', $request->id)->where('status', 1)->orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'])
                ->offset($requestData['start'])
                ->take($requestData['length'])
                ->get();

            $rows = RequestsItemsModel::where('request_id', $request->id)->where('status', 1)->count();

        } else {
            $items = array();
            $rows = 0;
        }

        $filtered = count($items);
        $dados = array();

        foreach ($items as $item) {
            $dado = array();
            $dado[] = '<img class="img-circle" src="' . asset($item->product->photo_url) . '" alt="" width="35">';
            $dado[] = $item->product->name;
            $dado[] = $this->Tools->sum_values_item($item->id);
            $dado[] = '<button onclick="return additional_item_request(\'' . $this->Tools->hash($item->product_id, 'encrypt') . '\',\'' . $this->Tools->hash($item->id, 'encrypt') . '\')" class="btn btn-sm btn-primary" ><i class="fa-solid fa-pen"></i></button> <button onclick="return  delete_item_request(\'' . $this->Tools->hash($item->id, 'encrypt') . '\')" class="btn btn-sm btn-danger m-t-3"><i class="fa-solid fa-trash"></i></button>';
            // $dado[] = $item->description;'R$' . number_format($item->value, 2, ',', '.')
            $dados[] = $dado;
        }

        //Cria o array de informações a serem retornadas para o Javascript
        $json_data = array(
            "draw" => intval($requestData['draw']), //para cada requisição é enviado um número como parâmetro
            "recordsTotal" => intval($filtered), //Quantidade de registros que há no banco de dados
            "recordsFiltered" => intval($rows), //Total de registros quando houver pesquisa
            "data" => $dados, //Array de dados completo dos dados retornados da tabela
        );

        return json_encode($json_data); //enviar dados como formato json
    }
    public function split_payment_table(Request $request)
    {
        $requestData = $request->all();
        $columns = array(
            0 => 'id',
            1 => 'product_id',
            2 => 'value',
            3 => 'id',
        );

        if ($requestData['columns'][1]['search']['value']) {
            $items = RequestsItemsModel::with('product')->where('request_id', $this->Tools->hash($requestData['columns'][1]['search']['value'], 'decrypt'))->where('status', 3)->orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'])->get();
        } else {
            $items = array();
        }
        $rows = 0;
        $filtered = count($items);
        $dados = array();

        foreach ($items as $item) {
            $dado = array();
            $dado[] = '#' . $item->id;
            $dado[] = $item->product->name;
            $dado[] = $this->Tools->sum_values_item($item->id);
            $dado[] = '<div class="custom-control custom-checkbox">
                       <input class="custom-control-input custom-control-input-secondary" type="checkbox" name="item" id="item' . $item->id . '" value="' . $item->id . '">
                       <label for="item' . $item->id . '" class="custom-control-label"></label>
                       </div>';
            $dados[] = $dado;
        }

        //Cria o array de informações a serem retornadas para o Javascript
        $json_data = array(
            "draw" => intval($requestData['draw']), //para cada requisição é enviado um número como parâmetro
            "recordsTotal" => intval($filtered), //Quantidade de registros que há no banco de dados
            "recordsFiltered" => intval($rows), //Total de registros quando houver pesquisa
            "data" => $dados, //Array de dados completo dos dados retornados da tabela
        );

        return json_encode($json_data); //enviar dados como formato json
    }
    public function request_client_view(Request $request)
    {
        $requestData = $request->all();

        if ($requestData['columns'][1]['search']['value']) {
            if ($requestData['columns'][2]['search']['value'] == 'true') {
                $items = RequestsItemsModel::with('product')->select('product_id', DB::raw('COUNT(id) as count'))
                    ->where('request_id', $this->Tools->hash($requestData['columns'][1]['search']['value'], 'decrypt'))
                    ->where('status', 2)
                    ->groupBy('product_id')
                    ->orderBy('count', $requestData['order'][0]['dir'])
                    ->get();
                $status = 2;

            } elseif ($requestData['columns'][2]['search']['value'] == 'delivery') {
                $items = RequestsItemsModel::with('product')->select('product_id', DB::raw('COUNT(id) as count'))
                    ->where('request_id', $this->Tools->hash($requestData['columns'][1]['search']['value'], 'decrypt'))
                    ->where('status', '>', 1)
                    ->groupBy('product_id')
                    ->orderBy('count', $requestData['order'][0]['dir'])
                    ->get();
                $status = 0;
            } else {
                $items = RequestsItemsModel::with('product')->select('product_id', DB::raw('COUNT(id) as count'))
                    ->where('request_id', $this->Tools->hash($requestData['columns'][1]['search']['value'], 'decrypt'))
                    ->where('status', '>', 2)
                    ->groupBy('product_id')
                    ->orderBy('count', $requestData['order'][0]['dir'])
                    ->get();
                $status = 3;
            }
            $rows = count($items);

        } else {
            $items = array();
            $rows = 0;
        }

        $filtered = count($items);
        $dados = array();

        foreach ($items as $item) {
            $dado = array();
            $dado[] = '<img class="img-circle" src="' . asset($item->product->photo_url) . '" alt="" width="35">';
            $dado[] = $item->product->name;
            $dado[] = $item->count;
            $dado[] = $this->Tools->sum_values_items_equals($item->product_id, $this->Tools->hash($requestData['columns'][1]['search']['value'], 'decrypt'));
            $dado[] = '<button onclick="return  list_items_equals_request(\'' . $requestData['columns'][1]['search']['value'] . '\',\'' . $this->Tools->hash($item->product->id, 'encrypt') . '\',\'' . $item->product->name . '\',\'' . $this->Tools->hash($status, 'encrypt') . '\')" class="btn btn-sm btn-primary m-t-3"><i class="fa-solid fa-eye"></i></button>';
            $dados[] = $dado;
        }

        //Cria o array de informações a serem retornadas para o Javascript
        $json_data = array(
            "draw" => intval($requestData['draw']), //para cada requisição é enviado um número como parâmetro
            "recordsTotal" => intval($filtered), //Quantidade de registros que há no banco de dados
            "recordsFiltered" => intval($rows), //Total de registros quando houver pesquisa
            "data" => $dados, //Array de dados completo dos dados retornados da tabela
        );

        return json_encode($json_data); //enviar dados como formato json
    }
    public function client_payment($id, Request $request)
    {
        $requestData = $request->all();
        if ($id) {
            $items = RequestsItemsModel::with('product')->select('product_id', DB::raw('COUNT(id) as count'))
                ->where('request_id', $this->Tools->hash($id, 'decrypt'))
                ->where('status', 3)
                ->groupBy('product_id')
                ->orderBy('count', $requestData['order'][0]['dir'])
                ->get();
            $rows = count($items);
        } else {
            $items = array();
            $rows = 0;
        }

        $filtered = count($items);
        $dados = array();
        foreach ($items as $item) {
            $dado = array();
            $dado[] = '#' . $item->product->id;
            $dado[] = '<img class="img-circle" src="' . asset($item->product->photo_url) . '" alt="" width="35">';
            $dado[] = $item->product->name;
            $dado[] = $item->count;
            $dado[] = $this->Tools->sum_values_items_equals($item->product_id, $this->Tools->hash($id, 'decrypt'));
            $dado[] = '<button onclick="return  list_items_equals_request(\'' . $id . '\',\'' . $this->Tools->hash($item->product->id, 'encrypt') . '\',\'' . $item->product->name . '\',\'\')" class="btn btn-sm btn-primary m-t-3"><i class="fa-solid fa-eye"></i></button>';
            $dados[] = $dado;
        }

        //Cria o array de informações a serem retornadas para o Javascript
        $json_data = array(
            "draw" => intval($requestData['draw']), //para cada requisição é enviado um número como parâmetro
            "recordsTotal" => intval($filtered), //Quantidade de registros que há no banco de dados
            "recordsFiltered" => intval($rows), //Total de registros quando houver pesquisa
            "data" => $dados, //Array de dados completo dos dados retornados da tabela
        );

        return json_encode($json_data); //enviar dados como formato json
    }
    public function all_request_table(Request $request)
    {
        $requestData = $request->all();
        $columns = array(
            0 => 'id',
            1 => 'client_name',
            2 => 'table',
            3 => 'created_at',
            4 => 'value',
            5 => 'id',
        );

        if ($requestData['columns'][1]['search']['value']) {
            $query = RequestsModel::query();
            if ($requestData['columns'][1]['search']['value']) {
                $query->where('table', $requestData['columns'][1]['search']['value']);
            }
            $query_rows = $query;
            $rows = $query_rows->count();

            $requests = $query->where('status', 1)->where('delivery', 0)->orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'])
                ->offset($requestData['start'])
                ->take($requestData['length'])
                ->get();
        } else {
            $requests = RequestsModel::with('request_items')->where('status', 1)->where('delivery', 0)->orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'])
                ->offset($requestData['start'])
                ->take($requestData['length'])
                ->get();
            $rows = RequestsModel::where('status', 1)->count();
        }
        $filtered = count($requests);
        $dados = array();
        foreach ($requests as $request) {
            $dado = array();
            $dado[] = "#" . $request->id;
            $dado[] = $request->client_name;
            $dado[] = $request->table;
            $dado[] = $request->request_items ? 'SIM' : 'NÃO';
            $dado[] = $this->Tools->sum_values_requests($request->id);
            $dado[] = '<button onclick="return requests_client_view_modal(\'' . $this->Tools->hash($request->id, 'encrypt') . '\')" class="btn btn-sm btn-default" ><i class="fa-solid fa-eye"></i></button> <button onclick="return delete_request(\'' . $this->Tools->hash($request->id, 'encrypt') . '\')" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button> <a class="btn btn-sm btn-success" href="' . route('close-request', ['id' => $this->Tools->hash($request->id, 'encrypt')]) . '"><i class="fa-solid fa-check"></i></a>';
            $dados[] = $dado;
        }

        //Cria o array de informações a serem retornadas para o Javascript
        $json_data = array(
            "draw" => intval($requestData['draw']), //para cada requisição é enviado um número como parâmetro
            "recordsTotal" => intval($filtered), //Quantidade de registros que há no banco de dados
            "recordsFiltered" => intval($rows),
            "data" => $dados, //Array de dados completo dos dados retornados da tabela
        );

        return json_encode($json_data); //enviar dados como formato json
    }
    public function table_menu(Request $request)
    {
        $requestData = $request->all();
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'value',
            3 => 'id',
        );

        if ($requestData['columns'][1]['search']['value']) {
            $items = ItemModel::where('type_id', $requestData['columns'][1]['search']['value'])
                ->where('status', 1)
                ->orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'])
                ->offset($requestData['start'])
                ->take($requestData['length'])
                ->get();
            $rows = count(ItemModel::where('type_id', $requestData['columns'][1]['search']['value'])->where('status', 1)->get());
        } else {
            $items = ItemModel::where('status', 1)->orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'])
                ->offset($requestData['start'])
                ->take($requestData['length'])
                ->get();
            $rows = count(ItemModel::all());
        }
        $filtered = count($items);
        $dados = array();
        foreach ($items as $item) {
            $dado = array();
            $dado[] = '<img class="img-circle" src="' . asset($item->photo_url) . '" alt="' . $item->name . '" width="35">';
            $dado[] = $item->name;
            $dado[] = 'R$' . number_format($item->value, 2, ',', '.');
            $dado[] = '<button onclick="return modal_view_item(\'' . $this->Tools->hash($item->id, 'encrypt') . '\')" class="btn btn-sm btn-dark" ><i class="fa-solid fa-eye"></i></button> <button onclick="return select_amount_item(\'' . $this->Tools->hash($item->id, 'encrypt') . '\')" class="btn btn-sm btn-primary"><i class="fa-solid fa-plus"></i></button>';
            $dados[] = $dado;
        }

        //Cria o array de informações a serem retornadas para o Javascript
        $json_data = array(
            "draw" => intval($requestData['draw']), //para cada requisição é enviado um número como parâmetro
            "recordsTotal" => intval($filtered), //Quantidade de registros que há no banco de dados
            "recordsFiltered" => intval($rows), //Total de registros quando houver pesquisa
            "data" => $dados, //Array de dados completo dos dados retornados da tabela
        );

        return json_encode($json_data); //enviar dados como formato json
    }
    public function list_items_equals(Request $request)
    {
        $requestData = $request->all();

        if ($requestData['columns'][1]['search']['value'] && $requestData['columns'][2]['search']['value']) {
            $query = RequestsItemsModel::with('product')
                ->where('request_id', $this->Tools->hash($requestData['columns'][1]['search']['value'], 'decrypt'))
                ->where('product_id', $this->Tools->hash($requestData['columns'][2]['search']['value'], 'decrypt'));
            if ($requestData['columns'][3]['search']['value']) {
                $query->where('status', $this->Tools->hash($requestData['columns'][3]['search']['value'], 'decrypt'));

            } else {
                $query->whereBetween('status', [2, 3]);
            }
            $items = $query->orderBy('id', 'asc')
                ->offset($requestData['start'])
                ->take($requestData['length'])
                ->get();
            $queryrows = RequestsItemsModel::where('request_id', $this->Tools->hash($requestData['columns'][1]['search']['value'], 'decrypt'))
                ->where('product_id', $this->Tools->hash($requestData['columns'][2]['search']['value'], 'decrypt'));
            if ($requestData['columns'][3]['search']['value']) {
                $queryrows->where('status', $this->Tools->hash($requestData['columns'][3]['search']['value'], 'decrypt'));

            } else {
                $queryrows->whereBetween('status', [2, 3]);
            }

            $rows = $queryrows->count();
        } else {
            $items = array();
            $rows = 0;
        }

        $filtered = count($items);
        $dados = array();

        foreach ($items as $item) {
            $dado = array();
            $dado[] = '<img class="img-circle" src="' . asset($item->product->photo_url) . '" alt="" width="35">';
            $dado[] = $item->product->name;
            $dado[] = $item->waiter;
            $dado[] = $this->Tools->sum_values_item($item->id);
            $dado[] = $item->status != 2 ? '<button onclick="return  view_item_request(\'' . $this->Tools->hash($item->id, 'encrypt') . '\')" class="btn btn-sm btn-secondary m-t-3"><i class="fa-solid fa-eye"></i></button> <button onclick="return delete_item_request(\'' . $this->Tools->hash($item->id, 'encrypt') . '\')" class="btn btn-sm btn-danger m-t-3"><i class="fa-solid fa-trash"></i></button>' : '<button onclick="return additional_item_request(\'' . $this->Tools->hash($item->product_id, 'encrypt') . '\',\'' . $this->Tools->hash($item->id, 'encrypt') . '\')" class="btn btn-sm btn-primary" ><i class="fa-solid fa-pen"></i></button> <button onclick="return  delete_item_request(\'' . $this->Tools->hash($item->id, 'encrypt') . '\')" class="btn btn-sm btn-danger m-t-3"><i class="fa-solid fa-trash"></i></button>';
            $dados[] = $dado;
        }

        //Cria o array de informações a serem retornadas para o Javascript
        $json_data = array(
            "draw" => intval($requestData['draw']), //para cada requisição é enviado um número como parâmetro
            "recordsTotal" => intval($filtered), //Quantidade de registros que há no banco de dados
            "recordsFiltered" => intval($rows), //Total de registros quando houver pesquisa
            "data" => $dados, //Array de dados completo dos dados retornados da tabela
        );

        return json_encode($json_data); //enviar dados como formato json

    }

}
