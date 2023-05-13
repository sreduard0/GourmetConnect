<?php

namespace App\Http\Controllers;

use App\Classes\Tools;
use App\Models\ItemModel;
use App\Models\LikesModel;

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
}
