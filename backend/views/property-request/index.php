<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\PropertyRequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Property Requests');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="property-request-index">

    <p>
        <?= Html::a(Yii::t('app', 'Create Property Request'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            [
                'attribute'=>'user_id',
                'label'=>'User',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->user->fullName;
                },
                'format'=>'raw'
            ],
            'property_category',
            [
                'attribute'=>'property_type_id',
                'label'=>'Property Type',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->propertyType->title;
                },
                'format'=>'raw'
            ],
            'budget_from',
            'budget_to',
            // 'no_of_bed_room',
            // 'state',
            // 'locality',
             'schedule:date',
             'status',
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
