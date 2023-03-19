<?php

namespace Elegant\Admin\Grid\Actions;

use Elegant\Admin\Actions\Response;
use Elegant\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Destroy extends RowAction
{
    /**
     * @var string
     */
    protected $method = 'DELETE';

    /**
     * @return array|null|string
     */
    public function name()
    {
        return admin_trans('destroy');
    }

    /**
     * @return string
     */
    public function getHandleRoute()
    {
        return "{$this->getResource()}/{$this->getKey()}";
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
//                $model->delete();
//            });
//        } catch (\Exception $exception) {
//            return $this->response()->error(admin_trans('destroy_failed') . ": {$exception->getMessage()}");
//        }
//
//        return $this->response()->success(admin_trans('destroy_succeeded'))->refresh();
//    }

    /**
     * @return void
     */
    public function dialog()
    {
        $this->question(admin_trans('destroy_confirm'), '', ['confirmButtonColor' => '#d33']);
    }
}
