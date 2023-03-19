<?php

namespace Elegant\Admin\Controllers;

use Elegant\Admin\Form;
use Elegant\Admin\Layout\Column;
use Elegant\Admin\Layout\Content;
use Elegant\Admin\Layout\Row;
use Elegant\Admin\Show;
use Elegant\Admin\Tree;
use Elegant\Admin\Widgets\Box;

class MenuController extends AdminController
{
    protected function title()
    {
        return admin_trans('auth_menus');
    }

    /**
     * @return \Illuminate\Config\Repository|mixed|string
     */
    protected function model()
    {
        return config('admin.database.menus_model');
    }

    /**
     * Index interface.
     *
     * @param Content $content
     *
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->title($this->title())
            ->description(admin_trans('list'))
            ->row(function (Row $row) {
                $row->column(6, $this->treeView()->render());

                $row->column(6, function (Column $column) {
                    $form = new \Elegant\Admin\Widgets\Form();
                    $form->action(admin_url('auth_menus'));

                    $form->select('parent_id', admin_trans('parent_id'))->options($this->model::selectOptions())->default(0);
                    $form->text('title', admin_trans('title'))->rules('required')->help(admin_trans('menus_title_help'));
                    $form->icon('icon', admin_trans('icon'))->default('fa-bars')->rules('required')->help($this->iconHelp());
                    $form->text('uri', admin_trans('uri'));

                    $form->hidden('_token')->default(csrf_token());

                    $column->append((new Box(admin_trans('new'), $form))->style('success'));
                });
            });
    }

    /**
     * @return \Elegant\Admin\Tree
     */
    protected function treeView()
    {
        $menuModel = config('admin.database.menus_model');

        $tree = new Tree(new $menuModel());

        $tree->disableCreate();

        $tree->branch(function ($branch) {
            $payload = "<i class='fa {$branch['icon']}'></i>&nbsp;<strong>" . admin_trans($branch['title']) . "</strong>";

            if (!isset($branch['children'])) {
                if (url()->isValidUrl($branch['uri'])) {
                    $uri = $branch['uri'];
                } else {
                    $uri = admin_url($branch['uri']);
                }

                $payload .= "&nbsp;&nbsp;&nbsp;<a href=\"$uri\" class=\"dd-nodrag\">$uri</a>";
            }

            return $payload;
        });

        $tree->enableTrashed();

        $tree->actions(function (Tree\Displayers\Actions $actions) {
//            $actions->useColumnEdit('title', admin_trans('title'));
            if ($actions->trashed && $actions->requestTrashed) {
                $actions->disableEdit();
                $actions->disableView();
                $actions->disableDestroy();
            }

            if ($actions->row['deleted_at']) {
                $actions->add(new Tree\Actions\Restore());
                $actions->add(new Tree\Actions\Delete());
            }
        });

        return $tree;
    }

    protected function detail($id)
    {
        $show = new Show($this->model::findOrFail($id));

        $show->field('id', 'ID');

        $show->field('title', admin_trans('title'));
        $show->field('uri', admin_trans('uri'));

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
        $form = new Form(new $this->model);

        $form->display('id', 'ID');

        $form->select('parent_id', admin_trans('parent_id'))->options($this->model::selectOptions());
        $form->text('title', admin_trans('title'))->rules('required')->help(admin_trans('menus_title_help'));
        $form->icon('icon', admin_trans('icon'))->default('fa-bars')->rules('required')->help($this->iconHelp());
        $form->text('uri', admin_trans('uri'));

        $form->display('created_at', admin_trans('created_at'));
        $form->display('updated_at', admin_trans('updated_at'));

        return $form;
    }

    /**
     * Help message for icon field.
     *
     * @return string
     */
    protected function iconHelp()
    {
        return 'For more icons please see <a href="http://fontawesome.io/icons/" target="_blank">http://fontawesome.io/icons/</a>';
    }
}
