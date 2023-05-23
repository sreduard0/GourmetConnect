<?php

namespace App\Http\Controllers;

use App\Classes\Tools;
use App\Models\ItemModel;
use App\Models\LikesModel;
use Illuminate\Http\Request;

class LikesController extends Controller
{
    public function like_item($item)
    {
        $like = LikesModel::where('item', 1)
            ->where('client_id', auth()->guard('client')->id())
            ->where('event_id', Tools::hash($item, 'decrypt'))
            ->first();
        if ($like) {
            LikesModel::find($like->id)->delete();
            ItemModel::find(Tools::hash($item, 'decrypt'))->decrement('likes');
            $item = ItemModel::find(Tools::hash($item, 'decrypt'));
            return ['event' => 'unlike', 'likes' => $item->likes, 'item' => $item];
        } else {
            LikesModel::create(['item' => 1, 'client_id' => auth()->guard('client')->id(), 'event_id' => Tools::hash($item, 'decrypt')]);
            ItemModel::find(Tools::hash($item, 'decrypt'))->increment('likes');
            $item = ItemModel::find(Tools::hash($item, 'decrypt'));
            return ['event' => 'like', 'likes' => $item->likes, 'item' => $item];
        }
    }
    // TABELA DATATABLES DE ITEMS CURTIDOS
    public function table(Request $request)
    {
        $requestData = $request->all();

        $items = LikesModel::join('items', 'likes.event_id', '=', 'items.id')
            ->where('item', 1)
            ->where('client_id', auth()->guard('client')->id())
            ->orderBy('likes.created_at', 'asc')
            ->get('items.*');

        $rows = count(ItemModel::where('type_id', $requestData['columns'][1]['search']['value'])->get());
        $filtered = count($items);
        $dados = array();
        foreach ($items as $item) {

            $dado = array();
            $dado[] = '<img class="img-circle" src="' . asset($item->photo_url) . '" alt="' . $item->name . '" width="35">';
            $dado[] = $item->name;
            $dado[] = 'R$' . number_format($item->value, 2, ',', '.');
            $dado[] = '<button onclick="return like_item(\'' . Tools::hash($item->id, 'encrypt') . '\')" class="' . Tools::hash($item->id, 'encrypt') . ' btn btn-sm btn-danger"><i class="fas fa-heart"></i></button> <button class="btn btn-sm btn-accent" onclick="return view_item(\'' . Tools::hash($item->id, 'encrypt') . '\')"><i class="fa fa-eye"></i></button>  <button onclick="return add_cart_modal(\'' . Tools::hash($item->id, 'encrypt') . '\')" class="btn btn-sm btn-accent"><i class="fa-solid fa-cart-circle-plus"></i></button>';
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
