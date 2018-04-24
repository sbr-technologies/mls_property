<?php 
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;
use common\models\EmailTemplates;
use dmstr\widgets\Alert;
use yii\helpers\Url;
use kartik\date\DatePicker;
$this->title = 'Scheduled Mail Details';
$models = $dataProvider->getModels();
?>
    <!-- Main content -->
            <div class="col-sm-12">
                <div class="box box-primary box-solid table-listing">
                    <div class="box-header with-border">
                        <h3 class="box-title">Recipients</h3>
                    </div>
                    <?= Alert::widget() ?>
                    <?php ActiveForm::begin(['method' => 'post','action' => ['newsletter/scheduled-update','id'=> $indexModel->id]]) ?>
                        <div class="box-body table-responsive">
                            <table class="table table-bordered text-center">
                                <tbody>
                                    <tr>
                                        <th style="width: 10px"><input name="" type="checkbox" class="chk_controller" checked disabled></th>
                                        <th>Name</th>
                                        <th>Email</th>
                                    </tr>
                                    <?php $i = 0;
                                    foreach ($models as $model) { ?>
                                        <tr>
                                            <td><input name="selection[]" value="<?= $model->id ?>" type="checkbox" checked class="chk_items" disabled></td>
                                            <td><?= $model->recipientName ?></td>
                                            <td><?= $model->recipientEmail ?></td>
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
                            <div class="form-inline">
                            <div class="row">
                            <div class="col-sm-12">
                            <span>Dates</span>
                            <div class="multidate-datepicker">
                            <?php echo DatePicker::widget([
                                    'model' => $indexModel,
                                    'attribute' => 'schedule_dates',
                                    'removeButton' => false,
                                    'options' => ['placeholder' => 'Dates'],
                                    'pluginOptions' => [
                                            'format' => 'dd/mm',
                                            'startDate' => "new Date()",
                                            'multidate' => true
                                    ]
                            ]);?>
                            </div>
                            </div>
                            <div class="col-sm-2">
                            <?= Html::activeDropDownList($indexModel, 'schedule', ['daily' => 'Daily', 'weekly' => 'Weekly', 'monthly' => 'Monthly'], ['prompt' => 'Select Interval'])?>
                            </div>
                            <div class="col-sm-4">
                            <span>Start</span>
                            <?php echo DatePicker::widget([
                                    'model' => $indexModel,
                                    'attribute' => 'scheduleStartDate',
                                    'removeButton' => false,
                                    'options' => ['placeholder' => 'Start date'],
                                    'pluginOptions' => [
                                            'format' => 'dd/mm/yyyy',
                                            'startDate' => "new Date()",
                                            'autoclose' => true
                                    ]
                            ]);?>
                            </div>
                            <div class="col-sm-4">
                            <span>Stop</span>
                            <?php echo DatePicker::widget([
                                    'model' => $indexModel,
                                    'attribute' => 'scheduleEndDate',
                                    'removeButton' => false,
                                    'options' => ['placeholder' => 'End date'],
                                    'pluginOptions' => [
                                            'format' => 'dd/mm/yyyy',
                                            'startDate' => "new Date()",
                                            'autoclose' => true
                                    ]
                            ]);?>
                            </div>
                                <div class="col-sm-2 text-right" style="padding-right: 34px;">
                                <?= Html::activeDropDownList($indexModel, 'status', ['active' => 'Active', 'inactive' => 'Inactive'])?>
                            </div>
                                <div class="col-sm-12 text-center" style="margin-top:15px;">
                            <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-primary']) ?>    
                            </div>
                            </div>
                            </div>
                        </div>
                    <?php ActiveForm::end()?>
                </div>
            </div>
    <!-- Main content -->