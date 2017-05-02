<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Landing */

$this->title = 'Обновить сайт: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Landings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->landing_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="landing-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
