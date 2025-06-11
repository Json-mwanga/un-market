<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var $product app\models\Product */
?>

<div class="product-popup-details">
    <h3><?= Html::encode($product->name) ?></h3>
    <p><strong>Price:</strong> $<?= Html::encode($product->price) ?></p>
    <p><strong>Status:</strong> <?= Html::encode($product->status) ?></p>
    <p><strong>Description:</strong> <?= Html::encode($product->description) ?></p>

    <?php if (!empty($product->images)): ?>
        <div class="product-image-gallery" style="display: flex; flex-wrap: wrap; gap: 10px;">
            <?php foreach ($product->images as $image): ?>
                <div class="image-thumb" style="width: 100px; height: 100px; overflow: hidden; cursor: zoom-in;">
                    <img src="<?= Url::to('@web/' . $image->image_path) ?>" 
                         alt="Product Image" 
                         class="popup-expand-img" 
                         style="width: 100%; height: 100%; object-fit: cover; border-radius: 4px;">
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No images uploaded for this product.</p>
    <?php endif; ?>
</div>

<!-- Optional: Simple JS to allow click-to-expand -->
<style>
    .modal-image-fullscreen {
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1050;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0,0,0,0.9);
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: zoom-out;
    }

    .modal-image-fullscreen img {
        max-width: 90%;
        max-height: 90%;
        object-fit: contain;
    }
</style>

<script>
    document.querySelectorAll('.popup-expand-img').forEach(img => {
        img.addEventListener('click', function () {
            const modal = document.createElement('div');
            modal.className = 'modal-image-fullscreen';
            const clone = this.cloneNode();
            modal.appendChild(clone);
            document.body.appendChild(modal);
            modal.addEventListener('click', () => modal.remove());
        });
    });
</script>
