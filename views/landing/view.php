<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Landing */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Landings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="landing-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->landing_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->landing_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'landing_id',
            'title',
            'meters',
            'floor',
            'state',
            'planning',
            'price',
            'price_sign',
            'about_text:ntext',
            'characterstics_text:ntext',
            'news_text:ntext',
            'infostructure_text:ntext',
            'location_text:ntext',
            'contacts_text:ntext',
        ],
    ]) ?>

</div>
