<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="breadcrumbs">
    <div class="container">
        <ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
            <li><a href="<?= \yii\helpers\Url::toRoute(['site/index']) ?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>首页</a></li>
            <li class="active">登陆</li>
        </ol>
    </div>
</div>
<div class="login">
    <div class="container">
        <h4>
            <span id="login-type-password" class="login_type checked_type" data-type="password" data-checked="true">账号密码登陆</span> |
            <span id="login-type-sms-code" class="login_type" data-type="sms_code" data-checked="false">短信验证登陆</span>
        </h4>
        <div class="login-form-grids animated wow slideInUp" data-wow-delay=".5s">
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'method'=> 'post',
            ]); ?>
            <?= $form->field($model, 'type')->hiddenInput()->label(false) ?>
            <div id="password-div">
                <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => '用户名/手机号'])->label(false) ?>
                <?= $form->field($model, 'password')->passwordInput(['placeholder' => '请输入密码'])->label(false) ?>
            </div>
            <div id="sms-code-div"  style="display: none">
                <?= $form->field($model, 'mobile')->textInput(['autofocus' => true, 'placeholder' => '手机号'])->label(false)  ?>
                <?= $form->field($model, 'verifyCode')->label(false)->widget(Captcha::className(), [
                    'name'=>'captchaimg',
                    'captchaAction'=>'site/captcha',
                    'imageOptions'=>[
                        'id'=>'captchaimg',
                        'title'=>'换一个',
                        'alt'=>'换一个',
                        'style'=>'cursor:pointer;',
                        // 添加点击事件
//                        'onclick' => 'this.src=this.src+"&c="+Math.random();',
                    ],
                    'template' => '<div class="row"><div class="col-xs-7 col-sm-7  col-lg-7" style="padding: 0px">{input}</div><div class="col-xs-5 col-sm-5  col-lg-5" style="padding: 0px">{image}</div></div>',
                    'options' => ['placeholder' => '图片验证码', 'class' => 'row']
                ])  ?>
                <?= $form->field($model, 'smsCode')->label(false)->widget(Captcha::className(), [
                    'template' => '<div class="row"><div class="col-xs-7 col-sm-7  col-lg-7" style="padding: 0px">{input}</div><div class="col-xs-5 col-sm-5  col-lg-5" style="padding: 7px 3px;"><a style="cursor: pointer;" id="getSmsCode">点击获取</a></div></div>',
                    'options' => ['placeholder' => '请输入短信验证码']
                ]); ?><a id="smsCodeUrl" data-url="<?= \yii\helpers\Url::toRoute(['site/get-sms-code']) ?>" style="display: none"></a>
            </div>
            <!--<?//  echo $form->field($model, 'rememberMe')->checkbox(['template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",]) ?>-->
            <div class="forgot">
                <a href="#">忘记密码?</a>
            </div>
            <?= Html::submitInput('登陆', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            <?php ActiveForm::end(); ?>

        </div>
        <p>
            <a href="<?= \yii\helpers\Url::toRoute(['site/register']) ?>">点击注册</a> (或)
            <a href="<?= \yii\helpers\Url::toRoute(['site/index']) ?>">返回首页<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></a>
        </p>
    </div>
</div>
<!-- //login -->
<?php
$this->registerJs("
    $(document).on('click', '.login_type', function(){
        if ($(this).data('checked') === false && !$(this).hasClass('checked_type')) {
            var type = $(this).data('type');

            $(this).addClass('checked_type');
            $(this).data('checked', true);
            $('#loginform-type').val(type);
            $('#loginform-username').val('');
            $('#loginform-password').val('');
            $('#loginform-mobile').val('');
            $('#loginform-smscode').val('');

            if (type === 'password') {
                $('#login-type-sms-code').removeClass('checked_type');
                $('#login-type-sms-code').data('checked', false);
                $('#password-div').css('display', 'block');
                $('#sms-code-div').css('display', 'none');
            } else {
                $('#login-type-password').removeClass('checked_type');
                $('#login-type-password').data('checked', false);
                $('#sms-code-div').css('display', 'block');
                $('#password-div').css('display', 'none');
            }
        }
    });
    $(document).on('click', '#getSmsCode', function(){
        var mobile = $('#loginform-mobile').val();
        if (mobile.length === 0) {
            alert('请输入手机号');
            $('#loginform-verifycode').prop('autofocus', 'autofocus');
        } else {

            var verifyCode = $('#loginform-verifycode').val();
            if (verifyCode.length === 0) {
                alert('请输入图形验证码');
                $('#loginform-verifycode').prop('autofocus', 'autofocus');
            } else {

                var url = $('#smsCodeUrl').data('url');

                $.get(url, {mobile:mobile, verify_code:verifyCode}, function(result){
                    result = JSON.parse(result)
                    alert(result.msg)
                });
            }
        }
    });
");
?>
