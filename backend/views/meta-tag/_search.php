<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MetaTagSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="meta-tag-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'model') ?>

    <?= $form->field($model, 'model_id') ?>

    <?= $form->field($model, 'page_title') ?>

    <?= $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'keywords') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
