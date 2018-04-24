<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>
<tbody>
    <tr style="background:#f5f5f5;">
        <td style="padding: 15px;">
            <p style="margin:0; padding:0 0 10px;"><strong>Hi Admin,</strong></p>
            <p style="margin:0; padding:0;"><strong>Leave Us a Note : Feedback from Contact Us</strong></p>
            <p class="confirmation" style="padding-bottom: 0;">Leave a note Form Contact.</p>
            <p> Name : <?= Html::encode($contactFeedback->salutation) ?> <?= Html::encode($contactFeedback->full_name) ?></p>
            <p> Email : <?= Html::encode($contactFeedback->email) ?></p>
            <p> Subject : <?= Html::encode($contactFeedback->subject) ?></p>
            <p> Message : <?= Html::encode($contactFeedback->message) ?></p>
        </td>
    </tr>
</tbody>
