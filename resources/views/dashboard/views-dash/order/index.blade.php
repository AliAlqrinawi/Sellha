@extends('dashboard.layouts.master')
@section('title', __('Order'))
@section('css')
    <!-- Data table css -->
    <link href="{{ asset('assets/scss/plugins/dataTables.bootstrap5.scss') }}" rel="stylesheet" />
    <link href="{{ asset('assets/scss/plugins/buttons.bootstrap5.scss') }}" rel="stylesheet">
    <link href="{{ asset('assets/scss/plugins/responsive.bootstrap5.scss') }}" rel="stylesheet" />

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
            height: 300px;
        }
    </style>
@stop

@section('content')

    <div id="error_message"></div>
    <div class="modal" id="modalOrderDelete" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('Delete Operation') }}</h6>
                    <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <ul id="list_error_message3"></ul>
                <div class="modal-body">
                    <p>{{ __('Are sure of the deleting process ?') }}</p><br>
                    <input class="form-control" id="nameDetele" type="text" readonly="">
                </div>
                <div class="modal-footer">
                    <button class="btn ripple btn-secondary" data-bs-dismiss="modal"
                        type="button">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-danger" id="deleteOrder">{{ __('Delete') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="showModalOrder1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('Product Details') }}</h6><button aria-label="Close" class="close"
                        data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="col-md-12"
                                style="border-style: groove; border-width: 1px; text-align: center; padding-top: 10px;">
                                <div class="col-md-12">
                                    <h6 class="text-danger">{{ __('Product Details') }}</h6>
                                </div>
                            </div>
                            <br>
                            <div class="row"
                                style="border-style: groove; border-width: 1px; text-align: center; padding-top: 10px; margin: 2px;">
                                <div class="col-md-6">
                                    <h6 class="text-primary">{{ __('Image') }}</h6>
                                </div>
                                <div class="col-md-6" id="image">

                                </div>
                            </div>
                            <br>
                            <div class="row"
                                style="border-style: groove; border-width: 1px; text-align: center; padding-top: 10px; margin: 2px;">
                                <div class="col-md-6">
                                    <h6 class="text-primary">{{ __('Name') }}</h6>
                                </div>
                                <div class="col-md-5" id="name"></div>
                            </div>
                            <br>
                            <div class="row"
                                style="border-style: groove; border-width: 1px; text-align: center; padding-top: 10px; margin: 2px;">
                                <div class="col-md-6">
                                    <h6 class="text-primary">{{ __('Product Owner') }}</h6>
                                </div>
                                <div class="col-md-6" id="product_owner"></div>
                            </div>
                            <br>
                            <div class="row"
                                style="border-style: groove; border-width: 1px; text-align: center; padding-top: 10px; margin: 2px;">
                                <div class="col-md-6">
                                    <h6 class="text-primary">{{ __('Price') }}</h6>
                                </div>
                                <div class="col-md-6" id="price"></div>
                            </div>
                            <br>
                            <div class="row"
                                style="border-style: groove; border-width: 1px; text-align: center; padding-top: 10px; margin: 2px;">
                                <div class="col-md-6">
                                    <h6 class="text-primary">{{ __('Discount') }}</h6>
                                </div>
                                <div class="col-md-6" id="discount"></div>
                            </div>
                            <br>
                            <div class="row"
                                style="border-style: groove; border-width: 1px; text-align: center; padding-top: 10px; margin: 2px;">
                                <div class="col-md-6">
                                    <h6 class="text-primary">{{ __('Views') }}</h6>
                                </div>
                                <div class="col-md-6" id="views"></div>
                            </div>
                            <br>
                            <div class="row"
                                style="border-style: groove; border-width: 1px; text-align: center; padding-top: 10px; margin: 2px;">
                                <div class="col-md-6">
                                    <h6 class="text-primary">{{ __('Status') }}</h6>
                                </div>
                                <div class="col-md-6" id="status"></div>
                            </div>
                            <br>
                            <div class="row"
                                style="border-style: groove; border-width: 1px; text-align: center; padding-top: 10px; margin: 2px;">
                                <div class="col-md-6">
                                    <h6 class="text-primary">{{ __('Display Area') }}</h6>
                                </div>
                                <div class="col-md-6" id="show"></div>
                            </div>
                            <br>
                            <div class="row"
                                style="border-style: groove; border-width: 1px; text-align: center; padding-top: 10px; margin: 2px;">
                                <div class="col-md-6">
                                    <h6 class="text-primary">{{ __('Category') }}</h6>
                                </div>
                                <div class="col-md-6" id="category"></div>
                            </div>
                            <br>
                            <div class="row"
                                style="border-style: groove; border-width: 1px; text-align: center; padding-top: 10px; margin: 2px;">
                                <div class="col-md-6">
                                    <h6 class="text-primary">{{ __('Sub Category') }}</h6>
                                </div>
                                <div class="col-md-6" id="sub_category"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-12"
                                style="border-style: groove; border-width: 1px; text-align: center; padding-top: 10px;">
                                <div class="col-md-12">
                                    <h6 class="text-danger">{{ __('Buyer Details') }}</h6>
                                </div>
                            </div>
                            <br>
                            <div class="row"
                                style="border-style: groove; border-width: 1px; text-align: center; padding-top: 10px; margin: 2px;">
                                <div class="col-md-6">
                                    <h6 class="text-primary">{{ __('Name') }}</h6>
                                </div>
                                <div class="col-md-6" id="name_buyer"></div>
                            </div>
                            <br>
                            <div class="row"
                                style="border-style: groove; border-width: 1px; text-align: center; padding-top: 10px; margin: 2px;">
                                <div class="col-md-6">
                                    <h6 class="text-primary">{{ __('Phone') }}</h6>
                                </div>
                                <div class="col-md-6" id="phone_buyer"></div>
                            </div>
                            <br>
                            <div class="row"
                                style="border-style: groove; border-width: 1px; text-align: center; padding-top: 10px; margin: 2px;">
                                <div class="col-md-6">
                                    <h6 class="text-primary">{{ __('Status') }}</h6>
                                </div>
                                <div class="col-md-6" id="Status_buyer"></div>
                            </div>
                            <br>
                            <div class="col-md-12"
                                style="border-style: groove; border-width: 1px; text-align: center; padding-top: 10px;">
                                <div class="col-md-12">
                                    <h6 class="text-danger">{{ __('Seller Details') }}</h6>
                                </div>
                            </div>
                            <br>
                            <div class="row"
                                style="border-style: groove; border-width: 1px; text-align: center; padding-top: 10px; margin: 2px;">
                                <div class="col-md-6">
                                    <h6 class="text-primary">{{ __('Name') }}</h6>
                                </div>
                                <div class="col-md-6" id="name_seller"></div>
                            </div>
                            <br>
                            <div class="row"
                                style="border-style: groove; border-width: 1px; text-align: center; padding-top: 10px; margin: 2px;">
                                <div class="col-md-6">
                                    <h6 class="text-primary">{{ __('Phone') }}</h6>
                                </div>
                                <div class="col-md-6" id="phone_seller"></div>
                            </div>
                            <br>
                            <div class="row"
                                style="border-style: groove; border-width: 1px; text-align: center; padding-top: 10px; margin: 2px;">
                                <div class="col-md-6">
                                    <h6 class="text-primary">{{ __('Status') }}</h6>
                                </div>
                                <div class="col-md-6" id="Status_seller"></div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row"
                        style="border-style: groove; border-width: 1px; text-align: center; padding-top: 10px;">
                        <div class="col-md-12">
                            <h6 class="text-primary">Location</h6>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="map"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn ripple btn-primary" data-bs-dismiss="modal"
                        type="button">{{ __('Done') }}</button>
                </div>
            </div>

        </div>
    </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="table-responsive hoverable-table">
                        <table class="table table-hover" id="get_order" style=" text-align: center;">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">{{ __('Total') }}</th>
                                    <th class="border-bottom-0">{{ __('Buyer name') }}</th>
                                    <th class="border-bottom-0">{{ __('Product name') }}</th>
                                    <th class="border-bottom-0">{{ __('Seller name') }}</th>
                                    <th class="border-bottom-0">{{ __('Status') }}</th>
                                    <th class="border-bottom-0">{{ __('Payment status') }}</th>
                                    <th class="border-bottom-0">{{ __('Processes') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <!-- DATA TABLE JS -->
    <script src="{{ asset('dashboard/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatable/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatable/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatable/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/table-data.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <script src="{{ asset('dashboard/js/advanced-form-elements.js') }}"></script>
    <script src="{{ asset('dashboard/js/select2.js') }}"></script>
    <script src="{{ asset('dashboard/local/order.js') }}"></script>

    <script>
        var map = L.map('map').setView([23.8859, 45.0792], 3);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);
    </script>
@stop
