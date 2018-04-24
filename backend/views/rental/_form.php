<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\View;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use common\models\PropertyType;
use common\models\PropertyCategory;
use common\models\MetricType;
use common\models\ConstructionStatusMaster;
use common\models\User;
use common\models\Profile;
use yii\web\JsExpression;
use kartik\select2\Select2;
use common\models\TimezoneMaster;
use kartik\date\DatePicker;
use common\models\CurrencyMaster;
use common\models\LocationLocalInfoTypeMaster;
use common\models\RentalPlanType;
use common\models\RentalFeatureMaster;
use common\models\ElectricityType;



/* @var $this yii\web\View */
/* @var $model common\models\Rental */
/* @var $form yii\widgets\ActiveForm */
?>
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#property" aria-controls="property" role="tab" data-toggle="tab">Property Details</a></li>
    <li role="presentation"><a href="#localInfo" aria-controls="localInfo" role="tab" data-toggle="tab">Location Local Information</a></li>
    <li role="presentation"><a href="#metaTag" aria-controls="metaTag" role="tab" data-toggle="tab">Meta Tag</a></li>
    <li role="presentation"><a href="#rentalPlan" aria-controls="rentalPlan" role="tab" data-toggle="tab">Rental Plan</a></li>
    <li role="presentation"><a href="#rentalFeature" aria-controls="rentalFeature" role="tab" data-toggle="tab">Rental Feature</a></li>
    <li role="presentation"><a href="#openHouses" aria-controls="openHouses" role="tab" data-toggle="tab">Open Houses</a></li>
