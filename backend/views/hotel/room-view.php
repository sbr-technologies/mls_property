<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $roomModel common\models\Hotel */

//yii\helpers\VarDumper::dump($roomModel,4,12); exit;
$this->title = $roomModel->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Hotel'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Hotel Room'), 'url' => ['room-list','id' => $hotel_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hotel-room-view">
    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['room-update', 'id' => $roomModel->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['room-delete', 'id' => $roomModel->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div>
        <div role="tabpanel" class="tab-pane active" id="hotel_info">
            <?= DetailView::widget([
                'model' => $roomModel,
                'attributes' => [
                            'hotel.name',
                            'roomType.name',
                            'name',
                            'floor_name',
                            'inclusion',
                            'amenities',
                            'isAc',
                            'status',
                ],
            ]) ?>
        </div>
    </div>
</div>
