<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\widgets\SocialLoginWidget;


$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;

//$this->registerJsFile(Yii::$app->urlManager->baseUrl.'/js/account.js', ['depends'=> [\yii\bootstrap\BootstrapPluginAsset::className()]])
?>
<section>
    <div class="inner-content-sec">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Login Sec -->
                    <div class="col-sm-7 login-box">
                        <div class="login-box-inner">
                            <div class="login-box-header">
                                <h2>Log In Your Account</h2>
                                <p>Please enter your Email and Password</p>
                            </div>
                            <div role="alert" class="alert alert-success alert-dismissible fade in" style="display:none;" id="sucLoginMsgDiv">
                                <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                                <span class="sucloginmsgdiv"></span>
                            </div>
                            <div role="alert" class="alert alert-danger alert-dismissible fade in" style="display:none;" id="failLoginMsgDiv">
                                <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                                <span class="failloginmsgdiv"></span>
                            </div>
                            <?php $form = ActiveForm::begin(['id' => 'login_form']); ?>
                                <input type="hidden" name="_redirect_url" value="<?= Yii::$app->session->has('_redirect_url')?Yii::$app->session->get('_redirect_url'):''?>" />
                                <?php if(Yii::$app->session->has('_redirect_url')) Yii::$app->session->remove('_redirect_url');?>
                                <?= $form->field($model, 'email')->textInput(['autofocus' => true,'class'=>'form-control','placeholder'=>'Email']) ?>

                                <?= $form->field($model, 'password')->passwordInput(['class'=>'form-control','placeholder'=>'Password']) ?>

                                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                                    <?= Html::a('Forgot Your Password ?', 
                                        ['/site/request-password-reset'],['class' => 'pull-right forgot-pass-link']
                                    ); ?>

                                <div class="form-group text-center login-popup-btn">
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
                            <?= Html::a('Register', 
                                ['/site/signup']
                            ); ?>

                        </div>
                    </div>
                    <!-- Login Sec -->
                </div>
            </div>
        </div>
    </div>
</section>