<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\CallingCodeMaster;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Agency */
/* @var $form yii\widgets\ActiveForm */
?>
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#generalInfo" aria-controls="property" role="tab" data-toggle="tab">General Information</a></li>
    <li role="presentation"><a href="#contactInfo" aria-controls="localInfo" role="tab" data-toggle="tab">Contact Information</a></li>
    <li role="presentation"><a href="#blogSocialInfo" aria-controls="messages" role="tab" data-toggle="tab">Blog & Social Information</a></li>
    <li role="presentation"><a href="#brokerInfo" aria-controls="messages" role="tab" data-toggle="tab">Broker Information</a></li>
</ul>
<?php $form = ActiveForm::begin(['options' => ['class' => 'frm_geocomplete']]); ?>
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="generalInfo">
        <div class="agency-form">
            
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            
            <?= $form->field($model, 'agencyID')->textInput(['maxlength' => true, 'disabled' => true]) ?>

            <?= $form->field($model, 'tagline')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'owner_name')->textInput(['maxlength' => true]) ?>

            <?php 
                echo $this->render('//shared/_address_fields', ['model' => $model, 'form' => $form]);
            ?>

            <?= $form->field($model, 'status')->dropDownList([$model::STATUS_ACTIVE => 'Active', $model::STATUS_INACTIVE => 'Inactive'],['prompt' => 'Select Status']) ?>

            <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>

            <?php
                echo $this->render('//shared/_photo-gallery', ['model' => $model, 'delete' => true]);
            ?>
            <?= $form->field($model, 'about')->textarea(['maxlength' => true,'rows' => 5, 'style' => 'resize:none;']) ?>
            
        </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="contactInfo">
        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        
        <?= $form->field($model, 'web_address')->textInput(['maxlength' => true]) ?>
        <?php 
            echo $this->render('//shared/_phone_fields', ['model' => $model, 'form' => $form]);
        ?>
    </div>
    <div role="tabpanel" class="tab-pane" id="blogSocialInfo">
        <div class="form-group office-info-social">
            <div class="form-group">
                <label for="usr">Facebook:</label>
                <?= Html::textInput('SocialMediaLink[facebook][url]', isset($socialMediaModel['facebook']['url']) ? $socialMediaModel['facebook']['url'] : '', ['class' => 'form-control social_facebook readonlyCls','placeholder' => 'Enter Facebook Link']) ?>
                <?= Html::hiddenInput('SocialMediaLink[facebook][name]', 'facebook', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Facebook Link']) ?>
            </div>
            <div class="form-group">
                <label for="usr">Twitter:</label>
                <?= Html::textInput('SocialMediaLink[twitter][url]', isset($socialMediaModel['twitter']['url']) ? $socialMediaModel['twitter']['url'] : '', ['class' => 'form-control social_twitter','placeholder' => 'Enter Twitter Link']) ?>
                <?= Html::hiddenInput('SocialMediaLink[twitter][name]', 'twitter', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Twitter Link']) ?>
            </div>
            <div class="form-group">
                <label for="usr">Instagram:</label>
                <?= Html::textInput('SocialMediaLink[instagram][url]', isset($socialMediaModel['instagram']['url']) ? $socialMediaModel['instagram']['url'] : '', ['class' => 'form-control social_instagram readonlyCls','placeholder' => 'Enter Instagram Link']) ?>
                <?= Html::hiddenInput('SocialMediaLink[instagram][name]', 'instagram' , ['class' => 'form-control readonlyCls','placeholder' => 'Enter Instagram Link']) ?>
            </div>
            
            <div class="form-group">
                <label for="usr">Linkedin:</label>
                <?= Html::textInput('SocialMediaLink[linkedin][url]', isset($socialMediaModel['linkedin']['url']) ? $socialMediaModel['linkedin']['url'] : '', ['class' => 'form-control social_linkedin readonlyCls','placeholder' => 'Enter Linkedin Link']) ?>
                <?= Html::hiddenInput('SocialMediaLink[linkedin][name]', 'linkedin' , ['class' => 'form-control readonlyCls','placeholder' => 'Enter Linkedin Link']) ?>
            </div>
            
            <div class="form-group">
                <label for="usr">Blog:</label>
                <?= Html::textInput('SocialMediaLink[blog][url]', isset($socialMediaModel['blog']['url']) ? $socialMediaModel['blog']['url'] : '', ['class' => 'form-control social_blog readonlyCls','placeholder' => 'Enter Blog Link']) ?>
                <?= Html::hiddenInput('SocialMediaLink[blog][name]', 'blog', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Blog Link']) ?>
            </div>
            
            <div class="form-group">
                <label for="usr">Interest:</label>
                <?= Html::textInput('SocialMediaLink[interest][url]', isset($socialMediaModel['interest']['url']) ? $socialMediaModel['interest']['url'] : '', ['class' => 'form-control social_interest readonlyCls','placeholder' => 'Enter Interest Link']) ?>
                <?= Html::hiddenInput('SocialMediaLink[interest][name]', 'interest', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Interest Link']) ?>
            </div>
            
            <div class="form-group">
                <label for="usr">Rss Feed:</label>
                <?= Html::textInput('SocialMediaLink[rss_feed][url]', isset($socialMediaModel['rss_feed']['url']) ? $socialMediaModel['rss_feed']['url'] : '', ['class' => 'form-control social_rss_feed readonlyCls','placeholder' => 'Enter RSS Feed Link']) ?>
                <?= Html::hiddenInput('SocialMediaLink[rss_feed][name]', 'rss_feed', ['class' => 'form-control readonlyCls','placeholder' => 'Enter RSS Feed Link']) ?>
            </div>
            
            <div class="form-group">
                <label for="usr">You Tube:</label>
                <?= Html::textInput('SocialMediaLink[youtube][url]', isset($socialMediaModel['youtube']['url']) ? $socialMediaModel['youtube']['url'] : '', ['class' => 'form-control social_youtube readonlyCls','placeholder' => 'Enter Youtube Link']) ?>
                <?= Html::hiddenInput('SocialMediaLink[youtube][name]', 'youtube', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Youtube Link']) ?>
            </div>
            
            <div class="form-group">
                <label for="usr">Google:</label>
                <?= Html::textInput('SocialMediaLink[google][url]', isset($socialMediaModel['google']['url']) ? $socialMediaModel['google']['url'] : '', ['class' => 'form-control social_google readonlyCls','placeholder' => 'Enter google Link']) ?>
                <?= Html::hiddenInput('SocialMediaLink[google][name]', 'google', ['class' => 'form-control readonlyCls','placeholder' => 'Enter google Link']) ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    
    <div role="presentation" class="tab-pane" id="brokerInfo">
    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($brokerModel, 'salutation')->dropDownList(['mr.' => 'Mr.', 'mrs.' => 'Mrs.', 'miss' => 'Miss.'], ['prompt' => 'Select'], ['class' => 'selectpicker']) ?>
        </div>

        <div class="col-sm-3">
            <?= $form->field($brokerModel, 'first_name')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Enter First Name']) ?>
        </div>

        <div class="col-sm-3">
            <?= $form->field($brokerModel, 'middle_name')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Enter Middle Name']) ?>
        </div>

        <div class="col-sm-3">
            <?= $form->field($brokerModel, 'last_name')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Enter Last Name']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?php
            $brokerIsAgent = $brokerModel->broker_is_agent;
            if ($brokerModel->broker_is_agent === null) {
                $brokerModel->broker_is_agent = 1;
            }
            ?>
            <?= $form->field($brokerModel, 'broker_is_agent')->checkbox() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($brokerModel, 'short_name')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Enter Short Name']) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($brokerModel, 'email')->textInput(['maxlength' => true, 'disabled' => true]) ?>
        </div>
    </div>
    <?php if ($brokerIsAgent == 1) { ?>
        <div class="form-group">
            <div class="row">
                <div class="col-sm-12">
                    <?= $form->field($brokerModel, 'agentID')->textInput(['maxlength' => true, 'disabled' => true]) ?>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($brokerModel, 'gender')->dropDownList([$brokerModel::GENDER_MALE => 'Male', $brokerModel::GENDER_FEMALE => 'Female'], ['prompt' => 'Select Gender']) ?>
        </div>
        <div class="col-sm-4">
            <?php
            echo $form->field($brokerModel, 'birthday')->widget(DatePicker::classname(), [
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
            if ($brokerModel->isNewRecord) {
                $brokerModel->timezone = 'Africa/Lagos';
            }
            ?>
            <?= $form->field($brokerModel, 'timezone')->dropDownList(ArrayHelper::map(\common\models\TimezoneMaster::find()->all(), 'name', 'label'), ['prompt' => 'Select Timezone']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($brokerModel, 'occupation')->dropDownList(['Employed' => 'Employed', 'Self Employed' => 'Self Employed', 'Business Owner' => 'Business Owner', 'Other' => 'Other'], ['prompt' => 'Select'], ['class' => 'selectpicker']) ?>
        </div>
        <div class="col-sm-6" style="display:none;" id="otherOccupationDiv">
            <?= $form->field($brokerModel, 'occupation_other')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
        </div>
    </div>
    <?= $this->render('//shared/_phone_fields', ['form' => $form, 'model' => $brokerModel]) ?>

    <?= $this->render('//shared/_address_fields', ['form' => $form, 'model' => $brokerModel]) ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($brokerModel, 'exp_year')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Enter Years of Experience', 'onkeypress' => 'return isNumberKeyWithDot(event)']) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($brokerModel, 'price_range')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Enter Activity Range (e.g 1-100)', 'onkeypress' => 'return isNumberWithHyphen(event)']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($brokerModel, 'specialization')->textarea(['style' => 'resize:none;', 'rows' => 5]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($brokerModel, 'area_served')->textarea(['style' => 'resize:none;', 'rows' => 5]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($brokerModel, 'about')->textarea(['style' => 'resize:none;', 'rows' => 3]) ?>
        </div>
    </div>

    <?= $this->render('//shared/_social_link_fields', ['socialMedia' => $brokerSocialMedia]) ?>

</div>
</div>
<?php ActiveForm::end(); ?>
    