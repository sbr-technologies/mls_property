<?php
use kartik\typeahead\Typeahead;
use yii\web\JsExpression;
use yii\helpers\Url;
use yii\web\View;
use kartik\select2\Select2;
use common\models\LocationSuggestion;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
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
                <form action="<?= Url::to(['/agent-search-result/agency']) ?>" role="search" class="frm_search_result_page_search" id="frm_search_result_page_search">
                    <div class="hotel-listing-form">

                        <input type="hidden" class="txt_filter_agent_rating search_item" value="" name="avg_rating" />
                        <input type="hidden" class="txt_filter_agent_recommendation search_item" value="" name="total_recommendations" />
                        <input type="hidden" class="txt_filter_agent_worked_with search_item" value="" name="worked_with" />
                        <input type="hidden" class="hid_reset_address" value="0" />
                        <input type="hidden" class="hid_search_page" value="0" />
                        <input type="hidden" class="hid_search_type" value="agency" />
                        <div class="form-group">
                            <?php
                            $template = '<div><p class="repo-language">{{language}}</p>' .
                                    '<p class="repo-name">{{value}}</p>' .
                                    '<p class="repo-description">{{email}}</p></div>';

                            echo Typeahead::widget([
                                'name' => 'name',
                                'options' => ['placeholder' => 'Enter Name of Agency', 'class' => 'txt_agency_suggestion search_item', 'id' => 'office_search_name_suggestion'],
                                'dataset' => [
                                    [
                                        'remote' => [
                                            'url' => Url::to(['/agency-suggestion']) . '?q=%QUERY',
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
                                            $('#office_search_office_name').append(newName).trigger('change');
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
                        <div class="dropdown property_more_filters">
                            <button class="dropdown-toggle btn_filter_by_more" type="button"><span class="btntext">More Filters</span>
                            <span class="caret"></span></button>
                            <div class="dropdown-menu">
                                <div class="form-sec">
                                    <div class="row">
                                        <div class="form-group">
                                        <h5>Office Advanced Search</h5>
                                        </div>
                                        <div class="form-group ">
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
                                                        'options' => ['placeholder' => 'Office Name', 'multiple' => false, 'class' => 'office_search_office_name search_item', 'id' => 'office_search_office_name'],
                                                        'pluginOptions' => [
                                                            'maximumInputLength' => 10,
                                                            'allowClear' => true,
                                                            'minimumInputLength' => 3,
                                                            'ajax' => [
                                                                'url' => Url::to(['/agency/search-by-name-json']),
                                                                'dataType' => 'json',
                                                                'data' => new JsExpression('function(term,page) { return {search:term, parent:$("#office_search_name_suggestion").val()}; }'),
                                                                'results' => new JsExpression('function(data,page) { return {results:data.results}; }'),
                                                            ]
                                                        ],
                                                        'pluginEvents' => [
                                                        "select2:select" => "function() {
                                                        var name = $('#office_search_office_name').find('option:selected').text();
                                                        $.post('" . Url::to(['agency/populate-children-by-name-json']) . "', {name:name}, function(response){
                                                            if(response.result){
                                                                var result = response.result;
                                                                $('#office_search_name_suggestion').val(result.name);
                                                                
                                                                var newID = new Option(result.text, result.id, true, true);
                                                                $('#office_search_office_id').append(newID).trigger('change');

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
                                                    'select2:unselect' => "function(){
                                                        $('#office_search_name_suggestion').val('');
                                                    }"
                                                    ]
                                                ]);
                                                ?>
                                                </div>
                                                <div class="col-sm-6">
                                                    <?php
                                                    $data = [];
                                                    $value = '';
                                                    if(isset($filters['agencyID']) && $filters['agencyID'] && isset($filters['agencyIDText'])){
                                                        $data = [$filters['agencyID'] => $filters['agencyIDText']];
                                                        $value = $filters['agencyID'];
                                                    }
                                                    echo Select2::widget([
                                                        'name' => 'agencyID',
                                                        'value' => $value,
                                                        'data' => $data,
                                                        'maintainOrder' => true,
                                                        'options' => ['placeholder' => 'Office ID', 'multiple' => false, 'class' => 'office_search_office_id search_item', 'id' => 'office_search_office_id'],
                                                        'pluginOptions' => [
                                                            'maximumInputLength' => 10,
                                                            'allowClear' => true,
                                                            'minimumInputLength' => 3,
                                                            'ajax' => [
                                                                'url' => Url::to(['/agency/search-by-name-id-json']),
                                                                'dataType' => 'json',
                                                                'data' => new JsExpression('function(term,page) { return {search:term, parent:$("#office_search_name_suggestion").val()}; }'),
                                                                'results' => new JsExpression('function(data,page) { return {results:data.results}; }'),
                                                            ]
                                                        ],
                                                        'pluginEvents' => [
                                                        "select2:select" => "function() { 
                                                        var id = $('#office_search_office_id').find('option:selected').val();
                                                        $.post('" . Url::to(['agency/populate-children-by-id-json']) . "', {id:id}, function(response){
                                                            if(response.result){
                                                                var result = response.result;
                                                                $('#office_search_name_suggestion').val(result.name);
                                                                
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
                                                        'options' => ['placeholder' => 'Select Town', 'id' => 'office_search_office_town', 'class' => 'office_search_office_town search_item'],
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
                                                    $value = '';
                                                    if(isset($filters['area']) && $filters['area']){
                                                        $value = $filters['area'];
                                                    }
                                                    echo DepDrop::widget([
                                                        'name' => 'area',
                                                        'value' => $value,
                                                        'data' => $areaData,
                                                        'options' => ['placeholder' => 'Select Area', 'id' => 'office_search_office_area', 'class' => 'office_search_office_area search_item'],
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
                                                    $value = '';
                                                    if(isset($filters['zip_code']) && $filters['zip_code']){
                                                        $value = $filters['zip_code'];
                                                    }
                                                    echo DepDrop::widget([
                                                        'name' => 'zip_code',
                                                        'value' => $value,
                                                        'data' => $zipData,
                                                        'options' => ['placeholder' => 'Select Zip Code', 'id' => 'office_search_office_zip_code', 'class' => 'office_search_office_zip_code search_item'],
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
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <input class="form-control office_search_office_mobile search_item" value="" placeholder="Office Phone" type="text" name="office1">
                                                </div>

                                                <div class="col-sm-6">
                                                    <input class="form-control office_search_office_email search_item" value="" placeholder="Office Email Address" type="text" name="email">
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
                        <!--<a href="#" class="lnk_agent_search_more" data-toggle="modal" data-target="#modal_agent_more_search">More Filters</a>-->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
$js = "$(function(){
        $('#office_search_name_suggestion').val('".(isset($filters['name'])?$filters['name']:'')."');
    });";

$this->registerJs($js, View::POS_END);