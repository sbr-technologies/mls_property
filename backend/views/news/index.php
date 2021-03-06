<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\NewsCategory;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel common\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'News');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <p>
        <?= Html::a(Yii::t('app', 'Create News'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            ['attribute' =>'news_category_id', 'label' => 'Category', 
//                'filter'=>ArrayHelper::map(Agency::find()->active()->asArray()->all(), 'id', 'name'),
            'filter' => Select2::widget([
                'model' => $searchModel,
                'attribute' => 'news_category_id',
                'data' => ArrayHelper::map(NewsCategory::find()->active()->orderBy(['name' => SORT_ASC])->asArray()->all(), 'id', 'name'),
                'theme' => Select2::THEME_BOOTSTRAP,
//                'hideSearch' => true,
                'options' => [
                    'placeholder' => 'Filter by category',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]),
            'value' => function($model){
                return $model->newsCategory->name;
            }],
//            'newsCategory.name',
            'title',
            //'content:ntext',
            //'slug',
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
