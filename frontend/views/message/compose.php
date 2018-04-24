<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\View;
use dosamigos\tinymce\TinyMce;

$this->registerJsFile(Yii::$app->getUrlManager()->getBaseUrl() . '/plugins/tokeninput/src/jquery.tokeninput.js', ['depends' => \yii\web\JqueryAsset::className()]);
$this->registerJsFile(Yii::$app->getUrlManager()->getBaseUrl() . '/plugins/ajaxfileupload.js', ['depends' => \yii\web\JqueryAsset::className()]);
$this->registerCssFile(Yii::$app->getUrlManager()->getBaseUrl() . '/plugins/tokeninput/styles/token-input-facebook.css');
$this->registerJsFile(Yii::$app->getUrlManager()->getBaseUrl() . '/js/message.js', ['depends' => \yii\web\JqueryAsset::className()]);
$this->registerJsFile(Yii::$app->getUrlManager()->getBaseUrl() . '/js/message_compose.js', ['depends' => \yii\web\JqueryAsset::className()]);
$localJs = 'var tokenInputUrl = "' . urldecode(Yii::$app->urlManager->createUrl(['/message/search-by-email'])) . '";'
        . 'var uploadMessageDocUrl = "' . urldecode(Yii::$app->urlManager->createUrl(['/message/upload'])) . '";'
        . 'var selectedRecipient = ' . (isset($recipient) && !empty($recipient) ? $recipient : "''") . ';';
$this->registerJs($localJs, View::POS_HEAD);
if (empty($this->title)) {
    $this->title = Yii::t('app', 'Compose a message');
}
?>

<div class="content-wrapper">
  <!-- Content Title Sec -->
  <section class="content-header">
    <h1><?php echo $this->title ?></h1>
    <ol class="breadcrumb">
      <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i> Message</a></li>
      <li class="active">Compose</li>
    </ol>
  </section>
  <!-- Content Title Sec -->

  <!-- Main content -->
  <section class="content">
    <div class="">
      <div class="row">
        <div class="internal-messege-sec">
          <div class="col-md-12">
            <div class="page_holder_div">

              <div class="message_main_part clearfix">
                <?php
//                            $templates = MessageTemplateMaster::find()->where('FIND_IN_SET('.Yii::$app->user->identity->profile_id.', profile_ids) > 0 and status=:status', [':status' => MessageTemplateMaster::STATUS_ACTIVE])->all();
                            echo $this->render(
                                    '_left-sidebar', ['action' => 'compose']
                            )
                ?>

                <div class="col-md-9 col-sm-8">
                  <div class="row">
                    <div class="message_content_part">
                      <div class="message_content_holder compose_message_content_holder">
                        <?php
                        $form = ActiveForm::begin(['id' => 'user-profile-form',
                                    'fieldConfig' => [
                                        'template' => "{input}\n{hint}\n{error}",
                                        'horizontalCssClasses' => [
                                            'label' => 'col-sm-4',
                                            'offset' => '',
                                            'wrapper' => 'col-sm-6',
                                            'error' => '',
                                            'hint' => '',
                                        ],
                                    ],
                        ]);
                        ?>
                        <input type="hidden" name="Message[mdud]" id="mdud" value="" /> 
                        <div class="form-group">
                          <?= $form->field($model, 'to')->textInput(['placeholder' => Yii::t('app', 'To')])->label(false) ?>
                        </div>
                        <div class="form-group">
                          <?= $form->field($model, 'subject')->textInput(['placeholder' => Yii::t('app', "Enter a subject")])->label(false) ?>

                        </div>
                        <div class="form-group">
                          <?php
                          echo $form->field($model, 'message')->widget(TinyMce::className(), [
                              'clientOptions' => [
                                  'plugins' => [
                                  ],
                                  'toolbar' => "undo redo",
                              ],
                              'options' => ['rows' => 6],
                          ])->label(false);
                          ?>


                        </div>
<!--                        <div class="form-group">
                          <div class="input-group"> <span class="input-group-btn"> <span class="btn btn-primary btn-file"> <i class="fa fa-paperclip"></i> <?= Yii::t('app', 'Attach file') ?>
                                <input type="file" name="message_upload_file" id="message_upload_file">
                              </span> </span>

                          </div>
                          <div class="uploaded_files">

                            <div class="col-attachment filetext">

                            </div>
                            <div class="clear"></div>
                          </div>
                        </div>-->
                        <div class="form-group">
                          <button name="" value="Send" class="btn btn_success" type="submit"><?= Yii::t('app', 'Send') ?></button>
                          <button name="" value="Send" class="btn btn_cancel" onclick="document.location.href = '<?= Yii::$app->urlManager->createUrl(['/message/inbox']) ?>'" type="button"><?= Yii::t('app', 'Cancel') ?></button>
                        </div>
                        <?php ActiveForm::end(); ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>

          </div>
        </div>
      </div>
    </div>
  </section>
</div>
