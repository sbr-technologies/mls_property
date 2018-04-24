<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'profile_id') ?>

    <?= $form->field($model, 'salutation') ?>

    <?= $form->field($model, 'first_name') ?>

    <?= $form->field($model, 'middle_name') ?>

    <?php // echo $form->field($model, 'last_name') ?>

    <?php // echo $form->field($model, 'username') ?>

    <?php // echo $form->field($model, 'short_name') ?>

    <?php // echo $form->field($model, 'lat') ?>

    <?php // echo $form->field($model, 'lng') ?>

    <?php // echo $form->field($model, 'location') ?>

    <?php // echo $form->field($model, 'auth_key') ?>

    <?php // echo $form->field($model, 'password_hash') ?>

    <?php // echo $form->field($model, 'password_reset_token') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'mobile1') ?>

    <?php // echo $form->field($model, 'calling_code') ?>

    <?php // echo $form->field($model, 'gender') ?>

    <?php // echo $form->field($model, 'dob') ?>

    <?php // echo $form->field($model, 'zip_code') ?>

    <?php // echo $form->field($model, 'tagline') ?>

    <?php // echo $form->field($model, 'profile_image_file_name') ?>

    <?php // echo $form->field($model, 'profile_image_extension') ?>

    <?php // echo $form->field($model, 'email_activation_key') ?>

    <?php // echo $form->field($model, 'otp') ?>

    <?php // echo $form->field($model, 'phone_verified') ?>

    <?php // echo $form->field($model, 'email_verified') ?>

    <?php // echo $form->field($model, 'email_activation_sent') ?>

    <?php // echo $form->field($model, 'avg_rating') ?>

    <?php // echo $form->field($model, 'total_reviews') ?>

    <?php // echo $form->field($model, 'ip_address') ?>

    <?php // echo $form->field($model, 'membership_id') ?>

    <?php // echo $form->field($model, 'address1') ?>

    <?php // echo $form->field($model, 'address2') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'country') ?>

    <?php // echo $form->field($model, 'social_id') ?>

    <?php // echo $form->field($model, 'social_type') ?>

    <?php // echo $form->field($model, 'slug') ?>

    <?php // echo $form->field($model, 'timezone') ?>

    <?php // echo $form->field($model, 'is_login_blocked') ?>

    <?php // echo $form->field($model, 'login_blocked_at') ?>

    <?php // echo $form->field($model, 'failed_login_cnt') ?>

    <?php // echo $form->field($model, 'status') ?>

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
