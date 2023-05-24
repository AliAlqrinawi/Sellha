let host = document.location;

let dayTableUrl = new URL('/admin/dayTable', host.origin);
let pathSegments = host.pathname.split('/');
let currentLang = pathSegments[1];
if(currentLang != 'ar' || currentLang != 'en'){
    currentLang = 'en';
}

var dayTable = $('#get_dayTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url:dayTableUrl
    },
    columns: [
        {data: "DT_RowIndex", name: "id"},
        {data: "image", name: "image"},
        {data: "title_"+currentLang, name: "title_"+currentLang},
        {data: "description_"+currentLang, name: "description_"+currentLang},
        {data: "status", name: "status"},
        {data: "action", name: "action"},
    ]
});

//  view modal dayTable
$(document).on('click', '#ShowModalDayTable', function (e) {
    e.preventDefault();
    $('#modalDayTableAdd').modal('show');
});

let AddUrl = new URL('admin/dayTable', host.origin);
// category admin
$(document).on('click', '#addDayTable', function (e) {
    e.preventDefault();
    let formdata = new FormData($('#formDayTableAdd')[0]);
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
                $('#modalDayTableAdd').modal('hide');
                $('#formDayTableAdd')[0].reset();
                dayTable.ajax.reload(null, false);
            }
        }
    });
});

let EditUrl = new URL('admin/dayTable', host.origin);
// view modification data
$(document).on('click', '#showModalEditDayTable', function (e) {
    e.preventDefault();
    var id = $(this).data('id');
    $('#modalDayTableUpdate').modal('show');
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
                // var id_videos = response.data.id_videos;
                // id_videos.forEach((value) => {
                //     console.log(value);
                //     $("#id_video").val(value).prop("selected", true);
                // });

                $("#parent_id option[value='"+response.data.parent_id+"']").prop("selected", true);
                $("#status option[value='"+response.data.status+"']").prop("selected", true);
            }
        }
    });
});

let UpdateUrl = new URL('admin/dayTable', host.origin);
$(document).on('click', '#updateDayTable', function (e) {
    e.preventDefault();
    let formdata = new FormData($('#formDayTableUpdate')[0]);
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
                $('#modalDayTableUpdate').modal('hide');
                $('#formDayTableUpdate')[0].reset();
                dayTable.ajax.reload(null, false);
            }
        }
    });
});

let DeleteUrl = new URL('admin/dayTable', host.origin);
$(document).on('click', '#showModalDeleteDayTable', function (e) {
    e.preventDefault();
    $('#nameDetele').val($(this).data('name'));
    var id = $(this).data('id');
    $('#modalDayTableDelete').modal('show');
    gg(id);
});
function gg(id) {
    $(document).off("click", "#deleteDayTable").on("click", "#deleteDayTable", function (e) {
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
                    $('#modalDayTableDelete').modal('hide');
                    dayTable.ajax.reload(null, false);
                }
            }
        });
    });
}

let statusUrl = new URL('admin/status/dayTable', host.origin);
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
                    dayTable.ajax.reload(null, false);
                }
        }
    });
});

//  close action
$(document).on('click', '#close', function (e) {
    e.preventDefault();
    $('#formDayTableAdd')[0].reset();
});

// Filters Table
// $('#statusFilter').change(function(){
//     table.ajax.reload(null, false);
// });
