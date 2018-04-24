<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\NewsletterEmailListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Subscriber Groups');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="newsletter-email-list-index">

    <p>
        <?= Html::a(Yii::t('app', 'Create Subscriber Group'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'title',
            'description:ntext',
            'last_mail_sent_at',
            'total_mail_sent',
            // 'status',
            // 'created_by',
            // 'updated_by',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
