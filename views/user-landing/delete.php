<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\UserLanding */

$this->title = 'Лишить менеджера доступа к сайту';
$this->params['breadcrumbs'][] = ['label' => 'User Landings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-landing-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'users' => $users,
        'landings' => $landings,
    ]) ?>

</div>
