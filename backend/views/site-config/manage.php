<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Agency;
use common\models\Agent;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

$this->title = 'Manage Website Settings';
?>
<div class="banner-form">

    <?php $form = ActiveForm::begin(['layout' => 'horizontal', 'options' => ['enctype' => 'multipart/form-data']]); ?>


    <?php
    if ($settings) {
        $i = 0;
        ?>
        <?php foreach ($settings as $row) {
            ?>
            <div class="form-group">
                <label  class="control-label col-sm-3"><?php echo $row->title; ?></label> 
                <input type='hidden' name='settings[<?php echo $i ?>][key]' value='<?php echo $row->key ?>' />
                <div class="col-sm-6">
                    <div class="col-md-10">
                        <?php if ($row->type == 'text') { ?>
                            <input type="text" name="settings[<?php echo $i ?>][value]" class="form-control" value="<?php echo empty($row->value)  ? $row->default : $row->value; ?>" />
                        <?php } elseif ($row->type == 'textarea') { ?>
                            <textarea name="settings[<?php echo $i ?>][value]" cols="40" rows="6"><?php echo $row->value; ?></textarea>
                            <?php
                        } elseif ($row->type == 'select') {
                            $options = explode('|', $row->options);
                            ?>
                            <select name="settings[<?php echo $i ?>][value]" class="form-control">
                                <?php
                                foreach ($options as $option) {
                                    if ($option == $row->value)
                                        echo '<option selected>' . $option . '</option>';
                                    else
                                        echo '<option>' . $option . '</option>';
                                }
                                ?>
                            </select>
                        <?php } elseif ($row->type == 'multi') {
                            $options = explode('|', $row->options);
                            ?>
                            <select multiple name="settings[<?php echo $i ?>][value][]" class="form-control">
                                <?php
                                $valuesArray = explode("|" , $row->value);
                                foreach ($options as $option) {
                                    if (in_array($option, $valuesArray))
                                        echo '<option selected>' . $option . '</option>';
                                    else
                                        echo '<option>' . $option . '</option>';
                                }
                                ?>
                            </select>
                        <?php }elseif($row->type == 'Agency'){ ?>
                            <?php // echo Html::dropDownList("settings[$i][value]", $row->value, ArrayHelper::map(Agency::find()->active()->all(), 'id', 'name'), ['prompt' => 'Select Agency', 'id' => 'sel_config_agency'])?>
                            <?php 
                                $agencyId = $row->value;
                                echo Select2::widget([
                                'name' => "settings[$i][value]",
                                'value' => $row->value,
                                    'data' => ArrayHelper::map(Agency::find()->active()->all(), 'id', 'name'),
                                    'options' => ['placeholder' => 'Select a Agency ...', 'id' => 'sel_config_agency'],
                                    'pluginOptions' => [
                                        'allowClear' => false
                                    ],
                                ]);
                                ?>
                            <?php }elseif($row->type == 'Agent'){ ?>

                            <?php echo DepDrop::widget([
                                'name' => "settings[$i][value]",
                                'data' => ArrayHelper::map(Agent::find()->where(['agency_id' => $agencyId])->active()->all(), 'id', 'fullName'),
                                'value' => $row->value,
                                'options' => ['id'=>'sel_config_agent'],
                                'type'=>DepDrop::TYPE_SELECT2,
                                'pluginOptions'=>[
                                    'depends'=>['sel_config_agency'],
                                    'placeholder' => 'Select...',
                                    'url' => Url::to(['/agent/index-json'])
                                ]
                            ]); ?>
                        <?php }?>
                            
                            &nbsp;&nbsp;
                    </div>
                    <div class="col-md-2">
                        <?php if ($row->unit) echo ucfirst($row->unit) ?>
                    </div>
                    <?php if(!empty($row->tip)) : ?>
                    <a href="#" data-toggle="tooltip" data-trigger="click"  data-placement="right" data-html="true" data-title="<?= $row->tip?>"><i class="fa fa-question-circle"></i></a>
                    <?php endif;?>
                </div>
            </div>
            <?php
            $i++;
        }
    }
    ?>


    <div class="form-group">
        <div class="col-sm-8 col-md-6 col-sm-push-4 col-md-push-3"> <?= Html::submitButton("Save", ['class' => 'btn btn-primary']) ?></div>
    </div>

    <?php ActiveForm::end(); ?>

</div>