<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\BlogCommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Blog Comments');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-comment-index">


    <p>
        <?= Html::a(Yii::t('app', 'Create Blog Comment'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'post.title',
            'title',
            'content:ntext',
            'status',
            // 'created_by',
            // 'updated_by',
            // 'created_at',
            // 'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{agency} {status} {view} {update} {delete}',
                'buttons' => [
                    'status' => function ($url,$model) {
                        if($model->status == $model::STATUS_PENDING){
                            $class = 'fa fa-check-circle-o';
                            $title = 'Active';
                        }else{
                            $class = 'fa fa-ban';
                            $title = 'Inactive';
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
