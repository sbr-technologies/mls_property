<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use common\models\News;
use common\models\StaticPage;



//$this->params['breadcrumbs'][] = $this->title;
$staticPage = StaticPage::findByName('News & Advices');
//yii\helpers\VarDumper::dump($newsDetails->photo); exit;
//yii\helpers\VarDumper::dump($newsCategory); exit;
$this->title = $newsCategory->name;



?>
<section>
    <div class="container">
        <div class="row">
            <div class="news-advices-sec">
                <div class="news-advices-top-sec">
                    <div class="col-sm-6">
                        <div class="latest-news-listing-sec">
                            <h2><?= $newsCategory->name ?></h2>
                            <div id="carousel-pager" class="carousel slide " data-ride="carousel" data-interval="500000000">
                                <div class="carousel-inner vertical">
                                    <?php
                                    if (!empty($newsDetails)) {
                                        foreach ($newsDetails as $key => $news) {
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
                                                            <a href="<?php echo Url::to(['news/news-view','id' => $news->id]) ?>"><img src="<?= $news->photo->imageUrl ?>" alt=""></a>
                                                        </div>
                                                        <div class="col-sm-9 latest-news-listing-con">
                                                            <p><?= $news->getReadMore($news->content); ?></p>
                                                            <span>11 hours ago</span>
                                                            <a href="<?php echo Url::to(['news/news-view','id' => $news->id]) ?>">Read More</a>
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
                                if(count($newsDetails) > 3){
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

                    <div class="col-sm-6 news-advice-img">
                        <?php
                        if (!empty($staticPage)) {
                        ?>
                            <img src="<?= $staticPage->photos[0]->imageUrl ?>" alt="">
                        <?php
                        }
                        ?>
                        
                    </div>
                </div>

                <div class="news-advices-bottom-sec">
                    <div class="col-sm-6">
                        <h2>Real Advices</h2>
                        <div class="real-advices-listing-sec">
                            <div class="real-advices-listing">
                                <div class="row">
                                    <div class="col-sm-6 real-advices-listing-con">
                                        <h3>Minvenen atis sem non ante accd sumsan tristiq</h3>
                                        <p>Nulla id auctor metus. Nulla facilisi. Vestibulum vehicula convallis arcu, quis tristique ante laoreet facilisis. Proin</p>
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
                                        <p>Nulla id auctor metus. Nulla facilisi. Vestibulum vehicula convallis arcu, quis tristique ante laoreet facilisis. Proin</p>
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

                    <div class="col-sm-6">
                        <div class="news-tab-listing-sec">
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#buy" aria-controls="buy" role="tab" data-toggle="tab">Buy</a></li>
                                <li role="presentation"><a href="#sell" aria-controls="sell" role="tab" data-toggle="tab">Sell</a></li>
                                <li role="presentation"><a href="#rent" aria-controls="rent" role="tab" data-toggle="tab">Rent</a></li>
                            </ul>

                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="buy">
                                    <div class="news-tab-listing">
                                        <div class="row">
                                            <div class="col-sm-8 news-tab-listing-con">
                                                <p>Cras auctor justo at ligula egestas tempor vitae ut velit. Sus pendisse dictum sapien et rhoncus.</p>
                                                <span>2 hours ago</span>
                                                <a href="javascript:void(0)">Know More</a>
                                            </div>
                                            <div class="col-sm-4 news-tab-listing-img">
                                                <a href="javascript:void(0)">
                                                    <img src="<?=Yii::$app->urlManager->baseUrl?>/public_main/images/news-tab-img1.jpg" alt="">
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="news-tab-listing">
                                        <div class="row">
                                            <div class="col-sm-8 news-tab-listing-con">
                                                <p>Cras auctor justo at ligula egestas tempor vitae ut velit. Sus pendisse dictum sapien et rhoncus.</p>
                                                <span>18 hours ago</span>
                                                <a href="javascript:void(0)">Know More</a>
                                            </div>
                                            <div class="col-sm-4 news-tab-listing-img">
                                                <a href="javascript:void(0)">
                                                    <img src="<?=Yii::$app->urlManager->baseUrl?>/public_main/images/news-tab-img2.jpg" alt="">
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="news-tab-listing">
                                        <div class="row">
                                            <div class="col-sm-8 news-tab-listing-con">
                                                <p>Cras auctor justo at ligula egestas tempor vitae ut velit. Sus pendisse dictum sapien et rhoncus.</p>
                                                <span>6 hours ago</span>
                                                <a href="javascript:void(0)">Know More</a>
                                            </div>
                                            <div class="col-sm-4 news-tab-listing-img">
                                                <a href="javascript:void(0)">
                                                    <img src="<?=Yii::$app->urlManager->baseUrl?>/public_main/images/news-tab-img3.jpg" alt="">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div role="tabpanel" class="tab-pane" id="sell">
                                    <div class="news-tab-listing">
                                        <div class="row">
                                            <div class="col-sm-8 news-tab-listing-con">
                                                <p>Cras auctor justo at ligula egestas tempor vitae ut velit. Sus pendisse dictum sapien et rhoncus.</p>
                                                <span>18 hours ago</span>
                                                <a href="javascript:void(0)">Know More</a>
                                            </div>
                                            <div class="col-sm-4 news-tab-listing-img">
                                                <a href="javascript:void(0)">
                                                    <img src="<?=Yii::$app->urlManager->baseUrl?>/public_main/images/news-tab-img2.jpg" alt="">
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="news-tab-listing">
                                        <div class="row">
                                            <div class="col-sm-8 news-tab-listing-con">
                                                <p>Cras auctor justo at ligula egestas tempor vitae ut velit. Sus pendisse dictum sapien et rhoncus.</p>
                                                <span>2 hours ago</span>
                                                <a href="javascript:void(0)">Know More</a>
                                            </div>
                                            <div class="col-sm-4 news-tab-listing-img">
                                                <a href="javascript:void(0)">
                                                    <img src="<?=Yii::$app->urlManager->baseUrl?>/public_main/images/news-tab-img1.jpg" alt="">
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="news-tab-listing">
                                        <div class="row">
                                            <div class="col-sm-8 news-tab-listing-con">
                                                <p>Cras auctor justo at ligula egestas tempor vitae ut velit. Sus pendisse dictum sapien et rhoncus.</p>
                                                <span>6 hours ago</span>
                                                <a href="javascript:void(0)">Know More</a>
                                            </div>
                                            <div class="col-sm-4 news-tab-listing-img">
                                                <a href="javascript:void(0)">
                                                    <img src="<?=Yii::$app->urlManager->baseUrl?>/public_main/images/news-tab-img3.jpg" alt="">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div role="tabpanel" class="tab-pane" id="rent">
                                    <div class="news-tab-listing">
                                        <div class="row">
                                            <div class="col-sm-8 news-tab-listing-con">
                                                <p>Cras auctor justo at ligula egestas tempor vitae ut velit. Sus pendisse dictum sapien et rhoncus.</p>
                                                <span>6 hours ago</span>
                                                <a href="javascript:void(0)">Know More</a>
                                            </div>
                                            <div class="col-sm-4 news-tab-listing-img">
                                                <a href="javascript:void(0)">
                                                    <img src="<?=Yii::$app->urlManager->baseUrl?>/public_main/images/news-tab-img3.jpg" alt="">
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="news-tab-listing">
                                        <div class="row">
                                            <div class="col-sm-8 news-tab-listing-con">
                                                <p>Cras auctor justo at ligula egestas tempor vitae ut velit. Sus pendisse dictum sapien et rhoncus.</p>
                                                <span>18 hours ago</span>
                                                <a href="javascript:void(0)">Know More</a>
                                            </div>
                                            <div class="col-sm-4 news-tab-listing-img">
                                                <a href="javascript:void(0)">
                                                    <img src="<?=Yii::$app->urlManager->baseUrl?>/public_main/images/news-tab-img2.jpg" alt="">
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="news-tab-listing">
                                        <div class="row">
                                            <div class="col-sm-8 news-tab-listing-con">
                                                <p>Cras auctor justo at ligula egestas tempor vitae ut velit. Sus pendisse dictum sapien et rhoncus.</p>
                                                <span>2 hours ago</span>
                                                <a href="javascript:void(0)">Know More</a>
                                            </div>
                                            <div class="col-sm-4 news-tab-listing-img">
                                                <a href="javascript:void(0)">
                                                    <img src="<?=Yii::$app->urlManager->baseUrl?>/public_main/images/news-tab-img1.jpg" alt="">
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
    </div>
</section>

