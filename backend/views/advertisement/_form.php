<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\User;
use common\models\Profile;
use common\models\AdvertisementLocationMaster;

/* @var $this yii\web\View */
/* @var $model common\models\Advertisement */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="advertisement-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
      <li role="presentation" class="active"><a href="#general_info" aria-controls="general_info" role="tab" data-toggle="tab">General Info</a></li>
      <li role="presentation"><a href="#ad_banners" aria-controls="ad_banners" role="tab" data-toggle="tab">Banners</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="general_info">
    <?= $form->field($model, 'user_id')->dropDownList(ArrayHelper::map(User::find()->all(), 'id', 'fullName'), ['prompt' => 'Select User']) ?>

    <?= $form->field($model, 'profileIds')->checkboxList(ArrayHelper::map(Profile::find()->where(['id' => [3, 4, 5, 6]])->all(), 'id', 'title')) ?>
  
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>
          
    <?= $form->field($model, 'status')->dropDownList([$model::STATUS_ACTIVE => 'Active', $model::STATUS_INACTIVE => 'Inactive'],['prompt' => 'Select Status']) ?>

    <?= $form->field($model, 'locations')->checkBoxList(ArrayHelper::map(AdvertisementLocationMaster::find()->all(), 'id', 'title')) ?>
    </div>
    <div role="tabpanel" class="tab-pane" id="ad_banners">
      <?php echo $this->render('_form-banner', ['model' => $model, 'bannerModels' => $bannerModels, 'form' => $form])?>
    </div>
    </div> 
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php 
$tmp = new common\models\AdvertisementBanner();
?>
<div style="display: none" class="dv_advertisement_banner_info_template">
    <div class="item new">
        <?= Html::activeHiddenInput($tmp, '[curTime]id')?>
        <div class="form-group">
          <?= Html::activeLabel($tmp, '[curTime]title')?>
          <?= Html::activeTextInput($tmp, '[curTime]title', ['class' => 'form-control'])?>
        </div>
        <div class="form-group">
          <?= Html::activeLabel($tmp, '[curTime]description')?>
          <?= Html::activeTextInput($tmp, '[curTime]description', ['class' => 'form-control'])?>
        </div>
        <div class="form-group">
          <?= Html::activeLabel($tmp, '[curTime]text_color')?>
          <?= Html::activeTextInput($tmp, '[curTime]text_color', ['class' => 'form-control'])?>
        </div>
        <div class="form-group">
          <?= Html::activeLabel($tmp, '[curTime]imageFiles[]')?>
          <?= Html::activeFileInput($tmp, '[curTime]imageFiles[]')?>
        </div>
        <div class="">
          <?= Html::activeHiddenInput($tmp, "[curTime]_destroy", ['class' => 'hidin_child_id']) ?>
          <a data-toggle="tooltip" class="btn btn_check_payment tooltip-test delete_child" title="" data-original-title="<?= Yii::t('app', 'Delete row') ?>"><i class="fa fa-trash-o"></i></a>
        </div>
    </div>
</div>