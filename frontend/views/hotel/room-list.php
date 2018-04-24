<?php
use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;


$this->title = 'My Hotel Rooms';
?>
<div class="content-wrapper">
    <!-- Content Title Sec -->
    <section class="content-header">
        <h1><?php echo $this->title ?></h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i> Property Management</a></li>
            <li class="active">List</li>
        </ol>
        <p>
            <?= Html::a(Yii::t('app', 'Create Room'), ['create-room','hotel_id'=>$id], ['class' => 'btn btn-success']) ?>
        </p>
    </section>
    <!-- Content Title Sec -->

    <!-- Main content -->
    <section class="content">
        <div class="manage-profile-sec">
          <?php
            $gridColumns = [
                ['class' => 'kartik\grid\SerialColumn'],
                // 'id',
                'hotel.name',
                'roomType.name',
                //'description:ntext',
                'name',
                'floor_name',
                'isAc',
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
                        'template' => '{room-status}  {room-view}  {room-update}  {room-delete}',
                        'buttons' => [
                            
                            'room-status' => function ($url,$model) {
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
                            'room-view' => function ($url,$model) {
                                $class = 'fa fa-eye';
                                $title = 'View Room';
                                return Html::a(
                                    '<span class="'.$class.'"></span>',
                                    $url, 
                                    [
                                        'title' => $title,
                                        'data-pjax' => '0',
                                    ]
                                );
                            },
                            'room-update' => function ($url,$model) {
                                $class = 'fa fa-pencil';
                                $title = 'Update Room';
                                return Html::a(
                                    '<span class="'.$class.'"></span>',
                                    $url, 
                                    [
                                        'title' => $title,
                                        'data-pjax' => '0',
                                    ]
                                );
                            },
                            'room-delete' => function ($url,$model) {
                                $class = 'fa fa-trash-o';
                                $title = 'Delete Room';
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
                    'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-home"></i> Room List</h3>',
                ],
            ]);
          ?>
        </div>
    </section>
    <!-- Main content -->
</div>