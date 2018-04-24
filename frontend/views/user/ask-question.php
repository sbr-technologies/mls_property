<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $questioModel \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Profile;
use yii\helpers\Url;
use common\models\User;

$this->title = 'Ask a Question';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile(
    '@web/public_main/js/profile.js',
    ['depends' => [
        \yii\bootstrap\BootstrapPluginAsset::ClassName()
        ]
   ]
);
$model  =   User::find()->where(['id' => $id])->one();

//$this->registerJsFile(Yii::$app->urlManager->baseUrl.'/public_main/js/profile.js', ['depends'=> [\yii\bootstrap\BootstrapPluginAsset::className()]])
?>

<div class="modal-body">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <!-- Login Sec -->
    <div class="login-box register-box">
        <div role="alert" class="alert alert-success alert-dismissible fade in" style="display:none;" id="sucMsgQuestDiv">
            <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
            <span class="sucmsgquestdiv"></span>
        </div>
        <div role="alert" class="alert alert-danger alert-dismissible fade in" style="display:none;" id="failMsgQuestDiv">
            <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
            <span class="failmsgquestdiv"></span>
        </div>
        <div class="login-box-inner">
            <div class="login-box-header">
                <h2>Ask a Question</h2>
            </div>
            <?php $form = ActiveForm::begin(['id' => 'question_form', 'options' => ['autocomplete' => 'off']]); ?>
                <input type="hidden" class="ask_redirect_url" name="_redirect_url" /> 
                <input type="hidden" value="<?= $model->id ?>" class="ask_user_id" name="Question[user_id]" /> 
                <div class="row">
                    <div class="col-sm-12">
                        <img src="<?php echo $model->getImageUrl(\common\models\User::THUMBNAIL)?>" alt="<?= $model->fullName?>"> Get in Touch With <strong><?= $model->fullName?></strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <?= $form->field($questioModel, 'name')->textInput(['autofocus' => true,'class'=>'form-control','placeholder'=>'Enter Name','value' => $userModel->fullName]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <?= $form->field($questioModel, 'email')->textInput(['autofocus' => true,'class'=>'form-control','placeholder'=>'Enter Emiail Address','value' => $userModel->email]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <?= $form->field($questioModel, 'mobile')->textInput(['autofocus' => true,'class'=>'form-control','placeholder'=>'Enter Phone Number','value' => $userModel->mobile1]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">	
                        <?= $form->field($questioModel, 'description')->textarea(['autofocus' => true,'class'=>'form-control','style'=>'resize:none;']) ?>
                    </div>
                </div>
                <div class="form-group text-center">
                    <?= Html::submitButton('Ask', ['class' => 'btn btn-default btn-main', 'name' => 'login-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <!-- Login Sec -->
</div>
