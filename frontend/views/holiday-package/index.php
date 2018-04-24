<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use common\models\BannerType;
Use common\models\Banner;
use common\models\HolidayPackage;
use common\models\VideoGallery;
$this->title                = "Holiday Package";

$this->registerJsFile(
    '@web/public_main/js/holiday-package.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

$banners                    =   [];
$destinationPackages        =   [];
$bannerType                 =   BannerType::findByName('Holiday Package');
$destinationBannerType      =   BannerType::findByName('Package Destinations');
if(!empty($bannerType)){
    $banners                =   Banner::find()->where(['type_id' => $bannerType->id])->orderBy(['sort_order' => SORT_ASC])->active()->all();
}
$holidayPackages            =   HolidayPackage::find()->orderBy(['id' => SORT_DESC])->active()->limit(4)->all();
if(!empty($destinationBannerType)){
    $destinationPackages    =   Banner::find()->where(['type_id' => $destinationBannerType->id])->orderBy(['sort_order' => SORT_ASC])->active()->all();
}

$packageVideo               =   VideoGallery::findByTitle('Holiday Package');

if(isset($packageVideo->youtube_video_code) && $packageVideo->youtube_video_code != ''){
    preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $packageVideo->youtube_video_code, $matches);
}


//yii\helpers\VarDumper::dump($holidayPackages,4,12); exit;
?>
<!-- Start Slider Section ==================================================-->
<figure class="bannerwithsearch">
    <!-- Home Slider -->
    <?php 
    if (!empty($banners)) {
    ?>
        <div id="slider" class="carousel slide carousel-fade" data-ride="carousel">
            <div class="carousel-inner" role="listbox">
                <?php
                foreach ($banners as $key => $banner) {
                    $bannerUrl      =   '';
                    $photo = $banner->photo;
                    $alias = $photo->getImageUrl();
                ?>
                <div class="item slider <?php echo $key == 0 ? 'active' : ''; ?>" style="background-image:url(<?php echo $photo->getImageUrl() ?>);">
                    <div class="slidercontent">
                        <div class="container">
                            <div class="figuretext"><?= $banner->title ? $banner->title : '' ?></div>
                            <div class="figuretextbottom"><?= $banner->description ? $banner->description : '' ?></div>
                        </div>
                    </div>
                </div>
                <?php 
                }
                ?>
            </div>
        </div>
    <?php 
    }
    ?>
    <!-- Home Slider -->

    <!-- Home Search Form -->
    <div class="searchhome searchHotel holiday-search">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="searchholder clearfix">
                        <div class="row">
                            <div class="searchbox agent-searchbox clearfix form-group-md">
                                <div class="col-sm-2 book-holiday-left">
                                    <h5>Book Holiday Packages</h5>
                                </div>
                                <div class="col-sm-10 book-holiday-right">
                                    <?= Html::beginForm(['holiday-package/search'], 'get', ['class' => 'frm_geocomplete frm_package_page_search','id' => 'holiday_package_form']) ?>
                                        <?= Html::hiddenInput('location_from', '', ['class' => 'package_search_location_from form-control','placeholder' => 'From'])?>
                                        <?= Html::hiddenInput('location_to', '', ['class' => 'package_search_location_to form-control','placeholder' => 'To'])?>
                                        <div class="col-sm-3">
                                            <?php echo $this->render('_from_location_suggestion');?>
                                        </div>
                                        <div class="col-sm-3">
                                            <?php echo $this->render('_to_location_suggestion');?>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="date-field">
                                                <select class="form-control package_search_travel_month" name="checkin">
                                                    <option value="">Month of travel(any)</option>
                                                    <option value="JUN2017">June 2017</option>
                                                    <option value="JUL2017">July 2017</option>
                                                    <option value="AUG2017">August 2017</option>
                                                    <option value="SEP2017">September 2017</option>
                                                    <option value="OCT2017">October 2017</option>
                                                    <option value="NOV2017">November 2017</option>
                                                    <option value="DEC2017">December 2017</option>
                                                </select>
                                                <!--<span><i class="fa fa-calendar" aria-hidden="true"></i></span>-->
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <?= Html::button('Search Now', ['class' => 'btn btn-button btn-block btn-md btn_search_holiday-package']) ?>
                                        </div>
                                    <?= Html::endForm() ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Home Search Form -->
