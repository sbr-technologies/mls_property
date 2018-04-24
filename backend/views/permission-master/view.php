<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model common\models\PermissionMaster */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Permission Masters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="permission-master-view">
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
            'service_category_ids',
            'name',
            ['attribute' => 'serviceCategories', 
                'format' => 'raw',
                'value' => implode('<br/>------<br/>', ArrayHelper::getColumn($model->serviceCategories, 'name'))
            ],
            'status',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
