<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>

<div class="password-reset">
    <p>Newsletter Subscription </p><br>
    <strong>Hi <?= Html::encode($subscriberModel->first_name) ?></strong>,
    <p>Thank you for Subscribe your email address for getting latest upadte from MLS Property</p>
    <p>If you are not made this subscription, you can unsubscribe by <a href="<?= $unsubscribeUrl ?>">click here</a></p>
    <p></p>
    
    
    
</div>
