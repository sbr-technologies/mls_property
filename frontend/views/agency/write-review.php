<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $reviewModel \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Profile;
use yii\helpers\Url;
use kartik\rating\StarRating;

$this->title = 'Write a Review';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile(
    '@web/public_main/js/profile.js',
    ['depends' => [
        \yii\bootstrap\BootstrapPluginAsset::ClassName()
        ]
   ]
);

//$this->registerJsFile(Yii::$app->urlManager->baseUrl.'/public_main/js/profile.js', ['depends'=> [\yii\bootstrap\BootstrapPluginAsset::className()]])
?>

<div class="modal-body">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <!-- Login Sec -->
    <div class="login-box register-box">
        <div role="alert" class="alert alert-success alert-dismissible fade in" style="display:none;" id="sucMsgReviewDiv">
            <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
            <span class="sucmsgreviewdiv"></span>
        </div>
        <div role="alert" class="alert alert-danger alert-dismissible fade in" style="display:none;" id="failMsgReviewDiv">
            <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
            <span class="failmsgreviewdiv"></span>
        </div>
        <div class="login-box-inner">
            <?php $form = ActiveForm::begin(['id' => 'review_form', 'options' => ['autocomplete' => 'off']]); ?>
                <input type="hidden" value="<?= $id ?>" class="ask_user_id" name="ReviewRating[model_id]" /> 
                
                <div class="row">
                    <div class="col-sm-12">
                        <?= $form->field($reviewModel, 'title')->textInput(['autofocus' => true,'class'=>'form-control','placeholder'=>'Title']) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">	
                        <?= $form->field($reviewModel, 'description')->textarea(['autofocus' => true,'class'=>'form-control','style'=>'resize:none;']) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">	
                        <?php echo $form->field($reviewModel, 'rating')->widget(StarRating::classname(), [
                            'pluginOptions' => ['size'=>'md', 'step' => 1, 'showCaption' => false, 'showClear' => false]
                        ]); ?>

                    </div>
                </div>
                <div class="form-group text-center">
                    <?= Html::submitButton('Post Review', ['class' => 'btn btn-default btn-main', 'name' => 'login-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <!-- Login Sec -->
</div>
