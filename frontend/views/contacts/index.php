<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use common\models\Agent;
use frontend\helpers\AuthHelper;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ContactSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Contacts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agent-contact-index">

    <div class="content-wrapper">
        <!-- Content Title Sec -->
        <section class="content-header">
            <h1><?php echo $this->title ?></h1>
            <ol class="breadcrumb">
                <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i> <?= $this->title?></a></li>
                <li class="active">List</li>
            </ol>
        </section>
        <!-- Content Title Sec -->

        <!-- Main content -->
        <section class="content">
            <div class="manage-profile-sec">
                <?php Pjax::begin(); 
                
                $columns = [
                    ['class' => 'yii\grid\SerialColumn'],
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
                    
                    if(AuthHelper::is('agency') && !empty($agency)){
                        array_splice($columns, 1, 0, [['attribute' => 'user_id', 'label' => 'AGENT ID',
                            'filter' => ArrayHelper::map(Agent::find()->where(['agency_id' => $agency->id])->active()->all(), 'id', 'commonName'),
                            'value' => function($model){
                            return $model->user->agentID;
                        }
                        ]]);
                    }
                
                ?>    <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => $columns,
                ]);
                ?>
<?php Pjax::end(); ?>
            </div>
        </section>
    </div>
</div>
