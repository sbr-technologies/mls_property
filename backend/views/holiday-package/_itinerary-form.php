<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&key=<?= Yii::$app->params['googleMapKey']?>"></script>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\models\HolidayPackageItinerary;



/* @var $this yii\web\View */
/* @var $itineraryModel common\models\Hotel */
/* @var $form yii\widgets\ActiveForm */



$this->registerJsFile(
    '@web/js/jquery.geocomplete.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile(
    '@web/js/location.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

for ($dd = 1; $dd <= 30; $dd++){
    $daysNameArr[$dd." Day"] = $dd." Day";
}
//yii\helpers\VarDumper::dump($daysNameArr); exit;
?>
<!-- Nav tabs -->
  
<?php $form = ActiveForm::begin(['options' => ['class' => 'frm_geocomplete']]); ?>
    <?= $form->field($itineraryModel, 'holiday_package_id')->hiddenInput(['maxlength' => true,'value' => $holiday_package_id])->label(false) ?>
    <div class="tab-content">
        <div class="hotel-form">
            <?= $form->field($itineraryModel, 'days_name')->dropDownList($daysNameArr,['prompt'=>'Select']) ?>

            <?= $form->field($itineraryModel, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($itineraryModel, 'description')->textarea(['rows' => 6]) ?>
            
            <?= $form->field($itineraryModel, 'location')->textInput(['maxlength' => true, 'id' => 'geocomplete']) ?>

            <?= $form->field($itineraryModel, 'address')->textInput(['maxlength' => true, 'class' => 'name form-control']) ?>

            <?= $form->field($itineraryModel, 'city')->textInput(['maxlength' => true, 'class' => 'locality form-control']) ?>

            <?= $form->field($itineraryModel, 'state')->textInput(['maxlength' => true, 'class' => 'administrative_area_level_1_short form-control']) ?>

            <?= $form->field($itineraryModel, 'country')->textInput(['maxlength' => true, 'class' => 'country form-control']) ?>
            
            <?= $form->field($itineraryModel, "imageFiles[]")->fileInput(['multiple' => false, 'accept' => 'image/*']) ?>

            <?php 
                echo $this->render('//shared/_photo-gallery', ['model' => $itineraryModel, 'delete' => true]);
            ?>
        </div>
        
        <div class="form-group">
            <?= Html::submitButton($itineraryModel->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $itineraryModel->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>
