<div class="btn-group pull-right" style="margin-right: 10px">
    <a href="" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#{{ $modalID }}"><i class="fa fa-filter"></i>&nbsp;&nbsp;{{ admin_trans('filter') }}</a>
    <a href="{!! $action !!}" class="btn btn-sm btn-facebook"><i class="fa fa-undo"></i>&nbsp;&nbsp;{{ admin_trans('reset') }}</a>
</div>

<div class="modal fade" id="{{ $modalID }}" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">{{ admin_trans('filter') }}</h4>
            </div>
            <form action="{!! $action !!}" method="get" pjax-container>
                <div class="modal-body">
                    <div class="form">
                        @foreach($filters as $filter)
                            <div class="form-group">
                                {!! $filter->render() !!}
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary submit">{{ admin_trans('submit') }}</button>
                    <button type="reset" class="btn btn-warning pull-left">{{ admin_trans('reset') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
