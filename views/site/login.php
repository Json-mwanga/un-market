<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Login or Sign Up';
?>

<style>
.site-login .container {
    max-width: 500px;
    margin: 0 auto;
    background: #fff;
    padding: 40px;
    text-align: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    border-radius: 10px;
    margin-top: 50px;
}

.site-login .btn {
    display: inline-block;
    margin: 10px;
    padding: 10px 20px;
    background: #3366FF;
    color: white;
    border: none;
    border-radius: 5px;
    text-decoration: none;
    cursor: pointer;
}

.site-login .btn:hover {
    background: #1a4de3;
}

.site-login .form-box {
    display: none;
    margin-top: 20px;
    text-align: left;
}

.site-login input {
    width: 100%;
    padding: 10px;
    margin-top: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

.site-login button[type="submit"] {
    margin-top: 15px;
    padding: 10px 20px;
    width: 100%;
    background: #000;
    color: #fff;
    border: none;
    border-radius: 5px;
}
</style>
<!-- LOGIN Form -->
<div class="site-login">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>
        <p>Welcome! Please log in or create an account.</p>

        <button class="btn" onclick="showForm('login')">Log In</button>
        <button class="btn" onclick="showForm('signup')">Sign Up</button>

        <!-- Login Form (Visible by Default) -->
        <div class="form-box" id="login" style="display: block;">
            <h3>Login</h3>
            <form method="post" action="<?= Url::to(['site/login']) ?>">
                <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>
                <input type="email" name="LoginForm[email]" placeholder="Email" required>
                <input type="password" name="LoginForm[password]" placeholder="Password" required>
                <button type="submit">Log In</button>
            </form>
        </div>

        <!-- Signup Form -->
        <div class="form-box" id="signup">
            <h3>Sign Up</h3>
            <?php $form = ActiveForm::begin([
                'action' => ['site/signup'],  // your signup action
                'method' => 'post',
            ]); ?>

            <?= $form->field($signupModel, 'first_name')->textInput(['placeholder' => 'First Name'])->label(false) ?>
            <?= $form->field($signupModel, 'last_name')->textInput(['placeholder' => 'Last Name'])->label(false) ?>
            <?= $form->field($signupModel, 'username')->textInput(['placeholder' => 'Username'])->label(false) ?>
            <?= $form->field($signupModel, 'phone_number')->textInput(['placeholder' => 'Phone Number'])->label(false) ?>
            <?= $form->field($signupModel, 'email')->input('email', ['placeholder' => 'Email'])->label(false) ?>
            <?= $form->field($signupModel, 'password')->passwordInput(['placeholder' => 'Password'])->label(false) ?>
            <?= $form->field($signupModel, 'password_confirm')->passwordInput(['placeholder' => 'Confirm Password'])->label(false) ?>

            <button type="submit">Sign Up</button>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<script>
function showForm(id) {
    document.getElementById('login').style.display = 'none';
    document.getElementById('signup').style.display = 'none';
    document.getElementById(id).style.display = 'block';
}
</script>
