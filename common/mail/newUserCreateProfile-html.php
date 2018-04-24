<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>
<tbody>
    <tr style="background:#f5f5f5;">
        <td style="padding: 15px;">
            <p style="margin:0; padding:0 0 10px;"><strong>Hi <?= Html::encode($user->fullName) ?>,</strong></p>
            <p style="margin:0; padding:0;"><strong>Your Registration : Update Profile</strong></p>
            <p class="confirmation" style="padding-bottom: 0;">Your email has been successfully verified.</p>
            <p>Please complete your profile and enjoy all options available to you on NaijaHouses.com</p>
            <p></p>

            <?= Html::a('Complete Your Profile', $loginUrl,['class' => 'btn btn-default btn-main']
            ); ?>

        </td>
    </tr>
</tbody>
