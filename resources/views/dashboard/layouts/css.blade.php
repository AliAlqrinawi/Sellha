@if(App::getLocale() == 'en')
<!-- Favicon -->
<link rel="icon" href="{{ asset('dashboard/img/brand/favicon.png') }}" type="image/x-icon">

<!-- Icons css -->
<link href="{{ asset('dashboard/css/icons.css') }}" rel="stylesheet">

<!-- Bootstrap css -->
<link id="style" href="{{ asset('dashboard/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

<!-- style css -->
<link href="{{ asset('dashboard/css/style.css') }}" rel="stylesheet">
<link href="{{ asset('dashboard/css/plugins.css') }}" rel="stylesheet">

<!--- Animations css-->
<link href="{{ asset('dashboard/css/animate.css') }}" rel="stylesheet">
@else
<!-- Favicon -->
<link rel="icon" href="{{ asset('dashboard/img/brand/favicon.png') }}" type="image/x-icon">

<!-- Icons css -->
<link href="{{ asset('dashboard/css/icons.css') }}" rel="stylesheet">

<!-- Bootstrap css -->
<link id="style" href="{{ asset('dashboard/plugins/bootstrap/css/bootstrap.rtl.min.css') }}" rel="stylesheet">

<!-- style css -->
<link href="{{ asset('dashboard/css/style.css') }}" rel="stylesheet">
<link href="{{ asset('dashboard/css/plugins.css') }}" rel="stylesheet">

<!--- Animations css-->
<link href="{{ asset('dashboard/css/animate.css') }}" rel="stylesheet">
@endif

<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

@yield('css')

