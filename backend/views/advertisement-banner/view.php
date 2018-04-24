<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\AdvertisementBanner */
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">View Advertisement Banner</h4>
</div>
<div class="modal-body">
    <div class="advertisement-banner-view"> 
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                //'id',
                ['attribute' =>'ad.title','label' => 'Advertisement'],
                'title',
                'description:ntext',
    //            'image_file_name',
    //            'image_file_extension',
                'text_color',
                'sort_order',
                'status',
            ],
        ]) ?>
        <?php
            echo $this->render('//shared/_photo-gallery', ['model' => $model, 'single' => true]);
        ?>
    </div>
</div>

