<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\PhotoGallerySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Photo Galleries');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="photo-gallery-index">

    <p>
        <?= Html::a(Yii::t('app', 'Create Photo Gallery'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'model',
            'title',
            'size:shortSize',
            [
            'format' => 'html',
            'value' => function($model) {
                return Html::img($model->getImageurl($model::THUMBNAIL), ['width' => 60]);
            },
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{status} {view}',
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
