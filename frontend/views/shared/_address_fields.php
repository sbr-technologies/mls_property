<?php
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\LocationSuggestion;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
$className = Inflector::camel2id(StringHelper::basename(get_class($model)));
$idPrefix = $className;
$namePrefix = '';
if(isset($index) && $index !== null){
    $idPrefix = 'idx_'. $index.$idPrefix;
    $namePrefix = "[$index]";
}
?>
<div class="row">
    <div class="form-group col-sm-3">
        <?php
        echo $form->field($model, "{$namePrefix}country")->widget(Select2::classname(), [
            'data' => ['Nigeria' => 'Nigeria'],
            'options' => ['id' => $idPrefix. '_address_field_depdrop_country'],
            'pluginOptions' => [
                'allowClear' => false
            ],
        ]);
        ?>
    </div>
    <div class="form-group col-sm-3">
        <?php
        echo $form->field($model, "{$namePrefix}state")->widget(Select2::classname(), [
            'data' => ArrayHelper::map(LocationSuggestion::find()->select('state')->distinct()->orderBy(['state' => SORT_ASC])->all(), 'state', 'state'),
            'options' => ['id' => $idPrefix. '_address_field_depdrop_state'],
            'pluginOptions' => [
                'placeholder' => 'Select State',
                'allowClear' => false
            ],
        ]);
        ?>
        <?php
//        echo $form->field($model, 'state')->widget(Typeahead::classname(), [
//            'dataset' => [
//                [
//                    'remote' => [
//                        'url' => Url::to(['/location-suggestion/get-states']) . '?q=%QUERY&country=Nigeria',
//                        'wildcard' => '%QUERY'
//                    ],
//                    'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
//                    'display' => 'value',
//                    'limit' => 10
//                ]
//            ],
//            'pluginOptions' => ['highlight' => true],
//            'options' => ['placeholder' => 'Filter as you type ...'],
//        ]);
        ?>
    </div>
    <div class="form-group col-sm-3">
        <?php
        $tData = [];
        if($model->state){
            $tData = ArrayHelper::map(LocationSuggestion::find()->where(['state' => $model->state])->select('city')->distinct()->orderBy(['city' => SORT_ASC])->all(), 'city', 'city');
        }
        echo $form->field($model, "{$namePrefix}town")->widget(DepDrop::classname(), [
            'options' => ['id' => $idPrefix. '_address_field_depdrop_town'],
            'data' => $tData,
            'type'=>DepDrop::TYPE_SELECT2,
            'pluginOptions' => [
                'depends' => [$idPrefix. '_address_field_depdrop_state'],
                'placeholder' => 'Select Town',
                'url' => Url::to(['/location-suggestion/get-towns'])
            ]
        ]);
//        echo $form->field($model, 'town')->widget(Typeahead::classname(), [
//            'dataset' => [
//                [
//                    'remote' => [
//                        'url' => Url::to(['/location-suggestion/get-towns']) . '?q=%QUERY&state=',
//                        'wildcard' => '%QUERY',
//                        'replace' => new JsExpression("function (url, uriEncodedQuery) {
//                                                                    if ($('#property-state').val()) {
//                                                                        url += encodeURIComponent($('#property-state').val());
//                                                                    }
//                                                                    return url.replace('%QUERY', uriEncodedQuery);
//                                                                }"),
//                    ],
//                    'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
//                    'display' => 'value',
//                    'limit' => 10
//                ]
//            ],
//            'pluginOptions' => ['highlight' => true],
//            'options' => ['placeholder' => 'Filter as you type ...'],
//        ]);
        ?>
    </div>
    <div class="form-group col-sm-3">

        <?php
        $aData = [];
        if($model->town){
            $aData = ArrayHelper::map(LocationSuggestion::find()->where(['city' => $model->town])->andWhere(['not', ['area' => null]])->select('area')->distinct()->orderBy(['area' => SORT_ASC])->all(), 'area', 'area');
        }

        echo $form->field($model, "{$namePrefix}area", ['template' => '{input}', 'options' => ['tag' => null]])->hiddenInput(['value' => '']);
        echo $form->field($model, "{$namePrefix}area")->widget(DepDrop::classname(), [
            'options' => ['id' => $idPrefix. '_address_field_depdrop_area', 'placeholder' => 'Select Area'],
            'data' => $aData,
            'type' => DepDrop::TYPE_SELECT2,
            'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
            'pluginOptions' => [
                'depends' => [$idPrefix. '_address_field_depdrop_town'],
                'placeholder' => 'Select Area',
                'url' => Url::to(['/location-suggestion/get-areas']),
            ]
        ]);
