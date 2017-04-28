<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\models\Landing;

/* @var $this yii\web\View */
/* @var $model app\models\Landing */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="landing-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <table class="table">
        <thead class="thead-inverse">
            <tr>
                <th>Метраж</th>
                <th>Этаж</th>
                <th>Состояние</th>
                <th>Планировка</th>
                <th>Ставка</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="width: 100px"><?= $form->field($model, 'meters')->textInput(['size' => 2])->label(false) ?></td>
                <td style="width: 100px"><?= $form->field($model, 'floor')->textInput(['maxlength' => true, 'size' => 1])->label(false) ?></td>
                <td style="width: 200px">
                    <?= $form->field($model, 'state')->dropDownList([
                        Landing::STATE_READY => 'готово к въезду',
                        Landing::STATE_OTDELKA => 'под отделку',
                        Landing::STATE_CLEAR_OTDELKA => 'под чистовую отделку',
                        Landing::STATE_SELLING => 'продажа',
                    ])->label(false) ?>
                </td>
                <td style="width: 150px">
                    <?= $form->field($model, 'planning')->dropDownList([
                        Landing::PLANNING_OPEN => 'открытая',
                        Landing::PLANNING_MIXED => 'смешанная',
                        Landing::PLANNING_CABINET => 'кабинетная',
                    ])->label(false) ?>
                </td>
                <td style="width: 180px">
                    <?= $form->field($model, 'price')->textInput()->label(false) ?>
                    <?= $form->field($model, 'price_sign')->dropDownList([
                        Landing::PRICE_SIGN_RUB => 'Руб',
                        Landing::PRICE_SIGN_DOL => '$',
                        Landing::PRICE_SIGN_EUR => '€',
                    ], ['style' => 'width: 100px !important'])->label(false) ?>
                </td>
            </tr>
        </tbody>
    </table>

    <?= $form->field($model, 'about_text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'characterstics_text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'news_text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'infostructure_text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'location_text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'contacts_text')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
