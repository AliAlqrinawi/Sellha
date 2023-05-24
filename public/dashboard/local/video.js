let host = document.location;

let VideoUrl = new URL('/admin/video', host.origin);
let pathSegments = host.pathname.split('/');
let currentLang = pathSegments[1];
if(currentLang != 'ar' || currentLang != 'en'){
    currentLang = 'en';
}

var video = $('#get_video').DataTable({
    processing: true,
    ajax: VideoUrl,
    columns: [
        {data: "DT_RowIndex", name: "DT_RowIndex"},
        {data: "image", name: "image"},
        {data: "title", name: "title_"+currentLang},
        {data: "status", name: "status"},
        {data: "action", name: "action"},
    ]
});
//  view modal video
$(document).on('click', '#ShowModalVideo', function (e) {
    e.preventDefault();
    $('#modalVideoAdd').modal('show');
});

let AddUrl = new URL('admin/video', host.origin);
// category admin
$(document).on('click', '#addVideo', function (e) {
    e.preventDefault();
    let formdata = new FormData($('#formVideoAdd')[0]);
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
                $('#modalVideoAdd').modal('hide');
                $('#formVideoAdd')[0].reset();
                video.ajax.reload(null, false);
            }
        }
    });
});

let EditUrl = new URL('admin/video', host.origin);
// view modification data
$(document).on('click', '#showModalEditVideo', function (e) {
    e.preventDefault();
    var id = $(this).data('id');
    $('#modalVideoUpdate').modal('show');
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
                // 'exercise_id' => 'required|exists:exercises,id',
                $('#id').val(id);
                $('#title_en').val(response.data.title_en);
                $('#title_ar').val(response.data.title_ar);
                $('#duration_exercise').val(response.data.duration_exercise);
                $('#fitness_level').val(response.data.fitness_level);
                $("#exercise_id option[value='"+response.data.exercise_id+"']").prop("selected", true);
                $("#type option[value='"+response.data.type+"']").prop("selected", true);
                $("#status option[value='"+response.data.status+"']").prop("selected", true);
            }
        }
    });
});

let UpdateUrl = new URL('admin/video', host.origin);
$(document).on('click', '#updateVideo', function (e) {
    e.preventDefault();
    let formdata = new FormData($('#formVideoUpdate')[0]);
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
                $('#modalVideoUpdate').modal('hide');
                $('#formVideoUpdate')[0].reset();
                video.ajax.reload(null, false);
            }
        }
    });
});

let DeleteUrl = new URL('admin/video', host.origin);
$(document).on('click', '#showModalDeleteVideo', function (e) {
    e.preventDefault();
    $('#nameDetele').val($(this).data('name'));
    var id = $(this).data('id');
    $('#modalVideoDelete').modal('show');
    gg(id);
});
function gg(id) {
    $(document).off("click", "#deleteVideo").on("click", "#deleteVideo", function (e) {
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
                    $('#modalVideoDelete').modal('hide');
                    video.ajax.reload(null, false);
                }
            }
        });
    });
}

let statusUrl = new URL('admin/status/video', host.origin);
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
                    video.ajax.reload(null, false);
                }
        }
    });
});

//  close action
$(document).on('click', '#close', function (e) {
    e.preventDefault();
    $('#formVideoAdd')[0].reset();
});
