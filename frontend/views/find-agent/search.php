<?php

use yii\helpers\Html;
use common\models\Agent;
use yii\helpers\Url;
use frontend\helpers\PropertyHelper;
use common\models\Property;
use common\helpers\StringMod;
use yii\widgets\LinkPager;
use kartik\rating\StarRating;

$this->title = 'Agent List for - '. Yii::$app->name;
$agentArr = $dataProvider->getModels();
//\yii\helpers\VarDumper::dump($agentArr); exit;
?>
<section>
    <!-- Property Menu Bar -->
    <?php
    echo $this->render('//shared/_agent_search_filtter', ['type' => 'agent', 'filters' => $filters]);
    ?>
    <!-- Property Menu Bar -->

    <div class="inner-content-sec">
        <div class="container agent_search_result_container">
            <div class="row">
                <div class="col-sm-9">
                    <div class="find-agent-top-part"><div class="col-sm-6">Agents: <span><?= $dataProvider->totalCount ?> <?php if($dataProvider->totalCount == 1) echo 'Agent';else echo 'Agents';?> Found</span></div>
                        <div class="col-sm-6"><div class="pull-right">
                                <span class="sort-by">Sort by:</span>
                                <select class="pull-right sort_items_by property-listing-select">
                                    <option value="<?= Agent::SORT_MOST_RECENT_ACTIVITY ?>" <?php if($sortBy == Agent::SORT_MOST_RECENT_ACTIVITY)echo 'selected'?>>Most Recent Activity</option>
                                    <option value="<?= Agent::SORT_HIGHEST_RATINGS ?>" <?php if($sortBy == Agent::SORT_HIGHEST_RATINGS)echo 'selected'?>>Highest Ratings</option>
                                    <option value="<?= Agent::SORT_MOST_RECOMMENDATIONS ?>" <?php if($sortBy == Agent::SORT_MOST_RECOMMENDATIONS)echo 'selected'?>>Most Recommendations</option>
                                    <option value="<?= Agent::SORT_MOST_FOR_SALE_LISTINGS ?>" <?php if($sortBy == Agent::SORT_MOST_FOR_SALE_LISTINGS)echo 'selected'?>>Most For Sale Listings</option>
                                    <option value="<?= Agent::SORT_FIRST_NAME ?>" <?php if($sortBy == Agent::SORT_FIRST_NAME)echo 'selected'?>>First Name</option>
                                    <option value="<?= Agent::SORT_LAST_NAME ?>" <?php if($sortBy == Agent::SORT_LAST_NAME)echo 'selected'?>>Last Name</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="agent-listing-sec">
                        <?php
                        foreach($agentArr as $agent){
                        ?>
                        <div class="agent-listing">
                            <div class="agent-listing-img">
                                <?php
                                if(!empty($agent->getImageUrl($agent::THUMBNAIL))){
                                    echo Html::img($agent->getImageUrl($agent::THUMBNAIL), [
                                        'class'=>'', 
                                    ]);
                                }
                                ?>
                            </div>
                            <div class="agent-listing-left-details">
                                <h3><a href="<?= Url::to(['user/view-profile', 'slug' => $agent->slug]) ?>" target="_blank"><?= ucwords($agent->fullName) ?></a></h3>
                                <?php 
                                    echo StarRating::widget([
                                        'name' => 'rating_'. $agent->agentID,
                                        'value' => $agent->avg_rating,
                                        'pluginOptions' => ['displayOnly' => true, 'size' => 'xs']
                                    ]);
                                ?>
                                <ul>
                                    <li>Total Recommendations: <?= $agent->total_recommendations?></li>
                                    <li><?= $agent->formattedAddress ?></li>
                                    <li>Agent ID # <?= $agent->agentID ?></li>
                                    <li><?= $agent->getMobile1() ?></li>
                                    <?php if($agent->agency_id){?><li>Office: <a target="_blank" href="<?= Url::to(['/agency/view', 'slug' => $agent->agency->slug]) ?>"> <?= $agent->agency->name ?></a></li><?php }?>
                                </ul>
                                <a href="<?= Url::to(['user/view-profile', 'slug' => $agent->slug]) ?>" class="btn btn-primary red-btn" target="_blank">More Details</a>
                            </div>
                            <div class="agent-listing-right">
                                <?php
                                $propertyCnt = Property::find()->where(['user_id' => $agent->id])->activeSold()->count();
                                if($propertyCnt != 0){
                                ?>
                                <div class="agent-listing-right-top">
                                    <div class="agent-listing-sale-sold">
                                        <?php
                                            $salePropertyCnt = Property::find()->where(['user_id' => $agent->id,'property_category_id' => 2])->active()->count();
                                            $soldPropertyCnt = Property::find()->where(['user_id' => $agent->id,'property_category_id' => 2])->sold()->count();
                                            $lastPropertyData = Property::find()->where(['user_id' => $agent->id])->activeSold()->orderBy(['id' => SORT_ASC])->one();
                                           //\yii\helpers\VarDumper::dump($lastPropertyData->created_at); exit;
//                                            PropertyHelper::getNumberFormatShort()
                                        ?>
                                        <span>For Sale: <?= $salePropertyCnt ?></span>
                                        <span>Sold: <?= $soldPropertyCnt ?></span>
                                    </div>
                                    <div class="agent-listing-range">
                                        <span>Activity range: $<?= PropertyHelper::getNumberFormatShort($agent->min_price) ?> - $<?= PropertyHelper::getNumberFormatShort($agent->max_price) ?></span>
                                        <span>Listed a house: <?= $lastPropertyData->created_at ? Yii::$app->formatter->asDate($lastPropertyData->created_at) : "" ?></span>
                                    </div>
                                </div>
                                <?php
                                }
                                ?>
                                <div class="agent-listing-right-bottom">
                                    <div class="agent-listing-right-left">
                                        <?php
                                        $agentSocialMediaArr = $agent->agentSocialMedias;
                                        foreach($agentSocialMediaArr as $socialMedia){
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
                                    <div class="agent-listing-right-right">
                                        <!--<span>View Local Activity Map</span>-->
                                        <a href="mailto:<?= $agent->email?>" class="btn btn-default">Email</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                        <div class="property_pagination">
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