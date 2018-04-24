<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\PhotoGallery */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Photo Galleries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="photo-gallery-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'model',
            'model_id',
            'title',
            'description:ntext',
            'image_file_name',
            'image_file_extension',
            'original_file_name',
            'size:size',
            'status',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
