<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Property;
use yii\web\View;
use common\models\ReviewRating;
use yii\helpers\ArrayHelper;
use common\models\User;
use common\models\Recommend;
use kartik\rating\StarRating;
use frontend\helpers\PropertyHelper;
use yii\widgets\LinkPager;

$userId         =   Yii::$app->user->id;
$this->title    =   "Profile for ". ucwords($model->fullName);
$properties     =   $listingActivitDataProvider->getModels();
$reviewArr      =   ReviewRating::find()->where(['model' => 'User', 'model_id' => $model->id])->orderby(['id' => SORT_DESC])->all();
$contactInfos   =   User::find()->where(['id' => $model->id])->one();
$recommendModel =   Recommend::find()->where(['recommend_id' => $userId, 'model' => 'User', 'model_id' => $model->id])->one();
$this->registerJsFile('@web/public_main/js/profile.js',['depends' => [\yii\web\JqueryAsset::className(),\yii\bootstrap\BootstrapPluginAsset::ClassName()]]);
$link = [];
if(!empty($model->agentSocialMedias)){
    foreach($model->agentSocialMedias as $social){
        $link[$social->name] = $social->url;
    }
}
?>
<section>
    <!-- Agent Profile Top Sec -->
    <div class="agent-profile-top-sec">
        <div class="profile-cover-img-sec">
            <img src="<?php echo $model->coverPhotoUrl ?>" alt="">
            <div class="overlay-coverimg"></div>
        </div>
        <div class="profile-cover-bottom-bar">
            <ul>
                <li class="active"><a href="javascript:void(0)">About</a> |</li>
                <li><a href="#ContactInfo">Contact Info</a> |</li>
                <li><a href="#PropertyActivity">Listing Activity</a></li>
            </ul>
        </div>
        <div class="profile-img-sec">
            <img src="<?php echo $model->getImageUrl(\common\models\User::THUMBNAIL) ?>" alt="<?= $model->fullName ?>">
        </div>
        <div class="profile-name-review">
            <h2><?php echo ucwords($model->fullName) ?></h2>
            <h3><?php echo $model->shortAddress ?></h3>
            <?php
            echo  StarRating::widget([
                    'name'              =>  'Profile Rating',
                    'value'             =>  $model->avg_rating,
                    'pluginOptions'     =>  [
                                                'displayOnly'           =>  true,
                                                'starCaptions'          =>  [
                                                                                0 => 'Extremely Poor',
                                                                                1 => 'Very Poor',
                                                                                2 => 'Poor',
                                                                                3 => 'Good',
                                                                                4 => 'Very Good',
                                                                                5 => 'Extremely Good',
                                                                            ],
                                                'starCaptionClasses'    =>  [
                                                                                0 => 'text-danger',
                                                                                1 => 'text-danger',
                                                                                2 => 'text-warning',
                                                                                3 => 'text-info',
                                                                                4 => 'text-primary',
                                                                                5 => 'text-success',
                                                                            ],
                                            ]
                ]);
            ?>                
        </div>
        <div class="profile-link-sec">
            <a href="javascript:void(0)" data-href="<?= Url::to(['user/ask-question', 'id' => $model->id]); ?>" class="btn btn-default red-btn ask_a_question">Ask a Question</a>
            <ul>
                <li><a href="javascript:void(0)" data-href="<?= Url::to(['user/write-review', 'id' => $model->id]); ?>" class="write_review"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Write A Review</a></li>
                <li><a href="javascript:void(0)" data-href="<?= Url::to(['user/recommend', 'id' => $model->id]); ?>" title="<?= $recommendModel ? 'Un Recommend me' : 'Recommend me' ?>" class="recommend_me"><i class="<?= $recommendModel ? 'fa fa-thumbs-up' : 'fa fa-thumbs-o-up' ?>" aria-hidden="true"></i> <?= $recommendModel ? 'Recommended' : 'Recommend' ?></a></li>
                <li><a href="javascript:void(0)" class="lnk_share_agency"><i class="fa fa-share-square-o" aria-hidden="true"></i> Share</a></li>
            </ul>
            <div class="arrow_box agent-share-box share_block">
                <ul class="popup_listing">
                    <li><a target="_blank" href="https://www.facebook.com/dialog/share?app_id=295891977497341&display=popup&href=<?= Url::to(['user/view-profile', 'slug' => $model->slug], TRUE) ?>&redirect_uri=<?= Url::to(['user/view-profile', 'slug' => $model->slug], TRUE) ?>"><i class="fa fa-facebook-square" aria-hidden="true"></i> Share on FB</a></li>
                    <li><a target="_blank" href="http://twitter.com/share?text=<?php echo ucwords(urlencode($model->commonName)) ?>&url=<?= Url::to(['user/view-profile', 'slug' => $model->slug], TRUE) ?>"><i class="fa fa-twitter-square" aria-hidden="true"></i> Share on Twitter</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Agent Profile Top Sec -->
    <div class="inner-content-sec">
        <div class="container">
            <div class="row">
                <div class="agent-profile-content-sec">
                    <div class="col-sm-12">
                      <h2>About <?php echo ucwords($model->fullName) ?> <!-- - <span>with RE/MAX In The City</span> --></h2>
                        <div class="row agent-profile-Txtcontent">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <?php if ($model->profile->title == 'Agent') { ?>
                                        Agent ID : <?= $model->agentId ?>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="form-group">
                                    <p><?php echo $model->about ?><!--<a href="javascript:void(0)">Read More</a> --></p>
                                </div>
                                <div id="ContactInfo">
                                    <div class="form-group">
                                        <h3>Contact Information</h3>
                                    </div>
                                    <?php
                                    if (!empty($contactInfos)) {
                                        ?>
                                        <label class="">Team :</label>
                                        <?= $contactInfos->teamName ? $contactInfos->teamName->name : "" ?><br>
                                        <label class="">Email :</label>
                                        <?= $contactInfos->email ? $contactInfos->email : "" ?><br>
                                        <label class="">Gender :</label>
                                        <?= $contactInfos->genderText ? $contactInfos->genderText : "" ?><br>
                                        <?php for($i= 1; $i<=4; $i++){
                                            $mobFunc = 'getMobile'.$i;
                                            $ofisFunc = 'getOffice'.$i;
                                            $faxFunc = 'getFax'.$i;
                                           ?>
                                           <?php if($contactInfos->$mobFunc()){?>
                                           <label class=""><?= $contactInfos->getAttributeLabel('mobile'. $i)?> :</label>
                                           <?= $contactInfos->$mobFunc() ?><br>
                                           <?php }?>
                                           <?php if($contactInfos->$ofisFunc()){?>
                                           <label class=""><?= $contactInfos->getAttributeLabel('office'. $i)?> :</label>
                                           <?= $contactInfos->$ofisFunc() ?><br>
                                           <?php }?>
                                           <?php if($contactInfos->$faxFunc()){?>
                                           <label class=""><?= $contactInfos->getAttributeLabel('fax'. $i)?> :</label>
                                           <?= $contactInfos->$faxFunc() ?><br>
                                           <?php }?>
                                        <?php }?>
                                        <label>Address :</label>
                                        <?= $contactInfos->formattedAddress ?>
                                <?php    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="table-responsive">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
                                        <tr>
                                            <td width="50%"><strong>Years of Experience:</strong> <?php echo $model->exp_year ?></td>
                                            <td width="50%"><strong>Activity Range:</strong> <?php echo $model->price_range ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Specializations:</strong> <?php echo $model->specialization ?></td>
                                            <td><strong>Areas Served:</strong> <?php echo $model->area_served ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Reviews:</strong> <?= $model->total_reviews ?></td>
                                        </tr>

                                        <tr>
                                            <td><strong>Total Recommendations:</strong> <?= $model->total_recommendations ?></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <?php
                                                if ($model->profile->title == 'Agent' || $model->profile->title == 'Agency') {
                                                    ?>
                                                    <span> 
                                                        <?php
                                                        $agency = $model->agency;
                                                        if (!empty($agency)) {
                                                            ?>
                                                            <p><strong>Brokerage :</strong><a target="_blank" href="<?= Url::to(['/agency/view', 'slug' => $agency->slug]) ?>"> <?= $agency->name ? $agency->name : "" ?></a></p>
                                                            <?php
                                                            if (!empty($agency->photos[0])) {
                                                                ?>
                                                                <img src="<?= $model->agency->photos[0]->imageUrl ?>" alt="" >
                                                                <?php
                                                            } else {
                                                                echo Html::img(Yii::getAlias('@uploadsUrl/banner_image/no-preview.jpg'), [
                                                                    'class' => '',
                                                                ]);
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php
                                                if ($model->profile->title == 'Agent' || $model->profile->title == 'Agency') {
                                                    ?>
                                                    <strong>Office Details:</strong> <?php echo $model->agency->formattedAddress ?>
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="socil-icon">
                                                <a href="<?php if(isset($link['facebook']) && $link['facebook']) echo 'http://'. $link['facebook']; else echo '#'?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                                <a href="<?php if(isset($link['twitter']) && $link['twitter']) echo 'http://'. $link['twitter']; else echo '#'?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                            </td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="PropertyActivity" class="col-sm-9 listing_activity_list agent-agency-activity-leftbar">
                            <h2 class="col-sm-8">Total <span><?= $listingActivitDataProvider->totalCount?></span> Listing Activities Found</h2>
                            <?php
                            //\yii\helpers\VarDumper::dump($properties,12,4); exit;
                            if (!empty($properties)) {
                                ?>
                                <div class="row listing-activity-list-sec">
                                    <?php
                                    foreach ($properties as $property) {
                                        // \yii\helpers\VarDumper::dump($property,12,4);
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
        <?php if ($property->featured) {
            echo '<div class="ribbon red"><span>Featured</span></div>';
        }; ?>
                                                    <a href="<?php echo Url::to(['property/view', 'slug' => $property->slug]) ?>" class="details-block-link"></a>
                                                </div>
                                            </div>
<!--                                        <div class="col-sm-3">
                                            <a href="javascript:void(0)" class="listing-activity-list">
                                                <?php
                                                $photosArr = $property->photos;
                                                if (is_array($photosArr) && count($photosArr) > 0) {
                                                    foreach ($photosArr as $photoKey => $photoVal) {
                                                        if ($photoKey == 0) {
                                                            if (isset($photoVal) && $photoVal != '') {
                                                                $alias = $photoVal->getImageUrl($photoVal::MEDIUM);
                                                                echo Html::img($alias);
                                                            }
                                                        }
                                                    }
                                                } else {
                                                    echo Html::img(Yii::getAlias('@uploadsUrl/banner_image/no_image_avaliable.png'));
                                                }
                                                ?>
                                                <div class="overlay-activity-img"></div>
                                                <span class="for-sale">
                                                    <?php
                                                    if (!empty($property->propertyTypeId)) {
                                                        echo implode(',', ArrayHelper::getColumn(common\models\PropertyType::find()->where(['id' => $property->propertyTypeId])->all(), 'title'));
                                                    }
                                                    ?>
                                                </span>
                                                <p><?= $property->shortAddress ?> <span><?= $property->price ?></span> <?= $property->no_of_room ?>bd <?= $property->no_of_bathroom ?>ba</p>
                                            </a>

                                        </div>-->
                                        <?php
                                    }
                                    ?>
                                </div>
                                <?php
                                echo LinkPager::widget([
                                    'pagination' => $listingActivitDataProvider->pagination
                                ]);
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
                                            <a href="javascript:void(0)" data-href="<?= Url::to(['user/write-review', 'id' => $model->id]); ?>" class="btn btn-default write-review-btn write_review"> Write A Review</a>
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
            </div>
        </div>
    </div>
</section>
<?php
$varJs          =   "var loginPopupurl = '".Url::to(['site/login', 'popup' => 1])."';";
$this->registerJs($varJs, View::POS_HEAD);

$askJs          =   "var askPopupurl = '".Url::to(['user/ask-question','id' => $model->id])."';";
$this->registerJs($askJs, View::POS_HEAD);

$reviewJs       =   "var reviewPopupurl = '".Url::to(['user/write-review','id' => $model->id])."';";
$this->registerJs($reviewJs, View::POS_HEAD);

$contactJs      =   "var contactPopupurl = '".Url::to(['user/contact-info','id' => $model->id])."';";
$this->registerJs($contactJs, View::POS_HEAD);


$js = "$(function(){
    $('.lnk_share_agency').on('click', function(){
        $('.share_block').toggle();
    });
    });";

$this->registerjs($js, View::POS_END);