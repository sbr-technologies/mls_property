<?php

use yii\helpers\Html;
use common\models\PhotoGallery;
use common\models\Property;
$footerText = 'This report has been prepared based on information furnished by sources deemed reliable , however no representation or warranty , either expressed or implied , is made to its accuracy.';
?>
<!DOCTYPE HTML>
<html>
    <head>
        <!-- Meta Tag
        ================================================== -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Your description">
        <meta name="keywords" content="Your keywords">
        <!--<link href="/mls_property/frontend/web/public_main/css/pdf.css" rel="stylesheet">-->
    </head>
    <body style="font-family: Arial">
        <!-- Start Content Section ==================================================-->
        <div class="main-wrapper">
            <div class="header">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:none;">
                    <tr>
                        <td align="left" width="100%" valign="top"><img src="<?= Yii::$app->urlManager->baseUrl ?>/public_main/images/logo.png" alt="" height="70"></td>
                        <!--<td align="right" width="60%" valign="bottom" style="padding-right:65px; padding-top:40px;"><div style="font-size:24px; text-align:right; color:#405e6f; font-weight:600; margin: 0;">'.ucfirst($node->title).'</div></td>-->
                    </tr>
                </table>            
            </div>
            <div class="main-wrapper">
                <div class="pdf-top-part">
                    <h2><?= $property->formattedAddress ?></h2>
                    <?php
                    $photos = $property->photos;
                    $active = '';
                    if (!empty($photos)) {
                        if (isset($photos) && $photos != '') {
                            $alias = $photos[0]->getImageUrl($photos[0]::LARGE);
                            echo Html::img($alias, ['class' => 'pdf-main-img', 'height' => '420']);
                        }
                    }
                    ?>
                    <h4><?= $property->formattedAddress ?><br>
                    <?= $property->price ?></h4>
                    <?php
                    $agency = $property->user->agency;
                    if (!empty($agency)) {
                        ?>

                        <div class="top-address-part">
                            <h4>Agency Details</h4>
                            <p>
                                <?= $agency->name ? $agency->name : "" ?>
    <?= $agency->formattedAddress ?>
                            </p>
                            <p>
                                <?= $agency->mobile1 ? "<span><b>Phone:</b>" . $agency->getOffice1() . "</span><br>" : ""; ?>
    <?= $agency->email ? "<span><a href='mailto:" . $agency->email . "'>" . $agency->email . "</a></span>" : "" ?>
                            </p>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="page-break"></div>
                    <h4>Investment Highlights</h4>
                    <p><?= $property->description ?></p>
                    <!--        <ul>
                                <li>Great proximity to Downtown Long Beach, less than a mile North of Alamitos Beach</li>
                                <li>Potential development site for up to 5 condos or lofts</li>
                                <li>Excellent unit mix with 2-2bd, 2-1bd, and 2-Studios</li>
                                <li>1 garage plus long driveway for front building</li>
                                <li>Strong rental market with low vacancy rate and strong income</li>
                                <li>One block north of Temple Loft development</li>
                                <li>Professionally managed, low maintenance building</li>
                                <li>1 or more of owners holds California real estate license</li>
                            </ul>-->
                    <?php
                    $lat = $property->lat;
                    $lng = $property->lng;
                    $formatted_address = $property->formattedAddress;

                    $map_url = 'https://maps.googleapis.com/maps/api/staticmap?center=' . $formatted_address . '&zoom=12&size=600x300&maptype=roadmap&markers=color:red%7C' . $lat . ',' . $lng;
                    //\yii\helpers\VarDumper::dump($map_url); exit;
                    echo $map_image = '<img src="' . $map_url . '" height="450" width="700" />';
                    ?>
                            <!--<p><iframe src="<?= $map_url ?>" width="700" height="450" frameborder="0" allowfullscreen></iframe></p>-->
                </div>

                <div class="pdf-middle-part">
                    <div class="page-break"></div>
                    <h4>Property Summary</h4>
                    <?php
                    if (!empty($property->propertyPriceHistories)) {
                        ?>
                        <h5>Average Price Nearby <?= $property->formattedAddress ?></h5>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-listing">
                            <tr>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Price</th>
                            </tr>
                            <?php
                            foreach ($property->propertyPriceHistories as $propertyHistory) {
                                ?>
                                <tr>
                                    <td><?= $propertyHistory->date ?></td>
                                    <td><?= $propertyHistory->status ?></td>
                                    <td><?= $propertyHistory->price ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                        <?php
                    }
                    $activeSql = "SELECT *, ( 3959 * acos( cos( radians(" . $property->lat . ") ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(" . $property->lng . ") ) + sin( radians('%s') ) * sin( radians( lat ) ) ) ) AS distance FROM mls_property where property_category_id = 2 AND town='" . $property->town . "' AND state='" . $property->state . "' AND status='" . Property::STATUS_ACTIVE . "' HAVING distance < 100000 order by distance asc LIMIT 0 , 20";
                    $activeProperty = Property::findBySql($activeSql)->all();
                    // \yii\helpers\VarDumper::dump($activeProperty,4,12); exit;
                    if (!empty($activeProperty)) {
                        $finalActiveData[] = [
                            'address' => $property->formattedAddress,
                            'no_of_room' => $property->no_of_room,
                            'no_of_bathroom' => $property->no_of_bathroom,
                            'price' => $property->price,
                            //'size'              =>  $property->size,
                            'lot_size' => $property->lot_size,
                            'distance' => 0
                        ];
                        foreach ($activeProperty as $active) {
                            $finalActiveData[] = [
                                'address' => $active->formattedAddress,
                                'no_of_room' => $active->no_of_room,
                                'no_of_bathroom' => $active->no_of_bathroom,
                                'price' => $active->price,
                                //'size'          =>  $active->size,
                                'lot_size' => $active->lot_size,
                                'distance' => round($active->distance) . 'Mi'
                            ];
                        }
                        if (!empty($finalActiveData)) {
                            ?>
                            <h5>Properties Nearby <?= $property->formattedAddress ?> Active</h5>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-listing listing-sold-active">
                                <tr>
                                    <th>Address</th>
                                    <th>No Of Room</th>
                                    <th>No Of Bathroom</th>
                                    <th>Price</th>
                                    <th>Lot Area</th>
                                    <th>Distance</th>
                                </tr>
                                <?php
                                foreach ($finalActiveData as $activeData) {
                                    // \yii\helpers\VarDumper::dump($activeData['address']); exit;
                                    ?>
                                    <tr>
                                        <td><?= $activeData['address'] ?></td>
                                        <td><?= $activeData['no_of_room'] ?></td>
                                        <td><?= $activeData['no_of_bathroom'] ?></td>
                                        <td><?= $activeData['price'] ?></td>
                                        <td><?= $activeData['lot_size'] ?></td>
                                        <td><?= $activeData['distance'] ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>

                            </table>
                            <?php
                        }
                    }
                    $soldSql = "SELECT *, ( 3959 * acos( cos( radians(" . $property->lat . ") ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(" . $property->lng . ") ) + sin( radians('%s') ) * sin( radians( lat ) ) ) ) AS distance FROM mls_property where property_category_id = 2 AND town='" . $property->town . "' AND state='" . $property->state . "' AND status='" . Property::STATUS_SOLD . "' HAVING distance < 100000 order by distance asc LIMIT 0 , 20";
                    $soldProperty = Property::findBySql($soldSql)->all();
                    //\yii\helpers\VarDumper::dump($soldProperty,4,12); exit;
                    if (!empty($soldProperty)) {
                        $finalSoldData = [];
                        foreach ($soldProperty as $sold) {
                            $finalSoldData[] = [
                                'address' => $sold->formattedAddress,
                                'no_of_room' => $sold->no_of_room,
                                'no_of_bathroom' => $sold->no_of_bathroom,
                                'price' => $sold->price,
                                // 'size'              =>  $sold->size,
                                'lot_size' => $sold->lot_size,
                                'distance' => round($sold->distance) . 'Mi'
                            ];
                        }
                        if (!empty($finalSoldData)) {
                            ?>
                            <h5>Properties Nearby <?= $property->formattedAddress ?> Sold</h5>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-listing listing-sold-active">
                                <tr>
                                    <th>Address</th>
                                    <th>No Of Room</th>
                                    <th>No Of Bathroom</th>
                                    <th>Price</th>
                                    <th>Lot Area</th>
                                    <th>Distance</th>
                                </tr>
                                <?php
                                foreach ($finalSoldData as $soldData) {
                                    ?>
                                    <tr>
                                        <td><?= $soldData->address ?></td>
                                        <td><?= $soldData->no_of_room ?></td>
                                        <td><?= $soldData->no_of_bathroom ?></td>
                                        <td><?= $soldData->price ?></td>
                                        <td><?= $soldData->lot_size ?></td>
                                        <td><?= $soldData->distance ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
                            <?php
                        }
                    }
                    $monthWiseProperty = [];
                    $addressList = Yii::$app->db->createCommand("SELECT count(id) as totalProperty,AVG(price) as avragePrice,MAX(price) as maxPrice,MIN(price) as minPrice, MONTH(FROM_UNIXTIME(created_at)) AS selectMonth,street_address,area,town,state,country,zip_code, lat, lng, ( 3959 * acos( cos( radians(" . $property->lat . ") ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(" . $property->lng . ") ) + sin( radians('%s') ) * sin( radians( lat ) ) ) ) AS distance FROM mls_property where town='" . $property->town . "' AND state='" . $property->state . "' AND status <> '" . Property::STATUS_INACTIVE . "' GROUP BY selectMonth HAVING distance < 1500000 order by distance asc LIMIT 0 , 20")->queryAll();
                    if (is_array($addressList) && count($addressList)) {
                        foreach ($addressList as $address) {
                            $monthWiseProperty[$address['selectMonth']] = $address;
                        }
                        if (!empty($monthWiseProperty)) {
                            ?>
                            <h5>Property History for <?= $property->formattedAddress ?></h5>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-listing">
                                <tr>
                                    <th>Month</th>
                                    <th>Average Price</th>
                                    <th>Maximum Price</th>
                                    <th>Minimum Price</th>
                                    <th>Total No of Properties</th>
                                </tr>
                                <?php
                                if (is_array($monthWiseProperty) && count($monthWiseProperty) > 0) {
                                    foreach ($addressList as $monthName => $monthVal) {
                                        $monthNum = sprintf("%02s", $monthVal["selectMonth"]);
                                        //echo $monthNum;
                                        $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
                                        //echo $monthName;
                                        ?>
                                        <tr>
                                            <td><?= $monthName ?></td>
                                            <td><?= Yii::$app->formatter->asCurrency($monthVal['avragePrice']) ?></td>
                                            <td><?= Yii::$app->formatter->asCurrency($monthVal['maxPrice']) ?></td>
                                            <td><?= Yii::$app->formatter->asCurrency($monthVal['minPrice']) ?></td>
                                            <td><?= $monthVal['totalProperty'] ?></td>

                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </table>
                            <?php
                        }
                    }
                    ?>
                </div>
                <?php
                $photos = $property->photos;
                $active = '';
                if (!empty($photos)) {
                    ?>
                    <div class="pdf-bottom-part">
                        <h4>Property Photo</h4>
                        <ul class="property-photos property-photos1">
                            <?php
                            if (isset($photos) && $photos != '') {
                                foreach ($photos as $key => $photo) {
                                    ?>
                                    <li>
                                        <?php
                                        if (isset($photo) && $photo != '') {
                                            $alias = $photo->getImageUrl($photo::THUMBNAIL);
                                            echo Html::img($alias);
                                        }
                                        //echo Html::img($alias);
                                        ?>
                                    </li>
                                    <?php
                                }
                            }
                            ?>  
                        </ul>
                    </div>
                    <?php
                }
                ?>
                <?php
                if (!empty($property->propertyFeatures)) {
                    ?>
                    <div class="pdf-bottom-part">
                        <h4>Property Photos</h4>
                        <ul class="property-photos">
                            <?php
                            foreach ($property->propertyFeatures as $feature) {
                                $photos = $feature->photos;
                                $itemListArr = $feature->featureItems;
                                if (count($itemListArr) > 0) {
                                    ?>
                                    <li><span><?= $feature->featureMaster->name ?></span>
                                        <?php
                                        if (count($photos) == 0) {
                                            echo Html::img(Yii::getAlias('@uploadsUrl/banner_image/no_image_avaliable.png'));
                                        } else {
                                            foreach ($photos as $key => $photo) {
                                                if ($key == 0) {
                                                    $active = 'active';
                                                } else {
                                                    $active = '';
                                                }
                                                if ($key == 0) {
                                                    if (isset($photo) && $photo != '') {
                                                        $alias = $photo->getImageUrl($photo::THUMBNAIL);
                                                        echo Html::img($alias);
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                    </div>
                    <?php
                }
                ?>
            </div>
            <!-- End Content Section ==================================================-->

    </body>
</html>