<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\web\View;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\EmailList */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Subscriber Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="email-list-view">

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
            'title',
            'description:ntext',
            'status',
        ],
    ]) ?>

</div>

<div>
    <div class="row" id="emailAssignmentWraper">
        <div class="col-lg-5">
            <?= Yii::t('app', 'Avaliable') ?>:
            <select id="list_avaliable" multiple size="20" style="width: 100%">
                <?php foreach ($available as $email){?>
                <?php echo '<option value="'.$email->id.'">'. $email->email.'</option>';?>
                <?php }?>
            </select>
        </div>
        <div class="col-lg-1">
            <br><br>
            <a href="#" id="btn_add_email" class="btn btn-success">&gt;&gt;</a><br>
            <a href="#" id="btn_remove_email" class="btn btn-danger">&lt;&lt;</a>
        </div>
        <div class="col-lg-5">
            <?= Yii::t('app', 'Assigned') ?>:
            <select id="list_assigned" multiple size="20" style="width: 100%">
                <?php foreach ($assigned as $email){?>
                <?php echo '<option value="'.$email->subscriber->id.'">'. $email->subscriber->email.'</option>';?>
                <?php }?>
            </select>
        </div>
    </div>
</div>

<?php
$localJs = 'var assignUrl = "' . urldecode(Url::to(['newsletter-email-list/assign', 'id' => $model->id])) . '";'
        . 'var unAssignUrl = "' . urldecode(Url::to(['newsletter-email-list/unassign', 'id' => $model->id])) . '";';
$this->registerJs($localJs, View::POS_HEAD);