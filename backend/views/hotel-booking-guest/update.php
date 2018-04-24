<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\HotelBookingGuest */

?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">
        Edit Hotel Booking Guest
    </h4>
</div>
<div class="modal-body">
    <div class="hotel-booking-guest-update">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
</div>