</ul>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data','class' => 'frm_geocomplete']]); ?>
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="property">
        <div class="rental-form">
            <?= $form->field($model, 'profile_id')->dropDownList(ArrayHelper::map(Profile::find()->where(['id' => [4, 5]])->all(), 'id', 'title'), ['prompt' => 'Select User type','id' => 'profile_id']) ?>         
            <?php
            echo $form->field($model, 'user_id')->widget(Select2::classname(), [
                'initValueText' => ($model->isNewRecord? '': $model->user->fullName), // set the initial display text
                'options' => ['placeholder' => 'Search for a User ...'],
        //                    'disabled' => true,
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 3,
                    'language' => [
                        'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                    ],
                    'ajax' => [
                        'url' => Url::to(['user/index']),
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term, type:"d", profile_id:$("#profile_id").val()}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(city) { return city.text; }'),
                    'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                ],
            ]);
            ?>
            
            <?= $form->field($model, 'property_type_id')->dropDownList(ArrayHelper::map(PropertyType::find()->where(['property_category_id' => 1])->active()->all(), 'id', 'title'), ['prompt' => 'Select type'])?>

            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

            <?php 
                echo $this->render('//shared/_address_fields', ['model' => $model, 'form' => $form]);
            ?>

            <?= $form->field($model, 'land_mark')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'near_buy_location')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'metric_type_id')->dropDownList(ArrayHelper::map(MetricType::find()->all(), 'id', 'name'), ['prompt' => 'Select Metric Type']) ?>

            <?= $form->field($model, 'size')->textInput() ?>
            
            <?= $form->field($model, 'size_max')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>

            <?= $form->field($model, 'lot_area')->textInput() ?>
            
            <?= $form->field($model, 'lot_area_max')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>

            <?= $form->field($model, 'no_of_room')->textInput() ?>
            
            <?= $form->field($model, 'no_of_room_max')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>

            <?= $form->field($model, 'no_of_balcony')->textInput() ?>
            
            <?= $form->field($model, 'no_of_balcony_max')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>

            <?= $form->field($model, 'no_of_bathroom')->textInput() ?>
            
             <?= $form->field($model, 'no_of_bathroom_max')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>

            <div class="checkbox-container clearfix">
                <?= $form->field($model, 'lift')->radioList(['1'=>'Yes',2=>'No'],['class' => 'custom-inline-radio']) ?>

                <?= $form->field($model, 'furnished')->radioList(['1'=>'Yes',2=>'No'],['class' => 'custom-inline-radio']) ?>

                <?= $form->field($model, 'water_availability')->radioList(['1'=>'Yes',2=>'No'],['class' => 'custom-inline-radio']) ?>
                
            </div>  
            <?= $form->field($model, 'electricityTypeIds')->checkBoxList(ArrayHelper::map(ElectricityType::find()->all(), 'id', 'name')) ?>

            <?= $form->field($model, 'studio')->dropDownList([$model::PET_FRIENDLY_YES => 'Yes', $model::PET_FRIENDLY_NO => 'No'],['prompt' => 'Select']) ?>

            <?= $form->field($model, 'pet_friendly')->dropDownList([$model::PET_FRIENDLY_YES => 'Yes', $model::PET_FRIENDLY_NO => 'No'],['prompt' => 'Select']) ?>

            <?= $form->field($model, 'in_unit_laundry')->dropDownList([$model::UNIT_LAUNDRY_YES => 'Yes', $model::UNIT_LAUNDRY_NO => 'No'],['prompt' => 'Select']) ?>

            <?= $form->field($model, 'pools')->dropDownList([$model::POOLS_YES => 'Yes', $model::POOLS_NO => 'No'],['prompt' => 'Select']) ?>

            <?= $form->field($model, 'homes')->dropDownList([$model::HOMES_YES => 'Yes', $model::HOMES_NO => 'No'],['prompt' => 'Select']) ?>
            
            
          
            <?= $form->field($model, 'currency_id')->dropDownList(ArrayHelper::map(CurrencyMaster::find()->active()->all(), 'id', 'name')) ?>
            
            <?= $form->field($model, 'rental_category')->dropDownList(['' => 'Select Rental Category', 'Rent' => 'Rent', 'Short Rent' => 'Short Rent']) ?>
            
            <?= $form->field($model, 'price_for')->dropDownList(['' => 'Select Price for', 'per Day' => 'per Day', 'per Month' => 'per Month', 'per Year' => 'per Year']) ?>
            
            <?= $form->field($model, 'price')->textInput() ?>
            
            <?= $form->field($model, 'service_fee_for')->dropDownList(['' => 'Select Price for', 'per Day' => 'per Day', 'per Month' => 'per Month', 'per Year' => 'per Year']) ?>
            
            <?= $form->field($model, 'service_fee')->textInput() ?>
            
            <?= $form->field($model, 'other_fee_for')->dropDownList(['' => 'Select Price for', 'per Day' => 'per Day', 'per Month' => 'per Month', 'per Year' => 'per Year']) ?>
            
            <?= $form->field($model, 'other_fee')->textInput() ?>

            <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>

            <?= $form->field($model, 'property_video_link')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'construction_status_id')->dropDownList(ArrayHelper::map(ConstructionStatusMaster::find()->all(), 'id', 'title'), ['prompt' => 'Select Construction Status']) ?>

            <?= $form->field($model, 'watermark_image')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'status')->dropDownList([$model::STATUS_ACTIVE => 'Active', $model::STATUS_INACTIVE => 'Inactive'],['prompt' => 'Select Status']) ?>

            <?php
                echo $this->render('//shared/_photo-gallery', ['model' => $model, 'delete' => true]);
            ?>

        </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="localInfo">
        <?php echo $this->render('_form_local_info', ['model' => $model, 'localInfoModel' => $localInfoModel, 'form' => $form])?>
    </div>
    <div role="tabpanel" class="tab-pane" id="metaTag">
        <?php echo $this->render('//shared/_meta-form', ['metaTagModel' => $metaTagModel, 'form' => $form])?>
    </div>
    <div role="tabpanel" class="tab-pane" id="rentalPlan">
        <?php echo $this->render('_form_rental_plan_info', ['model' => $model, 'rentalTypeModel' => $rentalTypeModel, 'form' => $form])?>
    </div>
    <div role="tabpanel" class="tab-pane" id="rentalFeature">
        <?php
            if($model->isNewRecord){
        ?>   
            <?php echo $this->render('_form_rental_feature_info', ['model' => $model, 'featureModel' => $featureModel,'featureItemModel' => $featureItemModel , 'form' => $form])?>
        <?php
            }else{
        ?>
            <?php echo $this->render('_form_rental_feature_info', ['model' => $model, 'featureModel' => $featureModel, 'form' => $form])?>
        <?php
            }
        ?>
    </div>
    <div role="tabpanel" class="tab-pane" id="openHouses">
        <div class="item">
            <?= $form->field($openHouseModel, "startdate")->textInput(['maxlength' => true,'class' => 'form-control datepkr']) ?>

            <?= $form->field($openHouseModel, "enddate")->textInput(['maxlength' => true,'class' => 'form-control datepkr']) ?>

            <?= $form->field($openHouseModel, "starttime")->textInput(['maxlength' => true,'class' => 'form-control timepicker']) ?>

            <?= $form->field($openHouseModel, "endtime")->textInput(['maxlength' => true,'class' => 'form-control timepicker']) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
