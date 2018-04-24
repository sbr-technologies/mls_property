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

<div class="modal-body">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <!-- Login Sec -->
    <div class="login-box register-box">
        <div role="alert" class="alert alert-success alert-dismissible fade in" style="display:none;" id="sucSignUpMsgDiv">
            <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
            <span class="sucsignupmsgdiv"></span>
        </div>
        <div role="alert" class="alert alert-danger alert-dismissible fade in" style="display:none;" id="failSignUpMsgDiv">
            <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
            <span class="failsignupmsgdiv"></span>
        </div>
        <div class="login-box-inner">
            <div class="login-box-header">
                <h2>Register Your Account</h2>
                <p>New user? Please take a min to fill in your information. You will only have to do this once. We promise!</p>
                <div class="register-top-bar">
                    <ul>
                        <li><i class="fa fa-lock" aria-hidden="true"></i> Save Favorites</li>
                        <li><i class="fa fa-bell" aria-hidden="true"></i> Get Alerts</li>
                        <li><i class="fa fa-link" aria-hidden="true"></i> Sync Devices</li>
                        <li><i class="fa fa-list-ul" aria-hidden="true"></i> Add Listing</li>
                    </ul>
                </div>
            </div>
            <?php $form = ActiveForm::begin(['id' => 'signup_form', 'options' => ['autocomplete' => 'off']]); ?>
                <?= $form->field($model, 'calling_code')->hiddenInput(['autofocus' => true,'class'=>'form-control','placeholder'=>'Mobile Number', 'value' => '+234', 'maxlength' => '10'])->label(false) ?>
                <?= $form->field($model, 'profile_id')->dropDownList(ArrayHelper::map(Profile::find()->where(['not in', 'id', [1,2]])->all(), 'id', 'title'), ['prompt' => 'Select User type']) ?>

                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'first_name')->textInput(['autofocus' => true,'class'=>'form-control','placeholder'=>'First Name']) ?>
                    </div>

                    <div class="col-sm-6">	
                        <?= $form->field($model, 'last_name')->textInput(['autofocus' => true,'class'=>'form-control','placeholder'=>'Last Name']) ?>
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'email')->textInput(['autofocus' => true,'class'=>'form-control','placeholder'=>'Email Address', 'id'=>'email','data-validate_email_url' => Url::to(['site/validateemail']), 'onblur' =>"validateEmail()"]) ?>
                    </div>

                    <div class="col-sm-6">
                        <?= $form->field($model, 'mobile1')->textInput(['autofocus' => true,'class'=>'form-control','placeholder'=>'Mobile Number','onkeypress'=>'return isNumberKey(event);','maxlength' => '15']) ?>
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
                    'template' => '{image}<a href="#" id="refresh_popup_captcha" title="Reload"><i class="fa fa-refresh"></i></a>{input}',
                    'imageOptions' => [
                    'id' => 'signup_popup_captcha_image'
                    ]
                ])
                ?>

                <?php $this->registerJs("
                    $('#refresh_popup_captcha').on('click', function(e){
                        e.preventDefault();
                        $('#signup_popup_captcha_image').yiiCaptcha('refresh');
                    })", yii\web\View::POS_END); 
                ?>
                
                <div class="form-group text-center">
                    <?= Html::submitButton('Sign Up', ['class' => 'btn btn-default btn-main', 'name' => 'login-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="login-bottom-bar">
            Already Registered User? 
            
            <?= Html::a('Login', 
                'javascript:void(0)',
                ['data-href' => Url::to(['/site/login', 'popup' => 1]), 'class' =>'lnk_login']
            ); ?>
            
        </div>
    </div>
    <!-- Login Sec -->
</div>

<?php $js="$('#mls_bs_modal_two').on('shown.bs.modal', function (e) {
        if($('#signup_popup_captcha_image').length > 0){
            $('#signup_popup_captcha_image').yiiCaptcha('refresh');
        }
    });";

$this->registerJs($js, yii\web\View::POS_END);