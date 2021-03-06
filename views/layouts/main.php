<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php if (Yii::$app->user->isGuest): ?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <script src="assets/js/jquery-1.11.3.min.js"></script>
    <?php $this->head() ?>
</head>
<body class="page-body  page-fade">
<?php $this->beginBody() ?>

<div class="wrap">

    <div class="container">
        <?= $content ?>
    </div>
</div>

<?php elseif (!Yii::$app->user->isGuest): ?>
<?=
    Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Выйти (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm();
 ?>
<?= $content ?>
<a href="<?= Url::base(true) ?>"> Вернуться на главную</a>
<?php endif; ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
