<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\TestimonialSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Testimonials');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="testimonial-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Testimonial'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
            'attribute'=>'user_id',
            'label'=>'User',
            'value'=>function ($model, $key, $index, $widget) {
                return $model->user->fullName;
            },
            'format'=>'raw'
            ],
//            'model',
//            'model_id',
            'title',
             'rating',
             'status',

            [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{status} {view} {update} {delete}',
            'buttons' => [
                'status' => function ($url,$model) {
                    if($model->status == $model::STATUS_APPROVED){
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
