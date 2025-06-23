<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap5\Modal;

$js = <<<JS
// Toggle between view and edit mode for address and bio
document.getElementById('edit-profile-btn').addEventListener('click', function() {
    // Hide Edit button, show Submit button and form inputs
    this.style.display = 'none';
    document.getElementById('submit-profile-btn').style.display = 'inline-block';

    // Show inputs
    document.querySelectorAll('.editable-field').forEach(el => el.style.display = 'block');
    // Hide text spans
    document.querySelectorAll('.readonly-field').forEach(el => el.style.display = 'none');
});
JS;
$this->registerJs($js);
?>

<style>
.cover-photo {
    background: url('<?= $user->cover_image ? Url::to('@web/' . $user->cover_image) : Url::to('@web/images/cover-placeholder.jpg') ?>') no-repeat center center;
    background-size: cover;
    height: 250px;
    position: relative;
}

/* Edit icon for cover image */
.cover-edit-icon {
    position: absolute;
    top: 10px;
    right: 20px;
    background: #007bff;
    color: white;
    border-radius: 50%;
    padding: 6px;
    cursor: pointer;
    font-size: 14px;
    z-index: 2;
}

/* Logout button container, positioned top-left */
.logout-icon-container {
    position: absolute;
    top: 10px;
    left: 20px;
    z-index: 2;
}

#logout-btn {
    padding: 5px 10px;
    font-size: 13px;
    font-weight: bold;
    display: flex;
    align-items: center;
    gap: 4px;
    background-color: #dc3545;
    border: none;
    color: white;
    border-radius: 4px;
    cursor: pointer;
}

#logout-btn:hover {
    background-color: #c82333;
}

#cover-image-input {
    display: none;
}

.profile-container {
    position: absolute;
    bottom: -70px;
    left: 30px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.profile-image {
    width: 140px;
    height: 140px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #fff;
}

.edit-icon {
    position: absolute;
    bottom: 10px;
    right: 10px;
    background: #007bff;
    color: white;
    border-radius: 50%;
    padding: 6px;
    cursor: pointer;
    font-size: 14px;
}

#profile-image-input {
    display: none;
}

.profile-details {
    margin-top: 90px;
    padding: 20px;
}

#submit-profile-btn {
    display: none; /* Hidden initially */
}
</style>

<?php $form = ActiveForm::begin([
    'action' => ['site/update-profile'],
    'options' => ['enctype' => 'multipart/form-data'],
]); ?>

<!-- Cover Photo -->
<div class="cover-photo">

    <!-- Cover image edit icon -->
    <label for="cover-image-input" class="cover-edit-icon" title="Edit Cover Image">✎</label>
    <?= $form->field($user, 'cover_image')->fileInput([
        'id' => 'cover-image-input',
        'onchange' => 'this.form.submit()'
    ])->label(false) ?>

    <!-- Profile photo container -->
    <div class="profile-container">
        <?= Html::img(
            $user->profile_image ? Url::to('@web/' . $user->profile_image) : Url::to('@web/images/default-profile.png'),
            ['class' => 'profile-image']
        ) ?>
        <label for="profile-image-input" class="edit-icon" title="Edit Profile Image">✎</label>
    </div>
</div>

<?= $form->field($user, 'profile_image')->fileInput([
    'id' => 'profile-image-input',
    'onchange' => 'this.form.submit()'
])->label(false) ?>

<!-- Profile Information -->
<div class="profile-details">
    <h2>
        Profile Information
        <?= Html::button('Edit', ['id' => 'edit-profile-btn', 'class' => 'btn btn-sm btn-secondary', 'style' => 'margin-left:10px;']) ?>
    </h2>

    <p><strong>First Name:</strong> <?= Html::encode($user->first_name) ?></p>
    <p><strong>Last Name:</strong> <?= Html::encode($user->last_name) ?></p>
    <p><strong>Email:</strong> <?= Html::encode($user->email) ?></p>
    <p><strong>Phone Number:</strong> <?= Html::encode($user->phone_number) ?></p>

    <div class="row">
        <div class="col-md-6">
            <!-- Display mode -->
            <p class="readonly-field"><strong>Address:</strong> <?= Html::encode($user->address) ?></p>
            <!-- Edit mode input -->
            <div class="editable-field" style="display:none;">
                <?= $form->field($user, 'address')->textInput()->label(false) ?>
            </div>
        </div>
        <div class="col-md-6">
            <!-- Display mode -->
            <p class="readonly-field"><strong>Bio:</strong> <?= nl2br(Html::encode($user->bio)) ?></p>
            <!-- Edit mode textarea -->
            <div class="editable-field" style="display:none;">
                <?= $form->field($user, 'bio')->textarea(['rows' => 3])->label(false) ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Update Profile', ['class' => 'btn btn-primary', 'id' => 'submit-profile-btn']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

<!-- PRODUCT UPLOAD FORM -->
<hr>
<h2>Your Products</h2>

<?php $productForm = ActiveForm::begin([
    'action' => ['site/upload-product'],
    'options' => ['enctype' => 'multipart/form-data'],
]); ?>

<div class="row">
    <div class="col-md-6">
        <?= $productForm->field($productModel, 'name')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-6">
        <?= $productForm->field($productModel, 'price')->textInput(['type' => 'number', 'step' => '0.01', 'min' => 0]) ?>
    </div>
</div>

<?= $productForm->field($productModel, 'description')->textarea(['rows' => 3]) ?>

<?= $productForm->field($productModel, 'status')->dropDownList([
    'on_sale' => 'On Sale',
    'sold' => 'Sold',
]) ?>

<?= $productForm->field($productModel, 'imageFiles[]')->fileInput([
    'multiple' => true,
    'accept' => 'image/*',
])->label('Upload Images (max 5)') ?>

<div class="form-group">
    <?= Html::submitButton('Upload Product', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>


<!-- DISPLAY USERS PRODUCTS -->
<div class="product-grid" style="display:flex; flex-wrap:wrap; gap:10px;">
    <?php foreach ($products as $product): ?>
        <div class="product-item" style="width:120px; text-align:center; cursor:pointer;" data-id="<?= $product->id ?>">
            <?php
            $img = ($product->images && count($product->images) > 0)
                ? Url::to('@web/' . $product->images[0]->image_path)
                : Url::to('@web/images/no-image.png');
            ?>
            <?= Html::img($img, ['style' => 'width:100%; height:100px; object-fit:cover; border-radius:6px;']) ?>
            <div style="font-size: 13px; margin-top: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                <?= Html::encode($product->name) ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>


    <!-- Logout button -->
    <div class="logout-icon-container">
        <?= Html::beginForm(['/site/logout'], 'post') ?>
            <?= Html::submitButton('⎋ Logout', ['id' => 'logout-btn']) ?>
        <?= Html::endForm() ?>
    </div>

<!-- Modal for product details -->
<?php Modal::begin([
    'id' => 'product-modal',
    'size' => Modal::SIZE_LARGE,
]); ?>
<div id="product-modal-content"></div>
<?php Modal::end(); ?>
