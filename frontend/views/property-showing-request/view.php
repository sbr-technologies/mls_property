<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

$this->title = 'Showing Request';

$this->registerJsFile(
    '@web/js/property_showing_request.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$curentUserId = Yii::$app->user->id;
?>
<div class="content-wrapper">
    <!-- Content Title Sec -->
    <section class="content-header">
        <h1><?php echo $this->title ?></h1>
        <ol class="breadcrumb">
            <li><a href="<?= yii\helpers\Url::to(['/property-showing-request'])?>"><i class="fa fa-home" aria-hidden="true"></i>Showing Requests</a></li>
            <li class="active"><?php echo $this->title ?></li>
        </ol>
    </section>
    <!-- Content Title Sec -->

    <!-- Main content -->
    <section class="content">
        <div class="manage-profile-sec">
            <table class="table table-bordered table-striped" width="100%">
                <tbody>
                    <?php if($model->user_id == $curentUserId){?>
                    <tr>
                        <th width="50%">Listing Agent/Seller</th>
                        <td><?= $model->property->user->fullName ?></td>
                    </tr>
                    <tr>
                        <th width="50%">Email</th>
                        <td><?= $model->property->user->email ?></td>
                    </tr>
                    <tr>
                        <th width="50%">Phone</th>
                        <td><?= $model->property->user->getMobile1() ?></td>
                    </tr>
                    <?php if(isset($model->property->user->agency)){?>
                    <tr>
                        <th width="50%">Agency</th>
                        <td><?= $model->property->user->agency->name ?></td>
                    </tr>
                    <?php }?>
                    <?php }else{?>
                    <tr>
                        <th width="50%">Showing Request By</th>
                        <td><?= $model->user->fullName ?></td>
                    </tr>
                    <tr>
                        <th width="50%">Email</th>
                        <td><?= $model->user->email ?></td>
                    </tr>
                    <tr>
                        <th width="50%">Phone</th>
                        <td><?= $model->user->getMobile1() ?></td>
                    </tr>
                    <?php if(isset($model->user->agency)){?>
                    <tr>
                        <th width="50%">Agency</th>
                        <td><?= $model->user->agency->name ?></td>
                    </tr>
                    <?php }?>
                    <?php }?>
                    
                    <tr>
                        <th width="50%">Property Address</th>
                        <td><?= $model->property ? $model->property->formattedAddress : "" ?></td>
                    </tr>
                    <tr>
                        <th width="50%">Showing Date</th>
                        <td><?= Yii::$app->formatter->asDate($model->schedule)  ?></td>
                    </tr>
                     <tr>
                        <th width="50%">Showing Time</th>
                        <td><?= date("h:i A",$model->schedule).' - '.  date("h:i A",$model->schedule_end)?></td>
                    </tr>
                    <tr>
                        <th width="50%">Date and Time stamped Request made</th>
                        <td><?= Yii::$app->formatter->asDatetime($model->created_at);  ?></td>
                    </tr>
                    <tr>
                        <th width="50%">Need lender for Pre Approval?</th>
                        <td><?= $model->needLender  ?></td>
                    </tr>
                    <tr>
                        <th width="50%">Note</th>
                        <td class="text-capitalize"><?= $model->note  ?></td>
                    </tr>
                    <tr>
                        <th width="50%">Status</th>
                        <td class="text-capitalize"><?= $model->status  ?></td>
                    </tr>
                </tbody>
            </table>
            
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
            <?php $form = ActiveForm::begin(['action' => 'replay-feedback','method' => 'post', 'options' => ['autocomplete' => 'off', 'id' => 'property_request_replay_data']]); ?>
            <?= $form->field($requestFeedback, 'showing_request_id')->hiddenInput(['maxlength' => true,'value' => $id, 'id' => 'showing_request_id'])->label(false) ?>
            <?= $form->field($requestFeedback, 'model_id')->hiddenInput(['maxlength' => true,'value' => $propertyId])->label(false) ?>
            <?= $form->field($requestFeedback, 'model')->hiddenInput(['maxlength' => true,'value' => $modelName])->label(false) ?>
            <?= $form->field($requestFeedback, 'requested_to')->hiddenInput(['maxlength' => true,'value' => $requestTo])->label(false) ?>
            <?= $form->field($requestFeedback, 'reply')->textarea(['rows' => 6,'style' => 'resize:none;']) ?>
            <div class="form-group">
                <?= Html::button(Yii::t('app', 'Send'), ['btn btn-primary bnt_replay_request']) ?>
            </div>
            <?php ActiveForm::end(); ?>

        </div>
    </section>
</div>


