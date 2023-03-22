function wbct_load_logo() {
    jQuery(document).ready(function(e) {
        var custom_uploader;
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Carica immagine',
            button: {
                text: 'Carica immagine'
            },
            library: { type: 'image' },
            multiple: true
        });
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            let fila = '<div id="fila_imagen">' +
                '<input  min="1" type="hidden" name="respuesta" id="" value="">' +
                '<div class="wbct-box-imagenes" id="imagen_preview">' +
                '<img src="' + attachment.url + '" style="max-width:360px" />' +
                '<input id="txtimage" type="hidden" name="txtimage" value="' + attachment.url + '" /> ' +
                '</div>' +
                '</div>';
            jQuery('.wbct-load-foto').html(fila);
        });
        custom_uploader.open();
    });
}