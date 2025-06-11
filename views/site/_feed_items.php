<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $products app\models\Product[] */

foreach ($products as $product):
    // Get first image or placeholder
    $firstImage = isset($product->images[0]) ? $product->images[0]->image_path : 'uploads/placeholder.jpg';
?>
    <div class="product-card">
        <a href="<?= Url::to(['site/product-details', 'id' => $product->id]) ?>">
            <img src="<?= Html::encode($firstImage) ?>" alt="<?= Html::encode($product->name) ?>" />
        </a>
        <h3><?= Html::encode($product->name) ?></h3>
        <p><?= Html::encode(mb_strimwidth($product->description, 0, 100, '...')) ?></p>
        <p><strong>Price:</strong> <?= Html::encode($product->price) ?></p>
        <small>Uploaded on: <?= date('Y-m-d', strtotime($product->created_at)) ?></small>
    </div>
<?php endforeach; ?>
