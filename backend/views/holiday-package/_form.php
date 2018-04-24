<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&key=<?= Yii::$app->params['googleMapKey']?>"></script>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\HolidayPackageCategory;
use kartik\datetime\DateTimePicker;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use common\models\User;
use common\models\Profile;
use kartik\select2\Select2;
use yii\web\JsExpression;
use common\models\HolidayPackageType;
use common\models\CurrencyMaster;

/* @var $this yii\web\View */
/* @var $model common\models\HolidayPackage */
/* @var $form yii\widgets\ActiveForm */

$this->registerJsFile(
    '@web/js/holiday-package.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#packageDetails" aria-controls="packageDetails" role="tab" data-toggle="tab">Package Details</a></li>
    <li role="presentation"><a href="#packageLocation" aria-controls="packageLocation" role="tab" data-toggle="tab">Package Location</a></li>
    <li role="presentation"><a href="#ImageInfo" aria-controls="localInfo" role="tab" data-toggle="tab">Holiday Package Image</a></li>
    <li role="presentation"><a href="#metaTag" aria-controls="metaTag" role="tab" data-toggle="tab">Meta Tag</a></li>
    <li role="presentation"><a href="#packageFeature" aria-controls="packageFeature" role="tab" data-toggle="tab">Package Feature</a></li>
</ul>
<?php $form = ActiveForm::begin(['options' => ['class' => 'frm_geocomplete']]); ?>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="packageDetails">
            <div class="holiday-package-form">
                <?= $form->field($model, 'profile_id')->dropDownList(ArrayHelper::map(Profile::find()->where(['not in', 'id', [1,2,3,4]])->all(), 'id', 'title'), ['prompt' => 'Select User type','id' => 'profile_id']) ?>
                
                <?php
                echo $form->field($model, 'user_id')->widget(Select2::classname(), [
                    'initValueText' => ($model->isNewRecord? '': $model->user->fullName), // set the initial display text
                    'options' => ['placeholder' => 'Search for a User ...'],
//                    'disabled' => true,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 3,
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                        ],
                        'ajax' => [
                            'url' => Url::to(['user/index']),
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term, type:"d", profile_id:$("#profile_id").val()}; }')
                        ],
                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                        'templateResult' => new JsExpression('function(city) { return city.text; }'),
                        'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                    ],
                ]);
                ?>
                <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(HolidayPackageCategory::find()->all(), 'id', 'title'), ['prompt' => 'Select Package']) ?>

                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

                <?= $form->field($model, 'currency_id')->dropDownList(ArrayHelper::map(CurrencyMaster::find()->active()->all(), 'id', 'name')) ?>
                
                <?= $form->field($model, 'package_amount')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'no_of_days')->textInput() ?>

                <?= $form->field($model, 'no_of_nights')->textInput() ?>

                <?= $form->field($model, 'hotel_transport_info')->textarea(['rows' => 6]) ?>

                <?php echo $form->field($model, 'departureDate')->widget(DateTimePicker::classname(), [
                    'options' => ['placeholder' => 'Check In'],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => Yii::$app->params['dateTimeFormatJs'],
                    ]
                ]);?>

                <?= $form->field($model, 'inclusion')->textarea(['rows' => 6]) ?>

                <?= $form->field($model, 'exclusions')->textarea(['rows' => 6]) ?>

                <?= $form->field($model, 'payment_policy')->textarea(['rows' => 6]) ?>

                <?= $form->field($model, 'cancellation_policy')->textarea(['rows' => 6]) ?>

                <?= $form->field($model, 'status')->dropDownList([$model::STATUS_ACTIVE => 'Active', $model::STATUS_INACTIVE => 'Inactive'],['prompt' => 'Select Status']) ?>

            </div>
        </div>
        
        <div role="tabpanel" class="tab-pane" id="packageLocation">
            <div class="hotel-form">
                <?php 
                    echo $this->render('_holiday-source-address', ['model' => $model, 'form' => $form]);
                ?>
                <?php 
                    echo $this->render('_holiday-destination-address', ['model' => $model, 'form' => $form]);
                ?>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="ImageInfo">
            <div class="hotel-form">

                <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>

                <?php 
                    echo $this->render('//shared/_photo-gallery', ['model' => $model]);
                ?>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="metaTag">
            <?php echo $this->render('//shared/_meta-form', ['metaTagModel' => $metaTagModel, 'form' => $form])?>
        </div>
        <div role="tabpanel" class="tab-pane" id="packageFeature">
            <?php
                if($model->isNewRecord){   
                    echo $this->render('_package-feature-form', ['packageFeatureItem'=>  $packageFeatureItem,'packageFeature' => $packageFeature, 'form' => $form]);
                }else{
                    echo $this->render('_package-feature-form', ['model' => $model, 'packageFeature' => $packageFeature, 'form' => $form]);
                }
            ?>
        </div>
        
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>

<?php

$tempFeatrue    =   new \common\models\HolidayPackageFeature();
$tempItem       =   new \common\models\HolidayPackageFeatureItem();
?>
<div style="display: none" class="dv_holiday_feature_block_template">
    <div class="item new">
        <?= Html::activeHiddenInput($tempFeatrue, '[curTime]id')?>
        <div class="form-group">
            <?= Html::activeLabel($tempFeatrue, '[curTime]holiday_package_type_id')?>
            <?= Html::activeDropDownList($tempFeatrue, '[curTime]holiday_package_type_id', ArrayHelper::map(HolidayPackageType::find()->all(), 'id', 'name'), ['prompt' => 'Select Feature', 'class' => 'form-control'])?>
        </div>
        <div class="form-group">
            <?= Html::activeHiddenInput($tempItem, '[curTime][1]id')?>
            <?= Html::activeLabel($tempItem, '[curTime][1]name')?>
            <?= Html::activeTextInput($tempItem, '[curTime][1]name', ['class' => 'form-control'])?>
        </div>
        <div class="form-group">
            <?= Html::activeHiddenInput($tempItem, '[curTime][2]id')?>
            <?= Html::activeLabel($tempItem, '[curTime][2]name')?>
            <?= Html::activeTextInput($tempItem, '[curTime][2]name', ['class' => 'form-control'])?>
        </div>
        <div class="form-group">
            <?= Html::activeHiddenInput($tempItem, '[curTime][3]id')?>
            <?= Html::activeLabel($tempItem, '[curTime][3]name')?>
            <?= Html::activeTextInput($tempItem, '[curTime][3]name', ['class' => 'form-control'])?>
        </div>
        <div class="form-group">
            <?= Html::activeHiddenInput($tempItem, '[curTime][4]id')?>
            <?= Html::activeLabel($tempItem, '[curTime][4]name')?>
            <?= Html::activeTextInput($tempItem, '[curTime][4]name', ['class' => 'form-control'])?>
        </div>
        <div class="form-group">
            <?= Html::activeHiddenInput($tempItem, '[curTime][5]id')?>
            <?= Html::activeLabel($tempItem, '[curTime][5]name')?>
            <?= Html::activeTextInput($tempItem, '[curTime][5]name', ['class' => 'form-control'])?>
        </div>
        <div class="">
          <?= Html::activeHiddenInput($tempFeatrue, "[curTime]_destroy", ['class' => 'hidin_child_id']) ?>
          <a data-toggle="tooltip" class="btn btn_check_payment tooltip-test delete_child" title="" data-original-title="<?= Yii::t('app', 'Delete row') ?>"><i class="fa fa-trash-o"></i></a>
        </div>
    </div>
</div>

