<?php

namespace App\Http\Controllers;

use App\Classes\Calculate;
use App\Classes\Tools;
use App\Models\PaymentMethodsModel;
use App\Models\RequestsItemsModel;
use App\Models\RequestsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    // FINALIZA O PAGAMENTO
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
    // IMPRIME CUPON FISCAL
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
    // TABELA DE DIVISÃO DE PAGAMENTO
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
    // TABELA COM ITEMS A PAGAR
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
}
