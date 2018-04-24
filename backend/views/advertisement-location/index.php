<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\AdvertisementLocation;
use common\models\AdvertisementLocationMaster;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel common\models\AdvertisementLocationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Advertisement Locations');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advertisement-location-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            ['attribute' => 'ad.user.fullName', 'label' => 'User'],
            'ad.title',
            ['attribute' => 'location_id', 'label' => 'Location',
                'value' => function($model){
                    return $model->location->title;
                },
                'filter' => ArrayHelper::map(AdvertisementLocationMaster::find()->active()->all(), 'id', 'title'),
            ],
            ['attribute' => 'status', 'filter' => [AdvertisementLocation::STATUS_ACTIVE => 'Active', AdvertisementLocation::STATUS_INACTIVE => 'Inactive']],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{status} {view} {delete}',
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
