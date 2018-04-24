<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\widgets\SocialLoginWidget;
use yii\web\View;
use yii\helpers\Url;

$this->title    =   'Share with Friend';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile(
    '@web/public_main/js/share_with_friend.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);                 
?>

<div class="modal-body share-property-modal">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <!-- Login Sec -->
    <div class="login-box register-box">
        <div class="login-box-inner">
            <div class="login-box-header">
                <h2 style="font-size: 20px; text-align: left;">Email to Your Friends</h2>
            </div>
            <div class="row form-group">
                <div class="col-sm-4">
                    <?php
                    if(!empty($model->photos[0])){
                    ?>
                        <img src="<?= $model->photos[0]->imageUrl ?>" alt="">
                    <?php
                    }else{
                        echo Html::img(Yii::getAlias('@uploadsUrl/banner_image/no_image_avaliable.png',['class' => 'img-responsive']));
                    }
                    ?>
                </div>
                <div class="col-sm-8">
                    <p><?= $model->formattedAddress ?></p>
                    <p><?= $model->price ? Yii::$app->formatter->asCurrency($model->price) : "N/A" ?></p>
                    <div class="share-property-left-titlePart">
                        <ul>
                            <li><i class="fa fa-home" aria-hidden="true"></i> <?= $model->no_of_room ?> Room<span><i class="fa fa-circle" aria-hidden="true"></i></span></li>
                            <li><i class="fa fa-bath" aria-hidden="true"></i> <?= $model->no_of_bathroom ? $model->no_of_bathroom : "N/A" ?> Baths <span><i class="fa fa-circle" aria-hidden="true"></i></span></li>
                            <li><i class="fa fa-trello" aria-hidden="true"></i> <?= $model->no_of_toilet ? $model->no_of_toilet : "N/A" ?> Toilet <span><i class="fa fa-circle" aria-hidden="true"></i></span></li>
                            <li><i class="fa fa-glide-g" aria-hidden="true"></i> <?= $model->no_of_garage ? $model->no_of_garage : "N/A" ?> Garage <span><i class="fa fa-circle" aria-hidden="true"></i></span></li>
                            <li><i class="fa fa-square" aria-hidden="true"></i> <?= $model->house_size ? $model->house_size : "NA"  ?> Sq. Ft.</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div role="alert" class="alert alert-success alert-dismissible fade in" style="display:none;" id="sucShareMsgDiv">
                <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                <span class="sucsharemsgdiv"></span>
            </div>
            <div role="alert" class="alert alert-danger alert-dismissible fade in" style="display:none;" id="failShareMsgDiv">
                <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                <span class="failsharemsgdiv"></span>
            </div>
            <?php
            if(!Yii::$app->user->isGuest){
                $model->share_email = Yii::$app->user->identity->email;
                $model->share_name = Yii::$app->user->identity->commonName;
            }
            
            ?>
            <?php $form = ActiveForm::begin(['method' => 'post','action' => ['property/send-share-property'],'options' => ['id' => 'frm_share_property_friends']]); ?>
                <?= $form->field($model, 'share_property_url')->hiddenInput(['value' => $propertyIpUrl])->label(false) ?>
                <?= $form->field($model, 'id')->hiddenInput(['value' => $model->id])->label(false) ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row">
                    <div class="col-sm-10">
                        <div class="row">
                    <div class="col-sm-12">
                        <?= $form->field($model, 'share_with', ['inputTemplate' => '<div class="input-group"><span class="input-group-addon">To</span>{input}</div>'])->textInput(['maxlength' => true,'class'=>'form-control','placeholder'=> 'Separate emails by a comma','id' => 'share_with'])->label(false) ?>
                    </div>

                    <div class="col-sm-6">
                        <?= $form->field($model, 'share_email')->textInput(['maxlength' => true,'class'=>'form-control','placeholder'=> 'Your Email','id' => 'share_email'])->label(false) ?>
                    </div>

                    <div class="col-sm-6">
                        <?= $form->field($model, 'share_name')->textInput(['maxlength' => true,'class'=>'form-control','placeholder'=> 'Your name','id' => 'share_name'])->label(false) ?>
                    </div>
                    <div class="col-sm-12">
                        <?= $form->field($model, 'share_note')->textArea(['maxlength' => true,'class'=>'form-control','rows' => 5,'style' => 'resize:none;','value' => 'Hi. Check out the property I found on '.Yii::$app->name.': '.$model->formattedAddress])->label(false) ?>
                    </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="row">
                            <div class="topsocial popupsocial">
                                <span>Share</span>
                                <a href="https://www.facebook.com/share.php?u=<?= Url::to(['property/view', 'slug' => $model->slug], true)?>" class="facebook" target="_blank"><i class="fa fa-facebook-f"></i></a>
                                  <a href="https://twitter.com/intent/tweet?text=Check+out+this+home+I+found+on+NaijaHouses.com%3A&url=<?= Url::to(['property/view', 'slug' => $model->slug], true)?>" class="twitter" target="_blank"><i class="fa fa-twitter"></i></a>
                                  <a href="https://plus.google.com/share?url=<?= Url::to(['property/view', 'slug' => $model->slug], true)?>" class="google-plus" target="_blank"><i class="fa fa-google-plus"></i></a>
                                  <a href="http://pinterest.com/pin/create/button/?description=Check+out+this+home+I+found+on+NaijaHouses.com.+&url=<?= Url::to(['property/view', 'slug' => $model->slug], true)?>" class="pinterest" target="_blank"><i class="fa fa-pinterest-p"></i></a>
                              </div>
                        </div>
                    </div>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <button class="btn btn-default btn-main" type="button" onclick="validateForm();" id="" name="">Send</button>
                        <button type="button" class="btn btn-default btn-main" data-dismiss="modal">Cancel</button>
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

