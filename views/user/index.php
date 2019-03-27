<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'account';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="breadcrumbs">
    <div class="container">
        <ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
            <li><a href="<?= \yii\helpers\Url::toRoute(['site/index']) ?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>首页</a></li>
            <li class="active">我的账号</li>
        </ol>
    </div>
</div>
<div class="login">
    <div class="container">
        <h4>
            <span id="login-type-password" class="login_type checked_type" data-type="password" data-checked="true">账号密码登陆</span> |
            <span id="login-type-sms-code" class="login_type" data-type="sms_code" data-checked="false">短信验证登陆</span>
        </h4>

        <p>
            <a href="<?= \yii\helpers\Url::toRoute(['site/register']) ?>">点击注册</a> (或) 返回
            <a href="<?= \yii\helpers\Url::toRoute(['site/index']) ?>">首页<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></a>
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
                alert('请输入短信验证码');
                $('#loginform-verifycode').prop('autofocus', 'autofocus');
            } else {

                var url = $('#smsCodeUrl').data('url');

                $.get(url, {mobile:mobile, verify_code:verifyCode}, function(result){
                    result = JSON.parse(result)
                    if (result.status == 500) {
                        alert(result.msg)
                    }
                });
            }
        }
    });
");
?>
