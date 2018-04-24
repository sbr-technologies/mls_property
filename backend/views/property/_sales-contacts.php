<?php

use yii\helpers\Html;
use kartik\typeahead\Typeahead;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\web\View;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;

$form = ActiveForm::begin(['options' => ['class' => '']]);
?>

<div class="box-group contact_accordion_sec" id="contact_accordion">
<?php
$index = 1;
//\yii\helpers\VarDumper::dump($contactArr,12,1); exit;
    for ($i = 0; $i < 6; $i++) {
        if (isset($allModels[$i])) {
            $model = $allModels[$i];
        } else {
            $model = $newModel;
        }
        ?>
            <div class="panel box box-danger box-solid panel_item">
                <div class="box-header with-border">
                    <h4 class="box-title">
                        <a data-toggle="collapse" data-parent="#contact_accordion" href="#collapse_<?= $i ?>">
                            Property Contact #<?= $index ?>
                        </a>
                    </h4>
                </div>
                <div id="collapse_<?= $i ?>" class="panel-collapse collapse <?php if ($i == 0) echo 'in' ?>">
                    <div class="box-body">
                        <div class="item new add-form-popup">
                            <input type="hidden" class="txt_item_index" value="<?= $i?>" />
                            <input type="hidden" class="txt_buyer_agent_selected" value="no" />
                            <input type="hidden" name="property_contact[<?= $i?>][agent_id]" class="txt_agent_id" value="<?php echo $model->agentID?>" />
                            <?= Html::activeHiddenInput($model, "[$i]id")?>
                            <div class="form-group col-sm-12">
                                <div class="row">
                                    <div class="row">
                                        <div class="col-sm-6 dynamic_sm">
                                        <?= $form->field($model, "[$i]type")->dropDownList(['Seller' => 'Seller', 'Buyer' => 'Buyer', 'Bank' => 'Bank', 'Buyer Agent' => 'Buyer Agent', 'Buyer Attorney' => 'Buyer Attorney', 'Seller Attorney' => 'Seller Attorney'], ['prompt' => 'Select', 'class' => 'form-control sel_contact_type', 'disabled' => !$model->isNewRecord]) ?>
                                        </div>
                                        <div style="display:none; position: absolute; left: 49%; top: 33px;"><a href="javascript:void(0)" class="refresh_page"><i class="fa fa-recycle"></i></a></div>
                                        <div class="col-sm-6 search_agent dynamic_sm">
                                            <label>Search Agent</label>
                                            <?php
                                            // Defines a custom template with a <code>Handlebars</code> compiler for rendering suggestions
                                            //echo '<label class="control-label">Select Agency</label>';
                                            $template = '<div><p class="repo-language">{{language}}</p>' .
                                                    '<p class="repo-name">{{value}}</p>' .
                                                    '<p class="repo-description">{{email}}</p></div>';

                                            echo Typeahead::widget([
                                                'name' => 'twitter_oss',
                                                'options' => ['placeholder' => 'FIlter by Agent Name', 'class' => 'agentFieldCls' . $i],
                                                'dataset' => [
                                                [
                                                    'remote' => [
                                                        'url' => Url::to(['property/agent']) . '&q=%QUERY',
                                                        'wildcard' => '%QUERY'
                                                    ],
                                                    'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                                                    'display' => 'value',
                                                    'templates' => [
                                                        'notFound' => '<div class="text-danger" style="padding:0 8px">Unable to find repositories for selected query.</div>',
                                                        'suggestion' => new JsExpression("Handlebars.compile('{$template}')")
                                                    ]
                                                ]
                                                ],
                                                'pluginEvents' => [
                                                    "typeahead:select" => "function(e, data) {
                                                        var thisField = $(this);
                                                        var thisBlock = thisField.closest('.panel_item');
                                                        $.loading();
                                                        thisBlock.find('.txt_buyer_agent_selected').val('yes');
                                                        thisField.closest('.panel_item').addClass('current').siblings().removeClass('current');
                                                        $('.readonlyCls').prop('disabled',true);
                                                        $.get('" . Url::to(['agent/detail-json']) . "', {user_id:data.id}, function(response){
                                                           $.loaded();
                                                            console.log(response);
                                                            $.each( response.agent_data, function( key, value ) { //allert('txt_'+cnt+'_'+key);
                                                                thisField.closest('.item').find('.txt_'+ key).val(value);
                                                            });
                                                            $.get('" . Url::to(['agent/view-address']) . "', {user_id:data.id, index:$('.txt_item_index').val()}, function(response){
                                                                $('body').find('.panel_item.current').find('.address_fields_holder').html(response);
                                                            });
                                                        }, 'json');
                                                    }"
                                                ]
                                            ]);
                                            ?>
                                        </div>
                                        <?php 
                                        if(!$model->isNewRecord){?>
                                        <div class="col-sm-6 text-right"><a href="#" class="remove_contact" data-contact_id="<?= $model->id?>"><i class="fa fa-trash"></i></a></div>
                                        <?php }?>
                                    </div>
                                    <h5>Personal and Contact Details:</h5>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <?= $form->field($model, "[$i]agentID")->textInput(['maxlength' => true, 'class' => 'form-control txt_agent_id', 'readonly' => true, 'style' => 'display:'.(!$model->isNewRecord && $model->type == 'Buyer Agent'?'block':'none')]) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-3">
        <?= $form->field($model, "[$i]salutation")->dropDownList(['mr.' => 'Mr.', 'mrs.' => 'Mrs.', 'miss' => 'Miss.'], ['prompt' => 'Select', 'class' => 'form-control txt_salutation']) ?>
                                            </div>

                                            <div class="col-sm-3">
        <?= $form->field($model, "[$i]first_name")->textInput(['maxlength' => true, 'class' => 'form-control txt_first_name', 'placeholder' => 'Enter First Name']) ?>
                                            </div>

                                            <div class="col-sm-3">
        <?= $form->field($model, "[$i]middle_name")->textInput(['maxlength' => true, 'class' => 'form-control txt_middle_name', 'placeholder' => 'Enter Middle Name']) ?>
                                            </div>

                                            <div class="col-sm-3">
        <?= $form->field($model, "[$i]last_name")->textInput(['maxlength' => true, 'class' => 'form-control txt_last_name', 'placeholder' => 'Enter Last Name']) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <?= $form->field($model, "[$i]short_name")->textInput(['maxlength' => true, 'class' => 'form-control txt_short_name', 'placeholder' => 'Enter Short Name']) ?>
                                            </div>
                                            <div class="col-sm-6">
        <?= $form->field($model, "[$i]email")->textInput(['maxlength' => true, 'class' => 'form-control txt_email']) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <?= $form->field($model, "[$i]gender")->dropDownList([$model::GENDER_MALE => 'Male', $model::GENDER_FEMALE => 'Female'], ['prompt' => 'Select Gender', 'class' => 'form-control txt_gender']) ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <?php
                                            echo $form->field($model, "[$i]birthday")->widget(DatePicker::classname(), [
                                                'options' => ['placeholder' => 'DD/MM/YYYY', 'class' => 'txt_birthday'],
                                                'pluginOptions' => [
                                                    'autoclose' => true,
                                                    'format' => Yii::$app->params['dateFormatJs']
                                                ]
                                            ]);
                                            ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <?php
                                            if ($model->isNewRecord) {
                                                $model->timezone = 'Africa/Lagos';
                                            }
                                            ?>
                                            <?= $form->field($model, "[$i]timezone")->dropDownList(ArrayHelper::map(\common\models\TimezoneMaster::find()->all(), 'name', 'label'), ['prompt' => 'Select Timezone', 'class' => 'form-control txt_timezone']) ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                 <?= $form->field($model, "[$i]occupation")->dropDownList(['Employed' => 'Employed', 'Self Employed' => 'Self Employed', 'Business Owner' => 'Business Owner', 'Other' => 'Other'], ['prompt' => 'Select', 'class' => 'form-control occupation']) ?>
                                            </div>
                                            <div class="col-sm-6 occupation_other" style="display:<?php if ($model->occupation == 'Other')
                                                     echo 'block';
                                                 else
                                                     echo 'none'
                                                     ?>" id="otherOccupationDiv">
                                                    <?= $form->field($model, "[$i]occupation_other")->textInput(['maxlength' => true, 'class' => 'form-control txt_occupation_other']) ?>
                                            </div>
                                        </div>
                                    </div>

                                    <?= $this->render('//shared/_phone_fields', ['form' => $form, 'model' => $model, 'index' => $i]) ?>

                                    <h5>Address Details:</h5>
                                    <div class="address_fields_holder">
                                        <?= $this->render('//shared/_address_fields', ['form' => $form, 'model' => $model, 'index' => $i]) ?>
                                    </div>
                                </div>
                            </div>     
                        </div>
                    </div>
                </div>
            </div>
        <?php
        $index ++;
    }
