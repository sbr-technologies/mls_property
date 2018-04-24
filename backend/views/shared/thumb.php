<?php
use common\models\Property;
use common\models\PhotoGallery;
use yii\helpers\Url;
?>
<div style="color:#666; font:14px/22px 'arial', sans-serif; margin:0 auto; padding:10px; outline:none; box-sizing:border-box; text-decoration:none; border:none; background:#fff; width:650px;">
    <div style="width:100%; display:inline-block;">
        <?php
            $now = time();
            $agency = null;
            $listedBy = $model->listedBy;
            if($listedBy->agency_id){
                $agency = $listedBy->agency;
            }
            ?>
            <div style="background:#eee; border:1px #d5d5d5 solid; border-radius:2px; display:inline-block; margin-bottom:10px; width:100%; position:relative;">
                <div style="padding:0; position:relative; background: #fff; width:44%; float:left;">
                    <img style="width:100%; height:150px;" src="<?= $model->getFeatureImage(PhotoGallery::THUMBNAIL)?>" alt="<?= $model->getFeatureImage(PhotoGallery::LANDSCAPE)?>" height="150">
                    <div class="featurespopupslider"> </div>
                    <div style="background:rgba(255,255,255,0.8); display:inline-block; width:100%;">
                        <h2 style="font-size:22px; color:#131313; font-weight:600; margin:0; padding:3%; display:inline-block; width:96%; border-bottom:1px #ddd solid;"><?= Yii::$app->formatter->asCurrency($model->currentPrice)?></h2>
                        <?php if($agency){?>
                        <div style="float:left; font-size:12px; padding:5px 10px; ">
                            <img src="<?php echo (!empty($agency->photo)? $agency->photo->imageUrl:'') ?>" alt="logo" style="float:left; margin:0; height:30px; width: 30px">
                            <p style="float:left; margin:2px 0 0 6px; line-height:30px;"><?= $agency->name?></p>
                        </div>
                        <?php }?>
                        <div style="float:right; font-size:12px; border-left:1px #979797 solid; text-align:right; padding:5px 10px; line-height:30px;">
                            <span style="color:#b21117;"><a href="<?= Url::to(['property/view', 'slug' => $model->slug], true)?>">View Details</a></span>
                        </div>
                    </div>
                </div>

                <div style="width:50%; float:left; padding:1% 2%;">
                    <div style="float:left; width:100%;">
                        <span style="background:#5cb85c; padding:4px 8px; margin-right:5px; color:#fff; border-radius:3px; font-size:12px;"><?= ucwords($model->market_status)?></span>
                        <span style="background:#5bc0de; padding:4px 8px; margin-right:5px; color:#fff; border-radius:3px; font-size:12px;"><?= $model->propertyCategory->title?></span>
                    </div>

                    <h4 style="color:#b21117; font-size:15px; margin:6px 0 6px;  line-height:18px; display:inline-block; width:100%;"><?= $model->formattedAddress?></h4>
                    <a href="javascript:void(0)" style="font-size:14px;  line-height:18px;">Property ID # <?= $model->reference_id?></a>
                    <p style="margin-bottom:10px; font-size:15px; color:#121212; line-height:18px;"><?= $model->getPropertyTypes()?></p>
                    <ul style="width:100%; display:inline-block; padding:0; margin:5px 0 10px;">
                        <li style="color:#666; border-right:1px #d5d5d5 solid; padding:4px 10px; text-align:center; float:left; font-weight:normal; font-size:13px; list-style:none; margin: 0;"><strong><img src="<?= Yii::$app->urlManager->baseUrl?>/images/icons/bd.png" alt=""></strong> bd <span style="display:block; font-weight:600; color:#000;"><?= $model->no_of_room?></span></li>
                        <li style="color:#666; border-right:1px #d5d5d5 solid; padding:4px 10px; text-align:center; float:left; font-weight:normal; font-size:13px; list-style:none; margin: 0;"><strong><img src="<?= Yii::$app->urlManager->baseUrl?>/images/icons/ba.png" alt=""></strong> ba <span style="display:block; font-weight:600; color:#000;"><?= $model->no_of_bathroom?></span></li>
                        <li style="color:#666; border-right:1px #d5d5d5 solid; padding:4px 10px; text-align:center; float:left; font-weight:normal; font-size:13px; list-style:none; margin: 0;"><strong><img src="<?= Yii::$app->urlManager->baseUrl?>/images/icons/tl.png" alt=""></strong> tl <span style="display:block; font-weight:600; color:#000;"><?= $model->no_of_toilet?></span></li>
                        <li style="color:#666; border-right:1px #d5d5d5 solid; padding:4px 10px; text-align:center; float:left; font-weight:normal; font-size:13px; list-style:none; margin: 0;"><strong><img src="<?= Yii::$app->urlManager->baseUrl?>/images/icons/gr.png" alt=""></strong> gr <span style="display:block; font-weight:600; color:#000;"><?= $model->no_of_garage?></span></li>
                        <li style="color:#666; padding:4px 10px; text-align:center; float:left; font-weight:normal; font-size:13px; list-style:none; margin: 0;"><strong><img src="<?= Yii::$app->urlManager->baseUrl?>/images/icons/sq.png" alt=""></strong> SqM <span style="display:block; font-weight:600; color:#000;"><?= $model->house_size?></span></li>
                    </ul>
                    <!--<a style="background:#5bc0de; border-color:#b21117; color:#fff; text-decoration:none; padding:7px 16px; font-size:16px;">Expires in <?= $model->daysExpiring?> Days</a> <a style="background:#b21117; border-color:#b21117; color:#fff; text-decoration:none; padding:7px 16px; font-size:16px; margin-left: 15px;" href="<?= Url::to(['property/quick-renew', 'key' => $model->auth_key, 'time' => $now]);?>">Renew</a>-->
                </div>
            </div>
    </div>
</div>