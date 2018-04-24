<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ContactAgent */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contact Agents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact-agent-view">



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
            'user.fullName',
            'property.title',
            'name',
            'email:email',
            'phone',
            'message:ntext',
            'status',
            
        ],
    ]) ?>

</div>
