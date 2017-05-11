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
            'building_type',            
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

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'template' => '{view}{update}{delete}',
                'buttons' => [
                'view' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                'title' => Yii::t('app', 'lead-view'),
                    ]);
                },

                'update' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                'title' => Yii::t('app', 'lead-update'),
                    ]);
                },
                'delete' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                'title' => Yii::t('app', 'lead-delete'),
                    ]);
                }

                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'view') {
                        $url ='index.php?r=landing/view&id='.$model->landing_id;
                        return $url;
                    }

                    if ($action === 'update') {
                        $url ='index.php?r=landing/ask-places-update&land_id='.$model->landing_id;
                        return $url;
                    }
                    if ($action === 'delete') {
                        $url ='index.php?r=landing/delete&id='.$model->landing_id;
                        return $url;
                    }

                }
            ],
        ],
    ]); ?>
</div>
