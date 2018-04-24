<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\EmailTemplates;
use yii\bootstrap\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel common\models\EmailSubscribersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Email Subscribers');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Newsletter Templates'), 'url' => ['templates']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="email-subscribers-index">
    <?php ActiveForm::begin()?>
    <div class="form-group">
        <div class="pull-right">  <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => 'btn btn-primary']) ?>
        </div>
        <div class="clear"></div>
    </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],
            'fullName',
            'email:email',
             'total_mail_sent',
             'last_mail_sent_at:datetime',
            // 'created_by',
            // 'updated_by',
             'created_at:datetime',
            // 'updated_at',
        ],
        'layout' => "{items}\n{pager}"
    ]); ?>
        <div class="form-group">
            <div class="col-sm-8 col-md-6 col-sm-push-4 col-md-push-3">  <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => 'btn btn-primary']) ?>
            </div>
            <div class="clear"></div>
        </div>
    <?php ActiveForm::end()?>
</div>
