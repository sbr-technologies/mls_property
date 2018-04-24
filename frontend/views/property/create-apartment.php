<?php
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use common\models\PropertyApartment;
use yii\helpers\Html;
?>
<?php $form = ActiveForm::begin(['method' => 'post','options' => ['id' => 'frm_create_apartment']]); ?>
<?php 
$model->property_id = $propertyId;
?>
<?= Html::activeHiddenInput($model, 'property_id');?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">Add New Apartment</h4>
</div>
<div class="modal-body">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
        <?= $form->field($model, 'description')->textarea(['class' => 'form-control', 'rows' => 2, 'style' => 'resize:none;']) ?>
        <div class="row">
            <div class="col-sm-3">
                <?php echo $form->field($model, 'no_of_room')->dropDownList([1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5'], ['prompt' => 'Bedroom', 'class' => 'form-control']) ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'no_of_bathroom')->dropDownList([1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5'], ['prompt' => 'Bathroom', 'class' => 'form-control']) ?>
            </div>
            <div class="col-sm-3">
                <?php echo $form->field($model, 'no_of_toilet')->dropDownList([1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5'], ['prompt' => 'Toilet', 'class' => 'form-control']) ?>
            </div>
            <div class="col-sm-3">
                <?php
                $model->market_status = PropertyApartment::MARKET_ACTIVE;
                ?>
                <?= $form->field($model, 'no_of_garage')->dropDownList([1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5'], ['prompt' => 'Garage', 'class' => 'form-control']) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <?php echo $form->field($model, 'apt_category_id')->dropDownList([2 => 'For Sale', 1 => 'For Rent'], ['prompt' => 'Select Property Category', 'id' => 'property_category_id', 'onchange' => 'showHideDiv(this.value)']) ?>
            </div>
            <div class="col-sm-6">
                <?php
                $model->market_status = PropertyApartment::MARKET_ACTIVE;
                ?>
                <?= $form->field($model, 'market_status')->dropDownList([PropertyApartment::MARKET_ACTIVE => 'Active', PropertyApartment::MARKET_SOLD => 'Sold'], ['prompt' => 'Select Status', 'id' => 'market_status', 'onchange' => 'showHideSoldDiv(this.value)']) ?>
            </div>
        </div>
        <div id="soldDataDiv" style="display:none;">
            <div class="row">
                <div class="col-sm-6">
                    <?php
                    echo $form->field($model, 'soldDate')->widget(DatePicker::classname(), [
                        'options' => ['placeholder' => 'DD/MM/YYYY'],
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => Yii::$app->params['dateFormatJs'],
                            'endDate' => "+0d",
                            'todayHighlight' => true,
                        ]
                    ]);
                    ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'sold_price')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary bnt_create_apartment">Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
<?php ActiveForm::end()?>