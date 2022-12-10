/*
 Tomar una fotografia y guardarla en un archivo v3
 @date 2018-10-22
 @author parzibyte
 @web parzibyte.me/blog
 */
const tieneSoporteUserMedia = () =>
    !!(navigator.getUserMedia || (navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia) || navigator.webkitGetUserMedia || navigator.msGetUserMedia)
const _getUserMedia = (...arguments) =>
    (navigator.getUserMedia || (navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia) || navigator.webkitGetUserMedia || navigator.msGetUserMedia).apply(navigator, arguments);

// Declaramos elementos del DOM
const _video = $("#video")[0],
        _message = $("#message-signup"),
        _foto_button = $("#foto-button"),
        _foto = $("#signupform-foto"),
        _listaDeDispositivos = $("#listaDeDispositivos");

const obtenerDispositivos = () => navigator
            .mediaDevices
            .enumerateDevices();
var camarahabilitada = true, messagecamara = "", foto64;

// La funcion que es llamada despues de que ya se dieron los permisos
// Lo que hace es llenar el select con los dispositivos obtenidos
const llenarSelectConDispositivosDisponibles = () => {

    _listaDeDispositivos.empty();
    obtenerDispositivos()
            .then(dispositivos => {
                const dispositivosDeVideo = [];
                dispositivos.forEach(dispositivo => {
                    const tipo = dispositivo.kind;
                    if (tipo === "videoinput") {
                        dispositivosDeVideo.push(dispositivo);
                    }
                });

                // Vemos si encontramos algun dispositivo, y en caso de que si, entonces llamamos a la funcion
                if (dispositivosDeVideo.length > 0) {
                    // Llenar el select
                    dispositivosDeVideo.forEach(dispositivo => {
                        const option = document.createElement('option');
                        option.value = dispositivo.deviceId;
                        option.text = dispositivo.label;
                        _listaDeDispositivos.append(option);
                    });
                }
            });
}

(function () {
    // Comenzamos viendo si tiene soporte, si no, nos detenemos
    if (!tieneSoporteUserMedia()) {
        messagecamara = "<div class='alert-danger alert alert-dismissible' role='alert'>Parece que el navegador no soporta el video en línea. Debe cambiarlo o actualizarlo.</div>";
        _message.html(messagecamara);
        camarahabilitada = false;
        return;
    }
    //Aqui guardaremos el stream globalmente
    let stream;


    // Obtenemos los dispositivos
    obtenerDispositivos()
            .then(dispositivos => {
                // Vamos a filtrarlos y guardar aqui los de video
                const dispositivosDeVideo = [];

                // Recorrer y filtrar
                dispositivos.forEach(function (dispositivo) {
                    const tipo = dispositivo.kind;
                    if (tipo === "videoinput") {
                        dispositivosDeVideo.push(dispositivo);
                    }
                });

                // Vemos si encontramos algun dispositivo, y en caso de que si, entonces llamamos a la funcion
                // y le pasamos el id de dispositivo
                if (dispositivosDeVideo.length > 0) {
                    // Mostrar stream con el ID del primer dispositivo, luego el usuario puede cambiar
                    mostrarStream(dispositivosDeVideo[0].deviceId);
                }
            });
    const mostrarStream = idDeDispositivo => {
        _getUserMedia({
            video: {
                // Justo aqui indicamos cual dispositivo usar
                deviceId: idDeDispositivo,
            }
        }, (streamObtenido) => {
            // Aqui ya tenemos permisos, ahora si llenamos el select,
            // pues si no, no nos daria el nombre de los dispositivos
            llenarSelectConDispositivosDisponibles();

            // Escuchar cuando seleccionen otra opcion y entonces llamar a esta funcion
            _listaDeDispositivos.on('change', function () {
                // Detener el stream
                if (stream) {
                    stream.getTracks().forEach(function (track) {
                        track.stop();
                    });
                }
                // Mostrar el nuevo stream con el dispositivo seleccionado
                mostrarStream(_listaDeDispositivos.val());
            });

            // Simple asignacion
            stream = streamObtenido;

            // Mandamos el stream de la camara al elemento de video
            _video.srcObject = stream;
            _video.play();


        }, (error) => {
            messagecamara = "<div class='alert-danger alert alert-dismissible' role='alert'>No se puede acceder a la camara, o no se ha dado permiso. Es necesario dar permiso de uso a la cámara para poder tomar la fotografía. El error reportado es: <i>" + error.message + "</i></div>";
            camarahabilitada = false;
            $("#form-signup :input").prop("disabled", true)
            _message.html(messagecamara);
        });
    }
    //Escuchar el click del boton para tomar la foto
    _foto_button.on("click", function () {
        let _canvas = $("#canvas")[0];
        let _canvasfotoacargar = $("#canvasfotoacargar")[0];
        let _img_confirm = $("#img-confirm");
        //Pausar reproduccion
        _video.pause();

        //Obtener contexto del canvas y dibujar sobre el
        let contexto2 = _canvasfotoacargar.getContext("2d");
        _canvasfotoacargar.width = 600; //_video.videoWidth;
        _canvasfotoacargar.height = 600 * _video.videoHeight / _video.videoWidth;
        contexto2.drawImage(_video, 0, 0, _canvasfotoacargar.width, _canvasfotoacargar.height);
        foto64 = _canvasfotoacargar.toDataURL('image/png');
        _foto.val(foto64); //Esta es la foto, en base 64
        _img_confirm.attr("src", _canvasfotoacargar.toDataURL('image/png'));

        let contexto = _canvas.getContext("2d");
        _canvas.width = 400; //_video.videoWidth;
        _canvas.height = 400 * _video.videoHeight / _video.videoWidth;
        contexto.drawImage(_video, 0, 0, _canvas.width, _canvas.height);

        //Reanudar reproduccion
        _video.play();
        $("#form-signup").yiiActiveForm("validateAttribute", "signupform-foto");
    });
})();