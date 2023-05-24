let host = document.location;

let CouponUrl = new URL('/admin/coupon', host.origin);
let pathSegments = host.pathname.split('/');
let currentLang = pathSegments[1];
if(currentLang != 'ar' || currentLang != 'en'){
    currentLang = 'en';
}

var coupon = $('#get_coupon').DataTable({
    processing: true,
    ajax: CouponUrl,
    columns: [
        {data: "DT_RowIndex", name: "id"},
        {data: "code", name: "code"},
        {data: "discount", name: "discount"},
        {data: "end_at", name: "end_at"},
        {data: "status", name: "status"},
        {data: "action", name: "action"},
    ]
});
//  view modal coupon
$(document).on('click', '#ShowModalCoupon', function (e) {
    e.preventDefault();
    $('#modalCouponAdd').modal('show');
});

let AddUrl = new URL('admin/coupon', host.origin);
// category admin
$(document).on('click', '#addCoupon', function (e) {
    e.preventDefault();
    let formdata = new FormData($('#formCouponAdd')[0]);
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
                $('#modalCouponAdd').modal('hide');
                $('#formCouponAdd')[0].reset();
                coupon.ajax.reload(null, false);
            }
        }
    });
});

let EditUrl = new URL('admin/coupon', host.origin);
// view modification data
$(document).on('click', '#showModalEditCoupon', function (e) {
    e.preventDefault();
    var id = $(this).data('id');
    $('#modalCouponUpdate').modal('show');
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
                $('#code').val(response.data.code);
                $('#discount').val(response.data.discount);
                $('#end_at').val(response.data.end_at);
                $("#status option[value='"+response.data.status+"']").prop("selected", true);
            }
        }
    });
});

let UpdateUrl = new URL('admin/coupon', host.origin);
$(document).on('click', '#updateCoupon', function (e) {
    e.preventDefault();
    let formdata = new FormData($('#formCouponUpdate')[0]);
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
                $('#modalCouponUpdate').modal('hide');
                $('#formCouponUpdate')[0].reset();
                coupon.ajax.reload(null, false);
            }
        }
    });
});

let DeleteUrl = new URL('admin/coupon', host.origin);
$(document).on('click', '#showModalDeleteCoupon', function (e) {
    e.preventDefault();
    $('#nameDetele').val($(this).data('name'));
    var id = $(this).data('id');
    $('#modalCouponDelete').modal('show');
    gg(id);
});
function gg(id) {
    $(document).off("click", "#deleteCoupon").on("click", "#deleteCoupon", function (e) {
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
                    $('#modalCouponDelete').modal('hide');
                    coupon.ajax.reload(null, false);
                }
            }
        });
    });
}

let statusUrl = new URL('admin/status/coupon', host.origin);
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
                    coupon.ajax.reload(null, false);
                }
        }
    });
});

//  close action
$(document).on('click', '#close', function (e) {
    e.preventDefault();
    $('#formCouponAdd')[0].reset();
});
