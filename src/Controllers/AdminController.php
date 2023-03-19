<?php

namespace Elegant\Admin\Controllers;

use Elegant\Admin\Layout\Content;
use Elegant\Admin\Traits\HasResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Controller;

class AdminController extends Controller
{
    use HasResourceActions;
    use HasResponse;

    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Title';

    /**
     * Set description for following 4 action pages.
     *
     * @var array
     */
    protected $description = [
        //        'index'  => 'Index',
        //        'show'   => 'Show',
        //        'edit'   => 'Edit',
        //        'create' => 'Create',
    ];

    /**
     * @var Model
     */
    protected $model = 'Model::class';

    /**
     * AdminController constructor.
     */
    public function __construct()
    {
        if (method_exists($this, 'model')) {
            $this->model = $this->model();
        }

        if (method_exists($this, 'title')) {
            $this->title = $this->title();
        }
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
            ->title($this->title)
            ->description($this->description['index'] ?? admin_trans('list'))
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed   $id
     * @param Content $content
     *
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->title($this->title)
            ->description($this->description['show'] ?? admin_trans('show'))
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed   $id
     * @param Content $content
     *
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->title($this->title)
            ->description($this->description['edit'] ?? admin_trans('edit'))
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     *
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->title($this->title)
            ->description($this->description['create'] ?? admin_trans('create'))
            ->body($this->form());
    }
}
