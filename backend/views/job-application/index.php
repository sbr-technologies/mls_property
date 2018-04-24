<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\JobApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Job Applications');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-application-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           
            'first_name',
            'middle_name',
            'last_name',
            'email:email',
            // 'calling_code',
            // 'mobile1',
            // 'gender',
            // 'dob',
            // 'zip_code',
            // 'ip_address',
            // 'status',
            // 'created_by',
            // 'updated_by',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
