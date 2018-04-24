<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\web\View;
use yii\helpers\Url;
$user = Yii::$app->user->identity;
?>

<div class="photo-upload-sec">
  <div class="row">
    <div class="col-sm-12">
      <div class="manage-profile-cover-image">
      
        <!--<img src="<?= Yii::$app->urlManager->baseUrl ?>/public_main/images/cover-pic.jpg" alt="">-->
        <img src="<?php if($user->coverPhotoUrl)echo $user->coverPhotoUrl;else echo Yii::$app->urlManager->baseUrl. '/public_main/images/cover-pic.jpg'?>" alt="">
        <div class="fileinput fileinput-new" data-provides="fileinput">
          <span class="btn btn-default btn-file" id="cover_photo_upload_btn"><span>Upload Cover Photo</span></span>
        </div>
        <div id="cropContainerCoverPhoto"></div>
      </div>

      <div class="manage-profile-image">
        <img src="<?php if($user->imageUrl) echo $user->imageUrl;else echo Yii::$app->urlManager->baseUrl. '/public_main/images/add-photo-img.jpg' ?>" alt="">
<!--        <div class="fileinput fileinput-new" data-provides="fileinput">
          <span class="btn btn-default btn-file" id="profile_photo_upload_btn"><span>Upload Profile Photo</span></span>
        </div>-->
        
        <div class="fileinput fileinput-new" data-provides="fileinput">
          <span class="btn btn-default btn-file" id="profile_photo_upload_btn"><span>Upload Profile Photo</span></span>
        </div>
        <div id="cropContainerProfilePhoto"></div>
      </div>
    </div>
  </div>
</div>


<?php
$this->registerJsFile(
    '@web/plugins/croppic/croppic.js?v=100',
    ['depends' => [
        \yii\web\JqueryAsset::className(),
        \yii\bootstrap\BootstrapPluginAsset::ClassName()
        ]
    ]
);
$js = "$(function() {
var croppicContainerModalOptions = {
                uploadUrl:'".Url::to(['user/upload-cover-photo'])."',
                cropUrl:'".Url::to(['user/update-cover-photo'])."',
                modal:true,
                imgEyecandyOpacity:0.4,
                customUploadButtonId: 'cover_photo_upload_btn',
                uploadData:{
                    '_fm_token':''
                },
                cropData:{
                    '_fm_token':''
                },
                loaderHtml:'<div class=\"loader\" style=\"background:rgba(38,200,242,.5); padding:10px 0; color:#fff;text-shadow: #000 0px 0 1px; position:absolute; top:0;\"><img src=\"\" alt=\"loader\"> Please wait...</div>'
}
var cropContainerModal = new Croppic('cropContainerCoverPhoto', croppicContainerModalOptions);

var croppicContainerModalOptions = {
                uploadUrl:'".Url::to(['user/upload-profile-photo'])."',
                cropUrl:'".Url::to(['user/update-profile-photo'])."',
                modal:true,
                imgEyecandyOpacity:0.4,
                customUploadButtonId: 'profile_photo_upload_btn',
                uploadData:{
                    '_fm_token':''
                },
                cropData:{
                    '_fm_token':''
                },
                loaderHtml:'<div class=\"loader\" style=\"background:rgba(38,200,242,.5); padding:10px 0; color:#fff;text-shadow: #000 0px 0 1px;  position:absolute; top:0;\"><img src=\"\" alt=\"loader\"> Please wait...</div>',
                onReset:		function(){ console.log('onReset') },
}
var cropContainerModal = new Croppic('cropContainerProfilePhoto', croppicContainerModalOptions);

});
";

$this->registerJs($js, View::POS_END);


$this->registerCssFile(
    '@web/plugins/croppic/croppic.css?v=100',
    ['depends' => [
            yii\web\YiiAsset::className(),
            yii\bootstrap\BootstrapAsset::className(),
        ]
    ]
);
$this->registerCss("#cropContainerCoverPhoto {
    top: 0;
    border: 1px solid #ccc;
    height: 250px;
    position: absolute;
    width: 100%;
}
#cropContainerProfilePhoto {
    top: 0;
    border: 1px solid #ccc;
    height: 192px;
    position: absolute;
    width: 100%;
}");