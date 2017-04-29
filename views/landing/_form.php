<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\models\Landing;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model app\models\Landing */
/* @var $form yii\widgets\ActiveForm */

// Generating different labels on Update action to show images
    $object_photo_label = $model->getAttributeLabel('object_photo');
    $object_photos_label = $model->getAttributeLabel('photos_files');
    $object_arendator_photos_label = $model->getAttributeLabel('arendator_photos_files');
    // on Update we attach existing image
    if (!$model->isNewRecord){
        $object_photo_label .= '<br><img src="' 
        .  $model->object_photo
        . '">';

        $photos = json_decode($model->photos);
        if ($photos){
            $answ = '<br>';
            foreach ($photos as $photo){
                $answ .= Html::img($photo, ['style' => 'max-width: 600px']).'<br>'.'<br>';
            }
            $object_photos_label .= $answ;
        }

        $photos = json_decode($model->arendator_photos);
        if ($photos){
            $answ = '<br>';
            foreach ($photos as $photo){
                $answ .= Html::img($photo, ['style' => 'max-width: 600px']).'<br>'.'<br>';
            }
            $object_arendator_photos_label .= $answ;
        }
    }
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
        <?= $form->field($model, 'object_photo_file')->fileInput()->label($object_photo_label) ?>
    </table>
    
    <?= $form->field($model, 'about_text')->widget(CKEditor::className(), [
        'preset' => 'full'
    ]) ?> 

    <?= $form->field($model, 'characteristics_text')->widget(CKEditor::className(), [
        'preset' => 'full'
    ]) ?>
    
    <?= $form->field($model, 'photos_files[]')->fileInput(['multiple' => true])->label($object_photos_label) ?>

    <?= $form->field($model, 'news_text')->widget(CKEditor::className(), [
        'preset' => 'full'
    ]) ?>

    <?= $form->field($model, 'infostructure_text')->widget(CKEditor::className(), [
        'preset' => 'full'
    ]) ?>

    <?= $form->field($model, 'arendator_photos_files[]')->fileInput(['multiple' => true])->label($object_arendator_photos_label) ?>

    <?= $form->field($model, 'location_text')->widget(CKEditor::className(), [
        'preset' => 'full'
    ]) ?>

    <?= $form->field($model, 'contacts_text')->widget(CKEditor::className(), [
        'preset' => 'full'
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
