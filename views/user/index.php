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
            <li class="active">我的</li>
        </ol>
    </div>
</div>
<div>
    <div class="container" style="color: #777;font-size: 0.7em">
        <div class="div-1">
            <div class="row row-1">
                <div class="user-setting-avatar row ">
                    <label class="col-xs-push-3 col-xs-6" style="cursor:pointer" for="changeAvatar"><img class="img-circle" style="width:80px;height:80px;" src="https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/6d/6d2e2ecb43e756ceb036ebbc3f7d0ef9c66cc494_full.jpg" alt="小毒">
                    </label>
                </div>
                <input type="file" id="changeAvatar" name="imageFile" style="position:absolute;left:-20000px; top:-20000px" value="修改头像">
            </div>
            <div class="row " style="margin: 18px 0">
                <div class="col-xs-4">用户名</div>
                <div class="col-xs-6" style="text-align:right;"><?= $user->username;?></div>
                <div class="col-xs-1">></div>
            </div>
            <div class="row" style="margin: 18px 0">
                <div class="col-xs-4">密码</div>
                <div class="col-xs-6" style="text-align:right;">******</div>
                <div class="col-xs-1">></div>
            </div>
            <div class="row" style="margin: 18px 0">
                <div class="col-xs-4">手机号</div>
                <div class="col-xs-6" style="text-align:right;"><?= $user->mobile;?></div>
                <div class="col-xs-1">></div>
            </div>
            <div class="row " style="margin: 18px 0">
                <div class="col-xs-4">账户</div>
                <div class="col-xs-6" style="text-align:right;">10.0</div>
                <div class="col-xs-1">></div>
            </div>
            <div class="row" style="margin: 18px 0">
                <div class="col-xs-4">已购</div>
                <div class="col-xs-6" style="text-align:right;">1</div>
                <div class="col-xs-1">></div>
            </div>
        </div>
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
