<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\HotelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Holiday Package Itineray');

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Holday Package'), 'url' => ['index']];

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="hotel-index">
    <p>
        <?= Html::a(Yii::t('app', 'Create Itinerary'), ['create-itinerary','holiday_package_id'=>$id], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            'holidayPackage.name',
            'days_name',
            //'description:ntext',
            'title',
            'city',
            'state',
           // 'status',
            // 'city',
            // 'address1',
            // 'address2',
            // 'zip_code',
            // 'lat',
            // 'lng',
            // 'estd',
            // 'status',
            // 'created_by',
            // 'updated_by',
            // 'created_at',
            // 'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{itinerary-view}  {itinerary-update}  {itinerary-delete}',
                'buttons' => [
                    'itinerary-view' => function ($url,$model) {
                        $class = 'fa fa-eye';
                        $title = 'View Room';
                        return Html::a(
                            '<span class="'.$class.'"></span>',
                            $url, 
                            [
                                'title' => $title,
                                'data-pjax' => '0',
                            ]
                        );
                    },
                    'itinerary-update' => function ($url,$model) {
                        $class = 'fa fa-pencil';
                        $title = 'Update Room';
                        return Html::a(
                            '<span class="'.$class.'"></span>',
                            $url, 
                            [
                                'title' => $title,
                                'data-pjax' => '0',
                            ]
                        );
                    },
                    'itinerary-delete' => function ($url,$model) {
                        $class = 'fa fa-trash-o';
                        $title = 'Delete Room';
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
