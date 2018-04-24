<?php 
use yii\helpers\ArrayHelper;
use common\models\LocationLocalInfoTypeMaster;
//yii\helpers\VarDumper::dump($model->propertyLocationLocalInfo);die();
?>
<div class="dv_hotel_booking_guest_info_container">
<?php foreach ($guestModels as $i => $guest){?>
<div class="item">
    <?= $form->field($guest, "[$i]id")->hiddenInput()->label(false) ?>
  
    <?= $form->field($guest, "[$i]first_name")->textInput(['maxlength' => true]) ?>

    <?= $form->field($guest, "[$i]last_name")->textInput(['maxlength' => true]) ?>

    <?= $form->field($guest, "[$i]middle_name")->textInput(['maxlength' => true]) ?>

    <?= $form->field($guest, "[$i]gender")->dropDownList([$guest::GENDER_MALE => 'Male', $guest::GENDER_FEMALE => 'Female'],['prompt' => 'Select Gender']) ?>

    <?= $form->field($guest, "[$i]age")->textInput() ?>
    <div class="">
        <?= $form->field($guest, "[$i]_destroy")->hiddenInput(['class' => 'hidin_child_id'])->label(false) ?>
        <?php if(!$guest->isNewRecord && $i > 0){?>
        <a data-toggle="tooltip" class="btn btn_check_payment tooltip-test delete_child" title="" data-original-title="<?= Yii::t('app','Delete row')?>"><i class="fa fa-trash-o"></i></a>
        <?php }?>
    </div>
</div>
<?php }?>
</div>
<button class="btn_add_hotel_booking_guest_info" type="button">Add Another</button>