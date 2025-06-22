<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
#use yii\bootstrap5\Nav;
#use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header style="background-color: #2c3e50; padding: 10px 20px;" id="unique-main-header">
    <div style="display: flex; flex-direction: column; align-items: flex-start;">
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
            <?= \yii\helpers\Html::img('@web/images/logo.png', [
                'alt' => 'Logo',
                'style' => 'height:30px; margin-right:10px;'
            ]) ?>
            <span style="font-size: 20px; color: white; font-weight: bold;">UNI MARKET</span>
        </div>

        <nav style="display: flex; width: 100%; align-items: center;">
            <div style="display: flex; gap: 20px;">
                <?= \yii\helpers\Html::a('Home', ['site/index'], ['style' => 'color: white; text-decoration: none; font-weight: bold;']) ?>
                <?= \yii\helpers\Html::a('Login', ['site/login'], ['style' => 'color: white; text-decoration: none; font-weight: bold;']) ?>
                <?= \yii\helpers\Html::a('Chat', ['site/chat'], ['style' => 'color: white; text-decoration: none; font-weight: bold;']) ?>
            </div>
            <?php 
             use yii\helpers\Url; ?>
            <div style="margin-left: auto;">
                <?php if (!Yii::$app->user->isGuest): ?>
                    <?= Html::img(
                        Yii::$app->user->identity->getProfileImageUrl(), // dynamic profile image url
                        [
                            'class' => 'profile-icon',
                            'onclick' => "location.href='" . Url::to(['site/profile']) . "'",
                            'style' => 'width:30px; height:30px; border-radius:50%; cursor:pointer; object-fit: cover;'
                        ]
                    ) ?>
                <?php else: ?>
                    <?= Html::img(
                        Url::to('@web/images/user.png'), // default image for guests
                        [
                            'class' => 'profile-icon',
                            'style' => 'width:30px; height:30px; border-radius:50%;'
                        ]
                    ) ?>
                <?php endif; ?>
            </div>


        </nav>
    </div>
</header>




<main id="main" class="flex-shrink-0" role="main">
    <div class="container">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">
        <div class="row text-muted">
            <div class="col-md-6 text-center text-md-start">&copy; DG-TECH <?= date('Y') ?></div>
            <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
