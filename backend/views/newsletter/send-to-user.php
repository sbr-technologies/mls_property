<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\EmailTemplates;
use yii\bootstrap\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel common\models\EmailSubscribersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'System Users');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Newsletter Templates'), 'url' => ['templates']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="email-subscribers-index">
    <?php echo $this->render('_user-search', ['model' => $searchModel, 'id' => $id]); ?>
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
            'first_name',
            'last_name',
            'email:email',
            'Mobile1',
            ['attribute' => 'dob', 'value' => function($model){
                return $model->birthday;
            }]
        ],
        'layout' => "{summary}\n{items}\n{pager}"
    ]); ?>
        <div class="form-group">
            <div class="col-sm-8 col-md-6 col-sm-push-4 col-md-push-3">  <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => 'btn btn-primary']) ?>
            </div>
            <div class="clear"></div>
        </div>
    <?php ActiveForm::end()?>
</div>
