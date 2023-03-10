<?php

namespace App\Http\Controllers;

use App\Classes\Tools;
use App\Models\AdditionalItemModel;
use App\Models\ItemModel;
use App\Models\TypeItemModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MenuController extends Controller
{
    private $Tools;
    public function __construct()
    {
        $this->Tools = new Tools;
    }
    // ADICIONANDO ITEMS
    public function save_new_type_item(Request $request)
    {
        $data_save = $request->all();
        $image_array_1 = explode(";", $data_save['img_type_product']);
        $image_array_2 = explode(",", $image_array_1[1]);
        $img = base64_decode($image_array_2[1]);
        $imageName = 'type_item-' . $data_save['name_type_product'] . '-gourmetconnect.png';
        $fileDir = 'img/product/type/';

        if (!is_dir($fileDir)) {
            mkdir($fileDir, 0444, true); //444
        }
        file_put_contents($fileDir . $imageName, $img);

        $item = new TypeItemModel();
        $item->photo_url = $fileDir . $imageName;
        $item->name = $data_save['name_type_product'];
        $item->description = $data_save['obs_type_product'];
        if ($item->save()) {
            return 'success';
        } else {
            return 'error';
        }

    }

    public function save_new_item(Request $request)
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
        $item->name = $data_save['name_product'];
        $item->value = str_replace(',', '.', str_replace('.', '', $data_save['value_product']));
        $item->description = $data_save['obs_product'];
        if ($item->save()) {
            return 'success';
        } else {
            return 'error';
        }

    }

    public function save_new_additional_item(Request $request)
    {
        $data_save = $request->all();
        $item = new AdditionalItemModel();
        $item->item_id = $data_save['item_menu'];
        $item->name = $data_save['name_additional'];
        $item->value = str_replace(',', '.', str_replace('.', '', $data_save['value_additional']));
        $item->description = $data_save['obs_additional'];
        if ($item->save()) {
            return 'success';
        } else {
            return 'error';
        }
    }
    // ADICIONANDO ITEMS
    public function edit_type_item(Request $request)
    {
        $data_save = $request->all();
        $item = TypeItemModel::find($data_save['id']);
        if ($data_save['img_type_product']) {
            $image_array_1 = explode(";", $data_save['img_type_product']);
            $image_array_2 = explode(",", $image_array_1[1]);
            $img = base64_decode($image_array_2[1]);
            $imageName = 'type_item-' . $data_save['name_type_product'] . '-gourmetconnect.png';
            $fileDir = 'img/product/type/';

            if (!is_dir($fileDir)) {
                mkdir($fileDir, 0444, true); //444
            }
            file_put_contents($fileDir . $imageName, $img);

            $item->photo_url = $fileDir . $imageName;
        }
        $item->name = $data_save['name_type_product'];
        $item->description = $data_save['obs_type_product'];
        if ($item->save()) {
            return 'success';
        } else {
            return 'error';
        }

    }

    public function edit_item(Request $request)
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
        $item->name = $data_save['name_product'];
        $item->value = str_replace(',', '.', str_replace('.', '', $data_save['value_product']));
        $item->description = $data_save['obs_product'];
        if ($item->save()) {
            return 'success';
        } else {
            return 'error';
        }

    }

    public function edit_additional_item(Request $request)
    {
        $data_save = $request->all();
        $item = AdditionalItemModel::find($data_save['id']);
        $item->item_id = $data_save['item_menu'];
        $item->name = $data_save['name_additional'];
        $item->value = str_replace(',', '.', str_replace('.', '', $data_save['value_additional']));
        $item->description = $data_save['obs_additional'];
        if ($item->save()) {
            return 'success';
        } else {
            return 'error';
        }
    }

    // EXCLUINDO ITEMS
    public function delete_type_item(Request $request)
    {
        $items = ItemModel::where('type_id', $this->Tools->hash($request->get('id'), 'decrypt'))->get();
        foreach ($items as $item) {
            AdditionalItemModel::where('item_id', $item->id)->delete();
        }
        ItemModel::where('type_id', $this->Tools->hash($request->get('id'), 'decrypt'))->delete();
        if (TypeItemModel::find($this->Tools->hash($request->get('id'), 'decrypt'))->delete()) {
            return 'success';
        }
    }

    public function delete_item(Request $request)
    {
        AdditionalItemModel::where('item_id', $this->Tools->hash($request->get('id'), 'decrypt'))->delete();
        if (ItemModel::find($this->Tools->hash($request->get('id'), 'decrypt'))->delete()) {
            return "success";
        }

    }

    public function delete_additional_item(Request $request)
    {
        if (AdditionalItemModel::find($this->Tools->hash($request->get('id'), 'decrypt'))->delete()) {
            return "success";
        }
    }

    // BUSCANDO INFORMAÇÕES DE ITEMS
    public function info_type_item(Request $request)
    {
        return json_encode(TypeItemModel::find($this->Tools->hash($request->get('id'), 'decrypt')));
    }

    public function info_item(Request $request)
    {
        return ItemModel::with('type','additionals')->find($this->Tools->hash($request->get('id'), 'decrypt'));
    }

    public function info_additional_item(Request $request)
    {
        return json_encode(AdditionalItemModel::find($this->Tools->hash($request->get('id'), 'decrypt')));
    }

    public function all_items()
    {
        return ItemModel::select('id', 'name')->get();
    }
    public function all_types()
    {
        return TypeItemModel::select('id', 'name')->get();
    }

    // TABELAS
    public function table_type_item(Request $request)
    {
        $requestData = $request->all();
        $types = TypeItemModel::with('items')->offset($requestData['start'])
            ->take($requestData['length'])->get();

        $filtered = count($types);
        $dados = array();

        foreach ($types as $type) {
            $dado = array();
            $dado[] = '<img class="img-circle" src="' . asset($type->photo_url) . '" alt="' . $type->name . '" width="35">
                        <div class="popup">
                            <img src="' . asset($type->photo_url) . '" alt="' . $type->name . '">
                        </div>';
            $dado[] = $type->name;
            $dado[] = count($type->items);
            $dado[] = '<button onclick="return modal_type_item(\'' . $this->Tools->hash($type->id, 'encrypt') . '\')" class="btn btn-sm btn-primary" ><i class="fa-solid fa-pen"></i></button> <button onclick="return delete_type_item(\'' . $this->Tools->hash($type->id, 'encrypt') . '\')" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>';
            // $dado[] = $type->description;
            $dados[] = $dado;
        }

        //Cria o array de informações a serem retornadas para o Javascript
        $json_data = array(
            "draw" => intval($requestData['draw']), //para cada requisição é enviado um número como parâmetro
            "recordsTotal" => intval($filtered), //Quantidade de registros que há no banco de dados
            "recordsFiltered" => intval(count(TypeItemModel::all())), //Total de registros quando houver pesquisa
            "data" => $dados, //Array de dados completo dos dados retornados da tabela
        );

        return json_encode($json_data); //enviar dados como formato json
    }
    public function table_item(Request $request)
    {
        $requestData = $request->all();
        $columns = array(
            0 => 'id',
            1 => 'id',
            2 => 'name',
            3 => 'value',
            4 => 'id',
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
            $dado = array();
            $dado[] = "#" . $item->id;
            $dado[] = '<img class="img-circle" src="' . asset($item->photo_url) . '" alt="' . $item->name . '" width="35">
                        <div class="popup">
                            <img src="' . asset($item->photo_url) . '" alt="' . $item->name . '">
                        </div>';
            $dado[] = $item->name;
            $dado[] = $item->type->name;
            $dado[] = 'R$' . number_format($item->value, 2, ',', '.');
            $dado[] = '<button onclick="return modal_view_item(\'' . $this->Tools->hash($item->id, 'encrypt') . '\')" class="btn btn-sm btn-secondary" ><i class="fa-solid fa-eye"></i></button> <button onclick="return modal_item(\'' . $this->Tools->hash($item->id, 'encrypt') . '\')" class="btn btn-sm btn-primary"><i class="fa-solid fa-pen"></i></button> <button onclick="return delete_item(\'' . $this->Tools->hash($item->id, 'encrypt') . '\')" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>';
            // $dado[] = $item->description;
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
    public function table_additional_items(Request $request)
    {
        $requestData = $request->all();
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'item_id',
            3 => 'value',
            4 => 'id',
        );

        if ($requestData['columns'][1]['search']['value']) {
            $items = AdditionalItemModel::where('item_id', $requestData['columns'][1]['search']['value'])->with('item')->orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'])
                ->offset($requestData['start'])
                ->take($requestData['length'])
                ->get();
            $rows = count(AdditionalItemModel::where('item_id', $requestData['columns'][1]['search']['value'])->get());

        } else {
            $items = AdditionalItemModel::with('item')->orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'])
                ->offset($requestData['start'])
                ->take($requestData['length'])
                ->get();
            $rows = count(AdditionalItemModel::all());
        }

        $filtered = count($items);
        $dados = array();

        foreach ($items as $item) {
            $dado = array();
            $dado[] = "#" . $item->id;
            $dado[] = $item->name;
            $dado[] = $item->item->name;
            $dado[] = 'R$' . number_format($item->value, 2, ',', '.');
            $dado[] = '<button onclick="return modal_additional_item(\'' . $this->Tools->hash($item->id, 'encrypt') . '\')" class="btn btn-sm btn-primary" ><i class="fa-solid fa-pen"></i></button> <button onclick="return delete_additional_item(\'' . $this->Tools->hash($item->id, 'encrypt') . '\')" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>';
            // $dado[] = $item->description;
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
