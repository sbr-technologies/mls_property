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
            <p>To activate your account,Please click on the following link or copy and paste the link on your browser :</p>
            <p></p>
            <p>
                <?= $verificationUrl ?>
            </p>
	<p> After activation, Please use the following detils to log in your account:</p>
	<p> UserName:- <?= Html::encode($user->email) ?></p>
	<p></p>
	<p> Password:- <?= Html::encode($user->rawPassword) ?></p>
        </td>
    </tr>
</tbody>
