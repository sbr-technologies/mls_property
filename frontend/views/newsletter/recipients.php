<?php 
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;
use common\models\EmailTemplates;
use dmstr\widgets\Alert;
use yii\helpers\Url;
use yii\grid\GridView;

$this->title = 'Contact List';
$models = $dataProvider->getModels();
?>
<div class="content-wrapper">
    <!-- Content Title Sec -->
    <section class="content-header">
        <h1><?= $this->title ?></h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
            <li class="active"><?= $this->title ?></li>
        </ol>
    </section>
    <!-- Content Title Sec -->
    <div class="content-inner-sec">
        <div class="col-sm-12">
<!-- Content Title Sec -->
<?php echo $this->render('_contact-search', ['model' => $searchModel, 'id' => $template_id]); ?>
        </div>
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="content-inner-sec">
            <div class="col-sm-12">
                <div class="box box-primary box-solid table-listing">
                    <div class="box-header with-border">
                        <h3 class="box-title">Contacts</h3>
                    </div>
                    <?= Alert::widget() ?>
                    <?php ActiveForm::begin(['method' => 'post','action' => ['newsletter/send','id'=> $template_id]]) ?>
                        <div class="box-body table-responsive">
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
                        </div>
                        <div class="box-footer clearfix">
                            <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => 'btn btn-primary pull-left']) ?>
                            <?php
                            echo LinkPager::widget([
                                'pagination' => $dataProvider->getPagination(),
                            ]);
                            ?>
                        </div>
                    <?php ActiveForm::end()?>
                </div>
            </div>
        </div>
    </section>
    <!-- Main content -->
</div>