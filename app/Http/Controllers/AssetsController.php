<?php

namespace App\Http\Controllers;

class AssetsController extends Controller
{
    public function __invoke($local, $file)
    {
        switch ($local) {
            case 'css':
                $path = storage_path("app/private/assets/css/{$file}");
                $headers = [
                    'Content-Type' => 'text/css',
                ];
                break;
            case 'js':
                $path = storage_path("app/private/assets/js/{$file}");
                $headers = [
                    'Content-Type' => 'application/javascript',
                ];
                break;
            default:
                $path = storage_path("app/private/img/{$local}/{$file}");
                $headers = [];
                break;
        }

        if (false) {
            abort(403, 'Você não tem autorização para acesso');
        }

        if (!file_exists($path)) {
            abort(404);
        }
        return response()->file($path, $headers);
    }
}
