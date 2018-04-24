<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&key=<?= Yii::$app->params['googleMapKey']?>"></script>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Profile;
use yii\helpers\ArrayHelper;
use common\models\CallingCodeMaster;
use common\models\Agency;
use kartik\date\DatePicker;
use common\models\PropertyType;


use kartik\typeahead\Typeahead;
use yii\web\JsExpression;
use yii\helpers\Url;
use yii\widgets\Pjax;


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
    '@web/js/buyer.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->title = 'Buyer Profile';
$soonNeedArr        =   [
                            ''                          =>  'Select',
                            'One Month – Three Months'  =>  'One Month – Three Months',
                            'Three Months – Six Months' =>  'Three Months – Six Months',
                            'Six months – 1 Year'       =>  'Six months – 1 Year',
                            '1 year +'                  =>  '1 year +',
                        ];
$usagesArr          =   [
                            ''                          =>  'Select',
                            'Owner Occupant'            =>  'Owner Occupant',
                            'Rent'                      =>  'Rent',
                        ];
$conditionsArr      =   [
                            ''                              =>  'Select',
                            'No repairs needed'             =>  'No repairs needed',
                            'Minor cosmetic repairs needed' =>  'Minor cosmetic repairs needed',
                            'Major cosmetic repairs needed' =>  'Major cosmetic repairs needed',
                            'Structural repairs needed'     =>  'Structural repairs needed',
                        ];
$featuresArr        =   [
                            'Kitchen'                       =>  'Kitchen',
                            'Closets/storage'               =>  'Closets/storage',
                            'Appliances (gas/electric)'     =>  'Appliances (gas/electric)',
                            'Floor plan (open, in-law)'     =>  'Floor plan (open, in-law)',
                            'Patio/deck'                    =>  'Patio/deck',
                            'Basement'                      =>  'Basement',
                            'Attic'                         =>  'Attic',
                            'Laundry room'                  =>  'Laundry room'
                            
                        ];
$amenitiesArr       =   [
                            'Office'                        =>  'Office',
                            'Play/exercise room'            =>  'Play/exercise room',
                            'Security system'               =>  'Security system',
                            'Furniture/furnishings'         =>  'Furniture/furnishings',
                            'Sprinkler system'              =>  'Sprinkler system',
                            'Workshop/studio'               =>  'Workshop/studio',
                            'In-law suite'                  =>  'In-law suite',
                            'Fireplace'                     =>  'Fireplace',
                            'Pool'                          =>  'Pool',
                            'Hot tub'                       =>  'Hot tub',
                            'Ceiling fans'                  =>  'Ceiling fans',
                            'Window treatments'             =>  'Window treatments',
                            'Satellite dish'                =>  'Satellite dish',
                            'Internet (broadband)'          =>  'Internet (broadband)',
                            'Sidewalk'                      =>  'Sidewalk',
                            'Energy efficient features'     =>  'Energy efficient features',
                        ];
