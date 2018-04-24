<?php

use frontend\models\Common;
 $notifications = new \common\models\Notification();
 $notifications = $notifications->searchAll();
 
?>
<li class="dropdown notifications-menu notification_holder"> <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-bell" aria-hidden="true"></i> <span class="label label-warning"><?= count($notifications) ?></span> </a>
    <ul class="dropdown-menu">
      
        <li class="header clearfix">You have <?= count($notifications) ?> notifications
        <?php if(count($notifications) > 0){?>
            <span class="notification_read pull-right"><a href="#" class="label label-primary readall"><?=Yii::t('app', 'All Read')?></a></span>
        <?php }?>
        </li>
        <?php if ($notifications):?>
        <li> 
            <ul class="menu">
                <?php
                foreach ($notifications as $rcpt) :
                ?>
                    <li>
                      <div class="notification_left_icon"> <img src="<?= $rcpt['sent_by']->imageUrl ?>" width="65"/> </div>
                        <div class="notification_right">
                            <div class="notification_right_title">
                                <div class=""><?= htmlspecialchars($rcpt['sent_by']->commonName) ?></div>
                                <div class=""><?= Yii::$app->formatter->asDatetime($rcpt['sent_at']) ?><a href="#" title="Mark as read" class="pull-right bullet tooltip-test mark_as_read" data-id="<?=$rcpt['id']?>" data-toggle="tooltip" data-original-title="Mark as read"></a></div>
                            </div>
                            <div class="notification_right_filename"><a href="<?= !empty($rcpt['target_path']) ? Yii::$app->urlManager->createUrl($rcpt['target_path']) : "#" ?>"  data-id="<?=$rcpt['id']?>" class="csd"><?= !empty($rcpt['icon_class']) ? '<i class="'.$rcpt['icon_class'].'"></i>' : '' ?> <?= htmlspecialchars($rcpt['subject']) ?></a></div>
                            <div class="notification_right_description">
                                <a href="<?= !empty($rcpt['target_path']) ? Yii::$app->urlManager->createUrl($rcpt['target_path']) : "#" ?>"  data-id="<?=$rcpt['id']?>" class="csd"><?= $rcpt['message'] ?></a></div>
                        </div>
                    </li>
                    <?php
                endforeach;
                ?>
            </ul>
        </li>
        <?php endif; ?>
    </ul>
</li>