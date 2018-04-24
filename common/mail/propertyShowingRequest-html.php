<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */
//yii\helpers\VarDumper::dump($propertyRequest);
//yii\helpers\VarDumper::dump(date("d-m-Y H:i",$propertyRequest->schedule));exit;
?>

<tbody>
    <tr style="background:#f5f5f5;">
        <td style="padding: 15px;">
            <p style="margin:0; padding:0 0 10px;">
                <strong>
                <?php
                if(!empty($propertyRequest->user->emailAddress)){
                ?>
                    <strong>Hi Agent <?= $propertyRequest->user->FullName ?></strong>
                <?php
                }else{
                ?>
                <strong>Hi Admin</strong>
                <?php } ?>,
                </strong>
            </p>
            <p style="margin:0; padding:0;"><strong>Property Showing Request</strong></p>
            <p class="confirmation" style="padding-bottom: 0;">Thank you for Sending Property Showing Request</p>
            <p>Property send Request User Details , given below :</p>
            Name : <?= Html::encode($propertyRequest->name) ?> <br>
            Email : <?= Html::encode($propertyRequest->email) ?> <br>
            Phone : <?= Html::encode($propertyRequest->phone) ?> <br>
            Schedule Date : <?= date("d-m-Y H:i",$propertyRequest->schedule);
                if($propertyRequest['schedule_end'] != ''){
                    echo "-".date("H:i",$propertyRequest['schedule_end']);
                }?> <br>
            Note : <?= Html::encode($propertyRequest->note) ?> </p>
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
