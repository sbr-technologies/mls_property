<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\models\PropertyType;

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
?>
<div class="row">
    <h5>Location :</h5>
    <div class="nar-information">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-3">
                    <?= $form->field($model, 'state')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'city')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'area')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'lga')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <?= $form->field($model, 'comment_location')->textarea(['maxlength' => true,'class'=> 'form-control']) ?>
                </div>
            </div>
        </div>
    </div>
    <h5>Economics :</h5>
    <div class="nar-information">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-4">
                    <label for="" class="control-label">Price range from (&#8358;) : </label>
                    <?= Html::activeTextInput($model, 'price_range_from', ['class' => 'form-control', 'placeholder' => 'Price Range From', 'onkeypress' => 'return isNumberKey(event)']) ?>
                </div>
                <div class="col-sm-4">
                    <label for="" class="control-label">Price range to (&#8358;) :</label>
                    <?= Html::activeTextInput($model, 'price_range_to', ['class' => 'form-control', 'placeholder' => 'Price Range To', 'onkeypress' => 'return isNumberKey(event)']) ?>
                </div>
                <div class="col-sm-4">
                    <label for="" class="control-label">How soon needed? :</label>
                    <?= $form->field($model, 'how_soon_need')->dropDownList($soonNeedArr, ['class' => 'form-control selectpicker'])->label(false) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <label for="" class="control-label">Usage :</label>
                    <?= $form->field($model, 'usage')->dropDownList($usagesArr, ['class' => 'form-control selectpicker'])->label(false) ?>
                </div>
                <div class="col-sm-4">
                    <label for="" class="control-label">Investment :</label>
                    <?= Html::activeTextInput($model, 'investment', ['class' => 'form-control', 'placeholder' => 'eg: 12345.50', 'onkeypress' => 'return isNumberKeyWithDot(event)']) ?>
                </div>
                <div class="col-sm-4">
                    <label for="" class="control-label">Cash flow (per Month):</label>
                    <?= Html::activeTextInput($model, 'cash_flow', ['class' => 'form-control', 'placeholder' => '12345.50', 'onkeypress' => 'return isNumberKeyWithDot(event)']) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <label for="" class="control-label">Appreciation (in % per Year) :</label>
                    <?= Html::activeTextInput($model, 'investment', ['class' => 'form-control', 'placeholder' => '12345.50', 'onkeypress' => 'return isNumberKeyWithDot(event)']) ?>
                </div>
                <div class="col-sm-4">
                    <label for="" class="control-label">Need Agent :</label>
                    <?= $form->field($model, 'need_agent')->dropDownList(['Yes' => 'Yes', 'No' => 'No'], ['prompt' => 'Select'])->label(false) ?>
                </div>
                <div class="col-sm-4">
                    <label for="" class="control-label">Contact me :</label>
                    <?= $form->field($model, 'contact_me')->dropDownList(['Yes' => 'Yes', 'No' => 'No'], ['prompt' => 'Select'])->label(false) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <label for="" class="control-label">Condition :</label>
                    <?= $form->field($model, 'condition')->dropDownList($conditionsArr, ['class' => 'form-control selectpicker'])->label(false) ?>
                </div>
            </div>
        </div>
    </div>
    <h5>Features :</h5>
    <div class="nar-information"
         <div class="col-sm-12">
            <div class="">
                <div class="col-sm-3">
                    <label for="" class="control-label">Age / year built :</label>
                    <?= Html::activeTextInput($model, 'year_built', ['class' => 'form-control', 'placeholder' => 'eg: 2007', 'onkeypress' => 'return isNumberKey(event)', 'maxlength' => 4]) ?>
                </div>
                <div class="col-sm-3">
                    <label for="" class="control-label">Beds :</label>
                    <?= Html::activeTextInput($model, 'bed', ['class' => 'form-control', 'placeholder' => 'eg: 10', 'onkeypress' => 'return isNumberKey(event)']) ?>
                </div>
                <div class="col-sm-3">
                    <label for="" class="control-label">Baths :</label>
                    <?= Html::activeTextInput($model, 'bath', ['class' => 'form-control', 'placeholder' => 'eg: 10', 'onkeypress' => 'return isNumberKey(event)']) ?>
                </div>
                <div class="col-sm-3">
                    <label for="" class="control-label">Living :</label>
                    <?= Html::activeTextInput($model, 'living', ['class' => 'form-control', 'placeholder' => 'eg: 10', 'onkeypress' => 'return isNumberKey(event)']) ?>
                </div>
            </div>
            <div class="">
                <div class="col-sm-3">
                    <label for="" class="control-label">Dining :</label>
                    <?= Html::activeTextInput($model, 'dining', ['class' => 'form-control', 'placeholder' => 'eg: 10', 'onkeypress' => 'return isNumberKey(event)']) ?>
                </div>
                <div class="col-sm-3">
                    <label for="" class="control-label">Stories :</label>
                    <?= Html::activeTextInput($model, 'stories', ['class' => 'form-control', 'placeholder' => 'Enter Stories']) ?>
                </div>
                <div class="col-sm-3">
                    <label for="" class="control-label">Square footage :</label>
                    <?= Html::activeTextInput($model, 'square_footage', ['class' => 'form-control', 'placeholder' => 'eg: 123.50', 'onkeypress' => 'return isNumberKeyWithDot(event)']) ?>
                </div>
                <div class="col-sm-3">
                    <label for="" class="control-label">Ceilings(In Ft.) :</label>
                    <?= Html::activeTextInput($model, 'celling', ['class' => 'form-control', 'placeholder' => 'Enter Ceilings']) ?>
                </div>
            </div>
            <div class="">
                <div class="form-group col-sm-12">
                    <label for="" class="control-label">Additional comments about features :</label>
                    <?= Html::activeTextarea($model, 'comment_location', ['class' => 'form-control', 'rows' => '5', 'style' => 'resize:none;']) ?>
                </div>
            </div>
        </div>

<div class="nar-information">
    <div class="col-sm-4">
        <h4>Property Type :</h4>
        <div class="form-group">
            <?php echo $form->field($model, 'propertyTypes')->checkBoxList(ArrayHelper::map(PropertyType::find()->all(), 'id', 'title'))->label(false) ?>  
        </div>
    </div>
    <div class="col-sm-4">
        <h4>Property Amenities :</h4>
        <div class="form-group">
            <?php echo $form->field($model, 'propertyAmenities')->checkBoxList($amenitiesArr)->label(false) ?>  
        </div>
    </div>
    <div class="col-sm-4">
        <h4>Other Features :</h4>
        <div class="form-group">
            <?php echo $form->field($model, 'otherFeatures')->checkBoxList($featuresArr)->label(false) ?>  
        </div>
    </div>
</div>

<div class="nar-information">
    <div class="col-sm-12">
        <div class="">
            <div class="form-group">
                <label for="" class="control-label">Additional comments about amenities :</label>
                <?= Html::activeTextarea($model, 'amenities_comment', ['class' => 'form-control', 'rows' => '5', 'style' => 'resize:none;']) ?>
            </div>
        </div>
        <div class="">
            <div class="form-group">
                <label for="" class="control-label">Please write any additional criteria on the lines below. :</label>
                <?= Html::activeTextarea($model, 'additional_criteria', ['class' => 'form-control', 'rows' => '5', 'style' => 'resize:none;']) ?>
            </div>
        </div>
    </div>
</div>
</div>