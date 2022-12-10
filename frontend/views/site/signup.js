var urlfassignup = "$urlfassignup", abreviaturasidentificacion = $abreviaturasidentificacion, urlsms = '$urlsms', _form = $('#form-signup'), _signupbtn = $("#signup-button"), celular = "", correo_electronico = "", identificacion = "", correo_electronicovalido = "", celularvalido = "", identificacionvalida = "", todovalidado = !1, celularvalidado = !1, correo_electronicovalidado = !1, identificacionvalidada = !1,
        setMessage = function (message, tipo) {
            if (!camarahabilitada) {
                $("#message-signup").html(messagecamara);
            } else {
                if (message == "") {
                    $("#message-signup").html("");
                } else {
                    $("#message-signup").html("<div class='alert-" + tipo + " alert alert-dismissible' role='alert'>" + message + "</div>");
                }
            }
        }
;
$("#ayudasignup").load(urlfassignup);
$("#documentoidentificacion-button").on("click", function (e) {
    var btn = $('#signupform-documentoidentificacion');
    btn.click();
    return false;
});
$("#documentoidentificacion-button").on("focusout", function (e) {
    _form.yiiActiveForm("validateAttribute", "signupform-documentoidentificacion");
});
$("#signupform-documentoidentificacion").on("change", function (e) {
    var canvaspdf = $("#canvaspdf").get(0), pdffile = $(this).get(0).files[0], fileReader = new FileReader(), pdfjsLib = window['pdfjs-dist/build/pdf'], canvasContext = canvaspdf.getContext('2d'), pdffile_url = URL.createObjectURL(pdffile);
    canvasContext.clearRect(0, 0, canvas.width, canvas.height);
    canvaspdf.height = 0;
    canvaspdf.width = 0;
    $("#signupform-pdf_correcto").val(0);
    if (pdffile.type != "application/pdf") {
        console.error(pdffile.name, " no es un archivo pdf.");
        return;
    }
    fileReader.onload = function () {
        pdfjsLib.GlobalWorkerOptions.workerSrc = '//mozilla.github.io/pdf.js/build/pdf.worker.js';
        var typedarray = new Uint8Array(this.result), loadingTask = pdfjsLib.getDocument(typedarray);
        loadingTask.promise.then(function (pdf) {
            pdf.getPage(pdf.numPages).then(function (page) {
                var viewport = page.getViewport({'scale': 1.0, 'rotate': 0});
                canvaspdf.height = viewport.height;
                canvaspdf.width = viewport.width;
                page.render({'canvasContext': canvasContext, 'viewport': viewport});
                $("#signupform-pdf_correcto").val(1);
                $("#viewerpdfconfirm").attr("src", pdffile_url);
                $("#errorpdf").html("");
            });
        }, function (reason) {
            console.error(reason);
            $("#errorpdf").html("<div class='alert-danger alert alert-dismissible' role='alert'>Debe cargar un pdf legible.</div>");
            $("#viewerpdfconfirm").attr('src', '');
            setMessage("El pdf que intenta cargar no tiene el formato correcto, está dañado o tiene contraseña. Debe usar otro archivo.", "danger");
        });
    };
    fileReader.readAsArrayBuffer(pdffile);
    _form.yiiActiveForm("validateAttribute", "signupform-pdf_correcto");
});
$("#reset-button").on("click", function () {
    krajeeDialog.confirm("¿Seguro que desea borrar el formulario?", function (result) {
        if (result) {
            _form.trigger("reset");
        }
    });
});
_signupbtn.on("click", function () {
    krajeeDialog.confirm($("#confirm-div").html(), function (result) {
        if (result) {
            _form.submit();
        }
    });
});
$(() => {
    function _enable() {
        setMessage('Dé clic en [REGISTRO] para enviar el formulario.', 'info');
        _signupbtn.prop('disabled', !tokenobtenido);
        _signupbtn.focus();
    }
    function _disable() {
        _signupbtn.prop('disabled', !0);
    }
    enableSubmit = _enable;
    disableSubmit = _disable;
});
setMessage('Ingrese el nombre completo tal como aparece en el documento de identificación.', "info");
$(".g-recaptcha").each(function () {
    this.addEventListener('load', function (e) {
        var tabindex = e.currentTarget.getAttribute('data-tabindex');
        if (tabindex) {
            e.target.tabIndex = tabindex;
        }
    }, true);
});
$("#signupform-tipo_identificacion_id").parent().find('.select2').on("focusout", function (e) {
    var span = $("#" + $(this).data("spanid"));
    setMessage("", "");
    span.html(abreviaturasidentificacion[$("#signupform-tipo_identificacion_id").val()]);
    _form.yiiActiveForm("validateAttribute", "signupform-foto");
    _form.yiiActiveForm("validateAttribute", "signupform-tipo_identificacion_id");
    setMessage("", "");
});
$("#signupform-tipo_identificacion_id").parent().find('.select2').prop('id', 'signupform-tipo_identificacion_select2');
$("#signupform-tipo_identificacion_select2").attr('data-message', 'Seleccione el tipo de identificación.');
$("#signupform-tipo_identificacion_select2").attr('data-spanid', 'span_tipodocumentoidentificacion');
_signupbtn.prop('disabled', !0);
$(".nocopypaste").on('paste', function (e) {
    e.preventDefault();
});
$(".nocopypaste").on('copy', function (e) {
    e.preventDefault();
});
$(".nocopypaste").on('cut', function (e) {
    e.preventDefault();
});
$(".nocopypaste").on("select", function () {
    this.selectionStart = this.selectionEnd;
});
$(".triminput").on("focusout", function (e) {
    setMessage("", "");
    $(this).val($.trim($(this).val()));
});
$("#signupform-nombres,#signupform-apellidos,#signupform-correo_electronico,#signupform-fecha_nacimiento,#signupform-celular,#signupform-identificacion").on("focusout", function (e) {
    var span = $("#" + $(this).data("spanid"));
    setMessage("", "");
    span.html($(this).val());
    _form.yiiActiveForm("validateAttribute", "signupform-foto");
});
$("#signupform-celular,#signupform-token,#signupform-password_fake,#signupform-password_repeat_fake,#obtener-token-button,#foto-button,#documentoidentificacion-button,#reset-button").on("focusout", function (e) {
    setMessage("", "");
    _form.yiiActiveForm("validateAttribute", "signupform-foto");
});
$(".nombresaspirante,.correosaspirante,#signupform-fecha_nacimiento,#signupform-identificacion,#signupform-celular,#signupform-token,#signupform-password_fake,#signupform-password_repeat_fake,#obtener-token-button,#signupform-tipo_identificacion_select2,#foto-button,#documentoidentificacion-button,#reset-button").on("focusin", function (e) {
    setMessage($(this).data("message"), "info");
});
$(".nombresaspirante").on("keyup", function (e) {
    var pos = e.target.selectionStart;
    $(this).val($(this).val().toUpperCase());
    setCaretPosition(this, pos);
});
$(".correosaspirante").on("keyup", function (e) {
    var pos = e.target.selectionStart;
    $(this).val($(this).val().toLowerCase());
    setCaretPosition(this, pos);
});
function validacion() {
    celularvalidado = $("#signupform-celular").val().match(/^[3]\d{9}$/g) != null;
    correo_electronicovalidado = $("#signupform-correo_electronico").val().match(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/i) != null && $("#signupform-correo_electronico").val() === $("#signupform-repite_correo_electronico").val();
    identificacionvalidada = $("#signupform-identificacion").val().match(/^((\d{8})|(\d{10})|(\d{11}))$/g) != null;
    if ($("#signupform-celular").val() == celularvalido && $("#signupform-identificacion").val() == identificacionvalida && $("#signupform-correo_electronico").val() == correo_electronicovalido) {
        celular = $("#signupform-celular").val();
        identificacion = $("#signupform-identificacion").val();
        correo_electronico = $("#signupform-correo_electronico").val();
        tokenobtenido = !0;
        listocelular();
    } else {
        todovalidado = (celularvalidado && correo_electronicovalidado && identificacionvalidada);
        if (todovalidado) {
            setMessage('Dé clic en el botón [TOKEN] para recibir el token en su celular.', "info");
        }
        $("#obtener-token-button").prop('disabled', !(todovalidado));
        $("#foto-button").prop('disabled', !(todovalidado));
        $("#signupform-token").prop('readonly', !0);
        $("#signupform-token").val("");
        $("#signupform-token").attr("placeholder", 'Dé clic en el botón [TOKEN] para recibir el token en su celular.');
        tokenobtenido = false;
        _signupbtn.prop('disabled', !0);
        $("#captcha_wrapper").addClass("disabled-element");
    }
}
$("#signupform-celular,#signupform-identificacion,#signupform-correo_electronico,#signupform-repite_correo_electronico").on("keyup", function (e) {
    if ($("#signupform-celular").val() != "" && $("#signupform-identificacion").val() != "" && $("#signupform-correo_electronico").val() != "") {
        validacion();
    }
});
$(':input[type="number"]').on("keypress", function (e) {
    var e = e || window.event;
    var keycode = ("keyCode" in e) ? e.keyCode : e.which;
    if (keycode === 187 || keycode === 43 || keycode === 101 || keycode === 44 || keycode === 45 || keycode === 46 || keycode === 39 || keycode === 222 || $(this).val().length >= $(this).attr('maxlength')) {
        e.preventDefault();
        return;
    }
});
$("#obtener-token-button").on("click", function (e) {
    celular = $("#signupform-celular").val();
    identificacion = $("#signupform-identificacion").val();
    correo_electronico = $("#signupform-correo_electronico").val();
    if (celular.match(/^[3]\d{9}$/g)) {
        $.ajax({
            url: urlsms,
            type: "post",
            data: {'Token[celular]': celular, 'Token[correo_electronico]': correo_electronico, 'Token[identificacion]': identificacion},
            cache: false,
            async: true,
            success: function (response) {
                tokenobtenido = response.resultado;
                setMessage(response.message, ((tokenobtenido) ? "success" : "danger"));
                if (tokenobtenido) {
                    listocelular();
                }
            }
        }).done(function () {}).fail(function () {}).always(function () {});
    } else {
        $("#signupform-celular").blur();
    }
});
function listocelular() {
    celularvalido = celular;
    correo_electronicovalido = correo_electronico;
    identificacionvalida = identificacion;
    $("#signupform-token").prop('readonly', !1);
    $("#captcha_wrapper").removeClass("disabled-element");
    $("#signupform-token").attr("placeholder", 'Dé clic en el botón [TOKEN] para recibir el token en su celular.');
    $("#signupform-token").focus();
}