<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ContactSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Contacts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contacts-index">
                <?php Pjax::begin(); 
                
                $columns = [
                    ['class' => 'yii\grid\SerialColumn'],
                    ['attribute' => 'user_id', 'filter' => Select2::widget([
                        'model' => $searchModel,
                        'attribute' => 'user_id',
                        'data' => ArrayHelper::map(\common\models\User::find()->active()->orderBy(['first_name' => SORT_ASC])->all(), 'id', 'commonName'),
                        'theme' => Select2::THEME_BOOTSTRAP,
        //                'hideSearch' => true,
                        'options' => [
                            'placeholder' => 'Filter by User',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]), 'value' => function($model){
                        if($model->user_id)
                            return $model->user->commonName;
                        elseif($model->property_id)
                            return $model->property->user->commonName;
                    }],
                    'first_name',
                    'last_name',
                    ['attribute' => 'gender', 'value' => function($model){
                        return $model->genderText;
                    }, 'filter' => [1 => 'Male', 2 => 'Female']],
                    'email:email',
                    'Mobile1',
                    ['attribute' => 'dob', 'value' => function($model){
                        return $model->birthday;
                    }],
                    // 'phone_2',
                    // 'created_at',
                    // 'updated_at',
                    // 'status',
                    ['class' => 'yii\grid\ActionColumn'],
                    ];
                
                ?>    <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => $columns,
                ]);
                ?>
<?php Pjax::end(); ?>
</div>
