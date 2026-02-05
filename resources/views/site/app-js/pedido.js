$('[data-link]').on('click', function () {
    let link = $(this).data('link');
    window.location.href = link;
})
$('.btn-status').on('click', function () {
    let status = $(this).data('status');
    if (status == 0) {
        $('.status-all').fadeIn();
    } else {
        $('.status-all').fadeOut();
        $('.status-' + status).fadeIn();
    }
});
$('.btn-status-sel').on('change', function () {
    let status = $('.btn-status-sel option:selected').data('status');
    if (status == 0) {
        $('.status-all').fadeIn();
    } else {
        $('.status-all').fadeOut();
        $('.status-' + status).fadeIn();
    }
});
