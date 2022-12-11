<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use yii\web\Response;
use frontend\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\DeleteEmailForm;
use common\helpers\SeleccionHelper;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use common\models\search\ProcesoSearch;
use common\helpers\AltiriaSMS;
use common\models\Token;
use common\models\Aspirante;

/**
 * Site controller
 */
class SiteController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['login', 'logout', 'signup', 'sms', 'requestPasswordReset', 'resetPassword', 'verifyEmail', 'deleteEmail', 'resendVerificationEmail', 'captcha'],
                'rules' => [
                    [
                        'actions' => ['signup', 'login', 'sms', 'requestPasswordReset', 'resetPassword', 'verifyEmail', 'deleteEmail', 'resendVerificationEmail'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['captcha'],
                        'allow' => true,
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                    'foto' => ['post'],
                    'validatesignup' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * {@inheritdoc}
     */
    public function actions() {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                //'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    private function foto($ruta, $imagenbase64) {
        date_default_timezone_set('America/Bogota');
        if (strlen($imagenbase64) <= 0) {
            return ['resultado' => false, 'message' => "No se recibió ninguna imagen"];
        }
        //La imagen traerá al inicio data:image/png;base64, cosa que debemos remover
        $imagenCodificadaLimpia = str_replace("data:image/png;base64,", "", $imagenbase64);
        // Venía en base64 pero sólo la codificamos así para que viajara por la red, ahora la decodificamos y
        // todo el contenido lo guardamos en un archivo
        $imagenDecodificada = base64_decode($imagenCodificadaLimpia);
        //Calcular un nombre único
        // DIRECTORY_SEPARATOR . "foto_" . uniqid() . ".png";
        //Escribir el archivo
        file_put_contents(Yii::$app->basePath .
            DIRECTORY_SEPARATOR .
            'web' . $ruta, $imagenDecodificada);
        //Terminar y regresar el nombre de la foto
        return ['resultado' => true, 'message' => $ruta];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site/login');
        } else {
            return $this->redirect(['/aspirante']);
        }
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin() { // OK
        if (Yii::$app->session->has('nuevoaspiranteuuid')) {
            Yii::$app->session->remove('nuevoaspiranteuuid');
        }
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout() { // OK
        if (Yii::$app->session->has('nuevoaspiranteuuid')) {
            Yii::$app->session->remove('nuevoaspiranteuuid');
        }
        Yii::$app->user->logout();

        return $this->goHome();
    }

    private function verificaCaptcha($captcha) {
        $secretKey = "6LeUyMcUAAAAAHw3ZvJb5vwvSSCqJigX7Xzx_O5d"; // Put your secret key here
        // post request to server
        $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) . '&response=' . urlencode($captcha);
        $response = file_get_contents($url);
        return json_decode($response, true);
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact() { // OK
        $model = new ContactForm();
        $captcha = true;
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->user->isGuest && isset($_POST['g-recaptcha-response'])) {
                $captcha = Yii::$app->request->post()['g-recaptcha-response'];
            }
            if ($captcha) {
                $responseKeys = [];
                if (Yii::$app->user->isGuest) {
                    $responseKeys = $this->verificaCaptcha($captcha);
                } else {
                    $model->email = Yii::$app->user->identity->correo_electronico;
                    $model->phone = Yii::$app->user->identity->celular;
                    $model->name = Yii::$app->user->identity->nombres . ' ' . Yii::$app->user->identity->apellidos;
                    $responseKeys["success"] = true;
                }
                // should return JSON with success as true
                if (!(Yii::$app->user->isGuest) || $responseKeys["success"]) {
                    if ($model->validate()) {
                        if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                            Yii::$app->session->setFlash('success', 'Gracias por contactarnos. Le responderémos tan pronto sea posible.');
                            return $this->goHome();
                        } else {
                            Yii::$app->session->setFlash('error', 'Hubo un error al enviar su mensaje.');
                            return $this->refresh();
                        }
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'Fuera de aquí spammer.');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Debe chequear el captcha del formulario.');
            }
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionProcesos() {
        $searchModel = new ProcesoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['proceso.activo' => 1]);
        return $this->render('procesos', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionFaqs() {
        return $this->render('faqs', [
        ]);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionFaqssignup() {
        return $this->renderPartial('faqssignup', [
        ]);
    }

    public function actionValidatesignup(){
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && Yii::$app->session->has('nuevoaspiranteuuid')) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return \kartik\form\ActiveForm::validate($model);
        }
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup() { // OK
        if (!Yii::$app->user->isGuest) {
            \Yii::$app->session->setFlash('error', 'Ha intentado ingresar a una página que no esta permitida mientras está autenticado en el sistema.');
            return $this->goHome();
        }
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && Yii::$app->session->has('nuevoaspiranteuuid')) {
            $priv_key = "MIIJKQIBAAKCAgECj3EcT/h4Rc4ecgebCHrC3RB0NET29pRP/Gjf6fFZr/Xa6kMSBEuNjoDG/c0Iuu3e+WBDBotDluO5Ru0nfq7XwTQXXMHMgHfM+KMeWBNw48DW5EZTSre2+x3kB92sP0FNWsdeGyEQhqF2fadM+hWdkezRei199hpAW+R3q5w24q5wa57iWR2YXnsLzHa2ttpOjrvUvVz3K9Mp+NjiUlkwBs0fydhT/xyJueBA4UvxPLbezqulmYenlNW3l7o4UnFLyi3lonPkE/jE1Wn8cYcNwKMAroj2KTO5S9H3efspa+iK+oUvaIgpi1gz5zG3ODvqjJfUL35jBG3Kbymvy4adAS9ZbpoB188B34APBhYvhLm2evjwvuPJ4fQCvbmbgsglOwpAtDhjnFIlYdd6XVh9oQB3XZc/sGZrIpkL4CDb/kuKQw58Xa7MFuGmf2dUSeFaMxQwfyv+aa6kqzRYOmqEL6HFxaWyoitZgbl2TppwFOyuJSg3MCmYsm+LmqrDHjNLr2uVQVU4YHCVWQgX5ZJlzDPArW+zhR5Dd1asedg2yyy92XeNpe1PUpLhdehFPcyppvxweecGXzGH+9vkET7PDHx9WOd1+8EWkm7tI9x70BtjQDvkxh+w506SpADE+O2P0RiRHRCzAjkbqqx8Uq17KCucHz5OeHt3hHjzSkUHiS8CAwEAAQKCAgEA04h+ybR4JJc8LjMULu1nvG7WAhSL29LL6btzII57EpX3PAm/Y9F6cxZOopSsj5+7iaIun4sMmkMOhbx+NZ16FmmYbKBDPubrKQeEAIrtsSOIdw3XTdLy5CKmeH9rWtLZg0W6smi+a6Tql+0Jo+CcBP94L8VE1MtuH/ohQSpecFQ6BhG2HWq2xS9TBH7/ww27ssceBqtdPjCdaCmfCVKtdFR5QOxnV3s/W9TrO4sF5UFjsTGmdWFZjWhYI0i/aqQUAMFFTmO2pVdxNytIhN9Aaf5xduLPB0chMz4lb6HGoYPgbq/TOBpRxh4GSkQ6TJTRwuQxX86baE+CuNOsX7QnMLVFmsPXSp0+qsRaw+c0YUMj20R6gb2xS5ZVSo/vAStKm4yCGeN1Y+vdauXVfuZ+R5qTx1B8q1HFV8mZKiknMpTvzC6itMeSUYASJ3mok9MFEde6peVZnMxmeWyeYPeXKROffSGvbR7MwIwfXW/nl2j2OdnF0BkbUF12rStvDfLzITF4CXdOeDNB3WEefaVqcNsCA26zqM9atIURy8vZpOKz/VfTZUdoisXXBovtlHfiaip2/HAgFmLBPneMq3f8pF/6OHI2ruKBFJTg2G/0OgeW7aTwcD6OZ1vETsl2Izm5Z/HuiwH7v4VCuVzth66AxflQkZT1fKr6LBvx4u2XyaECggEBAaB6djSOo5jmiOfLzpgsNUzuxy1gXrfoU+15Q9/So97zsYcNyAajWYkiRTQ7ujWu+ZUP79f8gWtwxJwSWRU7xiISUSB9y3nZEAPb49EREr7Osx51kYpu3CavZHEtyv/pA+igJ8nVU3xtLePXVePkQkVlUXa7TFOMz4uREUHl9pwCORZmoP9DZSQbfio6DhSvQbvhK88WojKzwtPD17w0uIL4/BK4GlnVopE9nEjZgJ6nU5ZxnJOmqaokqgRsjvlwLfHH49TVBsaINr+2iNImcKULYPV9MiL03tsYRnNDFlwAwtcu4HfRlLaLtTDmJ/p+LwQcfrzD8y/YtNNaJDgXxtECggEBAZLisp1Rn5xgpHfUu785DlahHJIWYeM/cy9BJaTyPTSNYUqVTocvlXLbEH6wAFhA/ns7Dwvp7EXg0nXaOASmYhxkaJxewI9GsnPE+Rm3qzxve2Y5zRW/aHhdlgbWqQFHyDYYmKb6Tz/Z80M4ADCSoh/BJkmIEU9LNLA2MvcpUSd2Vw/ymBChEwyLeEjHI3ctF0MgufwHcF97X3N5Ful1cjc2HcAJa1jS/yVur+P/WQrTZm0u5GekCfn85cv0baae1OZltvVr6x/PmD0MZaeMmeNJcSjSoX6oO5kixzf5JOKSVvgE0rKgp/g0cwYfuikycMWG1GxlQjl9x57w/zqeT/8CggEABfebN/ePOoKbFY8i/6UqglatfeXylXn7sdxZ75wKAwjE02WMJyQyBTf7e9sbOOev5cXbruGMTSjJeF7+7cH0fcp7ZRbIUo+cniGJaxZuiVNW16nhkvUxrFA5BTIdxXrmNnANAeRPlOnPjYMpVOGRXYMtHqFiX5QV6S8D60jLNsMFZF/GEMI7cb//F8XLK9qy+2kngokVe9p9gSE+NxEeT6oXmoEOx5i7Ao+6bITJRfypwu8PykHKDokF8phHmCVWUy+FASioNzH+btLDtRcd6A94rSvFCyEtDECVydL9QAY2xHSEfNMA6Xio+PFjQ0CJlep+ml/IXTgipyCUgkU88QKCAQBDpxexPSydOMlFag6g3Lbgqys+CM4lN9livQDSQu8uLPOCb7IBF2d0Iv8RFwLnzvosvU0Yhg5r6YXNzngLp9jfxaifYXXaWVfMAu6FeAckHeBN2TTsCvlDBQwVV+SHV4NyOg0gNPYr1bB4wCWgAm+A/5ErVdL6SrmtQVyrjl+XTdLu1aDdYf7t41muduoosASw/ATfImynS/NKU7IaP+OPC+JRBgPlpYC8y2pz0cQlAjy35uDp2mzmcqYv6nqjORatHbVsXtPbwqNg1P0Y9o480W9UGJKPzzY6z9E+P/MGrOY3va+X2Ux7bGtIQvmiw1qWgL6Y+SP2vX1Q3k0tjboHAoIBAQD1byquKNoAzrzzAp8uIVC4vUvrKtQ8UBJQgYEi0WGLnfVT+b4/Xa98b2zEU0o96rJKX9/NqT6ApmiD1G0G56VKVC4/PTSphc+AnPbiV36Bqec/nPxZR3Nl5ZaqeWq2kXWV4LeERSY+XT5jgCPVmT7/9q+3Zl8zlu3ZSYPv9stmOE+Z6XLEYMa8f5xNYiDJldoQabCrxh3GIuojRBTCFwFcSOO0CxigbhphunHzBn8remaFWGZAQtvn8Ja52b6y4p4prwpAvS/8W3m/knAwFl/OHR+cY9lzo23T0y/qXTGfCXt8e8WiQ5i195QwWux0KvCcKN/uZPaPzed/aES7kde7";
            $model->nombres = strtoupper($model->nombres);
            $model->apellidos = strtoupper($model->apellidos);
            $model->correo_electronico = strtolower($model->correo_electronico);
            $model->documentoidentificacion = UploadedFile::getInstance($model, 'documentoidentificacion');
            if ($model->documentoidentificacion) {
                if (mime_content_type($model->documentoidentificacion->tempName) == 'application/pdf') { // Si el archivo es de tipo pdf
                    $handle = fopen($model->documentoidentificacion->tempName, "r");
                    $contents = fread($handle, filesize($model->documentoidentificacion->tempName));
                    fclose($handle);
                    if (!(stristr($contents, "/Encrypt"))) { // Si el archivo no está cifrado
                        $token = Token::findOne([
                            'celular' => $model->celular,
                            'correo_electronico' => $model->correo_electronico,
                            'identificacion' => $model->identificacion,
                            'token' => $model->token,
                            'validado' => 0,
                        ]);
                        if (!is_null($token)) {
                            if ($model->validate()) {
                                $aspirante = new Aspirante();
                                if ($model->signup($aspirante)) {
                                    $archivo = new \common\models\ArchivoAspirante();
                                    $archivo->aspirante_uuid = $aspirante->uuid;
                                    $archivo->md5 = md5_file($model->documentoidentificacion->tempName);
                                    $archivo->comentarios_aspirante = "No se puede cambiar.";
                                    $archivo->tipo_archivo_aspirante_id = 1;
                                    SeleccionHelper::creaArchivoAspirante(
                                        $model->documentoidentificacion->tempName,
                                        $aspirante->identificacion,
                                        $aspirante->identificacion . '_' . Yii::$app->security->generateRandomString(),
                                        $archivo);
                                    $this->foto($aspirante->urlfoto, $model->foto);
                                    //La imagen traerá al inicio data:image/png;base64, cosa que debemos remover
                                    $imagenCodificadaLimpia = str_replace("data:image/png;base64,", "", $model->foto);
                                    // Venía en base64 pero sólo la codificamos así para que viajara por la red, ahora la decodificamos y
                                    // todo el contenido lo guardamos en un archivo
                                    $imagenDecodificada = base64_decode($imagenCodificadaLimpia);
                                    //Calcular un nombre único
                                    // DIRECTORY_SEPARATOR . "foto_" . uniqid() . ".png";
                                    //Escribir el archivo
                                    $fototemporal = Yii::$app->basePath .
                                        DIRECTORY_SEPARATOR .
                                        'web' . Yii::$app->params['rutaarchivosaspirantes'] .
                                        DIRECTORY_SEPARATOR .
                                        substr($aspirante->identificacion, 0, 3) .
                                        DIRECTORY_SEPARATOR .
                                        $aspirante->identificacion .
                                        DIRECTORY_SEPARATOR . $aspirante->urlfoto . '.png';
                                    file_put_contents($fototemporal, $imagenDecodificada);
                                    SeleccionHelper::creaArchivoAspirante($fototemporal, $aspirante->identificacion, $aspirante->urlfoto,
                                        null, '.png');
                                    unlink($fototemporal);
                                    $token->ip_registro = Yii::$app->request->userIP;
                                    $token->validado = 1;
                                    $token->save();
                                    if (Yii::$app->session->has('nuevoaspiranteuuid')) {
                                        Yii::$app->session->remove('nuevoaspiranteuuid');
                                    }
                                    Yii::$app->session->setFlash('success', 'Su registro ha sido exitoso. Por favor busque en su buzón el correo de verificación.');
                                    return $this->goHome();
                                }
                            } else {
                                Yii::$app->session->setFlash('error', 'Ha ocurrido un error de validación de los datos: ' . print_r($model->errors, true));
                            }
                        } else {
                            Yii::$app->session->setFlash('error', 'No se ha podido encontrar el token ingresado.');
                        }
                    } else {
                        Yii::$app->session->setFlash('error', 'El pdf cargado tiene contraseña, no se permiten archivos con contraseña.');
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'El documento de identidad que cargó no tiene el formato .pdf esperado o está dañado.');
                }
            } else {
                Yii::$app->session->setFlash('error', 'No ha cargado el documento de identificación.');
            }
        }
        if (!(Yii::$app->session->has('nuevoaspiranteuuid'))) {
            Yii::$app->session->set('nuevoaspiranteuuid', SeleccionHelper::uuid());
        }
        $model->celular = "";
        $model->token = "";
        $model->password = "";
        $model->password_repeat = "";
        $model->pdf_correcto = 0;
        $model->captcha = '';
        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset() { // OK
        if (!Yii::$app->user->isGuest) {
            \Yii::$app->session->setFlash('error', 'Ha intentado ingresar a una página que no esta permitida mientras está autenticado en el sistema.');
            return $this->goHome();
        }
        $model = new PasswordResetRequestForm();
        $captcha;
        if (Yii::$app->session->has('nuevoaspiranteuuid')) {
            Yii::$app->session->remove('nuevoaspiranteuuid');
        }
        if ($model->load(Yii::$app->request->post())) {
            if (isset($_POST['g-recaptcha-response'])) {
                $captcha = Yii::$app->request->post()['g-recaptcha-response'];
            }
            if ($captcha) {
                $secretKey = "6LeUyMcUAAAAAHw3ZvJb5vwvSSCqJigX7Xzx_O5d"; // Put your secret key here
                // post request to server
                $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) . '&response=' . urlencode($captcha);
                $response = file_get_contents($url);
                $responseKeys = json_decode($response, true);
                // should return JSON with success as true
                if ($responseKeys["success"]) {
                    if ($model->validate()) {
                        if ($model->sendEmail()) {
                            Yii::$app->session->setFlash('success', 'Revise su buzón de correo para instrucciones adicionales.');

                            return $this->goHome();
                        } else {
                            Yii::$app->session->setFlash('error', 'Lo sentimos, no ha sido posible recuperar la contraseña para la dirección de correo provista.');
                        }
                    } else {
                        Yii::$app->session->setFlash('error', 'No se ha podido validar el formulario.');
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'Fuera de aquí spammer.');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Debe chequear el captcha del formulario.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token) { // OK
        if (!Yii::$app->user->isGuest) {
            \Yii::$app->session->setFlash('error', 'Ha intentado ingresar a una página que no esta permitida mientras está autenticado en el sistema.');
            return $this->goHome();
        }
        if (Yii::$app->session->has('nuevoaspiranteuuid')) {
            Yii::$app->session->remove('nuevoaspiranteuuid');
        }
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'La nueva contraseña ha sido guardada de manera exitosa.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @return yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionVerifyEmail($token) { // OK
        if (!Yii::$app->user->isGuest) {
            \Yii::$app->session->setFlash('error', 'Ha intentado ingresar a una página que no esta permitida mientras está autenticado en el sistema.');
            return $this->goHome();
        }
        if (Yii::$app->session->has('nuevoaspiranteuuid')) {
            Yii::$app->session->remove('nuevoaspiranteuuid');
        }
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($aspirante = $model->verifyEmail()) {
            if (!(Yii::$app->user->isGuest)) {
                Yii::$app->user->logout();
            }
            if (Yii::$app->user->login($aspirante)) {
                Yii::$app->session->setFlash('success', '¡Su correo electronico ha sido verificado!');
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', 'Lo sentimos, no se ha podido verificar su correo electrónico con el token provisto.');
        return $this->goHome();
    }

    /**
     * Delete email address
     *
     * @param string $token
     * @return yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionDeleteEmail($token) { // OK
        if (!Yii::$app->user->isGuest) {
            \Yii::$app->session->setFlash('error', 'Ha intentado ingresar a una página que no esta permitida mientras está autenticado en el sistema.');
            return $this->goHome();
        }
        if (Yii::$app->session->has('nuevoaspiranteuuid')) {
            Yii::$app->session->remove('nuevoaspiranteuuid');
        }
        try {
            $model = new DeleteEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($model->load(Yii::$app->request->post())) {
            $aspirante = Aspirante::findByDeleteToken($token);
            if (!is_null($aspirante)) {
                AspiranteController::deleteAspirante($aspirante->uuid);
                foreach ($aspirante->archivosAspirante as $archivoaspirante) {
                    ArchivoaspiranteController::deleteArchivo($archivoaspirante->uuid);
                }
            }
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Va a eliminar el registro de ' . $model->aspirante->correo_electronico . ', esta acción es irreversible.');
        $model->confirmacion = 0;
        return $this->render('deleteToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail() {
        if (!Yii::$app->user->isGuest) {
            \Yii::$app->session->setFlash('error', 'Ha intentado ingresar a una página que no esta permitida mientras está autenticado en el sistema.');
            return $this->goHome();
        }
        if (Yii::$app->session->has('nuevoaspiranteuuid')) {
            Yii::$app->session->remove('nuevoaspiranteuuid');
        }
        $model = new ResendVerificationEmailForm();
        $captcha;
        if ($model->load(Yii::$app->request->post())) {
            if (isset($_POST['g-recaptcha-response'])) {
                $captcha = Yii::$app->request->post()['g-recaptcha-response'];
            }
            if ($captcha) {
                $secretKey = "6LeUyMcUAAAAAHw3ZvJb5vwvSSCqJigX7Xzx_O5d"; // Put your secret key here
                // post request to server
                $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) . '&response=' . urlencode($captcha);
                $response = file_get_contents($url);
                $responseKeys = json_decode($response, true);
                // should return JSON with success as true
                if ($responseKeys["success"]) {
                    if ($model->validate()) {
                        if ($model->sendEmail()) {
                            Yii::$app->session->setFlash('success', 'Revise su buzón de correo electrónico para instrucciones adicionales.');
                            return $this->goHome();
                        } else {
                            Yii::$app->session->setFlash('error', 'Lo sentimos, no ha sido posible reenviar el correo de verificación para la dirección de correo provista.');
                        }
                    } else {
                        Yii::$app->session->setFlash('error', 'No se ha podido validar el formulario.');
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'Fuera de aquí spammer.');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Debe chequear el captcha del formulario.');
            }
        }
        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

    /**
     *
     * @return []
     */
    public function actionSms() {
        date_default_timezone_set('America/Bogota');
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $tokenpost = new Token();
        $session = \Yii::$app->session;
        $date = new \DateTime();
        $date->modify('-30 minute');
        if (
            !(Yii::$app->user->isGuest) ||
            !($session->has('nuevoaspiranteuuid')) ||
            !(Yii::$app->request->isAjax) ||
            !(Yii::$app->request->isPost)
        ) {
            return ['resultado' => false, 'message' => 'Ha intentado una acción no permitida. Su IP ' . \Yii::$app->request->userIP . ' ha sido registrada.'];
        }
        if ($tokenpost->load(Yii::$app->request->post())) {
            $tokenpost->validado = 0;
            $tokenpost->ip_creacion = Yii::$app->request->userIP;
            $tokenpost->token = random_int(100000, 999999);
            if (!$tokenpost->validate()) {
                return ['resultado' => false, 'message' => print_r($tokenpost->errors, true)];
            }
            /* Se buscan los tokens que se han registrado con la misma IP en la última media hora */
            $numerotokens = Token::find()
                ->where(['ip_creacion' => Yii::$app->request->userIP])
                ->andWhere(['>', 'created_at', $date->format('Y-m-d H:i:s')])
                ->count();
            if ($numerotokens >= 10) {
                return ['resultado' => false, 'message' => 'Se han realizado demasiadas solicitudes de Token desde la IP ' . \Yii::$app->request->userIP . '. Debe esperar o intentar desde otra IP. La IP ha sido registrada y se revisarán las causas.'];
            }
            $dominio = explode("@", $tokenpost->correo_electronico)[1];
            if (in_array($dominio, Yii::$app->params['dominiosbloqueados'])) {
                return ['resultado' => false, 'message' => 'El dominio del correo electrónico ingresado no está permitido, debe cambiar el correo electrónico.'];
            }
            // Si se han registrado menos de 10 token desde la misma IP en la última media hora se continúa
            // Se revisa si hay un aspirante validado con este correo electrónico
            $aspirante = Aspirante::findByEmail($tokenpost->correo_electronico);
            if (!is_null($aspirante)) {
                $identificacion = substr($aspirante->identificacion, 0, 2) . str_repeat('*', strlen($aspirante->identificacion) - 4) . substr($aspirante->identificacion, -2);
                $celular = substr($aspirante->celular, 0, 2) . str_repeat('*', strlen($aspirante->celular) - 4) . substr($aspirante->celular, -2);
                return ['resultado' => false, 'message' => 'La dirección de correo electrónico "' . $tokenpost->correo_electronico . '" ya aparece registrada para el aspirante con identificación "' . $identificacion . '" y celular "' . $celular . '". Se puede usar una dirección de correo solo una vez, debe cambiarla para poder continuar.'];
            }
            // Si no hay un aspirante validado con ese correo electrónico se continúa
            $aspirante = Aspirante::findOne(['correo_electronico' => $tokenpost->correo_electronico]);
            if (!is_null($aspirante)) {
                $identificacion = substr($aspirante->identificacion, 0, 2) . str_repeat('*', strlen($aspirante->identificacion) - 4) . substr($aspirante->identificacion, -2);
                $celular = substr($aspirante->celular, 0, 2) . str_repeat('*', strlen($aspirante->celular) - 4) . substr($aspirante->celular, -2);
                return ['resultado' => false, 'message' => 'La dirección de correo electrónico "' . $tokenpost->correo_electronico . '" ya aparece registrada para el aspirante con identificación "' . $identificacion . '" y celular "' . $celular . '", pero no se ha validado el buzón de correo. Se puede usar una dirección de correo solo una vez, debe cambiarla para poder continuar.'];
            }
            // Se revisa si hay un aspirante validado con esta identificación
            $aspirante = Aspirante::findByIdentificacion($tokenpost->identificacion);
            if (!is_null($aspirante)) {
                list($usuario, $dominio) = preg_split("/@/", $aspirante->correo_electronico);
                $usuario = substr($usuario, 0, 1) . str_repeat('*', strlen($usuario) - 2) . substr($usuario, -1);
                $celular = substr($aspirante->celular, 0, 2) . str_repeat('*', strlen($aspirante->celular) - 4) . substr($aspirante->celular, -2);
                return ['resultado' => false, 'message' => 'La identificación "' . $tokenpost->identificacion . '" ya aparece registrada para el aspirante con correo electrónico "' . $usuario . '@' . $dominio . '" y celular "' . $celular . '". Solo se permite un registro por número de identificación.'];
            }
            // Si no hay un aspirante validado con esta identificación
            $aspirante = Aspirante::findOne(['identificacion' => $tokenpost->identificacion]);
            if (!is_null($aspirante)) {
                list($usuario, $dominio) = preg_split("/@/", $aspirante->correo_electronico);
                $usuario = substr($usuario, 0, 1) . str_repeat('*', strlen($usuario) - 2) . substr($usuario, -1);
                $celular = substr($aspirante->celular, 0, 2) . str_repeat('*', strlen($aspirante->celular) - 4) . substr($aspirante->celular, -2);
                return ['resultado' => false, 'message' => 'La identificación "' . $tokenpost->identificacion . '" ya aparece registrada para el aspirante con correo electrónico "' . $usuario . '@' . $dominio . '" y celular "' . $celular . '", pero no se ha validado el buzón de correo. Solo se permite un registro por número de identificación.'];
            }
            // Se revisa cuántos aspirantes se han registrado con el número de celular
            $numeroaspirantes = Aspirante::find()->where(['celular' => $tokenpost->celular, 'status' => Aspirante::STATUS_ACTIVE])->count();
            if ($numeroaspirantes >= 2) {
                return ['resultado' => false, 'message' => 'El celular "' . $tokenpost->celular . '" ya se ha utilizado para registrar ' . $numeroaspirantes . ' aspirantes. Debe usar otro celular para recibir el Token'];
            }
            // Si hay menos de dos aspirantes registrados con el mismo celular se continua
            $sDestination = '57' . $tokenpost->celular;
            $token = Token::findOne([
                'celular' => $tokenpost->celular,
                'correo_electronico' => $tokenpost->correo_electronico,
                'identificacion' => $tokenpost->identificacion,
                'validado' => 0,
            ]);
            if (is_null($token)) {
                $token = new Token();
                $token->ip_creacion = Yii::$app->request->userIP;
                $token->celular = $tokenpost->celular;
                $token->correo_electronico = $tokenpost->correo_electronico;
                $token->identificacion = $tokenpost->identificacion;
                $token->validado = 0;
                $token->token = random_int(100000, 999999);
                $token->save();
            }
            $mensaje = 'IP ' . Yii::$app->request->userIP . " el token para su registro es: " . $token->token . '. Mensaje enviado en ' . date("Y-m-d H:i:s");
            $response = $this->sendSMS($sDestination, $mensaje);
            if (!$response) {
                return ['resultado' => false, 'message' => 'Ha ocurrido un error al enviar el mensaje SMS.'];
            } else {
                return ['resultado' => true, 'message' => 'Se ha enviado un token al celular ' . $tokenpost->celular . ' debe ingresarlo en el campo Token para continuar.'];
            }
        } else {
            return ['resultado' => false, 'message' => 'No se ha enviado la información en el formato adecuado.'];
        }
    }

    /**
     *
     * @param string $sDestination Celular de destino
     * @param string $message Mensaje a enviar
     * @return boolean
     */
    private function sendSMS($sDestination, $message) {
        $altiriaSMS = new AltiriaSMS();
        $altiriaSMS->setUrl("http://www.altiria.net/api/http");
        $altiriaSMS->setDomainId('dirigiendoproyectos');
        $altiriaSMS->setLogin('jabernal@dirigiendoproyectos.com');
        $altiriaSMS->setPassword('Na$$imT4leB');
        $altiriaSMS->setDebug(true);
        $response = $altiriaSMS->sendSMS($sDestination, $message);

        if (!$response) {
            return false;
        } else {
            return true;
        }
    }

}
