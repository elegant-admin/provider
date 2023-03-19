<?php

namespace Elegant\Admin\Grid\Actions;

use Elegant\Admin\Actions\Response;
use Elegant\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Restore extends RowAction
{
    /**
     * @var string
     */
    protected $method = 'PUT';

    /**
     * @return array|null|string
     */
    public function name()
    {
        return admin_trans('restore');
    }

    /**
     * @return string
     */
    public function getHandleRoute()
    {
        return "{$this->getResource()}/{$this->getKey()}/restore";
    }

    /**
     * @param Model $model
     *
     * @return Response
     */
//    public function handle(Model $model)
//    {
//        try {
//            DB::transaction(function () use ($model) {
//                $model->restore();
//            });
//        } catch (\Exception $exception) {
//            return $this->response()->error(admin_trans('restore_failed') . ": {$exception->getMessage()}");
//        }
//
//        return $this->response()->success(admin_trans('restore_succeeded'))->refresh();
//    }

    /**
     * @return void
     */
    public function dialog()
    {
        $this->question(admin_trans('restore_confirm'), '', ['confirmButtonColor' => '#d33']);
    }
}