</figure>
<!-- End Slider Section ==================================================-->
<!-- Start Content Section ==================================================-->
<section>
    <?php
    if(!empty($holidayPackages)){
    ?>
    <!-- Latest Holiday Packages Sec -->
    <div class="holiday-packages-sec">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h2>Latest Holiday Packages</h2>
                    <div class="holiday-packages-list-sec">
                        <?php
                        foreach($holidayPackages as $package){
                        ?>
                        <div class="col-sm-3">
                            <a href="<?= Url::to(['holiday-package/package-details', 'id' => $package->id])?>" class="holiday-packages-list">
                                <?php 
                                $photo                =   $package->photos; 
                                if(!empty($photo)){
                                    $alias = $photo[0]->getImageUrl($photo[0]::LARGE);
                                    echo Html::img($alias);
                                }
                                ?>
                                <p><?= $package->name ? $package->name : "" ?></p>
                            </a>
                        </div>
                        <?php 
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php 
    }
    ?>
    <!-- HLatest Holiday Packages Sec -->
    <!-- Destinations Sec -->
    <?php 
    if(!empty($destinationPackages)){
    ?>
        <div class="destinations-sec">
            <div class="container">
                <div class="row">
                    <h2>Find More destinations</h2>
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <?php 
                                        if(!empty($destinationPackages[0])){
                                            $photo = $destinationPackages[0]->photo;
                                            $alias = $photo->getImageUrl();
                                        ?>
                                            <a href="<?= Url::to(['holiday-package/package-list', 'city' => 'New York'])?>" class="destinations-img-list" style="background:url(<?php echo $photo->getImageUrl() ?>) no-repeat;">
                                                <span><?= $destinationPackages[0]->title ? $destinationPackages[0]->title : "" ?></span>
                                            </a>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="col-sm-7">
                                        <?php 
                                        if(!empty($destinationPackages[1])){
                                            $photo = $destinationPackages[1]->photo;
                                            $alias = $photo->getImageUrl();
                                        ?>
                                            <a href="<?= Url::to(['holiday-package/package-list', 'city' => 'Los Angeles'])?>" class="destinations-img-list" style="background:url(<?php echo $photo->getImageUrl() ?>) no-repeat;">
                                                <span><?= $destinationPackages[1]->title ? $destinationPackages[1]->title : "" ?></span>
                                            </a>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="col-sm-7">
                                        <?php 
                                        if(!empty($destinationPackages[2])){
                                            $photo = $destinationPackages[2]->photo;
                                            $alias = $photo->getImageUrl();
                                        ?>
                                            <a href="<?= Url::to(['holiday-package/package-list', 'city' => 'Holtsville'])?>" class="destinations-img-list" style="background:url(<?php echo $photo->getImageUrl() ?>) no-repeat;">
                                                <span><?= $destinationPackages[2]->title ? $destinationPackages[2]->title : "" ?></span>
                                            </a>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="col-sm-5">
                                        <?php 
                                        if(!empty($destinationPackages[3])){
                                            $photo = $destinationPackages[3]->photo;
                                            $alias = $photo->getImageUrl();
                                        ?>
                                            <a href="<?= Url::to(['holiday-package/package-list', 'city' => 'Washington'])?>" class="destinations-img-list" style="background:url(<?php echo $photo->getImageUrl() ?>) no-repeat;">
                                                <span><?= $destinationPackages[3]->title ? $destinationPackages[3]->title : "" ?></span>
                                            </a>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <?php 
                                if(!empty($destinationPackages[4])){
                                    $photo = $destinationPackages[4]->photo;
                                    $alias = $photo->getImageUrl();
                                ?>
                                    <a href="<?= Url::to(['holiday-package/package-list', 'city' => 'Austin'])?>" class="destinations-img-list destinations-img-list1" style="background:url(<?php echo $photo->getImageUrl() ?>) no-repeat;">
                                        <span><?= $destinationPackages[4]->title ? $destinationPackages[4]->title : "" ?></span>
                                    </a>
                                <?php
                                }
                                ?>
                                <a href="javascript:void(0)" class="find-more-btn">Find More</a>
                            </div>
                        </div>
                    </div>
                    <div class="destinations-bottom-sec">
                        <div class="col-sm-7 destinations-bottom-left">
                            <?php 
                            if(!empty($destinationPackages[5])){
                                $photo = $destinationPackages[5]->photo;
                                $alias = $photo->getImageUrl();
                            ?>
                                <a href="<?= Url::to(['holiday-package/package-list', 'city' => 'Chicago'])?>" class="destinations-img-list" style="background:url(<?php echo $photo->getImageUrl() ?>) no-repeat;">
                                    <div class="sideTxt">More Travel Ideas</div>
                                    <div class="ladakhTxt">
                                        <h4><?= $destinationPackages[5]->title ? $destinationPackages[5]->title : "" ?></h4>
                                        <p><?= $destinationPackages[5]->description ? $destinationPackages[5]->description : "" ?></p>
                                    </div>
                                </a>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="col-sm-5 destinations-bottom-right">
                            <?php
                            if(isset($matches[1]) && $matches[1] != ''){
                            ?>
                            <iframe width="100%" height="300" src="https://www.youtube.com/embed/<?= $matches[1]?>" frameborder="0" allowfullscreen></iframe>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php 
    }
    ?>
</section>