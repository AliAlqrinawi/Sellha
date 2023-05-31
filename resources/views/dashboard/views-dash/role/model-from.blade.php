<div class="modal" id="modalRoleAdd">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">{{ __('Role') }}</h6>
                <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <hr />
                <ul id="list_error_message"></ul>
                <div class="form-group">
                    <label for="user_name">{{ __('Name') }}</label>
                    <input type="text" id="user_name" name="user_name"
                        class="form-control @error('user_name')  is-invalid @enderror" />
                    @error('name')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>
                <div class="table-responsive">
                    <table class="table mg-b-0 text-md-nowrap">
                        <thead>
                            <tr>
                                <th>{{ __('Tasks') }}</th>
                                <th>{{ __('All') }}</th>
                                <th>{{ __('View') }}</th>
                                <th>{{ __('Create') }}</th>
                                <th>{{ __('Edit') }}</th>
                                <th>{{ __('Delete') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">{{ __('All Permissions') }}</th>
                                <td>
                                    <div class="main-toggle-group-demo">
                                        <div class="main-toggle main-toggle-success" id="allh">
                                            <span></span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @foreach (config('permission') as $permissions => $label)
                                <tr>
                                    <th scope="row">{{ __($permissions) }}</th>
                                    @foreach ($label as $q)
                                        <td>
                                            <div class="main-toggle-group-demo">
                                                <div class="main-toggle main-toggle-success" id="{{ $q }}a"
                                                    data-v="{{ $q }}">
                                                    <span></span>
                                                </div>
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" id="addRole">{{ __('Save') }}</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button" id="close">{{ __('Close') }}</button>
            </div>
        </div>
    </div>
</div>

<!-- //////////////// -->
<div class="modal fade" id="modalRoleUpdate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">{{ __('Role') }}</h6>
                <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <hr />
                <input type="hidden" name="id" id="id">
                <div class="form-group">
                    <label for="user_name">{{ __('Name') }}</label>
                    <input type="text" id="edit_user_name" name="user_name"
                        class="form-control @error('user_name')  is-invalid @enderror" />
                    @error('name')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>
                <div class="table-responsive">
                    <table class="table mg-b-0 text-md-nowrap">
                        <thead>
                            <tr>
                                <th>{{ __('Tasks') }}</th>
                                <th>{{ __('All') }}</th>
                                <th>{{ __('View') }}</th>
                                <th>{{ __('Create') }}</th>
                                <th>{{ __('Edit') }}</th>
                                <th>{{ __('Delete') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row"> All Permissions</th>
                                <td>
                                    <div class="main-toggle-group-demo">
                                        <div class="main-toggle main-toggle-success" id="allu">
                                            <span></span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @foreach (config('permission') as $permissions => $label)
                                <tr>
                                    <th scope="row">{{ $permissions }}</th>
                                    @foreach ($label as $q)
                                        <td>
                                            <div class="main-toggle-group-demo">
                                                <div class="main-toggle main-toggle-success" id="{{ $q }}"
                                                    data-v="{{ $q }}">
                                                    <span></span>
                                                </div>
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" id="updateRole">{{ __('Update') }}</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button" id="close">{{ __('Close') }}</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modalRoleDelete" style="display: none;" aria-hidden="true">
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
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">{{ __('Close') }}</button>
                <button type="submit" class="btn btn-danger" id="deleteRole">{{ __('Delete') }}</button>
            </div>
        </div>
    </div>
</div>
