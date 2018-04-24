<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Admins');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <p>
        <?= Html::a(Yii::t('app', 'Create Admin'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'profile.title',
            'salutation',
            'first_name',
            'last_name',
//             'username',
            // 'short_name',
            // 'lat',
            // 'lng',
            // 'location',
            // 'auth_key',
            // 'password_hash',
            // 'password_reset_token',
            'email:email',
            // 'mobile1',
            // 'calling_code',
            // 'gender',
            // 'dob',
            // 'zip_code',
            // 'tagline',
            // 'profile_image_file_name',
            // 'profile_image_extension',
            // 'email_activation_key:email',
            // 'otp',
            // 'phone_verified',
            // 'email_verified:email',
            // 'email_activation_sent:email',
            // 'avg_rating',
            // 'total_reviews',
            // 'ip_address',
            // 'membership_id',
            // 'address1',
            // 'address2',
            // 'city',
            // 'country',
            // 'social_id',
            // 'social_type',
            // 'slug',
            // 'timezone',
            // 'is_login_blocked',
            // 'login_blocked_at',
            // 'failed_login_cnt',
            // 'status',
            // 'created_by',
            // 'updated_by',
            // 'created_at',
            // 'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{status} {view} {update} {delete}',
                'buttons' => [
                    'status' => function ($url,$model) {
                        if($model->status == $model::STATUS_ACTIVE){
                            $class = 'fa fa-ban';
                            $title = 'Inactive';
                        }else{
                            $class = 'fa fa-check-circle-o';
                            $title = 'Active';
                        }
                        return Html::a(
                            '<span class="'.$class.'"></span>',
                            $url, 
                            [
                                'title' => $title,
                                'data-pjax' => '0',
                            ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
