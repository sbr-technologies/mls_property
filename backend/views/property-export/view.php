<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Property */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Properties'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="property-view">

    <h1><?= Html::encode($this->title) ?></h1>

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
            'id',
            'user_id',
            'title',
            'description:ntext',
            'country',
            'state',
            'city',
            'address1',
            'address2',
            'lat',
            'lng',
            'zip_code',
            'near_buy_location',
            'metric_type_id',
            'size',
            'no_of_room',
            'no_of_balcony',
            'no_of_bathroom',
            'lift',
            'furnished',
            'water_availability',
            'status_of_electricity',
            'currency',
            'price',
            'property_video_link',
            'property_type_id',
            'property_category_id',
            'construction_status_id',
            'watermark_image',
            'status',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
