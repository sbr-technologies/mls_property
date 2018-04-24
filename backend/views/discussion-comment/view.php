<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model common\models\DiscussionComment */

$this->title = $model->post->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Discussion Comments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="discussion-comment-view">
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
            'user.fullName',
            'post.title',
            'content:ntext',
            ['attribute' => 'tags',
                'format' => 'raw',
                'value' => implode(' , ', ArrayHelper::getColumn($model->tags, 'title'))
            ],
            'status',
            'created_by',
            'updated_by',
//            'created_at',
//            'updated_at',
        ],
    ]) ?>

</div>
