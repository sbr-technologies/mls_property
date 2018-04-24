<?php
$this->title = 'Criteria Worksheet';
use common\models\LocationSuggestion;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
?>
<div class="criteria_worksheet export-to-excel">
    <div class="">
        <?php 
        $gridColumns = [
            [
                'class' => 'kartik\grid\SerialColumn',
                'vAlign' => GridView::ALIGN_TOP
            ],
            ['attribute' => 'user.fullName', 'label' => 'User Name', 'noWrap' => true],
            ['attribute' => 'user.email', 'label' => 'User Email', 'noWrap' => true],
            'state',
            'city',
            'area',
            'lga',
            ['attribute' => 'comment_location', 'noWrap' => true],
            ['attribute' => 'price_range_from', 'noWrap' => true],
            ['attribute' => 'price_range_to', 'noWrap' => true],
            ['attribute' => 'how_soon_need', 'noWrap' => true],
            'usage',
            'investment',
            ['attribute' => 'cash_flow', 'noWrap' => true],
            'appricition',
            ['attribute' => 'need_agent', 'noWrap' => true],
            ['attribute' => 'contact_me', 'noWrap' => true],
            ['attribute' => 'year_built', 'noWrap' => true],
            'bed',
            'bath',
            'living',
            'dining',
            'stories',
            ['attribute' => 'square_footage', 'noWrap' => true],
            'celling',
            ['attribute' => 'feature_comment', 'noWrap' => true],
            ['attribute' => 'amenities_comment', 'noWrap' => true],
            ['attribute' => 'additional_criteria', 'noWrap' => true],
            'condition',
            'commercial',
            'demolition',
            ['attribute' => 'property_types', 'value' => function($model){
                return implode(', ', ArrayHelper::getColumn($model->propertyTypesNames, 'title'));
            }, 'contentOptions'=>['class'=>'wrap-word'], 'noWrap' => true],
            [
                'attribute' => 'property_amenities', 'noWrap' => true,
                'contentOptions'=>['class'=>'wrap-word'],
            ],
            ['attribute' => 'other_features', 'noWrap' => true, 'contentOptions'=>['class'=>'wrap-word'],],
        ];
        $fullExportMenu = ExportMenu::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $gridColumns,
                    'target' => ExportMenu::TARGET_BLANK,
                    'fontAwesome' => true,
                    'pjaxContainerId' => 'kv-pjax-container',
                    'exportConfig' => [
//                        ExportMenu::FORMAT_PDF => false,
//                        ExportMenu::FORMAT_CSV => false,
//                        ExportMenu::FORMAT_HTML => false,
//                        ExportMenu::FORMAT_TEXT => false,
                        
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
            'filterModel' => $searchModel,
            'columns' => $gridColumns,
            'toolbar' => [
                '{export}',
                $fullExportMenu
            ],
            'bordered' => true,
            'striped' => false,
            'condensed' => false,
            'responsive' => true,
            'hover' => true,
            'floatHeader' => false,
            'showPageSummary' => true,
            'panel' => [
                'type' => GridView::TYPE_PRIMARY
            ],
        ]);
        ?>
    </div>
</div>