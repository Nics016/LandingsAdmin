<?php 
	use app\assets\AppAsset;
	use yii\helpers\Html;
	use yii\bootstrap\Nav;
	use yii\bootstrap\NavBar;
	use yii\widgets\Breadcrumbs;
	use common\widgets\Alert;

    use yii\helpers\Url;
    use app\models\UserLanding;
    use app\models\User;

    AppAsset::register($this);
 ?>

<?=
    Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Выйти (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm();
 ?>
 <!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<?php $this->beginPage() ?>
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
    <?php $this->head() ?>
    <!-- LOADING STYLES -->
    <link rel="icon" href="images/favicon.ico">
    <link rel="stylesheet" href="css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
    <link rel="stylesheet" href="css/neon-core.css">
    <link rel="stylesheet" href="css/neon-theme.css">
    <link rel="stylesheet" href="css/neon-forms.css">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="css/main.css">
    <!-- END OF LOADING STYLES -->
</head>

<body class="page-body  page-fade">
<?php $this->beginBody() ?>
<!-- LOADING SCRIPTS -->
    <!-- NEON -->
    <script src="js/neon-custom.js"></script>
    <script src="js/neon-api.js"></script>
    <script src="js/gsap/TweenMax.min.js"></script>
    <script src="js/resizeable.js"></script>
    <!-- END OF NEON -->
    <!-- BOOTSTRAP4 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha/js/bootstrap.min.js"></script>
    <!-- END OF BOOTSTRAP4 -->
<!-- END OF LOADING SCRIPTS -->

<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
    <div class="sidebar-menu">

        <div class="sidebar-menu-inner">
            
            <header class="logo-env">

                <!-- logo -->
                <div class="logo">
                    <a href="<?= Url::toRoute(['/']) ?>">
                        Landings Admin
                    </a>
                </div>

                <!-- logo collapse icon -->
                <div class="sidebar-collapse">
                    <a href="#" class="sidebar-collapse-icon"><!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
                        <i class="entypo-menu"></i>
                    </a>
                </div>

                                
                <!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
                <div class="sidebar-mobile-menu visible-xs">
                    <a href="#" class="with-animation"><!-- add class "with-animation" to support animation -->
                        <i class="entypo-menu"></i>
                    </a>
                </div>

            </header>

            <ul id="main-menu" class="main-menu">
                <!-- add class "multiple-expanded" to allow multiple submenus to open -->
                <!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->
                <li class="has-sub active opened">
                    <a href="<?= Url::base(true) ?>">
                        <i class="entypo-layout"></i>
                        <span class="title">Сайты</span>
                    </a>
                    <ul>

                    <?php if (Yii::$app->user->identity->role == User::ROLE_MANAGER): ?>
                        <?php $landings = UserLanding::findLandingsByManager(Yii::$app->user->identity->id) ?>
                        <?php foreach($landings as $land): ?>
                            <li>
                                <a href="<?= Url::toRoute(['landing/view', 'id' => $land->landing_id]) ?>">
                                    <span class="title"><?= $land->title ?></span>
                                </a>
                            </li> 
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <?php if (Yii::$app->user->identity->role == User::ROLE_ADMIN): ?>
                        <li>
                            <a href="<?= Url::toRoute(['landing/ask-places']) ?>">
                                <span class="title">Добавить новый</span>
                            </a>
                        </li> 
                        <li class="active">
                            <a href="<?= Url::toRoute(['landing/index']) ?>">
                                <span class="title">Все</span>
                            </a>
                        </li>     
                    <?php endif; ?>                     
                    </ul>
                </li>
                
            <?php if (Yii::$app->user->identity->role == User::ROLE_ADMIN): ?>
                <li class="has-sub">
                    <a href="layout-api.html">
                        <i class="entypo-monitor"></i>
                        <span class="title">Управление</span>
                    </a>
                    <ul>
                        <li class="has-sub">
                            <a href="layout-api.html">
                                <span class="title">Пользователи</span>
                            </a>
                            <ul>
                                <li><a href="<?= Url::toRoute(['user/index']) ?>"><span class="title">Все</span></a></li>
                                <li><a href="<?= Url::toRoute(['user/create']) ?>"><span class="title">Создать нового</span></a></li>
                            </ul>
                        </li>   
                        <li><a href="<?= Url::toRoute(['user-landing/create']) ?>"><span class="title">Предоставить доступ к сайту</span></a></li>
                        <li><a href="<?= Url::toRoute(['user-landing/delete']) ?>"><span class="title">Лишить доступа к сайту</span></a></li>
                    </ul>
                </li>
            <?php endif; ?>

            </ul>
        </div>
    </div>
    <div class="main-content">
        <?= $content ?>   
        
        <!-- Footer -->
        <footer class="main">
            
            &copy; 2017 | Landings Admin
        
        </footer>
    </div>
</div>
    <script>
        ///////////////////////////////////////////////////////////
        // Скрипт подсветки текущей страницы белым цветом в меню //
        ///////////////////////////////////////////////////////////

        // Убираем все классы "active" и "opened"
        $('.active').removeClass("active");
        $('.opened').removeClass("opened");

        // Получаем URL текущей открытой страницы без параметров
        var curHref = window.location.href.toString()
            .split(window.location.host)[1]
                .split('&')[0];

        // Проходим по каждой ссылке в меню. Если она = открытой, 
        // помечаем её классом "active", а все li над ней, которые имеют 
        // класс has-sub, помечаем классами "active" и "opened"
        $('.sidebar-menu a').each(function(){
            var curMenuLinkURL = $(this).attr('href');
            if (curMenuLinkURL == curHref){
                $(this).parent().addClass("active");
                var parentLi = $(this).parent().parent().parent();
                while (parentLi.is(".has-sub")){
                    parentLi.addClass("active opened");
                    parentLi = parentLi.parent().parent();
                    if (parentLi.is("div"))
                        break;
                }
                return false;
            }
        });

    </script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>