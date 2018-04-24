<?php

use yii\helpers\Html;
use common\models\Property;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\export\ExportMenu;

$this->title    =   'Transaction List of - '. Yii::$app->name;
$transactions   =   $dataProvider->getModels();
//yii\helpers\VarDumper::dump($transactions,4,12);
?>

<div class="content-wrapper">
    <!-- Content Title Sec -->
    <section class="content-header">
        <h1><?php echo $this->title ?></h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i> Transaction Management</a></li>
            <li class="active">List</li>
        </ol>
    </section>
    <!-- Content Title Sec -->

    <!-- Main content -->
    <section class="content">
        <div class="manage-profile-sec">
          <?php
            $gridColumns = [
                ['class' => 'kartik\grid\SerialColumn'],
                //'title',
                'receiverid',
                'transactionid',
                ['attribute' => 'amt', 'value' => function($model){
                    return $model->currencycode. ' '. $model->amt;
                }],
                'paymenttype',
                'paymentstatus',
                'status'
            ];
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => $gridColumns,
                'pjax' => true,
                'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']],
                'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-home"></i> Transaction</h3>',
                ],
            ]);
          ?>
        </div>
    </section>
    <!-- Main content -->
</div>