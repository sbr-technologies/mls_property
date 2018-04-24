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
                    <strong>Hi User <?= $propertyRequest->user->FullName ?></strong>,
                <?php
                }else{
                ?>
                <strong>Hi </strong>,
                <?php } ?>
            </p>
            <p style="margin:0; padding:0;"><strong>Discard Property Showing Request</strong></p>
            <p class="confirmation" style="padding-bottom: 0;">Your Property Showing Request has been Discard.</p>
            <p>Your Property send Request Details, given below :</p>
            Name : <?= Html::encode($propertyRequest->name) ?> <br>
            Email : <?= Html::encode($propertyRequest->email) ?> <br>
            Phone : <?= Html::encode($propertyRequest->phone) ?> <br>
            Schedule Date : <?= Html::encode(date("d-m-Y h:i",$propertyRequest->schedule)) ?> <br>
            Note : <?= Html::encode($propertyRequest->note) ?> </p>
            <p>Your Property Details , given below:</p>
            <p></p>
            <p>
            <h5> Property Address : </h5>
                Property : <?= Html::encode($propertyRequest->property->formattedAddress) ?><br>

            </p>
        </td>
    </tr>
</tbody>

