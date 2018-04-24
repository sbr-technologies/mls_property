<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
$this->title = 'Tell me more about property';

$this->registerJsFile(
    '@web/js/property_enquiery_request.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);


?>
<div class="content-wrapper">
    <!-- Content Title Sec -->
    <section class="content-header">
        <h1><?php echo $this->title ?></h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i><?= $this->title?></a></li>
            <li class="active">Details</li>
        </ol>
    </section>
    <!-- Content Title Sec -->

    <!-- Main content -->
    <section class="content">
        <div class="manage-profile-sec">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute'=>'model_id',
                        'label'=>'Property_Address/Location',
    //                    'noWrap' => true,
                        'value'=> isset($model->property)?$model->property->formattedAddress:'n/a'
                    ],
                    [
                        'attribute'=>'model_id',
                        'label'=>'Category',
                        'value'=> isset($model->property)?$model->property->propertyCategory->title:'n/a'
                    ],
                    ['attribute' => 'property.PropertyTypes', 'label' => 'Property_Type'],
                    ['attribute' => 'name', 'label' => 'Request by'],
                    [
                        'attribute'=>'model_id',
                        'label'=>'Agency Name',
                        'value'=> isset($model->property)?($model->property->user->agency_id?$model->property->user->agency->name:'n/a'):'n/a'
                    ],
                    'email:email',
                    'phone',
                    'message:ntext',
                    ['attribute' => 'created_at', 'label' => 'Date/Timestamped', 'value' => Yii::$app->formatter->asDatetime($model->created_at)],
                    //'assign_to',
//                    [   'attribute' => 'status',
//                        'contentOptions' => ['class' => 'text-capitalize']
//                    ],
                ],
            ]) ?>
        </div>
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
            <?php $form = ActiveForm::begin(['action' => 'replay-feedback','method' => 'post', 'options' => ['autocomplete' => 'off', 'id' => 'property_enquiery_replay_data']]); ?>
            <?= $form->field($enquieryFeedback, 'proerty_enquiery_id')->hiddenInput(['maxlength' => true,'value' => $id, 'id' => 'proerty_enquiery_id'])->label(false) ?>
            <?= $form->field($enquieryFeedback, 'property_id')->hiddenInput(['maxlength' => true,'value' => $propertyId])->label(false) ?>
            <?= $form->field($enquieryFeedback, 'replay')->textarea(['rows' => 6,'style' => 'resize:none;'])->label('Message') ?>

            <div class="form-group">
                <?= Html::button(Yii::t('app', 'Send'), ['class' => 'btn btn-primary bnt_replay_enquiery']) ?>
            </div>
            <?php ActiveForm::end(); ?>

        </div>
    </section>
</div>


