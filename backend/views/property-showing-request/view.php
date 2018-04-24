<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\models\PropertyShowingRequest */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Property Showing Requests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile(
    '@web/js/property_showing_request.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

?>
<div class="property-showing-request-view">
    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'user.fullName',
           // 'model_id',
            'model',
            'schedule:date',
            'note:ntext',
            'name',
            'email:email',
            'phone',
            'is_lender',
            'status',
//            'created_at',
//            'updated_at',
        ],
    ]) ?>

    <div id="listingTable"></div>
    <div role="alert" class="alert alert-success alert-dismissible fade in" style="display:none;" id="sucMsgDiv">
       <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
       <span class="sucmsgdiv"></span>
   </div>
   <div role="alert" class="alert alert-danger alert-dismissible fade in" style="display:none;" id="failMsgDiv">
       <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
       <span class="failmsgdiv"></span>
   </div>
   <div class="property-showing-request-form">
       <?php $form = ActiveForm::begin(['action' => 'index.php?r=property-showing-request/replay-feedback','method' => 'post', 'options' => ['autocomplete' => 'off', 'id' => 'property_request_replay_data']]); ?>
       <?= $form->field($requestFeedback, 'showing_request_id')->hiddenInput(['maxlength' => true,'value' => $id, 'id' => 'showing_request_id'])->label(false) ?>
       <?= $form->field($requestFeedback, 'model_id')->hiddenInput(['maxlength' => true,'value' => $propertyId])->label(false) ?>
       <?= $form->field($requestFeedback, 'model')->hiddenInput(['maxlength' => true,'value' => $modelName])->label(false) ?>
       <?= $form->field($requestFeedback, 'requested_to')->hiddenInput(['maxlength' => true,'value' => $requestTo])->label(false) ?>
       <?= $form->field($requestFeedback, 'reply')->textarea(['rows' => 6,'style' => 'resize:none;']) ?>

       <div class="form-group">
           <?= Html::button($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Replay'), ['class' => $model->isNewRecord ? 'btn btn-default red-btn bnt_save_property' : 'btn btn-primary bnt_replay_request']) ?>
       </div>
       <?php ActiveForm::end(); ?>

   </div>
</div>
