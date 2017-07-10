<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use app\components\Permiso;
use dosamigos\datepicker\DatePicker;
use app\components\InttegrumStaticData as Data;
use dosamigos\switchinput\SwitchBox;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */

$js = <<<EOD
    $('#modal-rfid').on('shown.bs.modal', function () {
        $('#rfid_hidden').focus();
    });
EOD;
$this->registerJs($js);

$jsDisableEnter = <<<EOD
    $("#rfid_hidden").keydown(function(event){
        if(event.keyCode == 13) {
            event.preventDefault();
            var valor = $(this).val();
            $(this).val('');
            $("#user-tag_rfid").val(valor);
            $('#modal-rfid').modal('hide');
            return false;
        }
    });
    $('#boton-rfid').on('click', function () {
        $('#modal-rfid').modal('show');
    });

    $('#borrar-rfid').click(function() {
        $('#user-tag_rfid').val('');
    });

    $('#generar-password').click(function(){
        var pass = Math.random().toString(36).slice(-8);
        $('#user-formpassword').val(pass);
        $('#user-formpasswordrepeat').val(pass);
        $('#user-sendpassword').val(pass);
    });

    /*$('#generar-email').click(function(){
        var mail = Math.random().toString(36).slice(-8);
        $('#user-email').val(mail+'@'+mail+'.com');
    });*/

    $('#user-formpassword').keyup(function(){
        $('#user-sendpassword').val($('#user-formpassword').val());
    });
EOD;
$this->registerJs($jsDisableEnter);
?>

<style>
    .title-datos-cliente {
        background-color: #6491C4;
        font-weight:bold;
        font-size:1.5em;
        color:white;
    }
    .row-datos-cliente {
        border-left:3px solid #6491C4;
    }

    .title-datos-sistema {
        background-color: #6AC45A;
        font-weight:bold;
        font-size:1.5em;
        color:white;
    }
    .row-datos-sistema {
        border-left:3px solid #6AC45A;
    }

    .title-datos-deportes-raqueta {
        background-color: #D66262;
        font-weight:bold;
        font-size:1.5em;
        color:white;
    }
    .row-datos-deportes-raqueta {
        border-left:3px solid #D66262;
    }

    .title-dias {
        background-color: #61ADA1;
        font-weight:bold;
        font-size:1.5em;
        color:white;
    }
    .row-dias {
        border-left:3px solid #61ADA1;
    }
</style>


<?php if (\Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?= \Yii::$app->session->getFlash('error') ?>
    </div>
<?php endif; ?>


<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row row-datos-cliente">
        <div class="col-lg-12 title-datos-cliente">
            DATOS DEL CLIENTE
        </div>
    </div>

    <div class="row row-datos-cliente">
        <div class="col-lg-4">
            <?= $form->field($model, 'nivel_permisos')->dropDownList(Permiso::getNivelesPorNivel(), [
                'prompt' => 'Selecciona una opción'
            ])->label('Tipo de usuario<span style="color:red;"> *</span>') ?>
        </div>

        <div class="col-lg-8">
            <?= Html::activeLabel($model, 'email') ?>
            <?php /*echo Html::button('Generar email', ['class' => 'btn btn-success btn-xs', 'id' => 'generar-email']) */?>
            <?= $form->field($model, 'email')->textInput(['maxlength' => 200])->label(false) ?>
        </div>
    </div>



	<div class="row row-datos-cliente">
        <div class="col-lg-6">
            <?= $form->field($model, 'nombre')->textInput(['maxlength' => 50])->label('Nombre<span style="color:red;"> *</span>') ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'apellidos')->textInput(['maxlength' => 100])->label('Apellidos<span style="color:red;"> *</span>') ?>
        </div>
    </div>

	<div class="row row-datos-cliente">
        <div class="col-lg-4">
            <?= $form->field($model, 'dni')->textInput(['maxlength' => 50]) ?>
        </div>


    </div>


    <div class="row row-datos-cliente">
        <div class="col-lg-8">
            <?= $form->field($model, 'direccion')->textInput(['maxlength' => 250]) ?>
        </div>

    </div>

    <div class="row row-datos-cliente">

        <div class="col-lg-6">
            <label class="control-label" for="user-tag_rfid">Tarjeta de identificación</label>
            <div class="input-group">
                <span class="input-group-btn">
                    <button id="boton-rfid" class="btn btn-default" type="button">Leer tarjeta</button>
                </span>
                <input id="user-tag_rfid" name="User[tag_rfid]" type="text" class="form-control" readonly="readOnly">
                <span class="input-group-btn">
                    <button id="borrar-rfid" class="btn btn-danger" type="button">Borrar tarjeta</button>
                </span>


                <?php
                Modal::begin([
                    'header' => '<h2>Esperando tarjeta </h2>',
                    'id' => 'modal-rfid',
                    //'toggleButton' => ['label' => 'Pasar tarjeta', 'class' => 'btn btn-success', 'id' => 'boton-rfid'],
                    'toggleButton' => false,
                    'size' => Modal::SIZE_SMALL,
                    'clientEvents' => [
                        //'shown.bs.modal' => 'alert("aaaaa")'
                    ]
                ]);

                echo Html::textInput('rfid_hidden', '', ['id' => 'rfid_hidden', 'class' => 'form-control']);
                echo '<div style="clear:both"></div>';

                Modal::end();
                ?>
            </div>
        </div>

    </div>

    <br/>

    <div class="row row-datos-sistema">
        <div class="col-lg-12 title-datos-sistema">
            DATOS DEL SISTEMA <span style="font-size:0.8em; font-weight:normal;">(Creamos una contraseña solo si existe posibilidad de reservas en línea.)</span>
        </div>
    </div>



	<div class="row row-datos-sistema">
    <br/>
        <div class="col-lg-4">
            <?= Html::activeLabel($model, 'formPassword') ?>
            <?= Html::button('Generar contraseña', ['class' => 'btn btn-success btn-xs', 'id' => 'generar-password']) ?>
            <?= $form->field($model, 'formPassword')->passwordInput(['maxlength' => 256])->label(false) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'formPasswordRepeat')->passwordInput(['maxlength' => 256]) ?>
        </div>



        <?= Html::activeHiddenInput($model, 'sendPassword') ?>

    </div>

    <br/>

    <div class="row">
        <div class="col-md-4">
            <?= Html::submitButton($model->isNewRecord ? \Yii::t('app', 'Crear') : \Yii::t('app', 'Guardar cambios'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>



    <?php ActiveForm::end(); ?>

</div>
