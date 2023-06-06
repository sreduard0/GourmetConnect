<?php

namespace Database\Seeders;

use App\Models\AppSettingsModel;
use App\Models\LoginAppModel;
use App\Models\UsersAppModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //===================================
        // SET CONFIG
        //===================================
        $settings = new AppSettingsModel();
        $settings->logo_url = 'img/gourmetconnect-logo/gourmetconnect.png';
        $settings->establishment_name = 'GourmetConnect';
        $settings->save();

        //===================================
        // CREATE PERMISSIONS
        //===================================
        $permissions = [
            // DASHBOARD
            ['name' => 'dashboard', 'display_name' => 'Painel de controle', 'group_name' => 'dashboard'],
            // PEDIDOS
            ['name' => 'create_order', 'display_name' => 'Criar comanda', 'group_name' => 'requests_local'],
            ['name' => 'view_orders', 'display_name' => 'Ver comandas', 'group_name' => 'requests_local'],
            ['name' => 'delete_request', 'display_name' => 'Apagar item', 'group_name' => 'requests_local'],
            ['name' => 'delete_order', 'display_name' => 'Apagar comanda', 'group_name' => 'requests_local'],
            ['name' => 'print_requests', 'display_name' => 'Imprimir comanda', 'group_name' => 'requests_local'],
            ['name' => 'finalize_order', 'display_name' => 'Finalizar comanda', 'group_name' => 'requests_local'],
            // DELIVERY
            ['name' => 'create_delivery', 'display_name' => 'Criar delivery', 'group_name' => 'requests_delivery'],
            ['name' => 'view_delivery', 'display_name' => 'Ver deliverys', 'group_name' => 'requests_delivery'],
            ['name' => 'delete_delivery', 'display_name' => 'Apagar delivery', 'group_name' => 'requests_delivery'],
            ['name' => 'delete_request_delivery', 'display_name' => 'Apagar item delivery', 'group_name' => 'requests_delivery'],
            ['name' => 'edit_delivery', 'display_name' => 'Editar delivery', 'group_name' => 'requests_delivery'],
            ['name' => 'sts_delivery', 'display_name' => 'Status delivery', 'group_name' => 'requests_delivery'],
            // MESAS
            ['name' => 'view_tables', 'display_name' => 'Ver mesas', 'group_name' => 'tables'],
            ['name' => 'qr_code_actions', 'display_name' => 'Gerar QR Code ', 'group_name' => 'tables'],
            // CARDAPIO
            ['name' => 'view_menu', 'display_name' => 'Ver cardápio', 'group_name' => 'menu'],
            ['name' => 'create_item_menu', 'display_name' => 'Criar item', 'group_name' => 'menu'],
            ['name' => 'edit_item_menu', 'display_name' => 'Editar item', 'group_name' => 'menu'],
            ['name' => 'delete_item_menu', 'display_name' => 'Apagar item', 'group_name' => 'menu'],
            ['name' => 'create_type_menu', 'display_name' => 'Criar tipo', 'group_name' => 'menu'],
            ['name' => 'edit_type_menu', 'display_name' => 'Editar tipo', 'group_name' => 'menu'],
            ['name' => 'delete_type_menu', 'display_name' => 'Apagar tipo', 'group_name' => 'menu'],
            ['name' => 'create_additional_menu', 'display_name' => 'Criar adicional', 'group_name' => 'menu'],
            ['name' => 'edit_additional_menu', 'display_name' => 'Editar adicional', 'group_name' => 'menu'],
            ['name' => 'delete_additional_menu', 'display_name' => 'Apagar adicional', 'group_name' => 'menu'],
            // CONFIG. APP
            ['name' => 'config_app_data', 'display_name' => 'Config. Dados', 'group_name' => 'app'],
            ['name' => 'config_app_delivery', 'display_name' => 'Config. Delivery', 'group_name' => 'app'],
            ['name' => 'config_app_email', 'display_name' => 'Config. Email(SMTP)', 'group_name' => 'app'],
            ['name' => 'config_app_theme', 'display_name' => 'Config. Tema', 'group_name' => 'app'],
            // USUARIOS
            ['name' => 'create_user', 'display_name' => 'Criar usuário', 'group_name' => 'user'],
            ['name' => 'edit_user', 'display_name' => 'Editar usuário', 'group_name' => 'user'],
            ['name' => 'delete_user', 'display_name' => 'Apagar usuário', 'group_name' => 'user'],
            ['name' => 'config_users', 'display_name' => 'Config. Usuários', 'group_name' => 'user'],
            ['name' => 'permissions_user', 'display_name' => 'Dar permissões', 'group_name' => 'user'],
            ['name' => 'reset_password', 'display_name' => 'Resetar senha', 'group_name' => 'user'],
            // CONFIG. SITE
            ['name' => 'config_site', 'display_name' => 'Config. Site', 'group_name' => 'site'],

        ];
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        //===================================
        // CREATE USER ADMINISTRATOR
        //===================================
        $create_login = new LoginAppModel();
        $create_login->active = 1;
        $create_login->login = 'admin@gourmetconnect.com';
        $create_login->password = Hash::make('admin@gourmetconnect.com');
        if ($create_login->save()) {
            $create_user = new UsersAppModel();
            $create_user->login_id = $create_login->id;
            $create_user->photo_url = 'img/avatar/user.png';
            $create_user->first_name = 'Administrador';
            $create_user->last_name = ' ';
            $create_user->job = strtoupper('administrador');
            $create_user->phone = '99999999999';
            $create_user->email = 'admin@gourmetconnect.coml';
            $create_user->save();
        }
        foreach ($permissions as $permission) {
            $create_login->givePermissionTo($permission['name']);
        }
    }
}
