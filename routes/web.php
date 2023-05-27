<?php

use App\Http\Controllers\AdditionalItemsController;
use App\Http\Controllers\AppSettingsController;
use App\Http\Controllers\AppViewsController;
use App\Http\Controllers\AssetsController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\ControlPanelController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RequestsController;
use App\Http\Controllers\SaleItemsController;
use App\Http\Controllers\SiteViewsController;
use App\Http\Controllers\TablesController;
use App\Http\Controllers\TypeItemsController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UsersController;
use App\Models\LoginClientModel;
use App\Models\UsersClientModel;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

//----------------------------------------------
//  ROTAS ADMINISTRATIVAS
//----------------------------------------------

//-------------------------------
// APP/ LOGIN
//-------------------------------
Route::get(config('app.prefix_admin'), function () {
    return redirect()->route('form_login');
});
Route::prefix(config('app.prefix_admin'))->group(function () {
    Route::middleware('ifAuth')->group(function () {
        Route::get('app/login', [AppViewsController::class, 'form_login'])->name('form_login');
        Route::post('post/submit/login', [LoginController::class, 'submit_login_app']);
        Route::post('post/validate/login', [LoginController::class, 'validate_login_app']);
    });
// LOGOUT
    Route::get('logout', [LoginController::class, 'logout_app'])->name('logout');
});

