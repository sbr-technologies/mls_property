<?php

use yii\web\View;

$localJs = 'var msgDeleteUrl = "' . urldecode(Yii::$app->urlManager->createUrl(['/message/delete'])) . '";';

$this->registerJs($localJs, View::POS_HEAD);
?>
<a href="<?= Yii::$app->urlManager->createUrl(['/message/view', 'id' => $message->id, 'action' => 'reply']) ?>" data-toggle="tooltip" class="tooltip-test" title="" data-original-title="Reply"><i class="fa fa-reply"></i></a>
<a href="<?= Yii::$app->urlManager->createUrl(['/message/view', 'id' => $message->id, 'action' => 'forward']) ?>" data-toggle="tooltip" class="tooltip-test" title="" data-original-title="Forward"><i class="fa fa-mail-forward"></i></a>

<?php
$attachment = $message->messageAttachments;
if (!empty($attachment)):
    ?>
    |
    <a href="#" data-toggle="tooltip" data-msg="<?= $message->id ?>" class="tooltip-test msg-file-zip" title="" data-original-title="<?= Yii::t('app', 'Download All Attachments') ?>"><i class="fa fa-download"></i></a>
<?php endif; ?>