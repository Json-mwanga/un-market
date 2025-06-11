<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\StringHelper;

/** @var \app\models\Product $model */

$user = $model->user;
$image = $model->images[0]->url ?? Url::to('@web/images/default-product.jpg'); // fallback image
$isGuest = Yii::$app->user->isGuest;
?>

<div class="product-card">
    <!-- User info and upload time -->
    <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <?= Html::img($user->getProfileImageUrl(), [
            'style' => 'width:30px; height:30px; border-radius:50%; object-fit:cover; margin-right:10px;',
            'alt' => 'User'
        ]) ?>
        <div>
            <strong><?= Html::encode($user->username) ?></strong><br>
            <small class="text-muted"><?= Yii::$app->formatter->asRelativeTime($model->created_at) ?></small>
        </div>
    </div>

    <!-- Product Image (clickable) -->
    <a href="<?= Url::to(['site/product', 'id' => $model->id]) ?>">
        <img src="<?= Html::encode($image) ?>" alt="<?= Html::encode($model->name) ?>" style="width:100%; border-radius:5px; object-fit:cover;">
    </a>

    <!-- Product Info -->
    <a href="<?= Url::to(['site/product', 'id' => $model->id]) ?>" style="text-decoration: none; color: inherit;">
        <h3><?= Html::encode($model->name) ?></h3>
    </a>
    <p><strong>Price:</strong> <?= Html::encode($model->price) ?> TZS</p>
    <p><strong>Status:</strong> 
        <span style="color:<?= $model->status === 'sold' ? 'red' : 'green' ?>;">
            <?= Html::encode(ucfirst($model->status)) ?>
        </span>
    </p>
    <p><?= Html::encode(StringHelper::truncateWords($model->description, 20)) ?></p>

    <!-- Action buttons -->
    <div style="display: flex; justify-content: space-between; margin-top: 10px;">
        <?php if (!$isGuest): ?>
            <button class="btn btn-outline-primary btn-sm like-btn" data-id="<?= $model->id ?>">Like</button>
            <button class="btn btn-outline-secondary btn-sm" onclick="location.href='<?= Url::to(['site/product', 'id' => $model->id]) ?>'">Comment</button>
            <button class="btn btn-outline-success btn-sm share-btn">Share</button>
        <?php else: ?>
            <small style="color:gray;">Login to like or comment</small>
        <?php endif; ?>
    </div>
</div>
