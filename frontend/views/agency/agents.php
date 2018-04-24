<?php
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\helpers\Html;
$this->title = 'Our Agents';
?>
<div class="agency-agents-list">
<div class="team-index">
<div class="content-wrapper">
    <!-- Content Title Sec -->
    <section class="content-header">
        <h1><?php echo $this->title ?></h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i> Agent Management</a></li>
            <li><i class="fa fa-users" aria-hidden="true"></i> List</li>
        </ol>
    </section>
    <!-- Content Title Sec -->

    <!-- Main content -->
    <section class="content">
        <div class="manage-profile-sec">
            
        <?php Pjax::begin(['id' => 'agency_agent_list_pjax']); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'agentID',
            'first_name',
            'last_name',
            'email:email',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function($url,$model){
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', str_replace('view', 'view-agent', $url));
                    }
                ]
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?>
            
        </div>
    </section>
</div>
</div>
</div>