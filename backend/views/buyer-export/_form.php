<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Buyer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="buyer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'profile_id')->textInput() ?>

    <?= $form->field($model, 'agency_id')->textInput() ?>

    <?= $form->field($model, 'salutation')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'short_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lat')->textInput() ?>

    <?= $form->field($model, 'lng')->textInput() ?>

    <?= $form->field($model, 'auth_key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password_hash')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password_reset_token')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mobile1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'calling_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gender')->textInput() ?>

    <?= $form->field($model, 'zip_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tagline')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'profile_image_extension')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email_activation_key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'otp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone_verified')->textInput() ?>

    <?= $form->field($model, 'email_verified')->textInput() ?>

    <?= $form->field($model, 'email_activation_sent')->textInput() ?>

    <?= $form->field($model, 'avg_rating')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total_reviews')->textInput() ?>

    <?= $form->field($model, 'ip_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'membership_id')->textInput() ?>

    <?= $form->field($model, 'address1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'state')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'social_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'social_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'timezone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_login_blocked')->textInput() ?>

    <?= $form->field($model, 'login_blocked_at')->textInput() ?>

    <?= $form->field($model, 'failed_login_cnt')->textInput() ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'intrest_in')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
