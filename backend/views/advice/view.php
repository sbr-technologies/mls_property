<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Advice */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Advices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advice-view">
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
            'adviceCategory.name',
            'title',
            'content:ntext',
            'slug',
            'status',
//            'created_by',
//            'updated_by',
//            'created_at',
//            'updated_at',
        ],
    ]) ?>
    
    <?php
        echo $this->render('//shared/_photo-gallery', ['model' => $model, 'single' => true]);
    ?>

</div>
