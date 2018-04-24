<?php
use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;


$this->title = 'My Advertisements';
?>
<div class="content-wrapper">
    <!-- Content Title Sec -->
    <section class="content-header">
        <h1><?php echo $this->title ?></h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i> Ad Management</a></li>
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
                'title',
                'description',
                    [
                        'class' => '\kartik\grid\ActionColumn',
                            'buttons'=>[
                            'view' => function ($url, $model) {     
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['/advertisement/view','id' => $model->id], [
                                    'title' => Yii::t('yii', 'delete'),
                            ]); 
                                
                          }
                        ],
                        'deleteOptions' => ['label' => '<i class="glyphicon glyphicon-remove"></i>']
                    ],
                    
                        
            ];


            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => $gridColumns,
                'pjax' => true,
                'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']],
                'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-home"></i> Advertisement</h3>',
                ],
            ]);
          ?>
        </div>
    </section>
    <!-- Main content -->
</div>