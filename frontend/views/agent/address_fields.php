<?php 
use yii\helpers\Html;
?>
<div class="row">
    <div class="form-group col-sm-3">
        <?php
        echo Html::activeLabel($model, 'country');
        echo Html::activeTextInput($model, 'country', ['class' => 'form-control txt_country', 'disabled' => true]);
        ?>
    </div>
    <div class="form-group col-sm-3">
        <?php
        echo Html::activeLabel($model, 'state');
        echo Html::activeTextInput($model, 'state', ['class' => 'form-control txt_state', 'disabled' => true]);
        ?>
    </div>
    <div class="form-group col-sm-3">
        <?php
        echo Html::activeLabel($model, 'town');
        echo Html::activeTextInput($model, 'town', ['class' => 'form-control txt_town', 'disabled' => true]);
        ?>
    </div>
    <div class="form-group col-sm-3">

        <?php
        echo Html::activeLabel($model, 'area');
        echo Html::activeTextInput($model, 'area', ['class' => 'form-control txt_area', 'disabled' => true]);
        ?>

    </div>
</div>
<div class="row">
    <div class="form-group col-sm-3">
       <?php
        echo Html::activeLabel($model, 'street_address');
        echo Html::activeTextInput($model, 'street_address', ['class' => 'form-control txt_street_address', 'disabled' => true]);
        ?>
    </div>
    <div class="form-group col-sm-3">
        <?php
        echo Html::activeLabel($model, 'street_number');
        echo Html::activeTextInput($model, 'street_number', ['class' => 'form-control txt_street_number', 'disabled' => true]);
        ?>
    </div>
    <div class="form-group col-sm-3">
        <?php
        echo Html::activeLabel($model, 'appartment_unit');
        echo Html::activeTextInput($model, 'appartment_unit', ['class' => 'form-control txt_appartment_unit', 'disabled' => true]);
        ?>
    </div>
    <div class="form-group col-sm-3">
        <?php
        echo Html::activeLabel($model, 'sub_area');
        echo Html::activeTextInput($model, 'sub_area', ['class' => 'form-control txt_sub_area', 'disabled' => true]);
        ?>
    </div>
</div>
<div class="row">
    <div class="form-group col-sm-3">
        <?php
        echo Html::activeLabel($model, 'zip_code');
        echo Html::activeTextInput($model, 'zip_code', ['class' => 'form-control txt_zip_code', 'disabled' => true]);
        ?>
    </div>
    <div class="form-group col-sm-3">
        <?php
        echo Html::activeLabel($model, 'local_govt_area');
        echo Html::activeTextInput($model, 'local_govt_area', ['class' => 'form-control txt_local_govt_area', 'disabled' => true]);
        ?>
        <span class="local_govt_area_or">OR</span>
    </div> 
    <div class="form-group col-sm-3">
        <?php
        echo Html::activeLabel($model, 'urban_town_area');
        echo Html::activeTextInput($model, 'urban_town_area', ['class' => 'form-control txt_urban_town_area', 'disabled' => true]);
        ?>
    </div>
    <div class="form-group col-sm-3">
        <?php
        echo Html::activeLabel($model, 'district');
        echo Html::activeTextInput($model, 'district', ['class' => 'form-control txt_district', 'disabled' => true]);
        ?>
    </div>
</div>