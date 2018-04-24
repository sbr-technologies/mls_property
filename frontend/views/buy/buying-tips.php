<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use common\models\StaticPage;
use common\models\News;
use common\models\NewsCategory;


//$this->params['breadcrumbs'][] = $this->title;
$staticPage = StaticPage::findByName('News & Advices');
//yii\helpers\VarDumper::dump($newsDetails->photo); exit;
//yii\helpers\VarDumper::dump($adviceCategory); exit;
$this->title = $adviceCategory->name;

$newsListAr     = News::find()->orderBy(['id' => SORT_DESC])->all();

?>
<section>
    <?php
    if(!empty($newsListAr)){
    ?>
    <div class="news-feed-sec">
        <div class="container">
            <div class="row">
                <div id="news-feed-list" class="owl-carousel owl-theme news-feed-list-sec">
                    <?php
                    foreach($newsListAr as $news){
                    ?>
                    <div class="item" style="text-align:left;">
                        <h6 style="margin-left:10px;"><?= $news->newsCategory->name ?></h6>
                        <a href="<?php echo Url::to(['news/news-view','id' => $news->id]) ?>" class="news-feed-listing" style="background:url('<?= $news->photo->imageUrl ?>') no-repeat;">
                            <div class="news-feed-list-con">
                                <h2><?= $news->title ?></h2>
                                <p><?= $news->getReadMore($news->content); ?></p>
                            </div>
                        </a>
                    </div>
                    <?php 
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
    <div class="container">
        <div class="row">
            <div class="news-advices-sec">
                <div class="news-advices-top-sec">
                    <div class="col-sm-8">
                        <div class="latest-news-listing-sec">
                            <h2><?= $adviceCategory->name ?></h2>
                            <div id="carousel-pager" class="carousel slide " data-ride="carousel" data-interval="500000000">
                                <div class="carousel-inner vertical">
                                    <?php
                                    if (!empty($adviceDetails)) {
                                        foreach ($adviceDetails as $key => $advice) {
                                            if($key == 0){
                                                $active     =   "active";
                                            }else{
                                                $active     =   "";
                                            }
                                    ?>
                                            <div class="<?= $active ?> item">
                                                <div class="latest-news-listing">
                                                    <div class="row">
                                                        <div class="col-sm-3 latest-news-listing-img">
                                                            <a href="javascript:void(0)"><img src="<?= $advice->photo->imageUrl ?>" alt=""></a>
                                                        </div>
                                                        <div class="col-sm-9 latest-news-listing-con">
                                                            <h4><strong><?= $advice->title ?></strong></h4>
                                                            <p><?= $advice->getReadMore($advice->content); ?></p>
                                                            <span>11 hours ago</span>
                                                            <a href="<?php echo Url::to(['news/advice-view','id' => $advice->id]) ?>">Read More</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php
                                        }
                                    }
                                    ?>
                                </div>  
                                <?php 
                                if(count($adviceDetails) > 3){
                                ?>
                                <a class="left carousel-control" href="#carousel-pager" role="button" data-slide="prev">
                                    <i class="fa fa-angle-up" aria-hidden="true"></i>
                                </a>
                                <a class="right carousel-control" href="#carousel-pager" role="button" data-slide="next">
                                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                                </a>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="latest-news-listing-sec">
                            <h2>Real Advices</h2>
                            <div class="real-advices-listing-sec">
                                <div class="real-advices-listing">
                                    <div class="row">
                                        <div class="col-sm-6 real-advices-listing-con">
                                            <h3>Minvenen atis sem non ante accd sumsan tristiq</h3>
                                            <a href="javascript:void(0)">Know More</a>
                                        </div>

                                        <div class="col-sm-6 real-advices-listing-img">
                                            <a href="javascript:void(0)">
                                                <img src="<?=Yii::$app->urlManager->baseUrl?>/public_main/images/real-advices-img1.jpg" alt="">
                                                <div class="real-advices-listing-video" data-toggle="modal" data-target="#advicesVideoModal"><i class="fa fa-play-circle-o" aria-hidden="true"></i></div>
                                            </a>

                                        </div>
                                    </div>
                                </div>

                                <div class="real-advices-listing">
                                    <div class="row">
                                        <div class="col-sm-6 real-advices-listing-con">
                                            <h3>Minvenen atis sem non ante accd sumsan tristiq</h3>
                                            <a href="javascript:void(0)">Know More</a>
                                        </div>

                                        <div class="col-sm-6 real-advices-listing-img">
                                            <a href="javascript:void(0)">
                                                <img src="<?=Yii::$app->urlManager->baseUrl?>/public_main/images/real-advices-img2.jpg" alt="">
                                            </a>
                                        </div>
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

