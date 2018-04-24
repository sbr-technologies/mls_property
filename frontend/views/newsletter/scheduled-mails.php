<?php 
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;
use common\models\EmailTemplates;
use dmstr\widgets\Alert;
use yii\helpers\Url;
use kartik\date\DatePicker;
$this->title = 'Scheduled Mails';
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

    <!-- Main content -->
    <section class="content">
        <div class="content-inner-sec">
            <div class="col-sm-12">
                <div class="box box-primary box-solid table-listing">
                    <div class="box-header with-border">
                        <h3 class="box-title">Scheduled Mails</h3>
                    </div>
                    <?= Alert::widget() ?>
                        <div class="box-body table-responsive">
                            <table class="table table-bordered text-center">
                                <tbody>
                                    <tr>
                                        <th>Schedule</th>
                                        <th>Start</th>
                                        <th>End</th>
                                        <th>Action</th>
                                    </tr>
                                    <?php $i = 0;
                                    foreach ($models as $model) { ?>
                                        <tr>
                                            <td><?= $model->schedule ?></td>
                                            <td><?= $model->schedule_start_date ?></td>
                                            <td><?= $model->schedule_end_date ?></td>
                                            <td>
                                                <a href="<?= Url::to(['newsletter/scheduled-mails-update', 'id' => $model->id])?>" class="btn btn-primary btn-sm" title="Update"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                                <a href="<?= Url::to(['newsletter/scheduled-mails-delete', 'id' => $model->id])?>" class="btn btn-primary btn-sm" title="Delete" onclick="return confirm('Are you sure want to delete this schedule?')"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="box-footer clearfix">
                        <?php
                        echo LinkPager::widget([
                            'pagination' => $dataProvider->getPagination(),
                        ]);
                        ?>
                        </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Main content -->
</div>