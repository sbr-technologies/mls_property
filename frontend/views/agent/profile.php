
<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&key=<?= Yii::$app->params['googleMapKey']?>"></script>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Profile;
use yii\helpers\ArrayHelper;
use common\models\CallingCodeMaster;
use common\models\Agency;
use kartik\date\DatePicker;
use common\models\Team;
use kartik\typeahead\Typeahead;
use yii\web\JsExpression;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */

//$this->registerJsFile(
//    'http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places'
//);

$this->registerJsFile(
    '@web/js/jquery.geocomplete.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->registerJsFile(
    '@web/js/location.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile(
    '@web/js/agency.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->title = 'Agent Profile';
?>
<div class="content-wrapper">
    <!-- Content Title Sec -->
    <section class="content-header">
        <h1>Manage Profile</h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
            <li class="active">Manage Profile</li>
        </ol>
    </section>
    <!-- Content Title Sec -->
    <!-- Main content -->
    <section class="content">
        <div class="manage-profile-sec">
            <!-- Photo Upload Sec -->
            <?php echo $this->render('//shared/_my_profile_top.php')?>
            <!-- Photo Upload Sec -->
            <div role="alert" class="alert alert-success alert-dismissible fade in" style="display:none;" id="sucMsgDiv">
                <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                <span class="sucmsgdiv"></span>
            </div>
            <div role="alert" class="alert alert-danger alert-dismissible fade in" style="display:none;" id="failMsgDiv">
                <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                <span class="failmsgdiv"></span>
            </div>
            <!-- Manage Profile Form -->
            <div class="manage-profile-form-sec">
                <div class="manage-profile-tab-bar">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#about-me" aria-controls="buy" role="tab" data-toggle="tab">About Me</a></li>
                        <li role="presentation"><a href="#address" aria-controls="rent" role="tab" data-toggle="tab">Address</a></li>
                        <li role="presentation"><a href="#blogs-socials" aria-controls="sell" role="tab" data-toggle="tab">Blogs & Socials</a></li>
                        <li role="presentation"><a href="#agency" aria-controls="sell" role="tab" data-toggle="tab">Agency</a></li>
                        <li role="presentation"><a href="#Personnel" aria-controls="sell" role="tab" data-toggle="tab">Expertise</a></li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="about-me">
                        <?php $form = ActiveForm::begin(['method' => 'post','action' => ['agent/update-profile'],'options' => ['id' => 'update_profile_form']]); ?>
                        <?= $form->field($model, 'id')->hiddenInput(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                        <div class="col-sm-12 form-sec">
                            <div class="row">
                                <h5>Personal Information:</h5>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <?= $form->field($model, 'salutation')->dropDownList(['mr.' => 'Mr.', 'mrs.' => 'Mrs.', 'miss' => 'Miss.'],['prompt' => 'Select'],['class'=>'selectpicker']) ?>
                                        </div>

                                        <div class="col-sm-3">
                                            <?= $form->field($model, 'first_name')->textInput(['maxlength' => true,'class'=>'form-control','placeholder'=>'Enter First Name']) ?>
                                        </div>

                                        <div class="col-sm-3">
                                            <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true,'class'=>'form-control','placeholder'=>'Enter Middle Name']) ?>
                                        </div>

                                        <div class="col-sm-3">
                                            <?= $form->field($model, 'last_name')->textInput(['maxlength' => true,'class'=>'form-control','placeholder'=>'Enter Last Name']) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <?= $form->field($model, 'short_name')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Enter Short Name']) ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'disabled' => true]) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <?= $form->field($model, 'agentID')->textInput(['maxlength' => true,'disabled' => true]) ?>
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
                                            <?= $form->field($model, 'occupation')->dropDownList(['Employed' => 'Employed', 'Self Employed' => 'Self Employed', 'Business Owner' => 'Business Owner', 'Other' => 'Other'],['prompt' => 'Select','onchange' => 'showHideProfileDiv(this.value);'],['class'=>'selectpicker']) ?>
                                        </div>
                                        <div class="col-sm-6" style="display:none;" id="otherOccupationDiv">
                                            <?= $form->field($model, 'occupation_other')->textInput(['maxlength' => true,'class'=>'form-control']) ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <?= $this->render('//shared/_phone_fields', ['form' => $form, 'model' => $model])?>
                                
                                <div class="form-group">
                                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-default' : 'btn btn-success']) ?>
                                </div>
                            </div>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="address">
                        <?php $form = ActiveForm::begin(['method' => 'post','action' => ['agent/update-address'],'options' => ['class' => 'frm_geocomplete','id' => 'update_address_form']]); ?>
                        <div class="col-sm-12 form-sec">
                            <div class="row">
                                <h5>Personal Address Details:</h5>
                                <!--<p>You haven't setup your blog account yet.</p>-->
                                <?= $this->render('//shared/_address_fields', ['form' => $form, 'model' => $model])?>
                                <div class="form-group">
                                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-default' : 'btn btn-success']) ?>
                                </div>
                            </div>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="blogs-socials">
                        <?= Html::beginForm(['agent/manage-social'], 'post', ['id' => 'manage_social_form']) ?>
                            <div class="col-sm-9 form-sec">
                                <div class="row">
                                    <h5>Personal Blog Information:</h5>
                                    <div class="form-group">
                                        <label for="">Blogs:</label>
                                        <?= Html::textInput('SocialMediaLink[blog][url]', isset($agentSocialMediaModel['blog']['url']) ? $agentSocialMediaModel['blog']['url'] : '', ['class' => 'form-control social_blog readonlyCls','placeholder' => 'Enter Blog ID']) ?>
                                        <?= Html::hiddenInput('SocialMediaLink[blog][name]', isset($agentSocialMediaModel['blog']['url']) ? 'blog' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Blog ID']) ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Facebook:</label>
                                        <?= Html::textInput('SocialMediaLink[facebook][url]', isset($agentSocialMediaModel['facebook']['url']) ? $agentSocialMediaModel['facebook']['url'] : '', ['class' => 'form-control social_facebook readonlyCls','placeholder' => 'Enter Facebook ID']) ?>
                                        <?= Html::hiddenInput('SocialMediaLink[facebook][name]', isset($agentSocialMediaModel['facebook']['url']) ? 'facebook' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Facebook ID']) ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Twitter:</label>
                                        <?= Html::textInput('SocialMediaLink[twitter][url]', isset($agentSocialMediaModel['twitter']['url']) ? $agentSocialMediaModel['twitter']['url'] : '', ['class' => 'form-control social_twitter readonlyCls','placeholder' => 'Enter Twitter ID']) ?>
                                        <?= Html::hiddenInput('SocialMediaLink[twitter][name]', isset($agentSocialMediaModel['twitter']['url']) ? 'twitter' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Twitter ID']) ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Google:</label>
                                        <?= Html::textInput('SocialMediaLink[google][url]', isset($agentSocialMediaModel['google']['url']) ? $agentSocialMediaModel['google']['url'] : '', ['class' => 'form-control social_google readonlyCls','placeholder' => 'Enter google ID']) ?>
                                        <?= Html::hiddenInput('SocialMediaLink[google][name]', isset($agentSocialMediaModel['google']['url']) ? 'google' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter google ID']) ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Instagram:</label>
                                        <?= Html::textInput('SocialMediaLink[instagram][url]', isset($agentSocialMediaModel['instagram']['url']) ? $agentSocialMediaModel['instagram']['url'] : '', ['class' => 'form-control social_instagram readonlyCls','placeholder' => 'Enter Instagram ID']) ?>
                                        <?= Html::hiddenInput('SocialMediaLink[instagram][name]', isset($agentSocialMediaModel['instagram']['url']) ? 'instagram' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Instagram ID']) ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Linkedin:</label>
                                        <?= Html::textInput('SocialMediaLink[linkedin][url]', isset($agentSocialMediaModel['linkedin']['url']) ? $agentSocialMediaModel['linkedin']['url'] : '', ['class' => 'form-control social_linkedin readonlyCls','placeholder' => 'Enter Linkedin ID']) ?>
                                        <?= Html::hiddenInput('SocialMediaLink[linkedin][name]', isset($agentSocialMediaModel['linkedin']['url']) ? 'linkedin' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Linkedin ID']) ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Youtube:</label>
                                        <?= Html::textInput('SocialMediaLink[youtube][url]', isset($agentSocialMediaModel['youtube']['url']) ? $agentSocialMediaModel['youtube']['url'] : '', ['class' => 'form-control social_youtube readonlyCls','placeholder' => 'Enter Youtube ID']) ?>
                                        <?= Html::hiddenInput('SocialMediaLink[youtube][name]', isset($agentSocialMediaModel['youtube']['url']) ? 'youtube' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Youtube ID']) ?>
                                    </div>

    <!--                                <div class="form-group">
                                        <label for="">Pinterest:</label>
                                        <input type="text" class="form-control" placeholder="You haven't setup your Pinterest account yet.">
                                        <a href="javascript:void(0)" class="redTxt">Setup your Pinterest account</a>
                                    </div>-->

                                    <div class="form-group">
                                        <label for="">RSSFeed:</label>
                                        <?= Html::textInput('SocialMediaLink[rss_feed][url]', isset($agentSocialMediaModel['rss_feed']['url']) ? $agentSocialMediaModel['rss_feed']['url'] : '', ['class' => 'form-control social_rss_feed readonlyCls','placeholder' => 'Enter RSS Feed ID']) ?>
                                        <?= Html::hiddenInput('SocialMediaLink[rss_feed][name]', isset($agentSocialMediaModel['rss_feed']['url']) ? 'rss_feed' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter RSS Feed ID']) ?>
                                    </div>

                                    <div class="form-group">
                                        <?= Html::submitButton('Update', ['class' => 'btn btn-success']) ?>
                                    </div>
                                </div>
                            </div>
                        <?= Html::endForm() ?>
                    </div>
                    
                    <div role="tabpanel" class="tab-pane" id="agency">
                        <?= Html::beginForm(['agent/manage-agency'], 'post', ['id' => 'update_agency_form']) ?>
                        <div class="col-sm-12 form-sec">
                            <div class="row">
                                <h5>Agency Info:</h5>
                                <div class="nar-information">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                            <?php
                                                // Defines a custom template with a <code>Handlebars</code> compiler for rendering suggestions
                                                echo '<label class="control-label">Select Agency</label>';
                                                $template = '<div><p class="repo-language">{{language}}</p>' .
                                                    '<p class="repo-name">{{value}}</p>' .
                                                    '<p class="repo-description">{{email}}</p></div>';

                                                echo Typeahead::widget([
                                                    'name' => 'twitter_oss', 
                                                    'options' => ['placeholder' => 'Filter as you type ...'],
                                                    'dataset' => [
                                                        [
                                                            'remote' => [
                                                                'url' => Url::to(['agent/agencies']) . '?q=%QUERY',
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
                                                            $('.readonlyCls').prop('disabled',true);
                                                            $.get('". Url::to(['agent/agency-details']). "', {agency_id:data.id}, function(response){
                                                               $.loaded();
                                                                //console.log(response); 
                                                                console.log(response.finalTeamJson); 
                                                                $.each( response.agency_data, function( key, value ) { 
                                                                
                                                                    $('.txt_'+key).val(value);
                                                                });
                                                                $.each( response.social_media, function( key, value ) {
                                                                    $('.social_'+value.name.toLowerCase()).val(value.url);
                                                                });
                                                                
                                                                var newOptions = response.finalTeamJson;
                                                                console.log(newOptions);
                                                                var team = $('#agent-team_id');
                                                                team.empty(); // remove old options
                                                                team.append($('<option></option>')
                                                                      .attr('value', '').text('No Team'));
                                                                $.each(newOptions, function(key,value) { 
                                                                   team.append($('<option></option>')
                                                                      .attr('value', key).text(value));
                                                                 }); 
                                                                if(response.agency_data.imageUrl){
                                                                    $('.agency_image').attr('src','');
                                                                    $('.agency_image').attr('src',response.agency_data.imageUrl);
                                                                    $('.agency_image').attr('style', '');
                                                                    $('#uploadImageDiv').hide('slow');
                                                                    $('#uploadImageDispaly').hide('slow');
                                                                }
                                                            }, 'json');
                                                        }"
                                                    ]
                                                ]);
                                            ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-2 box-btn-clear">
                                            <div class="form-group">
                                                <button name="" type="button" onclick="resetAgencyFormVal('readonlyCls');" class="btn btn-default red-btn">Clear</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h5>Agency Details:</h5>
                                <div class="nar-information">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <?php if($model->agency_id){?>
                                            <div class="form-group">
                                                <?php echo $form->field($model, 'team_id')->dropDownList(ArrayHelper::map(Team::find()->where(['agency_id' => $model->agency_id])->active()->all(), 'id', 'name'), ['class'=>'form-control selectpicker', 'prompt' => 'No Team'])->label('Select Team'); ?>
                                            </div>
                                            <?php }?>
                                            <div class="form-group required">
                                              <label for="" class="control-label">Name :</label>
                                                <?= Html::hiddenInput('Agency[id]', $agencyModel->id, ['class' => 'form-control txt_id hid_manage_agency_agency_id']) ?>
                                                <?= Html::textInput('Agency[name]', $agencyModel->name, ['class' => 'form-control txt_value readonlyCls required','placeholder' => 'Enter Agency Name']) ?>
                                            </div>
                                            <div class="form-group required">
                                              <label for="" class="control-label">Agency ID :</label>
                                                <?= Html::textInput('Agency[agencyID]', $agencyModel->agencyID, ['class' => 'form-control txt_value readonlyCls required', 'readonly' => true]) ?>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Tag Line :</label>
                                                <?= Html::textInput('Agency[tagline]', $agencyModel->tagline, ['class' => 'form-control txt_tagline readonlyCls','placeholder' => 'Enter Tag Line']) ?>
                                            </div>
                                            <div class="form-group required">
                                              <label for="" class="control-label">Owner Name :</label>
                                                <?= Html::textInput('Agency[owner_name]', $agencyModel->owner_name, ['class' => 'form-control txt_owner_name readonlyCls','placeholder' => 'Enter Owner Name']) ?>
                                            </div>
                                            <div class="agency_addr_details">
                                                <?= $this->render('//shared/_address_fields', ['form' => $form, 'model' => $agencyModel])?>
                                                <div class="form-group" id="uploadImageDiv">
                                                    <?= $form->field($agencyModel, 'imageFiles')->fileInput(['multiple' => false,'calss'=> 'form-control txt_agency_photo readonlyCls', 'accept' => 'image/*']) ?>
                                                </div>
                                                <div class="add-property-upload-images" id="uploadImageDispaly">
                                                    <?php
                                                        echo $this->render('//shared/_photo-gallery', ['model' => $agencyModel, 'single' => true, 'size' => common\models\PhotoGallery::FULL]);
                                                    ?>
                                                </div>
                                                <div class="add-upload-images">
                                                    <img src="" style="display:none;" class="agency_image" height="150px"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h5>Agency Contact Info:</h5>
                                <div class="nar-information">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="form-group">
                                                <label for="">Email Address :</label>
                                                <?= Html::textInput('Agency[email]', $agencyModel->email, ['class' => 'form-control txt_email readonlyCls','placeholder' => 'Enter Email Address']) ?>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <?= $form->field($agencyModel, 'calling_code')->dropDownList(ArrayHelper::map(CallingCodeMaster::find()->all(), 'code', 'name'), ['prompt' => 'Select Country', 'class'=>'txt_calling_code readonlyCls selectpicker']) ?>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="">Mobile1 :</label>
                                                        <?= Html::textInput('Agency[mobile1]', $agencyModel->mobile1, ['class' => 'form-control txt_mobile readonlyCls','placeholder' => 'Enter Mobile Number One','onkeypress'=>'return isNumberKey(event)']) ?>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="">Office1 :</label>
                                                        <?= Html::textInput('Agency[office1]', $agencyModel->office1, ['class' => 'form-control txt_mobile readonlyCls','placeholder' => 'Enter Mobile Number One','onkeypress'=>'return isNumberKey(event)']) ?>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="">Fax1 :</label>
                                                        <?= Html::textInput('Agency[fax1]', $agencyModel->fax1, ['class' => 'form-control txt_mobile readonlyCls','placeholder' => 'Enter Mobile Number One','onkeypress'=>'return isNumberKey(event)']) ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <?= $form->field($agencyModel, 'calling_code2')->dropDownList(ArrayHelper::map(CallingCodeMaster::find()->all(), 'code', 'name'), ['prompt' => 'Select Country', 'class'=>'txt_calling_code readonlyCls selectpicker']) ?>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="">Mobile2 :</label>
                                                        <?= Html::textInput('Agency[mobile2]', $agencyModel->mobile2, ['class' => 'form-control txt_mobile readonlyCls','placeholder' => 'Enter Mobile Number Two','onkeypress'=>'return isNumberKey(event)']) ?>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="">Office2 :</label>
                                                        <?= Html::textInput('Agency[office2]', $agencyModel->office2, ['class' => 'form-control txt_mobile readonlyCls','placeholder' => 'Enter Mobile Number Two','onkeypress'=>'return isNumberKey(event)']) ?>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="">Fax2 :</label>
                                                        <?= Html::textInput('Agency[fax2]', $agencyModel->fax2, ['class' => 'form-control txt_mobile readonlyCls','placeholder' => 'Enter Mobile Number Two','onkeypress'=>'return isNumberKey(event)']) ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <?= $form->field($agencyModel, 'calling_code3')->dropDownList(ArrayHelper::map(CallingCodeMaster::find()->all(), 'code', 'name'), ['prompt' => 'Select Country', 'class'=>'txt_calling_code readonlyCls selectpicker']) ?>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="">Mobile3 :</label>
                                                        <?= Html::textInput('Agency[mobile3]', $agencyModel->mobile3, ['class' => 'form-control txt_mobile readonlyCls','placeholder' => 'Enter Mobile Number Three','onkeypress'=>'return isNumberKey(event)']) ?>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="">Office3 :</label>
                                                        <?= Html::textInput('Agency[office3]', $agencyModel->office3, ['class' => 'form-control txt_mobile readonlyCls','placeholder' => 'Enter Mobile Number Three','onkeypress'=>'return isNumberKey(event)']) ?>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="">Fax3 :</label>
                                                        <?= Html::textInput('Agency[fax3]', $agencyModel->fax3, ['class' => 'form-control txt_mobile readonlyCls','placeholder' => 'Enter Mobile Number Three','onkeypress'=>'return isNumberKey(event)']) ?>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <?= $form->field($agencyModel, 'calling_code4')->dropDownList(ArrayHelper::map(CallingCodeMaster::find()->all(), 'code', 'name'), ['prompt' => 'Select Country', 'class'=>'txt_calling_code readonlyCls selectpicker']) ?>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="">Other Mobile :</label>
                                                        <?= Html::textInput('Agency[mobile4]', $agencyModel->mobile4, ['class' => 'form-control txt_mobile readonlyCls','placeholder' => 'Enter Mobile Number Three','onkeypress'=>'return isNumberKey(event)']) ?>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="">Other Office :</label>
                                                        <?= Html::textInput('Agency[office4]', $agencyModel->office4, ['class' => 'form-control txt_mobile readonlyCls','placeholder' => 'Enter Mobile Number Three','onkeypress'=>'return isNumberKey(event)']) ?>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="">Other Fax :</label>
                                                        <?= Html::textInput('Agency[fax4]', $agencyModel->fax4, ['class' => 'form-control txt_mobile readonlyCls','placeholder' => 'Enter Mobile Number Three','onkeypress'=>'return isNumberKey(event)']) ?>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="form-group">
                                                <label for="">Web Address:</label>
                                                <?= Html::textInput('Agency[web_address]', $agencyModel->web_address, ['class' => 'form-control txt_web_address readonlyCls','placeholder' => 'Enter Web Address']) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h5>Agency Blog & Social Info:</h5>
                                <div class="nar-information">
                                    <div class="col-sm-12">
                                        <div class="row">    
                                            <div class="form-group office-info-social">
                                                <?= Html::textInput('SocialMediaLink[facebook][url]', isset($socialMediaModel['facebook']['url']) ? $socialMediaModel['facebook']['url'] : '', ['class' => 'form-control social_facebook readonlyCls','placeholder' => 'Enter Facebook ID']) ?>
                                                <?= Html::hiddenInput('SocialMediaLink[facebook][name]', isset($socialMediaModel['facebook']['url']) ? 'facebook' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Facebook ID']) ?>

                                                <?= Html::textInput('SocialMediaLink[twitter][url]', isset($socialMediaModel['twitter']['url']) ? $socialMediaModel['twitter']['url'] : '', ['class' => 'form-control social_twitter readonlyCls','placeholder' => 'Enter Twitter ID']) ?>
                                                <?= Html::hiddenInput('SocialMediaLink[twitter][name]', isset($socialMediaModel['twitter']['url']) ? 'twitter' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Twitter ID']) ?>

                                                <?= Html::textInput('SocialMediaLink[instagram][url]', isset($socialMediaModel['instagram']['url']) ? $socialMediaModel['instagram']['url'] : '', ['class' => 'form-control social_instagram readonlyCls','placeholder' => 'Enter Instagram ID']) ?>
                                                <?= Html::hiddenInput('SocialMediaLink[instagram][name]', isset($socialMediaModel['instagram']['url']) ? 'instagram' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Instagram ID']) ?>

                                                <?= Html::textInput('SocialMediaLink[linkedin][url]', isset($socialMediaModel['linkedin']['url']) ? $socialMediaModel['linkedin']['url'] : '', ['class' => 'form-control social_linkedin readonlyCls','placeholder' => 'Enter Linkedin ID']) ?>
                                                <?= Html::hiddenInput('SocialMediaLink[linkedin][name]', isset($socialMediaModel['linkedin']['url']) ? 'linkedin' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Linkedin ID']) ?>

                                                <?= Html::textInput('SocialMediaLink[blog][url]', isset($socialMediaModel['blog']['url']) ? $socialMediaModel['blog']['url'] : '', ['class' => 'form-control social_blog readonlyCls','placeholder' => 'Enter Blog ID']) ?>
                                                <?= Html::hiddenInput('SocialMediaLink[blog][name]', isset($socialMediaModel['blog']['url']) ? 'blog' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Blog ID']) ?>

                                                <?= Html::textInput('SocialMediaLink[interest][url]', isset($socialMediaModel['interest']['url']) ? $socialMediaModel['interest']['url'] : '', ['class' => 'form-control social_interest readonlyCls','placeholder' => 'Enter Interest ID']) ?>
                                                <?= Html::hiddenInput('SocialMediaLink[interest][name]', isset($socialMediaModel['interest']['url']) ? 'interest' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Interest ID']) ?>

                                                <?= Html::textInput('SocialMediaLink[rss_feed][url]', isset($socialMediaModel['rss_feed']['url']) ? $socialMediaModel['rss_feed']['url'] : '', ['class' => 'form-control social_rss_feed readonlyCls','placeholder' => 'Enter RSS Feed ID']) ?>
                                                <?= Html::hiddenInput('SocialMediaLink[rss_feed][name]', isset($socialMediaModel['rss_feed']['url']) ? 'rss_feed' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter RSS Feed ID']) ?>

                                                <?= Html::textInput('SocialMediaLink[youtube][url]', isset($socialMediaModel['youtube']['url']) ? $socialMediaModel['youtube']['url'] : '', ['class' => 'form-control social_youtube readonlyCls','placeholder' => 'Enter Youtube ID']) ?>
                                                <?= Html::hiddenInput('SocialMediaLink[youtube][name]', isset($socialMediaModel['youtube']['url']) ? 'youtube' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Youtube ID']) ?>

                                                <?= Html::textInput('SocialMediaLink[google][url]', isset($socialMediaModel['google']['url']) ? $socialMediaModel['google']['url'] : '', ['class' => 'form-control social_google readonlyCls','placeholder' => 'Enter google ID']) ?>
                                                <?= Html::hiddenInput('SocialMediaLink[google][name]', isset($socialMediaModel['google']['url']) ? 'google' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter google ID']) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h5>About Agency :</h5>
                                <div class="nar-information">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <?= $form->field($agencyModel, 'about')->textarea(['maxlength' => true,'class'=>'form-control txt_about readonlyCls','placeholder'=>'Enter About Agency','rows' => 5,'style'=>'resize:none;'])->label(false) ?>
                                            </div>
                                            <div class="form-group">
                                                <?= Html::button('Update', ['class' => 'btn btn-success bnt_save_agency']) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?= Html::endForm() ?>
                    </div>
                    
                    <div role="tabpanel" class="tab-pane" id="Personnel">
                        <?php $form = ActiveForm::begin(['method' => 'post','action' => ['agent/update-about'],'options' => ['id' => 'update_about_form']]); ?>
                        <?= $form->field($model, 'id')->hiddenInput(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                        <div class="col-sm-12 form-sec">
                            <div class="row">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <?= $form->field($model, 'exp_year')->textInput(['maxlength' => true,'class'=>'form-control','placeholder'=>'Enter Years of Experience','onkeypress'=>'return isNumberKeyWithDot(event)']) ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <?= $form->field($model, 'price_range')->textInput(['maxlength' => true,'class'=>'form-control','placeholder'=>'Enter Activity Range (e.g 1-100)','onkeypress'=>'return isNumberWithHyphen(event)']) ?>
                                        </div>
<!--                                        <div class="col-sm-4">
                                            <?php //echo $form->field($model, 'brokerage')->textInput(['maxlength' => true,'class'=>'form-control','placeholder'=>'Enter Brockarage']) ?>
                                        </div>-->
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <?= $form->field($model, 'specialization')->textarea(['style'=> 'resize:none;','rows' =>5]) ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <?= $form->field($model, 'area_served')->textarea(['style'=> 'resize:none;','rows' =>5]) ?>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <?= $form->field($model, 'about')->textarea(['style'=> 'resize:none;','rows' =>5]) ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-default' : 'btn btn-success']) ?>
                                </div>
                            </div>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
            <!-- Manage Profile Form -->
        </div>
    </section>
    
    <!-- Main content -->
</div>
