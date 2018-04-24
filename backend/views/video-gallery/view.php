<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\VideoGallery */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Video Galleries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-gallery-view">


    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            //'model',
            //'model_id',
            'title',
            'description:ntext',
            'video_file_name',
            'video_file_extension',
            'original_file_name',
            'youtube_video_code',
            'status',
//            'created_by',
//            'updated_by',
//            'created_at',
//            'updated_at',
        ],
    ]) ?>

</div>
