<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Property;
use yii\web\View;
use common\models\ReviewRating;
use yii\helpers\ArrayHelper;
use common\models\User;
use common\models\Recommend;
use frontend\helpers\PropertyHelper;
use kartik\rating\StarRating;
use kartik\social\FacebookPlugin;
use kartik\social\TwitterPlugin;
use kartik\social\GooglePlugin;
use yii\widgets\LinkPager;

$userId         = Yii::$app->user->id;
$this->title    =   "Profile for ". ucwords($model->name);
$reviewArr      =   ReviewRating::find()->where(['model' => 'Agency', 'model_id' => $model->id])->orderby(['id' => SORT_DESC])->all();
$contactInfos   =   User::find()->where(['id' => $model->id])->one();
$recommendModel =   Recommend::find()->where(['recommend_id' => $userId, 'model' => 'Agency', 'model_id' => $model->id])->one();
//\yii\helpers\VarDumper::dump($recommendModel,4,12);exit;
//\yii\helpers\VarDumper::dump($reviewArr); exit;
$this->registerJsFile(
    '@web/public_main/js/profile.js',
    ['depends' => [
        \yii\web\JqueryAsset::className(),
        \yii\bootstrap\BootstrapPluginAsset::ClassName()
        ]
   ]
);
?>
<section>
    <!-- Agent Profile Top Sec -->
    <div class="agent-profile-top-sec agency-profile">
        <div class="profile-cover-img-sec">
            <?php /*?><?= Html::img(Yii::getAlias('@uploadsUrl/banner_image/no-preview.jpg'), ['class'=>'']); ?><?php */?>
            <div class="overlay-coverimg"></div>
        </div>
        <div class="profile-cover-bottom-bar">
            <ul>
                <li class="active"><a href="#agencyInfo">About</a> |</li>
                <!--<li><a href="#ContactInfo">Contact Info</a> |</li>-->
                <li><a href="#AgencyAgentList">Agents</a> |</li>
				<li><a href="#AgencyContactInfo">Contact Info</a> |</li>
                <li><a href="#PropertyActivity">Listing Activity</a></li>
            </ul>
        </div>

        <div class="profile-img-sec">
            <?php 
                if(!empty($model->photos[0])){ 
                ?>
            <img src="<?= $model->photos[0]->imageUrl ?>" alt="">
                <?php
                }else{
                    echo Html::img(Yii::getAlias('@uploadsUrl/banner_image/no-preview.jpg'), ['class'=>'']);
                }
            ?>
            
            <!--<a href="javascript:void(0)"><i class="fa fa-pencil-square" aria-hidden="true"></i></a>-->
        </div>

        <div class="profile-name-review">
          <h2><?php echo ucwords($model->name) ?><!-- <a href="javascript:void(0)"><i class="fa fa-pencil-square" aria-hidden="true"></i></a> --></h2>
            <h3><?php echo $model->shortAddress ?></h3>
            <?php
            echo  StarRating::widget([
                    'name'              =>  'Agency Rating',
                    'value'             =>  $model->avg_rating,
                    'pluginOptions'     =>  [
                                                'displayOnly'           =>  true,
                                            ]
                ]);
            ?>
        </div>
        <div class="profile-link-sec">
            <a href="javascript:void(0)" data-href="<?= Url::to(['agency/ask-question', 'id' => $model->id]); ?>" class="btn btn-default red-btn ask_a_question">Ask a Question</a>
            <ul>
                <li><a href="javascript:void(0)" data-href="<?= Url::to(['agency/write-review', 'id' => $model->id]); ?>" class="write_review"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Write A Review</a></li>
                <li><a href="javascript:void(0)" data-href="<?= Url::to(['agency/recommend', 'id' => $model->id]); ?>" title="<?= $recommendModel ? 'Un Recommend' : 'Recommend' ?>" class="recommend_me"><i class="<?= $recommendModel ? 'fa fa-thumbs-up' : 'fa fa-thumbs-o-up' ?>" aria-hidden="true"></i> <?= $recommendModel ? 'Recommended' : 'Recommend' ?></a></li>
                <li><a href="javascript:void(0)" class="lnk_share_agency"><i class="fa fa-share-square-o" aria-hidden="true"></i> Share</a></li>
            </ul>
            <div class="arrow_box share_block">
                <ul class="popup_listing">
                    <li><a target="_blank" href="https://www.facebook.com/dialog/share?app_id=295891977497341&display=popup&href=<?= Url::to(['agency/view', 'slug' => $model->slug], TRUE)?>&redirect_uri=<?= Url::to(['agency/view', 'slug' => $model->slug], TRUE)?>"><i class="fa fa-facebook-square" aria-hidden="true"></i> Share on FB</a></li>
                    <li><a target="_blank" href="http://twitter.com/share?text=<?php echo ucwords(urlencode($model->name)) ?>&url=<?= Url::to(['agency/view', 'slug' => $model->slug], TRUE)?>"><i class="fa fa-twitter-square" aria-hidden="true"></i> Share on Twitter</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Agent Profile Top Sec -->
    <div class="inner-content-sec">
        <div class="container">
            <div class="col-sm-12 cms-content-sec" id="agencyInfo">
                <div class="row">
                    <div class="col-sm-6">
                        <h2 class="content-title">About Agency </h2>
                        <?php 
                        if(!empty($model->about)){
                            ?>
                            <p><?= $model->about ?></p>
                        <?php
                        }else{
                        ?>
                            <div class="alert alert-info margine10top">
                                <i class="fa fa-info"></i>					
                                No data found.
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="col-sm-6">
                        <h2 class="content-title">Agency Details</h2>
                        <?php if (!empty($model)) { ?>  
                        <table border="0" cellpadding="" cellspacing="" class="agency_details_listing">
                            <tr>
                                <td>Agency ID:</td>
                                <td><?= $model->agencyID ?></td>
                            </tr>
                            <tr>
                                <td>Agency Name:</td>
                                <td><?= $model->name ?></td>
                            </tr>
                            <tr>
                                <td>Owner Name:</td>
                                <td><?= $model->owner_name ?></td>
                            </tr>
                            <tr>
                                <td>Phone:</td>
                                <td><?= $model->getOffice1() ?></td>
                            </tr>
                            <tr>
                                <td>No. of Teams</td>
                                <td><?= $model->total_teams ?></td>
                            </tr>
                            <tr>
                                <td>No. of Agents</td>
                                <td><?= $model->totalAgents ?></td>
                            </tr>
							<tr>
                                <td>No. of Listing</td>
                                <td><?= $model->totalListings ?></td>
                            </tr>
                            <tr>
                                <td>Total Reviews</td>
                                <td><?= $model->total_reviews?></td>
                            </tr>
                            
                            <tr>
                                <td>Total Recommendations</td>
                                <td><?= $model->total_recommendations?></td>
                            </tr>
                        </table>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 form-group" id="AgencyAgentList">
                <div class="form-group">
                    <h2>Agents</h2>
                </div>
                <div id="owl-demo-agency" class="owl-carousel owl-theme agent-carousel-sec">
                <?php 
                    $agents = \common\models\Agent::find()->where(['agency_id' => $model->id])->active()->orderBy(['first_name' => SORT_ASC])->all();
                    if(empty($agents)){
                        echo 'No Agents Found';
                    }else{
                        foreach ($agents as $agent){
                ?>
                    <div class="item">
                        <a href="<?= Url::to(['user/view-profile', 'slug' => $agent->slug]) ?>" target="_blank">
                                
                                <img src="<?= $agent->getImageUrl() ?>" /> <br /><?= $agent->commonName ?>
                            
                        </a>
                    </div>
                <?php 
                
                    } }
                ?>
                </div>
            </div>
			
			<div class="col-sm-12 form-group" id="AgencyContactInfo">
                <div class="form-group">
                    <h2>Contact Information</h2>
                </div>
                    <label class="">Email :</label>
                    <?= $model->email ?><br>
                    <?php for($i= 1; $i<=4; $i++){
                     $mobFunc = 'getMobile'.$i;
                     $ofisFunc = 'getOffice'.$i;
                     $faxFunc = 'getFax'.$i;
                    ?>
                    <?php if($model->$mobFunc()){?>
                    <label class=""><?= $model->getAttributeLabel('mobile'. $i)?> :</label>
                    <?= $model->$mobFunc() ?><br>
                    <?php }?>
                    <?php if($model->$ofisFunc()){?>
                    <label class=""><?= $model->getAttributeLabel('office'. $i)?> :</label>
                    <?= $model->$ofisFunc() ?><br>
                    <?php }?>
                    <?php if($model->$faxFunc()){?>
                    <label class=""><?= $model->getAttributeLabel('fax'. $i)?> :</label>
                    <?= $model->$faxFunc() ?><br>
                    <?php }?>
                    <?php }?>
                    <label>Address :</label>
                    <?= $model->formattedAddress ?>
            </div>
			
            <div class="col-sm-9 listing_activity_list agent-agency-activity-leftbar" id="PropertyActivity">
                <div class="row">
                    <h2 class="col-sm-8">Total <span><?= $listingActivitDataProvider->totalCount?></span> Listing Activities Found</h2>
				<span class="col-sm-4">Sort By
				<select id="sel_sort_listing_activity">
				<option value="">Select</option>
				<option value="area" <?php if($s_la == 'area') echo 'selected';?>>Area</option>
				<option value="town" <?php if($s_la == 'town') echo 'selected';?>>Town</option>
				<option value="price"<?php if($s_la == 'price') echo 'selected';?>>Price</option>
				</select>
				<span>
				</div>
                <?php
                $listingActivities = $listingActivitDataProvider->getModels();
                if(!empty($listingActivities)){
                   // \yii\helpers\VarDumper::dump($propertyArr,12,4);exit;echo 11;
                ?>
                <div class="row listing-activity-list-sec">
                    <?php
                    
                        foreach($listingActivities as $property){

                    ?>
                    <div class="property-listing-sec listing_item col-sm-6" data-id="<?= $property->id ?>">
                                    <div class="property-listing">
                                        <div class="col-sm-7 property-listing-left">
                                            <?php
                                            $photosArr = $property->photos;
                                            if (is_array($photosArr) && count($photosArr) > 0) {
                                                foreach ($photosArr as $photoKey => $photoVal) {
                                                    if ($photoKey == 0) {
                                                        if (isset($photoVal) && $photoVal != '') {
                                                            $alias = $photoVal->getImageUrl($photoVal::LARGE);
                                                            echo Html::img($alias, ['class' => 'property-listing-img']);
                                                        }
                                                    }
                                                }
                                            } else {
                                                echo Html::img(Yii::getAlias('@uploadsUrl/banner_image/no_image_avaliable.png'), ['class' => 'property-listing-img']);
                                            }
                                            ?>
                                            <span class="property-total-img"><i class="fa fa-picture-o" aria-hidden="true"></i> <?= count($photosArr) ?></span>
                                            <div class="featurespopupslider">
                                                <?php
                                                $photos = $property->photos;
                                                foreach ($photos as $key => $photo) {
                                                    if ($key == 0) {
                                                        $active = 'active';
                                                    } else {
                                                        $active = '';
                                                    }
                                                    if ($key > 0) {
                                                        if (isset($photo) && $photo != '') {
                                                            $alias = $photo->getImageUrl($photo::LARGE);
                                                            echo Html::img($alias, ['class' => 'property-listing-img featuresimg']);
                                                        }
                                                    }
                                                }
                                                ?>
                                            </div>
                                            <div class="property-listing-left-bottom">
                                                <div class="property-listing-left-bottom-left">
                                                    <?php
                                                    $agency = $property->user->agency;
                                                    if (!empty($agency)) {
                                                        if (!empty($agency->photos[0])) {
                                                            ?>
                                                            <img src="<?= $property->user->agency->photos[0]->imageUrl ?>" alt="" >
                                                        <?php }
                                                        ?>
                                                        <p><?= $agency->name ? $agency->name : "" ?></p>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <img src="<?= Yii::$app->urlManager->baseUrl ?>/public_main/images/property-listing-logo1.png" alt="">
                                                    <?php } ?>
                                                </div>
                                                <div class="property-listing-left-bottom-right">
                                                    <span><a href="<?php echo Url::to(['property/view', 'slug' => $property->slug]) ?>">View Details</a></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-5 property-listing-right">
                                            <div class="pull-left indicator-block">
                                                <?php if ($property->market_status == "Active") { ?>
                                                    <span class="btn btn-success btn-sm "> <?= $property->market_status ?></span>
                                                <?php } elseif ($property->market_status == "Sold") { ?>
                                                    <span class="btn btn-default btn-sm red-new-btn"><?= $property->market_status ?></span>
                                                <?php } elseif ($property->market_status == "Pending") { ?>
                                                    <span class="btn btn-success btn-sm "> <?= $property->market_status ?></span>
                                                <?php } ?>
                                                <span class="btn btn-info btn-sm"><?php echo $property->categoryName ?></span>
                                                <?php if ($property->isNew) { ?>
                                                    <span class="btn btn-default btn-sm">New</span>
                                                <?php } ?>
                                            </div>
                                            <div class="property-listing-save-icon">
                                                <a href="javascript:void(0)" class="save_as_favorite" data-href="<?= Url::to(['property/save-favorite', 'id' => $property->id]); ?>"><i class="fa <?= PropertyHelper::isFavorite($property->id) ? 'fa-heart' : 'fa-heart-o' ?>" aria-hidden="true"></i></a>
                                            </div>
                                            <h2><?php echo Yii::$app->formatter->asCurrency($property->price); ?></h2>
                                            <h4>
                                                <?= $property->formattedAddress ?>
                                            </h4>
                                            <a href="javascript:void(0)" class="property-listing-refid">Property ID # <?= $property->referenceId ?></a>
                                            <p><?= $property->firstPropertyType?></p>
                                            <ul class="property-listing-room-details">
                                                <li><strong><i class="fa fa-bed" aria-hidden="true"></i></strong> bd <span><?php echo $property->no_of_room; ?></span></li>
                                                <li><strong><i class="fa fa-bath" aria-hidden="true"></i></strong> ba <span><?php echo $property->no_of_bathroom ? $property->no_of_bathroom : "NA"; ?></span></li>
                                                <li><strong><i class="fa fa-trello" aria-hidden="true"></i></strong> tl <span><?php echo $property->no_of_toilet ? $property->no_of_toilet : "NA"; ?></span></li>
                                                <li><strong><i class="fa fa-glide-g" aria-hidden="true"></i></strong> gr <span><?php echo $property->no_of_garage ? $property->no_of_garage : "NA"; ?></span></li>
                                                <li><strong><i class="fa fa-square" aria-hidden="true"></i></strong> Sq ft <span><?php echo $property->lot_size; ?></span></li>
                                            </ul>
                                            <?php
                                            $js = "$(function(){
                                                        $(document).on('click', '.contact-agent-btn', function(){ 
                                                            var thisBtn = $(this);
                                                            $.get(thisBtn.data('href'), function(response){ 
                                                                if(response.status === false){ 
                                                                    $('#mls_bs_modal_one').modal({remote: '" . Url::to(['site/login', 'popup' => 1]) . "'});
                                                                    $('#mls_bs_modal_one').on('shown.bs.modal', function (e) {
                                                                        $('#mls_bs_modal_one').find('.login_redirect_url').val(location.href);
                                                                    });
                                                                }else{ 
                                                                    $('#mls_bs_modal_one').modal({remote: '" . Url::to(['/property/contact-agent', 'id' => $property->id, 'propertyUrl' => Url::to(['property/view', 'slug' => $property->slug])]) . "'});
                                                                }
                                                            }, 'json');
                                                            return false;
                                                        });
                                                    });";
                                            $this->registerJs($js, View::POS_END);
                                            ?>

                                            <span style="margin:0px"><i class="fa fa-calendar" aria-hidden="true"></i> added : <?= date("dS F Y", $property->created_at) ?></span>
                                        </div>
                                        <?php
                                        if ($property->featured) {
                                            echo '<div class="ribbon red"><span>Featured</span></div>';
                                        };
                                        ?>
                                        <a href="<?php echo Url::to(['property/view', 'slug' => $property->slug]) ?>" class="details-block-link"></a>
                                    </div>
                                </div>
                    <?php 
                        }
                    ?>
                    <div class="col-sm-12">
                    <?php 
                    echo LinkPager::widget([
                        'pagination' => $listingActivitDataProvider->pagination
                    ]);
                    ?>
                </div>
                </div>
            <?php 
                }else{
                    ?>
                    <div class="alert alert-info margine10top">
                        <i class="fa fa-info"></i>					
                        No listing activity found.
                    </div>
                <?php
                }
            ?>
        </div>
            <div class="col-sm-3 agent-agency-activity-rightbar">
                <?php
                    $ads = [];
                    $adLocation = common\models\AdvertisementLocationMaster::find()->where(['page' => 'Property Search Result'])->active()->one();
                    if(!empty($adLocation)){
                        $ads = $adLocation->advertisements;
                    }
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
            </div>
            
            <div class="col-sm-12">
                <h2>Ratings and Reviews</h2>
                <div class="row">
                    <div class="review-sec">
                        <div class="review-listing">
                            <div class="col-sm-2">
                                <a href="javascript:void(0)" data-href="<?= Url::to(['agency/write-review', 'id' => $model->id]); ?>" class="btn btn-default write-review-btn write_review"> Write A Review</a>
                            </div>
                        </div>
                    </div>
                    <div class="review-sec">
                        <?php
                        if (!empty($reviewArr)) {
                            foreach ($reviewArr as $review) {
                                ?>
                                <div class="review-listing">
                                    <div class="col-sm-9">
                                        <h2><?= $review->title ?></h2>
                                        <p>“<?= $review->description ?>”</p>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="rating-star">
                                            <span>Rating:</span>
                                            <?php
                                            $rating = $review->rating;
                                            //echo $rating; //exit;
                                            for ($i = 1; $i <= $rating; $i++) {
                                                ?>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <span class="review-author"><?= $review->user->fullName ?></span>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                        <h3>Did this agent help with your home? 
                            <a href="javascript:void(0)" data-href="<?= Url::to(['user/write-review', 'id' => $model->id]); ?>" class="write_review"> Write A Review</a>  
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$reviewJs       =   "var reviewPopupurl = '".Url::to(['agency/write-review','id' => $model->id])."';";
$this->registerJs($reviewJs, View::POS_HEAD);

$js = "$(function(){
    $('.lnk_share_agency').on('click', function(){
        $('.share_block').toggle();
    });
    $('#sel_sort_listing_activity').on('change', function(){
            window.location='".Url::to(['agency/view', 'slug' => $model->slug])."?s_la=' + this.value
    });
        
    $(document).on('click', '.save_as_favorite', function(){
        var thisBtn = $(this);
        $.get(thisBtn.data('href'), function(response){
            if(response.status === true){
                if(response.insert === true){
                    thisBtn.find('.fa').removeClass('fa-heart-o').addClass('fa-heart');
                }else{
                    thisBtn.find('.fa').removeClass('fa-heart').addClass('fa-heart-o');
                }
            }else{
                $('#mls_bs_modal_one').modal({remote: loginPopupurl});
                $('#mls_bs_modal_one').on('shown.bs.modal', function (e) {
                    $('#mls_bs_modal_one').find('.login_redirect_url').val(location.href);
                });
            }
        });
    });
    });";

$this->registerjs($js, View::POS_END);

$askJs          =   "var askPopupurl = '".Url::to(['agency/ask-question','id' => $model->id])."';";
$this->registerJs($askJs, View::POS_HEAD);