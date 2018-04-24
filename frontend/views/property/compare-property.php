<?php 
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
$this->title = 'Compare Property';
?>
<section>
    <div class="home-listing-sec">
        <div class="container">
            <div class="row">
                <div class="col-sm-3 compare-listing-outer">
                    <div class="compare-listing">
                        <div class="compare-listing-top">

                        </div>
                        
                        <div class="table-responsive">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-bordered compare-table-listing compare-table-listing-left text-center">
                                
                                <tr>
                                    <td>Category</td>
                                </tr>
                                <tr>
                                    <td>Property ID</td>
                                </tr>
                                <tr>
                                    <td>Bedrooms</td>
                                </tr>
                                <tr>
                                    <td>Toilet</td>
                                </tr>
                                <tr>
                                    <td>Bathrooms</td>
                                </tr>
                                <tr>
                                    <td>Garage</td>
                                </tr>
                                <tr>
                                    <td>Price</td>
                                </tr>
								<tr>
								<td>
									Construction type
								</td>
								</tr>
                                <tr>
                                    <td>Market Status</td>
                                </tr>
								<tr>
                                    <td>Construction Status</td>
                                </tr>
                                <tr>
                                    <td>Size</td>
                                </tr>
                                <tr>
                                    <td>Listing Date</td>
                                </tr>
                                <tr>
                                    <td>Expiring Date</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <?php
                foreach ($propertiesArr as $key => $property) {
                    ?>

                    <div class="col-sm-3 compare-listing-outer">
                        <div class="compare-listing">
                            <div class="compare-listing-top">
                                <a href="<?= Url::to(['property/remove-property', 'id' => $property->id]) ?>" class="compare-close"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                <img src="<?= $property->featureThumbImage ?>" />
                                <h3><?= substr($property->formattedAddress, 0, 100) ?></h3>
                                <p><?= $property->price ? Yii::$app->formatter->asCurrency($property->price) : "Nil" ?></p>
                            </div>
                            
                            <div class="table-responsive">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table compare-table-listing table-bordered">
                                    <tr>
                                        <td><?= $property->categoryName ?></td>
                                    </tr>
                                    <tr>
                                        <td>MLS <?= $property->referenceId ?></td>
                                    </tr>
                                    <tr>
                                        <td><?= $property->no_of_room ? $property->no_of_room : "Nil" ?></td>
                                    </tr>
                                    <tr>
                                        <td><?= $property->no_of_toilet ? $property->no_of_toilet : "Nil" ?></td>
                                    </tr>
                                    <tr>
                                        <td><?= $property->no_of_bathroom ? $property->no_of_bathroom : "Nil" ?></td>
                                    </tr>
                                    <tr>
                                        <td><?= $property->no_of_garage ? $property->no_of_garage : "Nil" ?></td>
                                    </tr>
                                    <tr>
                                        <td><?= $property->price ? Yii::$app->formatter->asCurrency($property->price) : "Nil" ?></td>
                                    </tr>
                                    <tr>
                                    <td>
                                    <?php if($property->propertyTypeIds) echo implode(',', arrayHelper::getColumn($property->propertyTypeIds, 'title'));else echo 'Nil';?>
                                    </td>
                                    </tr>
                                    <tr>
                                        <td><?= $property->market_status ? $property->market_status : "Nil" ?></td>
                                    </tr>
                                    <tr>
                                    <td>
                                    <?php 
                                     if($property->constructionStatus) echo implode(',', arrayHelper::getColumn($property->constructionStatus, 'title'));else echo 'Nil';
                                    ?>
                                    </td>
                                    </tr>
                                    <tr>
                                        <td> <?= $property->lot_size . " " . $property->metricType->name ?></td>
                                    </tr>
                                    <tr>
                                        <td><?= $property->listedDate ? $property->listedDate : "Nil" ?></td>
                                    </tr>
                                    <tr>
                                        <td><?= $property->expiredDate ? $property->expiredDate : "Nil" ?></td>
                                    </tr>

                                    <tr>
                                        <td><a href="<?= Url::to(['property/view', 'slug' => $property->slug]) ?>" target="_blank" class="btn btn-danger" role="button">View Details</a></td>
                                    </tr>

                                </table>


                            </div>
                        </div>
                    </div>
                <?php } ?> 
            </div>
        </div>
    </div>
</section>