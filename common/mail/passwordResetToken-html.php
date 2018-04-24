<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
<tbody>
    <tr style="background:#f5f5f5;">
        <td style="padding: 15px;">
            <p style="margin:0; padding:0 0 10px;"><strong>Hi <?= Html::encode($user->commonName) ?>,</strong></p>
            <p style="margin:0; padding:0;"><strong>Follow the link below to reset your password :</strong></p>
            <p class="confirmation" style="padding-bottom: 0;"><?= Html::a(Html::encode($resetLink), $resetLink) ?>.</p>
        </td>
    </tr>
</tbody>