//\yii\helpers\VarDumper::dump($featuresArr,4,12); exit;
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
                        <li role="presentation"><a href="#criteria-worksheet" aria-controls="sell" role="tab" data-toggle="tab">Property Criteria Worksheet</a></li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="about-me">
                        <?php $form = ActiveForm::begin(['method' => 'post','action' => ['buyer/update-profile'],'options' => ['id' => 'update_profile_form']]); ?>
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
                                            <?= $form->field($model, 'buyerID')->textInput(['maxlength' => true,'disabled' => true]) ?>
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
                        <?php $form = ActiveForm::begin(['method' => 'post','action' => ['buyer/update-address'],'options' => ['class' => 'frm_geocomplete','id' => 'update_address_form']]); ?>
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
                        <?= Html::beginForm(['buyer/manage-social'], 'post', ['id' => 'manage_social_form']) ?>
                            <div class="col-sm-12 form-sec">
                                <div class="row">
                                    <h5>Personal Blog Information:</h5>
                                    <div class="form-group">
                                        <label for="">Blogs:</label>
                                        <?= Html::textInput('SocialMediaLink[blog][url]', isset($buyerSocialMediaModel['blog']['url']) ? $buyerSocialMediaModel['blog']['url'] : '', ['class' => 'form-control social_blog readonlyCls','placeholder' => 'Enter Blog ID']) ?>
                                        <?= Html::hiddenInput('SocialMediaLink[blog][name]', isset($buyerSocialMediaModel['blog']['url']) ? 'blog' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Blog ID']) ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Facebook:</label>
                                        <?= Html::textInput('SocialMediaLink[facebook][url]', isset($buyerSocialMediaModel['facebook']['url']) ? $buyerSocialMediaModel['facebook']['url'] : '', ['class' => 'form-control social_facebook readonlyCls','placeholder' => 'Enter Facebook ID']) ?>
                                        <?= Html::hiddenInput('SocialMediaLink[facebook][name]', isset($buyerSocialMediaModel['facebook']['url']) ? 'facebook' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Facebook ID']) ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Twitter:</label>
                                        <?= Html::textInput('SocialMediaLink[twitter][url]', isset($buyerSocialMediaModel['twitter']['url']) ? $buyerSocialMediaModel['twitter']['url'] : '', ['class' => 'form-control social_twitter readonlyCls','placeholder' => 'Enter Twitter ID']) ?>
                                        <?= Html::hiddenInput('SocialMediaLink[twitter][name]', isset($buyerSocialMediaModel['twitter']['url']) ? 'twitter' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Twitter ID']) ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Google:</label>
                                        <?= Html::textInput('SocialMediaLink[google][url]', isset($buyerSocialMediaModel['google']['url']) ? $buyerSocialMediaModel['google']['url'] : '', ['class' => 'form-control social_google readonlyCls','placeholder' => 'Enter google ID']) ?>
                                        <?= Html::hiddenInput('SocialMediaLink[google][name]', isset($buyerSocialMediaModel['google']['url']) ? 'google' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter google ID']) ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Instagram:</label>
                                        <?= Html::textInput('SocialMediaLink[instagram][url]', isset($buyerSocialMediaModel['instagram']['url']) ? $buyerSocialMediaModel['instagram']['url'] : '', ['class' => 'form-control social_instagram readonlyCls','placeholder' => 'Enter Instagram ID']) ?>
                                        <?= Html::hiddenInput('SocialMediaLink[instagram][name]', isset($buyerSocialMediaModel['instagram']['url']) ? 'instagram' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Instagram ID']) ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Linkedin:</label>
                                        <?= Html::textInput('SocialMediaLink[linkedin][url]', isset($buyerSocialMediaModel['linkedin']['url']) ? $buyerSocialMediaModel['linkedin']['url'] : '', ['class' => 'form-control social_linkedin readonlyCls','placeholder' => 'Enter Linkedin ID']) ?>
                                        <?= Html::hiddenInput('SocialMediaLink[linkedin][name]', isset($buyerSocialMediaModel['linkedin']['url']) ? 'linkedin' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Linkedin ID']) ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Youtube:</label>
                                        <?= Html::textInput('SocialMediaLink[youtube][url]', isset($buyerSocialMediaModel['youtube']['url']) ? $buyerSocialMediaModel['youtube']['url'] : '', ['class' => 'form-control social_youtube readonlyCls','placeholder' => 'Enter Youtube ID']) ?>
                                        <?= Html::hiddenInput('SocialMediaLink[youtube][name]', isset($buyerSocialMediaModel['youtube']['url']) ? 'youtube' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Youtube ID']) ?>
                                    </div>

    <!--                                <div class="form-group">
                                        <label for="">Pinterest:</label>
                                        <input type="text" class="form-control" placeholder="You haven't setup your Pinterest account yet.">
                                        <a href="javascript:void(0)" class="redTxt">Setup your Pinterest account</a>
                                    </div>-->

                                    <div class="form-group">
                                        <label for="">RSSFeed:</label>
                                        <?= Html::textInput('SocialMediaLink[rss_feed][url]', isset($buyerSocialMediaModel['rss_feed']['url']) ? $buyerSocialMediaModel['rss_feed']['url'] : '', ['class' => 'form-control social_rss_feed readonlyCls','placeholder' => 'Enter RSS Feed ID']) ?>
                                        <?= Html::hiddenInput('SocialMediaLink[rss_feed][name]', isset($buyerSocialMediaModel['rss_feed']['url']) ? 'rss_feed' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter RSS Feed ID']) ?>
                                    </div>

                                    <div class="form-group">
                                        <?= Html::submitButton('Update', ['class' => 'btn btn-success']) ?>
                                    </div>
                                </div>
                            </div>
                        <?= Html::endForm() ?>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="criteria-worksheet">
                        <?php $form = ActiveForm::begin(['method' => 'post','action' => ['buyer/criteria-worksheet'],'options' => ['class' => 'frm_geocomplete','id' => 'update_worksheet_form']]); ?>
                        <div class="col-sm-12 form-sec">
                            <div class="row">
                                <h5>Location :</h5>
                                <div class="nar-information">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="form-group col-sm-3">
                                              <label for="" class="control-label">State :</label>
                                                <?= Html::textInput('BuyerWorkSheet[state]', $workSheet->state, ['class' => 'form-control','placeholder' => 'Enter State']) ?>
                                            </div>
                                            <div class="form-group col-sm-3">
                                              <label for="" class="control-label">LGA :</label>
                                                <?= Html::textInput('BuyerWorkSheet[lga]', $workSheet->lga, ['class' => 'form-control','placeholder' => 'Enter LGA']) ?>
                                            </div>
                                            <div class="form-group col-sm-3">
                                              <label for="" class="control-label">City/Town :</label>
                                                <?= Html::textInput('BuyerWorkSheet[city]', $workSheet->city, ['class' => 'form-control','placeholder' => 'Enter City/Town']) ?>
                                            </div>
                                            <div class="form-group col-sm-3">
                                              <label for="" class="control-label">Area :</label>
                                                <?= Html::textInput('BuyerWorkSheet[area]', $workSheet->area, ['class' => 'form-control','placeholder' => 'Enter Area']) ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group">
                                              <label for="" class="control-label">Additional comments about location :</label>
                                                <?= Html::textarea('BuyerWorkSheet[comment_location]', $workSheet->comment_location, ['class' => 'form-control','rows' => '5','style' => 'resize:none;']) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h5>Economics :</h5>
                                <div class="nar-information">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="form-group col-sm-4">
                                              <label for="" class="control-label">Price range from (&#8358;) : </label>
                                                <?= Html::textInput('BuyerWorkSheet[price_range_from]', $workSheet->price_range_from, ['class' => 'form-control','placeholder' => 'Price Range From','onkeypress'=>'return isNumberKey(event)']) ?>
                                            </div>
                                            <div class="form-group col-sm-4">
                                              <label for="" class="control-label">Price range to (&#8358;) :</label>
                                                <?= Html::textInput('BuyerWorkSheet[price_range_to]', $workSheet->price_range_to, ['class' => 'form-control','placeholder' => 'Price Range To','onkeypress'=>'return isNumberKey(event)']) ?>
                                            </div>
                                            <div class="form-group col-sm-4">
                                              <label for="" class="control-label">How soon needed? :</label>
                                                <?= $form->field($workSheet, 'how_soon_need')->dropDownList($soonNeedArr, ['class'=>'form-control selectpicker'])->label(false) ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-sm-4">
                                              <label for="" class="control-label">Usage :</label>
                                                <?= $form->field($workSheet, 'usage')->dropDownList($usagesArr, ['class'=>'form-control selectpicker'])->label(false) ?>
                                            </div>
                                            <div class="form-group col-sm-4">
                                              <label for="" class="control-label">Investment :</label>
                                                <?= Html::textInput('BuyerWorkSheet[investment]', $workSheet->investment, ['class' => 'form-control','placeholder' => 'eg: 12345.50','onkeypress'=>'return isNumberKeyWithDot(event)']) ?>
                                            </div>
                                            <div class="form-group col-sm-4">
                                              <label for="" class="control-label">Cash flow (per Month):</label>
                                                <?= Html::textInput('BuyerWorkSheet[cash_flow]', $workSheet->cash_flow, ['class' => 'form-control','placeholder' => '12345.50','onkeypress'=>'return isNumberKeyWithDot(event)']) ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-sm-4">
                                              <label for="" class="control-label">Appreciation (in % per Year) :</label>
                                                <?= Html::textInput('BuyerWorkSheet[appricition]', $workSheet->investment, ['class' => 'form-control','placeholder' => '12345.50','onkeypress'=>'return isNumberKeyWithDot(event)']) ?>
                                            </div>
                                            <div class="form-group col-sm-4">
                                              <label for="" class="control-label">Need Agent :</label>
                                                <?= $form->field($workSheet, 'need_agent')->dropDownList(['Yes' => 'Yes', 'No' => 'No'],['prompt' => 'Select'])->label(false) ?>
                                            </div>
                                            <div class="form-group col-sm-4">
                                              <label for="" class="control-label">Contact me :</label>
                                                <?= $form->field($workSheet, 'contact_me')->dropDownList(['Yes' => 'Yes', 'No' => 'No'],['prompt' => 'Select'])->label(false) ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-sm-4">
                                              <label for="" class="control-label">Condition :</label>
                                                <?= $form->field($workSheet, 'condition')->dropDownList($conditionsArr, ['class'=>'form-control selectpicker'])->label(false) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h5>Features :</h5>
                                <div class="nar-information"
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="form-group col-sm-3">
                                              <label for="" class="control-label">Age / year built :</label>
                                                <?= Html::textInput('BuyerWorkSheet[year_built]', $workSheet->year_built, ['class' => 'form-control','placeholder' => 'eg: 2007','onkeypress'=>'return isNumberKey(event)','maxlength' => 4]) ?>
                                            </div>
                                            <div class="form-group col-sm-3">
                                              <label for="" class="control-label">Beds :</label>
                                                <?= Html::textInput('BuyerWorkSheet[bed]', $workSheet->bed, ['class' => 'form-control','placeholder' => 'eg: 10','onkeypress'=>'return isNumberKey(event)']) ?>
                                            </div>
                                            <div class="form-group col-sm-3">
                                              <label for="" class="control-label">Baths :</label>
                                                <?= Html::textInput('BuyerWorkSheet[bath]', $workSheet->bath, ['class' => 'form-control','placeholder' => 'eg: 10','onkeypress'=>'return isNumberKey(event)']) ?>
                                            </div>
                                            <div class="form-group col-sm-3">
                                              <label for="" class="control-label">Living :</label>
                                                <?= Html::textInput('BuyerWorkSheet[living]', $workSheet->living, ['class' => 'form-control','placeholder' => 'eg: 10','onkeypress'=>'return isNumberKey(event)']) ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-sm-3">
                                              <label for="" class="control-label">Dining :</label>
                                                <?= Html::textInput('BuyerWorkSheet[dining]', $workSheet->dining, ['class' => 'form-control','placeholder' => 'eg: 10','onkeypress'=>'return isNumberKey(event)']) ?>
                                            </div>
                                            <div class="form-group col-sm-3">
                                              <label for="" class="control-label">Stories :</label>
                                                <?= Html::textInput('BuyerWorkSheet[stories]', $workSheet->stories, ['class' => 'form-control','placeholder' => 'Enter Stories']) ?>
                                            </div>
                                            <div class="form-group col-sm-3">
                                              <label for="" class="control-label">Square footage :</label>
                                                <?= Html::textInput('BuyerWorkSheet[square_footage]', $workSheet->square_footage, ['class' => 'form-control','placeholder' => 'eg: 123.50','onkeypress'=>'return isNumberKeyWithDot(event)']) ?>
                                            </div>
                                            <div class="form-group col-sm-3">
                                              <label for="" class="control-label">Ceilings(In Ft.) :</label>
                                                <?= Html::textInput('BuyerWorkSheet[celling]', $workSheet->celling, ['class' => 'form-control','placeholder' => 'Enter Ceilings']) ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group">
                                              <label for="" class="control-label">Additional comments about features :</label>
                                                <?= Html::textarea('BuyerWorkSheet[comment_location]', $workSheet->comment_location, ['class' => 'form-control','rows' => '5','style' => 'resize:none;']) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="nar-information">
                                    <div class="col-sm-4">
                                        <h5>Property Type :</h5>
                                        <div class="form-group">
                                            <?php echo $form->field($workSheet, 'propertyTypes')->checkBoxList(ArrayHelper::map(PropertyType::find()->all(), 'id', 'title'))->label(false) ?>  
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <h5>Property Amenities :</h5>
                                        <div class="form-group">
                                            <?php echo $form->field($workSheet, 'propertyAmenities')->checkBoxList($amenitiesArr)->label(false) ?>  
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <h5>Other Features :</h5>
                                        <div class="form-group">
                                            <?php echo $form->field($workSheet, 'otherFeatures')->checkBoxList($featuresArr)->label(false) ?>  
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="nar-information">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="form-group">
                                              <label for="" class="control-label">Additional comments about amenities :</label>
                                                <?= Html::textarea('BuyerWorkSheet[amenities_comment]', $workSheet->amenities_comment, ['class' => 'form-control','rows' => '5','style' => 'resize:none;']) ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group">
                                              <label for="" class="control-label">Please write any additional criteria on the lines below. :</label>
                                                <?= Html::textarea('BuyerWorkSheet[additional_criteria]', $workSheet->additional_criteria, ['class' => 'form-control','rows' => '5','style' => 'resize:none;']) ?>
                                            </div>
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