<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $questioModel \frontend\models\SignupForm */
use Yii;
use yii\helpers\Html;

use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Contact Info';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile(
    '@web/public_main/js/profile.js',
    ['depends' => [
        \yii\bootstrap\BootstrapPluginAsset::ClassName()
        ]
   ]
);
$contactInfos  =   $dataProvider->getModels();
//\yii\helpers\VarDumper::dump($contactInfos, 4 ,12); exit;
//$this->registerJsFile(Yii::$app->urlManager->baseUrl.'/public_main/js/profile.js', ['depends'=> [\yii\bootstrap\BootstrapPluginAsset::className()]])
?>

<div class="modal-title">
    <h2>Contact Info</h2>
</div>
<div class="modal-body">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <!-- Login Sec -->
    <div class="login-box register-box">
        <div class="login-box-inner">
            <div class="user-index">
                <?php
                if(!empty($contactInfos[0])){
                ?>
                    <div class="row">
                        <?php
                        if($contactInfos[0]->address1 != ''){
                        ?>
                        <div class="form-group">
                            <label class="label label-info">Team :</label>
                            <?= $contactInfos[0]->teamName->name ? $contactInfos[0]->teamName->name : ""  ?>
                        </div>
                        <div class="form-group">
                            <label class="label label-info">Email :</label>
                            <?= $contactInfos[0]->email  ?>
                        </div>
                        <div class="form-group">
                            <label class="label label-info">Phone :</label>
                            (<?= $contactInfos[0]->calling_code  ?>) - <?= $contactInfos[0]->phone_number ?>
                        </div>
                        <div class="form-group">
                            <label class="label label-info">Gender :</label>
                            <?= $contactInfos[0]->genderText  ?>
                        </div>
                        
                        <div class="form-group">
                            <label class="label label-info">Address One</label>
                            <?= $contactInfos[0]->address1  ?>
                        </div>
                        <?php
                        }
                        if($contactInfos[0]->address2 != ''){
                        ?>
                        <div class="form-group">
                            <label class="label label-info">Address Two</label>
                            <?= $contactInfos[0]->address2  ?>
                        </div>
                        <?php
                        }
                        if($contactInfos[0]->city != ''){
                        ?>
                        <div class="form-group">
                            <label class="label label-info">City</label>
                            <?= $contactInfos[0]->city  ?>
                        </div>
                        <?php
                        }
                        if($contactInfos[0]->country != ''){
                        ?>
                        <div class="form-group">
                            <label class="label label-info">Country</label>
                            <?= $contactInfos[0]->country  ?>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                <?php
                }
                ?>
                
            </div>
        </div>
    </div>
    <!-- Login Sec -->
</div>
