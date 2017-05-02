<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use app\models\User;
use app\models\Landing;

/* @var $this yii\web\View */
/* @var $model app\models\UserLanding */

$username = User::findOne($model->user_id)->username;
$landingName = Landing::findOne($model->landing_id)->title;

$this->title = "Доступ менеджеру <em style='color:red'>" . $username . "</em><br> к сайту <em style='color:darkgreen'>"  . $landingName . "</em><br> был успешно предоставлен";
$this->params['breadcrumbs'][] = ['label' => 'User Landings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-landing-view">

    <h1><?= $this->title ?></h1>

     <!-- <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'id',
            'user_id',
            'landing_id',
        ],
    ]) ?>  -->

</div>
