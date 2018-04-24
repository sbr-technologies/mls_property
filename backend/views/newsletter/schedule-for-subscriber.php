<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\EmailTemplates;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel common\models\EmailSubscribersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Subscribers');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Newsletter Templates'), 'url' => ['templates']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="email-subscribers-index">
    <?php echo $this->render('_subscriber_search', ['model' => $searchModel, 'id' => $id]); ?>
    <?php ActiveForm::begin()?>
<!--    <div class="form-group">
        <div class="pull-right">  <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => 'btn btn-primary']) ?>
        </div>
        <div class="clear"></div>
    </div>-->
    <div class="form-inline form-group">
        <div class="row">
            <div class="col-sm-12">
                <span>Dates</span>
                <div class="multidate-datepicker">
                    <?php
                    echo DatePicker::widget([
                        'model' => $indexModel,
                        'attribute' => 'schedule_dates',
                        'removeButton' => false,
                        'options' => ['placeholder' => 'Dates'],
                        'pluginOptions' => [
                            'format' => 'dd/mm',
                            'startDate' => "new Date()",
                            'multidate' => true
                        ]
                    ]);
                    ?>
                </div>
            </div>
            <div class="col-sm-2">
            <?= Html::activeDropDownList($indexModel, 'schedule', ['daily' => 'Daily', 'weekly' => 'Weekly', 'monthly' => 'Monthly'], ['class' => 'form-control', 'prompt' => 'Select Interval']) ?>
            </div>
            <div class="col-sm-4">
                <span>Start</span>
                <?php
                echo DatePicker::widget([
                    'model' => $indexModel,
                    'attribute' => 'scheduleStartDate',
                    'removeButton' => false,
                    'options' => ['placeholder' => 'Start date'],
                    'pluginOptions' => [
                        'format' => 'dd/mm/yyyy',
                        'startDate' => "new Date()",
                        'autoclose' => true
                    ]
                ]);
                ?>
            </div>
            <div class="col-sm-4">
                <span>Stop</span>
                <?php
                echo DatePicker::widget([
                    'model' => $indexModel,
                    'attribute' => 'scheduleEndDate',
                    'removeButton' => false,
                    'options' => ['placeholder' => 'End date'],
                    'pluginOptions' => [
                        'format' => 'dd/mm/yyyy',
                        'startDate' => "new Date()",
                        'autoclose' => true
                    ]
                ]);
                ?>
            </div>
            <div class="col-sm-2">
            <?= Html::submitButton(Yii::t('app', 'Schedule'), ['class' => 'btn btn-primary pull-right']) ?>    
            </div>
        </div>
    </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],
            'first_name',
            'last_name',
            'email:email',
        ],
        'layout' => "{summary}\n{items}\n{pager}"
    ]); ?>
    <?php ActiveForm::end()?>
</div>
