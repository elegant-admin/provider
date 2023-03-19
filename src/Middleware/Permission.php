<?php

namespace Elegant\Admin\Middleware;

use Elegant\Admin\Facades\Admin;
use Elegant\Admin\Traits\HasResponse;
use Illuminate\Http\Request;

class Permission
{
    use HasResponse;

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle(Request $request, \Closure $next)
    {
        if (config('admin.check_permissions') === false) {
            return $next($request);
        }

        if (strpos($request->route()->action['as'],'admin') === false) {
            return $next($request);
        }

        if (!Admin::user() || $this->shouldPassThrough($request)) {
            return $next($request);
        }

        if (Admin::user()->canAccess($request->route())) {
            return $next($request);
        }

        if (!$request->pjax() && $request->ajax()) {
            return $this->response()->error(admin_trans('deny'))->send();
        }

        Pjax::respond(
            response(Admin::content()->withError(admin_trans('deny')))
        );
    }

    /**
     * Determine if the request has a URI that should pass through verification.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    protected function shouldPassThrough($request)
    {
        return collect(config('admin.auth.excepts', []))
            ->map('admin_path')
            ->contains(function ($except) use ($request) {
                if ($except !== '/') {
                    $except = trim($except, '/');
                }

                return $request->is($except);
            });
    }
}
