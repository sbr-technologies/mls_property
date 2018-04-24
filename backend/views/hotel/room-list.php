<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\HotelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Hotel Rooms');

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Hotel'), 'url' => ['index']];

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="hotel-index">
    <p>
        <?= Html::a(Yii::t('app', 'Create Room'), ['create-room','hotel_id'=>$id], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            'hotel.name',
            'roomType.name',
            //'description:ntext',
            'name',
            'floor_name',
            'isAc',
            'status',
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
                'template' => '{room-status}  {room-view}  {room-update}  {room-delete}',
                'buttons' => [
                    'room-status' => function ($url,$model) {
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
                    'room-view' => function ($url,$model) {
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
                    'room-update' => function ($url,$model) {
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
                    'room-delete' => function ($url,$model) {
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
