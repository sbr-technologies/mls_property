<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\AdviceCategory;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $searchModel common\models\AdviceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Advices');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advice-index">

    <p>
        <?= Html::a(Yii::t('app', 'Create Advice'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            ['attribute' => 'advice_category_id', 'label' => 'Category',
//                'filter'=>ArrayHelper::map(Agency::find()->active()->asArray()->all(), 'id', 'name'),
            'filter' => Select2::widget([
                'model' => $searchModel,
                'attribute' => 'advice_category_id',
                'data' => ArrayHelper::map(AdviceCategory::find()->active()->orderBy(['name' => SORT_ASC])->asArray()->all(), 'id', 'name'),
                'theme' => Select2::THEME_BOOTSTRAP,
//                'hideSearch' => true,
                'options' => [
                    'placeholder' => 'Filter by category',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]),
            'value' => function($model) {
                return $model->adviceCategory->name;
            }],
//        'adviceCategory.name',
            'title',
            //'content:ntext',
            'slug',
             'status',
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
