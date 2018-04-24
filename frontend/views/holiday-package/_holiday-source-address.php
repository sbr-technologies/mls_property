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

<div class="source_details">
    <?= Html::activeHiddenInput($model, 'source_lat', ['class' => 'form-control', 'data-geo' => 'lat']) ?>
    <?= Html::activeHiddenInput($model, 'source_lng', ['class' => 'form-control', 'data-geo' => 'lng']) ?>
    <?= $form->field($model, 'source_location')->textInput(['maxlength' => true, 'id' => 'geocomplete_source']) ?>

    <?= $form->field($model, 'source_address')->textInput(['maxlength' => true, 'class' => 'form-control', 'data-geo' => 'name']) ?>

    <?= $form->field($model, 'source_city')->textInput(['maxlength' => true, 'class' => 'form-control', 'data-geo' => 'locality']) ?>

    <?= Html::activeHiddenInput($model, 'source_state', ['class' => 'form-control', 'data-geo' => 'administrative_area_level_1_short']) ?>
    <?= $form->field($model, 'source_state_long')->textInput(['class' => 'form-control', 'data-geo' => 'administrative_area_level_1']) ?>

    <?= $form->field($model, 'source_country')->textInput(['maxlength' => true, 'class' => 'form-control', 'data-geo' => 'country']) ?>
</div>



