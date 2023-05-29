@extends('dashboard.layouts.master')
@section('title', __('User'))
@section('css')
    <!-- Data table css -->
    <link href="{{ asset('assets/scss/plugins/dataTables.bootstrap5.scss') }}" rel="stylesheet" />
    <link href="{{ asset('assets/scss/plugins/buttons.bootstrap5.scss') }}" rel="stylesheet">
    <link href="{{ asset('assets/scss/plugins/responsive.bootstrap5.scss') }}" rel="stylesheet" />
@stop

@section('content')

    <div id="error_message"></div>
    <div class="modal" id="modalUserAdd">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('User') }}</h6>
                    <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <ul id="list_error_message"></ul>
                    <form id="formUserAdd" enctype="multipart/form-data">
                        <div class="row">

                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">{{ __('name') }} :</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">{{ __('Phone') }} :</label>
                                <input type="text" class="form-control" name="phone" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">{{ __('Status') }} :</label>
                                <select name="status" class="form-control">
                                    <option value="ACTIVE">{{ __('ACTIVE') }}</option>
                                    <option value="INACTIVE">{{ __('NACTIVE') }}</option>
                                </select>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="addUser">{{ __('Save') }}</button>
                            <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button"
                                id="close">{{ __('Close') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Basic modal -->
    <div class="modal" id="modalUserUpdate">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('Modification Process') }}</h6>
                    <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <ul id="list_error_message2"></ul>
                    <form id="formUserUpdate" enctype="multipart/form-data">
                        @method('PUT')
                        <input type="hidden" class="form-control" name="id" id="id">
                        <div class="row">

                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">{{ __('name') }} :</label>
                                <input type="text" class="form-control" name="name"  id="name" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">{{ __('Phone') }} :</label>
                                <input type="text" class="form-control" name="phone" id="phone" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">{{ __('Status') }} :</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="ACTIVE">{{ __('ACTIVE') }}</option>
                                    <option value="INACTIVE">{{ __('NACTIVE') }}</option>
                                </select>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success"
                                id="updateUser">{{ __('Update') }}</button>
                            <button class="btn ripple btn-secondary" data-bs-dismiss="modal"
                                type="button">{{ __('Close') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Basic modal -->

    <div class="modal" id="modalUserDelete" style="display: none;" aria-hidden="true">
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
                    <button type="submit" class="btn btn-danger" id="deleteUser">{{ __('Delete') }}</button>
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
                            <button class="btn btn-info-gradient btn-block" id="ShowModalUser"
                                style="font-weight: bold; color: beige;">{{ __('Addition') }}
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive hoverable-table">
                        <table class="table table-hover" id="get_user" style=" text-align: center;">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">{{ __('Name') }}</th>
                                    <th class="border-bottom-0">{{ __('Phone') }}</th>
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
    <script src="{{ asset('dashboard/local/user.js') }}"></script>
@stop
