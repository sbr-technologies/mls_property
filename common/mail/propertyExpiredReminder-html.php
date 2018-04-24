<?php
use yii\helpers\Html;
Yii::$app->formatter->timeZone = $property->user->timeZone;
?>

<tbody>
    <tr style="background:#f5f5f5;">
        <td style="padding: 15px;">
            <p style="margin:0; padding:0 0 10px;"><strong>Hi <?= Html::encode($property->user->fullName) ?>,</strong></p>
            <p style="margin:0; padding:0;"><strong>Your property listing expire will be in <?= $remainDays ?></strong></p>
            <p style="margin:0; padding:0;">To avoid any disruption in services, please renew your property before it expire.</p>
            <p class="confirmation" style="padding-bottom: 0;">
                Property : <?= $property->formattedAddress ?><br>
                Price     :<?= Yii::$app->formatter->asCurrency($property->price, $property->currency->code)?> <br> 
                Listed On : <?= date("d-m-Y",  strtotime($property->listed_date)) ?><br>
                Expired On : <?= date("d-m-Y",  strtotime($property->expired_date)) ?>
            </p>
        </td>
    </tr>
</tbody>
