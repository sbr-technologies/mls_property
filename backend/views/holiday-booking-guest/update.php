<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\HolidayBookingGuest */

?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">
        Edit Holiday Booking Guest
    </h4>
</div>
<div class="modal-body">
    <div class="holiday-booking-guest-update">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
</div>

