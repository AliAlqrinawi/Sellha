let host = document.location;

let PackageUrl = new URL('/admin/package', host.origin);
let pathSegments = host.pathname.split('/');
let currentLang = pathSegments[1];
if(currentLang != 'ar' || currentLang != 'en'){
    currentLang = 'en';
}

var package = $('#get_package').DataTable({
    processing: true,
    ajax: PackageUrl,
    columns: [
        {data: "DT_RowIndex", name: "DT_RowIndex"},
        {data: "title", name: "title"},
        {data: "description", name: "description"},
        {data: "title_duration", name: "title_duration"},
        {data: "duration", name: "duration"},
        {data: "price", name: "price"},
        {data: "status", name: "status"},
        {data: "action", name: "action"},
    ]
});
//  view modal package
$(document).on('click', '#ShowModalPackage', function (e) {
    e.preventDefault();
    $('#modalPackageAdd').modal('show');
});

let AddUrl = new URL('admin/package', host.origin);
// category admin
$(document).on('click', '#addPackage', function (e) {
    e.preventDefault();
    let formdata = new FormData($('#formPackageAdd')[0]);
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
                $('#modalPackageAdd').modal('hide');
                $('#formPackageAdd')[0].reset();
                package.ajax.reload(null, false);
            }
        }
    });
});

let EditUrl = new URL('admin/package', host.origin);
// view modification data
$(document).on('click', '#showModalEditPackage', function (e) {
    e.preventDefault();
    var id = $(this).data('id');
    $('#modalPackageUpdate').modal('show');
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
                $('#title_duration_ar').val(response.data.title_duration_ar);
                $('#title_duration_en').val(response.data.title_duration_en);
                $('#duration').val(response.data.duration);
                $('#price').val(response.data.price);
                $('#options').val(response.data.options);
                $('#end_at').val(response.data.end_at);
                $("#status option[value='"+response.data.status+"']").prop("selected", true);
            }
        }
    });
});

let UpdateUrl = new URL('admin/package', host.origin);
$(document).on('click', '#updatePackage', function (e) {
    e.preventDefault();
    let formdata = new FormData($('#formPackageUpdate')[0]);
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
                $('#modalPackageUpdate').modal('hide');
                $('#formPackageUpdate')[0].reset();
                package.ajax.reload(null, false);
            }
        }
    });
});

let DeleteUrl = new URL('admin/package', host.origin);
$(document).on('click', '#showModalDeletePackage', function (e) {
    e.preventDefault();
    $('#nameDetele').val($(this).data('name'));
    var id = $(this).data('id');
    $('#modalPackageDelete').modal('show');
    gg(id);
});
function gg(id) {
    $(document).off("click", "#deletePackage").on("click", "#deletePackage", function (e) {
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
                    $('#modalPackageDelete').modal('hide');
                    package.ajax.reload(null, false);
                }
            }
        });
    });
}

let statusUrl = new URL('admin/status/package', host.origin);
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
                    package.ajax.reload(null, false);
                }
        }
    });
});

//  close action
$(document).on('click', '#close', function (e) {
    e.preventDefault();
    $('#formPackageAdd')[0].reset();
});
