<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\widgets\SocialLoginWidget;
use yii\web\View;

$this->title    =   'Request a Private Showing';
$this->params['breadcrumbs'][] = $this->title;
$timeArr        =   [];
if(!empty($openHouseData)){
    foreach($openHouseData as $open){
        $startTime  =   $open->start_time;
        $endTime    =   $open->end_time;
        $range=range(strtotime($startTime),strtotime($endTime),15*60);
        foreach($range as $time){
            $timeArr[date("H:i:00",$time)] = date("H:i",$time);
        }
        //echo "<pre>"; print_r($startTime."++".$endTime); echo "<pre>";
    }
}else{
    $startTime  =   "0:00";
    $endTime    =   "23:45";
    $range=range(strtotime($startTime),strtotime($endTime),15*60);
    foreach($range as $time){
        $timeArr[date("H:i:00",$time)] = date("H:i",$time);
    }
}
                        
?>

<div class="modal-body">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <!-- Login Sec -->
    <div class="login-box register-box">
        <div class="login-box-inner">
            <div class="login-box-header">
                <h2>Request a Private Showing</h2>
                <p><strong><?= $propertyData->formattedAddress ?></strong></p>
                <div class="register-top-bar">
                    <ul>
                        <li><i class="fa fa-circle" aria-hidden="true"></i><?= $propertyData->no_of_room ? $propertyData->no_of_room : "N/A" ?> Beds</li>
                        <li><i class="fa fa-circle" aria-hidden="true"></i> <?= $propertyData->no_of_bathroom ? $propertyData->no_of_bathroom : "N/A" ?> Baths</li>
                        <li><i class="fa fa-circle" aria-hidden="true"></i> <?= $propertyData->no_of_balcony ? $propertyData->no_of_balcony : "N/A" ?> Balcony</li>
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
            <?php $form = ActiveForm::begin(['method' => 'post','action' => ['rental/send-request-showing'],'options' => ['class' => 'private-request-form']]); ?>
            <?= $form->field($model, "model_id")->hiddenInput(['value'=> $propertyData->id])->label(false); ?>
            <?= $form->field($model, "request_to")->hiddenInput(['value'=> $propertyData->user_id])->label(false); ?>
                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <?= $form->field($model, 'name')->textInput(['maxlength' => true,'class'=>'form-control txt_field','placeholder'=> 'Full Name','value' => $userModel->fullName])->label(false) ?>
                        </div>

                        <div class="form-group">
                            <?= $form->field($model, 'email')->textInput(['maxlength' => true,'class'=>'form-control txt_field','placeholder'=> 'Email','value' => $userModel->email])->label(false) ?>
                        </div>

                        <div class="form-group">
                            <?= $form->field($model, 'phone')->textInput(['maxlength' => true,'class'=>'form-control txt_field','placeholder'=> 'Phone','value' => $userModel->mobile1])->label(false) ?>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-7">
                                    <?= $form->field($model, 'schedule')->widget(\kartik\date\DatePicker::className(), [
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                        'format' => Yii::$app->params['dateFormatJs']
                                    ]
                                ])?>
                                </div>
                                <div class="col-sm-5">
                                    <?= $form->field($model, 'time')->dropDownList($timeArr, ['prompt' => 'Time','class' => 'selectpicker']) ?>
                                </div>
                            </div>
                            
                            
                        </div>

                        <div class="form-group">
                            <?= $form->field($model, 'note')->textArea(['maxlength' => true,'class'=>'form-control txt_field','placeholder'=> 'Request date and time for showing'])->label(false) ?>
                            
                        </div>

                        <div class="form-group custom-check-radio">
                            <label>
                                <input type="checkbox" name="PropertyShowingRequest[is_lender]" checked="checked" value="1">
                                <span class="lbl">I want to get pre-approved by a lender.</span>
                            </label>
                        </div>

                        <div class="form-group text-center">
                            <button class="btn btn-default btn-main" type="submit" name="">Send Request</button>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <?php
                        if(!empty($propertyData->photos[0])){
                        ?>
                            <img src="<?= $propertyData->photos[0]->imageUrl ?>" alt="">
                        <?php
                        }else{
                            echo Html::img(Yii::getAlias('@uploadsUrl/banner_image/no_image_avaliable.png',['class' => 'img-responsive']));
                        }
                        ?>
                        <?php 
                        if(!empty($openHouseData)){
                        ?>
                         <h5>Open House</h5>
                         
                        <?php
                            foreach($openHouseData as $open){
                                ?>
                         <div class="open-hour-date">
                            <p>
                             Date Range :
                            <?php
                                echo $open->startdate."&nbsp;"; 
                            ?>
                             -
                            <?php
                                echo $open->enddate."&nbsp;"; 
                            ?>
                            </p>
                            <p>
                                Time Range : <?= $open->starttime ?> - <?= $open->endtime ?>
                            </p>
                            
                         </div>       
                             <?php   
                            }
                        }
                        ?>
                    </div>

                    <div class="col-sm-12 form-group text-center">
                        <p>By sending a request you agree to our Privacy Policy</p>
                    </div>
                </div>
            <?php ActiveForm::end(); ?>


        </div>


    </div>
    <!-- Login Sec -->
</div>

