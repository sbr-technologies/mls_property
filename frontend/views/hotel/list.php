<?php
use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;


$this->title = 'My Hotels';
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
                'name',
                'tagline',
                'formattedAddress',
                'price:currency',
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
                        'template' => '{status} {view} {update} {delete} {room-list}', 
                            'buttons'=>[
                            'view' => function ($url, $model) {     
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['/hotel/details','id' => $model->id], [
                                    'title' => Yii::t('yii', 'delete'),
                                ]); 
                                
                            },
                            'room-list' => function ($url, $model, $key) {
                                return Html::a('<span class="fa fa-address-card-o"></span>', ['room-list', 'id'=>$model->id], [
                                    'title' => Yii::t('yii', 'Manage Room'),
                            ]);
                            },
                        ],
                        'deleteOptions' => ['label' => '<i class="glyphicon glyphicon-remove"></i>']
                    ],
            ];


            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => $gridColumns,
                'pjax' => true,
                'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']],
                'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-home"></i> Hotel</h3>',
                ],
            ]);
          ?>
        </div>
    </section>
    <!-- Main content -->
</div>