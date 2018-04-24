<?php
use yii\helpers\Html;
Yii::$app->formatter->timeZone = $subscription->user->timeZone;
?>

<tbody>
    <tr style="background:#f5f5f5;">
        <td style="padding: 15px;">
            <p style="margin:0; padding:0 0 10px;"><strong>Subject :- Subscription Expires-NaijaHouses.com</strong></p>

            <p style="margin:0; padding:0 0 10px;"><strong>Hi <?= Html::encode($subscription->user->first_name) ?>,</strong></p>

            <p>The MLS Properties Ltd (Property Id). Your subscription will be expire in <?= $remainDays ?>.</p>

            <p>To avoid any disruption in services, please renew your subscription before it expire.</p>

            <p style="margin:0; padding:10px 0 0 50px;"><?= Html::a('Renew Now', \yii\helpers\Url::to(['subscription/plan-details', 'id' => $subscription->plan_id], true))?></p>
        </td>
    </tr>
</tbody>
