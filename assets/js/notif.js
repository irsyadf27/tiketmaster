function notif_error(pesan) {
    new PNotify({
        title: 'Error',
        text: pesan,
        type: 'error',
        styling: 'bootstrap3',
        hide: false,
        buttons: {
            sticker: false
        }
    });
}
function notif_warning(pesan) {
    new PNotify({
        title: 'Pemberitahuan',
        text: pesan,
        styling: 'bootstrap3',
        hide: false,
        buttons: {
            sticker: false
        }
    });
}