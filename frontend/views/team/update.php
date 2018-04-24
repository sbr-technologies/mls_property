<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Team */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Team',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Teams'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="team-update">
<div class="team-index">
<div class="content-wrapper">
    <!-- Content Title Sec -->
    <section class="content-header">
        <h1><?php echo $this->title ?></h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i> Team Management</a></li>
            <li class="active">Add</li>
        </ol>
    </section>
    <!-- Content Title Sec -->

    <!-- Main content -->
    <section class="content">
        <div class="manage-profile-sec">
    <?= $this->render('_form', [
        'model'                 => $model,
        'agencyDataProvider'    => $agencyDataProvider,
    ]) ?>

</div>
    </section>
</div>
</div>
</div>
