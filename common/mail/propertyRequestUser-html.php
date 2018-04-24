<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>

<tbody>
    <tr style="background:#f5f5f5;">
        <td style="padding: 15px;">
            <p style="margin:0; padding:0 0 10px;">
                <strong>
                <?php
                if(!empty($propertyRequest->user->emailAddress)){
                ?>
                    <strong>Hi <?= $propertyRequest->user->FullName ?></strong>
                <?php
                } ?>
                </strong>,
            </p>
            
            <p>
                Thank you for submitting your Request for Property. Your request is being processed  
                and you will be notified of our decision as soon as possible. 
            </p>
            
            
        </td>
    </tr>
</tbody>
    


        
