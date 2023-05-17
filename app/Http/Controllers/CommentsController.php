<?php

namespace App\Http\Controllers;

use App\Models\CommentsModel;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function create(Request $request)
    {
        try {
            switch ($request->get('rating')) {
                case 1:
                    $rating = 'ruim';
                    break;
                case 2:
                    $rating = 'regular';
                    break;
                case 3:
                    $rating = 'bom';
                    break;
                case 4:
                    $rating = 'muito bom';
                    break;
                case 5:
                    $rating = 'ótimo';
                    break;

                default:
                    $rating = 'bom';
                    break;
            }
            $comment = new CommentsModel();
            $comment->user_id = auth()->guard('client')->id();
            $comment->rating = $rating;
            $comment->comments = $request->get('comment');
            $comment->save();

            $card_data = '<div class="testimonial-client"><div class="pic"><img src="' . asset(session('user')['photo']) . '" alt="1"></div><div class="testimonial-content"><h3 class="testimonial-title">' . session('user')['name'] . '</h3><h5><i class="text-warning fa-solid fa-star"></i> ' . $rating . '</h5><p class="description">' . $request->get('comment') . '</p></div><span class="date"><i class="fa-duotone fa-calendar"></i>' . date('d/m/Y', strtotime($comment->created_at)) . ' às ' . date('h:i', strtotime($comment->created_at)) . '</span></div>';

            return ['error' => false, 'message' => 'Comentário enviado.', 'cardData' => $card_data];
        } catch (\Throwable $th) {
            return ['error' => true, 'message' => 'Ouve algum erro ao enviar seu comentário. Por favor, tente novamente.'];
        }
    }

    public function delete($id)
    {
        //
    }
}
