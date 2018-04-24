<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Agent;
use frontend\helpers\AuthHelper;
use yii\web\View;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Contact */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="agent-contact-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'frm_geocomplete']]); ?>
    <h5>Personal and Contact Details:</h5>
    <?php if(AuthHelper::is('agency')){?>
        <?= $form->field($model, 'user_id')->dropDownList(ArrayHelper::map(Agent::find()->where(['agency_id' => Yii::$app->user->identity->agency->id])->all(), 'id', 'fullName')) ?>
    <?php }?>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-3">
                <?= $form->field($model, 'salutation')->dropDownList(['mr.' => 'Mr.', 'mrs.' => 'Mrs.', 'miss' => 'Miss.'], ['prompt' => 'Select'], ['class' => 'selectpicker']) ?>
            </div>

            <div class="col-sm-3">
                <?= $form->field($model, 'first_name')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Enter First Name']) ?>
            </div>

            <div class="col-sm-3">
                <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Enter Middle Name']) ?>
            </div>

            <div class="col-sm-3">
                <?= $form->field($model, 'last_name')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Enter Last Name']) ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'short_name')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Enter Short Name']) ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model, 'gender')->dropDownList([$model::GENDER_MALE => 'Male', $model::GENDER_FEMALE => 'Female'], ['prompt' => 'Select Gender']) ?>
        </div>
        <div class="col-sm-4">
            <?php
            echo $form->field($model, 'birthday')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'DD/MM/YYYY'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => Yii::$app->params['dateFormatJs']
                ]
            ]);
            ?>
        </div>
        <div class="col-sm-4">
            <?php
            if ($model->isNewRecord) {
                $model->timezone = 'Africa/Lagos';
            }
            ?>
            <?= $form->field($model, 'timezone')->dropDownList(ArrayHelper::map(\common\models\TimezoneMaster::find()->all(), 'name', 'label'), ['prompt' => 'Select Timezone']) ?>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'occupation')->dropDownList(['Employed' => 'Employed', 'Self Employed' => 'Self Employed', 'Business Owner' => 'Business Owner', 'Other' => 'Other'], ['prompt' => 'Select'], ['class' => 'selectpicker']) ?>
            </div>
            <div class="col-sm-6" style="display:<?php if($model->occupation == 'Other') echo 'block';else echo 'none'?>" id="otherOccupationDiv">
                <?= $form->field($model, 'occupation_other')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
            </div>
        </div>
    </div>

    <?= $this->render('//shared/_phone_fields', ['form' => $form, 'model' => $model])?>
	
    <h5>Address Details:</h5>
    
    <?= $this->render('//shared/_address_fields', ['form' => $form, 'model' => $model])?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$js = "$(function(){
    $('#contact-occupation').on('change', function(){
        if($(this).val() == 'Other'){
            $('#otherOccupationDiv').show();
        }else{
            $('#otherOccupationDiv').hide().find('input').val('');
        }
    });
    });";

$this->registerJs($js, View::POS_END);
    
