<?php 
use yii\helpers\ArrayHelper;
use common\models\RentalPlanType;
//yii\helpers\VarDumper::dump($model->propertyLocationLocalInfo);die();
?>
<div class="property_rental_plan_container">
    <?php foreach ($rentalTypeModel as $i => $rentalType) { ?>
        <div class="item">
            <?= $form->field($rentalType, "[$i]id")->hiddenInput()->label(false) ?>

            <?= $form->field($rentalType, "[$i]rental_plan_id")->dropDownList(ArrayHelper::map(RentalPlanType::find()->all(), 'id', 'name'), ['prompt' => 'Select Plan']) ?>

            <?= $form->field($rentalType, "[$i]name")->textInput(['maxlength' => true]) ?>
            
            <?= $form->field($rentalType, "[$i]bed")->textInput(['maxlength' => true]) ?> 
            
            <?= $form->field($rentalType, "[$i]bath")->textInput(['maxlength' => true]) ?> 
            
            <?= $form->field($rentalType, "[$i]size")->textInput(['maxlength' => true]) ?>
            
            <?= $form->field($rentalType, "[$i]price")->textInput(['maxlength' => true]) ?>
            
            <div class="">
                <?= $form->field($rentalType, "[$i]_destroy")->hiddenInput(['class' => 'hidin_child_id'])->label(false) ?>
                <?php if (!$rentalType->isNewRecord && $i > 0) { ?>
                    <a data-toggle="tooltip" class="btn btn_check_payment tooltip-test delete_child" title="" data-original-title="<?= Yii::t('app', 'Delete row') ?>"><i class="fa fa-trash-o"></i></a>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</div>
<button class="btn_add_rental_plan_info" type="button">Add Another</button>