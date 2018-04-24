<?php
use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;


$this->title = 'Hotel Feedback';
?>
<div class="content-wrapper">
    <!-- Content Title Sec -->
    <section class="content-header">
        <h1><?php echo $this->title ?></h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i> Feedback and Review</a></li>
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
                'title',
                'description',
                'rating',
                    [
                        'class' => 'kartik\grid\BooleanColumn',
                        'attribute' => 'status',
                        'value' => function($model, $key, $index, $widget) {
                            return $model->status == 'active';
                        },
                        'label' => 'Status',
                        'vAlign' => 'middle',
                    ],
                    [
                        'class' => '\kartik\grid\ActionColumn',
                            'buttons'=>[
                            'view' => function ($url, $model) {     
                                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['/hotel/details','id' => $model->id], [
                                    'title' => Yii::t('yii', 'View'),]); 
                            }
                        ],
                        'deleteOptions' => ['label' => '<i class="glyphicon glyphicon-remove"></i>']
                    ],
                    
                        
            ];


            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => $gridColumns,
                'pjax' => true,
                'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']],
                'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-home"></i> Hotel Feedback</h3>',
                ],
            ]);
          ?>
        </div>
    </section>
    <!-- Main content -->
</div>