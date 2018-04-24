<?php
use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;


$this->title = 'Tell Me About Property';
?>
<div class="content-wrapper">
    <!-- Content Title Sec -->
    <section class="content-header">
        <h1><?php echo $this->title ?></h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i> Property Management</a></li>
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
                [
                    'attribute'=>'model_id',
                    'label'=>'Property_Address/Location',
//                    'noWrap' => true,
                    'value'=>function ($model, $key, $index, $widget) {
                        return isset($model->property)?$model->property->formattedAddress:'n/a';
                    },
                    
                ],
                [
                    'attribute'=>'model_id',
                    'label'=>'Category',
                    'value'=>function ($model, $key, $index, $widget) {
                        return isset($model->property)?$model->property->propertyCategory->title:'n/a';
                    },
                    
                ],
                ['attribute' => 'property.PropertyTypes', 'label' => 'Property_Type'],
                ['attribute' => 'name', 'label' => 'Request_By/Name'],
                [
                    'attribute'=>'model_id',
                    'label'=>'Agency_Name',
                    'value'=>function ($model, $key, $index, $widget) {
                        return isset($model->property)?($model->property->user->agency_id?$model->property->user->agency->name:'n/a'):'n/a';
                    },
                    
                ],
                'email:email',
                'phone',
//                'subject',
                'message:ntext',
                ['attribute' => 'created_at', 'label' => 'Date/Timestamped', 'value' => function($model){
                    return Yii::$app->formatter->asDatetime($model->created_at);
                }],                            
//                'status',
                [
                    'class' => '\kartik\grid\ActionColumn',
                    'template' => '{view} {delete}'
                ],
                    
                        
            ];


            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => $gridColumns,
                'pjax' => true,
                'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']],
                'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-home"></i> '. $this->title .'</h3>',
                ],
            ]);
          ?>
        </div>
    </section>
    <!-- Main content -->
</div>