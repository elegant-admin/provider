<div class="box">

    <div class="box-header">

        <div class="btn-group">
            <a class="btn btn-primary btn-sm {{ $id }}-tree-tools" data-action="expand" title="{{ admin_trans('expand') }}">
                <i class="fa fa-plus-square-o"></i>&nbsp;{{ admin_trans('expand') }}
            </a>
            <a class="btn btn-primary btn-sm {{ $id }}-tree-tools" data-action="collapse" title="{{ admin_trans('collapse') }}">
                <i class="fa fa-minus-square-o"></i>&nbsp;{{ admin_trans('collapse') }}
            </a>
        </div>

        @if(($useSave && !$trashed) || ($useSave && $trashed && !$requestTrashed))
        <div class="btn-group">
            <a class="btn btn-info btn-sm {{ $id }}-save" title="{{ admin_trans('save') }}"><i class="fa fa-save"></i><span class="hidden-xs">&nbsp;{{ admin_trans('save') }}</span></a>
        </div>
        @endif

        @if($trashed && $requestTrashed)
        <div class="btn-group">
            <a href="{{ $url }}" class="btn btn-default btn-sm {{ $id }}-cancel" title="{{ admin_trans('cancel') }}"><i class="fa fa-times"></i><span class="hidden-xs">&nbsp;{{ admin_trans('cancel') }}</span></a>
        </div>
        @endif

        @if($trashed && !$requestTrashed)
        <div class="btn-group">
            <a href="{{ $url }}?&_scope_=trashed" class="btn btn-success btn-sm {{ $id }}-trashed" title="{{ admin_trans('trashed') }}"><i class="fa fa-trash"></i><span class="hidden-xs">&nbsp;{{ admin_trans('trashed') }}</span></a>
        </div>
        @endif

        <div class="btn-group">
            {!! $tools !!}
        </div>

        @if($useCreate)
        <div class="btn-group pull-right">
            <a class="btn btn-success btn-sm" href="{{ $url }}/create"><i class="fa fa-save"></i><span class="hidden-xs">&nbsp;{{ admin_trans('new') }}</span></a>
        </div>
        @endif

    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive no-padding">
        <div class="dd" id="{{ $id }}">
            <ol class="dd-list">
                @include($branchView, ['branchs' => $items])
            </ol>
        </div>
    </div>
    <!-- /.box-body -->
</div>
