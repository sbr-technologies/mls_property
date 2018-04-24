<?php
use yii\helpers\Url;
use common\models\SavedSearch;

$ads = [];
$adLocation = common\models\AdvertisementLocationMaster::find()->where(['page' => 'Property Search Result'])->active()->one();
if(!empty($adLocation)){
    $ads = $adLocation->advertisements;
}
$popularSearchData  =   SavedSearch::find()->limit(5)->all();
?>
    <div class="property-listing-right-sec">
        <!-- Right ad -->
<!--        <div class="rightside-ad">
            <a href="javascript:void(0)"><img src="<?=Yii::$app->urlManager->baseUrl?>/public_main/images/side-ad-banner.jpg" alt=""></a>
        </div>-->
                    <?php 
                    foreach($ads as $ad){
                        if($ad->status == 'active'){
                        ?>
                        <div class="rightside-ad">
                            <div id="ad_my_carousel_<?= $ad->id?>" class="carousel slide" data-ride="carousel">
                                <!-- Wrapper for slides -->
                                <div class="carousel-inner">
                                    <?php foreach($ad->advertisementBanners as $key => $banner){?>
                                    <?php if($banner->status == 'active'){?>
                                    <div class="item <?php if($key == 0)echo 'active'?>">
                                        <a href="<?= Url::to(['advertisement/redirect', 'id' => $ad->id])?>" target="_blank">
                                            <img src="<?= $banner->photo->getImageUrl()?>" alt="">
                                        </a>
                                    </div>
                                    <?php }?>
                                <?php }?>
                                </div>
                            </div>
                        </div>
                        <?php } }?>
        <!-- Right ad -->

        <!-- Popular Searches -->
        <div class="property-listing-right-bar">
            <h3>Popular Searches</h3>
            <ul class="popular-searches-list">
                <?php error_reporting(0);
                if(!empty($popularSearchData)){
                    foreach($popularSearchData as $popularSeach){
                        $searchSrting = json_decode($popularSeach->search_string,true);
                        //yii\helpers\VarDumper::dump($searchSrting,4,12); exit;
                        if(isset($searchSrting['filters']['state'][0])){
                ?>
                        <li><a href="<?= $popularSeach->searchUrl?>" target="_blank"><?= implode(', ', array_filter([$searchSrting['filters']['town'][0],$searchSrting['filters']['state'][0],$searchSrting['filters']['min_price'],$searchSrting['filters']['max_price']]))?></a></li>
                <?php
                        }
                    }
                }
                ?>
            </ul>
        </div>
        <!-- Popular Searches -->

        <!-- Thinking of selling -->
<!--        <div class="property-listing-right-bar">
            <h3>Thinking of selling?</h3>
                <div class="thinking-selling-search-bar">
                    <div class="input-group">
                        <?= $this->render('//shared/_complete_address_suggestion.php', [])?>
                        <form action="<?= Url::to(['sell/estimate'])?>">
                            <input type="hidden" class="realestate_search_location" name="location" />
                        <div class="input-group-btn">
                            <button class="btn btn-default btn_get_property_estimate" type="submit"><i class="fa fa-share" aria-hidden="true"></i></button>
                        </div>
                        </form>
                    </div>
                </div>
        </div>-->
        <!-- Thinking of selling -->

        <!-- Right ad -->
<!--        <div class="rightside-ad">
            <a href="javascript:void(0)"><img src="<?=Yii::$app->urlManager->baseUrl?>/public_main/images/side-ad-banner.jpg" alt=""></a>
        </div>-->
<?php 
                    foreach($ads as $ad){
                        if($ad->status == 'active'){
                        ?>
                        <div class="rightside-ad">
                            <div id="ad_my_carousel_<?= $ad->id?>" class="carousel slide" data-ride="carousel">
                                <!-- Wrapper for slides -->
                                <div class="carousel-inner">
                                    <?php foreach($ad->advertisementBanners as $key => $banner){?>
                                    <?php if($banner->status == 'active'){?>
                                    <div class="item <?php if($key == 0)echo 'active'?>">
                                        <a href="<?= Url::to(['advertisement/redirect', 'id' => $ad->id])?>" target="_blank">
                                            <img src="<?= $banner->photo->getImageUrl()?>" alt="">
                                        </a>
                                    </div>
                                    <?php }?>
                                <?php }?>
                                </div>
                            </div>
                        </div>
                        <?php } }?>
        <!-- Right ad -->

        <!-- Popular Searches -->
<!--        <div class="property-listing-right-bar neighborhoods-sec">
            <h3>Nearby Neighborhoods</h3>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <th>Neighborhood</th>
                    <th>Average</th>
                </tr>
                <tr>
                    <td>Aorbi eifend Phar ens ritmris fring</td>
                    <td>$447,800</td>
                </tr>
                <tr>
                    <td>Morbi eifend Phar endre ritmris fringilla</td>
                    <td>$447,800</td>
                </tr>
                <tr>
                    <td>Rbi eifend Phar endre ritmris fringilla</td>
                    <td>$447,800</td>
                </tr>
            </table>

            <ul class="neighborhoods-listing">
                <li><a href="javascript:void(0)">Nearby Zips</a></li>
                <li><a href="javascript:void(0)">Nearby Cities</a></li>
                <li><a href="javascript:void(0)">Nearby Counties</a></li>
                <li><a href="javascript:void(0)">More Bedroom Types in London</a></li>
                <li><a href="javascript:void(0)">More Property Types in London </a></li>
            </ul>
            <a href="javascript:void(0)" class="all-real-estate-link">All real estate in London</a>
        </div>-->
        <!-- Popular Searches -->

        <!-- Thinking of selling -->
<!--        <div class="property-listing-right-bar calculator-form">
            <h3>Moving Cost Calculator</h3>
            <form action="" method="post">
                <div class="form-group">
                    <label for="">Move Form</label>
                    <input type="text" class="form-control" placeholder="Zip Code">
                </div>
                <div class="form-group">
                    <label for="">Move To</label>
                    <input type="text" class="form-control" placeholder="Zip Code">
                </div>
                <div class="form-group">
                    <label for="">Size of Move</label>
                    <select name="" class="selectpicker">
                        <option>Studio</option>
                        <option>1 Bedroom</option>
                        <option>2 Bedroom</option>
                        <option>2-3 Bedroom</option>
                        <option>3 Bedroom</option>
                        <option>4 Bedroom</option>
                        <option>5 Bedroom</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Packing</label>
                    <select name="" class="selectpicker">
                        <option>None</option>
                        <option>Partial</option>
                        <option>Full</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-default">Get Estimates</button>
            </form>
        </div>-->
        <!-- Thinking of selling -->

    </div>