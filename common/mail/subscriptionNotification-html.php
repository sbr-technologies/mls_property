<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>
<!--<tbody>
    <tr style="background:#f5f5f5;">
        <td style="padding: 15px;">
            <p style="margin:0; padding:0 0 10px;"><strong>Hi <?= Html::encode($subscription->user->fullName) ?>,</strong></p>
            <p style="margin:0; padding:0;"><strong>Subscription Successful</strong></p>
            <p class="confirmation" style="padding-bottom: 0;">Thank you for subscribe</p>
            <p>You have successfully subscribed to <?= $plan->title?> for <?= $plan->serviceCategory->name?></p>
            <p>Amount charged: <?= Yii::$app->formatter->asCurrency($subscription->paid_amount)?> </p>
            <p>Your subscription valid upto <?= Yii::$app->formatter->asDate($subscription->subs_end)?></p>
        </td>
    </tr>
</tbody>-->
<tbody>
    <tr style="background:#f5f5f5;">
        <td style="padding: 15px;">
            <p style="margin:0; padding:0 0 10px;"><strong>Subject :- Subscription Activation-NaijaHouses.com</strong></p>

            <p style="margin:0; padding:0 0 10px;"><strong>Hi <?= Html::encode($subscription->user->first_name) ?>,</strong></p>

            <p class="confirmation" style="padding-bottom: 0;">Thanks for making payment.</p>

            <p>Your subscription has been activated and your listing have been published.​</p>

            <p>Please log in and edit your listing as you wish.</p>
            <p>Please contact us if you have any question.</p>
        </td>
    </tr>
</tbody>


