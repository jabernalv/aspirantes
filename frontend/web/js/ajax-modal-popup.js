/* 
 *Tomado de https://www.yiiframework.com/wiki/806/render-form-in-popup-via-ajax-create-and-update-with-ajax-validation-also-load-any-page-via-ajax-yii-2-0-2-3
 */
var _puedecerrar = false;
var _contenidopopup = '<canvas id="canvas" style="display: none;"></canvas>';
$(function () {
    //get the click of modal button to create / update item
    //we get the button by class not by ID because you can only have one id on a page and you can
    //have multiple classes therefore you can have multiple open modal buttons on a page all with or without
    //the same link.
    //we use on so the dom element can be called again if they are nested, otherwise when we load the content once it kills the dom element and wont let you load anther modal on click without a page refresh
    $('#modaldialog').on('hide.bs.modal', function (e) {
        if (!_puedecerrar) {
            // do something...
            e.preventDefault();
            e.stopPropagation();
            return false;
        } else {
            $('#modalContent').html(_contenidopopup);
            return true;
        }
    });
    $(document).on('click', '.showModalButton', function () {
        _puedecerrar = false;
        //check if the modal is open. if it's open just reload content not whole modal
        //also this allows you to nest buttons inside of modals to reload the content it is in
        //the if else are intentionally separated instead of put into a function to get the 
        //button since it is using a class not an #id so there are many of them and we need
        //to ensure we get the right button and content. 
        $('#modaldialog').modal({backdrop: 'static', keyboard: false}, 'show').find('#modalContent').load($(this).attr('value'));
        //dynamiclly set the header for the modal
        $('#modalHeader').html('<table style="width: 100% !important;"><tr><td><h5>' + $(this).attr('title') + '</h5></td><td style="width: 30px;"><button id="close-main-modal" type="button" class="close btn btn-sm btn-kv btn-default btn-outline-secondary btn-close" title="Cerrar vista detallada" data-dismiss="modal" aria-hidden="true" aria-label="Close" onclick="_puedecerrar=true;return true;"><svg class="svg-inline--fa fa-times fa-w-11 fa-fw" aria-hidden="true" data-prefix="fas" data-icon="times" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512" data-fa-i2svg=""><path fill="currentColor" d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"></path></svg><!-- <i class="fas fa-fw fa-times"></i> --></button></td></tr></table>');
    });
    $(document).on('click', '.showModalLinkImage', function () {
        _puedecerrar = true;
        //check if the modal is open. if it's open just reload content not whole modal
        //also this allows you to nest buttons inside of modals to reload the content it is in
        //the if else are intentionally separated instead of put into a function to get the 
        //button since it is using a class not an #id so there are many of them and we need
        //to ensure we get the right button and content.
        var img=$(this).find("img"),src=img.attr('src');
        $('#modaldialog').modal({backdrop: 'static', keyboard: false}, 'show').find('#modalContent').html("<div class='row'><div class='col'><img src='" + src + "' width='100%'></div></div>");
        //dynamiclly set the header for the modal
        $('#modalHeader').html('<table style="width: 100% !important;"><tr><td><h5>Ayuda</h5></td><td style="width: 30px;"><button id="close-main-modal" type="button" class="close btn btn-sm btn-kv btn-default btn-outline-secondary btn-close" title="Cerrar vista detallada" data-dismiss="modal" aria-hidden="true" aria-label="Close" onclick="_puedecerrar=true;return true;"><svg class="svg-inline--fa fa-times fa-w-11 fa-fw" aria-hidden="true" data-prefix="fas" data-icon="times" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512" data-fa-i2svg=""><path fill="currentColor" d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"></path></svg><!-- <i class="fas fa-fw fa-times"></i> --></button></td></tr></table>');
    });
});

