<?php

namespace Elegant\Admin\Controllers;

use Elegant\Admin\Form;
use Elegant\Admin\Grid;
use Elegant\Admin\Show;
use Illuminate\Support\Facades\Hash;

class UserController extends AdminController
{
    /**
     * @return array|\Illuminate\Contracts\Translation\Translator|string|null
     */
    protected function title()
    {
        return admin_trans('auth_users');
    }

    /**
     * @return \Illuminate\Config\Repository|mixed|string
     */
    protected function model()
    {
        return config('admin.database.users_model');
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new $this->model);
        $grid->model()->orderByDesc('id');

        $grid->column('id', 'ID')->sortable();
        $grid->column('username', admin_trans('username'));
        $grid->column('name', admin_trans('name'));
        $grid->column('roles', admin_trans('roles'))->pluck('name')->label();
//        $grid->column('permissions', admin_trans('permissions'))->width(500)->display(function ($permissions) {
//            $permissions = array_reduce($this->roles->pluck('permissions')->toArray(), 'array_merge', $permissions);
//            $names = [];
//            foreach (set_permissions() as $key => $value) {
//                if ($permissions && in_array($value, $permissions)) {
//                    array_push($names, $key);
//                }
//            }
//            return $names;
//        })->label();
        $grid->column('created_at', admin_trans('created_at'));
        $grid->column('updated_at', admin_trans('updated_at'));

        $grid->actions(function (Grid\Displayers\Actions $actions) {
            if ($actions->getKey() == 1) {
                $actions->disableDestroy();
            }
            if ($actions->row->deleted_at) {
                $actions->disableView();
                $actions->disableEdit();
                $actions->disableDestroy();
                $actions->add(new Grid\Actions\Restore());
                $actions->add(new Grid\Actions\Delete());
            }
        });

        $grid->tools(function (Grid\Tools $tools) {
            $tools->batch(function (Grid\Tools\BatchActions $actions) {
                $actions->disableDelete();
            });
        });

        $grid->filter(function(Grid\Filter $filter){
            $filter->disableIdFilter();
            $filter->scope('trashed', admin_trans('trashed'))->onlyTrashed();
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show($this->model::findOrFail($id));

        $show->field('id', 'ID');
        $show->field('username', admin_trans('username'));
        $show->field('name', admin_trans('name'));
        $show->field('roles', admin_trans('roles'))->as(function ($roles) {
            return $roles->pluck('name');
        })->label();
//        $show->field('permissions', admin_trans('permissions'))->as(function ($permissions) {
//            $permissions = array_reduce($this->roles->pluck('permissions')->toArray(), 'array_merge', $permissions);
//            $names = [];
//            foreach (set_permissions() as $key => $value) {
//                if ($permissions && in_array($value, $permissions)) {
//                    array_push($names, $key);
//                }
//            }
//            return $names;
//        })->label();
        $show->field('created_at', admin_trans('created_at'));
        $show->field('updated_at', admin_trans('updated_at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $roleModel = config('admin.database.roles_model');

        $form = new Form(new $this->model);

        $userTable = config('admin.database.users_table');
        $connection = config('admin.database.connection');

        $form->display('id', 'ID');
        $form->text('username', admin_trans('username'))
            ->creationRules(['required', "unique:{$connection}.{$userTable}"])
            ->updateRules(['required', "unique:{$connection}.{$userTable},username,{{id}}"]);

        $form->text('name', admin_trans('name'))->rules('required');
        $form->image('avatar', admin_trans('avatar'));
        $form->password('password', admin_trans('password'))->rules('required|confirmed');
        $form->password('password_confirmation', admin_trans('password_confirmation'))->rules('required')
            ->default(function ($form) {
                return $form->model()->password;
            });

        $form->ignore(['password_confirmation']);

        $form->multipleSelect('roles', admin_trans('roles'))
            ->options($roleModel::pluck('name', 'id'))
            ->optionDataAttributes('permissions', $roleModel::pluck('permissions', 'id'))
            ->config('maximumSelectionLength', config('admin.database.users_maximum_roles', '0'));
        $form->checkboxGroup('permissions', admin_trans('permissions'))->options(group_permissions())->related('roles', 'permissions');

        $form->display('created_at', admin_trans('created_at'));
        $form->display('updated_at', admin_trans('updated_at'));

        $form->saving(function (Form $form) {
            if ($form->password && $form->model()->password != $form->password) {
                $form->password = Hash::make($form->password);
            }
        });

        return $form;
    }
}
