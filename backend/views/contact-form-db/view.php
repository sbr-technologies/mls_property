<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ContactFormDb */

$this->title = $model->full_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contact Form Dbs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact-form-db-view">


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
            'salutation',
            'full_name',
            'email:email',
            'subject',
            'message:ntext',
            'statusText',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
