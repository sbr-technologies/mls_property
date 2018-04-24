<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>
<tbody>
    <tr style="background:#f5f5f5;">
        <td style="padding: 15px;">
            <p style="margin:0; padding:0 0 10px;"><strong>Hi Admin,</strong></p>
            <p style="margin:0; padding:0;"><strong>Ask a neighborhood expert</strong></p>
            <p class="confirmation" style="padding-bottom: 0;">Thank you for Ask a neighborhood expert Request</p>
            <p>Send Request User Details , given below :</p>
            Name : <?= Html::encode($propertyRequest->name) ?> <br>
            Email : <?= Html::encode($propertyRequest->email) ?> <br>
            Phone : <?= Html::encode($propertyRequest->phone) ?> <br>
            message : <?= Html::encode($propertyRequest->message) ?> </p>
            <p>Your Property Details , given below:</p>
            <p></p>
            <p>
            <h5> Property Address : </h5>
                Property : <?= Html::encode($propertyRequest->property->formattedAddress) ?><br>
                price : <?= Yii::$app->formatter->asCurrency($propertyRequest->property->price) ?><br>
            </p>
        </td>
    </tr>
</tbody>

