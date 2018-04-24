<?php
use yii\helpers\Html;
?>

<div class="agency-registration">
    <p></p><br>
    <strong>Hi Admin</strong>,
    
</div>
<tbody>
    <tr style="background:#f5f5f5;">
        <td style="padding: 15px;">
            <p style="margin:0; padding:0 0 10px;"><strong>Hi Admin,</strong></p>
            <p style="margin:0; padding:0;"><strong>New Agency Registration : Pending Approval</strong></p>
            <p class="confirmation" style="padding-bottom: 0;">The agency has been registered by <?= $user->fullName?></p>
            <p>Name : <?= $agency->name?></p>
            <p>Email: <?= $agency->email?></p>
        </td>
    </tr>
</tbody>
