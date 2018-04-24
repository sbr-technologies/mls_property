<?php
use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;


$this->title = 'Contact';
?>
<div class="content-wrapper">
    <!-- Content Title Sec -->
    <section class="content-header">
        <h1><?php echo $this->title ?></h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i> Property Management</a></li>
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
                'property.title',
                'user.fullName',
                'name',
                'email',
                'phone',
                'message', 
                'status',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => ' {status}',
                    'buttons' => [
                        'status' => function ($url,$model) {
                            if($model->status == $model::STATUS_ACTIVE){
                                $class = 'fa fa-thumbs-down';
                                $title = 'Inactive';
                            }else{
                                $class = 'fa fa-thumbs-up';
                                $title = 'Active';
                            }
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
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => $gridColumns,
                'pjax' => true,
                'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']],
                'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-home"></i> Contact Agent</h3>',
                ],
            ]);
          ?>
        </div>
    </section>
    <!-- Main content -->
</div>