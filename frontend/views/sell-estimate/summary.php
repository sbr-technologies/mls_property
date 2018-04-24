<?php
error_reporting(0);
use common\helpers\MathHelper;
$properties = $dataProvider->getModels();
$PriceArray = [];
$PricePerUnitArray = [];
$DaysArray = [];
$BedArray = [];
$BathArray = [];
$GarageArray = [];
$LotSizeArray = [];
$BuildingSizeArray = [];
$HouseSizeArray = [];
$YearBuiltArray = [];
$AgeArray = [];
if(count($properties) > 0){
foreach ($properties as $property){
    if($property->price){
        array_push($PriceArray, $property->price);
        array_push($PricePerUnitArray, $property->pricePerUnit);
    }
    array_push($DaysArray, $property->daysListed);
    if($property->no_of_room !== null){
        array_push($BedArray, $property->no_of_room);
    }
    if($property->no_of_bathroom !== null){
        array_push($BathArray, $property->no_of_bathroom);
    }
    if($property->no_of_garage){
        array_push($GarageArray, $property->no_of_garage);
    }
    if($property->house_size !== null){
        array_push($HouseSizeArray, $property->house_size);
    }
    if($property->lot_size !==null){
        array_push($LotSizeArray, $property->lot_size);
    }
    if($property->building_size !== null){
        array_push($BuildingSizeArray, $property->building_size);
    }
    
    if($property->year_built !== null){
        array_push($YearBuiltArray, $property->year_built);
        array_push($AgeArray, $property->age);
    }
}     
$avgPrice = MathHelper::average($PriceArray);
$medianPrice = MathHelper::calculateMedian($PriceArray);
}
?>

    <div class="container">
        <div class="col-sm-12">
            <div class="summary_details">
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
                            <a href="javascript:void(0)" data-type="summary" class="btn btn-default active sell_estimate_view" title="Summary"><i class="fa fa-th-large"></i></a>
                            <a href="javascript:void(0)" data-type="list" class="btn btn-default sell_estimate_view" title="List"><i class="fa fa-list"></i></a>
                            <a href="javascript:void(0)" data-type="thumbnails" class="btn btn-default sell_estimate_view" title="Thumbnails"><i class="fa fa-image"></i></a>
                            <a href="javascript:void(0)" data-type="map" class="btn btn-default sell_estimate_view" title="Map"><i class="fa fa-map"></i></a>
                            <a href="javascript:void(0)" data-type="chart" class="btn btn-default sell_estimate_view" title="Chart"><i class="fa fa-bar-chart"></i></a>
                        </div>
                    <?php } ?>
                </div>
            </div>
                <h3>Summary <?php //if(count($properties) > 0){ echo \yii\helpers\Html::a('<i class="fa fa-download"></i>');}?></h3>
            <?php if(count($properties) > 0){?>
            <table class="table table-bordered" width="50%">
                <tr>
                    <td>Maximum Price:</td>
                    <td><?= Yii::$app->formatter->asCurrency(max($PriceArray))?></td>
                </tr>
                <tr>
                    <td>Minimum Price:</td>
                    <td><?= Yii::$app->formatter->asCurrency(min($PriceArray))?></td>
                </tr>
                <tr>
                    <td>Average Price:</td>
                    <td><?= Yii::$app->formatter->asCurrency($avgPrice)?></td>
                </tr>
                <tr>
                    <td>Median Price:</td>
                    <td><?= Yii::$app->formatter->asCurrency($medianPrice)?></td>
                </tr>
                <tr><td>Days on Market</td><td><?= min($DaysArray)?> <span>to</span> <?= max($DaysArray)?> Days</td></tr>
                <?php if(!empty($BedArray)){?>
                <tr><td>No of  Bedrooms</td><td><?= min($BedArray)?> <span>to</span> <?= max($BedArray)?></td></tr>
                <?php } if(!empty($BathArray)){?>
                <tr><td>No of Bathrooms</td><td><?= min($BathArray)?> <span>to</span> <?= max($BathArray)?></td></tr>
                <?php } if(!empty($GarageArray)){?>
                <tr><td>No of Parking Spaces</td><td><?= min($GarageArray)?> <span>to</span> <?= max($GarageArray)?></td></tr>
                <?php }?>
                <tr><td>Lot Size</td><td><?= min($LotSizeArray)?> <span>to</span> <?= max($LotSizeArray)?></td></tr>
                <tr><td>Building Size</td><td><?= min($BuildingSizeArray)?> <span>to</span> <?= max($BuildingSizeArray)?></td></tr>
                <tr><td>Property Size</td><td><?= min($HouseSizeArray)?> <span>to</span> <?= max($HouseSizeArray)?></td></tr>
                <tr><td>Per Square Meter Price </td><td><?= Yii::$app->formatter->asCurrency(min($PricePerUnitArray))?> <span>to</span> <?= Yii::$app->formatter->asCurrency(max($PricePerUnitArray))?></td></tr>
                <tr><td>Year Built</td><td><?= min($YearBuiltArray)?> <span>to</span> <?= max($YearBuiltArray)?></td></tr>
                <tr><td>Age</td><td><?= min($AgeArray)?> <span>to</span> <?= max($AgeArray)?> Years</td></tr>
            </table>
            <?php }else{
                echo 'No Records Found';
            }?>
        </div>
    </div>
</div>
    
    
<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */