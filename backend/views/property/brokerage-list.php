<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use common\models\Profile;
use kartik\select2\Select2;
use common\models\User;
use common\models\PropertyCategory;
/* @var $this yii\web\View */
/* @var $searchModel common\models\PropertySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Brokerage Properties');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="property-index table table-bordered">
<?php Pjax::begin(); ?>    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'reference_id',
            ['attribute' => 'profile_id', 'label' => 'User Type',
//                'filter'=>ArrayHelper::map(Agency::find()->active()->asArray()->all(), 'id', 'name'),
            'filter' => Select2::widget([
                'model' => $searchModel,
                'attribute' => 'profile_id',
                'data' => ArrayHelper::map(Profile::find()->where(['id' => [4,5,7]])->orderBy(['title' => SORT_ASC])->asArray()->all(), 'id', 'title'),
                'theme' => Select2::THEME_BOOTSTRAP,
                'hideSearch' => true,
                'options' => [
                    'placeholder' => 'User type',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]),
            'value'=>function ($model, $key, $index, $widget) {
                    return $model->user->profile->title;
            }],
            ['attribute' => 'user_id', 'label' => 'User',
            'filter' => Select2::widget([
                'model' => $searchModel,
                'attribute' => 'user_id',
                'data' => ArrayHelper::map(User::find()->select(['id', new \yii\db\Expression("CONCAT(`first_name`, ' ',`last_name`) as name")])->where(['profile_id' => [4,5,7]])->orderBy(['first_name' => SORT_ASC])->asArray()->all(), 'id', 'name'),
                'theme' => Select2::THEME_BOOTSTRAP,
//                'hideSearch' => true,
                'options' => [
                    'placeholder' => 'Filter by user',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]),
            'value'=>function ($model, $key, $index, $widget) {
                    return $model->user->fullName;
            }],
            ['attribute' => 'property_category_id', 'label' => 'Category',
//                'filter'=>ArrayHelper::map(Agency::find()->active()->asArray()->all(), 'id', 'name'),
            'filter' => Select2::widget([
                'model' => $searchModel,
                'attribute' => 'property_category_id',
                'data' => ArrayHelper::map(PropertyCategory::find()->active()->orderBy(['title' => SORT_ASC])->asArray()->all(), 'id', 'title'),
                'theme' => Select2::THEME_BOOTSTRAP,
                'hideSearch' => true,
                'options' => [
                    'placeholder' => 'User type',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]),
            'value'=>function ($model, $key, $index, $widget) {
                    return $model->propertyCategory->title;
            }],
            ['attribute' => 'propertyTypeId',
                'format' => 'raw',
                'value' => function($model){
                    return implode(',', ArrayHelper::getColumn(common\models\PropertyType::find()->where(['id' => $model->propertyTypeId])->all(), 'title')) ;
                }
            ],
            [
                'attribute'=>'formattedAddress',
                'label'=>'Address',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->formattedAddress;
                },
                'format'=>'raw'
            ],
            ['attribute' => 'constructionStatusId',
                'format' => 'raw',
                'value' => function($model){
                    return implode(',', ArrayHelper::getColumn(common\models\ConstructionStatusMaster::find()->where(['id' => $model->constructionStatusId])->all(), 'title')) ;
                }
            ],
            'lot_size',
            'listed_date:date',
            'expired_date:date',
            'price:currency',
            'market_status',
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



