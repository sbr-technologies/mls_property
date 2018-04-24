<?php
use kartik\typeahead\Typeahead;
use yii\web\JsExpression;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\helpers\Html;
?>
<div id="added_associated_sellers">
    <?php Pjax::begin(['id' => 'seller_pjax_container']); ?>    
    <?= GridView::widget([
        'dataProvider' => $agencyDataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            'team.name',
            'agency.name',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'buttons'   => [
                    'delete'    =>  
                    function ($url,$model) {
                        $class = 'fa fa-trash-o';
                        $title = 'Delete';
                        return Html::a(
                            '<span class="'.$class.'"></span>',Url::to(['team-agency-mapping/delete', 'id' => $model->id]), 
                            [
                                'title'         => $title,
                                'data-pjax'     => '0',
                                'onclick' => "if (confirm('Are you sure?')) {
                                    $.loading();
                                    $.ajax('".Url::to(['team-agency-mapping/delete', 'id' => $model->id])."', {
                                        type: 'POST'
                                    }).done(function(data) {
                                         $.loaded('Successfully deleted');
                                         $.pjax.reload({container: '#seller_pjax_container'});
                                    });
                                }
                                return false;",
                            ]
                        );
                    },
                ],
            ],
        ],
    ]);
    ?>
    <?php Pjax::end(); ?>
    
</div>
<?php
// Defines a custom template with a <code>Handlebars</code> compiler for rendering suggestions
echo '<label class="control-label">Select Agency</label>';
$template = '<div><p class="repo-language">{{language}}</p>' .
    '<p class="repo-name">{{value}}</p>' .
    '<p class="repo-description">{{owner}}</p></div>';

echo Typeahead::widget([
    'name' => 'twitter_oss', 
    'options' => ['placeholder' => 'Filter as you type ...'],
    'dataset' => [
        [
            'remote' => [
                'url' => Url::to(['team/agency-list']) . '&q=%QUERY',
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
            $.loading();
            console.log(data);
            $.post('". Url::to(['team-agency-mapping/create']). "', {team_id:$model->id, agency_id:data.id}, function(response){
                $.loaded('Successfully assigned');
                //$(response).appendTo('#added_associated_sellers');
                if(response.status == 'success'){
                    $.pjax.reload({container: '#seller_pjax_container'});
                    $('.tt-input').typeahead('val','');
                }else{
                    alert('This seller already assigned to this aggent');
                    $('.tt-input').typeahead('val','');
                }
            }, 'json');
        }"
    ]
]);