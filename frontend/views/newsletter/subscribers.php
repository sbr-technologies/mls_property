<?php 
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;
use common\models\EmailTemplates;
use dmstr\widgets\Alert;
use yii\helpers\Url;
$this->title = 'Subscriber List';
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

    <!-- Main content -->
    <section class="content">
        <div class="content-inner-sec">
            <div class="col-sm-12">
                <div class="box box-primary box-solid table-listing">
                    <div class="box-header with-border">
                        <h3 class="box-title">Subscriber List</h3>
                    </div>
                    <?= Alert::widget() ?>
                    <?php ActiveForm::begin(['method' => 'post','action' => ['newsletter/send','id'=> $template_id]]) ?>
                        <div class="box-body table-responsive">
                            <table class="table table-bordered text-center">
                                <tbody>
                                    <tr>
                                        <th style="width: 10px"><input name="" type="checkbox" class="chk_controller"></th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Total Mail Sent</th>
                                        <th>Last Mail Sent At</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                    <?php $i = 0;
                                    foreach ($models as $model) { ?>
                                        <tr>
                                            <td><input name="selection[]" value="<?= $model->id ?>" type="checkbox" class="chk_items"></td>
                                            <td><?= $model->fullName ?></td>
                                            <td><?= $model->email ?></td>
                                            <td><?= $model->total_mail_sent ?></td>
                                            <td class="redTxt"><?= $model->lastMailSentAt ?></td>
                                            <td><?= $model->createdAt ?></td>
                                            <td><a href="<?= Url::to(['newsletter/send','id'=> $template_id,'subscriber_id' => $model->id]) ?>" class="btn btn-primary btn-sm">Send</a></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="box-footer clearfix">
                            <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => 'btn btn-primary pull-left']) ?>
                            <?php
                            echo LinkPager::widget([
                                'pagination' => $pages,
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