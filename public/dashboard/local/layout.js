let host = document.location;

let layoutUrl = new URL('/admin/layout', host.origin);
let pathSegments = host.pathname.split('/');
let currentLang = pathSegments[1];
// if(currentLang != 'ar' || currentLang != 'en'){
//     currentLang = 'en';
// }
console.log(currentLang);
var layout = $('#get_layout').DataTable({
    processing: true,
    ajax: layoutUrl,
    columns: [
        {data: "DT_RowIndex", name: "id"},
        {data: "image", name: "image"},
        {data: "title_"+currentLang, name: "title_"+currentLang},
        {data: "sud_title_"+currentLang, name: "sud_title_"+currentLang},
        {data: "description_"+currentLang, name: "description_"+currentLang},
        {data: "layout", name: "layout"},
        {data: "action", name: "action"},
    ]
});
//  view modal layout
$(document).on('click', '#ShowModalLayout', function (e) {
    e.preventDefault();
    $('#modalLayoutAdd').modal('show');
});

let AddUrl = new URL('admin/layout', host.origin);
// category admin
$(document).on('click', '#addLayout', function (e) {
    e.preventDefault();
    let formdata = new FormData($('#formLayoutAdd')[0]);
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
                $('#modalLayoutAdd').modal('hide');
                $('#formLayoutAdd')[0].reset();
                layout.ajax.reload(null, false);
            }
        }
    });
});

let EditUrl = new URL('admin/layout', host.origin);
// view modification data
$(document).on('click', '#showModalEditLayout', function (e) {
    e.preventDefault();
    var id = $(this).data('id');
    $('#modalLayoutUpdate').modal('show');
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
                $('#title_ar').val(response.data.title_ar);
                $('#title_en').val(response.data.title_en);
                $('#sud_title_ar').val(response.data.sud_title_ar);
                $('#sud_title_en').val(response.data.sud_title_en);
                $('#description_ar').val(response.data.description_ar);
                $('#description_en').val(response.data.description_en);
                $("#layout option[value='"+response.data.layout+"']").prop("selected", true);
            }
        }
    });
});

let UpdateUrl = new URL('admin/layout', host.origin);
$(document).on('click', '#updateLayout', function (e) {
    e.preventDefault();
    let formdata = new FormData($('#formLayoutUpdate')[0]);
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
                $('#modalLayoutUpdate').modal('hide');
                $('#formLayoutUpdate')[0].reset();
                layout.ajax.reload(null, false);
            }
        }
    });
});

let DeleteUrl = new URL('admin/layout', host.origin);
$(document).on('click', '#showModalDeleteLayout', function (e) {
    e.preventDefault();
    $('#nameDetele').val($(this).data('name'));
    var id = $(this).data('id');
    $('#modalLayoutDelete').modal('show');
    gg(id);
});
function gg(id) {
    $(document).off("click", "#deleteLayout").on("click", "#deleteLayout", function (e) {
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
                    $('#modalLayoutDelete').modal('hide');
                    layout.ajax.reload(null, false);
                }
            }
        });
    });
}

let statusUrl = new URL('admin/status/layout', host.origin);
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
                    layout.ajax.reload(null, false);
                }
        }
    });
});

//  close action
$(document).on('click', '#close', function (e) {
    e.preventDefault();
    $('#formLayoutAdd')[0].reset();
});
