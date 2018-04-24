<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\PropertyRequest */

$this->title = $model->user->fullName;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Property Requests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="property-request-view">

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
            'user.fullname',
            'property_category',
            ['attribute' => 'propertyType.title', 'label' => 'Property Type'],
            'budget_from',
            'budget_to',
            'no_of_bed_room',
            'state',
            ['attribute' => 'locality', 'label' => 'Town'],
            'area',
            'comment:ntext',
            ['attribute' => 'user.profile.title', 'label' => 'Requested By'],
            'user.email',
            'user.mobile1',
            'schedule:date',
            'status',
            'created_at:date',
//            'updated_at:datetime',
        ],
    ]) ?>

</div>
