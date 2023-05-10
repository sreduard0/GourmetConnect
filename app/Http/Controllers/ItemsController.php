<?php

namespace App\Http\Controllers;

use App\Classes\Tools;
use App\Models\AdditionalItemModel;
use App\Models\ItemModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ItemsController extends Controller
{
    // CRIANDO ITEM
    public function create(Request $request)
    {
        $data_save = $request->all();
        $image_array_1 = explode(";", $data_save['img_product']);
        $image_array_2 = explode(",", $image_array_1[1]);
        $img = base64_decode($image_array_2[1]);
        $imageName = 'item-' . $data_save['name_product'] . '-gourmetconnect.png';
        $fileDir = 'img/product/item/';

        if (!is_dir($fileDir)) {
            mkdir($fileDir, 0444, true); //444
        }
        file_put_contents($fileDir . $imageName, $img);

        $item = new ItemModel();
        $item->photo_url = $fileDir . $imageName;
        $item->type_id = $data_save['type_product'];
        $item->status = $data_save['status_product'];
        $item->name = $data_save['name_product'];
        $item->value = str_replace(',', '.', str_replace('.', '', $data_save['value_product']));
        $item->description = $data_save['obs_product'];
        if ($item->save()) {
            return 'success';
        } else {
            return 'error';
        }

    }
    // EDITANDO ITEM
    public function update(Request $request)
    {
        $data_save = $request->all();
        $item = ItemModel::find($data_save['id']);
        if ($data_save['img_product']) {
            $image_array_1 = explode(";", $data_save['img_product']);
            $image_array_2 = explode(",", $image_array_1[1]);
            $img = base64_decode($image_array_2[1]);
            $imageName = 'item-' . $data_save['name_product'] . date('s') . '-gourmetconnect.png';
            $fileDir = 'img/product/item/';

            if (!is_dir($fileDir)) {
                mkdir($fileDir, 0444, true); //444
            }
            File::delete($item->photo_url);
            file_put_contents($fileDir . $imageName, $img);
            $item->photo_url = $fileDir . $imageName;
        }
        $item->type_id = $data_save['type_product'];
        $item->status = $data_save['status_product'];
        $item->name = $data_save['name_product'];
        if ($item->value != str_replace(',', '.', str_replace('.', '', $data_save['value_product']))) {
            $item->old_value = $item->value;
        }
        $item->value = str_replace(',', '.', str_replace('.', '', $data_save['value_product']));
        $item->description = $data_save['obs_product'];
        if ($item->save()) {
            return 'success';
        } else {
            return 'error';
        }

    }
    // EXCLUINDO ITEM
    public function delete($id)
    {
        AdditionalItemModel::where('item_id', Tools::hash($id, 'decrypt'))->delete();
        if (ItemModel::find(Tools::hash($id, 'decrypt'))->delete()) {
            return "success";
        }
    }
    // BUSCA ITEM ESPECIFICO
    public function find(Request $request)
    {
        return ItemModel::with('type', 'additionals')->find(Tools::hash($request->get('id'), 'decrypt'));
    }
    // BUSCA TODOS ITEMS
    public function all_name_items()
    {
        return ItemModel::select('id', 'name')->get();
    }
    // TABELA DATATABLES DE ITEMS
    public function table(Request $request)
    {
        $requestData = $request->all();
        $columns = array(
            0 => 'id',
            1 => 'id',
            2 => 'name',
            3 => 'status',
            4 => 'value',
            5 => 'id',
        );

        if ($requestData['columns'][1]['search']['value']) {
            $items = ItemModel::where('type_id', $requestData['columns'][1]['search']['value'])
                ->with('type')
                ->orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'])
                ->offset($requestData['start'])
                ->take($requestData['length'])
                ->get();
            $rows = count(ItemModel::where('type_id', $requestData['columns'][1]['search']['value'])->get());
        } else {
            $items = ItemModel::with('type')->orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'])
                ->offset($requestData['start'])
                ->take($requestData['length'])
                ->get();
            $rows = count(ItemModel::all());

        }
        $filtered = count($items);
        $dados = array();
        foreach ($items as $item) {
            $buttons = '';
            if (Auth::user()->hasPermissionTo('view_menu')) {
                $buttons .= '<button onclick="return modal_view_item(\'' . Tools::hash($item->id, 'encrypt') . '\')" class="btn btn-sm btn-secondary" ><i class="fa-solid fa-eye"></i></button>  ';
            }
            if (Auth::user()->hasPermissionTo('edit_item_menu')) {
                $buttons .= '<button onclick="return modal_item(\'' . Tools::hash($item->id, 'encrypt') . '\')" class="btn btn-sm btn-primary"><i class="fa-solid fa-pen"></i></button> ';
            }
            if (Auth::user()->hasPermissionTo('delete_item_menu')) {
                $buttons .= '<button onclick="return delete_item(\'' . Tools::hash($item->id, 'encrypt') . '\')" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button> ';
            }

            $dado = array();
            $dado[] = "#" . $item->id;
            $dado[] = '<img class="img-circle" src="' . asset($item->photo_url) . '" alt="' . $item->name . '" width="35">
                        <div class="popup">
                            <img src="' . asset($item->photo_url) . '" alt="' . $item->name . '">
                        </div>';
            $dado[] = $item->name;
            $dado[] = $item->status ? 'Disponível' : 'Indisponível';
            $dado[] = $item->type->name;
            $dado[] = 'R$' . number_format($item->value, 2, ',', '.');
            $dado[] = $buttons;
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
