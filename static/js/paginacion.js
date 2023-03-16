/** Buscador */
function wbct_buscar_informacion(pagina, nombre_pagina, codigo) {
    var dato_search = document.getElementById("txt-search-notifica").value;
    (function ($) {
        var url = SolicitudesAjax.url;
        jQuery.ajax({
            type: 'POST',
            url: url,
            data: {
                pagina: pagina,
                codigo: codigo,
                nombre_pagina: nombre_pagina,
                dato_search: dato_search,
                action: "wrpro_load_informacion",
                nonce: SolicitudesAjax.seguridad,
            },
            /* beforeSend: function () {
                 jQuery('#wr-msg-paginacion').html('in aggiornamento..');
             },
             complete: function () {
                 jQuery('#wr-msg-paginacion').html('successful');
             },*/
            success: function (datos) {
                $(".wrbodytable").html(datos);
            },
            error: function (msg, xy) {
                console.log(msg);
                console.log(xy);
            }
        });
    })(jQuery);
}

(function ($) {
    nombre_pagina = jQuery('#nombre_pagina').val();
    wbct_buscar_informacion(1, nombre_pagina, '');
})(jQuery);

