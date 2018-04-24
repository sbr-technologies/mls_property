<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */
//\yii\helpers\VarDumper::dump($propertyDetails->user->sellerCompany->name);exit;
//\yii\helpers\VarDumper::dump($propertyDetails->propertyTypeIds,4,12); exit;
//\yii\helpers\VarDumper::dump($propertyDetails->user->fullName."++".$propertyDetails->user->profile->title."++".$propertyDetails->referenceId."++".$propertyDetails->formattedAddress); exit;
?>

<tbody>
    <tr style="background:#f5f5f5;">
        <td style="padding: 15px;">
            <p style="margin:0; padding:0 0 10px;"><strong>Hi,</strong></p>
            <p style="margin:0; padding:0;"><strong>New Property Add Information</strong></p>
            <p class="confirmation" style="padding-bottom: 0;">Please see below a message from <strong><?= Html::encode($propertyDetails->user->fullName) ?></strong> regarding a property add as an <?= Html::encode($propertyDetails->user->profile->title) ?>..</p>
            <p></p>
            <?php
            if($propertyDetails->user->profile->title == 'Agent'){
            ?>
                <p>Agency Name :<?=  $propertyDetails->user->agency->name ?></p>
            <?php
            }else if($propertyDetails->user->profile->title == 'Seller'){
                
            ?>
                <p>Seller Company Name : <?=  $propertyDetails->user->sellerCompany->name ?></p>
            <?php
            }
            ?>
            <p>Property Ref.: <?= Html::encode($propertyDetails->referenceId) ?></p>
            <p>Street Address: <?= Html::encode($propertyDetails->formattedAddress) ?></p>
            <p>Property Category: <?= Html::encode($propertyDetails->propertyCategory->title) ?></p>
            
            <p>Listing URL: <?= Html::encode($property_url) ?></p>
            
        </td>
    </tr>
</tbody>

