<?php

use yii\helpers\Html;
use common\models\Agent;
use yii\helpers\Url;
use frontend\helpers\PropertyHelper;
use common\models\Property;
use common\helpers\StringMod;
use common\models\PhotoGallery;
use yii\widgets\LinkPager;
use common\models\Agency;
use kartik\rating\StarRating;
$this->title = 'Agency List';
$agencyArr = $dataProvider->getModels();
//\yii\helpers\VarDumper::dump($town); exit;
?>
<section>
    <!-- Property Menu Bar -->
    <?php
    echo $this->render('//shared/_agency_search_filtter', ['filters' => $filters, 'sortBy' => $sortBy]);
//        \yii\helpers\VarDumper::dump($agencyArr,12,1); exit;
    ?>
    <!-- Property Menu Bar -->

    <div class="inner-content-sec">
        <div class="container agent_search_result_container">
            <div class="row">
                <div class="col-sm-9">
                    <div class="find-agent-top-part"><div class="col-sm-6">Agency: <span><?= $dataProvider->totalCount ?> <?php if($dataProvider->totalCount == 1) echo 'Agency';else echo 'Agencies';?> Found</span></div>
                        <div class="col-sm-6"><div class="pull-right">
                                <span class="sort-by">Sort by:</span>
                                <select class="pull-right sort_items_by property-listing-select">
                                    <option value="<?= Agency::SORT_NAME ?>" <?php if ($sortBy == Agency::SORT_NAME) echo 'selected' ?>>Name</option>
                                    <option value="<?= Agency::SORT_HIGHEST_RATINGS ?>" <?php if ($sortBy == Agency::SORT_HIGHEST_RATINGS) echo 'selected' ?>>Highest Ratings</option>
                                    <option value="<?= Agency::SORT_MOST_RECOMMENDATIONS ?>" <?php if ($sortBy == Agency::SORT_MOST_RECOMMENDATIONS) echo 'selected' ?>>Most Recommendations</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="agent-listing-sec">
                        <?php
                        foreach($agencyArr as $agency){
                        ?>
                        <div class="agent-listing">
                            <div class="agent-listing-img">
                                <a href="<?= Url::to(['agency/view', 'slug' => $agency->slug])?>" target="_blank"><img src="<?= !empty($agency->photo)?$agency->photo->getImageUrl(PhotoGallery::THUMBNAIL): Yii::$app->homeUrl.'images/no_image.jpg'?>" alt="logo"></a>
                            </div>
                            <div class="agent-listing-left-details">
                                <h3><a href="<?= Url::to(['agency/view', 'slug' => $agency->slug])?>" target="_blank"><?= ucwords($agency->name) ?></a></h3>
                                <?php 
                                    echo StarRating::widget([
                                        'name' => 'rating_'. $agency->agencyID,
                                        'value' => $agency->avg_rating,
                                        'pluginOptions' => ['displayOnly' => true, 'size' => 'xs']
                                    ]);
                                ?>
                                <ul>
                                    <li>Total Recommendations: <?= $agency->total_recommendations?></li>
                                    <li><?= $agency->formattedAddress ?> </li>
                                    <li>Agency ID # <?= $agency->agencyID ?></li>
                                    <li><?= $agency->getOffice1() ?></span></li>
                                </ul>
                                <a href="<?= Url::to(['agency/view', 'slug' => $agency->slug]) ?>" target="_blank" class="btn btn-primary red-btn">More Details</a>
                            </div>
                            <div class="agent-listing-right">
                                <?php
                                $agentsQuery = Agent::find()->select('id')->where(['agency_id' => $agency->id])->active();
                                $propertyCnt = Property::find()->where(['user_id' => $agentsQuery])->activeSold()->count();
                                if($propertyCnt != 0){
                                ?>
                                <div class="agent-listing-right-top">
                                    <div class="agent-listing-sale-sold">
                                        <?php
                                            $salePropertyCnt = Property::find()->where(['user_id' => $agentsQuery,'property_category_id' => 2])->active()->count();
                                            $soldPropertyCnt = Property::find()->where(['user_id' => $agentsQuery,'property_category_id' => 2])->sold()->count();
                                            $lastPropertyData = Property::find()->where(['user_id' => $agentsQuery])->orderBy(['id' => SORT_ASC])->one();
                                        ?>
                                        <span>For Sale: <?= $salePropertyCnt ?></span>
                                        <span>Sold: <?= $soldPropertyCnt ?></span>
                                    </div>
                                    <div class="agent-listing-range">
                                       
                                        <span>Listed a house: <?= $lastPropertyData->created_at ? Yii::$app->formatter->asDate($lastPropertyData->created_at) : "" ?></span>
                                    </div>
                                </div>
                                <?php
                                }
                                ?>
                                <div class="agent-listing-right-bottom">
                                    <div class="agent-listing-right-left">
                                        <?php
                                        $agencySocialMediaArr = $agency->socialMedias;
                                        foreach($agencySocialMediaArr as $socialMedia){
                                            if($socialMedia->name == 'facebook'){
                                                $url = StringMod::addHttp($socialMedia->url);
                                            ?>
                                                <a href="<?= Url::to($url) ?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                            <?php 
                                            }else if($socialMedia->name == 'twitter'){
                                            ?>
                                                <a href="<?= Url::to($url)?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                            <?php 
                                            }
                                        }
                                        ?>
                                    </div>
                                    <?php if($agency->email){?>
                                    <div class="agent-listing-right-right">
                                        <a href="mailto:<?= $agency->email?>" class="btn btn-default">Email</a>
                                    </div>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                        <div class="find_agent_pagination">
                            <?=
                            LinkPager::widget([
                                'pagination' => $dataProvider->getPagination(),
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <?php
                    echo $this->render('//shared/_agent_right_side_bar', []);
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Start Content Section ==================================================-->