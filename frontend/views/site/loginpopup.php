<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\widgets\SocialLoginWidget;



$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;

//$this->registerJsFile(Yii::$app->urlManager->baseUrl.'/js/account.js', ['depends'=> [\yii\bootstrap\BootstrapPluginAsset::className()]])
?>
<div class="modal-body">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <!-- Login Sec -->
    <div class="login-box full-login-box">
        <div role="alert" class="alert alert-success alert-dismissible fade in" style="display:none;" id="sucLoginMsgDiv">
            <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
            <span class="sucloginmsgdiv"></span>
        </div>
        <div role="alert" class="alert alert-danger alert-dismissible fade in" style="display:none;" id="failLoginMsgDiv">
            <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
            <span class="failloginmsgdiv"></span>
        </div>
        <div class="login-box-inner">
            <div class="login-box-header">
                <h2>Log In Your Account</h2>
                <p>Please enter your Email and Password</p>
            </div>
            <?php $form = ActiveForm::begin(['id' => 'login_form']); ?>
                <input type="hidden" class="login_redirect_url" name="_redirect_url" /> 
                <?= $form->field($model, 'email')->textInput(['autofocus' => true,'class'=>'form-control','placeholder'=>'Email']) ?>

                <?= $form->field($model, 'password')->passwordInput(['class'=>'form-control','placeholder'=>'Password']) ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <a href="javascript:void(0)" class="pull-right forgot-pass-link lnk_forgot_password">Forgot Your Password?</a>
                
                <div class="form-group text-center">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-default btn-main', 'name' => 'login-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
            <div class="login-bottom-sec">
                <h3><span>OR</span></h3>
                <p>Log In using one of the following social services:</p>
                <?php echo SocialLoginWidget::widget(array('action' => 'site/login')); ?>
            </div>
        </div>

        <div class="login-bottom-bar">
            Don't have an account? 
            <a href="javascript:void(0)" data-href="<?= \yii\helpers\Url::to(['/site/signup', 'popup' => 1])?>" class="lnk_signup">Register</a>
        </div>
    </div>
    <!-- Login Sec -->
    <!-- Forgot Password Sec -->
    <div class="login-box forgot-password-box">
        <div class="login-box-inner">
            <div class="login-box-header">
                <h2>Forgot Your Password?</h2>
                <p>Please enter your Email Address</p>
            </div>
            <div role="alert" class="alert alert-success alert-dismissible fade in" style="display:none;" id="sucPassMsgDiv">
                <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                <span class="sucpassmsgdiv"></span>
            </div>
            <div role="alert" class="alert alert-danger alert-dismissible fade in" style="display:none;" id="failPassMsgDiv">
                <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                <span class="failpassmsgdiv"></span>
            </div>
            <?= Html::beginForm(Yii::$app->urlManager->createUrl(['site/request-password-reset']),'post',['id' => 'request-password-reset-form']); ?>
                
                <?= Html::textInput('PasswordResetRequestForm[email]','', ['class' => 'form-control','placeholder' => 'Enter Your Email Address','id' => 'email']) ?>
               
                <div class="form-group text-center">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-default btn-main', 'name' => 'login-button']) ?>
                </div>
            <?= Html::endForm() ?>
        </div>

        <div class="login-bottom-bar">
            Back To Login Page? <a href="javascript:void(0)" class="forgot-pass-click-here lnk_login">Click Here</a>
        </div>
    </div>
    <!-- Forgot Password Sec -->
</div>

