<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

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

<header id="header">
    <?php
    NavBar::begin([
        'brandLabel' => 'Pet Blog',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ms-auto'],
        'items' => array_merge(
            !Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin() ? [
                ['label' => 'Admin Panel', 'url' => ['/admin/index']],
                ['label' => 'Manage Articles', 'url' => ['/admin/article/index']],
                ['label' => 'Manage Comments', 'url' => ['/admin/comment/index']],
                ['label' => 'Manage Users', 'url' => ['/admin/user/index']],
                ['label' => 'Manage Topics', 'url' => ['/admin/topic/index']],
            ] : [],
            !Yii::$app->user->isGuest && !Yii::$app->user->identity->isAdmin() ? [
                ['label' => 'Manage my articles', 'url' => ['/user/article/index']],
                ['label' => 'Edit profile', 'url' => ['/user/user/index']],
            ] : [],
            [
                Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/auth/login']]
                ) : (
                    '<li>'
                    . Html::beginForm(['/auth/logout'], 'post', ['class' => 'd-inline'])
                    . Html::submitButton(
                        'Logout (' . Yii::$app->user->identity->username . ')',
                        ['class' => 'btn btn-link logout text-decoration-none']
                    )
                    . Html::endForm()
                    . '</li>'
                )
            ]
        ),
    ]);

    NavBar::end();
    ?>

    <div class="container">

        <!--main content start-->

        <div class="main-content">

            <div class="container">

                <div class="row">

                    <?= $content ?>

                </div>

            </div>

        </div>

    </div>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
