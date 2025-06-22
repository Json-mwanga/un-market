<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\StringHelper;

/** @var \app\models\Product[] $products */

$statusClassMap = [
    'on_sale' => 'status-on-sale',
    'sold_out' => 'status-sold-out',
    'pre_order' => 'status-pre-order',
];
?>

<?php foreach ($products as $product): 
    $firstImage = $product->images[0]->image_path ?? '@web/images/default.png';
    $statusClass = isset($statusClassMap[$product->status]) ? $statusClassMap[$product->status] : 'status-default';
?>
    <div class="product-card">
        <!-- Clickable image linking to product details -->
        <a href="<?= Url::to(['site/product-details', 'id' => $product->id]) ?>">
            <img class="product-image" src="<?= Url::to($firstImage) ?>" alt="<?= Html::encode($product->name) ?>">
        </a>

        <h3><?= Html::encode($product->name) ?></h3>
        <p><strong>Price:</strong> <?= Html::encode($product->price) ?> TZS</p>
        
        <p class="product-description">
            <?= Html::encode(StringHelper::truncate($product->description, 100)) ?>
        </p>
        
        <p>
            <small>
                Uploaded by <?= Html::encode($product->user->username ?? 'Unknown') ?>
                on <?= date('M d, Y', strtotime($product->created_at)) ?>
            </small>
        </p>
        
        <p>
            <strong>Status:</strong> 
            <span class="product-status <?= $statusClass ?>">
                <?= Html::encode(ucwords(str_replace('_', ' ', $product->status))) ?>
            </span>
        </p>

        <div style="margin-top: 10px;">
            <?php if (!Yii::$app->user->isGuest): ?>
                <button class="btn btn-sm btn-outline-primary like-button" data-id="<?= $product->id ?>">Like</button>
                <button class="btn btn-sm btn-outline-secondary comment-button" data-id="<?= $product->id ?>">Comment</button>
            <?php endif; ?>
            <a class="btn btn-sm btn-outline-success" href="<?= Url::to(['site/product-details', 'id' => $product->id]) ?>">View</a>
        </div>
    </div>
<?php endforeach; ?>
