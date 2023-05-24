let host = document.location;

let ExerciseUrl = new URL('/admin/exercise', host.origin);
let pathSegments = host.pathname.split('/');
let currentLang = pathSegments[1];
if(currentLang != 'ar' || currentLang != 'en'){
    currentLang = 'en';
}

var exercise = $('#get_exercise').DataTable({
    processing: true,
    ajax: ExerciseUrl,
    columns: [
        {data: "DT_RowIndex", name: "DT_RowIndex"},
        {data: "image", name: "image"},
        {data: "title", name: "title"},
        {data: "status", name: "status"},
        {data: "action", name: "action"},
    ]
});
//  view modal exercise
$(document).on('click', '#ShowModalExercise', function (e) {
    e.preventDefault();
    $('#modalExerciseAdd').modal('show');
});

let AddUrl = new URL('admin/exercise', host.origin);
// category admin
$(document).on('click', '#addExercise', function (e) {
    e.preventDefault();
    let formdata = new FormData($('#formExerciseAdd')[0]);
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
                $('#modalExerciseAdd').modal('hide');
                $('#formExerciseAdd')[0].reset();
                exercise.ajax.reload(null, false);
            }
        }
    });
});

let EditUrl = new URL('admin/exercise', host.origin);
// view modification data
$(document).on('click', '#showModalEditExercise', function (e) {
    e.preventDefault();
    var id = $(this).data('id');
    $('#modalExerciseUpdate').modal('show');
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
                $("#status option[value='"+response.data.status+"']").prop("selected", true);
            }
        }
    });
});

let UpdateUrl = new URL('admin/exercise', host.origin);
$(document).on('click', '#updateExercise', function (e) {
    e.preventDefault();
    let formdata = new FormData($('#formExerciseUpdate')[0]);
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
                $('#modalExerciseUpdate').modal('hide');
                $('#formExerciseUpdate')[0].reset();
                exercise.ajax.reload(null, false);
            }
        }
    });
});

let DeleteUrl = new URL('admin/exercise', host.origin);
$(document).on('click', '#showModalDeleteExercise', function (e) {
    e.preventDefault();
    $('#nameDetele').val($(this).data('name'));
    var id = $(this).data('id');
    $('#modalExerciseDelete').modal('show');
    gg(id);
});
function gg(id) {
    $(document).off("click", "#deleteExercise").on("click", "#deleteExercise", function (e) {
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
                    $('#modalExerciseDelete').modal('hide');
                    exercise.ajax.reload(null, false);
                }
            }
        });
    });
}

let statusUrl = new URL('admin/status/exercise', host.origin);
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
                    exercise.ajax.reload(null, false);
                }
        }
    });
});

//  close action
$(document).on('click', '#close', function (e) {
    e.preventDefault();
    $('#formExerciseAdd')[0].reset();
});