Route::middleware('auth')->group(function () {
//-------------------------------
// ASSETS ADMINISTRATIVOS
//-------------------------------
    Route::get('private/assets/{local?}/{file?}', AssetsController::class);

    Route::prefix(config('app.prefix_admin'))->group(function () {
// ----------------------------
// APP/ VIEWS
// ----------------------------
        Route::get('control-panel', [AppViewsController::class, 'control_panel'])->middleware('hasPermission:dashboard')->name('control_panel');
        Route::get('requests', [AppViewsController::class, 'requests'])->middleware('hasPermission:view_orders')->name('requests');
        Route::get('requests/close-request/{id}', [AppViewsController::class, 'close_request'])->middleware('hasPermission:finalize_order')->name('close-request');
        Route::get('delivery', [AppViewsController::class, 'delivery'])->middleware('hasPermission:view_delivery')->name('delivery');
        Route::get('tables', [AppViewsController::class, 'tables'])->middleware('hasPermission:view_tables')->name('tables');
        Route::get('menu', [AppViewsController::class, 'menu'])->middleware('hasPermission:view_menu')->name('menu');
        Route::get('users', [AppViewsController::class, 'users'])->middleware('hasPermission:create_user,edit_user,delete_user,ermissions_user')->name('users');
        Route::get('app-settings', [AppViewsController::class, 'app_settings'])->name('app_settings');
        Route::get('site-settings', [AppViewsController::class, 'site_settings'])->name('site_settings');

// -----------------------------
// APP/ SETTINGS
// -----------------------------
        Route::post('post/save/establishment-settings', [AppSettingsController::class, 'save_establishment_settings']);
        Route::post('post/save/theme-settings', [AppSettingsController::class, 'save_theme_settings']);
        Route::post('post/delete/delivery/local', [AppSettingsController::class, 'delete_delivery_local']);
        Route::post('post/save/delivery-local-settings', [AppSettingsController::class, 'save_delivery_local_settings']);
        Route::post('post/table/app-settings/delivery-locations', [AppSettingsController::class, 'delivery_locations']);
        Route::post('post/save/app-settings/mailer', [AppSettingsController::class, 'save_email_settings']);
        Route::get('get/app-settings/logo', [AppSettingsController::class, 'logo']);

// ------------------------------
// APP/ CARDÁPIO
// ------------------------------
// TIPO ITENS
        Route::post('post/save/menu/type/new', [TypeItemsController::class, 'create']);
        Route::put('put/save/menu/type/edit', [TypeItemsController::class, 'update']);
        Route::delete('delete/menu/type/{id}', [TypeItemsController::class, 'delete']);
        Route::post('post/info/menu/type', [TypeItemsController::class, 'find']);
        Route::get('get/info/menu/types', [TypeItemsController::class, 'all_name_types']);
        Route::post('post/table/menu/type', [TypeItemsController::class, 'table']);
// ITENS
        Route::post('post/save/menu/item/new', [ItemsController::class, 'create']);
        Route::put('put/save/menu/item/edit', [ItemsController::class, 'update']);
        Route::delete('delete/menu/item/{id}', [ItemsController::class, 'delete']);
        Route::post('post/info/menu/item', [ItemsController::class, 'find']);
        Route::get('get/info/menu/items', [ItemsController::class, 'all_name_items']);
        Route::post('post/table/menu/items', [ItemsController::class, 'table']);
// ADICIONAIS
        Route::post('post/save/menu/additional-item/new', [AdditionalItemsController::class, 'create']);
        Route::put('put/save/menu/additional-item/edit', [AdditionalItemsController::class, 'update']);
        Route::delete('delete/menu/additional-item/{id}', [AdditionalItemsController::class, 'delete']);
        Route::post('post/info/menu/additional-item', [AdditionalItemsController::class, 'find']);
        Route::post('post/table/menu/additional-items', [AdditionalItemsController::class, 'table']);

//-------------------------------
// APP/ PEDIDOS
//-------------------------------
// ESTABELECIMENTO
        Route::post('post/order/new', [OrderController::class, 'create'])->middleware('hasPermission:create_order');
        Route::delete('delete/order/{id}', [OrderController::class, 'delete'])->middleware('hasPermission:delete_order');
        Route::get('get/table/orders/{table}', [OrderController::class, 'table_orders_list'])->middleware('hasPermission:create_order');
        Route::get('get/order/information/{id}', [OrderController::class, 'order_information'])->middleware('hasPermission:view_orders');
        Route::get('get/check/order/finish/{id}', [OrderController::class, 'check_order_finish'])->middleware('hasPermission:finalize_order');
        Route::post('post/table/orders', [OrderController::class, 'table'])->middleware('hasPermission:view_orders');
// DELIVERY
        Route::post('post/delivery/new', [DeliveryController::class, 'create'])->middleware('hasPermission:create_delivery');
        Route::put('post/delivery/edit', [DeliveryController::class, 'update'])->middleware('hasPermission:edit_delivery');
        Route::delete('delete/delivery/{id}', [DeliveryController::class, 'delete'])->middleware('hasPermission:delete_delivery');
        Route::put('put/delivery/status/out', [DeliveryController::class, 'out_for_delivery'])->middleware('hasPermission:sts_delivery');
        Route::put('put/delivery/status/finalize', [DeliveryController::class, 'finalize_delivery'])->middleware('hasPermission:sts_delivery');
        Route::get('get/delivery/information/{id}', [DeliveryController::class, 'delivery_information_modal'])->middleware('hasPermission:view_delivery');
        Route::get('get/delivery/information/edit/{id}', [DeliveryController::class, 'delivery_information_edit'])->middleware('hasPermission:edit_delivery');
        Route::post('post/table/delivery', [DeliveryController::class, 'delivery_table'])->middleware('hasPermission:view_delivery');
// PEDIDOS
        Route::post('post/request/item/add', [RequestsController::class, 'add_item_request'])->middleware('hasPermission:create_order,create_delivery');
        Route::post('post/request/item/delete', [RequestsController::class, 'delete_item_request'])->middleware('hasPermission:delete_request,delete_request_delivery');
        Route::post('post/request/item/send', [RequestsController::class, 'send_item_request'])->middleware('hasPermission:create_order,create_delivery');
        Route::post('post/request/additional-item/save', [RequestsController::class, 'save_obs_item_request'])->middleware('hasPermission:create_order,create_delivery');
        Route::post('post/request/item/additionals', [RequestsController::class, 'additionals_items_request'])->middleware('hasPermission:create_order,create_delivery');
        Route::post('post/request/print', [RequestsController::class, 'print_request'])->middleware('hasPermission:print_requests,sts_delivery');
        Route::post('post/request/print/confirm', [RequestsController::class, 'print_confirm'])->middleware('hasPermission:print_requests,sts_delivery');
        Route::post('post/info/request/item', [RequestsController::class, 'view_item_request'])->middleware('hasPermission:view_orders,view_delivery');
        Route::post('post/table/request/client', [RequestsController::class, 'request_client_table'])->middleware('hasPermission:create_order,create_delivery');
        Route::post('post/table/request/client-view', [RequestsController::class, 'request_client_view'])->middleware('hasPermission:view_orders,view_delivery');
        Route::post('post/sum/request/client-payment', [RequestsController::class, 'sum_requests_client'])->middleware('hasPermission:view_orders,view_delivery,finalize_order');
        Route::post('post/table/request/list-items-equals', [RequestsController::class, 'list_items_equals'])->middleware('hasPermission:view_orders,view_delivery');
        Route::post('post/table/request/menu', [RequestsController::class, 'table_menu'])->middleware('hasPermission:create_order,create_delivery');
// PAGAMENTO
        Route::middleware('hasPermission:finalize_order')->group(function () {
            Route::post('post/table/request/client-payment/{id}', [PaymentController::class, 'client_payment']);
            Route::post('post/table/request/split-payment', [PaymentController::class, 'split_payment_table']);
            Route::post('post/request/finalize-payment', [PaymentController::class, 'finalize_payment']);
            Route::post('post/request/tax-coupon', [PaymentController::class, 'tax_coupon']);
        });

// MESAS
        Route::get('post/table/events', [TablesController::class, 'tables_events'])->middleware('hasPermission:view_tables');
        Route::post('post/table/info/clients', [TablesController::class, 'table_info'])->middleware('hasPermission:view_orders');

//-------------------------------
// APP/ PAINEL DE CONTROLE
//-------------------------------
        Route::middleware('hasPermission:dashboard')->group(function () {
            Route::get('get/control-panel/chart/monthly-sales-chart', [ControlPanelController::class, 'monthly_sales_chart']);
            Route::get('get/control-panel/chart/areas-with-more-delivery', [ControlPanelController::class, 'areas_with_more_delivery']);
        });

//-------------------------------
// APP/ USUARIOS
//-------------------------------
// USUÁRIOS
        Route::post('post/user/create', [UsersController::class, 'create'])->middleware('hasPermission:create_user');
        Route::get('get/user/edit/{id}', [UsersController::class, 'edit'])->middleware('hasPermission:edit_user');
        Route::put('put/user/update', [UsersController::class, 'update'])->middleware('hasPermission:edit_user');
        Route::delete('delete/user/{id}', [UsersController::class, 'delete'])->middleware('hasPermission:delete_user');
        Route::post('post/table/users-app', [UsersController::class, 'table'])->middleware('hasPermission:create_user');
        Route::get('get/check/email/{email}', [UsersController::class, 'check_email']);
        Route::get('get/permissions/{user}', [UsersController::class, 'permissions'])->middleware('hasPermission:create_user,edit_user,delete_user,permissions_user');
        Route::put('put/permissions', [UsersController::class, 'save_permissions'])->middleware('hasPermission:permissions_user');
        Route::get('get/reset/password/{id}', [UsersController::class, 'reset_password'])->middleware('hasPermission:reset_password');

// PERFIL DO USUÁRIO
        Route::get('get/user/profile', [UserProfileController::class, 'show']);
        Route::put('put/profile/update', [UserProfileController::class, 'update']);
        Route::put('put/password/update', [UserProfileController::class, 'update_password']);

//-------------------------------
// APP/ NOTIFICAÇÕES
//-------------------------------
        Route::get('notification/events', [NotificationController::class, 'notification'])->middleware('hasPermission:print_requests');
        Route::post('notification/events/requests', [NotificationController::class, 'new_request_notification'])->middleware('hasPermission:print_requests');

    });
});

