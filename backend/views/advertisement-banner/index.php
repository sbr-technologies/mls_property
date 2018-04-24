<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

use common\models\PhotoGallery;
/* @var $this yii\web\View */
/* @var $searchModel common\models\AdvertisementBannerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$adId = null;
$parms = Yii::$app->request->queryParams;
if(isset($parms['AdvertisementBannerSearch']['ad_id']))
    $adId = $parms['AdvertisementBannerSearch']['ad_id'];
$this->title = Yii::t('app', 'Advertisement Banners');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advertisement-banner-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Advertisement Banner'), ['create', 'ad_id' => $adId], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'ad.title',
            'title',
            'description:ntext',
            [
                'attribute' => 'photo',
                'format' => 'html',
                'value' => function($model){
                    return Html::img($model->photo->getImageUrl(PhotoGallery::THUMBNAIL), ['width' => 60]);
                }
            ],
            //'image_file_name',
            // 'image_file_extension',
            // 'text_color',
            // 'sort_order',
            // 'status',

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
<?php Pjax::end(); ?>
</div>
