<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Article $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group">
        <label for="image-label">Image</label><br>
        <?= $form->field($model, 'image', [
            'template' => '{input}{error}',
        ])->fileInput(['accept' => 'image/*'])->label(false) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
