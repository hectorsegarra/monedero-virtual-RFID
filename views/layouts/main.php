<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\assets\AppAsset;
use app\assets\FontAwesomeAsset;
use app\models\User;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
FontAwesomeAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<?php $this->beginBody() ?>
    <div class="wrap">

        <?php
            NavBar::begin([
                //'brandLabel' => 'Gestión',
                //'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);

            echo "<div style='color:white; position:absolute; right:6px; top:0px;'>".Yii::$app->usuarioMeta->empresa['nombre']."</div>";

            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-left'],
                'encodeLabels' => false, // declaration goes here (before the items)
                'items' => [
                    ['label' => \Yii::t('app', '<i class="fa fa-home" aria-hidden="true"></i>'), 'url' => ['/site/index'], 'visible' => Yii::$app->permiso->todosMenosUsuarios()],
                    ['label' => \Yii::t('app', 'Usuarios'), 'url' => ['user/index'], 'visible' => Yii::$app->permiso->todosMenosUsuarios()],
                    ['label' => 'Otros',
                        'visible' => Yii::$app->permiso->todosMenosUsuarios(),
                        'items' => [
                            //DEVOLUCIONES
                            ['label' => \Yii::t('app', '<i class="fa fa-inbox" aria-hidden="true"></i> <strong>Ver devoluciones</strong>'), 'url' => ['monedero-historico/index-devolucion'], 'visible' => Yii::$app->permiso->todosMenosUsuarios()],
                            //ANULACIONES
                            ['label' => \Yii::t('app', '<i class="fa fa-inbox" aria-hidden="true"></i> <strong>Ver anulaciones</strong>'), 'url' => ['monedero-historico/index-anulacion'], 'visible' => Yii::$app->permiso->todosMenosUsuarios()],
                            //MOVIMIENTOS
                            ['label' => \Yii::t('app', '<i class="fa fa-inbox" aria-hidden="true"></i> <strong>Ver movimientos</strong>'), 'url' => ['monedero-historico/index'], 'visible' => Yii::$app->permiso->todosMenosUsuarios()],
                            //Estadisticas
                            ['label' => \Yii::t('app', '<i class="fa fa-bar-chart" aria-hidden="true"></i> <strong>Estadistícas</strong>'), 'url' => ['backend/estadisticas'], 'visible' => Yii::$app->permiso->todosMenosUsuarios()],
                            //informes
                            ['label' => \Yii::t('app', '<i class="fa fa-file-text-o" aria-hidden="true"></i> <strong>Informes</strong>'), 'url' => ['site/informes'], 'visible' => Yii::$app->permiso->todosMenosUsuarios()],
                            /*TERMINALES (ESTO SOLO PARA el usuario admin)*/
                            ['label' => \Yii::t('app', '<i class="fa fa-calculator" aria-hidden="true"></i> <strong>Terminales</strong>'), 'url' => ['terminal/index'], 'visible' => Yii::$app->user->id == 1],
                            //AYUDA
                            ['label' => \Yii::t('app', '<i class="fa fa-info-circle" aria-hidden="true"></i> <strong>Ayuda y créditos</strong>'), 'url' => ['site/ayuda'], 'visible' => Yii::$app->permiso->todosMenosUsuarios()],
                        ]
                    ],
                ],
            ]);

            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'encodeLabels' => false, // declaration goes here (before the items)
                'items' => [

                    ['label' => \Yii::t('app', 'Cerrar sesión') . ' (' . User::getIdentityEmail() . ')',
                        'url' => ['/site/logout'],
                        'visible' => !Yii::$app->user->isGuest,
                        'linkOptions' => ['data-method' => 'post']
                    ],
                ],
            ]);
            NavBar::end();
        ?>


        <div class="container">
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; Hector Segarra Castillo. <?= date('Y') ?></p>
        </div>
    </footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
