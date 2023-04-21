<?php

namespace App\Http\Controllers;

class AssetsController extends Controller
{
    public function __invoke($local, $file)
    {

        // echo $url;
        // $local = str_replace('@', '/', $local);
        $path = storage_path("app/private/assets/{$local}/{$file}");
        // Verifica se o arquivo existe
        if (!file_exists($path)) {
            abort(404);
        }
        // Verifica se o usuário está autenticado e tem permissão de administrador
        if (false) {
            abort(403, 'Você não tem autorização para acesso');
        }
        // Retorna o arquivo
        switch ($local) {
            case 'css':
                $headers = [
                    'Content-Type' => 'text/css',
                ];
                break;
            case 'js':
                $headers = [
                    'Content-Type' => 'application/javascript',
                ];
                break;
            default:
                $headers = [];
                break;
        }
        return response()->file($path, $headers);
    }
}
