<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\JobApplication */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Job Applications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-application-view">


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
            'id',
            'first_name',
            'middle_name',
            'last_name',
            'email:email',
            'calling_code',
            'mobile1',
            'gender',
            'dob',
            'zip_code',
            'ip_address',
            'status',
            'created_by',
            'updated_by',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>
    <?php 
    
        echo $this->render('//shared/_photo-gallery', ['model' => $model]);
    
    ?>

</div>
