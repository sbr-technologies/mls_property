<?php

use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Buyers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="buyer-index">

    <?php
        $gridColumns = [
            ['class' => 'kartik\grid\SerialColumn'],
            ['attribute' => 'fullName', 'label' => 'Name'],
            'email:email',
            ['attribute' => 'phoneNumber'],
            [
            'class'=>'kartik\grid\BooleanColumn',
            'attribute'=>'status',
            'value' => function($model, $key, $index, $widget){
                    return $model->status == 'active';
            },
            'label' => 'Status',    
            'vAlign'=>'middle',
            ],
    //        ['attribute'=>'buy_amount','format'=>['decimal',2], 'hAlign'=>'right', 'width'=>'110px'],
    //        ['attribute'=>'sell_amount','format'=>['decimal',2], 'hAlign'=>'right', 'width'=>'110px'],
    //        ['class' => 'kartik\grid\ActionColumn', 'urlCreator'=>function(){return '#';}]
        ];

        $fullExportMenu = ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
            'target' => ExportMenu::TARGET_BLANK,
            'fontAwesome' => true,
    //        'disabledColumns'=>[0], // ID & Name
            'hiddenColumns'=>[0],
            'pjaxContainerId' => 'kv-pjax-container',
            'exportConfig' => [
                ExportMenu::FORMAT_PDF => false,
            ],
            'dropdownOptions' => [
                'label' => 'Full',
                'class' => 'btn btn-default',
                'itemsBefore' => [
                    '<li class="dropdown-header">Export All Data</li>',
                ],
            ],
        ]);
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
            'pjax' => true,
            'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Properties</h3>',
            ],
            // set a label for default menu
            'export' => [
                'label' => 'Page',
                'fontAwesome' => true,
            ],
            // your toolbar can include the additional full export menu
            'toolbar' => [
                '{export}',
                $fullExportMenu
            ]
        ]);
    ?>
    
    
</div>
