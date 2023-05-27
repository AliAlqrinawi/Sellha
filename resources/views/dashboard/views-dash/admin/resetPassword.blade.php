@extends('dashboard.layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/jquery-nice-select/css/nice-select.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"> Dashboard </h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0"> / Change Password</span>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            @if(Session::has('danger'))
                <div class="alert alert-danger">
                    {{ Session::get('danger') }}
                </div>
            @endif
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
                        action="{{ route('admin.resetPassword') }}" method="post">
                        {{ csrf_field() }}
                        <div class="">
                            <div class="row mg-b-20">
                                <div class="parsley-input col-md-12 mg-t-20 mg-md-t-0" id="lnWrapper">
                                    <label>Old Password : <span class="tx-danger">*</span></label>
                                    <input class="form-control mg-b-20" data-parsley-class-handler="#lnWrapper"
                                        name="old_password" type="password">
                                </div>
                            </div>

                            <div class="row mg-b-20">
                                <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                    <label>New Password : <span class="tx-danger">*</span></label>
                                    <input class="form-control mg-b-20" data-parsley-class-handler="#lnWrapper"
                                        name="new_password" type="password">
                                </div>
                                <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                    <label> Password Confirmation : <span class="tx-danger">*</span></label>
                                    <input class="form-control mg-b-20" data-parsley-class-handler="#lnWrapper"
                                        name="confirm_password" type="password">
                                </div>
                            </div>

                            <div class="mg-t-30">
                                <button class="btn btn-main-primary pd-x-20" type="submit">Update</button>
                                <a class="btn btn-secondary" data-effect="effect-scale"
                                    style="font-weight: bold; color: beige;" href="{{ url('/admin/home') }}">Close</a>
                            </div>
                    </form>
                </div>
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
