let host = document.location;

let RoleUrl = new URL('/admin/role', host.origin);
let pathSegments = host.pathname.split('/');
let currentLang = pathSegments[1];
if(currentLang != 'ar' || currentLang != 'en'){
    currentLang = 'en';
}

var role = $('#get_role').DataTable({
    processing: true,
    ajax: RoleUrl,
    columns: [
        {data: "DT_RowIndex", name: "id"},
        {data: "name", name: "name"},
        // {data: "count", name: "count"},
        {data: "created_at", name: "created_at"},
        {data: "action", name: "action"},
    ]
});

function run(f = []) {
    for (var i = 0; i < f.length; i++) {
        $('#' + f[i]).removeClass('on');
    }
}

var Permissions = ['role-view', 'role-create', 'role-update', 'role-delete'
];

var roles = [
    'role-all', 'role-view', 'role-create', 'role-update', 'role-delete',
];

function all(all, arr = []) {
    $('#' + all + 'a').click(function(e) {
        e.preventDefault();
        for (var i = 0; i < arr.length; i++) {
            if ($('#' + all + "a").hasClass('on')) {
                $('#' + arr[i] + 'a').removeClass('on');
            } else {
                $('#' + arr[i] + 'a').addClass('on');
            }

        }
    });
    $('#' + all).click(function(e) {
        e.preventDefault();
        for (var i = 0; i < arr.length; i++) {
            if ($('#' + all).hasClass('on')) {
                $('#' + arr[i]).removeClass('on');
            } else {
                $('#' + arr[i]).addClass('on');
            }
        }
    });
}

all('role-all', Permissions);

$('#allh').click(function(e) {
    e.preventDefault();
    for (var i = 0; i < roles.length; i++) {
        if ($('#allh').hasClass('on')) {
            $('#' + roles[i] + 'a').removeClass('on');
        } else {
            $('#' + roles[i] + 'a').addClass('on');
        }
    }
});
$('#allu').click(function(e) {
    e.preventDefault();
    for (var i = 0; i < roles.length; i++) {
        if ($('#allu').hasClass('on')) {
            $('#' + roles[i]).removeClass('on');
        } else {
            $('#' + roles[i]).addClass('on');
        }
    }
});

//  view modal role
$(document).on('click', '#ShowModalRole', function (e) {
    e.preventDefault();
    $('#modalRoleAdd').modal('show');
});

let AddUrl = new URL('admin/role', host.origin);
// category admin
$(document).on('click', '#addRole', function (e) {
    e.preventDefault();
    const points = new Array();
    for (var i = 0; i < roles.length; i++) {
        if ($('#' + roles[i] + "a").hasClass('on')) {
            points.push($('#' + roles[i] + "a").data('v'));
        }
    }
    var data = {
        name: $('#user_name').val(),
        permissions: points,
    };
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        url: AddUrl,
        data: data,
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
                $('#modalRoleAdd').modal('hide');
                role.ajax.reload(null, false);
            }
        }
    });
});

let EditUrl = new URL('admin/role', host.origin);
// view modification data
$(document).on('click', '#showModalEditRole', function (e) {
    e.preventDefault();
    var id = $(this).data('id');
    $('#modalRoleUpdate').modal('show');
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
                // function run(f = []) {
                //     for (var i = 0; i < f.length; i++) {
                //         $('#' + f[i]).removeClass('on');
                //     }
                // }
                run(roles);
                $('#edit_user_name').val(response.data.name);
                $('#id').val(id);
                for (var i = 0; i < response.data.permissions.length; i++) {
                    if (response.data.permissions[i] == $('#' + response.data
                        .permissions[i]).data('v')) {
                        $('#' + response.data.permissions[i]).addClass('on');
                    } else {
                        $('#' + response.data.permissions[i]).removeClass('on');
                    }
                }
            }
        }
    });
});

let UpdateUrl = new URL('admin/role', host.origin);
$(document).on('click', '#updateRole', function (e) {
    e.preventDefault();
    let formdata = new FormData($('#formRoleUpdate')[0]);
    var id = $('#id').val();
    console.log(id);
    const point = new Array();
    for (var i = 0; i < roles.length; i++) {
        if ($('#' + roles[i]).hasClass('on')) {
            point.push($('#' + roles[i]).data('v'));
        }
    }
    var data = {
        id: id,
        permissions: point,
        name: $('#edit_user_name').val(),
    };
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'PUT',
        url: UpdateUrl+'/'+id,
        data: data,
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
                $('#modalRoleUpdate').modal('hide');
                role.ajax.reload(null, false);
            }
        }
    });
});

let DeleteUrl = new URL('admin/role', host.origin);
$(document).on('click', '#showModalDeleteRole', function (e) {
    e.preventDefault();
    $('#nameDetele').val($(this).data('name'));
    var id = $(this).data('id');
    $('#modalRoleDelete').modal('show');
    gg(id);
});
function gg(id) {
    $(document).off("click", "#deleteRole").on("click", "#deleteRole", function (e) {
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
                    $('#modalRoleDelete').modal('hide');
                    role.ajax.reload(null, false);
                }
            }
        });
    });
}
