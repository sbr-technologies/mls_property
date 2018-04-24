<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\helpers\ArrayHelper;
use common\models\LocationSuggestion;
use kartik\depdrop\DepDrop;
$this->title = 'Agent Advance Search';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile(Yii::$app->urlManager->baseUrl.'/public_main/js/agent_search.js', ['depends'=> [\yii\bootstrap\BootstrapPluginAsset::className()]])
?>
<div class="vertical-alignment-helper">
    <div class="modal-dialog vertical-align-center"> 
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <!-- Agent Search Sec -->
                <div class="login-box register-box">
                    <div class="login-box-inner">
                        <div class="login-box-header">
                            <h2>Office Search</h2>
                        </div>
                        <?= Html::beginForm(['find-agent/search-agency'], 'get', ['class' => 'frm_geocomplete frm_find_agent_page_search','id' => 'buy_property_form']) ?>
                            <?= Html::hiddenInput('location', '', ['class' => 'realestate_search_location'])?>
                            <?= Html::hiddenInput('agent', '', ['class' => 'realestate_search_agent'])?>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <?php
                                        echo Select2::widget([
                                            'name' => 'name',
                                            'maintainOrder' => true,
                                            'options' => ['placeholder' => 'Office Name', 'multiple' => false, 'class' => 'office_search_office_name search_item', 'id' => 'office_search_office_name'],
                                            'pluginOptions' => [
                                                'maximumInputLength' => 10,
                                                'allowClear' => true,
                                                'minimumInputLength' => 3,
                                                'ajax' => [
                                                'url' => Url::to(['/agency/search-by-name-json']),
                                                'dataType' => 'json',
                                                'data' => new JsExpression('function(term,page) { return {search:term}; }'),
                                                'results' => new JsExpression('function(data,page) { return {results:data.results}; }'),
                                                ]
                                            ],
                                            'pluginEvents' => [
                                                "select2:select" => "function() { 
                                                     var name = $('#office_search_office_name').find('option:selected').text();
                                                     $.post('".Url::to(['agency/populate-children-by-name-json'])."', {name:name}, function(response){
                                                        if(response.result){
                                                            var result = response.result;
                                                            var newID = new Option(result.text, result.id, true, true);
                                                            $('#search_agency_id').append(newID).trigger('change');

                                                            if(result.address.state){
                                                                $('#office_search_office_state').val(result.address.state).trigger('change');
                                                            }
                                                            if(result.address.town){
                                                                var newTown = new Option(result.address.town, result.address.town, true, true);
                                                                $('#office_search_office_town').append(newTown).trigger('change');
                                                            }
                                                            if(result.address.area){
                                                                var newArea = new Option(result.address.area, result.address.area, true, true);
                                                                $('#office_search_office_area').append(newArea).trigger('change');
                                                            }
                                                            if(result.address.zip_code){
                                                                var newZipCode = new Option(result.address.zip_code, result.address.zip_code, true, true);
                                                                $('#office_search_office_zip_code').append(newZipCode).trigger('change');
                                                            }
                                                            
                                                        }
                                                    }, 'json');
                                                }",
                                            ]
                                        ]);
                                        ?>
                                    </div>
                                    <div class="col-sm-6">
                                    <?php
                                        echo Select2::widget([
                                            'name' => 'agencyID',
                                            'maintainOrder' => true,
                                            'options' => ['placeholder' => 'Office ID', 'multiple' => false, 'class' => 'office_search_office_id search_item', 'id' => 'search_agency_id'],
                                            'pluginOptions' => [
                                                'maximumInputLength' => 10,
                                                'allowClear' => true,
                                                'minimumInputLength' => 3,
                                                'ajax' => [
                                                'url' => Url::to(['/agency/search-by-name-id-json']),
                                                'dataType' => 'json',
                                                'data' => new JsExpression('function(term,page) { return {search:term, parent:$("#office_search_office_name").val()}; }'),
                                                'results' => new JsExpression('function(data,page) { return {results:data.results}; }'),
                                                ]
                                            ],
                                            'pluginEvents' => [
                                                "select2:select" => "function() { 
                                                     var id = $('#search_agency_id').val();
                                                     $.post('".Url::to(['agency/populate-children-by-id-json'])."', {id:id}, function(response){
                                                        if(response.result){
                                                            var result = response.result;
                                                            var newName = new Option(result.text, result.name, true, true);
                                                            $('#office_search_office_name').append(newName).trigger('change');

                                                            if(result.address.state){
                                                                $('#office_search_office_state').val(result.address.state).trigger('change');
                                                            }
                                                            if(result.address.town){
                                                                var newTown = new Option(result.address.town, result.address.town, true, true);
                                                                $('#office_search_office_town').append(newTown).trigger('change');
                                                            }
                                                            if(result.address.area){
                                                                var newArea = new Option(result.address.area, result.address.area, true, true);
                                                                $('#office_search_office_area').append(newArea).trigger('change');
                                                            }
                                                            if(result.address.zip_code){
                                                                var newZipCode = new Option(result.address.zip_code, result.address.zip_code, true, true);
                                                                $('#office_search_office_zip_code').append(newZipCode).trigger('change');
                                                            }
                                                            
                                                        }
                                                    }, 'json');
                                                }",
                                            ]
                                        ]);
                                    ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-6">
                                    <?php
                                        echo Select2::widget([
                                            'name' => 'state',
                                            'maintainOrder' => true,
                                            'data' => ArrayHelper::map(LocationSuggestion::find()->select('state')->distinct()->orderBy(['state' => SORT_ASC])->all(), 'state', 'state'),
                                            'options' => ['placeholder' => 'Select State', 'multiple' => false, 'class' => 'office_search_office_state search_item', 'id' => 'office_search_office_state'],
                                            'pluginOptions' => [
                                                'maximumInputLength' => 10,
                                                'allowClear' => true,
                                            ]
                                        ]);
                                    ?>
                                    </div>
                                    <div class="col-sm-6">
                                    <?php
                                        echo DepDrop::widget([
                                            'name' => 'town',
                                            'options' => ['id' => 'office_search_office_town', 'class' => 'office_search_office_town search_item'],
                                            'type' => DepDrop::TYPE_SELECT2,
                                            'pluginOptions' => [
                                                'depends' => ['office_search_office_state'],
                                                'placeholder' => 'Select Town',
                                                'url' => Url::to(['/location-suggestion/get-towns'])
                                            ],
                                            'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                                        ]);
                                    ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-6">
                                    <?php
                                        echo DepDrop::widget([
                                            'name' => 'area',
                                            'options' => ['id' => 'office_search_office_area', 'class' => 'office_search_office_area search_item'],
                                            'type' => DepDrop::TYPE_SELECT2,
                                            'pluginOptions' => [
                                                'depends' => ['office_search_office_town'],
                                                'placeholder' => 'Select Area',
                                                'url' => Url::to(['/location-suggestion/get-areas'])
                                            ],
                                            'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                                        ]);
                                    ?>
                                    </div>
                                    <div class="col-sm-6">
                                        <?php
                                        echo DepDrop::widget([
                                            'name' => 'zip_code',
                                            'options' => ['class' => 'office_search_office_zip_code search_item', 'id' => 'office_search_office_zip_code'],
                                            'type' => DepDrop::TYPE_SELECT2,
                                            'pluginOptions' => [
                                                'depends' => ['office_search_office_town'],
                                                'placeholder' => 'Select Zip Code',
                                                'url' => Url::to(['/location-suggestion/get-zip-codes'])
                                            ],
                                            'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                                        ]);
                                    ?>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="form-group text-center">
                                <?= Html::button('Search Now', ['class' => 'btn btn-default btn-main btn_search_agancy']) ?>
                            </div>
                        <?= Html::endForm() ?>
                    </div>
                </div>
                <!-- Agent Search Sec -->
            </div>
        </div>
    </div>
</div>