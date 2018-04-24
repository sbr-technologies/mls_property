<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use common\models\News;



$this->title = "Buying Tips";
//\yii\helpers\VarDumper::dump($buyingModel); exit;

?>
<section>
    <div class="container">
        <div class="row">
            <div class="news-advices-sec">
                <div class="news-advices-bottom-sec">
                    <div class="col-sm-8">
                        <h2>Buying Tips</h2>
                        <div style="height:15px;"></div>
                        <?php 
                        if(!empty($buyingModel)){
                        ?>
                        <div class="real-advices-listing">
                            <?php 
                            foreach($buyingModel as $buying){
                            ?>
                            <div class="row">
                                <div class="col-sm-4 real-advices-listing-img">
                                    <a href="javascript:void(0)">
                                        <img src="<?= $buying->photos[0]->imageUrl ?>" alt="">
                                    </a>
                                </div>
                                <div class="col-sm-8 real-advices-listing-con">
                                    <h3><?= $buying->title ?></h3>
                                    <p><?= $buying->content  ?></p>
                                    <a href="javascript:void(0)">Know More</a>
                                </div>
                            </div>
                            <?php 
                            }
                            ?>
                        </div>
                        <?php 
                        }
                        ?>
                    </div>

                    <div class="col-sm-4">
                        <div class="news-tab-listing-sec">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

