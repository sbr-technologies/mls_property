<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\StaticPage */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Static Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="static-page-view">


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
            
            'name',
            'content:ntext',
            'slug',
            'meta_title',
            'meta_keywords:ntext',
            'meta_description:ntext',
            'status',
            'created_at:datetime',
            'updated_at:datetime',
            
        ],
    ]) ?>
    
    <?php 
    
        echo $this->render('//shared/_photo-gallery', ['model' => $model]);
    
    ?>
    
</div>
