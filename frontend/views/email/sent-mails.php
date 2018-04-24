<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use frontend\helpers\AuthHelper;
use yii\helpers\StringHelper;


$this->title = 'Sent Mails';
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
                ['attribute' => 'recipient', 'noWrap' => true],
                ['attribute' => 'subject', 'noWrap' => true],
                ['attribute' => 'content', 'value' => function($model){
                    return StringHelper::truncate(strip_tags($model->content), 40);
                }],
                ['attribute' => 'created_at', 'label' => 'Sent At', 'value' => function($model){
                    return Yii::$app->formatter->asDatetime($model->created_at);
                }],
                
                ['attribute' => 'status'],   
            ];
                        
            if(AuthHelper::is('agency')){
                array_splice($gridColumns, 2, 0, [['attribute' => 'sent_by', 'noWrap' => true, 'filter' => false, 'label' => 'Listing Agent', 'value' => function($model){
                    return $model->sentBy->commonName;
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