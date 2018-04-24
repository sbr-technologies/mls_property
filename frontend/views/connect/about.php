<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use common\models\StaticPage;
use yii\helpers\Url;
use common\models\Banner;
use common\models\BannerType;


//$this->params['breadcrumbs'][] = $this->title;

$staticPage = StaticPage::findByName('About us');

$this->title = $staticPage->pageTitle;
$this->registerMetaTag([
    'name' => 'description',
    'content' => $staticPage->meta_description
]);
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => $staticPage->meta_keywords
]);

$bannerType     = BannerType::findByName('Our Brands');


$banners = Banner::find()->where(['type_id' => $bannerType->id])->orderBy(['sort_order' => SORT_ASC])->active()->all();

//\yii\helpers\VarDumper::dump($banners,4,12);exit;

?>
<section>
    <div class="about-top-part">
        <img src="<?= $staticPage->photos[0]->imageUrl ?>" alt="">
        <div class="about-top-con">
            <h2>About Us</h2>
        </div>
    </div>

    <div class="inner-content-sec">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="about-sec">
                        <?php
                        if (!empty($staticPage)) {
                            echo $staticPage->content;
                        }
                        ?>

                        <h2>Our Brands</h2>
                        <?php
                        if (!empty($banners)) {
                        ?>
                            <ul>
                            <?php
                                foreach ($banners as $key => $banner) {
                                    $bannerUrl      =   '';
                                    $photo = $banner->photo;
                            ?>
                                <li><img src="<?= $photo->getImageUrl() ?>" alt=""></li>
                            <?php
                                }
                            ?>
                            </ul>
                        <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

