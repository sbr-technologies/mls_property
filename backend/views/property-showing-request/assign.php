<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use yii\helpers\Url;
use kartik\typeahead\Typeahead;
use yii\helpers\Html;

use common\models\Profile;

$this->title = 'Property showing request assingment';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Properties'), 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Assign';
?>
<div class="property-request-assign-view">
    <div>
        <?php $form = ActiveForm::begin(); ?>
        <?= Html::activeHiddenInput($model, 'user_id');?>
        <?= $form->field($model, 'profile_id')->dropDownList(ArrayHelper::map(Profile::find()->where(['in', 'id', [4,5]])->all(), 'id', 'title'), ['prompt' => 'Select User type','id' => 'profile_id']) ?>
        <?php
            $template = '<div><p class="repo-language">{{language}}</p>' .
                        '<p class="repo-name">{{value}}</p>' .
                        '<p class="repo-description">{{email}}</p></div>';
            echo $form->field($model, 'user_name')->widget(Typeahead::classname(), [
                'dataset' => [
                    [
                        'remote' => [
                            'url' => Url::to(['/user']),
//                            'wildcard' => '%QUERY',
                            'replace' => new JsExpression("function(url, uriEncodedQuery) {
                                val = $('#profile_id').val();
//                                if (!val) return url;
                                //correction here
                                return url + '&q='+ uriEncodedQuery +'&type=t' +'&profile_id=' + encodeURIComponent(val)
                            }")
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
                    console.log(data);
                    $('#propertyshowingrequest-user_id').val(data.id);
                }"
            ],
        'pluginOptions' => ['highlight' => true],
            'options' => ['placeholder' => 'Filter as you type ...'],
            ]);
        ?>
        <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Assing Agent/Seller'), ['class' =>'btn btn-success']) ?>
        </div>
      <?php ActiveForm::end()?>
    </div>
</div>


