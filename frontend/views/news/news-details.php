<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'News Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<section>
    <div class="news-details-top-part">
        <img src="<?=Yii::$app->urlManager->baseUrl?>/public_main/images/news-detailsBG.jpg" alt="">
    </div>

    <div class="inner-content-sec">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="news-details-sec">
                        <h2>Proin venenatis sem non ante accumsan tristiqd uen non alique</h2>
                        <p>This is Photoshop's version  of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non  mauris vitae erat consequat auctor eu in elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue. Sed non neque elit. Sed ut imperdiet nisi. Proin condimentum fermentum nunc. Etiam pharetra, erat sed fermentum feugiat, velit mauris egestas quam, ut aliquam massa nisl quis neque. Suspendisse in orci enim. This is Photoshop's version  of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non  mauris vitae erat consequat auctor eu in elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue. Sed non neque elit. Sed ut imperdiet nisi. Proin condimentum fermentum nunc. Etiam pharetra, erat sed fermentum feugiat.<p>

                        <p>This is Photoshop's version  of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non  mauris vitae erat consequat auctor eu in elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue. Sed non neque elit. Sed ut imperdiet nisi. Proin condimentum fermentum nunc. Etiam pharetra, erat sed fermentum feugiat, velit mauris egestas quam, ut aliquam massa nisl quis neque. Suspendisse in orci enim. This is Photoshop's version  of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="news-similar-topic">
        <div class="container">
            <div class="row">
                <h2>Similar Topics</h2>
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="latest-news-listing">
                                <div class="row">
                                    <div class="col-sm-3 latest-news-listing-img">
                                        <a href="javascript:void(0)">
                                            <img src="<?=Yii::$app->urlManager->baseUrl?>/public_main/images/latest-news-img1.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="col-sm-9 latest-news-listing-con">
                                        <p>Proin venenatis sem non ante accumsan tristiqd uen non alique tmi. Nam lobortis urna sed. Proin venenatis sem non </p>
                                        <span>11 hours ago</span>
                                        <a href="<?php echo Url::to(['site/news-details']) ?>">Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="latest-news-listing">
                                <div class="row">
                                    <div class="col-sm-3 latest-news-listing-img">
                                        <a href="javascript:void(0)">
                                            <img src="<?=Yii::$app->urlManager->baseUrl?>/public_main/images/latest-news-img2.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="col-sm-9 latest-news-listing-con">
                                        <p>Proin venenatis sem non ante accumsan tristiqd uen non alique tmi. Nam lobortis urna sed. Proin venenatis sem non </p>
                                        <span>8 hours ago</span>
                                        <a href="<?php echo Url::to(['site/news-details']) ?>">Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="latest-news-listing">
                                <div class="row">
                                    <div class="col-sm-3 latest-news-listing-img">
                                        <a href="javascript:void(0)">
                                            <img src="<?=Yii::$app->urlManager->baseUrl?>/public_main/images/latest-news-img3.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="col-sm-9 latest-news-listing-con">
                                        <p>Proin venenatis sem non ante accumsan tristiqd uen non alique tmi. Nam lobortis urna sed. Proin venenatis sem non </p>
                                        <span>6 hours ago</span>
                                        <a href="<?php echo Url::to(['site/news-details']) ?>">Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="latest-news-listing">
                                <div class="row">
                                    <div class="col-sm-3 latest-news-listing-img">
                                        <a href="javascript:void(0)">
                                            <img src="<?=Yii::$app->urlManager->baseUrl?>/public_main/images/latest-news-img1.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="col-sm-9 latest-news-listing-con">
                                        <p>Proin venenatis sem non ante accumsan tristiqd uen non alique tmi. Nam lobortis urna sed. Proin venenatis sem non </p>
                                        <span>11 hours ago</span>
                                        <a href="<?php echo Url::to(['site/news-details']) ?>">Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