<?php
$tempLoc    = new \common\models\RentalLocationLocalInfo();
$tempRental =   new common\models\RentalPlan();
$tempFeatrue    =   new \common\models\RentalFeature();
$tempItem       =   new \common\models\RentalFeatureItem();


//$startTime  = array_merge($stratHour,$stratMinute);

//\yii\helpers\VarDumper::dump($startTime);
//
//\yii\helpers\VarDumper::dump($endTime);

?>
<div style="display: none" class="dv_local_info_block_template">
    <div class="item new">
        <?= Html::activeHiddenInput($tempLoc, '[curTime]id')?>
        <?= Html::activeHiddenInput($tempLoc, '[curTime]lat', ['class' => 'lat_curTime'])?>
        <?= Html::activeHiddenInput($tempLoc, '[curTime]lng', ['class' => 'lng_curTime'])?>
        <div class="form-group">
        <?= Html::activeLabel($tempLoc, '[curTime]local_info_type_id')?>
        <?= Html::activeDropDownList($tempLoc, '[curTime]local_info_type_id', ArrayHelper::map(LocationLocalInfoTypeMaster::find()->all(), 'id', 'title'), ['prompt' => 'Select Local Location', 'class' => 'form-control'])?>
        </div>
        <div class="form-group">
            <?= Html::activeLabel($tempLoc, '[curTime]title')?>
            <?= Html::activeTextInput($tempLoc, '[curTime]title', ['class' => 'form-control'])?>
        </div>
        <div class="form-group">
            <?= Html::activeLabel($tempLoc, '[curTime]location')?>
            <?= Html::activeTextInput($tempLoc, '[curTime]location', ['class' => 'form-control geocomplete_local_info_curTime'])?>
        </div>
        <div class="form-group">
          <?= Html::activeLabel($tempLoc, '[curTime]description')?>
          <?= Html::activeTextarea($tempLoc, '[curTime]description', ['class' => 'form-control'])?>
        </div>
      
      <div class="">
        <?= Html::activeHiddenInput($tempLoc, "[curTime]_destroy", ['class' => 'hidin_child_id']) ?>
        <a data-toggle="tooltip" class="btn btn_check_payment tooltip-test delete_child" title="" data-original-title="<?= Yii::t('app', 'Delete row') ?>"><i class="fa fa-trash-o"></i></a>
      </div>
      
    </div>
</div>

