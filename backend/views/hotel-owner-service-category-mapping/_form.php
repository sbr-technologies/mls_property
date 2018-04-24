<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\HotelOwnerServiceCategoryMapping */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hotel-owner-service-category-mapping-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'hotel_owner_id')->textInput() ?>

    <?= $form->field($model, 'service_category_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
