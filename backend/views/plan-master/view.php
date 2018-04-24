<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\editable\Editable;
use common\models\PermissionMaster;
use common\models\PlanPermission;
/* @var $this yii\web\View */
/* @var $model common\models\PlanMaster */

$url = ['index'];
if($model->for_agency){
    $url = ['agency'];
}

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Plan Masters'), 'url' => $url];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plan-master-view">


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
    
<div>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
      <li role="presentation" class="active"><a href="#plan" aria-controls="plan" role="tab" data-toggle="tab">Plan</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="plan">
            <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                //'id',
                'serviceCategory.name',
                'title',
                'description:ntext',
                'status',
                'amount:currency',
                'amount_for_3_months:currency',
                'amount_for_6_months:currency',
                'amount_for_12_months:currency',
                ['attribute' => 'number_of_standard_listing', 'value' => $model->number_of_standard_listing === null? 'Unlimited':$model->number_of_standard_listing],
                ['attribute' => 'number_of_premium_listing', 'value' => $model->number_of_premium_listing === null? 'Unlimited':$model->number_of_premium_listing],
                'created_at:datetime',
                'updated_at:datetime',
            ],
            ]) ?>
        </div>
    </div>
</div>

</div>
