<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use common\models\DiscussionPost;


$this->title = "Selling Discussion";

$discussionArr  = DiscussionPost::find()->where(['category_id' => 3])->active()->all();
//yii\helpers\VarDumper::dump($discussionArr,4,12); exit;

?>
<!-- Start Content Section ==================================================-->
<section>
    <!-- Property Menu Bar -->
    <div class="property-menu-bar buying-selling-menu-bar">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <form action="" role="search">
                        <div class="property-menu-list">
                            <a href="javascript:void(0)">Home</a>
                            <div class="dropdown">
                                <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">Categories <span class="caret"></span></a>
                                <div class="dropdown-menu">
                                    <ul>
                                        <li><a href="javascript:void(0)">Financing</a></li>
                                        <li><a href="javascript:void(0)">Buying &amp; Selling</a></li>
                                        <li><a href="javascript:void(0)">Renting</a></li>
                                        <li><a href="javascript:void(0)">Home Improvement / DIY</a></li>
                                        <li><a href="javascript:void(0)">Neighborhood</a></li>
                                        <li><a href="javascript:void(0)">Unique Homes</a></li>
                                        <li><a href="javascript:void(0)">General Discussion</a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="dropdown">
                                <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">Help <span class="caret"></span></a>
                                <div class="dropdown-menu">
                                    <ul>
                                        <li data-value=""><a href="javascript:void(0)">House Talk Support</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-default save-search-btn" type="submit">Start a discussion</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Property Menu Bar -->

    <div class="inner-content-sec">
        <div class="container">
            <div class="row">
                <div class="col-sm-9">
                    <div class="buying-selling-titlebar">
                        <h2>Latest in Selling</h2>
                        <select name="">
                            <option>Latest in Selling</option>
                            <option>Popular in Selling</option>
                        </select>
                    </div>

                    <div class="buying-selling-listing-sec">
                        <?php 
                        if(!empty($discussionArr)){
                            foreach($discussionArr as $discussion){
                                $commentCount = count($discussion->discussionComments);
//                                $likeCount = count($discussion->postLikes);
                        ?>
                        <a href="javascript:void(0)" class="buying-selling-listing">
                            <h4><?= $discussion->category->title ?></h4>
                            <h3><?= $discussion->title ?></h3>
                            <h6>By <?= $discussion->user->fullName ?> on <?= $discussion->created_at ? date("Y-m-d",$discussion->created_at) : "" ?></h6>
                            <p><?= $discussion->content ?></p>
                            <p><i class="fa fa-tags"></i>
                                <?php $tagsArr = $discussion->Tags; 
 
                                foreach($tagsArr as $tag){
                                    echo $tag->title.',';
                                }
                                ?>
                            </p>
                            <div class="buying-selling-bottom">

                                <div class="buying-selling-bottom-list">
                                    <i class="fa fa-commenting-o fa-m"></i>
                                    <span><?= $commentCount ?></span>
                                    <span>Replies</span>
                                </div>

                                <div class="buying-selling-bottom-list">
                                    <i class="fa fa-eye fa-m"></i>
                                    <span>346</span>
                                    <span>Views</span>
                                </div>

                                <div class="buying-selling-bottom-list">
                                    <i class="fa fa-clock-o fa-m"></i>
                                    <span>Latest reply by</span>
                                    <span class="name">MissyG</span>
                                    <span>yesterday</span>
                                </div>
                            </div>
                        </a>

                        

                        <div class="property-listing-bottom-sec">
                            <p class="pull-left">Found <?= count($discussionArr) ?> matching Comments</p>

                            <div class="pagination-sec">
                                <ul class="pagination">
                                    <li class="page-item"> <a class="page-link" href="javascript:void(0)" aria-label="Previous"> <span aria-hidden="true">&laquo;</span> <span class="sr-only">Previous</span> </a> </li>
                                    <li class="page-item active"><a class="page-link" href="javascript:void(0)">1</a></li>
                                    <li class="page-item"><a class="page-link" href="javascript:void(0)">2</a></li>
                                    <li class="page-item"><a class="page-link" href="javascript:void(0)">3</a></li>
                                    <li class="page-item"><a class="page-link" href="javascript:void(0)" aria-label="Next"> <span aria-hidden="true">&raquo;</span> <span class="sr-only">Next</span> </a> </li>
                                </ul>
                            </div>
                        </div>
                        <?php 
                            }
                        }
                        ?>
                    </div>
                </div>

                <!-- Property Details Right -->
                <div class="col-sm-3 property-details-right">
                    <!-- Property Details AD -->
                    <div class="property-details-right-ad">
                        <a href="javascript:void(0)"><img src="images/prpperty-details-ad.png" alt=""></a>
                    </div>
                    <!-- Property Details AD -->

                    <!-- Property Details Social Icon -->
                    <div class="property-details-right-social">
                        <h4>Share This Property On Your Social Media</h4>
                        <a href="javascript:void(0)" class="facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                        <a href="javascript:void(0)" class="twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                        <a href="javascript:void(0)" class="instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                        <a href="javascript:void(0)" class="linkedin"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                        <a href="javascript:void(0)" class="pinterest"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>
                        <a href="javascript:void(0)" class="google-plus"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
                        <a href="javascript:void(0)" class="rss"><i class="fa fa-rss" aria-hidden="true"></i></a>
                        <a href="javascript:void(0)" class="youtube"><i class="fa fa-youtube" aria-hidden="true"></i></a>
                    </div>
                    <!-- Property Details Social Icon -->

                    <!-- Property Details Similar Property -->
                    <div class="property-details-right-similar-property">
                        <h4>Similar Property</h4>
                        <div class="similar-property-listing-right">
                            <a href="javascript:void(0)" class="similar-property-listing">
                                <img src="images/similar-property-img1.jpg" alt="">
                                <div class="similar-property-content">
                                    <p class="btn btn-primary red-btn">View Details</p>
                                    <p class="similar-property-content-txt">12/D S. N. Jhon Road, New York. 7684652</p>
                                </div>
                            </a>

                            <a href="javascript:void(0)" class="similar-property-listing">
                                <img src="images/similar-property-img2.jpg" alt="">
                                <div class="similar-property-content">
                                    <p class="btn btn-primary red-btn">View Details</p>
                                    <p class="similar-property-content-txt">12/D S. N. Jhon Road, New York. 7684652</p>
                                </div>
                            </a>

                            <a href="javascript:void(0)" class="similar-property-listing">
                                <img src="images/similar-property-img3.jpg" alt="">
                                <div class="similar-property-content">
                                    <p class="btn btn-primary red-btn">View Details</p>
                                    <p class="similar-property-content-txt">12/D S. N. Jhon Road, New York. 7684652</p>
                                </div>
                            </a>

                            <a href="javascript:void(0)" class="similar-property-listing">
                                <img src="images/similar-property-img4.jpg" alt="">
                                <div class="similar-property-content">
                                    <p class="btn btn-primary red-btn">View Details</p>
                                    <p class="similar-property-content-txt">12/D S. N. Jhon Road, New York. 7684652</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <!-- Property Details Similar Property -->

                    <!-- Property Details Similar Property -->
                    <div class="property-details-right-similar-property">
                        <h4>Recently Sold Homes</h4>
                        <div class="similar-property-listing-right">
                            <a href="javascript:void(0)" class="similar-property-listing">
                                <img src="images/similar-property-img1.jpg" alt="">
                                <div class="similar-property-content">
                                    <p class="sold-priceTxt">$123.34</p>
                                    <p class="similar-property-content-txt">12/D S. N. Jhon Road, New York. 7684652</p>
                                </div>
                            </a>

                            <a href="javascript:void(0)" class="similar-property-listing">
                                <img src="images/similar-property-img2.jpg" alt="">
                                <div class="similar-property-content">
                                    <p class="sold-priceTxt">$133.34</p>
                                    <p class="similar-property-content-txt">12/D S. N. Jhon Road, New York. 7684652</p>
                                </div>
                            </a>

                            <a href="javascript:void(0)" class="similar-property-listing">
                                <img src="images/similar-property-img3.jpg" alt="">
                                <div class="similar-property-content">
                                    <p class="sold-priceTxt">$153.34</p>
                                    <p class="similar-property-content-txt">12/D S. N. Jhon Road, New York. 7684652</p>
                                </div>
                            </a>

                            <a href="javascript:void(0)" class="similar-property-listing">
                                <img src="images/similar-property-img4.jpg" alt="">
                                <div class="similar-property-content">
                                    <p class="sold-priceTxt">$123.34</p>
                                    <p class="similar-property-content-txt">12/D S. N. Jhon Road, New York. 7684652</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <!-- Property Details Similar Property -->

                    <!-- Property Details AD -->
                    <div class="property-details-right-ad">
                        <a href="javascript:void(0)"><img src="images/prpperty-details-ad.png" alt=""></a>
                    </div>
                    <!-- Property Details AD -->
                </div>
                <!-- Property Details Right -->
            </div>
        </div>
    </div>
</section>
<!-- Start Content Section ==================================================-->