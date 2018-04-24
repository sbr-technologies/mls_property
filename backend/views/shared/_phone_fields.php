<?php
use yii\helpers\ArrayHelper;
use common\models\CallingCodeMaster;
if($model->isNewRecord){
    $model->calling_code = '+234';
    $model->calling_code2 = '+234';
    $model->calling_code3 = '+234';
    $model->calling_code4 = '+234';
}

$namePrefix = '';
if(isset($index) && $index !== null){
    $namePrefix = "[$index]";
}
?>
<div class="form-group">
    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, "{$namePrefix}calling_code")->dropDownList(ArrayHelper::map(CallingCodeMaster::find()->all(), 'code', 'name'), ['prompt' => 'Select Country', 'class' => 'form-control txt_calling_code']) ?>
        </div>

        <div class="col-sm-3">
            <?= $form->field($model, "{$namePrefix}mobile1")->textInput(['maxlength' => '15', 'class' => 'form-control txt_mobile1', 'placeholder' => 'e.g. 07056144444', 'onkeypress' => 'return isNumberKey(event)']) ?>
            <!--<span class="redTxt pull-right">Add Phone</span>-->
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, "{$namePrefix}office1")->textInput(['maxlength' => '15', 'class' => 'form-control txt_office1', 'placeholder' => 'e.g. 07056144444', 'onkeypress' => 'return isNumberKey(event)']) ?>
            <!--<span class="redTxt pull-right">Add Phone</span>-->
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, "{$namePrefix}fax1")->textInput(['maxlength' => '15', 'class' => 'form-control txt_fax1', 'placeholder' => 'e.g. 07056144444', 'onkeypress' => 'return isNumberKey(event)']) ?>
            <!--<span class="redTxt pull-right">Add Phone</span>-->
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, "{$namePrefix}calling_code2")->dropDownList(ArrayHelper::map(CallingCodeMaster::find()->all(), 'code', 'name'), ['prompt' => 'Select Country'], ['class' => 'selectpicker txt_calling_code2']) ?>
        </div>

        <div class="col-sm-3">
            <?= $form->field($model, "{$namePrefix}mobile2")->textInput(['maxlength' => '15', 'class' => 'form-control txt_mobile2', 'placeholder' => 'e.g. 07056144444', 'onkeypress' => 'return isNumberKey(event)']) ?>
            <!--<span class="redTxt pull-right">Add Phone</span>-->
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, "{$namePrefix}office2")->textInput(['maxlength' => '15', 'class' => 'form-control txt_office2', 'placeholder' => 'e.g. 07056144444', 'onkeypress' => 'return isNumberKey(event)']) ?>
            <!--<span class="redTxt pull-right">Add Phone</span>-->
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, "{$namePrefix}fax2")->textInput(['maxlength' => '15', 'class' => 'form-control txt_fax2', 'placeholder' => 'e.g. 07056144444', 'onkeypress' => 'return isNumberKey(event)']) ?>
            <!--<span class="redTxt pull-right">Add Phone</span>-->
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, "{$namePrefix}calling_code3")->dropDownList(ArrayHelper::map(CallingCodeMaster::find()->all(), 'code', 'name'), ['prompt' => 'Select Country'], ['class' => 'selectpicker txt_calling_code3']) ?>
        </div>

        <div class="col-sm-3">
            <?= $form->field($model, "{$namePrefix}mobile3")->textInput(['maxlength' => '15', 'class' => 'form-control txt_mobile3', 'placeholder' => 'e.g. 07056144444', 'onkeypress' => 'return isNumberKey(event)']) ?>
            <!--<span class="redTxt pull-right">Add Phone</span>-->
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, "{$namePrefix}office3")->textInput(['maxlength' => '15', 'class' => 'form-control txt_office3', 'placeholder' => 'e.g. 07056144444', 'onkeypress' => 'return isNumberKey(event)']) ?>
            <!--<span class="redTxt pull-right">Add Phone</span>-->
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, "{$namePrefix}fax3")->textInput(['maxlength' => '15', 'class' => 'form-control txt_fax3', 'placeholder' => 'e.g. 07056144444', 'onkeypress' => 'return isNumberKey(event)']) ?>
            <!--<span class="redTxt pull-right">Add Phone</span>-->
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, "{$namePrefix}calling_code4")->dropDownList(ArrayHelper::map(CallingCodeMaster::find()->all(), 'code', 'name'), ['prompt' => 'Select Country'], ['class' => 'selectpicker txt_calling_code4']) ?>
        </div>

        <div class="col-sm-3">
            <?= $form->field($model, "{$namePrefix}mobile4")->textInput(['maxlength' => '15', 'class' => 'form-control txt_mobile4', 'placeholder' => 'e.g. 07056144444', 'onkeypress' => 'return isNumberKey(event)']) ?>
            <!--<span class="redTxt pull-right">Add Phone</span>-->
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, "{$namePrefix}office4")->textInput(['maxlength' => '15', 'class' => 'form-control txt_office4', 'placeholder' => 'e.g. 07056144444', 'onkeypress' => 'return isNumberKey(event)']) ?>
            <!--<span class="redTxt pull-right">Add Phone</span>-->
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, "{$namePrefix}fax4")->textInput(['maxlength' => '15', 'class' => 'form-control txt_fax4', 'placeholder' => 'e.g. 07056144444', 'onkeypress' => 'return isNumberKey(event)']) ?>
            <!--<span class="redTxt pull-right">Add Phone</span>-->
        </div>
    </div>
</div>