<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ElectricityTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Electricity Types');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="electricity-type-index">

    <p>
        <?= Html::a(Yii::t('app', 'Create Electricity Type'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',
            'status',
//            'created_at',
//            'updated_at',

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
                    }
                ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