//        echo $form->field($model, 'area')->widget(Typeahead::classname(), [
//            'dataset' => [
//                [
//                    'remote' => [
//                        'url' => Url::to(['/location-suggestion/get-areas']) . '?q=%QUERY&town=',
//                        'wildcard' => '%QUERY',
//                        'replace' => new JsExpression("function (url, uriEncodedQuery) {
//                                                                    if ($('#property-town').val()) {
//                                                                        url += encodeURIComponent($('#property-town').val());
//                                                                    }
//                                                                    return url.replace('%QUERY', uriEncodedQuery);
//                                                                }"),
//                    ],
//                    'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
//                    'display' => 'value',
//                    'limit' => 10
//                ]
//            ],
//            'pluginOptions' => ['highlight' => true],
//            'options' => ['placeholder' => 'Filter as you type ...'],
//        ]);
        ?>

    </div>
</div>
<div class="row">
    <div class="form-group col-sm-3">
        <?= $form->field($model, "{$namePrefix}street_address")->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'e.g Inner Block street']) ?>
    </div>
    <div class="form-group col-sm-3">
        <?= $form->field($model, "{$namePrefix}street_number")->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'e.g 1234']) ?>
    </div>
    <div class="form-group col-sm-3">
        <?= $form->field($model, "{$namePrefix}appartment_unit")->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'e.g 100']) ?>
    </div>
    <div class="form-group col-sm-3">
        <?= $form->field($model, "{$namePrefix}sub_area")->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
    </div>
</div>
<div class="row">
    <div class="form-group col-sm-3">
        <?php
        $zData = [];
        if($model->town){
            $zData = ArrayHelper::map(LocationSuggestion::find()->where(['city' => $model->town])->select('zip_code')->distinct()->orderBy(['zip_code' => SORT_ASC])->all(), 'zip_code', 'zip_code');
        }
//        print_r($zData);die();
        echo $form->field($model, "{$namePrefix}zip_code", ['template' => '{input}', 'options' => ['tag' => null]])->hiddenInput(['value' => '']);
        echo $form->field($model, "{$namePrefix}zip_code")->widget(DepDrop::classname(), [
            'options' => ['id' => $idPrefix. '_address_field_depdrop_zip_code', 'placeholder' => 'Select Zip Code'],
            'data' => $zData,
            'type' => DepDrop::TYPE_SELECT2,
            'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
            'pluginOptions' => [
                'depends' => [$idPrefix. '_address_field_depdrop_town'],
                'placeholder' => 'Select Zip Code',
                'url' => Url::to(['/location-suggestion/get-zip-codes']),
            ]
        ]);
