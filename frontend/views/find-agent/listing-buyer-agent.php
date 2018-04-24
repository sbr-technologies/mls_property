<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use common\models\StaticPage;



$staticPageObj  =  StaticPage::find()->where(['id' => 10])->one();
//yii\helpers\VarDumper::dump($staticPageObj); exit;
?>

<!-- Start Content Section ==================================================-->
<section>
    <div class="inner-content-sec">
        <div class="container">
            <div class="row">
                <div class="interviewing-listing-agent-sec">
                    <div class="col-sm-9 interviewing-listing-left">
                        <?php
                        if(!empty($staticPageObj)){
                            $photos = $staticPageObj->photos;
                            $this->title = $staticPageObj->name;
                        ?>
                        <h2><span>SELL</span> <?= $staticPageObj->name ?></h2>
                        <h4>By <?= $staticPageObj->user->fullName ?> |<?= date("Y-m-d",$staticPageObj->created_at) ?></h4>
                        <?php
                        if(is_array($photos)){
                            foreach($photos as $photo){
                                ?>
                                <img src="<?php echo $photo->getImageUrl() ?>" alt="">
                                <?php
                            }
                        }
                        ?>
                        <?= $staticPageObj->content ?>
                        <?php 
                        }else{
                            ?>
                        
                        <?php
                        }
                        ?>
                    </div>

                    <!-- Property Details Right -->
                    <div class="col-sm-3 property-details-right">
                        <!-- Property Details AD -->
                        <div class="property-details-right-ad">
                            <a href="javascript:void(0)"><img src="<?=Yii::$app->urlManager->baseUrl?>/public_main/images/prpperty-details-ad.png" alt=""></a>
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

                        

                        

                        <!-- Property Details AD -->
                        <div class="property-details-right-ad">
                            <a href="javascript:void(0)"><img src="<?=Yii::$app->urlManager->baseUrl?>/public_main/images/prpperty-details-ad.png" alt=""></a>
                        </div>
                        <!-- Property Details AD -->
                    </div>
                    <!-- Property Details Right -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Start Content Section ==================================================-->