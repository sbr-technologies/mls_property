<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\tinymce\TinyMce;
use common\models\StaticBlockLocationMaster;

/* @var $this yii\web\View */
/* @var $model common\models\StaticBlock */
/* @var $form yii\widgets\ActiveForm */
?>
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#blockDetails" aria-controls="blockDetails" role="tab" data-toggle="tab">Block Details</a></li>
    <li role="presentation"><a href="#blockImageInfo" aria-controls="blockImageInfo" role="tab" data-toggle="tab">Block Image</a></li>
</ul>
<?php $form = ActiveForm::begin(); ?>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="blockDetails">
            <div class="static-block-form">
                <?= $form->field($model, 'block_location_id')->dropDownList(ArrayHelper::map(StaticBlockLocationMaster::find()->all(), 'id', 'title'), ['prompt' => 'Select Static Block']) ?>
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

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

                <?= $form->field($model, 'status')->dropDownList([$model::STATUS_ACTIVE => 'Active', $model::STATUS_INACTIVE => 'Inactive'],['prompt' => 'Select Status']) ?>

                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="blockImageInfo">
            <div class="static-block-form">
                <?= $form->field($model, 'imageFiles[]')->fileInput(['accept' => 'image/*']) ?>
                <?php
                    echo $this->render('//shared/_photo-gallery', ['model' => $model, 'single' => true]);
                ?>
                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
    </div>
                
    
<?php ActiveForm::end(); ?>
