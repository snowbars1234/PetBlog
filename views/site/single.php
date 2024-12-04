<?php

use yii\helpers\Url;

?>
<div class="col-md-8">

    <article class="post">

        <div class="post-thumb">

            <a href="blog.html"><img src="<?= $article->getImage() ?>" alt=" image"></a>

        </div>

        <div class="post-content">

            <header class="entry-header text-center text-uppercase">



                    <a href="<?= Url::toRoute(['/topic', 'id' => $article->topic->id]) ?>"> <?= $article->topic->name; ?></a>



                <h1 class="entry-title">
                    <a href="#"><?= htmlspecialchars($article->title); ?></a>
                </h1>
            </header>

            <div class="entry-content">

                <?= $article->description; ?>

            </div>

            <div class="decoration">

                <?php foreach (preg_split("/[\s,]+/", $article->tag) as $tag): ?>

                    <a href="/search?SearchForm[text]=<?= str_replace('#', '', $tag) ?>"

                       class="btn btn-default"><?= $tag ?></a>

                <?php endforeach; ?>

            </div>

            <div class="social-share">

                <span class="social-share-title pull-left text-capitalize">By <?= $article->user->name; ?> On <?= $article->getDate(); ?></span>

                <ul class="text-center pull-right">

                    <li>
                        <a class="s-facebook"
                           href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(Url::to(['site/view', 'id' => $article->id], true)); ?>&title=<?= urlencode($article->title); ?>"
                           target="_blank">
                            <i class="fa fa-facebook"></i>
                        </a>
                    </li>
                    <li>
                        <a class="s-twitter"
                           href="https://twitter.com/intent/tweet?url=<?= urlencode(Url::to(['site/view', 'id' => $article->id], true)); ?>&text=<?= urlencode($article->title); ?>"
                           target="_blank">
                            <i class="fa fa-twitter"></i>
                        </a>
                    </li>
                    <li>
                        <a class="s-linkedin"
                           href="https://www.linkedin.com/shareArticle?mini=true&url=<?= urlencode(Url::to(['site/view', 'id' => $article->id], true)); ?>&title=<?= urlencode($article->title); ?>&summary=<?= urlencode($article->description); ?>"
                           target="_blank">
                            <i class="fa fa-linkedin"></i>
                        </a>
                    </li>
                    <li>
                        <a class="s-whatsapp"
                           href="https://api.whatsapp.com/send?text=<?= urlencode($article->title . ' ' . Url::to(['site/view', 'id' => $article->id], true)); ?>"
                           target="_blank">
                            <i class="fa fa-whatsapp"></i>
                        </a>
                    </li>


                </ul>

            </div>

        </div>

    </article>
    <div class="leave-comment"><!--leave comment-->
        <?php if (!Yii::$app->user->isGuest): ?>

            <?php $form = \yii\widgets\ActiveForm::begin([

                'action' => ['site/comment', 'id' => $article->id],

                'options' => ['class' => '', 'role' => 'form']]) ?>

            <div class="leave-comment"><!--leave comment-->

                <h4>Leave a reply</h4>

                <form class="form-horizontal contact-form" role="form" method="post" action="#">

                    <div class="form-group">

                        <div class="col-md-12">

                            <?= $form->field($commentForm, 'comment')->textarea(['class' => 'form-control',
                                'placeholder' => 'Write Message'])->label(false) ?>

                        </div>

                    </div>

                    <button type="submit" class="btn send-btn">Post Comment</button>

                    <?php \yii\widgets\ActiveForm::end() ?>

                </form>

            </div><!--end leave comment-->

        <?php endif; ?>
    </div>
    <div class="comments-block">
        <?php if (!empty($commentsParent)): ?>

            <div class="comments-block">

                <?php foreach ($commentsParent as $comment): ?>

                    <div class="comment-block">

                        <?php if (!$comment->delete): ?>

                            <div class="comment">

                                <a href="#" class="comment-img">

                                    <img class="img-round" src="<?= $comment->user->getImage(); ?>" alt="">

                                </a>

                                <div class="comment-body">

                                    <div class="comment-top">

                                        <?php if (!Yii::$app->user->isGuest): ?>

                                            <button class="replay btn pull-right" onclick="ShowReplay(this)"> Replay

                                            </button>

                                        <?php endif; ?>

                                        <h5><?= $comment->user->name; ?></h5>

                                        <p class="comment-date">

                                            <?= $comment->getDate(); ?>

                                        </p>

                                    </div>

                                    <div class="comment-text">

                                        <?= $comment->text; ?>

                                    </div>

                                    <?php if ($comment->user_id == Yii::$app->user->id): ?>

                                        <?php $form = \yii\widgets\ActiveForm::begin([

                                            'action' => ['site/comment-delete', 'id' => $article->id, 'id_comment' => $comment->id],

                                            'options' => ['class' => '', 'role' => 'form']]) ?>

                                        <div class="comment-delete">

                                            <button type="submit" class="delete-btn">

                                                <i class="fa fa-trash"></i>

                                            </button>

                                        </div>

                                        <?php \yii\widgets\ActiveForm::end() ?>

                                    <?php endif; ?>

                                </div>

                            </div>

                        <?php else: ?>

                            <?php if (is_int(array_search($comment->id, array_column($commentsChild, 'comment_id')))): ?>

                                <div class="comment">

                                    <a href="#" class="comment-img">

                                        <img class="img-round" src="<?= $comment->user->getImage(); ?>" alt="">

                                    </a>

                                    <div class="comment-body">

                                        <div class="comment-top">

                                            <h5><?= $comment->user->name; ?></h5>

                                            <p class="comment-date">

                                                <?= $comment->getDate(); ?>

                                            </p>

                                        </div>

                                        <div class="comment-text">

                                            Comment delete

                                        </div>

                                    </div>

                                </div>

                            <?php endif; ?>

                        <?php endif; ?>

                        <div class="replay-comment" hidden>

                            <?php if (!Yii::$app->user->isGuest): ?>

                                <?php $form = \yii\widgets\ActiveForm::begin([

                                    'action' => ['site/comment', 'id' => $article->id, 'id_comment' => $comment->id],

                                    'options' => ['class' => '', 'role' => 'form']]) ?>

                                <div class="leave-comment-child"><!--leave comment-->

                                    <h4>Leave a reply for <?= $comment->user->name; ?></h4>

                                    <div class="form-group">

                                        <div class="col-md-12">

                                            <?= $form->field($commentForm, 'comment')->textarea(['class' => 'form-control',
                                                'placeholder' => 'Write Message'])->label(false) ?>

                                        </div>

                                    </div>

                                    <button type="submit" class="btn send-btn">Post Comment</button>

                                    <?php \yii\widgets\ActiveForm::end() ?>

                                </div><!--end leave comment-->

                            <?php endif; ?>

                        </div>

                        <div class="comment-childs-container">

                            <div class="comment-childs">

                                <?php foreach ($commentsChild as $commentChild): ?>

                                    <?php if ($commentChild->comment_id == $comment->id): ?>

                                        <div class="comment-block" >

                                            <div class="comment">

                                                <a href="#" class="comment-img">

                                                    <img class="img-round" src="<?= $commentChild->user->getImage(); ?>"

                                                         alt="">

                                                </a>

                                                <div class="comment-body">

                                                    <div class="comment-top">

                                                        <h5><?= $commentChild->user->name; ?></h5>

                                                        <p class="comment-date">

                                                            <?= $commentChild->getDate(); ?>

                                                        </p>

                                                    </div>

                                                    <div class="comment-text">

                                                        <?= $commentChild->text; ?>

                                                    </div>

                                                    <?php if ($commentChild->user_id == Yii::$app->user->id): ?>

                                                        <?php $form = \yii\widgets\ActiveForm::begin([

                                                            'action' => ['site/comment-delete', 'id' => $article->id,
                                                                'id_comment' => $commentChild->id],

                                                            'options' => ['class' => '', 'role' => 'form']]) ?>

                                                        <div class="comment-delete" >

                                                            <button type="submit" class="delete-btn">

                                                                <i class="fa fa-trash"></i>

                                                            </button>

                                                        </div>

                                                        <?php \yii\widgets\ActiveForm::end() ?>

                                                    <?php endif; ?>

                                                </div>

                                            </div>

                                        </div>

                                    <?php endif; ?>

                                <?php endforeach; ?>

                            </div>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>
    </div>
</div>
<div class="col-md-4">
<?php echo \Yii::$app->view->renderFile('@app/views/site/right.php', compact('popular','recent','topics'));?>?>
</div>
<script>

    function ShowReplay(button) {

        var comment = button.parentElement.parentElement.parentElement.parentElement;

        var repl = comment.getElementsByClassName('replay-comment')[0];



        repl.hidden = !repl.hidden;

        console.log(repl);

    }
</script>