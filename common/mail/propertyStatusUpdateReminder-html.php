<?php
use yii\helpers\Html;
Yii::$app->formatter->timeZone = $property->user->timeZone;
?>

<tbody>
    <tr style="background:#f5f5f5;">
        <td style="padding: 15px;">
            <p style="margin:0; padding:0 0 10px;"><strong>Hi <?= Html::encode($property->user->fullName) ?>,</strong></p>
            <p style="margin:0; padding:0;"><strong>Update Property Status</strong></p>
            <p class="confirmation" style="padding-bottom: 0;">
                Property : <?= $property->formattedAddress ?><br>
                Price     :<?= Yii::$app->formatter->asCurrency($property->price, $property->currency->code)?>  
                Listed On : <?= Yii::$app->formatter->asDatetime($property->created_at) ?>
            </p>
        </td>
    </tr>
</tbody>
