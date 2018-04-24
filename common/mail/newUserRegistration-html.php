<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>
<tbody>
    <tr style="background:#f5f5f5;">
        <td style="padding: 15px;">
            <p style="margin:0; padding:0 0 10px;"><strong>Hi <?= Html::encode($user->fullName) ?>,</strong></p>
            <p style="margin:0; padding:0;"><strong>Your Registration : NaijaHouses.com</strong></p>
            <p class="confirmation" style="padding-bottom: 0;">Thank you for registration at NaijaHouse.com</p>
            <p>Please use the following to login to your account :</p>
            <p></p>
            <p>
                Username : <?= Html::encode($user->email) ?><br>
                Password : <?= Html::encode($user->rawPassword) ?>
            </p>
        </td>
    </tr>
</tbody>

