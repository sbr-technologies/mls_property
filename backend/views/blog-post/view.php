<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\BlogPost */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Blog Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-post-view">

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
            ///'id',
            'user.fullName',
            'title',
            'content:ntext',
            'slug',
            'status',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>
    <?php 
        
        foreach($model->photos as $photo){
           // yii\helpers\VarDumper::dump($photo->id, 4, 1);
            echo "<div style='margin:5px;padding:5px;'><img src='".$photo->imageUrl."' height='150px' width='200px'/></div>"; ?>
            <?=Html::a(Yii::t('app', '<i class="fa fa-trash"></i>'), ['delete-photo', 'id' => $photo->id], [
                'class' => 'btn btn-danger lnk_delete_image',
                'id' => $photo->id,
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]); ?>
   <?php
        }
    ?>
</div>
