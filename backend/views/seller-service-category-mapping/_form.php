<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SellerServiceCategoryMapping */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="seller-service-category-mapping-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'seller_id')->textInput() ?>

    <?= $form->field($model, 'service_category_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
