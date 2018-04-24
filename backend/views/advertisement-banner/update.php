<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AdvertisementBanner */
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">
        Edit Advertisement Banner
    </h4>
</div>
<div class="modal-body">
    <div class="advertisement-banner-update">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>