//==============================================================================================================================================================================

//----------------------------------------------
//  ROTAS CLIENTE
//----------------------------------------------

//----------------------------------------------
//  SITE/ LOGIN
//----------------------------------------------
// FORM LOGIN
Route::get('login', [SiteViewsController::class, 'form_login'])->name('site_login_form')->middleware('ifAuth');
Route::get('logout', [LoginController::class, 'logout_client'])->name('logout_client');

// LOGIN COM GOOGLE
Route::get('auth/google/redirect', [GoogleLoginController::class, 'redirect'])->name('auth_google');
Route::get('auth/google/callback', [GoogleLoginController::class, 'callback']);

//-------------------------------
// SITE/ VIEWS
//-------------------------------
Route::get('/', [SiteViewsController::class, 'home_page'])->name('home_page');
Route::get('menu', [SiteViewsController::class, 'menu'])->name('menu_client');
Route::get('cart', [SiteViewsController::class, 'cart'])->name('cart')->middleware('auth:client');
Route::get('about', [SiteViewsController::class, 'about'])->name('about');
Route::get('agenda', [SiteViewsController::class, 'agenda'])->name('agenda');
Route::get('contact', [SiteViewsController::class, 'contact'])->name('contact');

//-------------------------------
// SITE/ ITEM
//-------------------------------
Route::get('get/item/show/{id}', [SaleItemsController::class, 'show']);
Route::get('get/item/additionals/{id}', [SaleItemsController::class, 'additionals'])->middleware('auth:client');
Route::put('put/add/item/cart', [SaleItemsController::class, 'create'])->middleware('auth:client');

//-------------------------------
// SITE/ COMENTARIOS
//-------------------------------
// NOVO COMENTARIO
Route::post('post/create/comment/client', [CommentsController::class, 'create'])->middleware('auth:client');

//-------------------------------
// SITE/ LIKES
//-------------------------------
// CURTIR ITEM
Route::get('get/item/like/{item}', [LikesController::class, 'like_item'])->middleware('auth:client');
// TABELA DE CURTIDOS
Route::post('post/table/item/like', [LikesController::class, 'table'])->middleware('auth:client');

