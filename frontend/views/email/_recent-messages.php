<?php
use common\models\Messages;
use frontend\models\Common;
use common\models\User;
?>
<div class="body_title_head">
    <h2><?= Yii::t('app', 'Recent Messages') ?></h2>
</div>
<?php
$recentMessages = Messages::getRecent();
if (!empty($recentMessages)) :
    foreach ($recentMessages as $message) :
        ?>
        <div class="recent_messages_holder">
            <div class="recent_messages_img"><img src="<?=  $message->sender->getImageUrl(User::THUMBNAIL) ?>" alt="<?= $message->sender->commonName?>"></div>
            <div class="recent_messages_text">
                <h3><?= $message->sender->fullName ?></h3>
                <p><?= Common::excerpt($message->message, 0, 60) ?> <a href="<?= Yii::$app->urlManager->createUrl(['/messages/inbox', 'id' => $message->id]) ?>"><?= Yii::t('app', 'Read More') ?></a></p>
            </div>
            <div class="clear"></div>
        </div>
    <?php
    endforeach;
else :
    ?>
    <p><?= Yii::t('app', 'No recent messages') ?></p> 
<?php endif;
?>

<div class="text-right"><a href="<?= Yii::$app->urlManager->createUrl('/messages/inbox') ?>" class="btn btn_success_small"><?= Yii::t('app', 'View More') ?></a></div>
<div class="clear"></div>