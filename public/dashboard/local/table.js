let host = document.location;

let TableUrl = new URL('/admin/table', host.origin);
let pathSegments = host.pathname.split('/');
let currentLang = pathSegments[1];
if(currentLang != 'ar' || currentLang != 'en'){
    currentLang = 'en';
}

var table = $('#get_table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url:TableUrl,
        // data: function (d) {
        //     d.status = $('#statusFilter').val()
        // }
    },
    columns: [
        {data: "DT_RowIndex", name: "id"},
        {data: "title", name: "title_"+currentLang},
        {data: "description", name: "description_"+currentLang},
        {data: "status", name: "status"},
        {data: "action", name: "action"},
    ]
});

//  view modal table
$(document).on('click', '#ShowModalTable', function (e) {
    e.preventDefault();
    $('#modalTableAdd').modal('show');
});

let AddUrl = new URL('admin/table', host.origin);
// category admin
$(document).on('click', '#addTable', function (e) {
    e.preventDefault();
    let formdata = new FormData($('#formTableAdd')[0]);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        url: AddUrl,
        data: formdata,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.status == 400) {
                // errors
                $('#list_error_message').html("");
                $('#list_error_message').addClass("alert alert-danger");
                $('#list_error_message').text(response.message);
            } else {
                $('#error_message').html("");
                $('#error_message').addClass("alert alert-success");
                $('#error_message').text(response.message);
                $('#modalTableAdd').modal('hide');
                $('#formTableAdd')[0].reset();
                table.ajax.reload(null, false);
            }
        }
    });
});

let EditUrl = new URL('admin/table', host.origin);
// view modification data
$(document).on('click', '#showModalEditTable', function (e) {
    e.preventDefault();
    var id = $(this).data('id');
    $('#modalTableUpdate').modal('show');
    $.ajax({
        type: 'GET',
        url: EditUrl+'/' + id+'/edit',
        data: "",
        success: function (response) {
            if (response.status == 404) {
                $('#error_message').html("");
                $('#error_message').addClass("alert alert-danger");
                $('#error_message').text(response.message);
            } else {
                $('#id').val(id);
                $('#title_en').val(response.data.title_en);
                $('#title_ar').val(response.data.title_ar);
                $('#description_en').val(response.data.description_en);
                $('#description_ar').val(response.data.description_ar);
                $("#status option[value='"+response.data.status+"']").prop("selected", true);
            }
        }
    });
});

let UpdateUrl = new URL('admin/table', host.origin);
$(document).on('click', '#updateTable', function (e) {
    e.preventDefault();
    let formdata = new FormData($('#formTableUpdate')[0]);
    var id = $('#id').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        url: UpdateUrl+'/'+id,
        data: formdata,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.status == 400) {
                // errors
                $('#list_error_message2').html("");
                $('#list_error_message2').addClass("alert alert-danger");
                $('#list_error_message2').text(response.message);
            } else {
                $('#error_message').html("");
                $('#error_message').addClass("alert alert-success");
                $('#error_message').text(response.message);
                $('#modalTableUpdate').modal('hide');
                $('#formTableUpdate')[0].reset();
                table.ajax.reload(null, false);
            }
        }
    });
});

let DeleteUrl = new URL('admin/table', host.origin);
$(document).on('click', '#showModalDeleteTable', function (e) {
    e.preventDefault();
    $('#nameDetele').val($(this).data('name'));
    var id = $(this).data('id');
    $('#modalTableDelete').modal('show');
    gg(id);
});
function gg(id) {
    $(document).off("click", "#deleteTable").on("click", "#deleteTable", function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'DELETE',
            url: DeleteUrl+'/'+id,
            data: '',
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status == 400) {
                    // errors
                    $('#list_error_message3').html("");
                    $('#list_error_message3').addClass("alert alert-danger");
                    $('#list_error_message3').text(response.message);
                } else {
                    $('#error_message').html("");
                    $('#error_message').addClass("alert alert-success");
                    $('#error_message').text(response.message);
                    $('#modalTableDelete').modal('hide');
                    table.ajax.reload(null, false);
                }
            }
        });
    });
}

let statusUrl = new URL('admin/status/table', host.origin);
$(document).on('click', '#status', function (e) {
    e.preventDefault();
    var id = $(this).data('id');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'PUT',
        url: statusUrl+'/'+id,
        data: "",
        success: function (response) {
             if (response.status == 400) {
                    // errors
                    $('#list_error_message3').html("");
                    $('#list_error_message3').addClass("alert alert-danger");
                    $('#list_error_message3').text(response.message);
                } else {
                    $('#error_message').html("");
                    $('#error_message').addClass("alert alert-success");
                    $('#error_message').text(response.message);
                    table.ajax.reload(null, false);
                }
        }
    });
});

//  close action
$(document).on('click', '#close', function (e) {
    e.preventDefault();
    $('#formTableAdd')[0].reset();
});

// Filters Table
// $('#statusFilter').change(function(){
//     table.ajax.reload(null, false);
// });
