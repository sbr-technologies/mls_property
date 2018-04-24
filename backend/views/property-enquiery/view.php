<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;


$this->registerJsFile(
    '@web/js/property_enquiery_request.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);



/* @var $this yii\web\View */
/* @var $model common\models\PropertyEnquiery */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Property Enquieries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="property-enquiery-view">

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?= Html::tag('h2', $model->property->formattedAddress. ' ( '. $model->property->title. ' )')?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'name',
            'email:email',
            'phone',
            'subject',
            'message:ntext',
            'assignTo.fullName',
            'status',
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
       <?php $form = ActiveForm::begin(['action' => 'index.php?r=property-enquiery/replay-feedback','method' => 'post', 'options' => ['autocomplete' => 'off', 'id' => 'property_enquiery_replay_data']]); ?>
       <?= $form->field($enquieryFeedback, 'proerty_enquiery_id')->hiddenInput(['maxlength' => true,'value' => $id, 'id' => 'proerty_enquiery_id'])->label(false) ?>
       <?= $form->field($enquieryFeedback, 'property_id')->hiddenInput(['maxlength' => true,'value' => $propertyId])->label(false) ?>
       <?= $form->field($enquieryFeedback, 'replay')->textarea(['rows' => 6,'style' => 'resize:none;']) ?>

       <div class="form-group">
           <?= Html::button($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Replay'), ['class' => $model->isNewRecord ? 'btn btn-default red-btn bnt_save_property' : 'btn btn-primary bnt_replay_enquiery']) ?>
       </div>
       <?php ActiveForm::end(); ?>

   </div>
</div>
