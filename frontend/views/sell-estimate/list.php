<?php 
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\export\ExportMenu;
?>
    <div class="container">
        <div class="col-sm-12">
            <div class="sell_estimate_list_view">
            <div class="row property-listing-top-title">
                <div class="col-sm-6 breadcrumb-list">
                    
                        <ul>
                            <?php
                            foreach ($breadcrumb as $item) {
                                if (is_array($item)) {
                                    echo '<li><a href="#">' . implode('|', $item) . '</a></li>';
                                } else {
                                    echo '<li><a href="#">' . $item . '</a></li>';
                                }
                            }
                            ?>
                        </ul>
                    
                </div>
                <div class="col-sm-6 text-right">
                    <?php if (1) { ?>
                        <div class="form-group clearfix">
                            <a href="javascript:void(0)" data-type="summary" class="btn btn-default sell_estimate_view" title="Summary"><i class="fa fa-th-large"></i></a>
                            <a href="javascript:void(0)" data-type="list" class="btn btn-default active sell_estimate_view" title="List"><i class="fa fa-list"></i></a>
                            <a href="javascript:void(0)" data-type="thumbnails" class="btn btn-default sell_estimate_view" title="Thumbnails"><i class="fa fa-image"></i></a>
                            <a href="javascript:void(0)" data-type="map" class="btn btn-default sell_estimate_view" title="Map"><i class="fa fa-map"></i></a>
                            <a href="javascript:void(0)" data-type="chart" class="btn btn-default sell_estimate_view" title="Chart"><i class="fa fa-bar-chart"></i></a>
                        </div>
                    <?php } ?>
                </div>
            </div>
                <?php
        
                $gridColumns = [
                    [
                        'class' => 'kartik\grid\SerialColumn',
                        'vAlign' => GridView::ALIGN_TOP
                    ],
                    'reference_id',
                    [
                        'attribute' => 'formattedAddress',
                        'label' => 'Property_Complete_Address',
                        'value' => function ($model, $key, $index, $widget) {
                            return Html::a($model->formattedAddress, ['property/view', 'slug' => $model->slug], ['target' => '_blank']);
                        },
                        'format' => 'raw'
                    ],
                    ['attribute' => 'propertyCategory.title', 'label' => 'Category'],
                    'market_status',
                    ['attribute' => 'propertyTypeId',
                        'format' => 'raw',
                        'value' => function($model) {
                            return implode(',', ArrayHelper::getColumn(common\models\PropertyType::find()->where(['id' => $model->propertyTypeId])->all(), 'title'));
                        }
                    ],
                    ['attribute' => 'constructionStatusId',
                        'format' => 'raw',
                        'value' => function($model) {
                            return implode(',', ArrayHelper::getColumn(common\models\ConstructionStatusMaster::find()->where(['id' => $model->constructionStatusId])->all(), 'title'));
                        }
                    ],
                    'no_of_room',
                    'no_of_bathroom',
                    'no_of_garage',
                    'no_of_toilet',
                    'lot_size',
                    'building_size',
                    'house_size',
                    'year_built',
                    'listed_date:date',
                    ['attribute' => 'daysListed', 'value' => function($model){
                        return $model->daysListed. ' Days';
                    }],
                    'price:currency',
                    'pricePerUnit:currency',
                    'sold_date:date',
                    'sold_price:currency',
                ];
                $fullExportMenu = ExportMenu::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => $gridColumns,
                            'target' => ExportMenu::TARGET_BLANK,
                            'fontAwesome' => true,
                            'pjaxContainerId' => 'kv-pjax-container',
                            'exportConfig' => [
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
                    'toolbar' => [
                        '{export}',
                        $fullExportMenu
                    ],
                    'bordered' => true,
                    'striped' => false,
                    'condensed' => false,
                    'responsive' => true,
                    'resizableColumns' => false,
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
</div>