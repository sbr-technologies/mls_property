<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Agent */

$this->title = Yii::t('app', 'Create Agent');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Agents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agent-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
