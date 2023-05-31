@extends('dashboard.layouts.master')
@section('title', __('General Settings'))
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

                        <h4>{{ __('General Settings') }}</h4>
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
                                    @if ($x->key == 'about_ar' || $x->key == 'about_en' || $x->key == 'termsOfUse_ar' || $x->key == 'termsOfUse_en' || $x->key == 'privacyPolicy_ar' || $x->key == 'privacyPolicy_en')
                                        <div class="col-md-12">
                                            <textarea class="form-control" name="{{ $x->key }}" id="summernote{{ $x->id }}">@if (isset($x->value)){{ $x->value }}@endif</textarea>
                                        </div>
                                    @else
                                        <div class="col-md-12">
                                            <input type="{{ $x->type }}" name="{{ $x->key }}"
                                                class="form-control"
                                                value="@if (isset($x->value)) {{ $x->value }} @endif">
                                        </div>
                                    @endif
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
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#summernote2').summernote({
                height: 300,
                focus: true
            });

            $('#summernote3').summernote({
                height: 300,
                focus: true
            });

            $('#summernote4').summernote({
                height: 300,
                focus: true
            });

            $('#summernote5').summernote({
                height: 300,
                focus: true
            });

            $('#summernote7').summernote({
                height: 300,
                focus: true
            });

            $('#summernote8').summernote({
                height: 300,
                focus: true
            });
        });
    </script>
@endsection
