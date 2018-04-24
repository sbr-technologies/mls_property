<?php
use yii\helpers\Html;
Yii::$app->formatter->timeZone = $receiver->timeZone;
?>

<tbody>
    <tr style="background:#f5f5f5;">
        <td style="padding: 15px;">
            <p style="margin:0; padding:0 0 10px;"><strong>Hi <?= Html::encode($receiver->fullName) ?>,</strong></p>
            <p style="margin:0; padding:0;"><strong>New message Received</strong></p>
            <p class="confirmation" style="padding-bottom: 0;">You have received a new message bellow details.</p>
            <p></p>
            <p>
                Sender : <?= $sender->fullName ?><br>
                Send At : <?= Yii::$app->formatter->asDatetime($message->created_at) ?>
            </p>
            <p>
                Subject: <?= $message->subject?>
            </p>
            <p>
                <?= $message->message?>
            </p>
        </td>
    </tr>
</tbody>

