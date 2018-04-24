<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\PhotoGallery;
use yii\widgets\LinkPager;
use common\models\Team;

$this->title = 'Team List';
$teamArr = $dataProvider->getModels();
//\yii\helpers\VarDumper::dump($teamArr,12,1); exit;
//$this->registerJsFile(Yii::$app->urlManager->baseUrl.'/public_main/js/team_search.js', ['depends'=> [\yii\bootstrap\BootstrapPluginAsset::className()]])
?>

<div class="container team_search_result_container">
    <div class="row">
        <div class="col-sm-9">
            <div class="find-agent-top-part"><div class="col-sm-6">Teams: <span><?= $dataProvider->totalCount ?> <?php if($dataProvider->totalCount == 1) echo 'Team';else echo 'Teams';?> Found</span></div>
                <div class="col-sm-6"><div class="pull-right">
                        <span class="sort-by">Sort by:</span>
                        <select class="pull-right sort_teams_by property-listing-select">
                            <option value="<?= Team::SORT_NAME ?>" <?php if ($sortBy == Team::SORT_NAME) echo 'selected' ?>>Name</option>
                            <option value="<?= Team::SORT_OFFICE_NAME ?>" <?php if ($sortBy == Team::SORT_OFFICE_NAME) echo 'selected' ?>>Office Name</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="agent-listing-sec">
                        <?php
                        foreach($teamArr as $team){
                            $agency = $team->agency;
                        ?>
                        <div class="agent-listing">
                            <div class="agent-listing-left-details team-search-list">
                                <a href="<?= Url::to(['agency/view', 'slug' => $agency->slug])?>"><img src="<?= !empty($agency->photo)?$agency->photo->getImageUrl(PhotoGallery::THUMBNAIL): Yii::$app->homeUrl.'images/no_image.jpg'?>" alt="logo"></a>
                                <h2>Team Name: <?= ucwords($team->name) ?></h2>
                                <h3>Team ID: <?= ucwords($team->teamID) ?></h3>
                                <h4>Agency: <?= Html::a($agency->name, ['agency/view', 'slug' => $agency->slug])?></h4>
                                <?php if(!empty($team->users)){
                                    $i = 1;
                                    $sl = false;
                                    if(count($team->users) > 1){
                                        $sl = true;
                                    }
                                ?>
                                <div>
                                    <a href="#" class="team_member_header">Team Members</a>
                                    <div class="team_member_content" style="display: none">
                                        <?php foreach($team->users as $member){
                                        echo Html::a(($sl?$i. '. ':'').$member->fullName, ['user/view-profile', 'slug' => $member->slug], ['class' => 'team-member-item', 'target' => "_blank"]);
                                        $i++;
                                        }?>
                                    </div>
                                </div>
                                <?php }?>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="property_pagination">
                        <?=
                        LinkPager::widget([
                            'pagination' => $dataProvider->getPagination(),
                        ]);
                        ?>
                    </div>
        </div>
        <div class="col-sm-3">
            <?php
            echo $this->render('//shared/_agent_right_side_bar', []);
            ?>
        </div>
    </div>
</div>
<!-- Start Content Section ==================================================-->