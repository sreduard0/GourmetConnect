<?php

namespace App\Http\Controllers;

use App\Classes\Tools;
use App\Models\AdditionalItemModel;
use Illuminate\Http\Request;

class AdditionalItemsController extends Controller
{
    // CRIANDO ADICIONAL DO ITEM
    public function create(Request $request)
    {
        $data_save = $request->all();
        $item = new AdditionalItemModel();
        $item->item_id = $data_save['item_menu'];
        $item->name = $data_save['name_additional'];
        $item->status = $data_save['status_additional'];
        $item->value = str_replace(',', '.', str_replace('.', '', $data_save['value_additional']));
        $item->description = $data_save['obs_additional'];
        if ($item->save()) {
            return 'success';
        } else {
            return 'error';
        }
    }
    // EDITANDO ADICIONAL DE ITEM
    public function update(Request $request)
    {
        $data_save = $request->all();
        $item = AdditionalItemModel::find($data_save['id']);
        $item->item_id = $data_save['item_menu'];
        $item->name = $data_save['name_additional'];
        $item->status = $data_save['status_additional'];
        $item->value = str_replace(',', '.', str_replace('.', '', $data_save['value_additional']));
        $item->description = $data_save['obs_additional'];
        if ($item->save()) {
            return 'success';
        } else {
            return 'error';
        }
    }
    // EXCLUINDO ADICIONAL DE ITEM
    public function delete($id)
    {
        if (AdditionalItemModel::find(Tools::hash($id, 'decrypt'))->delete()) {
            return "success";
        }
    }
    // BUSCA ADICIONAL ESPECIFICO
    public function find(Request $request)
    {
        return json_encode(AdditionalItemModel::find(Tools::hash($request->get('id'), 'decrypt')));
    }
    // TABELA DATATABLES DE ADICIONAIS DE ITEM
    public function table(Request $request)
    {
        $requestData = $request->all();
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'status',
            3 => 'item_id',
            4 => 'value',
            5 => 'id',
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
            $dado[] = $item->status ? 'Disp.' : 'Ind.';
            $dado[] = $item->item->name;
            $dado[] = 'R$' . number_format($item->value, 2, ',', '.');
            $dado[] = '<button onclick="return modal_additional_item(\'' . Tools::hash($item->id, 'encrypt') . '\')" class="btn btn-sm btn-primary" ><i class="fa-solid fa-pen"></i></button> <button onclick="return delete_additional_item(\'' . Tools::hash($item->id, 'encrypt') . '\')" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>';
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
