<?php

use common\models\Property;
use frontend\helpers\PropertyHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\LinkPager;
use yii\helpers\StringHelper;
use common\models\User;
use common\models\Agency;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\export\ExportMenu;

$session = Yii::$app->session;

$session->set('locationId', $location);


$this->title = $location. ' Property for Sale - '. Yii::$app->name;
$properties = $dataProvider->getModels();
//PropertyHelper::filterListing($properties);
//$dataProvider->setTotalCount(count($properties));
//$dataProvider->setModels($properties);
//yii\helpers\VarDumper::dump($properties,12,1); exit;
//print_r($propTypes);die();
?>
<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&key=<?= Yii::$app->params['googleMapKey']?>"></script>
<section class="propertymenubar_holder">
    <!-- Property Menu Bar -->
    <?php
    echo $this->render('//shared/_property_sell_estimate_filtter', ['location' => $location, 'town' => $town, 'area'  => $area,'state' => $state,
        'category' => $category, 'category_id' => $category_id,
        'constStatuses' => $constStatuses, 'marktStatuses' => $marktStatuses, 'categories' => $categories,
        'minPrice' => $minPrice, 'maxPrice' => $maxPrice, 'bedroom' => $bedroom, 'bathroom' => $bathroom, 'garage' => $garage, 'propTypes' => $propTypes,
        'lotSize' => $lotSize,'buildingSize' => $buildingSize,'houseSize' => $houseSize,
        'noOfToilet' => $noOfToilet,'noOfBoysQuater' => $noOfBoysQuater,'yearBuilt' => $yearBuilt,'agencyID' => $agencyID,
        'agentID' => $agentID,'agentName' => $agentName,'generals' => $generals, 'exteriors' => $exteriors, 'interiors' => $interiors,
        'teamID' => $teamID, 'teamName' => $teamName, 'agencyName' => $agencyName, 'soleMandate' => $soleMandate, 'featuredListing' => $featuredListing,
        'propertyID' => $propertyID, 'streetAddress' => $streetAddress, 'streetNumber' => $streetNumber,'appartmentUnit' => $appartmentUnit,
        'zipCode' => $zipCode, 'localGovtArea' => $localGovtArea, 'urbanTownArea' => $urbanTownArea, 'source' => $source, 'viewType' => $viewType, 'sortBy' => $sortBy
        ]);
    $view = 'summary';
    if($viewType){
        $view = $viewType;
    }
    ?>
    <!-- Property Menu Bar -->
    <div style="position: relative">
        <div id="xPopup" class="map-popup-box"></div>
        <div class="inner-content-sec property_search_result_container">
            <?php if($view == 'list'){ ?>
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
                                ['attribute' => 'daysListed', 'value' => function($model) {
                                        return $model->daysListed . ' Days';
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
            <?php }else{?>
            <?= $this->render('//sell-estimate/'.$view, ['dataProvider' => $dataProvider, 'searchModel' => $searchModel, 'items' => $items, 'breadcrumb' => $breadcrumb, 'sortBy' => $sortBy])?>
            <?php }?>
        </div>
    </div>
</section>
<?php 
$session   =   Yii::$app->session;
$compProps = $session->get('comp_props');
?>
<input type="hidden" id="compareCntId" value="<?= (isset($compProps)? count($compProps):0)?>" />
<a href="<?php echo Url::to(['property/compare-property']) ?>"  target="_blank" class="compare-count lnk_compare_property" data-url="" title="Compare" style='display: <?php if(!$compProps)echo 'none';else echo 'block'; ?>'>Compare <span id="totalCntDiv"><?= (isset($compProps)? count($compProps):0)?></span></a>
<script type="foo/bar" id='usageList'>
        <div class="map-popup-box-list">
            <a href="<%= detail_url %>" target="_blank">
                <img src="<%= feature_image %>" alt="">
                <div class="map-popup-box-list-content">
                        <p class="map-popup-box-list-content-txt"><%= address %></p>
                        <p class="map-popup-box-list-content-txt"><span><%= price%></span> <strong><%= bedroom%> bd <i class="fa fa-circle" aria-hidden="true"></i> <%= bathroom %> ba <i class="fa fa-circle" aria-hidden="true"></i> <%= area %></strong></p>
                </div>
            </a>
	</div>
</script>