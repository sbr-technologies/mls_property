<?php
use kartik\typeahead\Typeahead;
use yii\web\JsExpression;
use yii\helpers\Url;
use yii\web\View;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// Defines a custom template with a <code>Handlebars</code> compiler for rendering suggestions
$template = '<div class="location-suggestion-item"><p class="location-type">{{location_type}}</p>' .
    '<p class="location-name">{{value}}</p>' .
    '</div>';

$notFoundTemplate = '<div class="suggestion_location_notfound"><p>Unable to find any location for selected query.</p></div>';
$headerTemplate = '<div class="location-suggestion-header"><i class="fa fa-map-marker"></i> Places</div>';

echo Typeahead::widget([
    'name' => 'location_suggestion', 
    'options' => ['placeholder' => 'Pls enter Area, Town, State'],
//    'pluginOptions' => ['highlight' => true],
    'dataset' => [
        [
            'remote' => [
                'url' => Url::to(['/location-suggestion']) . '?q=%QUERY',
                'wildcard' => '%QUERY'
            ],
            'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
            'display' => 'value',
            'templates' => [
//                'notFound' => '<div class="text-danger" style="padding:0 8px">Unable to find any location for selected query.</div>',
                'notFound' => new JsExpression("Handlebars.compile('{$notFoundTemplate}')"),
                'suggestion' => new JsExpression("Handlebars.compile('{$template}')"),
                'header' => $headerTemplate
            ],
            'limit' => 20
        ]
    ],
    'pluginEvents' => [
        "typeahead:select" => "function(e, data) {
//            console.log(data);
            $('.realestate_search_location').val(data.value);
        }",
        "typeahead:beforeclose" => "function(e) {
            console.log(e.target);
//            if (!$(e.target).is(':focus')) {
//                return false;
//            }
            var target = e.target;
            if($(target).siblings('.tt-menu').find('.suggestion_location_notfound').length > 0){
                return false;
            }
        }"
    ]
]);

//$js = "$(function(){
//        $(document).on('click', '.close', function(){
//            $('#w0').typeahead('reset');
//        });
//    });";
//
//$this->registerJs($js, View::POS_END);