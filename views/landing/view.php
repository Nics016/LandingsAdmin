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
        <?= Html::a('Обновить', ['update', 'id' => $model->landing_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->landing_id], [
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
            [
                'attribute' => 'state',
                'value' => function($model){
                    switch($model['state']){
                        case $model::STATE_READY:
                            return "готово к въезду";
                            break;

                        case $model::STATE_OTDELKA:
                            return "под отделку";
                            break;

                        case $model::STATE_CLEAR_OTDELKA:
                            return "под чистовую отделку";
                            break;

                        case $model::STATE_SELLING:
                            return "продажа";
                            break;

                    }
                }
            ],
            [
                'attribute' => 'planning',
                'value' => function($model){
                    switch($model['price_sign']){
                        case $model::PLANNING_OPEN:
                            return "открытая";
                            break;

                        case $model::PLANNING_MIXED:
                            return "смешанная";
                            break;

                        case $model::PLANNING_CABINET:
                            return "кабинетная";
                            break;
                    }
                }
            ],
            'price',
            [
                'attribute' => 'price_sign',
                'value' => function($model){
                    switch($model['price_sign']){
                        case $model::PRICE_SIGN_RUB:
                            return "Руб";
                            break;

                        case $model::PRICE_SIGN_DOL:
                            return "$";
                            break;

                        case $model::PRICE_SIGN_EUR:
                            return "€";
                            break;
                    }
                }
            ],
            [
                'attribute' => 'about_text',
                'format' => 'html',
            ],
            [
                'attribute' => 'characterstics_text',
                'format' => 'html',
            ],
            [
                'attribute' => 'news_text',
                'format' => 'html',
            ],
            [
                'attribute' => 'infostructure_text',
                'format' => 'html',
            ],
            [
                'attribute' => 'location_text',
                'format' => 'html',
            ],
            [
                'attribute' => 'contacts_text',
                'format' => 'html',
            ],
        ],
    ]) ?>

</div>
