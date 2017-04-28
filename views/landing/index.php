<?php

use yii\helpers\Html;
use yii\grid\GridView;

use app\models\Landing;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сайты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="landing-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать новый', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

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
            // 'planning',
            'price',
            [
                'attribute' => 'price_sign',
                'value' => function($model){
                    switch($model['state']){
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
            // 'about_text:ntext',
            // 'characterstics_text:ntext',
            // 'news_text:ntext',
            // 'infostructure_text:ntext',
            // 'location_text:ntext',
            // 'contacts_text:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
