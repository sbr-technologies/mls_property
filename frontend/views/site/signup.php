<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Profile;
use yii\captcha\Captcha;
use yii\helpers\Url;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;

//$this->registerJsFile(Yii::$app->urlManager->baseUrl.'/js/account.js', ['depends'=> [\yii\bootstrap\BootstrapPluginAsset::className()]])
?>

<section>
    <div class="inner-content-sec">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Register Sec -->
                    <div class="row register-sec">
                        <div class="col-sm-7 register-left-sec">
                            <h2>Register Your Account</h2>
                            <p>New user? Please take a min to fill in your information. You will only have to do this once. We promise!</p>
                            <div role="alert" class="alert alert-success alert-dismissible fade in" style="display:none;" id="sucSignUpMsgDiv">
                                <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                                <span class="sucsignupmsgdiv"></span>
                            </div>
                            <div role="alert" class="alert alert-danger alert-dismissible fade in" style="display:none;" id="failSignUpMsgDiv">
                                <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                                <span class="failsignupmsgdiv"></span>
                            </div>
                            <?php $form = ActiveForm::begin(['id' => 'signup_form', 'options' => ['autocomplete' => 'off']]); ?>
                                <?= $form->field($model, 'profile_id')->dropDownList(ArrayHelper::map(Profile::find()->where(['not in', 'id', [1,2]])->all(), 'id', 'title'), ['prompt' => 'Select User type']) ?>
                                <?= $form->field($model, 'calling_code')->hiddenInput(['autofocus' => true,'class'=>'form-control','placeholder'=>'Mobile Number', 'value' => '+234', 'maxlength' => '10'])->label(false) ?>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <?= $form->field($model, 'first_name')->textInput(['autofocus' => true,'class'=>'form-control','placeholder'=>'First Name']) ?>
                                    </div>

                                    <div class="col-sm-6">	
                                        <?= $form->field($model, 'last_name')->textInput(['autofocus' => true,'class'=>'form-control','placeholder'=>'First Name']) ?>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-sm-6">
                                        <?= $form->field($model, 'email')->textInput(['autofocus' => true,'class'=>'form-control','placeholder'=>'Email Address', 'id'=>'email','data-validate_email_url' => Url::to(['site/validateemail']), 'onblur' =>"validateEmail()"]) ?>
                                    </div>

                                    <div class="col-sm-6">
                                        <?= $form->field($model, 'mobile1')->textInput(['autofocus' => true,'class'=>'form-control','placeholder'=>'Mobile Number','onkeypress'=>'return isNumberKey(event)','maxlength' => '15']) ?>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-sm-6">
                                        <?= $form->field($model, 'password')->passwordInput(['class'=>'form-control','placeholder'=>'Password']) ?>
                                    </div>

                                    <div class="col-sm-6">
                                        <?= $form->field($model, 'confirm_password')->passwordInput(['class'=>'form-control','placeholder'=>'Confirm Password']) ?>
                                    </div>
                                </div>



                                <?= $form->field($model, 'verifyCode')->widget(\yii\captcha\Captcha::classname(), [
                                    'template' => '{image}<a href="#" id="refresh_captcha" title="Reload"><i class="fa fa-refresh"></i></a>{input}',
                                    'imageOptions' => [
                                    'id' => 'signup_captcha_image'
                                    ]
                                ])
                                ?>

                                <?php $this->registerJs("
                                    $('#refresh_captcha').on('click', function(e){
                                        e.preventDefault();
                                        $('#signup_captcha_image').yiiCaptcha('refresh');
                                    })", yii\web\View::POS_END); 
                                ?>

                                <div class="form-group text-center">
                                    <?= Html::submitButton('Sign Up', ['class' => 'btn btn-default btn-main', 'name' => 'login-button']) ?>
                                </div>
                            <?php ActiveForm::end(); ?>
                            <div class="login-bottom-bar">
                                Already Registered User? 

                                <?= Html::a('Login', 
                                    ['/site/login']
                                ); ?>

                            </div>
                        </div>
                        
                        <div class="col-sm-5 register-right-sec">
                            <div class="register-right-inner">
                                <h2>Why Create An Account?</h2>
                                <ul>
                                    <li>
                                        <p><i class="fa fa-lock" aria-hidden="true"></i></p>
                                        <h3>Save Your Favourite Propertie <span>to view later</span></h3>
                                    </li>

                                    <li>
                                        <p><i class="fa fa-envelope-o" aria-hidden="true"></i></p>
                                        <h3>Get Email Alerts For New Properties <span>when properties become available</span></h3>
                                    </li>

                                    <li>
                                        <p><i class="fa fa-link" aria-hidden="true"></i></p>
                                        <h3>Syncs On Your Devices <span>for future records</span></h3>
                                    </li>

                                    <li>
                                        <p><i class="fa fa-home" aria-hidden="true"></i></p>
                                        <h3>List Your Properties <span>for rental or sale</span></h3>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Register Sec -->
                </div>
            </div>
        </div>
    </div>
</section>