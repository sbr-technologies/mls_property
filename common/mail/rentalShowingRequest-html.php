<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>
<tbody>
    <tr style="background:#f5f5f5;">
        <td style="padding: 15px;">
            <p style="margin:0; padding:0 0 10px;">
                <?php
                if(!empty($propertyRequest->user->emailAddress)){
                ?>
                    <strong>Hi Agent <?= $propertyRequest->user->FullName ?></strong>
                <?php
                }else{
                ?>
                <strong>Hi Admin</strong>
                <?php } ?>,
            </p>
            <p style="margin:0; padding:0;"><strong>Rental Property Showing Request :</strong></p>
            <p class="confirmation" style="padding-bottom: 0;">Thank you for Sending Property Showing Request</p>
            <p>Property send Request User Details , given below :</p>
            Name : <?= Html::encode($propertyRequest->name) ?> <br>
            Email : <?= Html::encode($propertyRequest->email) ?> <br>
            Phone : <?= Html::encode($propertyRequest->phone) ?> <br>
            Schedule Date : <?= $dateTime ? Yii::$app->formatter->asDatetime($dateTime) : Yii::$app->formatter->asDate($date) ?> <br>
            Note : <?= Html::encode($propertyRequest->note) ?> </p>
            <p>Your Property Details , given below:</p>
            <p></p>
            <p>
            <h5> Property Address : </h5>
                Property : <?= Html::encode($propertyRequest->rental->formattedAddress) ?><br>
                price : <?= Yii::$app->formatter->asCurrency($propertyRequest->rental->price) ?><br>

            </p>
        </td>
    </tr>
</tbody>
