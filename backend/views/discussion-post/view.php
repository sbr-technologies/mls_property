<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model common\models\DiscussionPost */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Discussion Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="discussion-post-view">
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
           // 'id',
            'user.fullName',
            'category.title',
            'title',
            'content:ntext',
            ['attribute' => 'tags',
                'format' => 'raw',
                'value' => implode(' , ', ArrayHelper::getColumn($model->tags, 'title'))
            ],
            'slug',
            'status',
            'created_by',
            'updated_by',
//            'created_at',
//            'updated_at',
        ],
    ]) ?>

</div>
