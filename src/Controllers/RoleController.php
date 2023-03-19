<?php

namespace Elegant\Admin\Controllers;

use Elegant\Admin\Form;
use Elegant\Admin\Grid;
use Elegant\Admin\Show;

class RoleController extends AdminController
{
    /**
     * @return array|\Illuminate\Contracts\Translation\Translator|string|null
     */
    protected function title()
    {
        return admin_trans('auth_roles');
    }

    /**
     * @return \Illuminate\Config\Repository|mixed|string
     */
    protected function model()
    {
        return config('admin.database.roles_model');
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new $this->model());
        $grid->model()->orderByDesc('id');

        $grid->column('id', 'ID')->sortable();
        $grid->column('slug', admin_trans('slug'));
        $grid->column('name', admin_trans('name'));
//        $grid->column('permissions', admin_trans('permissions'))->width(500)->display(function ($permissions) {
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
            if ($actions->row->slug == 'administrator') {
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
        $show->field('slug', admin_trans('slug'));
        $show->field('name', admin_trans('name'));
//        $show->field('permissions', admin_trans('permissions'))->as(function ($permissions) {
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
        $form = new Form(new $this->model());

        $form->display('id', 'ID');

        $form->text('slug', admin_trans('slug'))->rules('required');
        $form->text('name', admin_trans('name'))->rules('required');
        $form->checkboxGroup('permissions', admin_trans('permissions'))->options(group_permissions());

        $form->display('created_at', admin_trans('created_at'));
        $form->display('updated_at', admin_trans('updated_at'));

        return $form;
    }
}
