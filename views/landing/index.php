<?php

use yii\helpers\Html;
use yii\grid\GridView;

use app\models\Landing;
use app\models\Place;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сайты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="landing-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать новый', ['ask-places'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            'landing_id',
            'title',
            
            [
                'label' => 'Количество помещений',
                'value' => function($model){
                    $numPlaces = count(Place::findPlacesByLanding($model->landing_id));
                    return $numPlaces;
                }
            ],
            // 'about_text:ntext',
            // 'characteristics_text:ntext',
            // 'news_text:ntext',
            // 'infostructure_text:ntext',
            // 'location_text:ntext',
            // 'contacts_text:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
