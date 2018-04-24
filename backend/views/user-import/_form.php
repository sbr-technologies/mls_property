<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UserImport*/
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-import-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'userCsv')->fileInput(['multiple' => false, 'accept' => 'csv/*']) ?>

    <div class="form-group">
        <?= Html::submitButton( Yii::t('app', 'Import'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
