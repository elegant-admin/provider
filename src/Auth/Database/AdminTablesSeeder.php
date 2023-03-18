<?php

namespace Elegant\Admin\Auth\Database;

use Elegant\Admin\Auth\Database\Log;
use Elegant\Admin\Auth\Database\Menu;
use Elegant\Admin\Auth\Database\Role;
use Elegant\Admin\Auth\Database\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create a user.
        User::query()->truncate();
        User::query()->create([
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'name'     => 'super_administrator',
            'permissions' => [],
        ]);

        // create a role.
        Role::query()->truncate();
        Role::query()->create([
            'name'        => 'super_administrator',
            'slug'        => 'administrator',
            'permissions' => ["*"],
        ]);

        // add role to user.
        DB::table(config('admin.database.user_roles_table'))->truncate();
        User::query()->first()->roles()->save(Role::query()->first());

        // add default menus.
        Menu::query()->truncate();
        Menu::query()->insert([
            [
                'parent_id' => 0,
                'order'     => 1,
                'title'     => 'home',
                'icon'      => 'fa-bar-chart',
                'uri'       => '/',
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ],
            [
                'parent_id' => 0,
                'order'     => 2,
                'title'     => 'administration',
                'icon'      => 'fa-tasks',
                'uri'       => '',
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ],
            [
                'parent_id' => 2,
                'order'     => 3,
                'title'     => 'auth_users',
                'icon'      => 'fa-users',
                'uri'       => 'auth_users',
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ],
            [
                'parent_id' => 2,
                'order'     => 4,
                'title'     => 'auth_roles',
                'icon'      => 'fa-user',
                'uri'       => 'auth_roles',
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ],
            [
                'parent_id' => 2,
                'order'     => 5,
                'title'     => 'auth_menus',
                'icon'      => 'fa-bars',
                'uri'       => 'auth_menus',
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ],
            [
                'parent_id' => 2,
                'order'     => 6,
                'title'     => 'auth_logs',
                'icon'      => 'fa-history',
                'uri'       => 'auth_logs',
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ],
        ]);

        Log::query()->truncate();
    }
}
