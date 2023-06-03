<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'en' ? 'ltr' : 'rtl' }}">

<head>

    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title -->
    <title> @yield('title', env('APP_NAME')) </title>

    <!-- CSS -->
    @include('dashboard.layouts.css')

</head>

<body class="main-body app sidebar-mini {{ app()->getLocale() == 'en' ? 'ltr' : 'rtl' }}" style="font-family: cairo, sans-serif;font-style: normal;font-weight: 200;">

    <!-- Loader -->
    <div id="global-loader">
        <img src="{{ asset('dashboard/img/svgicons/loader.svg') }}" class="loader-img" alt="Loader">
    </div>
    <!-- /Loader -->

    <!-- Page -->
    <div class="page">
        <div>
            <!-- main-header -->
            @include('dashboard.layouts.header')
            <!-- /main-header -->

            <!-- main-sidebar -->
            @include('dashboard.layouts.sidebar')
            <!-- main-sidebar -->
        </div>

        <!-- main-content -->
        <div class="main-content app-content">

            <!-- container -->
            <div class="main-container container-fluid">

                <!-- breadcrumb -->
                <div class="breadcrumb-header justify-content-between">
                    <div class="left-content">
                        <div>
                            <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">{{ __('Hi, welcome back!') }}</h2>
                            <p class="mg-b-0">{{ __('Sales monitoring dashboard template.') }}</p>
                        </div>
                    </div>
                </div>
                @yield('content')
            </div>
            <!-- /Container -->
        </div>
        <!-- /main-content -->

        <!-- Sidebar-right-->
        <div class="sidebar sidebar-right sidebar-animate">
            <div class="panel panel-primary card mb-0 box-shadow">
                <div class="tab-menu-heading border-0 p-3">
                    <div class="card-title mb-0">Notifications</div>
                    <div class="card-options ms-auto">
                        <a href="javascript:void(0);" class="sidebar-remove"><i class="fe fe-x"></i></a>
                    </div>
                </div>
                <div class="panel-body tabs-menu-body latest-tasks p-0 border-0">
                    <div class="tabs-menu ">
                        <!-- Tabs -->
                        <ul class="nav panel-tabs">
                            <li class=""><a href="#side1" class="active" data-bs-toggle="tab"><i
                                        class="fe fe-message-circle tx-15 me-2"></i> Chat</a></li>
                            <li><a href="#side2" data-bs-toggle="tab"><i class="fe fe-bell tx-15 me-2"></i>
                                    Notifications</a></li>
                            <li><a href="#side3" data-bs-toggle="tab"><i class="fe fe-users tx-15 me-2"></i>
                                    Friends</a></li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active " id="side1">
                            <div class="list d-flex align-items-center border-bottom p-3">
                                <div class="">
                                    <span class="avatar bg-primary brround avatar-md">CH</span>
                                </div>
                                <a class="wrapper w-100 ms-3" href="javascript:void(0);">
                                    <p class="mb-0 d-flex ">
                                        <b>New Websites is Created</b>
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <i class="mdi mdi-clock text-muted me-1"></i>
                                            <small class="text-muted ms-auto">30 mins ago</small>
                                            <p class="mb-0"></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="list d-flex align-items-center border-bottom p-3">
                                <div class="">
                                    <span class="avatar bg-danger brround avatar-md">N</span>
                                </div>
                                <a class="wrapper w-100 ms-3" href="javascript:void(0);">
                                    <p class="mb-0 d-flex ">
                                        <b>Prepare For the Next Project</b>
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <i class="mdi mdi-clock text-muted me-1"></i>
                                            <small class="text-muted ms-auto">2 hours ago</small>
                                            <p class="mb-0"></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="list d-flex align-items-center border-bottom p-3">
                                <div class="">
                                    <span class="avatar bg-info brround avatar-md">S</span>
                                </div>
                                <a class="wrapper w-100 ms-3" href="javascript:void(0);">
                                    <p class="mb-0 d-flex ">
                                        <b>Decide the live Discussion</b>
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <i class="mdi mdi-clock text-muted me-1"></i>
                                            <small class="text-muted ms-auto">3 hours ago</small>
                                            <p class="mb-0"></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="list d-flex align-items-center border-bottom p-3">
                                <div class="">
                                    <span class="avatar bg-warning brround avatar-md">K</span>
                                </div>
                                <a class="wrapper w-100 ms-3" href="javascript:void(0);">
                                    <p class="mb-0 d-flex ">
                                        <b>Meeting at 3:00 pm</b>
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <i class="mdi mdi-clock text-muted me-1"></i>
                                            <small class="text-muted ms-auto">4 hours ago</small>
                                            <p class="mb-0"></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="list d-flex align-items-center border-bottom p-3">
                                <div class="">
                                    <span class="avatar bg-success brround avatar-md">R</span>
                                </div>
                                <a class="wrapper w-100 ms-3" href="javascript:void(0);">
                                    <p class="mb-0 d-flex ">
                                        <b>Prepare for Presentation</b>
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <i class="mdi mdi-clock text-muted me-1"></i>
                                            <small class="text-muted ms-auto">1 day ago</small>
                                            <p class="mb-0"></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="list d-flex align-items-center border-bottom p-3">
                                <div class="">
                                    <span class="avatar bg-pink brround avatar-md">MS</span>
                                </div>
                                <a class="wrapper w-100 ms-3" href="javascript:void(0);">
                                    <p class="mb-0 d-flex ">
                                        <b>Prepare for Presentation</b>
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <i class="mdi mdi-clock text-muted me-1"></i>
                                            <small class="text-muted ms-auto">1 day ago</small>
                                            <p class="mb-0"></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="list d-flex align-items-center border-bottom p-3">
                                <div class="">
                                    <span class="avatar bg-purple brround avatar-md">L</span>
                                </div>
                                <a class="wrapper w-100 ms-3" href="javascript:void(0);">
                                    <p class="mb-0 d-flex ">
                                        <b>Prepare for Presentation</b>
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <i class="mdi mdi-clock text-muted me-1"></i>
                                            <small class="text-muted ms-auto">45 minutes ago</small>
                                            <p class="mb-0"></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="list d-flex align-items-center p-3">
                                <div class="">
                                    <span class="avatar bg-blue brround avatar-md">U</span>
                                </div>
                                <a class="wrapper w-100 ms-3" href="javascript:void(0);">
                                    <p class="mb-0 d-flex ">
                                        <b>Prepare for Presentation</b>
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <i class="mdi mdi-clock text-muted me-1"></i>
                                            <small class="text-muted ms-auto">2 days ago</small>
                                            <p class="mb-0"></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="tab-pane  " id="side2">
                            <div class="list-group list-group-flush ">
                                <div class="list-group-item d-flex  align-items-center">
                                    <div>
                                        <span class="avatar avatar-lg brround cover-image"
                                            data-bs-image-src="{{ asset('dashboard/img/users/12.jpg') }}"><span
                                                class="avatar-status bg-success"></span></span>
                                    </div>
                                    <div class="ms-3">
                                        <strong>Madeleine</strong> Hey! there I' am available....
                                        <div class="small text-muted">
                                            3 hours ago
                                        </div>
                                    </div>
                                </div>
                                <div class="list-group-item d-flex  align-items-center">
                                    <div>
                                        <span class="avatar avatar-lg brround cover-image"
                                            data-bs-image-src="{{ asset('dashboard/img/users/1.jpg') }}"></span>
                                    </div>
                                    <div class="ms-3">
                                        <strong>Anthony</strong> New product Launching...
                                        <div class="small text-muted">
                                            5 hour ago
                                        </div>
                                    </div>
                                </div>
                                <div class="list-group-item d-flex  align-items-center">
                                    <div>
                                        <span class="avatar avatar-lg brround cover-image"
                                            data-bs-image-src="{{ asset('dashboard/img/users/2.jpg') }}"><span
                                                class="avatar-status bg-success"></span></span>
                                    </div>
                                    <div class="ms-3">
                                        <strong>Olivia</strong> New Schedule Realease......
                                        <div class="small text-muted">
                                            45 minutes ago
                                        </div>
                                    </div>
                                </div>
                                <div class="list-group-item d-flex  align-items-center">
                                    <div>
                                        <span class="avatar avatar-lg brround cover-image"
                                            data-bs-image-src="{{ asset('dashboard/img/users/8.jpg') }}"><span
                                                class="avatar-status bg-success"></span></span>
                                    </div>
                                    <div class="ms-3">
                                        <strong>Madeleine</strong> Hey! there I' am available....
                                        <div class="small text-muted">
                                            3 hours ago
                                        </div>
                                    </div>
                                </div>
                                <div class="list-group-item d-flex  align-items-center">
                                    <div>
                                        <span class="avatar avatar-lg brround cover-image"
                                            data-bs-image-src="{{ asset('dashboard/img/users/11.jpg') }}"></span>
                                    </div>
                                    <div class="ms-3">
                                        <strong>Anthony</strong> New product Launching...
                                        <div class="small text-muted">
                                            5 hour ago
                                        </div>
                                    </div>
                                </div>
                                <div class="list-group-item d-flex  align-items-center">
                                    <div>
                                        <span class="avatar avatar-lg brround cover-image"
                                            data-bs-image-src="{{ asset('dashboard/img/users/6.jpg') }}"><span
                                                class="avatar-status bg-success"></span></span>
                                    </div>
                                    <div class="ms-3">
                                        <strong>Olivia</strong> New Schedule Realease......
                                        <div class="small text-muted">
                                            45 minutes ago
                                        </div>
                                    </div>
                                </div>
                                <div class="list-group-item d-flex  align-items-center">
                                    <div>
                                        <span class="avatar avatar-lg brround cover-image"
                                            data-bs-image-src="{{ asset('dashboard/img/users/9.jpg') }}"><span
                                                class="avatar-status bg-success"></span></span>
                                    </div>
                                    <div class="ms-3">
                                        <strong>Olivia</strong> Hey! there I' am available....
                                        <div class="small text-muted">
                                            12 minutes ago
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane  " id="side3">
                            <div class="list-group list-group-flush ">
                                <div class="list-group-item d-flex  align-items-center">
                                    <div>
                                        <span class="avatar avatar-md brround cover-image"
                                            data-bs-image-src="{{ asset('dashboard/img/users/9.jpg') }}"><span
                                                class="avatar-status bg-success"></span></span>
                                    </div>
                                    <div class="ms-2">
                                        <div class="fw-semibold" data-bs-toggle="modal" data-bs-target="#chatmodel">
                                            Mozelle Belt</div>
                                    </div>
                                    <div class="ms-auto">
                                        <a href="javascript:void(0);" class="btn btn-sm btn-light"
                                            data-bs-toggle="modal" data-bs-target="#chatmodel"><i
                                                class="fab fa-facebook-messenger"></i></a>
                                    </div>
                                </div>
                                <div class="list-group-item d-flex  align-items-center">
                                    <div>
                                        <span class="avatar avatar-md brround cover-image"
                                            data-bs-image-src="{{ asset('dashboard/img/users/11.jpg') }}"></span>
                                    </div>
                                    <div class="ms-2">
                                        <div class="fw-semibold" data-bs-toggle="modal" data-bs-target="#chatmodel">
                                            Florinda Carasco</div>
                                    </div>
                                    <div class="ms-auto">
                                        <a href="javascript:void(0);" class="btn btn-sm btn-light"
                                            data-bs-toggle="modal" data-bs-target="#chatmodel"><i
                                                class="fab fa-facebook-messenger"></i></a>
                                    </div>
                                </div>
                                <div class="list-group-item d-flex  align-items-center">
                                    <div>
                                        <span class="avatar avatar-md brround cover-image"
                                            data-bs-image-src="{{ asset('dashboard/img/users/10.jpg') }}"><span
                                                class="avatar-status bg-success"></span></span>
                                    </div>
                                    <div class="ms-2">
                                        <div class="fw-semibold" data-bs-toggle="modal" data-bs-target="#chatmodel">
                                            Alina Bernier</div>
                                    </div>
                                    <div class="ms-auto">
                                        <a href="javascript:void(0);" class="btn btn-sm btn-light"
                                            data-bs-toggle="modal" data-bs-target="#chatmodel"><i
                                                class="fab fa-facebook-messenger"></i></a>
                                    </div>
                                </div>
                                <div class="list-group-item d-flex  align-items-center">
                                    <div>
                                        <span class="avatar avatar-md brround cover-image"
                                            data-bs-image-src="{{ asset('dashboard/img/users/2.jpg') }}"><span
                                                class="avatar-status bg-success"></span></span>
                                    </div>
                                    <div class="ms-2">
                                        <div class="fw-semibold" data-bs-toggle="modal" data-bs-target="#chatmodel">
                                            Zula Mclaughin</div>
                                    </div>
                                    <div class="ms-auto">
                                        <a href="javascript:void(0);" class="btn btn-sm btn-light"
                                            data-bs-toggle="modal" data-bs-target="#chatmodel"><i
                                                class="fab fa-facebook-messenger"></i></a>
                                    </div>
                                </div>
                                <div class="list-group-item d-flex  align-items-center">
                                    <div>
                                        <span class="avatar avatar-md brround cover-image"
                                            data-bs-image-src="{{ asset('dashboard/img/users/13.jpg') }}"></span>
                                    </div>
                                    <div class="ms-2">
                                        <div class="fw-semibold" data-bs-toggle="modal" data-bs-target="#chatmodel">
                                            Isidro Heide</div>
                                    </div>
                                    <div class="ms-auto">
                                        <a href="javascript:void(0);" class="btn btn-sm btn-light"
                                            data-bs-toggle="modal" data-bs-target="#chatmodel"><i
                                                class="fab fa-facebook-messenger"></i></a>
                                    </div>
                                </div>
                                <div class="list-group-item d-flex  align-items-center">
                                    <div>
                                        <span class="avatar avatar-md brround cover-image"
                                            data-bs-image-src="{{ asset('dashboard/img/users/12.jpg') }}"><span
                                                class="avatar-status bg-success"></span></span>
                                    </div>
                                    <div class="ms-2">
                                        <div class="fw-semibold" data-bs-toggle="modal" data-bs-target="#chatmodel">
                                            Mozelle Belt</div>
                                    </div>
                                    <div class="ms-auto">
                                        <a href="javascript:void(0);" class="btn btn-sm btn-light"><i
                                                class="fab fa-facebook-messenger"></i></a>
                                    </div>
                                </div>
                                <div class="list-group-item d-flex  align-items-center">
                                    <div>
                                        <span class="avatar avatar-md brround cover-image"
                                            data-bs-image-src="{{ asset('dashboard/img/users/4.jpg') }}"></span>
                                    </div>
                                    <div class="ms-2">
                                        <div class="fw-semibold" data-bs-toggle="modal" data-bs-target="#chatmodel">
                                            Florinda Carasco</div>
                                    </div>
                                    <div class="ms-auto">
                                        <a href="javascript:void(0);" class="btn btn-sm btn-light"
                                            data-bs-toggle="modal" data-bs-target="#chatmodel"><i
                                                class="fab fa-facebook-messenger"></i></a>
                                    </div>
                                </div>
                                <div class="list-group-item d-flex  align-items-center">
                                    <div>
                                        <span class="avatar avatar-md brround cover-image"
                                            data-bs-image-src="{{ asset('dashboard/img/users/7.jpg') }}"></span>
                                    </div>
                                    <div class="ms-2">
                                        <div class="fw-semibold" data-bs-toggle="modal" data-bs-target="#chatmodel">
                                            Alina Bernier</div>
                                    </div>
                                    <div class="ms-auto">
                                        <a href="javascript:void(0);" class="btn btn-sm btn-light"><i
                                                class="fab fa-facebook-messenger"></i></a>
                                    </div>
                                </div>
                                <div class="list-group-item d-flex  align-items-center">
                                    <div>
                                        <span class="avatar avatar-md brround cover-image"
                                            data-bs-image-src="{{ asset('dashboard/img/users/2.jpg') }}"></span>
                                    </div>
                                    <div class="ms-2">
                                        <div class="fw-semibold" data-bs-toggle="modal" data-bs-target="#chatmodel">
                                            Zula Mclaughin</div>
                                    </div>
                                    <div class="ms-auto">
                                        <a href="javascript:void(0);" class="btn btn-sm btn-light"
                                            data-bs-toggle="modal" data-bs-target="#chatmodel"><i
                                                class="fab fa-facebook-messenger"></i></a>
                                    </div>
                                </div>
                                <div class="list-group-item d-flex  align-items-center">
                                    <div>
                                        <span class="avatar avatar-md brround cover-image"
                                            data-bs-image-src="{{ asset('dashboard/img/users/14.jpg') }}"><span
                                                class="avatar-status bg-success"></span></span>
                                    </div>
                                    <div class="ms-2">
                                        <div class="fw-semibold" data-bs-toggle="modal" data-bs-target="#chatmodel">
                                            Isidro Heide</div>
                                    </div>
                                    <div class="ms-auto">
                                        <a href="javascript:void(0);" class="btn btn-sm btn-light"><i
                                                class="fab fa-facebook-messenger"></i></a>
                                    </div>
                                </div>
                                <div class="list-group-item d-flex  align-items-center">
                                    <div>
                                        <span class="avatar avatar-md brround cover-image"
                                            data-bs-image-src="{{ asset('dashboard/img/users/11.jpg') }}"></span>
                                    </div>
                                    <div class="ms-2">
                                        <div class="fw-semibold" data-bs-toggle="modal" data-bs-target="#chatmodel">
                                            Florinda Carasco</div>
                                    </div>
                                    <div class="ms-auto">
                                        <a href="javascript:void(0);" class="btn btn-sm btn-light"
                                            data-bs-toggle="modal" data-bs-target="#chatmodel"><i
                                                class="fab fa-facebook-messenger"></i></a>
                                    </div>
                                </div>
                                <div class="list-group-item d-flex  align-items-center">
                                    <div>
                                        <span class="avatar avatar-md brround cover-image"
                                            data-bs-image-src="{{ asset('dashboard/img/users/9.jpg') }}"></span>
                                    </div>
                                    <div class="ms-2">
                                        <div class="fw-semibold" data-bs-toggle="modal" data-bs-target="#chatmodel">
                                            Alina Bernier</div>
                                    </div>
                                    <div class="ms-auto">
                                        <a href="javascript:void(0);" class="btn btn-sm btn-light"
                                            data-bs-toggle="modal" data-bs-target="#chatmodel"><i
                                                class="fab fa-facebook-messenger"></i></a>
                                    </div>
                                </div>
                                <div class="list-group-item d-flex  align-items-center">
                                    <div>
                                        <span class="avatar avatar-md brround cover-image"
                                            data-bs-image-src="{{ asset('dashboard/img/users/15.jpg') }}"><span
                                                class="avatar-status bg-success"></span></span>
                                    </div>
                                    <div class="ms-2">
                                        <div class="fw-semibold" data-bs-toggle="modal" data-bs-target="#chatmodel">
                                            Zula Mclaughin</div>
                                    </div>
                                    <div class="ms-auto">
                                        <a href="javascript:void(0);" class="btn btn-sm btn-light"
                                            data-bs-toggle="modal" data-bs-target="#chatmodel"><i
                                                class="fab fa-facebook-messenger"></i></a>
                                    </div>
                                </div>
                                <div class="list-group-item d-flex  align-items-center">
                                    <div>
                                        <span class="avatar avatar-md brround cover-image"
                                            data-bs-image-src="{{ asset('dashboard/img/users/4.jpg') }}"></span>
                                    </div>
                                    <div class="ms-2">
                                        <div class="fw-semibold" data-bs-toggle="modal" data-bs-target="#chatmodel">
                                            Isidro Heide</div>
                                    </div>
                                    <div class="ms-auto">
                                        <a href="javascript:void(0);" class="btn btn-sm btn-light"
                                            data-bs-toggle="modal" data-bs-target="#chatmodel"><i
                                                class="fab fa-facebook-messenger"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/Sidebar-right-->


        <!-- Footer opened -->
        <div class="main-footer">
            <div class="container-fluid pd-t-0 ht-100p">
                <span> Copyright © 2022 <a href="javascript:void(0);" class="text-primary">Valex</a>. Designed with
                    <span class="fa fa-heart text-danger"></span> by <a href="javascript:void(0);"> Spruko </a> All
                    rights reserved.</span>
            </div>
        </div>
        <!-- Footer closed -->

    </div>
    <!-- End Page -->

    <!-- Back-to-top -->
    <a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>

    @include('dashboard.layouts.js')
</body>

</html>
