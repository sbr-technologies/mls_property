<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>
<tbody>
    <tr style="background:#f5f5f5;">
        <td style="padding: 15px;">
            <p style="margin:0; padding:0 0 10px;"><strong>Hi <?= Html::encode($sellerMap->seller->fullName) ?>,</strong></p>
            <p style="margin:0; padding:0;"><strong>Assign Seller Confirmation</strong></p>
            <p class="confirmation" style="padding-bottom: 0;">Congratulation, you are assign to the agent <?= Html::encode($sellerMap->agent->fullName) ?></p>
        </td>
    </tr>
</tbody>
