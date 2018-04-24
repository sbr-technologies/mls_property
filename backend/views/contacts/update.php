<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Contact */
$this->title = Yii::t('app', 'Update Contact of ', [
    'modelClass' => 'User',
]) ."  ". $model->user->fullName;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contacts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->fullName, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="user-update">

                <?=
                $this->render('_form', [
                    'model' => $model,
                ])
                ?>
</div>