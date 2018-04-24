<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&key=<?= Yii::$app->params['googleMapKey']?>"></script>
<?php
//$this->registerJsFile(
//    'http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places'
//);

$this->registerJsFile(
    '@web/js/jquery.geocomplete.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->registerJsFile(
    '@web/js/location.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>
<?= $form->field($model, 'location')->textInput(['maxlength' => true, 'class'=> 'form-control','id' => 'geocomplete']) ?>

<?= $form->field($model, 'lat')->hiddenInput(['class' => 'lat'])->label(false) ?>
<?= $form->field($model, 'lng')->hiddenInput(['class' => 'lng'])->label(false) ?>

<?= $form->field($model, 'country')->textInput(['maxlength' => true, 'class' => 'country form-control']) ?>
<?= $form->field($model, 'state')->textInput(['class' => 'administrative_area_level_1 form-control']) ?>
<?= $form->field($model, 'town')->textInput(['maxlength' => true, 'class' => 'locality small-height-textarea form-control']) ?>
<?= $form->field($model, 'area')->textInput(['maxlength' => true, 'class' => 'route form-control']) ?>
<?= $form->field($model, 'street_address')->textInput(['maxlength' => true, 'class' => 'formatted_address small-height-textarea form-control']) ?>
<?= $form->field($model, 'street_number')->textInput(['maxlength' => true, 'class' => 'street_number small-height-textarea form-control']) ?>
<?= $form->field($model, 'sub_area')->textInput(['maxlength' => true, 'class' => 'sublocality form-control']) ?>
<?= $form->field($model, 'zip_code')->textInput(['maxlength' => true, 'class' => 'postal_code small-height-textarea form-control']) ?>
<?= $form->field($model, 'local_govt_area')->textInput(['maxlength' => true, 'class' => 'small-height-textarea form-control']) ?>
<?= $form->field($model, 'urban_town_area')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
<?= $form->field($model, 'district')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
 