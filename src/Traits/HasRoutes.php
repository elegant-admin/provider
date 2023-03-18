<?php

namespace Elegant\Admin\Traits;

use Elegant\Admin\Controllers\AuthController;
use Elegant\Admin\Controllers\LogController;
use Elegant\Admin\Controllers\MenuController;
use Elegant\Admin\Controllers\RoleController;
use Elegant\Admin\Controllers\UserController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

trait HasRoutes
{
    /**
     * Register the builtin routes.
     *
     * @return void
     *
     * @deprecated Use Admin::routes() instead();
     */
    public function registerAuthRoutes()
    {
        $this->routes();
    }

    /**
     * Register the builtin routes.
     *
     * @return void
     */
    public function routes()
    {
        $attributes = [
            'prefix'     => config('admin.route.prefix'),
            'middleware' => config('admin.route.middleware'),
        ];

        app('router')->group($attributes, function ($router) {
            /* @var Router $router */
            $authController = config('admin.auth.auth_controller', AuthController::class);
            $router->get('login', $authController.'@getLogin')->name('admin.login');
            $router->post('login', $authController.'@postLogin')->name('admin.login_post');
            $router->get('logout', $authController.'@getLogout')->name('admin.logout');
            $router->get('self_setting', $authController.'@getSetting')->name('admin.self_setting');
            $router->put('self_setting', $authController.'@putSetting')->name('admin.self_setting_put');

            $userController = config('admin.database.users_controller', UserController::class);
            $router->resource('auth_users', $userController)->names('admin.auth_users');
            $router->put('auth_users/{auth_user}/restore', $userController.'@restore')->name('admin.auth_users.restore');
            $router->delete('auth_users/{auth_user}/delete', $userController.'@delete')->name('admin.auth_users.delete');

            $roleController = config('admin.database.roles_controller', RoleController::class);
            $router->resource('auth_roles', $roleController)->names('admin.auth_roles');
            $router->put('auth_roles/{auth_role}/restore', $roleController.'@restore')->name('admin.auth_roles.restore');
            $router->delete('auth_roles/{auth_role}/delete', $roleController.'@delete')->name('admin.auth_roles.delete');

            $menuController = config('admin.database.menus_controller', MenuController::class);
            $router->resource('auth_menus', $menuController, ['except' => ['create']])->names('admin.auth_menus');
            $router->put('auth_menus/{auth_menu}/restore', $menuController.'@restore')->name('admin.auth_menus.restore');
            $router->delete('auth_menus/{auth_menu}/delete', $menuController.'@delete')->name('admin.auth_menus.delete');

            $logController = config('admin.database.logs_controller', LogController::class);
            $router->resource('auth_logs', $logController, ['only' => ['index', 'destroy']])->names('admin.auth_logs');

            /* @var Route $router */
            $router->namespace('\Elegant\Admin\Controllers')->group(function ($router) {
                /* @var Router $router */
                $router->post('_handle_form_', 'HandleController@handleForm')->name('handle_form');
                $router->post('_handle_action_', 'HandleController@handleAction')->name('handle_action');
                $router->get('_handle_selectable_', 'HandleController@handleSelectable')->name('handle_selectable');
                $router->get('_handle_renderable_', 'HandleController@handleRenderable')->name('handle_renderable');
            });
        });
    }
}
