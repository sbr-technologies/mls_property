<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Agent */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Agents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agent-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'profile_id',
            'agency_id',
            'salutation',
            'first_name',
            'middle_name',
            'last_name',
            'username',
            'short_name',
            'lat',
            'lng',
            'auth_key',
            'password_hash',
            'password_reset_token',
            'email:email',
            'mobile1',
            'calling_code',
            'gender',
            'dob',
            'zip_code',
            'tagline',
            'profile_image_file_name',
            'profile_image_extension',
            'email_activation_key:email',
            'otp',
            'phone_verified',
            'email_verified:email',
            'email_activation_sent:email',
            'avg_rating',
            'total_reviews',
            'ip_address',
            'membership_id',
            'address1',
            'address2',
            'city',
            'state',
            'country',
            'social_id',
            'social_type',
            'slug',
            'timezone',
            'is_login_blocked',
            'login_blocked_at',
            'failed_login_cnt',
            'status',
            'intrest_in',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
