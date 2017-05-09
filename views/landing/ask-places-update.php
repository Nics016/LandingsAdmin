<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\models\AskPlaces;

/* @var $model app\models\AskPlaces */
/* @var $numPlaces integer */

$this->title = 'Задать количество площадок';
?>

<?php $form = ActiveForm::begin(); ?>
	<?= $form->field($model, 'numPlaces')->textInput(['size' => 2, 'value' => $numPlaces]) ?>

	 <div class="form-group">
        <?= Html::submitButton('Продолжить', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>