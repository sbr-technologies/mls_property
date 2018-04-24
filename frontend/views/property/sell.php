<?php
use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use frontend\helpers\AuthHelper;

$this->title = 'Sale Property List';
?>
<div class="content-wrapper">
    <!-- Content Title Sec -->
    <section class="content-header">
        <h1><?php echo $this->title ?></h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i> Property Management</a></li>
            <li class="active">Sale Property List</li>
        </ol>
    </section>
    <!-- Content Title Sec -->

    <!-- Main content -->
    <section class="content">
        <div class="manage-profile-sec">
          <?php
            $gridColumns = [
                ['class' => 'kartik\grid\SerialColumn'],
                'reference_id',
                ['attribute' => 'formattedAddress',
                    'headerOptions' => ['style' => 'width:30%'],   
                    'label' => 'Property_Address/Location'
                ],
                ['attribute' => 'propertyTypeId', 'label' => 'Property_Type',
                    'format' => 'raw',
                    'value' => function($model){
                        return implode(', ', ArrayHelper::getColumn(common\models\PropertyType::find()->where(['id' => $model->propertyTypeId])->all(), 'title')) ;
                    }
                ],
                ['attribute' => 'constructionStatusId',
                    'format' => 'raw',
                    'value' => function($model){
                        return implode(', ', ArrayHelper::getColumn(common\models\ConstructionStatusMaster::find()->where(['id' => $model->constructionStatusId])->all(), 'title')) ;
                    },
                    'headerOptions' => ['style' => 'width:20%'],   
                ],
                'price:currency',
                'listed_date:date',
                'expired_date:date',
                'daysExpiring',
                'market_status',
                [
                    'class' => '\kartik\grid\ActionColumn',
                        'template' => '{duplicate} {view} {update} {delete} {renew}',
                        'buttons'=>[
                            'view' => function ($url, $model) {     
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['/property/details','id' => $model->id], ['title' => Yii::t('yii', 'View')]); 
                            },
                            'duplicate' => function ($url, $model) {     
                                return Html::a('<span class="glyphicon glyphicon-duplicate"></span>', ['/property/duplicate','id' => $model->id], ['title' => Yii::t('yii', 'Duplicate')]); 
                            },
                            'renew' => function ($url, $model) {
                                if ($model->daysExpiring > 30) {
                                    return false;
                                }
                                return Html::a('<span class="glyphicon glyphicon-refresh"></span>', ['/property/renew', 'id' => $model->id, 'cat' => 'sell'], ['title' => Yii::t('yii', 'Renew')]);
                            }
                        ],
                        'deleteOptions' => ['label' => '<i class="glyphicon glyphicon-remove"></i>'],
                        'noWrap' => true
                ],
            ];

            if(AuthHelper::is('agency')){
                array_splice($gridColumns, 2, 0, [['attribute' => 'agentID', 'label' => 'Agent ID']]);
            }

            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => $gridColumns,
                'pjax' => true,
                'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']],
                'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-home"></i> Sale Property List</h3>',
                ],
            ]);
          ?>
        </div>
    </section>
    <!-- Main content -->
</div>