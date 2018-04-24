<?php
use Yii;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>
<tbody>
    <tr style="background:#f5f5f5;">
        <td style="padding: 15px;">
            <p style="margin:0; padding:0 0 10px;"><strong>Hi <?= Html::encode($user->fullName) ?>,</strong></p>
            <p style="margin:0; padding:0;"><strong>Change Password</strong></p>
            <p class="confirmation" style="padding-bottom: 0;">Your Password Changed Successfully, If you did not do it,Please contact with <?= Yii::$app->name ?> Admin.</p>
            <p>Your Updated Login Credentials Details , given below:</p>
            <p></p>
            <p>
                Username : <?= Html::encode($user->email) ?><br>
                Password : <?= Html::encode($user->rawPassword) ?>
            </p>
        </td>
    </tr>
</tbody>

