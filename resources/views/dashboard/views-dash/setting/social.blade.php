@extends('layouts.master')
@section('css')

@section('title')
المستخدمين
@stop

<!-- Internal Data table css -->

<link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
<!--Internal   Notify -->
<link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />

@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">{{ trans('app_users.Home') }}</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0"> / {{trans('setting.page_title')}}</span>

        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection

@section('content')
    <div class="main-body">
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@elseif( session('delete') )
<div class="alert alert-danger ">
    {{ session('delete') }}
</div>
@endif

<!-- row opened -->
<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <h4> {{trans('setting.social')}}</h4>
                <hr>
            </div>
            <div class="card-body">
            @can('setting-view')
                <form action="{{route('setting.update')}}" method="post" autocomplete="off"
                    enctype="multipart/form-data">
                    {{ csrf_field() }}
                    @foreach ($settings as $key => $x)
                    <div class="form-group">
                        @if (App::getLocale() == 'en')
                        <label class="col-md-3 control-label" for="site_title">{{ $x->title_en }} : </label>
                        @else
                        <label class="col-md-3 control-label" for="site_title">{{ $x->title_ar }} : </label>
                        @endif
                        <div class="col-md-10">
                            <textarea id="site_title" name=" {{ $x->key_id }}"
                                class="form-control">@if(isset($x->value)){{$x->value}}@endif</textarea>
                        </div>
                    </div>
                    @endforeach
                    <hr>
                    @can('setting-create')
                    <button type="submit" class="btn btn-info-gradient btn-block col-sm-2">
                        <a href="#" style="font-weight: bold; color: beige;">{{trans('setting.edit')}}</a>
                    </button>
                    @endcan
                </form>
            @endcan
            </div>
        </div>
    </div>
    <!--/div-->

    <!-- Modal effects -->
    <div class="modal" id="modaldemo8">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{trans('users_admin.delete_users')}}</h6><button aria-label="Close"
                        class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <form action="match/destroy" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p>{{trans('users_admin.delete_message2')}}</p><br>
                        <input type="hidden" name="id" id="user_id" value="">
                        <input class="form-control" name="username" id="username" type="text" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{trans('users_admin.Close')}}</button>
                        <button type="submit" class="btn btn-danger">{{trans('users_admin.Submit')}}</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

</div>
<!-- /row -->
</div>
@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
<!--Internal  Datatable js -->
<script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
<!--Internal  Notify js -->
<script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
<!-- Internal Modal js-->
<script src="{{ URL::asset('assets/js/modal.js') }}"></script>

<script>
$('#modaldemo8').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget)
    var user_id = button.data('user_id')
    var username = button.data('username')
    var modal = $(this)
    modal.find('.modal-body #user_id').val(user_id);
    modal.find('.modal-body #username').val(username);
})
</script>


@endsection
