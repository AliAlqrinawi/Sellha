@extends('dashboard.layouts.master')
@section('title', __('Product'))
@section('css')
    <!-- Data table css -->
    <link href="{{ asset('assets/scss/plugins/dataTables.bootstrap5.scss') }}" rel="stylesheet" />
    <link href="{{ asset('assets/scss/plugins/buttons.bootstrap5.scss') }}" rel="stylesheet">
    <link href="{{ asset('assets/scss/plugins/responsive.bootstrap5.scss') }}" rel="stylesheet" />
@stop

@section('content')

    <div id="error_message"></div>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="modal" id="showModalProduct1">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('Product Details') }}</h6><button aria-label="Close" class="close"
                        data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row" style="padding: 12px;">
                        <div class="col-md-6" style="color: blue; font-weight: bold;">{{ __('Discount') }}</div>
                        <div class="col-md-6" id="discount"></div>
                      </div>
                      <div class="row" style="padding: 12px;">
                        <div class="col-md-6" style="color: blue; font-weight: bold;">{{ __('Description') }}</div>
                        <div class="col-md-6" id="description"></div>
                      </div>
                      <div class="row" style="padding: 12px;">
                        <div class="col-md-6" style="color: blue; font-weight: bold;">{{ __('Is Sale') }}</div>
                        <div class="col-md-6" id="is_sale"></div>
                      </div>
                      <div class="row" style="padding: 12px;">
                        <div class="col-md-6" style="color: blue; font-weight: bold;">{{ __('Display Area') }}</div>
                        <div class="col-md-6" id="show"></div>
                      </div>
                      <div class="row" style="padding: 12px;">
                        <div class="col-md-6" style="color: blue; font-weight: bold;">{{ __('Type') }}</div>
                        <div class="col-md-6" id="type"></div>
                      </div>
                      <div class="row" style="padding: 12px;">
                        <div class="col-md-6" style="color: blue; font-weight: bold;">{{ __('Category') }}</div>
                        <div class="col-md-6" id="category"></div>
                      </div>
                      <div class="row" style="padding: 12px;">
                        <div class="col-md-6" style="color: blue; font-weight: bold;">{{ __('Sub Category') }}</div>
                        <div class="col-md-6" id="sub_category"></div>
                      </div>
                </div>
                <div class="modal-footer">
                    <button class="btn ripple btn-primary" data-bs-dismiss="modal" type="button">{{ __('Done') }}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="modalProductDelete" style="display: none;" aria-hidden="true">
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
                    <button type="submit" class="btn btn-danger" id="deleteProduct">{{ __('Delete') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- row -->

    <div class="row">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="row row-xs wd-xl-80p">
                        <div class="col-sm-6 col-md-3 mg-t-10">
                            <a href="{{ route('product.create') }}" class="btn btn-info-gradient btn-block" id="ShowModalProduct"
                                style="font-weight: bold; color: beige;">{{ __('Addition') }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive hoverable-table">
                        <table class="table table-hover" id="get_product" style=" text-align: center;">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">{{ __('Image') }}</th>
                                    <th class="border-bottom-0">{{ __('Name') }}</th>
                                    <th class="border-bottom-0">{{ __('Category Name') }}</th>
                                    <th class="border-bottom-0">{{ __('Product Owner') }}</th>
                                    <th class="border-bottom-0">{{ __('Price') }}</th>
                                    <th class="border-bottom-0">{{ __('Views') }}</th>
                                    <th class="border-bottom-0">{{ __('Status') }}</th>
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
    <script src="{{ asset('dashboard/local/product.js') }}"></script>
@stop
