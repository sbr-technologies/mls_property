<?php
use kartik\typeahead\Typeahead;
use yii\web\JsExpression;
use yii\helpers\Url;
use yii\web\View;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use common\models\LocationSuggestion;
use yii\helpers\ArrayHelper;
error_reporting(0);
$this->registerJsFile(
    '@web/plugins/underscore.js',
    ['depends' => [
        \yii\web\JqueryAsset::className(),
        \yii\bootstrap\BootstrapPluginAsset::ClassName()
        ]
   ]
);

$this->registerJsFile(
    '@web/public_main/js/team_search.js',
    ['depends' => [
        \yii\web\JqueryAsset::className(),
        \yii\bootstrap\BootstrapPluginAsset::ClassName()
        ]
   ]
);
?>
<div class="property-menu-bar find-agent-menu-bar">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <form action="<?= Url::to(['/team-search-result'])?>" role="search" class="frm_find_team_page_search" id="frm_search_result_page_search">
                    <input type="hidden" class="hid_search_page" value="0" />
                    <div class="hotel-listing-form">
                        <div class="form-group">
                            <?php
                            $template = '<div><p class="repo-language">{{language}}</p>' .
                                    '<p class="repo-name">{{value}}</p>' .
                                    '<p class="repo-description">{{email}}</p></div>';

                                echo Typeahead::widget([
                                    'name' => 'name', 
                                    'options' => ['placeholder' => 'Enter Name of Team', 'class' => 'txt_team_suggestion', 'id' => 'txt_team_suggestion'],
                                    'dataset' => [
                                        [
                                            'remote' => [
                                                'url' => Url::to(['/team-suggestion']) . '?q=%QUERY',
                                                'wildcard' => '%QUERY'
                                            ],
                                            'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                                            'display' => 'value',
                                            'templates' => [
                                                'notFound' => '<div class="text-danger" style="padding:0 8px">Unable to find any Team for selected query.</div>',
                                                'suggestion' => new JsExpression("Handlebars.compile('{$template}')")
                                            ],
                                            'limit' => 20
                                        ]
                                    ],
                                    'pluginEvents' => [
                                        "typeahead:select" => "function(e, data) {
                                            console.log(data);
                                            var newName = new Option(data.value, data.value, true, true);
                                            $('#team_search_team_name').append(newName).trigger('change');
                                        }"
                                    ]
                                ]);
                            ?>
                        </div>
                            <button class="btn btn-default save-search-btn" type="submit">Search</button>
                    </div>
                    <div class="property-menu-list">
                        <div class="dropdown property_more_filters">
                            <button class="dropdown-toggle btn_filter_by_more" type="button"><span class="btntext">More Filters</span>
                                <span class="caret"></span></button>
                            <div class="dropdown-menu">
                                <div class="form-sec">
                                    <div class="row">
                                        <div class="form-group">
                                        <h5>Team Information</h5>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <?php
                                                    $data = [];
                                                    $value = '';
                                                    if(isset($filters['name']) && $filters['name']){
                                                        $data = [$filters['name'] => $filters['name']];
                                                        $value = $filters['name'];
                                                    }
                                                    echo Select2::widget([
                                                        'name' => 'name',
                                                        'value' => $value,
                                                        'data' => $data,
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
                                                            $('#txt_team_suggestion').val(result.name);
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
                                                        'select2:unselect' => "function(){
                                                            $('#txt_team_suggestion').val('');
                                                        }"
                                                        ]
]);
                                                    ?>
                                                </div>
                                                <div class="col-sm-6">
                                                    <?php
                                                    $data = [];
                                                    $value = '';
                                                    if(isset($filters['teamID']) && $filters['teamID']){
                                                        $data = [$filters['teamID'] => $filters['teamID']];
                                                        $value = $filters['teamID'];
                                                    }
                                                    echo Select2::widget([
                                                        'name' => 'teamID',
                                                        'value' => $value,
                                                        'data' => $data,
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
                                                    $data = [];
                                                    $value = '';
                                                    if(isset($filters['officeName']) && $filters['officeName']){
                                                        $data = [$filters['officeName'] => $filters['officeName']];
                                                        $value = $filters['officeName'];
                                                    }
                                                    echo Select2::widget([
                                                        'name' => 'officeName',
                                                        'value' => $value,
                                                        'data' => $data,
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
                                                 $.post('" . Url::to(['agency/populate-children-by-name-json']) . "', {name:name}, function(response){
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
                                                    $data = [];
                                                    $value = '';
                                                    if(isset($filters['officeID']) && $filters['officeID']){
                                                        $data = [$filters['officeID'] => $filters['officeID']];
                                                        $value = $filters['officeID'];
                                                    }
                                                    echo Select2::widget([
                                                        'name' => 'officeID',
                                                        'value' => $value,
                                                        'data' => $data,
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
                                                 $.post('" . Url::to(['agency/populate-children-by-id-json']) . "', {id:id}, function(response){
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
                                                    $value = '';
                                                    $townData = [];
                                                    if(isset($filters['officeState']) && $filters['officeState']){
                                                        $value = $filters['officeState'];
                                                        $townData = ArrayHelper::map(LocationSuggestion::find()->select('city')->distinct()->where(['state' => $filters['officeState']])->orderBy(['city' => SORT_ASC])->all(), 'city', 'city');
                                                    }
                                                    echo Select2::widget([
                                                        'name' => 'officeState',
                                                        'value' => $value,
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
                                                    $value = '';
                                                    $areaData = [];
                                                    $zipData = [];
                                                    if(isset($filters['officeTown']) && $filters['officeTown']){
                                                        $value = $filters['officeTown'];
                                                        $areaData = ArrayHelper::map(LocationSuggestion::find()->select('area')->distinct()->where(['city' => $filters['officeTown']])->orderBy(['area' => SORT_ASC])->all(), 'area', 'area');
                                                        $zipData = ArrayHelper::map(LocationSuggestion::find()->select('zip_code')->distinct()->where(['city' => $filters['officeTown']])->orderBy(['zip_code' => SORT_ASC])->all(), 'zip_code', 'zip_code');
                                                    }
                                                    echo DepDrop::widget([
                                                        'name' => 'officeTown',
                                                        'value' => $value,
                                                        'data' => $townData,
                                                        'options' => ['placeholder' => 'Select Town', 'id' => 'team_search_office_town', 'class' => 'team_search_office_town search_item'],
                                                        'type' => DepDrop::TYPE_SELECT2,
                                                        'pluginOptions' => [
                                                            'depends' => ['team_search_office_state'],
                                                            'url' => Url::to(['/location-suggestion/get-towns']),
                                                            'placeholder' => 'Select Town'
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
                                                    $value = '';
                                                    if(isset($filters['officeArea']) && $filters['officeArea']){
                                                        $value = $filters['officeArea'];
                                                    }
                                                    echo DepDrop::widget([
                                                        'name' => 'officeArea',
                                                        'value' => $value,
                                                        'data' => $areaData,
                                                        'options' => ['placeholder' => 'Select Area', 'id' => 'team_search_office_area', 'class' => 'team_search_office_area search_item'],
                                                        'type' => DepDrop::TYPE_SELECT2,
                                                        'pluginOptions' => [
                                                            'depends' => ['team_search_office_town'],
                                                            'url' => Url::to(['/location-suggestion/get-areas']),
                                                            'placeholder' => 'Select Area'
                                                        ],
                                                        'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                                                    ]);
                                                    ?>
                                                </div>
                                                <div class="col-sm-6">
                                                    <?php
                                                    $value = '';
                                                    if(isset($filters['officeZipCode']) && $filters['officeZipCode']){
                                                        $value = $filters['officeZipCode'];
                                                    }
                                                    echo DepDrop::widget([
                                                        'name' => 'officeZipCode',
                                                        'value' => $value,
                                                        'data' => $zipData,
                                                        'options' => ['placeholder' => 'Select Zip Code', 'class' => 'team_search_office_zip_code search_item', 'id' => 'team_search_office_zip_code'],
                                                        'type' => DepDrop::TYPE_SELECT2,
                                                        'pluginOptions' => [
                                                            'depends' => ['team_search_office_town'],
                                                            'url' => Url::to(['/location-suggestion/get-zip-codes']),
                                                            'placeholder' => 'Select Zip Code'
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
                                                    <input name="officeMobile" class="form-control team_search_office_mobile search_item" placeholder="Office Mobile" type="text">
                                                </div>

                                                <div class="col-sm-6">
                                                    <input name="officeEmail" class="form-control team_search_office_email search_item" placeholder="Office Email Address" type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group text-center">
                                            <button name="" type="button" class="btn btn-default gray-btn btn_filter_by_more_options_reset">Reset</button>
                                            <button name="" type="button" class="btn btn-default gray-btn btn_filter_by_more_options_cancel">Cancel</button>
                                            <button name="" type="submit" class="btn btn-default red-btn btn_filter_by_more_options">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$js = "$(function(){
            $('.txt_team_suggestion').val('".(isset($filters['name'])?$filters['name']:'')."');
        });";

$this->registerJs($js, View::POS_END);
?>