<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\helpers\Url;

global $selectedTeam;
/* @var $this yii\web\View */
/* @var $model common\models\Team */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Teams'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$selectedTeam = $model->id;
?>
<div class="team-view">
<div class="team-index">
<div class="content-wrapper">
    <!-- Content Title Sec -->
    <section class="content-header">
        <h1><?php echo $this->title ?></h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i> Team Management</a></li>
            <li><a href="<?= Url::to(['/team'])?>"><i class="fa fa-users" aria-hidden="true"></i> List</a></li>
            <li class="active"><?= $model->name?></li>
        </ol>
    </section>
    <!-- Content Title Sec -->

    <!-- Main content -->
    <section class="content">
    <div class="manage-profile-sec">
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#team_info" aria-controls="general_info" role="tab" data-toggle="tab">Team Info</a></li>
        <li role="presentation"><a href="#associated_agency" aria-controls="associated_sellers" role="tab" data-toggle="tab">Team Members</a></li>
        <li role="presentation"><a href="#add_team_member" aria-controls="associated_sellers" role="tab" data-toggle="tab">Add Member</a></li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="team_info">
            <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'name',
                        'teamID',
                        'createdBy',
                        'created_at:datetime',
                        'status',
                    ],
                ])
            ?>
        </div>
        <div role="tabpanel" class="tab-pane" id="associated_agency">
            <?php Pjax::begin(['id' => 'agency_pjax_container']); ?>    
            <?= GridView::widget([
                'dataProvider' => $teamMemberDataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    //'id',
                    'commonName',
                    'agentID',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{delete}',
                        'buttons'   => [
                            'delete'    =>  
                            function ($url,$model) {
                                $class = 'fa fa-trash-o';
                                $title = 'Delete';
                                return Html::a(
                                    '<span class="'.$class.'"></span>','#', 
                                    [
                                        'title'         => $title,
                                        'data-pjax'     => '0',
                                        'onclick' => "if (confirm('Are you sure?')) {
                                            $.loading();
                                            $.ajax('".Url::to(['team/delete-member', 'id' => $model->id])."', {
                                                type: 'POST'
                                            }).done(function(data) {
                                                 $.loaded('Successfully deleted');
                                                 $.pjax.reload({container: '#agency_pjax_container', async:false});
                                                 $.pjax.reload({container: '#add_team_member_pjax', async:false});
                                            });
                                        }
                                        return false;",
                                    ]
                                );
                            },
                        ],
                    ],
                ],
            ]);
            ?>
            <?php Pjax::end(); ?>
        </div>
        <div role="tabpanel" class="tab-pane" id="add_team_member">
        <?php Pjax::begin(['id' => 'add_team_member_pjax']); ?>    <?= GridView::widget([
        'dataProvider' => $ourAgentsDataProvider,
        'filterModel' => $ourAgentsSearchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'agentID',
            'first_name',
            'last_name',
            'email:email',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{add-member}',
                'buttons' => [
                    'add-member' => function ($url,$model) {
                        global $selectedTeam;
                        if(!$model->team_id){
                            $class = 'fa fa-plus';
                            $title = 'Add';
                            $conf = 'Are you sure want to add?';
                        }else{
                            $class = 'fa fa-check-circle-o disabled';
                            $title = 'Already Added';
                            $conf = 'Agent already assigned to team, still want to assign?';
                        }
                        return Html::a(
                            '<span class="'.$class.'"></span>',
                            $url, 
                            [
                                'title'         => $title,
                                'data-pjax'     => '0',
                                'onclick' => "if (confirm('".$conf."')) {
                                    $.loading();
                                    $.ajax('".$url."', {
                                        type: 'POST', 
                                        data: {team_id: ". $selectedTeam."}
                                    }).done(function(data) {
                                         $.loaded('Successfully Added');
                                         $.pjax.reload({container: '#add_team_member_pjax', async:false});
                                         $.pjax.reload({container: '#agency_pjax_container', async:false});
                                    });
                                }
                                return false;",
                            ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?>
        </div>
    </div>
    

</div>
    </section>
</div>
</div>
</div>