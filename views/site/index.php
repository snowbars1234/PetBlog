<?php

/** @var yii\web\View $this */

use yii\helpers\Url;

$this->title = 'My Yii Application';
?>
<div class="col-md-8">
    <?php foreach ($articles as $article): ?>
                <article class="post">
                    <div class="post-thumb">
                        <a href=""><img class="img-index" src="<?= $article->getImage() ?> " alt="Image"></a>
                    </div>
                    <div class="post-content">
                        <header class="entry-header text-center text-uppercase">
                            <a href="<?= Url::toRoute(['/topic', 'id' => $article->topic->id]) ?>"> <?= $article->topic->name; ?></a>

                            <h1 class="entry-title"><a href=""> <?= $article->title; ?> </a>
                        </header>
                        <div class="entry-content">
                            <p> <?= mb_strimwidth($article->description,0, 360, "..."); ?> </p>
                            <div class="btn-continue-reading text-center text-uppercase">
                                <a href="<?= Url::toRoute(['/view', 'id'=>$article->id]) ?>" class="more-link">Continue Reading</a>
                            </div>
                        </div>
                        <div class="social-share">
                            <span class="social-share-title pull-left text-capitalize">By <?= $article->user->name;?> On <?= $article->getDate();?></span>
                            <ul class="text-center pull-right">
                                <li><a class="s-facebook" href="#"><i class="fa fa-eye"></i></a></li>
                                <span><?= (int)$article->viewed; ?></span>
                            </ul>
                        </div>
                    </div>
                </article>
    <?php endforeach; ?>
</div>

<!-- Сайдбар -->
<div class="col-md-4">
    <?php echo \Yii::$app->view->renderFile('@app/views/site/right.php', compact('popular','recent','topics'));?>
</div>


<?= yii\widgets\LinkPager::widget([
        'pagination' => $pagination,
    ]) ?>
</div>

