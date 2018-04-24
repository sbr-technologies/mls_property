<?php
use yii\helpers\Url;
$listingAgent = $model->property->user;
$showingAgent = $model->user;
$dateRange = '';

if(isset($model->schedule) && $model->schedule != '' && isset($model->schedule_end) && $model->schedule_end == ''){
    $dateRange = date('h:i A',$model->schedule);
}elseif(isset($model->schedule) && $model->schedule != '' && isset($model->schedule_end) && $model->schedule_end != ''){
    $dateRange = date('h:i A',$model->schedule)."-".date('h:i A',$model->schedule_end);
}elseif(isset($model->schedule) && $model->schedule == '' && isset($model->schedule_end) && $model->schedule_end != ''){
    $dateRange = date('h:i A',$model->schedule_end);
}
?>

<div style="color:#666; font:14px/22px arial, sans-serif; margin:0 auto; padding:20px; outline:none; box-sizing:border-box; text-decoration:none; border:none; background:#fff; width:650px;">
    <div>
        <?php if($type == 'request'){?>
        <h2 style="color:#b21117; font-size:22px; margin:0 0 25px; font-weight:600; text-align:center;"><span style="display:inline-block; margin:0;">Showing Request Received</span></h2>
        <?php }elseif($type == 'approve'){?>
        <h2 style="color:#01a04e; font-size:22px; margin:0 0 25px; font-weight:600; text-align:center;"><img src="'.Yii::$app->params['homeUrl']. '/images/icon-check.png" alt="" style="display:inline-block; margin:0 0 0 0;"> <span style="display:inline-block; margin:0;">Showing Request Approved</span></h2>
        <?php }elseif($type == 'decline'){?>
        <h2 style="color:#b21117; font-size:22px; margin:0 0 25px; font-weight:600; text-align:center;"><img src="'.Yii::$app->params['homeUrl']. '/images/icon-close.png" alt="" style="display:inline-block; margin:0 0 0 0;"> <span style="display:inline-block; margin:0;">Showing Request Declined</span></h2>
        <?php }elseif($type == 'cancel'){?>
        <h2 style="color:#b21117; font-size:22px; margin:0 0 25px; font-weight:600; text-align:center;"><img src="'.Yii::$app->params['homeUrl']. '/images/icon-close.png" alt="" style="display:inline-block; margin:0 0 0 0;"> <span style="display:inline-block; margin:0;">Showing Request Cancelled</span></h2>
        <?php }?>
        <div style="clear:both;"></div>
        <?= $this->render('//shared/thumb', ['model' => $model->property])?>
        <div style="clear:both;"></div>
        <h3 style="color:#b21117; font-size:18px; margin:20px 0; font-weight:600; border-bottom:1px #ddd solid; padding-bottom:10px;">Appointment Details</h3>
        <p style="width:100%; float:left; margin:0;"><img src="<?= Yii::$app->params['homeUrl']. '/images/icon-road.png' ?>" alt="" style="margin-top:2px; float:left;"> <span style="border-left:1px #333 solid; padding:0 0 5px 25px; float:left; margin-left:15px;">Showing</span></p>
        <p style="width:100%; float:left; margin:0;"><img src="<?= Yii::$app->params['homeUrl']. '/images/icon-date.png' ?>" alt="" style="margin-top:2px; float:left;"> <span style="border-left:1px #333 solid; padding:0 0 5px 25px; float:left; margin-left:15px;"><?= Yii::$app->formatter->asDate($model->schedule)?></span></p>
        <p style="width:100%; float:left; margin:0;"><img src="<?= Yii::$app->params['homeUrl']. '/images/icon-clock.png' ?>" alt="" style="margin-top:2px; float:left;"> <span style="border-left:1px #333 solid; padding:0 0 5px 25px; float:left; margin-left:15px;"><?= $dateRange?></span></p>
        <p style="width:100%; float:left; margin:15px 0;"><span style="float:left;"><?= $model->note?></span></p>
        <div style="clear:both;"></div>
        <div style="text-align:center">
        <?php if($type == 'request' && $to == 'la'){?>
            <a href="<?= Yii::$app->params['homeUrl'].'/property-showing-request/quick-approve?key='. $model->auth_key.'&time='. $model->created_at ?>" style="background:#1093f5; border-radius:4px; padding:11px 30px; font-size:14px; color:#1093f5; text-decoration:none; display:inline-block; color:#fff; text-align:center; font-size:18px; margin:10px 3px 30px;">Approve</a>
            <a href="<?= Yii::$app->params['homeUrl'].'/property-showing-request/quick-decline?key='. $model->auth_key.'&time='. $model->created_at ?>" style="background:#b21117; border-radius:4px; padding:11px 30px; font-size:14px; color:#1093f5; text-decoration:none; display:inline-block; color:#fff; text-align:center; font-size:18px; margin:10px 3px 30px;">Decline</a>
        <?php }elseif($type == 'request' && $to == 'sa'){?>
            <a href="<?= Yii::$app->params['homeUrl'].'/property-showing-request/quick-cancel?key='. $model->auth_key.'&time='. $model->created_at?>" style="background:#1093f5; border-radius:4px; padding:11px 30px; font-size:14px; color:#1093f5; text-decoration:none; display:inline-block; color:#fff; text-align:center; font-size:18px; margin:10px 3px 30px;">Cancel</a>
            <a href="<?= Yii::$app->params['homeUrl'].'/property-showing-request/quick-re-schedule?key='. $model->auth_key.'&time='. $model->created_at?>" style="background:#b21117; border-radius:4px; padding:11px 30px; font-size:14px; color:#1093f5; text-decoration:none; display:inline-block; color:#fff; text-align:center; font-size:18px; margin:10px 3px 30px;">Re-Schedule</a>
        <?php }?>
        </div>
        <div style="clear:both;"></div>
        <h3 style="color:#b21117; font-size:18px; margin:20px 0; font-weight:600; border-bottom:1px #ddd solid; padding-bottom:10px;">Showing Request by</h3>
        <img src="<?= $showingAgent->imageUrl?>" alt="" style="width:150px; height:100px; float:left; border:1px #ddd solid; padding:4px; margin:0 15px 10px 0;">
        <h4 style="font-size:16px; color:#333; margin:0 0 5px;"><a href="<?= Url::to(['user/view-profile', 'slug' => $showingAgent->slug], true);?>"><?=$showingAgent->fullName?></a></h4>
        <h5 style="font-size:14px; color:#999; margin:0 0 5px;"><?=$showingAgent->email?></h5>
        <p style="color:#666; margin:0 0 5px; font-size:12px;"><?=$showingAgent->getMobile1()?></p>
        <?php if($showingAgent->agency_id){?>
        <h5 style="font-size:14px; color:#999; margin:0 0 5px;"><a href="<?= Url::to(['agency/view', 'slug' => $showingAgent->agency->slug], true);?>"><?=$showingAgent->agency->name?></a></h5>
        <?php }?>
        <div style="clear:both;"></div>
        <h3 style="color:#b21117; font-size:18px; margin:50px 0 20px 0; font-weight:600; border-bottom:1px #ddd solid; padding-bottom:10px;">Listing Presented by</h3>
        <img src="<?= $listingAgent->imageUrl?>" alt="" style="width:150px; height:100px; float:left; border:1px #ddd solid; padding:4px; margin:0 15px 10px 0;">
        <h4 style="font-size:16px; color:#333; margin:0 0 5px;"><a href="<?= Url::to(['user/view-profile', 'slug' => $listingAgent->slug], true);?>"><?=$listingAgent->fullName?></a></h4>
        <h4 style="font-size:16px; color:#333; margin:0 0 5px;"><?=$listingAgent->email?></h4>
        <h4 style="font-size:16px; color:#333; margin:0 0 5px;"><?=$listingAgent->getMobile1()?></h4>
        <?php if($listingAgent->agency_id){?>
        <h5 style="font-size:14px; color:#999; margin:0 0 5px;"><a href="<?= Url::to(['agency/view', 'slug' => $listingAgent->agency->slug], true);?>"><?=$listingAgent->agency->name?></a></h5>
        <?php }?>
        <div style="clear:both;"></div>
        <p style="color:#666; margin:30px 0 0 0; padding:10px 0; font-size:13px; border-top:1px #ddd solid; text-align:center;">For questions regarding this appointment, Please contact the listing agent directly at <?= $listingAgent->getMobile1()?></p>
        
    </div>
</div>