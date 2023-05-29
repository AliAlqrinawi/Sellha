@extends('dashboard.layouts.master')
@section('title', __('Profile'))
@section('css')
@stop

@section('content')
@if ($errors->any())
<div class="alert alert-danger" style="margin: 15px">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
@if(Session::has('success'))
<div class="alert alert-success">
    {{Session::get('success')}}
</div>
@endif
    <div class="row row-sm">
        <div class="col-xl-4">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="ps-0">
                        <div class="main-profile-overview">
                            <div class="main-img-user profile-user">
                                <img alt="" src="{{ Request::root() . '/' . $user->profile->avatar }}">
                            </div>
                            <div class="d-flex justify-content-between mg-b-20">
                                <div>
                                    <h5 class="main-profile-name"> {{ $user->name }}</h5>
                                </div>
                            </div>
                            <h6>{{ __('About') }}</h6>
                            <div class="main-profile-bio">
                                {{ $user->profile->about }}
                            </div><!-- main-profile-bio -->
                            <hr class="mg-y-30">
                            <h6>{{ __('verification') }}</h6>
                            <div class="skill-bar mb-4 clearfix mt-3">
                                <span>{{ __('Account verification') }}</span>
                                <div class="progress mt-2">
                                    <div class="progress-bar bg-primary-gradient" role="progressbar" aria-valuenow="{{ $user->verification * 33.33 }}"
                                        aria-valuemin="0" aria-valuemax="100" style="width: {{ $user->verification * 33.33 }}%"></div>
                                </div>
                            </div>
                            <!--skill bar-->
                        </div><!-- main-profile-overview -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="row row-sm">
                <div class="col-sm-12 col-xl-4 col-lg-12 col-md-12">
                    <div class="card ">
                        <div class="card-body">
                            <div class="counter-status d-flex md-mb-0">
                                <div class="counter-icon bg-primary-transparent">
                                    <i class="icon-layers text-primary"></i>
                                </div>
                                <div class="ms-auto">
                                    <h5 class="tx-13">{{ __('Orders') }}</h5>
                                    <h2 class="mb-0 tx-22 mb-1 mt-1">{{ $user->orders_count }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-xl-4 col-lg-12 col-md-12">
                    <div class="card ">
                        <div class="card-body">
                            <div class="counter-status d-flex md-mb-0">
                                <div class="counter-icon bg-danger-transparent">
                                    <i class="icon-paypal text-danger"></i>
                                </div>
                                <div class="ms-auto">
                                    <h5 class="tx-13">{{ __('Products') }}</h5>
                                    <h2 class="mb-0 tx-22 mb-1 mt-1">{{ $user->products_count }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-xl-4 col-lg-12 col-md-12">
                    <div class="card ">
                        <div class="card-body">
                            <div class="counter-status d-flex md-mb-0">
                                <div class="counter-icon bg-success-transparent">
                                    <i class="icon-rocket text-success"></i>
                                </div>
                                <div class="ms-auto">
                                    <h5 class="tx-13">{{ __('Total orders') }}</h5>
                                    <h2 class="mb-0 tx-22 mb-1 mt-1">{{ $user->orders_sum_total ?? 0 }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="tabs-menu ">
                        <!-- Tabs -->
                        <ul class="nav nav-tabs profile navtab-custom panel-tabs">
                            <li class="">
                                <a href="#home" data-bs-toggle="tab" class="active" aria-expanded="true"> <span
                                        class="visible-xs"><i class="las la-user-circle tx-16 me-1"></i></span> <span
                                        class="hidden-xs">{{ __('Details') }}</span> </a>
                            </li>
                            <li class="">
                                <a href="#settings" data-bs-toggle="tab" aria-expanded="false"> <span
                                        class="visible-xs"><i class="las la-cog tx-16 me-1"></i></span>
                                    <span class="hidden-xs">{{ __('Modification') }}</span> </a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content border border-top-0 p-4 br-dark">
                        <div class="tab-pane active" id="home">
                            <h4 class="tx-15 text-uppercase mb-3">{{ __('About') }}</h4>
                            <p class="m-b-5">{{ $user->profile->about }}</p>
                            <div class="m-t-30">
                                <h4 class="tx-15 text-uppercase mt-3">{{ __('User Name') }}</h4>
                                <div class=" p-t-10">
                                    <h5 class="text-primary m-b-5 tx-14">{{ $user->profile->user_name }}</h5>
                                </div>
                                <hr>
                                <h4 class="tx-15 text-uppercase mt-3">{{ __('Email') }}</h4>
                                <div class=" p-t-10">
                                    <h5 class="text-primary m-b-5 tx-14">{{ $user->profile->email }}</h5>
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="tab-pane" id="settings">
                            <form action="{{ route('profile.update1' , $user->profile->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="form-group">
                                    <label for="name">{{ __('User Name') }}</label>
                                    <input type="text" value="{{ $user->profile->user_name }}" name="user_name" id="name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="phone">{{ __('Phone') }}</label>
                                    <input type="number" value="{{ $user->phone }}" name="phone" id="phone"
                                        class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="email">{{ __('Email') }}</label>
                                    <input type="email" value="{{ $user->profile->email }}" name="email" id="email"
                                        class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="distance">{{ __('Distance') }} :</label>
                                    <select name="distance" id="distance" class="form-control">
                                        <option value="MILE">{{ __('MILE') }}</option>
                                        <option value="KILO">{{ __('KILO') }}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="avatar">{{ __('Avatar') }}</label>
                                    <input type="file" name="avatar" id="avatar" class="form-control"  accept="image/png, image/jpeg">
                                </div>
                                <div class="form-group">
                                    <label for="about">{{ __('About') }}</label>
                                    <textarea id="about" name="about" class="form-control">{{ $user->profile->about }}</textarea>
                                </div>
                                <button class="btn btn-primary waves-effect waves-light w-md" type="submit">{{ __('Save') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@stop
