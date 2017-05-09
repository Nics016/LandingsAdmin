<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

use app\models\User;
use app\models\UserLanding;
use app\models\Place;
use app\models\PlaceLanding;

/* @var $this yii\web\View */
/* @var $model app\models\Landing */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Landings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

// Показываем сайт только в том случае, если менеджер имеет доступ
// к нему
if (UserLanding::userHasAccessToLanding(Yii::$app->user->identity->id, $model->landing_id)):
?>
<div class="landing-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['ask-places-update', 'land_id' => $model->landing_id], ['class' => 'btn btn-primary']) ?>
        <?php if (Yii::$app->user->identity->role == User::ROLE_ADMIN): ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->landing_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?php endif; ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'landing_id',
            'title',
            [
                'label' => 'К этому сайту имеют доступ менеджеры',
                'format' => 'html',
                'value' => function($model){
                    $returnUl = '<ul>';
                    $managers = UserLanding::findManagersByLanding($model->landing_id);
                    foreach($managers as $man){
                        $returnUl .= '<li>' . $man->username . '</li>';
                    }
                    $returnUl .= '</ul>';
                    if ($returnUl === '<ul></ul>')
                        $returnUl = 'нет';
                    return $returnUl;
                }
            ],
            [
                'label' => 'Помещения',
                'format' => 'html',
                'value' => function($model){
                    $returnUl = '<ol>';
                    $places = Place::findPlacesByLanding($model->landing_id);
                    foreach($places as $place){
                        $returnUl .= '<li>';
                            $returnUl .= '<ul>';
                            $returnUl .= Place::generateLi($place);
                            $returnUl .= '</ul>';
                        $returnUl .= '</li>';
                    }
                    $returnUl .= '</ol>';
                    if ($returnUl === '<ol></ol>')
                        $returnUl = 'нет';
                    return $returnUl;
                }
            ],
            [
                'attribute' => 'about_text',
                'format' => 'html',
            ],
            [
                'attribute' => 'characteristics_text',
                'format' => 'html',
            ],
            [
                'attribute' => 'arendator_photos',
                'label' => 'Фотографии',
                'format' => 'html',
                'value' => function($model){
                    $photos = json_decode($model->photos);
                    if ($photos){
                        $answ = '';
                        foreach ($photos as $photo){
                            $answ .= Html::img($photo, ['style' => 'max-width: 600px']).'<br>'.'<br>';
                        }
                        return
                            $answ;
                    }
                    return 'Нет фотографий';
                }
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
                'attribute' => 'arendator_photos',
                'label' => 'Арендаторы',
                'format' => 'html',
                'value' => function($model){
                    $photos = json_decode($model->arendator_photos);
                    if ($photos){
                        $answ = '';
                        foreach ($photos as $photo){
                            $answ .= Html::img($photo, ['style' => 'max-width: 600px']).'<br>'.'<br>';
                        }
                        return
                            $answ;
                    }
                    return 'Нет фотографий';
                }
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
<?php else: ?>
    <h1>Вы не имеете доступа к данному сайту</h1>
<?php endif; ?>