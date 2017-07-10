<?php

use yii\helpers\Html;
$js = <<<EOD
    $("#logout").click(function() {
        $.ajax({
            url: "/site/logout",
            type: "post"
        });
    });
EOD;
$this->registerJs($js);

?>

<h3>¿Desea cerrar caja?</h3>

<p>
    Texto de ayuda
</p>

<p>
    <?= Html::a('Sí', ['empresa/cerrar-caja'], ['class' => 'btn btn-warning']) ?>
    <?= Html::button('No', ['class' => 'btn btn-danger', 'id' => 'logout']) ?>
    <?= Html::button('Cancelar', ['class' => 'btn btn-default', 'data-dismiss' => 'modal', 'aria-hidden' => 'true']) ?>
</p>