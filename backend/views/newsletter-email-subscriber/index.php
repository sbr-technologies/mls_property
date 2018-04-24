<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\NewsletterEmailSubscriberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Newsletter Email Subscribers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="newsletter-email-subscriber-index">

    <p>
        <?= Html::a(Yii::t('app', 'Create Newsletter Email Subscriber'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'first_name',
            'middle_name',
            'last_name',
            'email:email',
            // 'total_mail_sent',
            // 'last_mail_sent_at',
            // 'status',
            // 'created_by',
            // 'updated_by',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
