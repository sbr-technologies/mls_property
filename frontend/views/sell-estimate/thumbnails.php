<?php 
use yii\helpers\Url;
use common\models\User;
use yii\helpers\Html;
use frontend\helpers\PropertyHelper;
use yii\helpers\StringHelper;
use yii\web\View;
use yii\widgets\LinkPager;
use common\models\Agency;
use common\models\Property;

$properties = $dataProvider->getModels();
?>
    <div class="container">
        <div class="col-sm-12">
            <div class="sell_estimate_thumbnails">
            <div class="row property-listing-top-title">
                <div class="col-sm-3 breadcrumb-list">
                    
                        <ul>
                            <?php
                            foreach ($breadcrumb as $item) {
                                if (is_array($item)) {
                                    echo '<li><a href="#">' . implode('|', $item) . '</a></li>';
                                } else {
                                    echo '<li><a href="#">' . $item . '</a></li>';
                                }
                            }
                            ?>
                        </ul>
                    
                </div>
                <div class="col-sm-5 propery-listing-title-bar">
                    <?php
                    if (!empty($properties)) {
                        ?>
                        <div class="pull-right propery-listing-title-bar-right"><span><?= $dataProvider->totalCount ?> Homes sorted by</span>
                            <select class="pull-right sort_property_by property-listing-select">
                                <option value="<?= Property::SORT_RELEVANT ?>" <?php if ($sortBy == Property::SORT_RELEVANT) echo 'selected' ?>>Relevant Listings</option>
                                <option value="<?= Property::SORT_NEWEST ?>" <?php if ($sortBy == Property::SORT_NEWEST) echo 'selected' ?>>Newest Listings</option>
                                <option value="<?= Property::SORT_LOWEST_PRICE ?>" <?php if ($sortBy == Property::SORT_LOWEST_PRICE) echo 'selected' ?>>Lowest Price</option>
                                <option value="<?= Property::SORT_HIGHEST_PRICE ?>" <?php if ($sortBy == Property::SORT_HIGHEST_PRICE) echo 'selected' ?>>Highest Price</option>
                                <option value="<?= Property::SORT_LARGEST_AREA ?>" <?php if ($sortBy == Property::SORT_LARGEST_AREA) echo 'selected' ?>>Largest Sqm</option>
                            </select>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <div class="col-sm-4 text-right">
                    <?php if (1) { ?>
                        <div class="form-group clearfix">
                            <a href="javascript:void(0)" data-type="summary" class="btn btn-default sell_estimate_view" title="Summary"><i class="fa fa-th-large"></i></a>
                            <a href="javascript:void(0)" data-type="list" class="btn btn-default  sell_estimate_view" title="List"><i class="fa fa-list"></i></a>
                            <a href="javascript:void(0)" data-type="thumbnails" class="btn btn-default active sell_estimate_view" title="Thumbnails"><i class="fa fa-image"></i></a>
                            <a href="javascript:void(0)" data-type="map" class="btn btn-default sell_estimate_view" title="Map"><i class="fa fa-map"></i></a>
                            <a href="javascript:void(0)" data-type="chart" class="btn btn-default sell_estimate_view" title="Chart"><i class="fa fa-bar-chart"></i></a>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-sm-12 search_result_left">
                      <?php $navLinks = [];
                        if (!empty($properties)) {
                            
                          foreach ($properties as $key => $property) {
                              if(isset($properties[$key + 1])){
                                $navLinks[$property->id]['next'] = $properties[$key + 1]->slug;
                              }
                              if(isset($properties[$key - 1])){
                                $navLinks[$property->id]['prev'] = $properties[$key - 1]->slug;
                              }
                          ?>
                          <div class="listing_item col-sm-12" data-id="<?= $property->id?>">
                                <div class="property-listing">
                                    <div class="col-sm-7 property-listing-left">
                                        <?php
                                        $photosArr = $property->photos;
                                        if(is_array($photosArr) && count($photosArr) > 0){
                                            foreach($photosArr as $photoKey => $photoVal){
                                                if($photoKey == 0){
                                                    if(isset($photoVal) && $photoVal != ''){
                                                        $alias = $photoVal->getImageUrl($photoVal::LARGE);
                                                        echo Html::img($alias,['class' => 'property-listing-img']);
                                                    }
                                                }
                                            }
                                        }else{
                                            echo Html::img(Yii::getAlias('@uploadsUrl/banner_image/no_image_avaliable.png'),['class' => 'property-listing-img']);
                                        }
                                        ?>
                                        <span class="property-total-img"><i class="fa fa-picture-o" aria-hidden="true"></i> <?= count($photosArr) ?></span>
                                        <div class="featurespopupslider">
                                            <?php
                                            $photos = $property->photos;
                                            foreach ($photos as $key => $photo) {
                                                if($key == 0){
                                                    $active     =   'active';
                                                }else{
                                                    $active     =   '';
                                                }
                                                if($key > 0){
                                                    if(isset($photo) && $photo != ''){
                                                        $alias = $photo->getImageUrl($photo::LARGE);
                                                        echo Html::img($alias,['class' => 'property-listing-img featuresimg']);
                                                    }
                                                }
                                            }
                                            ?>
                                        </div>
                                        
                                            
                                            <?php 
                                                if($property->user->profile_id == User::PROFILE_SELLER && $property->isSellerInformationShow != "No"){
                                                    $agencyId = common\models\SiteConfig::item('agencyId');
                                                    $agency = Agency::findOne($agencyId);
                                                }else{
                                                    $agency = $property->user->agency;
                                                }
                                                if(!empty($agency)){?>
                                                    <div class="property-listing-left-bottom">
                                                    <div class="property-listing-left-bottom-left">
                                                    <?php if(isset($agency->photos[0]) && !empty($agency->photo)){
                                                    ?>
                                                        <img src="<?php echo $agency->photo->imageUrl ?>" alt="logo" >
                                                    <?php
                                                    }else{?>
                                                        <img src="<?= Yii::$app->urlManager->baseUrl ?>/public_main/images/property-listing-logo1.png" alt="">
                                                    <?php }?>
                                                    <p class="name-link"><?= $agency->nameLink ?></p>
                                                    </div>
                                                    <div class="property-listing-left-bottom-right">
                                                        <span><a href="<?php echo Url::to(['property/view', 'slug' => $property->slug]) ?>">View Details</a></span>
                                                    </div>
                                                    </div>
                                                    <?php
                                                }
                                            ?>
                                    </div>
                                    <div class="col-sm-5 property-listing-right">
                                        <div class="pull-left indicator-block">
                                            <?php if($property->market_status == "Active"){?>
                                                <span class="btn btn-success btn-sm "> <?= $property->market_status ?></span>
                                            <?php }elseif($property->market_status == "Sold"){?>
                                                <span class="btn btn-default btn-sm red-new-btn"><?= $property->market_status ?></span>
                                            <?php }elseif($property->market_status == "Pending"){?>
                                                <span class="btn btn-success btn-sm "> <?= $property->market_status ?></span>
                                            <?php } ?>
                                            <span class="btn btn-info btn-sm"><?php echo $property->categoryName?></span>
                                            <?php if($property->isNew){?>
                                                <span class="btn btn-default btn-sm" style="color: #fff;background-color:#800080">New</span>
                                            <?php }?>
                                        </div>
                                        <?php 
                                            $session   =   Yii::$app->session;
                                            $compProps = $session->get('comp_props');
                                        ?>
                                        <div class="property-listing-save-icon">
                                            <?php if($compProps && in_array($property->id, $compProps)){?>
                                                <button type="button" class="lnk_add_to_compare" title="Added to compare" value="Added" data-value ="<?= $property->id ?>" data-url="<?= Url::to(['property/add-to-compare','id' => $property->id]) ?>"><i class="fa fa-minus" aria-hidden="true"></i></button>
                                            <?php }else{?>
                                                <button type="button" class="lnk_add_to_compare" title="Add to compare" value="Compare" data-value ="<?= $property->id ?>" data-url="<?= Url::to(['property/add-to-compare','id' => $property->id]) ?>"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                            <?php }?>
                                            <a href="javascript:void(0)" class="save_as_favorite" data-href="<?= Url::to(['property/save-favorite', 'id' => $property->id]);?>"><i class="fa <?= PropertyHelper::isFavorite($property->id)? 'fa-heart':'fa-heart-o'?>" aria-hidden="true"></i></a>
                                        </div>
                                        <h2><?php echo substr(Yii::$app->formatter->asCurrency($property->price), 0, -3); ?></h2>
                                        <h4>
                                            <?= StringHelper::truncate($property->formattedAddress, 60); ?>
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
                                        <?= Html::a('Contact Agent', 
                                            'javascript:void(0);',
                                            ['class' => 'btn btn-primary contact-agent-btn','data-href' => Url::to(['/site/check-login'])]
                                        ); ?>
                                        <?php 
                                            $js = "$(function(){
                                                        $(document).on('click', '.contact-agent-btn', function(){ 
                                                            var thisBtn = $(this);
                                                            $.get(thisBtn.data('href'), function(response){ 
                                                                if(response.status === false){ 
                                                                    $('#mls_bs_modal_one').modal({remote: '".Url::to(['site/login', 'popup' => 1])."'});
                                                                    $('#mls_bs_modal_one').on('shown.bs.modal', function (e) {
                                                                        $('#mls_bs_modal_one').find('.login_redirect_url').val(location.href);
                                                                    });
                                                                }else{ 
                                                                    $('#mls_bs_modal_one').modal({remote: '".Url::to(['/property/contact-agent','id' => $property->id,'propertyUrl' => Url::to(['property/view', 'slug' => $property->slug])])."'});
                                                                }
                                                            }, 'json');
                                                            return false;
                                                        });
                                                    });";
                                            $this->registerJs($js, View::POS_END);  

                                        ?>

                                        <div class="listing-added-date"><i class="fa fa-calendar" aria-hidden="true"></i> added : <?= date("dS F Y",$property->created_at) ?></div> 
                                    </div>
                                    <?php if($property->preimum_lisitng){?>
                                    <div class="premium_listing"><img src="/public_main/images/primum-img.png" alt="Premium"></div>
                                    <?php }?>
                                    <?php if($property->featured){echo '<div class="ribbon red"><span>Featured</span></div>';};?>
                                    <a href="<?php echo Url::to(['property/view', 'slug' => $property->slug]) ?>" class="details-block-link"></a>
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
                        <?php
                        }else{
                      ?>
                            <div class="alert alert-info margine10top">
                                <i class="fa fa-info"></i>
                                No Property found.
                            </div>
                            <p class="text-center">
                                <strong>
                                    Can't find what you're looking for? Pls 
                                    <a href="<?= Url::to(['property/request']) ?>"> Post a Request</a>
                                </strong>
                            </p> 
                      <?php  
                        }
                        Yii::$app->session->set('nav_links', $navLinks);
                      ?>
            </div>
        </div>
    </div>
</div>