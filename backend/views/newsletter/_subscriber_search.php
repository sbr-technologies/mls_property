<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
/* @var $this yii\web\View */
/* @var $model common\models\NewsletterEmailSubscriberSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="newsletter-email-subscriber-search">

    <?php $form = ActiveForm::begin(['layout' => 'horizontal',
        'action' => ['send-to-subscriber', 'id' => $id],
        'method' => 'get',
    ]); ?>
<div class="box-body">
    <?= $form->field($model, 'first_name')->label('Search By First Name') ?>

    <?= $form->field($model, 'last_name')->label('Search By Last Name') ?>

    <?php echo $form->field($model, 'email')->label('Search By Email') ?>

    <?php // echo $form->field($model, 'total_mail_sent') ?>

    <?php // echo $form->field($model, 'last_mail_sent_at') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

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
