<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
$this->title = 'Request Details';

$this->registerJsFile(
    '@web/js/property_showing_request.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);


?>
<div class="content-wrapper">
    <!-- Content Title Sec -->
    <section class="content-header">
        <h1><?php echo $this->title ?></h1>
        <ol class="breadcrumb">
            <li><a href="<?= yii\helpers\Url::to(['property/requested-property'])?>"><i class="fa fa-home" aria-hidden="true"></i> Requests</a></li>
            <li class="active"><?= $this->title?></li>
        </ol>
    </section>
    <!-- Content Title Sec -->

    <!-- Main content -->
    <section class="content">
        <div class="manage-profile-sec">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                'user.fullname',
                'property_category',
                ['attribute' => 'propertyType.title', 'label' => 'Property Type'],
                'budget_from',
                'budget_to',
                'no_of_bed_room',
                'state',
                ['attribute' => 'locality', 'label' => 'Town'],
                'area',
                'comment:ntext',
                ['attribute' => 'user.profile.title', 'label' => 'Requested By'],
                'user.email',
                'user.mobile1',
                'schedule:date',
                'created_at:date',
                'status',
        //            'updated_at:datetime',
            ],
]) ?>
        </div>
<!--        <div id="listingTable"></div>
         <div role="alert" class="alert alert-success alert-dismissible fade in" style="display:none;" id="sucMsgDiv">
            <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
            <span class="sucmsgdiv"></span>
        </div>
        <div role="alert" class="alert alert-danger alert-dismissible fade in" style="display:none;" id="failMsgDiv">
            <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
            <span class="failmsgdiv"></span>
        </div>-->
<!--        <div class="property-showing-request-form">
            <?php //echo $form = ActiveForm::begin(['action' => 'replay-feedback','method' => 'post', 'options' => ['autocomplete' => 'off', 'id' => 'property_request_replay_data']]); ?>
            <?php //echo $form->field($requestFeedback, 'showing_request_id')->hiddenInput(['maxlength' => true,'value' => $id, 'id' => 'showing_request_id'])->label(false) ?>
            <?php //echo $form->field($requestFeedback, 'property_id')->hiddenInput(['maxlength' => true,'value' => $propertyId])->label(false) ?>
            <?php //echo $form->field($requestFeedback, 'requested_to')->hiddenInput(['maxlength' => true,'value' => $requestTo])->label(false) ?>
            <?php //echo $form->field($requestFeedback, 'reply')->textarea(['rows' => 6,'style' => 'resize:none;']) ?>

            <div class="form-group">
                <?php //echo Html::button($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Replay'), ['class' => $model->isNewRecord ? 'btn btn-default red-btn bnt_save_property' : 'btn btn-primary bnt_replay_request']) ?>
            </div>
            <?php //echo ActiveForm::end(); ?>

        </div>-->
    </section>
</div>


