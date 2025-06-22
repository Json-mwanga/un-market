<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = $model->name;
?>

<div class="product-card" style="max-width: 700px; margin: auto;">
    <h2><?= Html::encode($model->name) ?></h2>
    <p><strong>Price:</strong> <?= Html::encode($model->price) ?> TZS</p>
    <p><strong>Status:</strong> <?= Html::encode(ucfirst($model->status)) ?></p>
    <p><strong>Description:</strong> <?= Html::encode($model->description) ?></p>

    <!-- Show all images -->
    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
        <?php foreach ($model->images as $img): ?>
            <img src="<?= Url::to('@web/' . Html::encode($img->image_path)) ?>" style="width: 120px; border-radius: 5px;">
        <?php endforeach; ?>
    </div>
</div>

<hr style="max-width: 700px; margin: 40px auto;">

<!-- Comments section -->
<div style="max-width: 700px; margin: auto;">
    <h4>Comments</h4>

    <?php if (!Yii::$app->user->isGuest): ?>
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($newComment, 'comment')->textarea([
            'rows' => 3, 
            'placeholder' => 'Write your comment here...'
        ])->label(false) ?>

        <div class="form-group">
            <?= Html::submitButton('Post Comment', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    <?php else: ?>
        <p><em><a href="<?= Url::to(['site/login']) ?>">Login</a> to comment.</em></p>
    <?php endif; ?>

    <div style="margin-top: 20px;">
        <?php foreach ($comments as $comment): ?>
            <div style="border-bottom: 1px solid #ddd; margin-bottom: 10px; padding: 5px 0;">
                <strong><?= Html::encode($comment->user->username ?? 'Guest') ?>:</strong>
                <p><?= Html::encode($comment->comment) ?></p>
                <small class="text-muted"><?= Yii::$app->formatter->asRelativeTime($comment->created_at) ?></small>
            </div>
        <?php endforeach; ?>
    </div>
</div>
