<?php
use kartik\typeahead\Typeahead;
use yii\web\JsExpression;
use yii\helpers\Url;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// Defines a custom template with a <code>Handlebars</code> compiler for rendering suggestions
$template = '<div><p class="repo-language">{{language}}</p>' .
    '<p class="repo-name">{{value}}</p>' .
    '<p class="repo-description">{{email}}</p></div>';

echo Typeahead::widget([
    'name' => 'location_suggestion', 
    'options' => ['placeholder' => 'Leaving From','class' => 'form-control txt_from_location'],
    'dataset' => [
        [
            'remote' => [
                'url' => Url::to(['/location-suggestion']) . '?q=%QUERY',
                'wildcard' => '%QUERY'
            ],
            'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
            'display' => 'value',
            'templates' => [
                'notFound' => '<div class="text-danger" style="padding:0 8px">Unable to find any location for selected query.</div>',
                'suggestion' => new JsExpression("Handlebars.compile('{$template}')")
            ],
            'limit' => 20
        ]
    ],
    'pluginEvents' => [
        "typeahead:select" => "function(e, data) {
            console.log(data);
            $('.package_search_location_from').val(data.id);
        }"
    ]
]);