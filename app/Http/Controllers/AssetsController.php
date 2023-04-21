<?php

namespace App\Http\Controllers;

class AssetsController extends Controller
{
    public function __invoke($url, )
    {

        // echo $url;
        // $local = str_replace('@', '/', $local);
        $path = storage_path("app/private/assets/{$url}");

        // Verifica se o arquivo existe
        if (!file_exists($path)) {
            abort(404);
        }
        // Verifica se o usuário está autenticado e tem permissão de administrador
        if (false) {
            abort(403, 'Você não tem autorização para acesso');
        }
        // Retorna o arquivo
        $mime = mime_content_type($path);
        header('Content-Type: ' . $mime);

        return response()->file($path);
    }
}
