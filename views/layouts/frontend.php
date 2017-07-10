<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\assets\AppAsset;
use app\assets\FontAwesomeAsset;



/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
//JuiExtendedAsset::register($this);
FontAwesomeAsset::register($this);
$this->registerCssFile(Yii::$app->request->baseUrl.'/css/frontend.css', ['depends'=> 'yii\bootstrap\BootstrapAsset']);
$this->registerJsFile(Yii::$app->request->baseUrl.'/plugins/cookiechoices/cookiechoices.js');
$urlCookies = \yii\helpers\Url::to(['site/cookies']);
$js = <<<EOD
    cookieChoices.showCookieConsentBar(
        'Este sitio usa cookies para mejorar la experiencia de navegación',
        'Aceptar', '¿Que es esto?', '$urlCookies');
EOD;
$this->registerJs($js);

?>

<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Description, Keywords and Author -->
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Inttegrum S.L.">

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?=Yii::$app->request->baseUrl?>/favicon.ico" type="image/x-icon" />

    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?=Yii::$app->request->baseUrl?>/144.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?=Yii::$app->request->baseUrl?>/114.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?=Yii::$app->request->baseUrl?>/72.png">
    <link rel="apple-touch-icon-precomposed" href="<?=Yii::$app->request->baseUrl?>/57.png">

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
    <div class="container">

        <div class="row">
            <div class="col-md-12 img-menu">
                <img class="img-responsive" src="<?= Yii::$app->request->baseUrl.'/img/logo/logo.png' ?>" alt="Logotipo web"/>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <?php
                    NavBar::begin([
                        'brandLabel' => false,
                        //'brandUrl' => Yii::$app->homeUrl,
                        'options' => [
                            'class' => 'navbar navbar-default',/*navbar-default*/
                        ],
                        'innerContainerOptions' => [
                            'class' => 'container-fluid',
                            'style'=>'margin-left:0px; padding-left:0px;'
                        ],
                        'renderInnerContainer' => true,//Esto hace que se vea o no lo que definimos en innercontainer
                    ]);
                    echo Nav::widget([
                        'options' => ['class' => 'navbar navbar-nav navbar-left'],
                        'items' => [
                            ['label' =>  'Inicio' , 'url' => ['/'], /*'linkOptions'=>['class'=>'btn-menu']*/],
                            [
                                'label' => 'Acceder',
                                'url' => ['/site/login'],
                                'visible' => Yii::$app->user->isGuest,
                            ],





                            //Privado
                            //['label' => \Yii::t('app', 'Gestión'), 'url' => ['/backend/index'], 'visible'=>Yii::$app->permiso->nivelMinimo(9), 'linkOptions'=>['class'=>'btn-menu']]
                        ],
                    ]);
                    /*echo Nav::widget([
                        'options' => ['class' => 'navbar-nav navbar-right'],
                        'items' => [
                            ['label' => 'Contacto', 'url' => ['/contacto'], 'linkOptions'=>['class'=>'btn-menu']]
                        ]
                    ]);*/
                    NavBar::end();
                ?>
            </div>
        </div>


        <div class="container-fluid cuerpoweb">
            <?= $content ?>
        </div>



        <nav class="navbar navbar footerExtra">
            <div class="container-fluid">
                <div class="col-sm-12 text-right hidden-xs">
                    <a class="footertext" href="http://www.inttegrum.com">Desarrollado por Inttegrum,SL</a>
                </div>
            </div><!-- /.container-fluid -->
            <br/><br/>
        </nav>
    </div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
