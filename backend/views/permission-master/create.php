<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PermissionMaster */

$this->title = Yii::t('app', 'Create Permission Master');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Permission Masters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="permission-master-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
