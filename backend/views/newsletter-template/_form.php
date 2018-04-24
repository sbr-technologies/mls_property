<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use dosamigos\tinymce\TinyMce;
use yii\web\View;
use yii\helpers\ArrayHelper;
use common\models\NewsletterTemplateVarMaster;

/* @var $this yii\web\View */
/* @var $model common\models\EmailTemplates */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="email-templates-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type')->dropDownList(['user' => 'User', 'subscriber' => 'Subscriber'], ['prompt' => 'Select recipient type']) ?>
    
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

    <?=
    $form->field($model, 'content')->widget(TinyMce::className(), [
        'clientOptions' => [
            'plugins' => [
                "advlist autolink lists link charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste"
            ],
            'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | languages",
        ],
        'options' => ['rows' => 12],
    ]);
    ?>
    
    <?= $form->field($model, 'variableList')->dropDownList(
            ArrayHelper::map(NewsletterTemplateVarMaster::find()->select('variable, title')->where(['status' => 'active'])->all(), 'variable', 'title'), ['prompt' => Yii::t('app', 'Select template variable')]);?>
    
    <?= $form->field($model, 'status')->dropDownList([$model::STATUS_ACTIVE => 'Active', $model::STATUS_INACTIVE => 'Inactive'],['prompt' => 'Select Status']) ?>
  
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

$js = "jQuery(function($){
    $('#newslettertemplate-variablelist').on('change', function(){
        if($(this).val()){
            tinymce.activeEditor.execCommand('mceInsertContent', false, $(this).val());
            $(this).val('');
        }
    });
    });";
$this->registerJs($js, View::POS_END, 'cms-script');