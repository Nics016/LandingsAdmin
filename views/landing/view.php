<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

use Yii;
use app\models\User;
use app\models\UserLanding;

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
        <?= Html::a('Обновить', ['update', 'id' => $model->landing_id], ['class' => 'btn btn-primary']) ?>
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
                    return $returnUl;
                }
            ],
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
                'attribute' => 'object_photo',
                'format' => 'html',
                'value' => function($model){
                    if ($model->object_photo)
                        return
                            Html::img($model->object_photo, ['style' => 'max-width: 600px']);
                    return 
                        'Нет фото';
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