<div style="display: none" class="dv_rental_plan_block_template">
    <div class="item new">
        <?= Html::activeHiddenInput($tempRental, '[curTime]id')?>
        
        <div class="form-group">
        <?= Html::activeLabel($tempRental, '[curTime]rental_plan_id')?>
        <?= Html::activeDropDownList($tempRental, '[curTime]rental_plan_id', ArrayHelper::map(RentalPlanType::find()->all(), 'id', 'name'), ['prompt' => 'Select Plan', 'class' => 'form-control'])?>
        </div>
        <div class="form-group">
            <?= Html::activeLabel($tempRental, '[curTime]name')?>
            <?= Html::activeTextInput($tempRental, '[curTime]name', ['class' => 'form-control'])?>
        </div>
        <div class="form-group">
            <?= Html::activeLabel($tempRental, '[curTime]bed')?>
            <?= Html::activeTextInput($tempRental, '[curTime]bed', ['class' => 'form-control'])?>
        </div>
        <div class="form-group">
            <?= Html::activeLabel($tempRental, '[curTime]bath')?>
            <?= Html::activeTextInput($tempRental, '[curTime]bath', ['class' => 'form-control'])?>
        </div>
        <div class="form-group">
            <?= Html::activeLabel($tempRental, '[curTime]size')?>
            <?= Html::activeTextInput($tempRental, '[curTime]size', ['class' => 'form-control'])?>
        </div>
        <div class="form-group">
            <?= Html::activeLabel($tempRental, '[curTime]price')?>
            <?= Html::activeTextInput($tempRental, '[curTime]price', ['class' => 'form-control'])?>
        </div>
      <div class="">
        <?= Html::activeHiddenInput($tempRental, "[curTime]_destroy", ['class' => 'hidin_child_id']) ?>
        <a data-toggle="tooltip" class="btn btn_check_payment tooltip-test delete_child" title="" data-original-title="<?= Yii::t('app', 'Delete row') ?>"><i class="fa fa-trash-o"></i></a>
      </div>
      
    </div>
</div>
<div style="display: none" class="dv_rental_feature_block_template">
    <div class="item new">
        <?= Html::activeHiddenInput($tempFeatrue, '[curTime]id')?>
        <div class="form-group">
            <?= Html::activeLabel($tempFeatrue, '[curTime]feature_master_id')?>
            <?= Html::activeDropDownList($tempFeatrue, '[curTime]feature_master_id', ArrayHelper::map(RentalFeatureMaster::find()->all(), 'id', 'name'), ['prompt' => 'Select Feature', 'class' => 'form-control'])?>
        </div>
        <div class="form-group">
            <?= Html::activeHiddenInput($tempItem, '[curTime][1]id')?>
            <?= Html::activeLabel($tempItem, '[curTime][1]name')?>
            <?= Html::activeTextInput($tempItem, '[curTime][1]name', ['class' => 'form-control'])?>
        </div>
        <div class="form-group">
            <?= Html::activeHiddenInput($tempItem, '[curTime][2]id')?>
            <?= Html::activeLabel($tempItem, '[curTime][2]name')?>
            <?= Html::activeTextInput($tempItem, '[curTime][2]name', ['class' => 'form-control'])?>
        </div>
        <div class="form-group">
            <?= Html::activeHiddenInput($tempItem, '[curTime][3]id')?>
            <?= Html::activeLabel($tempItem, '[curTime][3]name')?>
            <?= Html::activeTextInput($tempItem, '[curTime][3]name', ['class' => 'form-control'])?>
        </div>
        <div class="form-group">
            <?= Html::activeHiddenInput($tempItem, '[curTime][4]id')?>
            <?= Html::activeLabel($tempItem, '[curTime][4]name')?>
            <?= Html::activeTextInput($tempItem, '[curTime][4]name', ['class' => 'form-control'])?>
        </div>
        <div class="form-group">
            <?= Html::activeHiddenInput($tempItem, '[curTime][5]id')?>
            <?= Html::activeLabel($tempItem, '[curTime][5]name')?>
            <?= Html::activeTextInput($tempItem, '[curTime][5]name', ['class' => 'form-control'])?>
        </div>
        <div class="">
          <?= Html::activeHiddenInput($tempFeatrue, "[curTime]_destroy", ['class' => 'hidin_child_id']) ?>
          <a data-toggle="tooltip" class="btn btn_check_payment tooltip-test delete_child" title="" data-original-title="<?= Yii::t('app', 'Delete row') ?>"><i class="fa fa-trash-o"></i></a>
        </div>
    </div>
</div>
