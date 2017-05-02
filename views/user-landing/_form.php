<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserLanding */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-landing-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->dropDownList($users, ['style' => 'width: 300px']) ?>

    <?= $form->field($model, 'landing_id')->dropDownList($landings, ['style' => 'width: 300px']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Применить' : 'Лишить доступа', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
