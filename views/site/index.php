<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var array $products */

$this->title = 'Home';
?>

<style>
/* Header styling */
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 30px;
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.site-logo {
    display: flex;
    align-items: center;
    gap: 10px;
}

.site-logo img {
    height: 40px;
}

.nav-links {
    margin-top: 10px;
    display: flex;
    gap: 20px;
    padding: 10px 30px;
    background-color: #ffffff;
    border-bottom: 1px solid #dee2e6;
}

.nav-links a {
    text-decoration: none;
    color: #333;
    font-weight: 500;
}

.nav-links a:hover {
    text-decoration: underline;
}

/* Profile image on top right */
.profile-thumb {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    cursor: pointer;
    width: 50px;
    height: 50px;
    border-radius: 50%;      /* makes it circular */
    object-fit: cover;       /* ensures image covers area without distortion */
    border: 2px solid #ddd;  /* optional subtle border */
    margin-right: 10px;      /* space between image and name */
    vertical-align: middle;  /* aligns nicely with text */
    display: inline-block;
}



/* Product feed */
.product-feed {
    padding: 30px;
}

.product-card {
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  padding: 15px;
  margin-bottom: 20px;
  display: flex;
  flex-direction: column;
  transition: transform 0.2s ease;
}

.product-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 6px 15px rgba(0,0,0,0.15);
}

.product-card .product-image {
  width: 100%;
  height: 270px;
  object-fit: cover;
  border-radius: 8px;
  margin-bottom: 10px;
}

.product-card .product-title {
  font-weight: 600;
  font-size: 1.2rem;
  margin-bottom: 5px;
  color: #333;
}

.product-card .product-price {
  color: #2c7a7b;
  font-weight: 700;
  margin-bottom: 10px;
}

.product-card .product-description {
  font-size: 0.9rem;
  color: #555;
  max-height: 3.6em; /* roughly 2 lines */
  overflow: hidden;
  text-overflow: ellipsis;
  margin-bottom: 15px;
}

.product-card .product-buttons {
  display: flex;
  justify-content: space-between;
  gap: 10px;
}

.product-card button,
.product-card a.button-link {
  flex: 1;
  padding: 8px 12px;
  background-color: #3182ce;
  border: none;
  border-radius: 6px;
  color: white;
  font-weight: 600;
  cursor: pointer;
  text-align: center;
  text-decoration: none;
  transition: background-color 0.2s ease;
}

.product-card button:hover,
.product-card a.button-link:hover {
  background-color: #2c5282;
}


.product-details {
    flex-grow: 1;
}

.product-details h4 {
    margin: 0 0 10px;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
}

.user-info img {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    object-fit: cover;
}

.product-status {
  display: inline-block;
  padding: 5px 12px;
  border-radius: 12px;
  font-weight: 600;
  font-size: 0.9rem;
  color: white;
  border: 2px solid transparent;
  background-color: #38a169 !important;
  border-color: #2f855a !important;
  min-width: 80px;
  text-align: center;
  user-select: none;
}

.status-on-sale {
  background-color: #38a169; /* green */
  border-color: #2f855a;
}

.status-sold-out {
  background-color: #e53e3e; /* red */
  border-color: #c53030;
}

.status-pre-order {
  background-color: #dd6b20; /* orange */
  border-color: #b45309;
}

.status-default {
  background-color: #718096; /* gray */
  border-color: #4a5568;
}

.product-description {
  max-height: 4.5em;           /* Limit height to ~3 lines */
  overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-line-clamp: 3;       /* Limit to 3 lines */
  -webkit-box-orient: vertical;
  line-height: 1.5em;
}


</style>

<!-- Product Feed -->
<div class="product-feed">
    <?php foreach ($products as $product): ?>
        <div class="product-card">
            <!-- Product image -->
            <?= Html::a(
                Html::img(
                    isset($product->images[0]) && !empty($product->images[0]->image_path)
                        ? Url::to('@web/' . Html::encode($product->images[0]->image_path))
                        : Url::to('@web/images/no-image.png'),
                    ['class' => 'product-image']
                ),
                ['site/product', 'id' => $product->id]
            ) ?>

            <!-- Product details -->
            <div class="product-details">
                <!-- User Info -->
                <div class="user-info">
                    <?= Html::img(
                        $product->user && !empty($product->user->profile_image)
                            ? Url::to('@web/' . Html::encode($product->user->profile_image))
                            : Url::to('@web/images/default-profile.png'),
                        ['class' => 'profile-thumb']
                    ) ?>
                    <span><?= Html::encode(trim($product->user->first_name . ' ' . $product->user->last_name)) ?></span>
                </div>

                <h4><?= Html::encode($product->name) ?></h4>
                <p><strong>Price:</strong> TSh. <?= Html::encode($product->price) ?></p>
                <p><strong>Status:</strong> <?= Html::encode(ucwords(str_replace('_', ' ', $product->status))) ?></p>
                <p><?= Html::encode(mb_strimwidth($product->description, 0, 100, '...')) ?></p>
                <p style="font-size: 12px; color: gray;">
                    Uploaded: <?= date('M d, Y H:i', strtotime($product->created_at)) ?>
                </p>

                <!-- Recent Comment Preview -->
                <div class="comment-preview" style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #ddd;">
                    
                    <?php
                        $latestComment = $product->recentComments[0] ?? null;
                        if ($latestComment):
                    ?>
                        <div style="font-size: 13px; color: #333;">
                            <em><?= Html::encode($latestComment->user->username ?? 'Anonymous') ?>:</em>
                            <?= Html::encode(mb_strimwidth($latestComment->comment, 0, 80, '...')) ?>
                        </div>

                    <?php endif; ?>
                </div>

                <?= Html::a('View Details', ['site/product', 'id' => $product->id], ['class' => 'btn btn-sm btn-outline-primary']) ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
