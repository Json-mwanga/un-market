<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\StringHelper;

/** @var \app\models\Product[] $products */
?>

<?php foreach ($products as $product): ?>
    <div class="product-card">
        <?php
        $firstImage = $product->images[0]->image_path ?? '@web/images/default.png';
        ?>
        <img src="<?= Url::to($firstImage) ?>" alt="<?= Html::encode($product->name) ?>">

        <h3><?= Html::encode($product->name) ?></h3>
        <p><strong>Price:</strong> <?= Html::encode($product->price) ?> TZS</p>
        <p><?= Html::encode(StringHelper::truncate($product->description, 100)) ?></p>
        <p><small>Uploaded by <?= Html::encode($product->user->username ?? 'Unknown') ?> on <?= date('M d, Y', strtotime($product->created_at)) ?></small></p>
        <p><strong>Status:</strong> <?= Html::encode(ucfirst($product->status)) ?></p>

        <div style="margin-top: 10px;">
            <?php if (!Yii::$app->user->isGuest): ?>
                <button class="btn btn-sm btn-outline-primary like-button" data-id="<?= $product->id ?>">Like</button>
                <button class="btn btn-sm btn-outline-secondary comment-button" data-id="<?= $product->id ?>">Comment</button>
            <?php endif; ?>
            <a class="btn btn-sm btn-outline-success" href="<?= Url::to(['site/product-details', 'id' => $product->id]) ?>">View</a>
        </div>
    </div>
<?php endforeach; ?>
