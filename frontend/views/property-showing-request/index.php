<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\PropertyShowingRequest;
use frontend\helpers\AuthHelper;


$this->title = 'Property Showing Request';
?>
<div class="content-wrapper">
    <!-- Content Title Sec -->
    <section class="content-header">
        <h1><?php echo $this->title ?></h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i><?= $this->title?></a></li>
            <li class="active">List</li>
        </ol>
    </section>
    <!-- Content Title Sec -->

    <!-- Main content -->
    <section class="content">
        <div class="manage-profile-sec">
          <?php
            $gridColumns = [
                ['class' => 'kartik\grid\SerialColumn'],
                ['attribute' => 'property.formattedAddress', 'label' => 'Property_Address/Location'],
                ['attribute' => 'name', 'noWrap' => true, 'label' => 'Request by'],
                'email:email',
                'phone',
                ['attribute' => 'created_at', 'label' => 'Date/Timestamped', 'value' => function($model){
                    return Yii::$app->formatter->asDatetime($model->created_at);
                }],
                ['attribute' => 'schedule', 'label' => 'Showing Date', 'filter' => false, 'value' => function($model){
                    return Yii::$app->formatter->asDate($model->schedule);
                }],
                ['attribute' => 'schedule', 'label' => 'Showing time', 'filter' => false, 'noWrap' => true, 'value' => function($model){
                    return date("h:i A",$model->schedule).' - '.  date("h:i A",$model->schedule_end);
                }],
                ['attribute' => 'status', 'filter' => [PropertyShowingRequest::STATUS_PENDING => 'Pending', PropertyShowingRequest::STATUS_APPROVE => 'Approved', PropertyShowingRequest::STATUS_DECLINE => 'Declined', PropertyShowingRequest::STATUS_CANCELLED => 'Cancelled']],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'Action',
                    'template' => ' {view} {approve} {decline} {cancel}',
                    'buttons' => [
                        'approve' => function ($url,$model) {
                            $user = Yii::$app->user->identity;
                            $agents = [];
                            if(AuthHelper::is('agency')){
                                $agents = \yii\helpers\ArrayHelper::getColumn(\common\models\User::find()->where(['agency_id' => $user->agency_id])->all(), 'id');
                            }
                            if(($model->property->user_id == $user->id || in_array($model->property->user_id, $agents)) && $model->status == PropertyShowingRequest::STATUS_PENDING){
                                $class = 'fa fa-thumbs-up';
                                $title = 'Approve';
                                return Html::a(
                                    '<span class="'.$class.'"></span>',
                                    $url, 
                                    [
                                        'title' => $title,
                                        'data-pjax' => '0',
                                    ]
                                );
                            }
                        },
                        'decline' => function ($url,$model) {
                            $user = Yii::$app->user->identity;
                            $agents = [];
                            if(AuthHelper::is('agency')){
                                $agents = \yii\helpers\ArrayHelper::getColumn(\common\models\User::find()->where(['agency_id' => $user->agency_id])->all(), 'id');
                            }
                            if(($model->property->user_id == $user->id || in_array($model->property->user_id, $agents)) && $model->status == PropertyShowingRequest::STATUS_PENDING){
                                $class = 'fa fa-thumbs-down';
                                $title = 'Decline';

                                return Html::a(
                                    '<span class="'.$class.'"></span>',
                                    $url, 
                                    [
                                        'title' => $title,
                                        'data-pjax' => '0',
                                        'onclick' => "return confirm('Are you sure want to decline?')"
                                    ]
                                );
                            }
                        },
                        'cancel' => function ($url,$model) {
                            $userId = Yii::$app->user->id;
                            if($model->user_id == $userId && $model->status == PropertyShowingRequest::STATUS_PENDING){
                                $class = 'fa fa-times';
                                $title = 'Cancel';

                                return Html::a(
                                    '<span class="'.$class.'"></span>',
                                    $url, 
                                    [
                                        'title' => $title,
                                        'data-pjax' => '0',
                                        'onclick' => "return confirm('Are you sure want to cancel?')"
                                    ]
                                );
                            }
                        },
     /*                    'pending' => function ($url,$model) {
                            $class = 'fa fa-ban';
                            $title = 'Discard';
                            return Html::a(
                                '<span class="'.$class.'"></span>',
                                $url, 
                                [
                                    'title' => $title,
                                    'data-pjax' => '0',
                                ]
                            );
                        }, */
                    ],
                ],      
            ];
                        
            if(AuthHelper::is('agency')){
                array_splice($gridColumns, 2, 0, [['attribute' => 'model_id', 'noWrap' => true, 'filter' => false, 'label' => 'Listing Agent', 'value' => function($model){
                    return $model->property->user->fullName;
                }]]);
            }

            echo GridView::widget([
                'filterModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'columns' => $gridColumns,
                'pjax' => true,
                'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']],
                'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-home"></i> '.$this->title.'</h3>',
                ],
            ]);
          ?>
        </div>
    </section>
    <!-- Main content -->
</div>