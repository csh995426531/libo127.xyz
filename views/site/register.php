<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Register';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="breadcrumbs">
    <div class="container">
        <ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
            <li><a href="<?= \yii\helpers\Url::toRoute(['site/index']) ?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>首页</a></li>
            <li class="active">注册</li>
        </ol>
    </div>
</div>
<div class="register" style="padding-top: 0">
    <div class="container">
        <div class="login-form-grids animated wow slideInUp" data-wow-delay=".5s">
            <?php $form = ActiveForm::begin([
                'id' => 'register-form',
                'method'=> 'post',
            ]); ?>
            <div id="sms-code-div" >
                <?= $form->field($model, 'mobile')->textInput(['autofocus' => true, 'placeholder' => '手机号'])->label(false)  ?>
                <?= $form->field($model, 'verifyCode')->label(false)->widget(Captcha::className(), [
                    'name'=>'captchaimg',
                    'captchaAction'=>'site/captcha',
                    'imageOptions'=>[
                        'id'=>'captchaimg',
                        'title'=>'换一个',
                        'alt'=>'换一个',
                        'style'=>'cursor:pointer;',
                    ],
                    'template' => '<div class="row"><div class="col-xs-7 col-sm-7  col-lg-7" style="padding: 0px">{input}</div><div class="col-xs-5 col-sm-5  col-lg-5" style="padding: 0px">{image}</div></div>',
                    'options' => ['placeholder' => '图片验证码', 'class' => 'row']
                ])  ?>
                <?= $form->field($model, 'smsCode')->label(false)->widget(Captcha::className(), [
                    'template' => '<div class="row"><div class="col-xs-7 col-sm-7  col-lg-7" style="padding: 0px">{input}</div><div class="col-xs-5 col-sm-5  col-lg-5" style="padding: 7px 3px;"><a style="cursor: pointer;" id="getSmsCode">点击获取</a></div></div>',
                    'options' => ['placeholder' => '请输入短信验证码']
                ]); ?><a id="smsCodeUrl" data-url="<?= \yii\helpers\Url::toRoute(['site/get-sms-code']) ?>" style="display: none"></a>
            </div>
            <?= Html::submitInput('注册', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            <?php ActiveForm::end(); ?>
        </div>
        <p>
            <a href="<?= \yii\helpers\Url::toRoute(['site/register']) ?>">点击登陆</a> (或)
            <a href="<?= \yii\helpers\Url::toRoute(['site/index']) ?>">返回首页<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></a>
        </p>
    </div>
</div>
<!-- //login -->
<?php
$this->registerJs("
    $(document).on('click', '#getSmsCode', function(){
        var mobile = $('#registerform-mobile').val();
        if (mobile.length === 0) {
            alert('请输入手机号');
            $('#registerform-verifycode').prop('autofocus', 'autofocus');
        } else {

            var verifyCode = $('#registerform-verifycode').val();
            if (verifyCode.length === 0) {
                alert('请输入图形验证码');
                $('#registerform-verifycode').prop('autofocus', 'autofocus');
            } else {

                var url = $('#smsCodeUrl').data('url');

                $.get(url, {mobile:mobile, verify_code:verifyCode, type:'register'}, function(result){
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
