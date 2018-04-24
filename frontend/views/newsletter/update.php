<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use dosamigos\tinymce\TinyMce;
use yii\web\View;
use yii\helpers\ArrayHelper;
use common\models\NewsletterTemplateVarMaster;

?>

<!-- Start right Section ==================================================-->
<div class="content-wrapper">
    <!-- Content Title Sec -->
    <section class="content-header">
        <h1>Create Email Template</h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
            <li class="active">Create Email Template</li>
        </ol>
    </section>
    <!-- Content Title Sec -->

    <!-- Main content -->
    <section class="content">
        <div class="content-inner-sec">
            <div class="col-sm-12">
                <div class="box box-primary box-solid table-listing">
                    <div class="box-header with-border">
                        <h3 class="box-title">Create Email Template</h3>
                    </div>
                    <?php $form = ActiveForm::begin(); ?>
                        <div class="box-body">
                            <div class="form-group">
                                <?= $form->field($model, 'title')->textInput(['maxlength' => true,'class' => 'form-control']) ?>
                            </div>

                            <div class="form-group">
                                <?= $form->field($model, 'subject')->textInput(['maxlength' => true,'class' => 'form-control']) ?>
                            </div>

                            <div class="form-group">
                                <?=
                                    $form->field($model, 'content')->widget(TinyMce::className(), [
                                        'clientOptions' => [
                                            'plugins' => [
                                                "advlist autolink lists link charmap print preview anchor",
                                                "searchreplace visualblocks code fullscreen",
                                                "insertdatetime media table contextmenu paste"
                                            ],
                                            'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | languages",
                                        ],
                                        'options' => ['rows' => 12],
                                    ]);
                                ?>
                            </div>

                            <div class="form-group">
                                <?= $form->field($model, 'status')->dropDownList([$model::STATUS_ACTIVE => 'Active', $model::STATUS_INACTIVE => 'Inactive'],['prompt' => 'Select Status']) ?>
                            </div>
                        </div>

                        <div class="box-footer clearfix">
                            <div class="form-group">
                                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-default btn-lg red-btn' : 'btn btn-default btn-lg red-btn']) ?>
                            </div>
                        </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </section>
    <!-- Main content -->
</div>
<!-- End right Section ==================================================-->