<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use common\models\Agency;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $searchModel common\models\TeamSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Teams');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="team-index">

    <p>
        <?= Html::a(Yii::t('app', 'Create Team'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'teamID',
            ['attribute' =>'agency_id', 'label' => 'Agency', 
//                'filter'=>ArrayHelper::map(Agency::find()->active()->asArray()->all(), 'id', 'name'),
            'filter' => Select2::widget([
                'model' => $searchModel,
                'attribute' => 'agency_id',
                'data' => ArrayHelper::map(Agency::find()->active()->orderBy(['name' => SORT_ASC])->asArray()->all(), 'id', 'name'),
                'theme' => Select2::THEME_BOOTSTRAP,
//                'hideSearch' => true,
                'options' => [
                    'placeholder' => 'Filter by agency',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]),
            'value' => function($model){
                return $model->agency->name;
            }],
            'created_at:datetime',
            'status',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
