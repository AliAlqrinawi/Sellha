@extends('dashboard.layouts.master')
@section('css')
    <!-- Internal Nice-select css  -->
    <link href="{{ URL::asset('assets/plugins/jquery-nice-select/css/nice-select.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"> Dashboard </h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0"> / Change Profile</span>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <br>
                    <form class="parsley-style-1" id="selectForm2" autocomplete="off" name="selectForm2"
                        action="{{ route('admin.updat') }}" method="post">
                        {{ csrf_field() }}
                        <div class="">
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <div class="row mg-b-20">
                                <div class="parsley-input col-md-6" id="fnWrapper">
                                    <label>Name : <span class="tx-danger">*</span></label>
                                    <input class="form-control form-control-md mg-b-20"
                                        data-parsley-class-handler="#lnWrapper" value="{{ $user->name }}" name="name"
                                        required="" type="text">
                                </div>

                                <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                    <label>E-mail : <span class="tx-danger">*</span></label>
                                    <input class="form-control form-control-md mg-b-20"
                                        data-parsley-class-handler="#lnWrapper" value="{{ $user->email }}" name="email"
                                        required="" type="email">
                                </div>
                            </div>
                            <div class="row mg-b-20">
                            </div>
                        </div>
                        <div class="mg-t-30">
                            <button class="btn btn-main-primary pd-x-20"
                                type="submit">Update</button>
                            <a class="btn btn-secondary" data-effect="effect-scale" style="font-weight: bold; color: beige;"
                                href="{{ url('/admin/home') }}">Close</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <!-- Internal Nice-select js-->
    <script src="{{ URL::asset('assets/plugins/jquery-nice-select/js/jquery.nice-select.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery-nice-select/js/nice-select.js') }}"></script>
    <!--Internal  Parsley.min js -->
    <script src="{{ URL::asset('assets/plugins/parsleyjs/parsley.min.js') }}"></script>
    <!-- Internal Form-validation js -->
    <script src="{{ URL::asset('assets/js/form-validation.js') }}"></script>
@endsection
