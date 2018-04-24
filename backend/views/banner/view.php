<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Banner */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Banners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-view">


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
            ['attribute' => 'type.title', 'label' => 'Banner Type'],
            ['attribute' => 'property.title', 'label' => 'Property Name'],
            'title',
            'description',
            'text_color',
            'sort_order',
            'status',
//            'created_by',
//            'updated_by',
//            'created_at:datetime',
//            'updated_at:datetime',
        ],
    ]) ?>

    <?php
        echo $this->render('//shared/_photo-gallery', ['model' => $model, 'single' => true]);
    ?>
    
</div>
