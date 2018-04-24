<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PropertyRequestSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="property-request-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'property_category_id') ?>

    <?= $form->field($model, 'property_type_id') ?>

    <?= $form->field($model, 'budget') ?>

    <?php // echo $form->field($model, 'no_of_bed_room') ?>

    <?php // echo $form->field($model, 'state') ?>

    <?php // echo $form->field($model, 'locality') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
