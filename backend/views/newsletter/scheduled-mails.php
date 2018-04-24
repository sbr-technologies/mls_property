<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\PropertyShowingRequest;
use frontend\helpers\AuthHelper;
use yii\helpers\StringHelper;


$this->title = 'Scheduled Emails';
?>
<div class="manage-profile-sec">
  <?php
    $gridColumns = [
        ['class' => 'kartik\grid\SerialColumn'],
        ['attribute' => 'schedule', 'label' => 'Sent By'],
        ['attribute' => 'schedule_start_date', 'noWrap' => true],
        'schedule_end_date',
        ['attribute' => 'status'],   
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{scheduled-update} {scheduled-delete}',
            'buttons' => [
                'scheduled-update' => function ($url,$model) {
                    return Html::a(
                        '<span class="glyphicon glyphicon-pencil"></span>',
                        $url, 
                        [
                            'title' => 'Update',
                            'data-pjax' => '0',
                        ]
                    );
                },
                'scheduled-delete' => function ($url,$model) {
                    return Html::a(
                        '<span class="glyphicon glyphicon-trash"></span>',
                        $url, 
                        [
                            'title' => 'Delete',
                            'data-pjax' => '0',
                        ]
                    );
                },
            ],
        ],
    ];

    echo GridView::widget([
//        'filterModel' => $searchModel,
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