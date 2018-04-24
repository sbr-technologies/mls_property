<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = Yii::t('app', 'Create Hotel Owner');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Hotel Owner'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
