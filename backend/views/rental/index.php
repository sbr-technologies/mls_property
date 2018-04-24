<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\RentalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Rentals');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rental-index">

    <p>
        <?= Html::a(Yii::t('app', 'Create Rental'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'reference_id',
            'user.profile.title',
            [
                'attribute'=>'user_id',
                'label'=>'User',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->user->fullName;
                },
                'format'=>'raw'
            ],
            'formattedAddress',
            //'description:ntext',
            'country',
            // 'state',
            // 'city',
            // 'address1',
            // 'address2',
            // 'lat',
            // 'lng',
            // 'zip_code',
            // 'land_mark',
            // 'near_buy_location',
            // 'metric_type_id',
            // 'size_range',
            // 'lot_area_range',
            // 'room_range',
            // 'balcony_range',
            // 'bathroom_range',
            // 'lift',
            // 'studio',
            // 'pet_friendly',
            // 'in_unit_laundry',
            // 'pools',
            // 'homes',
            // 'furnished',
            // 'water_availability',
            // 'status_of_electricity',
            // 'currency',
            // 'currency_symbol',
            // 'price',
            // 'property_video_link',
            // 'property_type_id',
            // 'property_category_id',
            // 'construction_status_id',
            // 'watermark_image',
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
