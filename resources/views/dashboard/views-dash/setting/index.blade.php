@extends('dashboard.layouts.master')
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
<!-- include libraries(jQuery, bootstrap) -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<!-- include summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Dashboard</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0"> / Settings</span>

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

                <h4>Social media</h4>
                <hr>
            </div>

            <div class="card-body">
                <form action="{{route('setting.update' , 1)}}" method="POST">
                    {{ csrf_field() }}
                    @method('PUT')
                    @foreach ($settings as $key => $x)
                    <div class="form-group">
                        @if (App::getLocale() == 'en')
                        <label class="col-md-3 control-label">{{ $x->label_en }} : </label>
                        @else
                        <label class="col-md-3 control-label">{{ $x->label_ar }} : </label>
                        @endif
                        <div class="col-md-12">
                            <input type="{{$x->type }}" name="{{ $x->key }}"
                            class="form-control" required
                            value="@if(isset($x->value)){{$x->value}}@endif">
                        </div>
                    </div>
                    @endforeach
                    <hr>
                    <button type="submit" class="btn btn-info-gradient btn-block col-sm-2">
                        Update
                    </button>
                </form>
            </div>
        </div>
    </div>
    <!--/div-->
</div>
    </div>
@endsection
@section('js')
@endsection
