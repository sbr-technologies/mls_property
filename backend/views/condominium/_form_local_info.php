<?php 
use yii\helpers\ArrayHelper;
use common\models\LocationLocalInfoTypeMaster;
//yii\helpers\VarDumper::dump($localInfoModel);die();
?>
<div class="property_local_info_container">
    <?php foreach ($localInfoModel as $i => $localInfo) { ?>
        <div class="row item new add-form-popup">
            <div class="form-group col-sm-6">
                <?= $form->field($localInfo, "[$i]id")->hiddenInput()->label(false) ?>
                <?= $form->field($localInfo, "[$i]lat")->hiddenInput(['class' => 'form-control lat_'])->label(false) ?>
                <?= $form->field($localInfo, "[$i]lng")->hiddenInput(['class' => 'form-control lng_'])->label(false) ?>
                <div class="form-group">
                    <?= $form->field($localInfo, "[$i]local_info_type_id")->dropDownList(ArrayHelper::map(LocationLocalInfoTypeMaster::find()->all(), 'id', 'title'), ['prompt' => 'Select Local Location']) ?>
                </div>
                <div class="form-group">
                    <?= $form->field($localInfo, "[$i]title")->textInput(['maxlength' => true]) ?>
                </div>
                <div class="form-group">
                    <?= $form->field($localInfo, "[$i]location")->textInput(['maxlength' => true,'class' => 'form-control geocomplete_local_info']) ?>
                </div>
            </div>
            <div class="form-group col-sm-6">
                <div class="form-group">
                    <?= $form->field($localInfo, "[$i]description")->textarea(['rows' => 8,'style' => 'resize:none;']) ?>
                </div>
            </div>
            <div class="">
                <?= $form->field($localInfo, "[$i]_destroy")->hiddenInput(['class' => 'hidin_child_id'])->label(false) ?>
                <?php if (!$localInfo->isNewRecord && $i > 0) { ?>
                    <a data-toggle="tooltip" class="btn btn_check_payment tooltip-test delete_child" title="" data-original-title="<?= Yii::t('app', 'Delete row') ?>"><i class="fa fa-trash-o"></i></a>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</div>