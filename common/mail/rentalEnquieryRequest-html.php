<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */
//\yii\helpers\VarDumper::dump($propertyEnquiry,4,12); exit;
?>

<tbody>
    <tr style="background:#f5f5f5;">
        <td style="padding: 15px;">
            <p style="margin:0; padding:0 0 10px;"><strong>Hi ,</strong></p>
            <p style="margin:0; padding:0;"><strong>Property Enquiry Information</strong></p>
            <p class="confirmation" style="padding-bottom: 0;">Please see below a message from <strong><?= Html::encode($propertyEnquiry->name) ?></strong> regarding a property for which you are listed as an agent.</p>
            <p>Property Ref.: <?= Html::encode($propertyEnquiry->rental->referenceId ? $propertyEnquiry->rental->referenceId : "") ?></p>
            <p>Street Address: <?= Html::encode($propertyEnquiry->rental->formattedAddress) ?></p>
            <p>Listing: <?= Html::encode($property_url) ?></p>
            <p>Name : <?= Html::encode($propertyEnquiry->name) ?> <br>
            Email : <?= Html::encode($propertyEnquiry->email) ?> <br>
            Phone : <?= Html::encode($propertyEnquiry->phone) ?> <br>
            Comments : Hello <?= Html::encode($propertyEnquiry->message) ?> | Property #<?= Html::encode($propertyEnquiry->rental->referenceId ? $propertyEnquiry->rental->referenceId : "") ?> on <?= Html::encode($property_url) ?></p>
        </td>
    </tr>
</tbody>
        
