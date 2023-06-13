@extends('dashboard.layouts.master')
@section('title', __('Product'))
@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-color-markers/dist/css/leaflet-color-markers.css" />
    <script src="https://unpkg.com/leaflet-color-markers/dist/leaflet-color-markers.js"></script>

    <style>
        #map {
            height: 600px;
            width: 82.7%;
        }
    </style>
@stop

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="row row-xs wd-xl-80p">
                        <div class="col-sm-6 col-md-3 mg-t-10">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form class="needs-validation" action="{{ route('product.update' , $product->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row row-sm">

                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">{{ __('Title in English') }} :</label>
                            <input type="text" class="form-control" name="title_en" value="{{ old('title_en' , $product->title_en) }}">
                            @error('title_en')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">{{ __('Title in Arabic') }} :</label>
                            <input type="text" class="form-control" name="title_ar" value="{{ old('title_ar' , $product->title_ar) }}"
                                required>
                            @error('title_ar')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">{{ __('Price') }} :</label>
                            <input type="number" class="form-control" name="price" value="{{ old('price' , $product->price) }}" required>
                            @error('price')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">{{ __('Discount') }} :</label>
                            <input type="number" class="form-control" name="discount" value="{{ old('discount' , $product->discount) }}">
                            @error('discount')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">{{ __('Image') }} :</label>
                            <input type="file" class="form-control" name="file">
                            @error('file')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">{{ __('Images') }} :</label>
                            <input type="file" class="form-control" name="files[]" multiple>
                            @error('files')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">{{ __('Category Name') }} :</label>
                            <select name="category_id" class="form-control">
                                <option value=""></option>
                                @foreach ($categories as $value)
                                    <option value="{{ $value->id }}" @if ($value->id == old('category_id' , $product->category_id)) selected @endif>
                                        {{ app()->getLocale() == 'ar' ? $value->title_ar : $value->title_en }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">{{ __('Sub Categories') }} :</label>
                            <select name="sub_category_id" class="form-control">
                                <option value=""></option>
                                @foreach ($subCategories as $value)
                                    <option value="{{ $value->id }}" @if ($value->id == old('sub_category_id' , $product->sub_category_id)) selected @endif>
                                        {{ app()->getLocale() == 'ar' ? $value->title_ar : $value->title_en }}</option>
                                @endforeach
                            </select>
                            @error('sub_category_id')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">{{ __('Display Area') }} :</label>
                            <select name="show" class="form-control">
                                <option value=""></option>
                                <option value="BEST-DEALS" @if ('BEST-DEALS' == old('show' , $product->show)) selected @endif>
                                    {{ __('BEST DEALS') }}</option>
                                <option value="NEW-ARRIVALS" @if ('NEW-ARRIVALS' == old('show' , $product->show)) selected @endif>
                                    {{ __('NEW ARRIVALS') }}</option>
                                <option value="MOST-WANTED" @if ('MOST-WANTED' == old('show' , $product->show)) selected @endif>
                                    {{ __('MOST WANTED') }}</option>
                                <option value="DEALS-OF-THE-WEEK" @if ('DEALS-OF-THE-WEEK' == old('show' , $product->show)) selected @endif>
                                    {{ __('DEALS OF THE WEEK') }}</option>
                            </select>
                            @error('show')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">{{ __('Type') }} :</label>
                            <select name="type" class="form-control">
                                <option value=""></option>
                                <option value="NEW" @if ('NEW' == old('type' , $product->type)) selected @endif>
                                    {{ __('NEW') }}</option>
                                <option value="LIKENEW" @if ('LIKENEW' == old('type' , $product->type)) selected @endif>
                                    {{ __('LIKENEW') }}</option>
                                <option value="GOOD" @if ('GOOD' == old('type' , $product->type)) selected @endif>
                                    {{ __('GOOD') }}</option>
                                <option value="NOTSODUSTY" @if ('NOTSODUSTY' == old('type' , $product->type)) selected @endif>
                                    {{ __('NOTSODUSTY') }}</option>
                                <option value="OLD" @if ('OLD' == old('type' , $product->type)) selected @endif>
                                    {{ __('OLD') }}</option>
                            </select>
                            @error('type')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">{{ __('User') }} :</label>
                            <select name="user_id" class="form-control">
                                <option value=""></option>
                                @foreach ($users as $value)
                                    <option value="{{ $value->id }}"
                                        @if ($value->id == old('user_id' , $product->user_id)) selected @endif>
                                        {{ $value->name }}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">{{ __('Status') }} :</label>
                            <select name="status" class="form-control">
                                <option value="ACTIVE" @if ('ACTIVE' == old('status' , $product->status)) selected @endif>
                                    {{ __('ACTIVE') }}</option>
                                <option value="INACTIVE" @if ('INACTIVE' == old('status' , $product->status)) selected @endif>
                                    {{ __('NACTIVE') }}</option>
                            </select>
                            @error('status')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">{{ __('Description in Arabic') }} :</label>
                            <textarea name="description_ar" class="form-control" rows="10">{{ old('description_ar' , $product->description_ar) }}</textarea>
                            @error('description_ar')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">{{ __('Description in English') }} :</label>
                            <textarea name="description_en" class="form-control" rows="10">{{ old('description_en' , $product->description_ar) }}</textarea>
                            @error('description_en')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <input type="hidden" name="lat" id="lat" value="{{ old('lat' , $product->lat) }}">

                        <input type="hidden" name="lng" id="lng" value="{{ old('lng' , $product->lng) }}">
                        <div id="map" class="form-group col-md-12"></div>
                        </div>
                        <button type="submit"
                            class="btn btn-main-primary pd-x-30 mg-r-5 mg-t-5">{{ __('Save') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        var map = L.map('map').setView([23.8859, 45.0792], 5);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        let marker = L.marker([{{ $product->lat }}, {{ $product->lng }}]).addTo(map)
        map.on('click', (event) => {
            if (marker !== null) {
                map.removeLayer(marker);
            }
            marker = L.marker([event.latlng.lat, event.latlng.lng]).addTo(map);
            lat = event.latlng.lat;
            lng = event.latlng.lng;
            document.getElementById("lat").value = lat;
            document.getElementById("lng").value = lng;
        });
    </script>
@stop
