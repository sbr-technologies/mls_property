<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\widgets\SocialLoginWidget;
use yii\helpers\Url;



$this->title = 'Ask a neighborhood expert';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile(Yii::$app->urlManager->baseUrl.'/js/site.js', ['depends'=> [\yii\bootstrap\BootstrapPluginAsset::className()]])
?>

<div class="modal-body">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <!-- Login Sec -->
    <div class="login-box register-box">
        <div class="login-box-inner">
            <div class="login-box-header">
                <h2>Tell me more about this property</h2>
                <!--<p>Already a User? Pls log in to your account, to save and access your messages, and avoid multiple registrations</p>-->
                <p><strong><?= $propertyData->formattedAddress ?></strong></p>
                <div class="register-top-bar">
                    <ul>
                        <li><i class="fa fa-home" aria-hidden="true"></i><?= $propertyData->no_of_room ? $propertyData->no_of_room : "N/A" ?> Beds</li>
                        <li><i class="fa fa-bath" aria-hidden="true"></i> <?= $propertyData->no_of_bathroom ? $propertyData->no_of_bathroom : "N/A" ?> Baths</li>
                        <li><i class="fa fa-trello" aria-hidden="true"></i> <?= $propertyData->no_of_toilet ? $propertyData->no_of_toilet : "N/A" ?> Toilet</li>
                        <li><i class="fa fa-glide-g" aria-hidden="true"></i> <?= $propertyData->no_of_garage ? $propertyData->no_of_garage : "N/A" ?> Garage </li>
                        <li><i class="fa fa-square" aria-hidden="true"></i> <?= $propertyData->house_size ? $propertyData->house_size : "NA"  ?> Sq. Ft.</li>
                        <li><i class="fa fa-rupee" aria-hidden="true"></i> <?= $propertyData->price ? Yii::$app->formatter->asCurrency($propertyData->price) : "N/A" ?></li>
                    </ul>
                </div>
            </div>
            <div role="alert" class="alert alert-success alert-dismissible fade in" style="display:none;" id="reqSucMsgDiv">
                <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                <span class="reqsucmsgdiv"></span>
            </div>
            <div role="alert" class="alert alert-danger alert-dismissible fade in" style="display:none;" id="reqFailMsgDiv">
                <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                <span class="reqfailmsgdiv"></span>
            </div>
            <?php $form = ActiveForm::begin(['method' => 'post','action' => ['property/send-contact-agent'],'options' => ['class' => 'contact-agent-form']]); ?>
            <?= $form->field($model, "model_id")->hiddenInput(['value'=> $propertyData->id])->label(false); ?>
            <?= $form->field($model, "model")->hiddenInput(['value'=> 'Property'])->label(false); ?>
            <?= $form->field($model, "user_id")->hiddenInput(['value'=> $propertyData->user_id])->label(false); ?>
            <?= $form->field($model, 'property_url')->hiddenInput(['value' => $propertyUrl])->label(false) ?>
                <div class="row">
                    <div class="col-sm-7">
                        <div class="form-group">
                            <?= $form->field($model, 'name')->textInput(['maxlength' => true,'class'=>'form-control txt_field','placeholder'=> 'Full Name', 'value' => $userModel->fullName])->label(false) ?>
                        </div>

                        <div class="form-group">
                            <?= $form->field($model, 'email')->textInput(['maxlength' => true,'class'=>'form-control txt_field','placeholder'=> 'Email', 'value' => $userModel->email])->label(false) ?>
                        </div>

                        <div class="form-group">
                            <?= $form->field($model, 'phone')->textInput(['maxlength' => true,'class'=>'form-control txt_field','placeholder'=> 'Phone', 'value' => $userModel->mobile1])->label(false) ?>
                        </div>
                        
                        <div class="form-group">
                            <?= $form->field($model, 'message')->textArea(['maxlength' => true,'class'=>'form-control txt_field','placeholder'=> 'Tell me more about this property'])->label(false) ?>
                        </div>
<!--                        <div class="col-sm-12">
                            <?php //echo $form->field($model, 'login_user')->checkbox()->label(false) ?> I am confirming I am a registered user or please register me as a user. <br>
                            <?php //echo $form->field($model, 'privacy_policy')->checkbox()->label(false) ?> I agree to your <a href="<?php echo Url::to(['site/privacy-policy']) ?>" target="_blank"> Privacy Policy</a>. <br>
                            <?php //echo $form->field($model, 'newsletter_send')->checkbox()->label(false) ?> Please send me news, tips and promos from NaijaHouses.com.
                        </div>-->
                        <div class="form-group text-center">
                            <button class="btn btn-default btn-main" type="submit" name="">Send Request</button>
                            <button type="button" class="btn btn-default btn-main" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>

                    <div class="col-sm-5">
                        <?php
                        if(!empty($propertyData->photos[0])){
                        ?>
                            <img src="<?= $propertyData->photos[0]->imageUrl ?>" alt="">
                        <?php
                        }else{
                            echo Html::img(Yii::getAlias('@uploadsUrl/banner_image/no_image_avaliable.png',['class' => 'img-responsive']));
                        }
                        ?>
                        
                    </div>
                    
                    <div class="col-sm-12 form-group text-center">
                        <p>By sending a request you agree to our <a href="<?php echo Url::to(['site/privacy-policy']) ?>" target="_blank">Privacy Policy</a></p>
                    </div>
                </div>
            <?php ActiveForm::end(); ?>


        </div>


    </div>
    <!-- Login Sec -->
</div>

