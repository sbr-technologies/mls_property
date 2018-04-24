<?php
use yii\helpers\Html;
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


<?= $form->field($model, 'destination_location')->textInput(['maxlength' => true, 'id' => 'geocomplete_destination']) ?>
<div class="dest_details">
    <?= Html::activeHiddenInput($model, 'destination_lat', ['class' => 'form-control', 'data-geo' => 'lat']) ?>
    <?= Html::activeHiddenInput($model, 'destination_lng', ['class' => 'form-control', 'data-geo' => 'lng']) ?>
    <?= Html::activeHiddenInput($model, 'destination_state', ['class' => 'form-control', 'data-geo' => 'administrative_area_level_1_short']) ?>
    <?= $form->field($model, 'destination_address')->textInput(['maxlength' => true, 'class' => 'form-control', 'data-geo' => 'name']) ?>

    <?= $form->field($model, 'destination_city')->textInput(['maxlength' => true, 'class' => 'form-control', 'data-geo' => 'locality']) ?>

    <?= $form->field($model, 'destination_state_long')->textInput(['maxlength' => true, 'class' => 'form-control', 'data-geo' => 'administrative_area_level_1']) ?>

    <?= $form->field($model, 'destination_country')->textInput(['maxlength' => true, 'class' => 'form-control', 'data-geo' => 'country']) ?>
</div>



