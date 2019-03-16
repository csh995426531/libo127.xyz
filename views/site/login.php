<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- breadcrumbs -->
<!--<div class="breadcrumbs">-->
<!--    <div class="container">-->
<!--        <ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">-->
<!--            <li><a href="index.html"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>-->
<!--            <li class="active">Login Page</li>-->
<!--        </ol>-->
<!--    </div>-->
<!--</div>-->
<!-- //breadcrumbs -->
<!-- login -->
<div class="login">
    <div class="container">
        <h2>Login Form</h2>

        <div class="login-form-grids animated wow slideInUp" data-wow-delay=".5s">
            <form>
                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'layout' => 'horizontal',
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                        'labelOptions' => ['class' => 'col-lg-1 control-label'],
                    ],
                ]); ?>
<!--                <input type="email" placeholder="Email Address" required=" " >-->

<!--                <input type="password" placeholder="Password" required=" " >-->

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <!--<?//  echo $form->field($model, 'rememberMe')->checkbox(['template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",]) ?>-->
                <div class="forgot">
                    <a href="#">Forgot Password?</a>
                </div>
<!--                <input type="submit" value="Login">-->
                <?= Html::submitInput('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                <?php ActiveForm::end(); ?>
            </form>
        </div>
        <h4>For New People</h4>
        <p><a href="registered.html">Register Here</a> (Or) go back to <a href="index.html">Home<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></a></p>
    </div>
</div>
<!-- //login -->