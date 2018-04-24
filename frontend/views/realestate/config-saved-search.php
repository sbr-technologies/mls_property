<?php

use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\web\View;
use common\models\SavedSearch;

$this->title = 'Config Saved Search';
$search = json_decode($model->search_string);
$itemHtml = '<ul>';
foreach ($search->filters as $key => $filter) {
    if(!empty($filter)){
        $itemHtml .= '<li><strong>' . SavedSearch::formattedFilter($key) . ':</strong> ' . SavedSearch::RelatedValue($key, $filter) . '</li>';
    }
}

$itemHtml .= '</ul>';
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
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $this->title ?></h3>
                </div>
                <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'name'); ?>
                <?= $form->field($model, 'cc_self')->checkbox()->label('Cc Me')?>
                    <label>Who gets alerts? <span><a href="javascript:void(0)" class="add_more_alert_recipient"><i class="fa fa-plus-circle"></i></a></span></label>
                        <div class="alert_recipient_holder">
                            <?php for ($i = 0; $i<count($model->recipient); $i++){
                                $label = 'Recipients';
                                if($i > 0){
                                    $label = false;
                                }
                            ?>
                            <div class="row item">
                                <div class="col-sm-11">
                                    <?= $form->field($model, "recipient[$i]")->textInput()->label($label)?>
                                </div>
                                <div class="col-sm-1">
                                    <!--<a href="javascript:void(0)" class="remove-recipient"><i class="fa fa-minus-circle"></i></a>-->
                                </div>
                            </div>
                            <?php }?>
                        </div>
                <?= $form->field($model, 'schedule')->dropDownList(['never' => 'Never', 'asap' => 'ASAP', 'daily' => 'Daily', 'weekly' => 'Weekly', 'monthly' => 'Monthly']) ?>
                <?= $form->field($model, 'message')->textarea(); ?>
                
                <div class="form-group">
                    <label>Criteria</label>
                    <div>
                        <?= $itemHtml?>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo Html::submitButton('Submit', ['class' => 'btn btn-primary']); ?>
                </div>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </section>
    <!-- Main content -->
</div>
<?php
$js="$(function(){
        $(document).on('click', '.add_more_alert_recipient', function(){
            var curTime = Date.now();
            $('<div class=\"form-group row item\"><div class=\"col-sm-11\"><input type=\"text\" name=\"SavedSearch[recipient]['+ curTime +']\" class=\"form-control\" /></div><div class=\"col-sm-1\"><a href=\"#\" class=\"remove-recipient\"><i class=\"fa fa-minus-circle\"></i></a></div></div>').appendTo('.alert_recipient_holder');
        });

        $(document).on('click', '.remove-recipient', function(){
            $(this).closest('.item').remove();
            return false;
        });
    });";

$this->registerJs($js, View::POS_END);