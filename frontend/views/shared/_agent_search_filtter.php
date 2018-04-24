<?php
use kartik\typeahead\Typeahead;
use yii\web\JsExpression;
use yii\helpers\Url;
use yii\web\View;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use common\models\LocationSuggestion;
use yii\helpers\Html;

//print_r($filters);die();

$this->registerJsFile(
    '@web/plugins/underscore.js',
    ['depends' => [
        \yii\web\JqueryAsset::className(),
        \yii\bootstrap\BootstrapPluginAsset::ClassName()
        ]
   ]
);

$this->registerJsFile(
    '@web/public_main/js/agent_search.js',
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
                <form action="<?= Url::to(['/agent-search-result'])?>" role="search" class="frm_search_result_page_search" id="frm_search_result_page_search">
                <div class="hotel-listing-form">
                    <input type="hidden" class="txt_filter_agent_rating search_item" value="" name="avg_rating" />
                        <input type="hidden" class="txt_filter_agent_recommendation search_item" value="" name="total_recommendations" />
                        <input type="hidden" class="txt_filter_agent_worked_with search_item" value="" name="worked_with" />
                        <input type="hidden" class="hid_search_type" value="agent" />
                        <div class="form-group">
                            <?php
                            $template = '<div>' .
                                    '<p class="repo-name">{{value}}</p>' .
                                    '</div>';

                                echo Typeahead::widget([
                                    'name' => 'agent_suggestion', 
                                    'options' => ['placeholder' => 'Enter Name of Agent', 'class' => 'txt_agent_suggestion', 'id' => 'txt_agent_suggestion'],
                                    'dataset' => [
                                        [
                                            'remote' => [
                                                'url' => Url::to(['/agent-suggestion']) . '?q=%QUERY',
                                                'wildcard' => '%QUERY'
                                            ],
                                            'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                                            'display' => 'value',
                                            'templates' => [
                                                'notFound' => '<div class="text-danger" style="padding:0 8px">Unable to find any Agent for selected query.</div>',
                                                'suggestion' => new JsExpression("Handlebars.compile('{$template}')")
                                            ],
                                            'limit' => 20
                                        ]
                                    ],
                                    'pluginEvents' => [
                                        "typeahead:select" => "function(e, data) {
                                            console.log(data);
                                            var newName = new Option(data.value, data.value, true, true);
                                            $('#agent_search_agent_name').append(newName).trigger('change');
                                        }"
                                    ]
                                ]);
                            ?>
                        </div>
                        <button class="btn btn-default save-search-btn" type="submit">Search</button>
                </div>
                <div class="property-menu-list">
                    <div class="dropdown">
                      <button class="dropdown-toggle btn_filter_by_rating" type="button" data-toggle="dropdown"><span class="btntext">Rating</span>
                            <span class="caret"></span></button>
                        <div class="dropdown-menu filter_agent_by_rating">
                            <ul>
                                <li>
                                  <a href="javascript:void(0)" data-value="">Any</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"  data-value="1">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>    
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" data-value="2">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>    
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" data-value="3">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>    
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" data-value="4">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>    
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" data-value="5">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>    
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="dropdown">
                      <button class="dropdown-toggle btn_filter_by_recommendation" type="button" data-toggle="dropdown"><span class="btntext">Recommendation</span>
                            <span class="caret"></span></button>
                        <div class="dropdown-menu filter_agent_by_recommendation">
                            <ul>
                                <li><a href="javascript:void(0)" data-value="">Any</a></li>
                                <li><a href="javascript:void(0)" data-value="1">1+</a></li>
                                <li><a href="javascript:void(0)" data-value="5">5+</a></li>
                                <li><a href="javascript:void(0)" data-value="10">10+</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="dropdown any-price-menu">
                          <button class="dropdown-toggle btn_filter_by_price" type="button" data-toggle="dropdown"><span class="btntext">Any Price</span>
                                <span class="caret"></span>
                            </button>
                            <div class="dropdown-menu">
                                <div class="form-inline">
                                    <div class="row">
                                        <div class="col-sm-5 pright">
                                            <div class="input-group">
                                                <span class="input-group-addon">$</span>
                                                <input type="text" name="min_price" class="form-control txt_filter_min_price search_item" placeholder="No Min">
                                            </div>
                                        </div>

                                        <div class="col-sm-1 pleft pright text-center">-</div>

                                        <div class="col-sm-5 pleft">
                                            <div class="input-group">
                                                <span class="input-group-addon">$</span>
                                                <input type="text" name="max_price" class="form-control txt_filter_max_price search_item" placeholder="No Max">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown-divider"></div>
                                <ul class="pull-left min_price_option_group">
                                    <li><a href="javascript:void(0)" data-val="">N0</a></li>
                                    <li><a href="javascript:void(0)" data-val="100000">N100K</a></li>
                                    <li><a href="javascript:void(0)" data-val="250000">N250K</a></li>
                                    <li><a href="javascript:void(0)" data-val="500000">N500K</a></li>
                                    <li><a href="javascript:void(0)" data-val="750000">N750K</a></li>
                                    <li><a href="javascript:void(0)" data-val="1000000">N1M</a></li>
                                    <li><a href="javascript:void(0)" data-val="2000000">N2M</a></li>
                                    <li><a href="javascript:void(0)" data-val="5000000">N5M</a></li>
                                    <li><a href="javascript:void(0)" data-val="10000000">N10M</a></li>
                                    <li><a href="javascript:void(0)" data-val="20000000">N20M</a></li>
                                    <li><a href="javascript:void(0)" data-val="40000000">N40M</a></li>
                                    <li><a href="javascript:void(0)" data-val="50000000">N50M</a></li>
                                    <li><a href="javascript:void(0)" data-val="60000000">N60M</a></li>
                                    <li><a href="javascript:void(0)" data-val="80000000">N80M</a></li>
                                    <li><a href="javascript:void(0)" data-val="100000000">N100M</a></li>
                                </ul>
                                
                                <ul class="pull-right max_price_option_group" style="visibility: hidden;">
                                    <li><a href="javascript:void(0)" data-val="">N0</a></li>
                                    <li><a href="javascript:void(0)" data-val="100000">N100K</a></li>
                                    <li><a href="javascript:void(0)" data-val="250000">N250K</a></li>
                                    <li><a href="javascript:void(0)" data-val="500000">N500K</a></li>
                                    <li><a href="javascript:void(0)" data-val="750000">N750K</a></li>
                                    <li><a href="javascript:void(0)" data-val="1000000">N1M</a></li>
                                    <li><a href="javascript:void(0)" data-val="2000000">N2M</a></li>
                                    <li><a href="javascript:void(0)" data-val="5000000">N5M</a></li>
                                    <li><a href="javascript:void(0)" data-val="10000000">N10M</a></li>
                                    <li><a href="javascript:void(0)" data-val="20000000">N20M</a></li>
                                    <li><a href="javascript:void(0)" data-val="40000000">N40M</a></li>
                                    <li><a href="javascript:void(0)" data-val="50000000">N50M</a></li>
                                    <li><a href="javascript:void(0)" data-val="60000000">N60M</a></li>
                                    <li><a href="javascript:void(0)" data-val="80000000">N80M</a></li>
                                    <li><a href="javascript:void(0)" data-val="100000000">N100M</a></li>
                                    <li><a href="javascript:void(0)" data-val="">Any</a></li>
                                </ul>
                            </div>
                        </div>

                    <div class="dropdown">
                      <button class="dropdown-toggle btn_filter_by_worked_with" type="button" data-toggle="dropdown"><span class="btntext">Worked With</span>
                            <span class="caret"></span></button>
                        <div class="dropdown-menu filter_agent_by_worked_with">
                            <ul>
                                <li><a href="javascript:void(0)" data-value="">None</a></li>
                                <li><a href="javascript:void(0)" data-value="1">Buyers and Sellers</a></li>
                                <li><a href="javascript:void(0)" data-value="2">Buyers</a></li>
                                <li><a href="javascript:void(0)" data-value="3">Sellers</a></li>
                            </ul>
                        </div>
                    </div>
                  
                  <div class="dropdown property-type-menu property_type_dropdown">
                    <button class="dropdown-toggle btn_filter_by_prop_type" type="button" data-toggle="dropdown"><span class="btntext">Property Type</span>
                      <span class="caret"></span></button>
                    <div class="dropdown-menu">
                      <ul class="property_type_option_group">
                        <li>
                          <?php
                          $propertyTypes = \common\models\PropertyType::find()->active()->all();
                          foreach ($propertyTypes as $type) {
                              ?>
                              <div class="custom-check-radio">
                                <label>
                                  <input type="checkbox" value="<?= $type->id ?>" data-text_val="<?= $type->title ?>" name="chk_filter_property_type[]" class="chk_filter_property_type">
                                  <span class="lbl"><?= $type->title ?></span>
                                </label>
                              </div>
                          <?php } ?>
                        </li>
                      </ul>
                    </div>
                  </div>
                  
                    <div class="dropdown property_more_filters">
                        <button class="dropdown-toggle btn_filter_by_more" type="button"><span class="btntext">More Filters</span>
                            <span class="caret"></span></button>
                        <div class="dropdown-menu">
                            <div class="form-sec">
                                <div class="row">
                                    <div class="form-group">
                                    <h5>Agent Information</h5>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <?php
                                                $data = [];
                                                $value = '';
                                                if(isset($filters['name']) && $filters['name'] && isset($filters['nameText'])){
                                                    $data = [$filters['name'] => $filters['nameText']];
                                                    $value = $filters['name'];
                                                }
                                                echo Select2::widget([
                                                    'name' => 'name',
                                                    'value' => $value,
                                                    'data' => $data,
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
                                                                    $('#txt_agent_suggestion').val(result.name);
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
                                                                    
                                                                    var team = result.team;
                                                                    if(team.name){
                                                                        var newName = new Option(team.name, team.name, true, true);
                                                                        $('#agent_search_team_name').append(newName).trigger('change');
                                                                    }
                                                                    if(team.id){
                                                                        var newID = new Option(team.id, team.id, true, true);
                                                                        $('#agent_search_team_id').append(newID).trigger('change');
                                                                    }

                                                                }
                                                            }, 'json');
                                                        }",
                                                        'select2:unselect' => "function(){
                                                            $('#txt_agent_suggestion').val('');
                                                        }"
                                                    ]
                                                ]);
                                                ?>
                                            </div>
                                            <div class="col-sm-6">
                                                <?php
                                                $data = [];
                                                $value = '';
                                                if(isset($filters['agentID']) && $filters['agentID'] && isset($filters['agentIDText'])){
                                                    $data = [$filters['agentID'] => $filters['agentIDText']];
                                                    $value = $filters['agentID'];
                                                }
                                                echo Select2::widget([
                                                    'name' => 'agentID',
                                                    'value' => $value,
                                                    'data' => $data,
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
                                                    $('#txt_agent_suggestion').val(result.name);
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
                                                    
                                                    var team = result.team;
                                                    if(team.name){
                                                        var newName = new Option(team.name, team.name, true, true);
                                                        $('#agent_search_team_name').append(newName).trigger('change');
                                                    }
                                                    if(team.id){
                                                        var newID = new Option(team.id, team.id, true, true);
                                                        $('#agent_search_team_id').append(newID).trigger('change');
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
                                                if(isset($filters['state']) && $filters['state']){
                                                    $value = $filters['state'];
                                                    $townData = ArrayHelper::map(LocationSuggestion::find()->select('city')->distinct()->where(['state' => $filters['state']])->orderBy(['city' => SORT_ASC])->all(), 'city', 'city');
                                                }
                                                echo Select2::widget([
                                                    'name' => 'state',
                                                    'value' => $value,
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
                                                $value = '';
                                                $areaData = [];
                                                $zipData = [];
                                                if(isset($filters['town']) && $filters['town']){
                                                    $value = $filters['town'];
                                                    $areaData = ArrayHelper::map(LocationSuggestion::find()->select('area')->distinct()->where(['city' => $filters['town']])->orderBy(['area' => SORT_ASC])->all(), 'area', 'area');
                                                    $zipData = ArrayHelper::map(LocationSuggestion::find()->select('zip_code')->distinct()->where(['city' => $filters['town']])->orderBy(['zip_code' => SORT_ASC])->all(), 'zip_code', 'zip_code');
                                                }
                                                echo DepDrop::widget([
                                                    'name' => 'town',
                                                    'value' => $value,
                                                    'data' => $townData,
                                                    'options' => ['placeholder' => 'Select Town', 'id' => 'agent_search_agent_town', 'class' => 'agent_search_agent_town search_item'],
                                                    'type' => DepDrop::TYPE_SELECT2,
                                                    'pluginOptions' => [
                                                        'depends' => ['agent_search_agent_state'],
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
                                                $value = '';
                                                if(isset($filters['area']) && $filters['area']){
                                                    $value = $filters['area'];
                                                }
                                                echo DepDrop::widget([
                                                    'name' => 'area',
                                                    'value' => $value,
                                                    'data' => $areaData,
                                                    'options' => ['placeholder' => 'Select Area', 'id' => 'agent_search_agent_area', 'class' => 'agent_search_agent_area search_item'],
                                                    'type' => DepDrop::TYPE_SELECT2,
                                                    'pluginOptions' => [
                                                        'depends' => ['agent_search_agent_town'],
                                                        'placeholder' => 'Select Area',
                                                        'url' => Url::to(['/location-suggestion/get-areas'])
                                                    ],
                                                    'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                                                ]);
                                                ?>
                                            </div>
                                            <div class="col-sm-6">
                                                <?php
                                                $value = '';
                                                if(isset($filters['zip_code']) && $filters['zip_code']){
                                                    $value = $filters['zip_code'];
                                                }
                                                echo DepDrop::widget([
                                                    'name' => 'zip_code',
                                                    'value' => $value,
                                                    'data' => $zipData,
                                                    'options' => ['placeholder' => 'Select Zip Code', 'class' => 'agent_search_agent_zip_code search_item', 'id' => 'agent_search_agent_zip_code'],
                                                    'type' => DepDrop::TYPE_SELECT2,
                                                    'pluginOptions' => [
                                                        'depends' => ['agent_search_agent_town'],
                                                        'placeholder' => 'Select Zip Code',
                                                        'url' => Url::to(['/location-suggestion/get-zip-codes'])
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
                                                <?= Html::textInput('email', '', ['class' => 'agent_search_agent_email form-control search_item', 'placeholder' => 'Email Address']) ?>
                                            </div>

                                            <div class="col-sm-6">
                                                <?= Html::textInput('mobile1', '', ['class' => 'agent_search_agent_mobile form-control search_item', 'placeholder' => 'Mobile Number']) ?>
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
                                                if(isset($filters['officeName']) && $filters['officeName'] && isset($filters['officeNameText'])){
                                                    $data = [$filters['officeName'] => $filters['officeNameText']];
                                                    $value = $filters['officeName'];
                                                }
                                                echo Select2::widget([
                                                    'name' => 'officeName',
                                                    'value' => $value,
                                                    'data' => $data,
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
                                                 $.post('" . Url::to(['agency/populate-children-by-name-json']) . "', {name:name}, function(response){
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
                                                $data = [];
                                                $value = '';
                                                if(isset($filters['officeID']) && $filters['officeID'] && isset($filters['officeIDText'])){
                                                    $data = [$filters['officeID'] => $filters['officeIDText']];
                                                    $value = $filters['officeID'];
                                                }
                                                echo Select2::widget([
                                                    'name' => 'officeID',
                                                    'value' => $value,
                                                    'data' => $data,
                                                    'maintainOrder' => true,
                                                    'options' => ['placeholder' => 'Office ID', 'multiple' => false, 'class' => 'agent_search_office_id search_item', 'id' => 'agent_search_office_id'],
                                                    'pluginOptions' => [
                                                        'maximumInputLength' => 10,
                                                        'allowClear' => true,
                                                        'minimumInputLength' => 3,
                                                        'ajax' => [
                                                            'url' => Url::to(['/agency/search-by-name-id-json']),
                                                            'dataType' => 'json',
                                                            'data' => new JsExpression('function(term,page) { return {search:term, parent:$("#agent_search_office_name").val()}; }'),
                                                            'results' => new JsExpression('function(data,page) { return {results:data.results}; }'),
                                                        ]
                                                    ],
                                                    'pluginEvents' => [
                                                        "select2:select" => "function() {
                                                            var id = $('#agent_search_office_id').val();
                                                            $.post('" . Url::to(['agency/populate-children-by-id-json']) . "', {id:id}, function(response){
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
                                                    'options' => ['placeholder' => 'Select Office Town', 'id' => 'agent_search_office_town', 'class' => 'agent_search_office_town search_item'],
                                                    'type' => DepDrop::TYPE_SELECT2,
                                                    'pluginOptions' => [
                                                        'depends' => ['agent_search_office_state'],
                                                        'placeholder' => 'Select Office Town',
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
                                                $value = '';
                                                if(isset($filters['officeArea']) && $filters['officeArea']){
                                                    $value = $filters['officeArea'];
                                                }
                                                echo DepDrop::widget([
                                                    'name' => 'officeArea',
                                                    'value' => $value,
                                                    'data' => $areaData,
                                                    'options' => ['placeholder' => 'Select Office Area', 'id' => 'agent_search_office_area', 'class' => 'agent_search_office_area search_item'],
                                                    'type' => DepDrop::TYPE_SELECT2,
                                                    'pluginOptions' => [
                                                        'depends' => ['agent_search_office_town'],
                                                        'placeholder' => 'Select Office Area',
                                                        'url' => Url::to(['/location-suggestion/get-areas'])
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
                                                    'options' => ['placeholder' => 'Select Office Zip Code', 'class' => 'agent_search_office_zip_code search_item', 'id' => 'agent_search_office_zip_code'],
                                                    'type' => DepDrop::TYPE_SELECT2,
                                                    'pluginOptions' => [
                                                        'depends' => ['agent_search_office_town'],
                                                        'placeholder' => 'Select Office Zip Code',
                                                        'url' => Url::to(['/location-suggestion/get-zip-codes'])
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
                                                <?= Html::textInput('officeEmail', '', ['class' => 'search_agent_email form-control search_item', 'placeholder' => 'Office Email Address']) ?>
                                            </div>

                                            <div class="col-sm-6">
                                                <?= Html::textInput('officePhone1', '', ['class' => 'search_agent_phone form-control search_item', 'placeholder' => 'Office Phone']) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                    <h5>Team Information</h5>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <?php
                                                echo Select2::widget([
                                                    'name' => 'teamName',
                                                    'maintainOrder' => true,
                                                    'options' => ['placeholder' => 'Team Name', 'multiple' => false, 'class' => 'agent_search_team_name search_item', 'id' => 'agent_search_team_name'],
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
                                                     var name = $('#agent_search_team_name').find('option:selected').text();
                                                     $.post('" . Url::to(['/team/populate-children-by-name-json']) . "', {name:name}, function(response){
                                                        if(response.result){
                                                            var result = response.result;
                                                            var newID = new Option(result.text, result.id, true, true);
                                                            $('#agent_search_team_id').append(newID).trigger('change');
                                                            
                                                            var office = result.office;
                                                            var newOfficeName = new Option(office.name, office.name, true, true);
                                                            $('#team_search_office_name').append(newOfficeName).trigger('change');
                                                            var newOfficeID = new Option(office.id, office.id, true, true);
                                                            $('#team_search_office_id').append(newOfficeID).trigger('change');
                                                            
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
                                                    'options' => ['placeholder' => 'Team ID', 'multiple' => false, 'class' => 'agent_search_team_id search_item', 'id' => 'agent_search_team_id'],
                                                    'pluginOptions' => [
                                                        'maximumInputLength' => 10,
                                                        'allowClear' => true,
                                                        'minimumInputLength' => 3,
                                                        'ajax' => [
                                                            'url' => Url::to(['/team/search-by-name-id-json']),
                                                            'dataType' => 'json',
                                                            'data' => new JsExpression('function(term,page) { return {search:term, parent:$("#agent_search_team_name").val()}; }'),
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
                                                            var newOfficeName = new Option(office.name, office.id, true, true);
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
                                    <div class="form-group text-center">
                                        <button name="" type="button" class="btn btn-default gray-btn btn_filter_by_more_options_reset">Reset</button>
                                        <button name="" type="button" class="btn btn-default gray-btn btn_filter_by_more_options_cancel">Cancel</button>
                                        <button name="" type="button" class="btn btn-default red-btn btn_filter_by_more_options">Search</button>
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
        $('#txt_agent_suggestion').val('".(isset($filters['name'])?$filters['name']:'')."');
    });";

$this->registerJs($js, View::POS_END);