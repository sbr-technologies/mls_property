<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>

<tbody>
    <tr style="background:#f5f5f5;">
        <td style="padding: 15px;">
            <p style="margin:0; padding:0 0 10px;">
                <strong>Hi Admin</strong>,
            </p>
            <!--<p style="margin:0; padding:0;"><strong>Follow the link below to reset your password :</strong></p>-->
            <!--<p class="confirmation" style="padding-bottom: 0;">Thank you for Sending Property Request.</p>-->
            <p>Property send Request User Details , given below :</p>
            <p>Requested By : <?= Html::encode($propertyRequest->user->FullName) ?> <br>
            Name : <?= Html::encode($propertyRequest->user->FullName) ?> <br>
            Email : <?= Html::encode($propertyRequest->user->emailAddress) ?> <br>
            Phone : <?= Html::encode($propertyRequest->user->phoneNumber) ?> <br>
            Schedule Date : <?= Yii::$app->formatter->asDate($propertyRequest->schedule); ?> </p>
            <p>Your Property Details , given below:</p>
            <p></p>
            <p>
                Property Details : </p>
            <p>
                Property Category : <?= Html::encode($propertyRequest->propertyCategory->title) ?><br>
                Property Type : <?= Html::encode($propertyRequest->propertyType->title) ?><br>
                No of Room : <?= Html::encode($propertyRequest->no_of_bed_room) ?><br>
                State : <?= Html::encode($propertyRequest->state) ?><br>
                Locality : <?= Html::encode($propertyRequest->locality ? $propertyRequest->locality : "" ) ?><br>
                Comments : <?= Html::encode($propertyRequest->comment ? $propertyRequest->comment : "") ?><br>
            </p>
        </td>
    </tr>
</tbody>
    


        
