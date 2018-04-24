<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Profile;

/* @var $this yii\web\View */
/* @var $model common\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="box box-info">
<div class="user-search">

    <?php $form = ActiveForm::begin(['layout' => 'horizontal',
        'action' => ['send-to-user', 'id' => $id],
        'method' => 'get',
    ]); ?>
    <div class="box-body">

    <?= $form->field($model, 'profile_id')->dropDownList(ArrayHelper::map(Profile::find()->where(['id' => [3, 4, 5, 7]])->all(), 'id', 'title'), ['prompt' => 'All'])->label('Search by user type') ?>

    <?= $form->field($model, 'first_name')->label('Search by First name') ?>

    <?php echo $form->field($model, 'last_name')->label('Search by Last name') ?>

    <?php echo $form->field($model, 'email')->label('Search by Email') ?>
        
    <?php // echo $form->field($model, 'birthday') ?>

    </div>
    <div class="box-footer">
        <div class="col-sm-9">
    <div class="form-group pull-right">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
</div>