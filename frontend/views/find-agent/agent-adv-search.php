<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\web\JsExpression;
use common\models\LocationSuggestion;

error_reporting(0);
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
                            <h2>Agent Search</h2>
                        </div>
                        <?= Html::beginForm(['find-agent/search'], 'get', ['class' => 'frm_geocomplete frm_find_agent_page_search','id' => 'buy_property_form']) ?>
                        <?= Html::hiddenInput('type', 'agent', ['class' => 'find_agent_search_type'])?>
                        <div class="form-group">
                            <h5>Agent Information</h5>
                        </div>
                        <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <?php
                                echo Select2::widget([
                                    'name' => 'name',
                                    'maintainOrder' => true,
                                    'options' => ['placeholder' => 'Name', 'multiple' => false, 'class' => 'agent_search_agent_name search_item', 'id' => 'agent_search_agent_name'],
                                    'pluginOptions' => [
                                        'maximumInputLength' => 10,
                                        'allowClear' => true,
                                        'minimumInputLength' => 3,
                                        'ajax' => [
                                            'url' => Url::to(['/agent/search-by-name-json']),
                                            'dataType' => 'json',
                                            'data' => new JsExpression('function(term,page) { return {search:term}; }'),
                                            'results' => new JsExpression('function(data,page) { return {results:data.results}; }'),
                                        ]
                                    ],
                                    'pluginEvents' => [
                                        "select2:select" => "function() { 
                                                 var name = $('#agent_search_agent_name').find('option:selected').text();
                                                 $.post('" . Url::to(['/agent/populate-children-by-name-json']) . "', {name:name}, function(response){
                                                    if(response.result){
                                                        var result = response.result;
                                                        var newID = new Option(result.text, result.id, true, true);
                                                        $('#agent_search_agent_id').append(newID).trigger('change');
                                                        
                                                        var address = result.address;
                                                        $.each(address, function(index, value){
                                                            if(value == null){
                                                                value = '';
                                                            }
                                                            if(index == 'state'){
                                                                $('#agent_search_agent_state').val(value).trigger('change');
                                                            }else if(index == 'town'){
                                                                var newTown = new Option(value, value, true, true);
                                                                $('#agent_search_agent_town').append(newTown).trigger('change');
                                                            }else if(index == 'area'){
                                                                var newArea = new Option(value, value, true, true);
                                                                $('#agent_search_agent_area').append(newArea).trigger('change');
                                                            }else if(index == 'zip_code'){
                                                                var newZipCode = new Option(value, value, true, true);
                                                                $('#agent_search_agent_zip_code').append(newZipCode).trigger('change');
                                                            }
                                                        });

                                                        var office = result.office;
                                                        var newOfficeName = new Option(office.name, office.name, true, true);
                                                        $('#agent_search_office_name').append(newOfficeName).trigger('change');
                                                        var newOfficeID = new Option(office.id, office.id, true, true);
                                                        $('#agent_search_office_id').append(newOfficeID).trigger('change');

                                                        $.each(office.address, function(index, value){
                                                            if(value == null){
                                                                value = '';
                                                            }
                                                            if(index == 'state'){
                                                                $('#agent_search_office_state').val(value).trigger('change');
                                                            }else if(index == 'town'){
                                                                var newTown = new Option(value, value, true, true);
                                                                $('#agent_search_office_town').append(newTown).trigger('change');
                                                            }else if(index == 'area'){
                                                                var newArea = new Option(value, value, true, true);
                                                                $('#agent_search_office_area').append(newArea).trigger('change');
                                                            }else if(index == 'zip_code'){
                                                                var newZipCode = new Option(value, value, true, true);
                                                                $('#agent_search_office_zip_code').append(newZipCode).trigger('change');
                                                            }
                                                        });

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
                                'name' => 'agentID',
                                'maintainOrder' => true,
                                'options' => ['placeholder' => 'Agent ID', 'multiple' => false, 'class' => 'agent_search_agent_id search_item', 'id' => 'agent_search_agent_id'],
                                'pluginOptions' => [
                                    'maximumInputLength' => 10,
                                    'allowClear' => true,
                                    'minimumInputLength' => 3,
                                    'ajax' => [
                                        'url' => Url::to(['/agent/search-by-name-id-json']),
                                        'dataType' => 'json',
                                        'data' => new JsExpression('function(term,page) { return {search:term, parent:$("#agent_search_team_name").val()}; }'),
                                        'results' => new JsExpression('function(data,page) { return {results:data.results}; }'),
                                    ]
                                ],
                                'pluginEvents' => [
                                    "select2:select" => "function() { 
                                             var id = $('#agent_search_agent_id').val();
                                             $.post('" . Url::to(['/agent/populate-children-by-id-json']) . "', {id:id}, function(response){
                                                if(response.result){
                                                    var result = response.result;
                                                    var newName = new Option(result.text, result.name, true, true);
                                                    $('#agent_search_agent_name').append(newName).trigger('change');
                                                    
                                                    var address = result.address;
                                                    $.each(address, function(index, value){
                                                        if(value == null){
                                                            value = '';
                                                        }
                                                        if(index == 'state'){
                                                            $('#agent_search_agent_state').val(value).trigger('change');
                                                        }else if(index == 'town'){
                                                            var newTown = new Option(value, value, true, true);
                                                            $('#agent_search_agent_town').append(newTown).trigger('change');
                                                        }else if(index == 'area'){
                                                            var newArea = new Option(value, value, true, true);
                                                            $('#agent_search_agent_area').append(newArea).trigger('change');
                                                        }else if(index == 'zip_code'){
                                                            var newZipCode = new Option(value, value, true, true);
                                                            $('#agent_search_agent_zip_code').append(newZipCode).trigger('change');
                                                        }
                                                    });
                                                    
                                                    var office = result.office;
                                                    var newOfficeName = new Option(office.name, office.name, true, true);
                                                    $('#agent_search_office_name').append(newOfficeName).trigger('change');
                                                    var newOfficeID = new Option(office.id, office.id, true, true);
                                                    $('#agent_search_office_id').append(newOfficeID).trigger('change');
                                                    
                                                    $.each(office.address, function(index, value){
                                                        if(value == null){
                                                            value = '';
                                                        }
                                                        if(index == 'state'){
                                                            $('#agent_search_office_state').val(value).trigger('change');
                                                        }else if(index == 'town'){
                                                            var newTown = new Option(value, value, true, true);
                                                            $('#agent_search_office_town').append(newTown).trigger('change');
                                                        }else if(index == 'area'){
                                                            var newArea = new Option(value, value, true, true);
                                                            $('#agent_search_office_area').append(newArea).trigger('change');
                                                        }else if(index == 'zip_code'){
                                                            var newZipCode = new Option(value, value, true, true);
                                                            $('#agent_search_office_zip_code').append(newZipCode).trigger('change');
                                                        }
                                                    });

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
                                        'options' => ['placeholder' => 'Select State', 'multiple' => false, 'class' => 'agent_search_agent_state search_item', 'id' => 'agent_search_agent_state'],
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
                                        'options' => ['id' => 'agent_search_agent_town', 'class' => 'agent_search_agent_town search_item'],
                                        'type' => DepDrop::TYPE_SELECT2,
                                        'pluginOptions' => [
                                            'depends' => ['agent_search_agent_state'],
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
                                        'options' => ['id' => 'agent_search_agent_area', 'class' => 'agent_search_agent_area search_item'],
                                        'type' => DepDrop::TYPE_SELECT2,
                                        'pluginOptions' => [
                                            'depends' => ['agent_search_agent_town'],
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
                                        'options' => ['class' => 'agent_search_agent_zip_code search_item', 'id' => 'agent_search_agent_zip_code'],
                                        'type' => DepDrop::TYPE_SELECT2,
                                        'pluginOptions' => [
                                            'depends' => ['agent_search_agent_town'],
                                            'placeholder' => 'Select Zip Code',
                                            'url' => Url::to(['/location-suggestion/get-zip-codes'])
                                        ],
                                        'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                                    ]);
                                ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>Office Information</h5>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <?php
                                    echo Select2::widget([
                                        'name' => 'officeName',
                                        'maintainOrder' => true,
                                        'options' => ['placeholder' => 'Office Name', 'multiple' => false, 'class' => 'agent_search_office_name search_item', 'id' => 'agent_search_office_name'],
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
                                                 var name = $('#agent_search_office_name').find('option:selected').text();
                                                 $.post('".Url::to(['agency/populate-children-by-name-json'])."', {name:name}, function(response){
                                                    if(response.result){
                                                        var result = response.result;
                                                        var newID = new Option(result.text, result.id, true, true);
                                                        $('#agent_search_office_id').append(newID).trigger('change');
                                                        $.each(result.address, function(index, value){
                                                            if(value == null){
                                                                value = '';
                                                            }
                                                            if(index == 'state'){
                                                                $('#agent_search_office_state').val(value).trigger('change');
                                                            }else if(index == 'town'){
                                                                var newTown = new Option(value, value, true, true);
                                                                $('#agent_search_office_town').append(newTown).trigger('change');
                                                            }else if(index == 'area'){
                                                                var newArea = new Option(value, value, true, true);
                                                                $('#agent_search_office_area').append(newArea).trigger('change');
                                                            }else if(index == 'zip_code'){
                                                                var newZipCode = new Option(value, value, true, true);
                                                                $('#agent_search_office_zip_code').append(newZipCode).trigger('change');
                                                            }
                                                        });
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
                                        'name' => 'officeID',
                                        'maintainOrder' => true,
                                        'options' => ['placeholder' => 'Office ID', 'multiple' => false, 'class' => 'agent_search_office_id search_item', 'id' => 'agent_search_office_id'],
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
                                                 var id = $('#agent_search_office_id').val();
                                                 $.post('".Url::to(['agency/populate-children-by-id-json'])."', {id:id}, function(response){
                                                    if(response.result){
                                                        var result = response.result;
                                                        var newName = new Option(result.text, result.name, true, true);
                                                        $('#agent_search_office_name').append(newName).trigger('change');
                                                        $.each(result.address, function(index, value){
                                                            if(value == null){
                                                                value = '';
                                                            }
                                                            if(index == 'state'){
                                                                $('#agent_search_office_state').val(value).trigger('change');
                                                            }else if(index == 'town'){
                                                                var newTown = new Option(value, value, true, true);
                                                                $('#agent_search_office_town').append(newTown).trigger('change');
                                                            }else if(index == 'area'){
                                                                var newArea = new Option(value, value, true, true);
                                                                $('#agent_search_office_area').append(newArea).trigger('change');
                                                            }else if(index == 'zip_code'){
                                                                var newZipCode = new Option(value, value, true, true);
                                                                $('#agent_search_office_zip_code').append(newZipCode).trigger('change');
                                                            }
                                                        });
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
                                        'name' => 'officeState',
                                        'maintainOrder' => true,
                                        'data' => ArrayHelper::map(LocationSuggestion::find()->select('state')->distinct()->orderBy(['state' => SORT_ASC])->all(), 'state', 'state'),
                                        'options' => ['placeholder' => 'Select Office State', 'multiple' => false, 'class' => 'agent_search_office_state search_item', 'id' => 'agent_search_office_state'],
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
                                        'name' => 'officeTown',
                                        'options' => ['id' => 'agent_search_office_town', 'class' => 'agent_search_office_town search_item'],
                                        'type' => DepDrop::TYPE_SELECT2,
                                        'pluginOptions' => [
                                            'depends' => ['agent_search_office_state'],
                                            'placeholder' => 'Select Office Town',
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
                                        'name' => 'officeArea',
                                        'options' => ['id' => 'agent_search_office_area', 'class' => 'agent_search_office_area search_item'],
                                        'type' => DepDrop::TYPE_SELECT2,
                                        'pluginOptions' => [
                                            'depends' => ['agent_search_office_town'],
                                            'placeholder' => 'Select Office Area',
                                            'url' => Url::to(['/location-suggestion/get-areas'])
                                        ],
                                        'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                                    ]);
                                ?>
                                </div>
                                <div class="col-sm-6">
                                    <?php
                                    echo DepDrop::widget([
                                        'name' => 'officeZipCode',
                                        'options' => ['class' => 'agent_search_office_zip_code search_item', 'id' => 'agent_search_office_zip_code'],
                                        'type' => DepDrop::TYPE_SELECT2,
                                        'pluginOptions' => [
                                            'depends' => ['agent_search_office_town'],
                                            'placeholder' => 'Select Office Zip Code',
                                            'url' => Url::to(['/location-suggestion/get-zip-codes'])
                                        ],
                                        'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                                    ]);
                                ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <?= Html::button('Search Now', ['class' => 'btn btn-default btn-main btn_search_agent']) ?>
                        </div>
                        <?= Html::endForm() ?>
                    </div>
                </div>
                <!-- Agent Search Sec -->
            </div>
        </div>
    </div>
</div>
