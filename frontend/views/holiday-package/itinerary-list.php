<?php
use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;


$this->title = 'My Holiday Package Itinerary';
?>
<div class="content-wrapper">
    <!-- Content Title Sec -->
    <section class="content-header">
        <h1><?php echo $this->title ?></h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i> Holiday Management</a></li>
            <li class="active">List</li>
        </ol>
        <p>
            <?= Html::a(Yii::t('app', 'Create Itinerary'), ['create-itinerary','holiday_package_id'=>$id], ['class' => 'btn btn-success']) ?>
        </p>
    </section>
    <!-- Content Title Sec -->

    <!-- Main content -->
    <section class="content">
        <div class="manage-profile-sec">
          <?php
            $gridColumns = [
                ['class' => 'kartik\grid\SerialColumn'],
                'holidayPackage.name',
                'days_name',
                //'description:ntext',
                'title',
                'city',
                'state',
                    
                    [
                        'class' => '\kartik\grid\ActionColumn',
                        'template' => '{itinerary-view} {itinerary-update} {itinerary-delete} ', 
                            'buttons'=>[
                            'itinerary-view' => function ($url,$model) {
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
                            'itinerary-update' => function ($url,$model) {
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
                            'itinerary-delete' => function ($url,$model) {
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
                    'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-home"></i> Holiday Package</h3>',
                ],
            ]);
          ?>
        </div>
    </section>
    <!-- Main content -->
</div>