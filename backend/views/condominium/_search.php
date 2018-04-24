<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PropertySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="property-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'reference_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'agency_id') ?>

    <?= $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'slug') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'country') ?>

    <?php // echo $form->field($model, 'state') ?>

    <?php // echo $form->field($model, 'town') ?>

    <?php // echo $form->field($model, 'area') ?>

    <?php // echo $form->field($model, 'street_address') ?>

    <?php // echo $form->field($model, 'street_number') ?>

    <?php // echo $form->field($model, 'appartment_unit') ?>

    <?php // echo $form->field($model, 'sub_area') ?>

    <?php // echo $form->field($model, 'zip_code') ?>

    <?php // echo $form->field($model, 'local_govt_area') ?>

    <?php // echo $form->field($model, 'urban_town_area') ?>

    <?php // echo $form->field($model, 'district') ?>

    <?php // echo $form->field($model, 'lot_size') ?>

    <?php // echo $form->field($model, 'building_size') ?>

    <?php // echo $form->field($model, 'house_size') ?>

    <?php // echo $form->field($model, 'lat') ?>

    <?php // echo $form->field($model, 'lng') ?>

    <?php // echo $form->field($model, 'metric_type_id') ?>

    <?php // echo $form->field($model, 'no_of_room') ?>

    <?php // echo $form->field($model, 'no_of_bathroom') ?>

    <?php // echo $form->field($model, 'no_of_garage') ?>

    <?php // echo $form->field($model, 'no_of_toilet') ?>

    <?php // echo $form->field($model, 'no_of_boys_quater') ?>

    <?php // echo $form->field($model, 'year_built') ?>

    <?php // echo $form->field($model, 'sole_mandate') ?>

    <?php // echo $form->field($model, 'preimum_lisitng') ?>

    <?php // echo $form->field($model, 'virtual_link') ?>

    <?php // echo $form->field($model, 'featured') ?>

    <?php // echo $form->field($model, 'market_status') ?>

    <?php // echo $form->field($model, 'currency_id') ?>

    <?php // echo $form->field($model, 'currency_symbol') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'price_for') ?>

    <?php // echo $form->field($model, 'service_fee') ?>

    <?php // echo $form->field($model, 'service_fee_payment_term') ?>

    <?php // echo $form->field($model, 'other_fee') ?>

    <?php // echo $form->field($model, 'other_fee_payment_term') ?>

    <?php // echo $form->field($model, 'contact_term') ?>

    <?php // echo $form->field($model, 'tax') ?>

    <?php // echo $form->field($model, 'tax_for') ?>

    <?php // echo $form->field($model, 'insurance') ?>

    <?php // echo $form->field($model, 'insurance_for') ?>

    <?php // echo $form->field($model, 'hoa_fees') ?>

    <?php // echo $form->field($model, 'hoa_for') ?>

    <?php // echo $form->field($model, 'property_type_id') ?>

    <?php // echo $form->field($model, 'property_category_id') ?>

    <?php // echo $form->field($model, 'construction_status_id') ?>

    <?php // echo $form->field($model, 'avg_rating') ?>

    <?php // echo $form->field($model, 'total_reviews') ?>

    <?php // echo $form->field($model, 'rem_sent_at') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'is_seller_information_show') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