?>
</div>
<?php ActiveForm::end(); ?>

<?php
$js="$(function(){
    
    $('.panel_item').each(function(index){
        var thisBlock = $(this);
        if(thisBlock.find('.sel_contact_type').val() == 'Buyer Agent'){
            thisBlock.find('input[name^=\"Contact[\"]').attr('readonly', true);
            thisBlock.find('select[name^=\"Contact[\"]').attr('disabled', true);
        }
    });


    $('body').on('change', '.sel_contact_type', function(){
        var thisField = $(this);
        var thisBlock = thisField.closest('.panel_item');
        if(thisField.val() == 'Buyer Agent'){
            thisField.closest('.item').find('.search_agent').show();
            thisField.closest('.item').find('.txt_agent_id').show();
            thisBlock.find('input[name^=\"Contact[\"]').attr('readonly', true);
            thisBlock.find('select[name^=\"Contact[\"]').attr('disabled', true);
            thisField.closest('.dynamic_sm').next().show();
        }else{
            thisField.closest('.item').find('.search_agent').hide();
            thisField.closest('.item').find('.txt_agent_id').hide();
            thisBlock.find('input[name^=\"Contact[\"]').attr('readonly', false);
            thisBlock.find('select[name^=\"Contact[\"]').attr('disabled', false);
            thisField.closest('.dynamic_sm').next().hide();
        }
    });
    $('body').on('click', '.refresh_page', function(){
        var thisField = $(this);
        var thisBlock = thisField.closest('.panel_item');
        if(thisBlock.find('.txt_buyer_agent_selected').val() == 'yes'){
            location.reload();
        }else{
            thisBlock.find('.sel_contact_type').val('').attr('disabled', false).trigger('change');
        }
    });
    
    $('body').on('click', '.remove_contact', function(){
        if(!confirm('Are you sure?')){
            return false;
        }
        var thisBtn = $(this);
        $.post('".Url::to(['property/delete-contact'])."', {contact_id:thisBtn.data('contact_id')}, function(){
            thisBtn.parents('.panel_item').slideUp('slow');
            setTimeout(location.reload(), 500);
        }, 'json');
        return false;
    });

    });";

$this->registerJs($js, View::POS_END);