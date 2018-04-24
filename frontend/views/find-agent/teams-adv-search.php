<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\web\JsExpression;
use kartik\depdrop\DepDrop;
use yii\helpers\ArrayHelper;
use common\models\LocationSuggestion;

$this->title = 'Agent Advance Search';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile(Yii::$app->urlManager->baseUrl.'/public_main/js/team_search.js', ['depends'=> [\yii\bootstrap\BootstrapPluginAsset::className()]])
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
                            <h2>Team Search</h2>
                        </div>
                        <?= Html::beginForm(['find-agent/search-team'], 'get', ['class' => 'frm_geocomplete frm_find_team_page_search','id' => 'buy_property_form']) ?>
                        <?= Html::hiddenInput('type', 'team', ['class' => 'find_agent_search_type'])?>
                        <div class="form-group">
                            <h5>Team Information</h5>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <?php
                                    echo Select2::widget([
                                        'name' => 'name',
                                        'maintainOrder' => true,
                                        'options' => ['placeholder' => 'Team Name', 'multiple' => false, 'class' => 'team_search_team_name search_item', 'id' => 'team_search_team_name'],
                                        'pluginOptions' => [
                                            'maximumInputLength' => 10,
                                            'allowClear' => true,
                                            'minimumInputLength' => 3,
                                            'ajax' => [
                                                'url' => Url::to(['/team/search-by-name-json']),
                                                'dataType' => 'json',
                                                'data' => new JsExpression('function(term,page) { return {search:term}; }'),
                                                'results' => new JsExpression('function(data,page) { return {results:data.results}; }'),
                                            ]
                                        ],
                                        'pluginEvents' => [
                                            "select2:select" => "function() { 
                                                     var name = $('#team_search_team_name').find('option:selected').text();
                                                     $.post('" . Url::to(['/team/populate-children-by-name-json']) . "', {name:name}, function(response){
                                                        if(response.result){
                                                            var result = response.result;
                                                            var newID = new Option(result.text, result.id, true, true);
                                                            $('#team_search_team_id').append(newID).trigger('change');
                                                            
                                                            var office = result.office;
                                                            var newOfficeName = new Option(office.name, office.name, true, true);
                                                            $('#team_search_office_name').append(newOfficeName).trigger('change');
                                                            var newOfficeID = new Option(office.id, office.id, true, true);
                                                            $('#team_search_office_id').append(newOfficeID).trigger('change');
                                                            
                                                            if(office.address.state){
                                                                $('#team_search_office_state').val(office.address.state).trigger('change');
                                                            }
                                                            if(office.address.town){
                                                                var newTown = new Option(office.address.town, office.address.town, true, true);
                                                                $('#team_search_office_town').append(newTown).trigger('change');
                                                            }
                                                            if(office.address.area){
                                                                var newArea = new Option(office.address.area, office.address.area, true, true);
                                                                $('#team_search_office_area').append(newArea).trigger('change');
                                                            }
                                                            if(office.address.zip_code){
                                                                var newZipCode = new Option(office.address.zip_code, office.address.zip_code, true, true);
                                                                $('#team_search_office_zip_code').append(newZipCode).trigger('change');
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
                                        'name' => 'teamID',
                                        'maintainOrder' => true,
                                        'options' => ['placeholder' => 'Team ID', 'multiple' => false, 'class' => 'team_search_team_id search_item', 'id' => 'team_search_team_id'],
                                        'pluginOptions' => [
                                            'maximumInputLength' => 10,
                                            'allowClear' => true,
                                            'minimumInputLength' => 3,
                                            'ajax' => [
                                                'url' => Url::to(['/team/search-by-name-id-json']),
                                                'dataType' => 'json',
                                                'data' => new JsExpression('function(term,page) { return {search:term, parent:$("#team_search_team_name").val()}; }'),
                                                'results' => new JsExpression('function(data,page) { return {results:data.results}; }'),
                                            ]
                                        ],
                                        'pluginEvents' => [
                                            "select2:select" => "function() { 
                                                     var id = $('#team_search_team_id').val();
                                                     $.post('" . Url::to(['/team/populate-children-by-id-json']) . "', {id:id}, function(response){
                                                        if(response.result){
                                                            var result = response.result;
                                                            var newName = new Option(result.text, result.name, true, true);
                                                            $('#team_search_team_name').append(newName).trigger('change');

                                                            var office = result.office;
                                                            var newOfficeName = new Option(office.name, office.name, true, true);
                                                            $('#team_search_office_name').append(newOfficeName).trigger('change');
                                                            var newOfficeID = new Option(office.id, office.id, true, true);
                                                            $('#team_search_office_id').append(newOfficeID).trigger('change');
                                                            
                                                            if(office.address.state){
                                                                $('#team_search_office_state').val(office.address.state).trigger('change');
                                                            }
                                                            if(office.address.town){
                                                                var newTown = new Option(office.address.town, office.address.town, true, true);
                                                                $('#team_search_office_town').append(newTown).trigger('change');
                                                            }
                                                            if(office.address.area){
                                                                var newArea = new Option(office.address.area, office.address.area, true, true);
                                                                $('#team_search_office_area').append(newArea).trigger('change');
                                                            }
                                                            if(office.address.zip_code){
                                                                var newZipCode = new Option(office.address.zip_code, office.address.zip_code, true, true);
                                                                $('#team_search_office_zip_code').append(newZipCode).trigger('change');
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
                        <h5>Office Information</h5>
                        </div>
                        <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <?php
                                        echo Select2::widget([
                                            'name' => 'officeName',
                                            'maintainOrder' => true,
                                            'options' => ['placeholder' => 'Office Name', 'multiple' => false, 'class' => 'team_search_office_name search_item', 'id' => 'team_search_office_name'],
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
                                                     var name = $('#team_search_office_name').find('option:selected').text();
                                                     $.post('".Url::to(['agency/populate-children-by-name-json'])."', {name:name}, function(response){
                                                        if(response.result){
                                                            var result = response.result;
                                                            var newID = new Option(result.text, result.id, true, true);
                                                            $('#team_search_office_id').append(newID).trigger('change');

                                                            if(result.address.state){
                                                                $('#team_search_office_state').val(result.address.state).trigger('change');
                                                            }
                                                            if(result.address.town){
                                                                var newTown = new Option(result.address.town, result.address.town, true, true);
                                                                $('#team_search_office_town').append(newTown).trigger('change');
                                                            }
                                                            if(result.address.area){
                                                                var newArea = new Option(result.address.area, result.address.area, true, true);
                                                                $('#team_search_office_area').append(newArea).trigger('change');
                                                            }
                                                            if(result.address.zip_code){
                                                                var newZipCode = new Option(result.address.zip_code, result.address.zip_code, true, true);
                                                                $('#team_search_office_zip_code').append(newZipCode).trigger('change');
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
                                            'name' => 'officeID',
                                            'maintainOrder' => true,
                                            'options' => ['placeholder' => 'Office ID', 'multiple' => false, 'class' => 'team_search_office_id search_item', 'id' => 'team_search_office_id'],
                                            'pluginOptions' => [
                                                'maximumInputLength' => 10,
                                                'allowClear' => true,
                                                'minimumInputLength' => 3,
                                                'ajax' => [
                                                'url' => Url::to(['/agency/search-by-name-id-json']),
                                                'dataType' => 'json',
                                                'data' => new JsExpression('function(term,page) { return {search:term, parent:$("#team_search_office_name").val()}; }'),
                                                'results' => new JsExpression('function(data,page) { return {results:data.results}; }'),
                                                ]
                                            ],
                                            'pluginEvents' => [
                                                "select2:select" => "function() { 
                                                     var id = $('#team_search_office_id').val();
                                                     $.post('".Url::to(['agency/populate-children-by-id-json'])."', {id:id}, function(response){
                                                        if(response.result){
                                                            var result = response.result;
                                                            var newName = new Option(result.text, result.name, true, true);
                                                            $('#team_search_office_name').append(newName).trigger('change');

                                                            if(result.address.state){
                                                                $('#team_search_office_state').val(result.address.state).trigger('change');
                                                            }
                                                            if(result.address.town){
                                                                var newTown = new Option(result.address.town, result.address.town, true, true);
                                                                $('#team_search_office_town').append(newTown).trigger('change');
                                                            }
                                                            if(result.address.area){
                                                                var newArea = new Option(result.address.area, result.address.area, true, true);
                                                                $('#team_search_office_area').append(newArea).trigger('change');
                                                            }
                                                            if(result.address.zip_code){
                                                                var newZipCode = new Option(result.address.zip_code, result.address.zip_code, true, true);
                                                                $('#team_search_office_zip_code').append(newZipCode).trigger('change');
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
                                        'name' => 'officeState',
                                        'maintainOrder' => true,
                                        'data' => ArrayHelper::map(LocationSuggestion::find()->select('state')->distinct()->orderBy(['state' => SORT_ASC])->all(), 'state', 'state'),
                                        'options' => ['placeholder' => 'Select State', 'multiple' => false, 'class' => 'team_search_office_state search_item', 'id' => 'team_search_office_state'],
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
                                        'options' => ['id' => 'team_search_office_town', 'class' => 'team_search_office_town search_item'],
                                        'type' => DepDrop::TYPE_SELECT2,
                                        'pluginOptions' => [
                                            'depends' => ['team_search_office_state'],
                                            'placeholder' => 'Select Town',
                                            'url' => Url::to(['/location-suggestion/get-towns'])
                                        ],
                                        'select2Options' => ['pluginOptions' => ['allowClear' => true]],
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
                                        'options' => ['id' => 'team_search_office_area', 'class' => 'team_search_office_area search_item'],
                                        'type' => DepDrop::TYPE_SELECT2,
                                        'pluginOptions' => [
                                            'depends' => ['team_search_office_town'],
                                            'placeholder' => 'Select Area',
                                            'url' => Url::to(['/location-suggestion/get-areas'])
                                        ],
                                        'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                                    ]);
                                    ?>
                                </div>
                                <div class="col-sm-6">
                                    <?php
                                    echo DepDrop::widget([
                                        'name' => 'officeZipCode',
                                        'options' => ['class' => 'team_search_office_zip_code search_item', 'id' => 'team_search_office_zip_code'],
                                        'type' => DepDrop::TYPE_SELECT2,
                                        'pluginOptions' => [
                                            'depends' => ['team_search_office_town'],
                                            'placeholder' => 'Select Zip Code',
                                            'url' => Url::to(['/location-suggestion/get-zip-codes'])
                                        ],
                                        'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                                    ]);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <?= Html::button('Search Now', ['class' => 'btn btn-default btn-main btn_search_team']) ?>
                        </div>
                        <?= Html::endForm() ?>
                    </div>
                </div>
                <!-- Agent Search Sec -->
            </div>
        </div>
    </div>
</div>