//        echo $form->field($model, 'zip_code')->widget(Typeahead::classname(), [
//            'dataset' => [
//                [
//                    'remote' => [
//                        'url' => Url::to(['/location-suggestion/get-zip-codes']) . '?q=%QUERY&town=',
//                        'wildcard' => '%QUERY',
//                        'replace' => new JsExpression("function (url, uriEncodedQuery) {
//                                                                if ($('#property-town').val()) {
//                                                                    url += encodeURIComponent($('#property-town').val());
//                                                                }
//                                                                return url.replace('%QUERY', uriEncodedQuery);
//                                                            }"),
//                    ],
//                    'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
//                    'display' => 'value',
//                    'limit' => 10
//                ]
//            ],
//            'pluginOptions' => ['highlight' => true],
//            'options' => ['placeholder' => 'Filter as you type ...'],
//        ]);
        ?>
    </div>
    <div class="form-group col-sm-3">
        <?php
        $lgaData = [];
        if($model->state){
            $lgaData = ArrayHelper::map(LocationSuggestion::find()->where(['state' => $model->state])->andWhere(['not', ['local_government_area' => null]])->select('local_government_area')->distinct()->orderBy(['local_government_area' => SORT_ASC])->all(), 'local_government_area', 'local_government_area');
        }
        echo $form->field($model, "{$namePrefix}local_govt_area", ['template' => '{input}', 'options' => ['tag' => null]])->hiddenInput(['value' => '']);
        echo $form->field($model, "{$namePrefix}local_govt_area")->widget(DepDrop::classname(), [
            'options' => ['id' => $idPrefix. '_address_field_depdrop_local_govt_area', 'placeholder' => 'Select Locat Govt. Area',],
            'data' => $lgaData,
            'type' => DepDrop::TYPE_SELECT2,
            'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
            'pluginOptions' => [
                'depends' => [$idPrefix. '_address_field_depdrop_state'],
                'placeholder' => 'Select Locat Govt. Area',
                'url' => Url::to(['/location-suggestion/get-local-govt-area']),
            ]
        ]);
//        echo $form->field($model, 'local_govt_area')->widget(Typeahead::classname(), [
//            'dataset' => [
//                [
//                    'remote' => [
//                        'url' => Url::to(['/location-suggestion/get-local-govt-area']) . '?q=%QUERY&state=',
//                        'wildcard' => '%QUERY',
//                        'replace' => new JsExpression("function (url, uriEncodedQuery) {
//                                                                    if ($('#property-state').val()) {
//                                                                        url += encodeURIComponent($('#property-state').val());
//                                                                    }
//                                                                    return url.replace('%QUERY', uriEncodedQuery);
//                                                                }"),
//                    ],
//                    'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
//                    'display' => 'value',
//                    'limit' => 10
//                ]
//            ],
//            'pluginOptions' => ['highlight' => true],
//            'options' => ['placeholder' => 'Filter as you type ...'],
//        ]);
        ?>
        <span class="local_govt_area_or">OR</span>
    </div> 
    <div class="form-group col-sm-3">
        <?= $form->field($model, "{$namePrefix}urban_town_area")->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
    </div>
    <div class="form-group col-sm-3">
        <?php
        $dData = [];
        if($model->local_govt_area){
            $dData = ArrayHelper::map(LocationSuggestion::find()->where(['local_government_area' => $model->local_govt_area])->andWhere(['not', ['district' => null]])->select('district')->distinct()->orderBy(['district' => SORT_ASC])->all(), 'district', 'district');
        }
        echo $form->field($model, "{$namePrefix}district", ['template' => '{input}', 'options' => ['tag' => null]])->hiddenInput(['value' => '']);
        echo $form->field($model, "{$namePrefix}district")->widget(DepDrop::classname(), [
            'options' => ['id' => $idPrefix. '_address_field_depdrop_district', 'placeholder' => 'Select District'],
            'data' => $dData,
            'type' => DepDrop::TYPE_SELECT2,
            'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
            'pluginOptions' => [
                'depends' => [$idPrefix. '_address_field_depdrop_local_govt_area'],
                'placeholder' => 'Select District',
                'url' => Url::to(['/location-suggestion/get-districts']),
            ]
        ]);
//        echo $form->field($model, 'district')->widget(Typeahead::classname(), [
//            'dataset' => [
//                [
//                    'remote' => [
//                        'url' => Url::to(['/location-suggestion/get-districts']) . '?q=%QUERY&local_govt_area=',
//                        'wildcard' => '%QUERY',
//                        'replace' => new JsExpression("function (url, uriEncodedQuery) {
//                                                                    if ($('#property-local_govt_area').val()) {
//                                                                        url += encodeURIComponent($('#property-local_govt_area').val());
//                                                                    }
//                                                                    return url.replace('%QUERY', uriEncodedQuery);
//                                                                }"),
//                    ],
//                    'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
//                    'display' => 'value',
//                    'limit' => 10
//                ]
//            ],
//            'pluginOptions' => ['highlight' => true],
//            'options' => ['placeholder' => 'Filter as you type ...'],
//        ]);
        ?>
    </div>
</div>