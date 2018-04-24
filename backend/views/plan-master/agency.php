<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\ServiceCategory;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel common\models\PlanMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Office Plan Masters');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plan-master-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Plan'), ['/plan-master/agency-create'], ['class' => 'btn btn-success']) ?>
    </p>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            ['attribute' => 'service_category_id', 'label' => 'Service Category',
                'value' => function ($model){
                    return $model->serviceCategory->name;
                },
                'filter' => ArrayHelper::map(ServiceCategory::find()->all(), 'id', 'name')
            ],
            'title',
            'amount:currency',
            'status',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
