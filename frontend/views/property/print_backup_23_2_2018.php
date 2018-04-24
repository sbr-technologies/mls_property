<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&key=<?= Yii::$app->params['googleMapKey']?>"></script>
<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use common\models\Property;


?>
<style type="text/css">
    /* Import styles --------------------------------------------------------*/
    @import url("https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,800italic,800,700italic,700,600italic");

    /* Standar Styles --------------------------------------------------------*/
    * { margin:0px; padding:0px; outline:none; }
    img { margin:0px; padding:0px; outline:none; max-width:100%; }
    body { margin:0; font-size: 16px; color: #333; font-family: 'Open Sans', sans-serif; }
    a { color: #b51318; text-decoration:none; outline:none; 
            -webkit-transition: all 0.4s linear;
            -moz-transition: all 0.4s linear;
            -o-transition: all 0.4s linear;
            transition: all 0.4s linear;
    }
    a:hover { text-decoration: none; color: #222; }
    a:focus { outline:none; text-decoration:none; }
    input[type="file"]:focus,
    input[type="radio"]:focus,
    input[type="checkbox"]:focus { outline: none; outline: none; outline-offset: inherit; }
    img { margin:0px; padding:0px; outline:none; border:none; max-width:100%; max-height:100%; }
    p { padding: 0; line-height:24px; margin-bottom:30px; }
    li {  }

    h1, h2, h3, h4, h5, h6 { font-weight: normal; padding: 0; margin:0; font-family: 'Open Sans'; color:#333; }
    h1 { font-size:36px; }
    h2 { font-size:30px; }
    h3 { font-size:24px; }
    h4 { font-size:18px; }
    h5 { font-size:16px; }
    h6 { font-size:14px; }

    /* Start Content Styles --------------------------------------------------*/
    .main-wrapper { width:1000px; height:auto; margin:auto; background:#f9f9f9; position:relative; }
    .main-wrapper h1 { font-size:30px; font-weight:600; margin-bottom:20px; }
    .main-wrapper h2 { font-size:30px; font-weight:600; margin:0 0 20px; }
    .main-wrapper h3 { font-size:24px; margin:15px 0; }
    .top-logo-sec { position:relative; z-index:5; padding:50px 0 0 80px; }
    .triangle-topleft { width:0; height: 0; border-top: 125px solid #b51318; border-right: 125px solid transparent; position:absolute; left:0; top:0; }

    .pdf-top-part { text-align:center; margin:30px 0; }
    .pdf-top-part .pdf-main-img { border:1px #ddd solid; padding:8px; background:#fff; }
    .top-address-part { width:54%; display:inline-block; margin:40px 0 20px; }
    .top-address-part p { text-align:left; width:50%; float:left; line-height:28px; }

    .pdf-top-part ul { margin:20px 0 40px; padding:0 50px; }
    .pdf-top-part ul li { font-size:18px; list-style:disc inside; color:#333; line-height:24px; padding:8px 0; text-align:left; width:100%; }
    .pdf-top-part iframe { border:1px #ddd solid; padding:8px; background:#fff; }
    .pdf-middle-part { text-align:center; margin:30px 0 0; padding: 0 50px; }


    .table-listing { margin:15px 0 40px; border:1px #ddd solid; }
    .table-listing th { background:#b51318; color:#fff; padding:8px; text-align:center; border-right:1px #fff solid; }
    .table-listing td { padding:8px; text-align:center; border-bottom:1px #ddd solid; border-right:1px #ddd solid; }
    .table-listing .last-list { background:#eee; }
    .listing-sold-active tr th:first-child, .listing-sold-active tr td:first-child { text-align:left; }

    .pdf-bottom-part { width:100%; display:inline-block; text-align:center; margin:30px 0; }
    .pdf-bottom-part h3 { font-weight:600; }
    .pdf-bottom-part .property-photos { list-style:none; margin:40px auto 0; padding:0 50px;  }
    .pdf-bottom-part .property-photos li { list-style:none; width:44%; float:left; margin:0; padding:3%; }
    .pdf-bottom-part .property-photos li span { font-size:18px; color:#000; text-transform:uppercase; margin-bottom:10px; display:block; }
    .pdf-bottom-part .property-photos li img { width:100%; border:1px #ddd solid; padding:6px; background:#fff; }
    .pdf-bottom-part .property-photos1 li { list-style:none; width:20%; float:left; margin:0; padding:0.5%; }

    .pdf-footer-part { margin-top:20px; }
    .pdf-footer-part p { text-align:center; margin-bottom:10px; color:#000; font-size:14px; }
    .pdf-footer-inner { background:#b51318 url(../images/footer-icon.png) no-repeat 96% center; padding:15px 0; }
    .pdf-footer-inner p { color:#fff; padding:0 100px; font-size:17px; line-height:28px; }
</style>
<!-- Start Content Section ==================================================-->
<div class="main-wrapper">
    <div class="top-logo-sec" style="text-align:center">
        <!--<div class="triangle-topleft"></div>-->
        <img src="<?=Yii::$app->urlManager->baseUrl?>/public_main/images/logo.png" alt="" height="70">
    </div>
    <div class="pdf-top-part">
        <h2>Exclusive Multi-Family Offering Memorandum</h2>
        <?php
        $photos                 =   $property->photos; 
        $active                 =   '';
        if(!empty($photos)){
            if(isset($photos) && $photos != ''){
                $alias = $photos[0]->getImageUrl($photos[0]::LARGE);
                echo Html::img($alias,['class' => 'pdf-main-img']);
            }
        }
        ?>
        <h4><?= $property->formattedAddress ?><br>
        <?= $property->price ?></h4>
        <?php 
        $agency = $property->user->agency;
        if(!empty($agency)){
        ?>
        
        <div class="top-address-part">
            <h4>Agency Details</h4>
            <p>
                <?= $agency->name ? $agency->name : "" ?>
                <?= $agency->formattedAddress ?>
            </p>
            <p>
                <?= $agency->mobile1 ? "<span><b>Phone:</b>". $agency->getOffice1()."</span><br>" : ""; ?>
                <?= $agency->email ? "<span><a href='mailto:".$agency->email."'>".$agency->email."</a></span>" : "" ?>
            </p>
        </div>
        <?php 
        }
        ?>
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
        
        $map_url = 'https://maps.googleapis.com/maps/api/staticmap?center='.$formatted_address.'&zoom=12&size=600x300&maptype=roadmap&markers=color:red%7C'.$lat.','.$lng;
        //\yii\helpers\VarDumper::dump($map_url); exit;
        echo $map_image = '<img src="'.$map_url.'" height="450" width="700" />';
        ?>
        <!--<p><iframe src="<?= $map_url ?>" width="700" height="450" frameborder="0" allowfullscreen></iframe></p>-->
    </div>

    <div class="pdf-middle-part">
        <h4>Property Summary</h4>
        <?php
        if(!empty($property->propertyPriceHistories)){
        ?>
        <h5>Average Price Nearby <?= $property->formattedAddress ?></h5>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-listing">
                <tr>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Price</th>
                </tr>
                <?php
                foreach($property->propertyPriceHistories as $propertyHistory){
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
        $activeSql = "SELECT *, ( 3959 * acos( cos( radians(".$property->lat.") ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(".$property->lng.") ) + sin( radians('%s') ) * sin( radians( lat ) ) ) ) AS distance FROM mls_property where property_category_id = 2 AND town='".$property->town."' AND state='".$property->state."' AND status='".Property::STATUS_ACTIVE."' HAVING distance < 100000 order by distance asc LIMIT 0 , 20";
        $activeProperty     =   Property::findBySql($activeSql)->all();
            // \yii\helpers\VarDumper::dump($activeProperty,4,12); exit;
        if(!empty($activeProperty)){
            $finalActiveData[]  =   [
                                        'address'           => $property->formattedAddress,
                                        'no_of_room'        => $property->no_of_room,
                                        'no_of_bathroom'    => $property->no_of_bathroom,
                                        'price'             => $property->price,
                                        //'size'              =>  $property->size,
                                        'lot_size'          => $property->lot_size,
                                        'distance'          => 0    
                                    ];
            foreach($activeProperty as $active){
                $finalActiveData[]  =   [
                                            'address'       => $active->formattedAddress,
                                            'no_of_room'    => $active->no_of_room,
                                            'no_of_bathroom'=>  $active->no_of_bathroom,
                                            'price'         =>  $active->price,
                                            //'size'          =>  $active->size,
                                            'lot_size'      =>  $active->lot_size,
                                            'distance'      => round($active->distance). 'Mi'
                                        ];
            }
            if(!empty($finalActiveData)){
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
                    foreach($finalActiveData as $activeData){
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
        $soldSql = "SELECT *, ( 3959 * acos( cos( radians(".$property->lat.") ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(".$property->lng.") ) + sin( radians('%s') ) * sin( radians( lat ) ) ) ) AS distance FROM mls_property where property_category_id = 2 AND town='".$property->town."' AND state='".$property->state."' AND status='".Property::STATUS_SOLD."' HAVING distance < 100000 order by distance asc LIMIT 0 , 20";
        $soldProperty       =   Property::findBySql($soldSql)->all();
        //\yii\helpers\VarDumper::dump($soldProperty,4,12); exit;
        if(!empty($soldProperty)){
            $finalSoldData    =   [];
            foreach($soldProperty as $sold){
                $finalSoldData[]    =   [
                                        'address'          => $sold->formattedAddress,
                                        'no_of_room'        => $sold->no_of_room,
                                        'no_of_bathroom'    =>  $sold->no_of_bathroom,
                                        'price'             =>  $sold->price,
                                       // 'size'              =>  $sold->size,
                                        'lot_size'          =>  $sold->lot_size,
                                        'distance'          => round($sold->distance). 'Mi'
                                    ];
            }
            if(!empty($finalSoldData)){
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
                    foreach($finalSoldData as $soldData){
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
        $addressList= Yii::$app->db->createCommand("SELECT count(id) as totalProperty,AVG(price) as avragePrice,MAX(price) as maxPrice,MIN(price) as minPrice, MONTH(FROM_UNIXTIME(created_at)) AS selectMonth,street_address,area,town,state,country,zip_code, lat, lng, ( 3959 * acos( cos( radians(".$property->lat.") ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(".$property->lng.") ) + sin( radians('%s') ) * sin( radians( lat ) ) ) ) AS distance FROM mls_property where town='".$property->town."' AND state='".$property->state."' AND status <> '".Property::STATUS_INACTIVE."' GROUP BY selectMonth HAVING distance < 1500000 order by distance asc LIMIT 0 , 20")->queryAll();
        if(is_array($addressList) && count($addressList)){
            foreach($addressList as $address){
                $monthWiseProperty[$address['selectMonth']] =   $address;
            } 
            if(!empty($monthWiseProperty)){
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
                    if(is_array($monthWiseProperty) && count($monthWiseProperty) > 0){
                        foreach($addressList as $monthName => $monthVal){
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
    $photos                 =   $property->photos; 
    $active                 =   '';
    if(!empty($photos)){
        ?>
        <div class="pdf-bottom-part">
            <h4>Property Photo</h4>
            <ul class="property-photos property-photos1">
                <?php
                if(isset($photos) && $photos != ''){
                    foreach ($photos as $key => $photo) {
                        ?>
                        <li>
                        <?php
                            if(isset($photo) && $photo != ''){
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
    if(!empty($property->propertyFeatures)){
    ?>
        <div class="pdf-bottom-part">
            <h4>Property Photos</h4>
            <ul class="property-photos">
                <?php
                foreach($property->propertyFeatures as $feature){ 
                    $photos = $feature->photos;
                    $itemListArr   =   $feature->featureItems;
                    if(count($itemListArr) > 0){
                    ?>
                        <li><span><?= $feature->featureMaster->name  ?></span>
                            <?php
                            if(count($photos) == 0){
                                echo Html::img(Yii::getAlias('@uploadsUrl/banner_image/no_image_avaliable.png'));
                            }else{
                                foreach ($photos as $key => $photo) {
                                    if($key == 0){
                                        $active     =   'active';
                                    }else{
                                        $active     =   '';
                                    }
                                    if($key == 0){
                                        if(isset($photo) && $photo != ''){
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
    <div class="pdf-footer-part">
        <p><?= $property->formattedAddress ?></p>
        <div class="pdf-footer-inner">
            <p>This report has been prepared based on information furnished by sources deemed reliable, however no representation or warranty, either expressed or implied, is made to its accuracy.</p>
        </div>
    </div>
</div>
<!-- End Content Section ==================================================-->

