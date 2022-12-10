var abreviaturasidentificacion = $abreviaturasidentificacion,
        urlsms = '$urlsms',
        _formsignup = $('#form-signup'),
        celular = "",
        correo_electronico = "",
        identificacion = "",
        correo_electronicovalido = "",
        celularvalido = "",
        identificacionvalida = "",
        todovalidado = !1,
        celularvalidado = !1,
        correo_electronicovalidado = !1,
        identificacionvalidada = !1,
        contentCargados = [true],
        navListItems = $('div.setup-panel div a'), // tab nav items
        allWells = $('.setup-content'), // content div
        _data = _formsignup.data("yiiActiveForm"),
        listocelular = function () {
            celularvalido = celular;
            correo_electronicovalido = correo_electronico;
            identificacionvalida = identificacion;
            //$("#signupform-token").prop('readonly',!1); // Hay que activar este
            $("#signupform-token").attr("placeholder", 'Dé clic en el botón [TOKEN] para recibir el token en su celular.');
            $("#signupform-token").focus();
        },
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
        },
        validacion = function () {
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
                //$("#signupform-token").prop('readonly',!0); // Hay que activar este
                $("#signupform-token").val("");
                $("#signupform-token").attr("placeholder", 'Dé clic en el botón [TOKEN] para recibir el token en su celular.');
                tokenobtenido = false;
            }
        }
;
$(".setup-content").each(function (index, element) {
    if (index > 0) {
        contentCargados.push(false);
    }
    $(this).data('index', index);
});
$("#signup-button").on("click", function (event) {
    $("#signupform-foto").val(foto64);
});
$("#foto-button").on('focusout', function (e) {
    _formsignup.yiiActiveForm("validateAttribute", "signupform-foto");
});
$("#signupform-captcha-image").trigger("click");
$("#documentoidentificacion-button").on("click", function (e) {
    var btn = $('#signupform-documentoidentificacion');
    btn.click();
    return false;
});
$("#documentoidentificacion-button").on("focusout", function (e) {
    _formsignup.yiiActiveForm("validateAttribute", "signupform-documentoidentificacion");
});
$("#obtener-token-button").on("focusout", function (e) {
    if (!($('#signupform-token').is('[readonly]'))) {
        $('#signupform-token').focus();
    }
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
                var viewport = page.getViewport({'scale': 1, 'rotate': 0});
                canvaspdf.height = viewport.height;
                canvaspdf.width = viewport.width;
                page.render({'canvasContext': canvasContext, 'viewport': viewport});
                $("#signupform-pdf_correcto").val(1);
                $("#viewerpdfconfirm").attr("src", pdffile_url);
                $("#errorpdf").html("");
                _formsignup.yiiActiveForm("validateAttribute", "signupform-documentoidentificacion");
            });
        }, function (reason) {
            console.error(reason);
            $("#errorpdf").html("<div class='alert-danger alert alert-dismissible' role='alert'>Debe cargar un pdf legible.</div>");
            $("#viewerpdfconfirm").attr('src', '');
            setMessage("El pdf que intenta cargar no tiene el formato correcto, está dañado o tiene contraseña. Debe usar otro archivo.", "danger");
        });
    };
    fileReader.readAsArrayBuffer(pdffile);
    _formsignup.yiiActiveForm("validateAttribute", "signupform-pdf_correcto");
});
$("#signupform-tipo_identificacion_id").parent().find('.select2').on("focusout", function (e) {
    setMessage("", "");
    $("#span_tipodocumentoidentificacion").html(abreviaturasidentificacion[$("#signupform-tipo_identificacion_id").val()]);
});
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
$("#signupform-tipo_identificacion_id").parent().find('.select2').prop('id', 'signupform-tipo_identificacion_select2');
$("#signupform-tipo_identificacion_id").parent().find('.select2').addClass("focus");
$(":input,#signupform-tipo_identificacion_select2").on('focusin', function (e) {
    $('[data-spanid]').each(function (index, element) {
        var span = $("#" + $(this).data("spanid"));
        if ($(this).hasClass("nombresaspirante")) {
            span.html($(this).val().toUpperCase());
        } else if ($(this).hasClass("correosaspirante")) {
            span.html($(this).val().toLowerCase());
        } else {
            span.html($(this).val());
        }
    });
    $(".helpli").removeClass("alert alert-info");
    $(".helpli").addClass("noshow");
    var help_li = "#help-for-" + $(this).attr("id");
    if ($(help_li).length > 0) {
        $(help_li).addClass("alert alert-info");
        $(help_li).removeClass("noshow");
    }
});

allWells.hide(); // hide all contents by default

navListItems.on('click', function (e) {
    e.preventDefault();
    var _target = $($(this).attr('href')),
            _item = $(this);

    if (!_item.hasClass('disabled')) {
        navListItems.removeClass('btn-primary').addClass('btn-default');
        _item.addClass('btn-primary');
        allWells.hide();
        _target.show();
        _focus = _target.find('.focus');
        if (_focus.is('select')) {
            $("#" + _focus.prop('id')).select2('open').select2('close').select2('open');
        } else {
            _focus.focus();
        }
    }
});
// next button
$('.nextBtn').click(function () {
    // Validation
    $.each(_formsignup.data("yiiActiveForm").attributes, function () {
        if (!($("#" + this.id).closest(".form-group").hasClass("has-error"))) {
            this.status = 3;
        }
    });
    _formsignup.yiiActiveForm("validate");
    var curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id"),
            curStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]'),
            nextStepWizardStep = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next(),
            nextStepWizard = nextStepWizardStep.children("a"),
            curInputs = curStep.find(":input"),
            isValid = true;
    curInputs.each(function (index, element) {
        if ($(this).closest(".form-group").hasClass("has-error")) {
            isValid = false;
            return false;
        }
    });
    // move to next step if valid
    if (isValid) {
        curStepWizard.addClass("btn-success");
        nextStepWizardStep.removeClass('disabled');
        nextStepWizard.removeClass('disabled').trigger('click');
    }
});
// prev button
$('.prevBtn').click(function () {
    var curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id"),
            prevStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a"),
            curInputs = curStep.find("input[type='text'],input[type='email'],input[type='password'],input[type='url']");
    prevStepWizard.trigger('click');
});
$('div.setup-panel div a.btn-primary').trigger('click');