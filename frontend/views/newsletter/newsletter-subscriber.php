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
                    <?php ActiveForm::begin(['method' => 'post']) ?>
                        <div class="box-body table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th style="width: 10px">Sl.</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        
                                    </tr>
                                    <?php $i = 1;
                                    foreach ($emailSubscriber as $email) {
                                      
                                    ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td><?= $email->fullName ?></td>
                                            <td><?= $email->email ?></td>
                                        </tr>
                                    <?php 
                                    $i++;
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php ActiveForm::end()?>
                </div>
            </div>
        </div>
    </section>
    <!-- Main content -->
</div>