<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Request password reset';
$this->params['breadcrumbs'][] = $this->title;
//$this->registerJsFile(Yii::$app->urlManager->baseUrl.'/js/account.js', ['depends'=> [\yii\bootstrap\BootstrapPluginAsset::className()]])
?>
<section>
    <div class="inner-content-sec">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Forgot Password Sec -->
                    <div class="col-sm-7 login-box">
                        <div role="alert" class="alert alert-success alert-dismissible fade in" style="display:none;" id="sucPassMsgDiv">
                            <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                            <span class="sucpassmsgdiv"></span>
                        </div>
                        <div role="alert" class="alert alert-danger alert-dismissible fade in" style="display:none;" id="failPassMsgDiv">
                            <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                            <span class="failpassmsgdiv"></span>
                        </div>
                        <div class="login-box-inner">
                            <div class="login-box-header">
                                <h2>Forgot Your Password?</h2>
                                <p>Please enter your Email Address</p>
                            </div>

                            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

                                <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                                <div class="form-group">
                                    <?= Html::submitButton('Send', ['class' => 'btn btn-primary']) ?>
                                </div>

                            <?php ActiveForm::end(); ?>
                        </div>

                        <div class="login-bottom-bar">
                            Back To Login Page? 
                            <?= Html::a('Click Here', 
                                ['/site/login']
                            ); ?>
                        </div>
                    </div>
                    <!-- Forgot Password Sec -->
                </div>
            </div>
        </div>
    </div>
</section>
