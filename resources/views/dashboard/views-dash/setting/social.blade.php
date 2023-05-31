@extends('dashboard.layouts.master')
@section('title', __('Social Settings'))
@section('css')
@stop

@section('content')
    <div class="main-body">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif(session('delete'))
            <div class="alert alert-danger ">
                {{ session('delete') }}
            </div>
        @endif
        <!-- row opened -->
        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header pb-0">

                        <h4>{{ __('Social Settings') }}</h4>
                        <hr>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('setting.update', 1) }}" method="POST">
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
                                        <input type="{{ $x->type }}" name="{{ $x->key }}"
                                            class="form-control"
                                            value="@if (isset($x->value)){{ $x->value }}@endif">
                                    </div>
                                </div>
                            @endforeach
                            <hr>
                            <button type="submit" class="btn btn-success btn-block col-sm-2">{{ __('Update') }}</button>
                        </form>
                    </div>
                </div>
            </div>
            <!--/div-->
        </div>
    </div>
@endsection
@section('script')
@endsection
