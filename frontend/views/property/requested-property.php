<?php
use yii\helpers\Html;
use kartik\grid\GridView;


$this->title = 'Request for Property';
?>
<div class="content-wrapper">
    <!-- Content Title Sec -->
    <section class="content-header">
        <h1><?php echo $this->title ?></h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i><?= $this->title?></a></li>
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
//                [
//                    'attribute'=>'user_id',
//                    'label'=>'User',
//                    'value'=>function ($model, $key, $index, $widget) {
//                        return $model->user->fullName;
//                    },
//                    'format'=>'raw'
//                ],
                'property_category',
                [
                    'attribute'=>'property_type_id',
                    'label'=>'Property Type',
                    'value'=>function ($model, $key, $index, $widget) {
                        return $model->propertyType->title;
                    },
                    'format'=>'raw'
                ],
                'budget_from',
                'budget_to',
                // 'no_of_bed_room',
                // 'state',
                // 'locality',
                'schedule:date',
                [
                    'attribute' => 'status',
                    'contentOptions' => ['class' => 'text-capitalize'],
                ],
                // 'created_at',
                // 'updated_at',

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => ' {request-feedback-view} ',
                    'buttons' => [
                        'request-feedback-view' => function ($url,$model) {
                            $class = 'fa fa-eye';
                            $title = 'Approve';
                            return Html::a(
                                '<span class="'.$class.'"></span>',
                                $url, 
                                [
                                    'title' => $title,
                                    'data-pjax' => '0',
                                ]
                            );
                        },
                        
                    ],
                ],
                        
            ];


            echo GridView::widget([
                'filterModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'columns' => $gridColumns,
                'pjax' => true,
                'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']],
                'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-home"></i> '.$this->title.'</h3>',
                ],
            ]);
          ?>
        </div>
    </section>
    <!-- Main content -->
</div>