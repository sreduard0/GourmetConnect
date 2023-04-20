<?php

namespace App\Http\Controllers;

use App\Classes\Calculate;
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
// PEDIDO DO CLIENTE
    public function add_item_request(Request $request)
    {
        $data = $request->all();
        if (isset($data['client_id'])) {
            $request = RequestsModel::select('id')->where('id', Tools::hash($data['client_id'], 'decrypt'))->where('status', 1)->first();
        } else {
            $request = RequestsModel::select('id')->where('table', $data['table'])->where('client_name', $data['client'])->where('status', 1)->first();
        }
        $product = ItemModel::select('value')->find(Tools::hash($data['item'], 'decrypt'));

        for ($i = 1; $i <= $data['amount']; $i++) {
            $requestItems[] = [
                'request_id' => $request->id,
                'product_id' => Tools::hash($data['item'], 'decrypt'),
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
    public function delete_item_request(Request $request)
    {
        $data = $request->all();
        if (RequestsItemsModel::where('id', Tools::hash($data['item'], 'decrypt'))->delete()) {
            return 'success';
        } else {
            return 'not-delete';
        }
    }
    public function send_item_request(Request $request)
    {
        $data = $request->all();
        if (isset($data['client_id'])) {
            $request = RequestsModel::select('id')->where('id', Tools::hash($data['client_id'], 'decrypt'))->where('status', 1)->first();
        } else {
            $request = RequestsModel::select('id')->where('table', $data['table'])->where('client_name', strtoupper($data['client']))->where('status', 1)->first();
        }
        if (RequestsItemsModel::where('request_id', $request->id)->where('status', 1)->update(['waiter' => session('user')['name'], 'status' => 2])) {
            if (!isset($data['client_id'])) {
                event(new notificationNewRequest([
                    'notify' => 1,
                    'type' => 'bootbox',
                    'title' => 'NOVO PEDIDO',
                    'request_id' => Tools::hash($request->id, 'encrypt'),
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

    public function additionals_items_request(Request $request)
    {
        $data = $request->all();
        $itemsCheck = RequestAdditionalItemModal::where('item_id', Tools::hash($data['request_id'], 'decrypt'))->get();
        $items = AdditionalItemModel::where('item_id', Tools::hash($data['item'], 'decrypt'))->get();
        $item = RequestsItemsModel::select('observation', 'value')->find(Tools::hash($data['request_id'], 'decrypt'));

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
                        'item_id' => Tools::hash($inputs['id'], 'decrypt'),
                        'value' => $additional->value,
                    ];
                    RequestAdditionalItemModal::updateOrCreate(['additional_id' => $input['id'], 'item_id' => Tools::hash($inputs['id'], 'decrypt')], $additionals);
                } else {
                    RequestAdditionalItemModal::where('additional_id', $input['id'])->where('item_id', Tools::hash($inputs['id'], 'decrypt'))->delete();
                }
            }
        }
        $observation = RequestsItemsModel::find(Tools::hash($inputs['id'], 'decrypt'));
        $observation->observation = $inputs['obs'];
        $observation->value = Calculate::itemValue(Tools::hash($inputs['id'], 'decrypt'));
        $observation->save();
        return 'success';

    }
    public function print_request(Request $request)
    {
        if ($request->get('id') != 'all') {
            $command = RequestsModel::with('address')->find(Tools::hash($request->get('id'), 'decrypt'));
            $requests = RequestsItemsModel::where('request_id', Tools::hash($request->get('id'), 'decrypt'))->where('status', 2)->orderBy('product_id', 'asc')->get();

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
    public function print_confirm(Request $request)
    {
        event(new notificationNewRequest([
            'notify' => 0,
            'type' => 'event_table',
            'title' => null,
            'request_id' => null,
            'messege' => null,
            'size' => null,
            'centervertical' => null,
            'user_destination' => null,
        ]));
        if ($request->get('id') != 'all') {
            RequestsItemsModel::where('request_id', Tools::hash($request->get('id'), 'decrypt'))->where('status', 2)->update(['status' => 3]);
            RequestsModel::where('id', Tools::hash($request->get('id'), 'decrypt'))->where('delivery', 1)->update(['status' => 2]);
        } else {
            RequestsItemsModel::where('status', 2)->update(['status' => 3]);
            RequestsModel::where('status', 1)->where('delivery', 1)->update(['status' => 2]);
        }
    }
    public function sum_requests_client(Request $request)
    {
        $location = DeliveryAddressModel::where('request_id', Tools::hash($request->get('id'), 'decrypt'))->first();
        if ($location) {
            return Calculate::requestValue(Tools::hash($request->get('id'), 'decrypt'), [1, 3], true, true);
        } else {
            return Calculate::requestValue(Tools::hash($request->get('id'), 'decrypt'), [1, 3], false, true);
        }
    }
    // INFORMAÇÕES DO PEDIDO
    public function view_item_request(Request $request)
    {
        $data = RequestsItemsModel::with('product', 'additionals')->find(Tools::hash($request->get('id'), 'decrypt'));
        $data->value = Calculate::itemValue(Tools::hash($request->get('id'), 'decrypt'), true);
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
            if (RequestsItemsModel::where('request_id', Tools::hash($data['id'], 'decrypt'))->where('status', 3)->count() < 1) {
                RequestsModel::find(Tools::hash($data['id'], 'decrypt'))->update(['status' => 2]);
                RequestsItemsModel::where('request_id', Tools::hash($data['id'], 'decrypt'))->where('status', 2)->delete();
            }

            return 'split_success';
        } else {
            if (RequestsItemsModel::where('request_id', Tools::hash($data['id'], 'decrypt'))->where('status', 3)->update(['status' => 4, 'payment_method' => $data['method']])) {
                RequestsModel::find(Tools::hash($data['id'], 'decrypt'))->update(['status' => 2]);
                RequestsItemsModel::where('request_id', Tools::hash($data['id'], 'decrypt'))->where('status', 2)->delete();
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
            $requests = RequestsItemsModel::with('additionals')->where('request_id', Tools::hash($data['id'], 'decrypt'))->where('status', 4)->where('print', null)->orderBy('product_id', 'asc')->get();
            RequestsItemsModel::where('request_id', Tools::hash($data['id'], 'decrypt'))->where('status', 4)->where('print', null)->update(['print' => 1]);
        }

        if ($data['action'] == 'not') {
            return false;
        }

        $method = PaymentMethodsModel::select('name')->find($data['method']);
        $items = [];
        foreach ($requests as $item) {
            if (isset($total)) {
                $total += Calculate::itemValue($item->id);
            } else {
                $total = Calculate::itemValue($item->id);
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
            'command' => RequestsModel::find(Tools::hash($data['id'], 'decrypt')),
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

        if ($requestData['columns'][1]['search']['value']) {
            $items = RequestsItemsModel::with('product')->where('request_id', Tools::hash($requestData['columns'][1]['search']['value'], 'decrypt'))->where('status', 1)->orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'])
                ->offset($requestData['start'])
                ->take($requestData['length'])
                ->get();

            $rows = RequestsItemsModel::where('request_id', Tools::hash($requestData['columns'][1]['search']['value'], 'decrypt'))->where('status', 1)->count();

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
            $dado[] = Calculate::itemValue($item->id, true);
            $dado[] = '<button onclick="return additional_item_request(\'' . Tools::hash($item->product_id, 'encrypt') . '\',\'' . Tools::hash($item->id, 'encrypt') . '\')" class="btn btn-sm btn-primary" ><i class="fa-solid fa-pen"></i></button> <button onclick="return  delete_item_request(\'' . Tools::hash($item->id, 'encrypt') . '\')" class="btn btn-sm btn-danger m-t-3"><i class="fa-solid fa-trash"></i></button>';
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
            $items = RequestsItemsModel::with('product')->where('request_id', Tools::hash($requestData['columns'][1]['search']['value'], 'decrypt'))->where('status', 3)->orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'])->get();
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
            $dado[] = Calculate::itemValue($item->id, true);
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
                    ->where('request_id', Tools::hash($requestData['columns'][1]['search']['value'], 'decrypt'))
                    ->where('status', 2)
                    ->groupBy('product_id')
                    ->orderBy('count', $requestData['order'][0]['dir'])
                    ->get();
                $status = 2;

            } elseif ($requestData['columns'][2]['search']['value'] == 'delivery') {
                $items = RequestsItemsModel::with('product')->select('product_id', DB::raw('COUNT(id) as count'))
                    ->where('request_id', Tools::hash($requestData['columns'][1]['search']['value'], 'decrypt'))
                    ->where('status', '>', 1)
                    ->groupBy('product_id')
                    ->orderBy('count', $requestData['order'][0]['dir'])
                    ->get();
                $status = 0;
            } else {
                $items = RequestsItemsModel::with('product')->select('product_id', DB::raw('COUNT(id) as count'))
                    ->where('request_id', Tools::hash($requestData['columns'][1]['search']['value'], 'decrypt'))
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
            $dado[] = Calculate::itemEqualsValue($item->product_id, Tools::hash($requestData['columns'][1]['search']['value'], 'decrypt'), [2, 3], true);
            $dado[] = '<button onclick="return  list_items_equals_request(\'' . $requestData['columns'][1]['search']['value'] . '\',\'' . Tools::hash($item->product->id, 'encrypt') . '\',\'' . $item->product->name . '\',\'' . Tools::hash($status, 'encrypt') . '\')" class="btn btn-sm btn-primary m-t-3"><i class="fa-solid fa-eye"></i></button>';
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
                ->where('request_id', Tools::hash($id, 'decrypt'))
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
            $dado[] = Calculate::itemEqualsValue($item->product_id, Tools::hash($id, 'decrypt'), 3, true);
            $dado[] = '<button onclick="return  list_items_equals_request(\'' . $id . '\',\'' . Tools::hash($item->product->id, 'encrypt') . '\',\'' . $item->product->name . '\',\'\')" class="btn btn-sm btn-primary m-t-3"><i class="fa-solid fa-eye"></i></button>';
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
            $dado[] = '<button onclick="return modal_view_item(\'' . Tools::hash($item->id, 'encrypt') . '\')" class="btn btn-sm btn-dark" ><i class="fa-solid fa-eye"></i></button> <button onclick="return select_amount_item(\'' . Tools::hash($item->id, 'encrypt') . '\')" class="btn btn-sm btn-primary"><i class="fa-solid fa-plus"></i></button>';
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
                ->where('request_id', Tools::hash($requestData['columns'][1]['search']['value'], 'decrypt'))
                ->where('product_id', Tools::hash($requestData['columns'][2]['search']['value'], 'decrypt'));
            if ($requestData['columns'][3]['search']['value']) {
                $query->where('status', Tools::hash($requestData['columns'][3]['search']['value'], 'decrypt'));

            } else {
                $query->whereBetween('status', [2, 3]);
            }
            $items = $query->orderBy('id', 'asc')
                ->offset($requestData['start'])
                ->take($requestData['length'])
                ->get();
            $queryrows = RequestsItemsModel::where('request_id', Tools::hash($requestData['columns'][1]['search']['value'], 'decrypt'))
                ->where('product_id', Tools::hash($requestData['columns'][2]['search']['value'], 'decrypt'));
            if ($requestData['columns'][3]['search']['value']) {
                $queryrows->where('status', Tools::hash($requestData['columns'][3]['search']['value'], 'decrypt'));

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
            $dado[] = Calculate::itemValue($item->id, true);
            $dado[] = $item->status != 2 ? '<button onclick="return  view_item_request(\'' . Tools::hash($item->id, 'encrypt') . '\')" class="btn btn-sm btn-secondary m-t-3"><i class="fa-solid fa-eye"></i></button> <button onclick="return delete_item_request(\'' . Tools::hash($item->id, 'encrypt') . '\')" class="btn btn-sm btn-danger m-t-3"><i class="fa-solid fa-trash"></i></button>' : '<button onclick="return additional_item_request(\'' . Tools::hash($item->product_id, 'encrypt') . '\',\'' . Tools::hash($item->id, 'encrypt') . '\')" class="btn btn-sm btn-primary" ><i class="fa-solid fa-pen"></i></button> <button onclick="return  delete_item_request(\'' . Tools::hash($item->id, 'encrypt') . '\')" class="btn btn-sm btn-danger m-t-3"><i class="fa-solid fa-trash"></i></button>';
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
