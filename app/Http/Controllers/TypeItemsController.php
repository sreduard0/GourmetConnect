<?php

namespace App\Http\Controllers;

use App\Classes\Tools;
use App\Models\AdditionalItemModel;
use App\Models\ItemModel;
use App\Models\TypeItemModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TypeItemsController extends Controller
{
    // CRIANDO TIPO DE ITEM
    public function create(Request $request)
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
    // EDITANDO TIPO DE ITEM
    public function update(Request $request)
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
    // EXCLUINDO TIPO DE ITEM
    public function delete($id)
    {
        $items = ItemModel::where('type_id', Tools::hash($id, 'decrypt'))->get();
        foreach ($items as $item) {
            AdditionalItemModel::where('item_id', $item->id)->delete();
        }
        ItemModel::where('type_id', Tools::hash($id, 'decrypt'))->delete();
        if (TypeItemModel::find(Tools::hash($id, 'decrypt'))->delete()) {
            return 'success';
        }
    }
    // BUSCA O NOME DE TODOS OS TYPOS DE ITEM
    public function all_name_types()
    {
        return TypeItemModel::select('id', 'name')->get();
    }
    // BUSTA UM TIPO DE ITEM
    public function find(Request $request)
    {
        return json_encode(TypeItemModel::find(Tools::hash($request->get('id'), 'decrypt')));
    }
    // TABELA DATATABLES DE TIPO DE ITEMS
    public function table(Request $request)
    {
        $requestData = $request->all();
        $types = TypeItemModel::with('items')->offset($requestData['start'])
            ->take($requestData['length'])->get();

        $filtered = count($types);
        $dados = array();

        foreach ($types as $type) {
            $buttons = '';
            if (Auth::user()->hasPermissionTo('edit_type_menu')) {
                $buttons .= '<button onclick="return modal_type_item(\'' . Tools::hash($type->id, 'encrypt') . '\')" class="btn btn-sm btn-primary" ><i class="fa-solid fa-pen"></i></button> ';
            }
            if (Auth::user()->hasPermissionTo('delete_type_menu')) {
                $buttons .= '<button onclick="return delete_type_item(\'' . Tools::hash($type->id, 'encrypt') . '\')" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button> ';
            }
            $dado = array();
            $dado[] = '<img class="img-circle" src="' . asset($type->photo_url) . '" alt="' . $type->name . '" width="35">
                        <div class="popup">
                            <img src="' . asset($type->photo_url) . '" alt="' . $type->name . '">
                        </div>';
            $dado[] = $type->name;
            $dado[] = count($type->items);
            $dado[] = $buttons ? $buttons : '-';
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
}
