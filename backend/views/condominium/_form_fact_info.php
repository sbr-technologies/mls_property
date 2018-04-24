<?php

use yii\helpers\ArrayHelper;
use common\models\FactMaster;
?>
<div class="property_fact_info_container">
<?php foreach ($factInfoModel as $i => $factInfo) { ?>
    <div class="item">
        <?= $form->field($factInfo, "[$i]id")->hiddenInput()->label(false); ?>
      
        <?= $form->field($factInfo, "[$i]fact_master_id")->dropDownList(ArrayHelper::map(FactMaster::find()->all(), 'id', 'title'), ['prompt' => 'Select Local Location']) ?>

        <?= $form->field($factInfo, "[$i]title")->textInput(['maxlength' => true]) ?>

        <?= $form->field($factInfo, "[$i]description")->textarea(['rows' => 3]) ?>
        
        <div class="">
        <?= $form->field($factInfo, "[$i]_destroy")->hiddenInput(['class' => 'hidin_child_id'])->label(false) ?>
        <?php if(!$factInfo->isNewRecord && $i > 0){?>
        <a data-toggle="tooltip" class="btn btn_check_payment tooltip-test delete_child" title="" data-original-title="<?= Yii::t('app', 'Delete row') ?>"><i class="fa fa-trash-o"></i></a>
        <?php }?>
        </div>
    </div>
<?php } ?>
</div>
<button class="btn_add_property_fact_info" type="button">Add new Feature Gallery</button>