//-------------------------------
// SITE/ CARRINHO
//-------------------------------
// CONTAR ITENS DO CARRINHO
Route::get('cart/item/count', [SaleItemsController::class, 'cart_count'])->middleware('auth:client');
Route::post('post/table/cart', [SaleItemsController::class, 'cart_table'])->middleware('auth:client');

//-------------------------------
// SITE/ PEDIDOS
//-------------------------------
Route::get('table/request/qr-code/client/{table}', function ($table) {
    return $table;
});

// //-------------------------------
// // TESTES
// //-------------------------------
// Route::get('teste4/', function () {
//     // auth()->guard('client')->attempt(['login' => trim('dudu.martins373@gmail.com'), 'password' => trim('Eduardo3386')]);
//     // echo auth()->guard('client')->check();
//     auth()->guard('client')->logout();
// });
// Route::get('teste3', function () {
//     echo (Redirect::intended(route('requests'))->headers->get('Location'));
//     // LoginAppModel::find(1)->update(['password' => Hash::make('xivunk')]);

//     // if (auth()->attempt(['login' => 'Eduardo', 'password' => 'xivunk'])) {
//     //     // usuário autenticado com sucesso
//     //     // return redirect()->intended('/dashboard');

//     //     echo 'logado';
//     // } else {
//     //     // credenciais inválidas
//     //     // return back()->withErrors(['email' => 'Credenciais inválidas']);
//     //     echo 'Erro';
//     // }

// });
// Route::get('teste2/{permission}', function ($permission) {
//     // Permission::create(['name' => 'Teste']);

//     // $editor = Role::create(['name' => 'Teste']);
//     // $editor->givePermissionTo('Teste');

//     $login = LoginAppModel::find(25);
//     // $login->assignRole($permission);
//     $login->givePermissionTo($permission);
//     // $login->removeRole('Dashboard');
//     // $login->revokePermissionTo('Teste');

//     // if ($login->hasRole('Teste')) {
//     //     echo 'Tem a Hole teste.';
//     // }
//     // if ($login->hasPermissionTo('Teste')) {
//     //     echo 'Tem a permissão teste.';
//     // }

// });
// Route::get('teste', function () {
//     $permissions = [
//         //     // DASHBOARD
//         //     'dashboard',
//         //     // PEDIDOS
//         //     'view_orders',
//         //     'create_order',
//         //     'delete_request',
//         //     'delete_order',
//         //     'print_requests',
//         //     'finalize_order',
//         //     // DELIVERY
//         //     'view_delivery',
//         //     'create_delivery',
//         //     'delete_delivery',
//         //     'delete_request_delivery',
//         //     'edit_delivery',
//         //     'sts_delivery',
//         //     // MESAS
//         //     'view_tables',
//         //     'qr_code_actions',
//         //     // CARDAPIO
//         //     'view_menu',
//         //     'create_item_menu',
//         //     'edit_item_menu',
//         //     'delete_item_menu',
//         //     'create_type_menu',
//         //     'edit_type_menu',
//         //     'delete_type_menu',
//         //     'create_additional_menu',
//         //     'edit_additional_menu',
//         //     'delete_additional_menu',
//         //     // CONFIG. APP
//         //     'config_app_data',
//         //     'config_app_delivery',
//         //     'config_app_email',
//         //     'config_app_theme',
//         //     // USUARIOS
//         //     'edit_user',
//         //     'create_user',
//         //     'delete_user',
//         //     'config_users',
//         //     'permissions_user',
//         // 'reset_password',
//         //     // CONFIG. SITE
//         //     'config_site',

//     ];
//     Permission::create(['name' => 'reset_password', 'display_name' => 'Resetar senha', 'group_name' => 'user']);

//     // foreach ($permissions as $permission) {
//     //     Permission::create(['name' => $permission]);
//     // }

//     // $editor = Role::create(['name' => $role]);
//     // $editor->givePermissionTo('Teste');

//     // $login = LoginAppModel::find(1);
//     // // $login->givePermissionTo('Teste');

//     // if ($login->hasRole('Teste')) {
//     //     echo 'Tem a Hole teste.';
//     // }
//     // if ($login->hasPermissionTo('Teste')) {
//     //     echo 'Tem a permissão teste.';
//     // }

// });
Route::get('teste', function () {
    $login = LoginClientModel::where('google_id', '105229560683506769316')->first();
    if ($login) {
        auth()->guard('client')->login($login);
        $user = UsersClientModel::where('login_id', auth()->guard('client')->id())->first();
        session()->put([
            'user' => [
                'name' => $user->first_name,
                'photo' => $user->photo_url,
                'email' => $user->email,
            ],
        ]);

        return redirect()->route('home_page');
    }

});
