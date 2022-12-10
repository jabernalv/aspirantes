<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use common\widgets\Alert;
use kartik\icons\FontAwesomeAsset;
use kartik\dialog\Dialog;

//use \derekisbusy\popper\PopperAsset;

FontAwesomeAsset::register($this);
//PopperAsset::register($this);
$asset = Yii::$app->params['tema']::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <noscript>
        <META HTTP-EQUIV="Refresh" CONTENT="0;URL=/noscript.html">
        </noscript>
        <link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <script src='https://www.google.com/recaptcha/api.js' async defer></script>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <div class="wrap">
            <?php
            NavBar::begin([
                'brandLabel' => Yii::$app->name,
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'id' => "mainNav",
                    'class' => 'navbar fixed-top navbar-expand-lg navbar-dark bg-dark',
                ],
            ]);
            $menuItems = [
                ['label' => 'Inicio', 'url' => ['/site/index']],
                ['label' => 'Procesos', 'url' => ['/site/procesos']],
                ['label' => 'Contactenos', 'url' => ['/site/contact']],
                ['label' => 'Preguntas frecuentes', 'url' => ['/site/faqs']],
            ];
            if (Yii::$app->user->isGuest) {
                $menuItems[] = ['label' => 'Regístrese', 'url' => ['/site/signup']];
                //$menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
            } else {
                $menuItems[] = '<li>'
                        . Html::beginForm(['/site/logout'], 'post')
                        . Html::submitButton(
                                'Salir del sistema',
                                ['class' => 'btn btn-link logout']
                        )
                        . Html::endForm()
                        . '</li>';
            }
            $menuItems[] = ['label' => 'A-', 'url' => '#', 'options' => ['id' => 'jfontsize-dec']];
            $menuItems[] = ['label' => 'A', 'url' => '#', 'options' => ['id' => 'jfontsize-orig']];
            $menuItems[] = ['label' => 'A+', 'url' => '#', 'options' => ['id' => 'jfontsize-inc']];
            echo Nav::widget([
                //'options' => ['class' => 'navbar-nav navbar-right'],
                'options' => ['class' => 'navbar-nav ml-auto'],
                'items' => $menuItems,
            ]);
            NavBar::end();
            ?>
            <div class="container-fluid">
                <div id="mycontainer" class="container">

                    <?=
                    Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ])
                    ?>
                    <?= Alert::widget() ?>
                    <?= $content ?>
                    <div id="faqslink">Para aprender a usar el sistema dé clic en <a href="<?= Url::to(['/site/faqs']) ?>">Preguntas frecuentes</a></div>
                    <br><hr>
                </div>
            </div>
        </div>
        <footer class="footer py-5 bg-dark">
            <div class="container">
                <p class="pull-left text-white">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
            </div>
        </footer>
        <?php
        echo Dialog::widget(['options' => [// customized BootstrapDialog options
                'size' => Dialog::SIZE_WIDE,
                'nl2br' => false,
            ]
        ]);
        ?>
        <?php
//if (!(Yii::$app->user->isGuest)) :
        yii\bootstrap4\Modal::begin([
            'headerOptions' => ['id' => 'modalHeader'],
            'id' => 'modaldialog',
            'size' => 'modal-xl',
            //keeps from closing modal with esc key or by clicking out of the modal.
            // user must click cancel or X to close
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
        ]);
        ?>
        <div id="modalContent" style="width:100% !important;">
            <div class="d-flex align-items-center">
                <strong>Cargando ...</strong>&nbsp;<div class="spinner-grow text-primary ml-auto" role="status" aria-hidden="true"></div>
            </div>
        </div>
        <?php
        yii\bootstrap4\Modal::end();
//endif;
        $this->registerJsFile('/js/jstorage.js?', ['depends' => [yii\web\JqueryAsset::class]]);
        $this->registerJsFile('/js/jquery.jfontsize-2.0.js?', ['depends' => [yii\web\JqueryAsset::class]]);
        $js = "$('body').jfontsize({btnMinusClasseId:'#jfontsize-dec',btnDefaultClasseId:'#jfontsize-orig',btnPlusClasseId:'#jfontsize-inc',btnMinusMaxHits:2,btnPlusMaxHits:3,sizeChange:2});";
        $this->registerJs($js);
        ?>
        <?php $this->endBody() ?>
    </body>
</html>
<?php
$this->endPage();
