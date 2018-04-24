<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\View;
use dosamigos\tinymce\TinyMce;
use frontend\models\Common;
use \common\models\Message;
use common\models\User;

$this->registerJsFile(Yii::$app->getUrlManager()->getBaseUrl() . '/plugins/tokeninput/src/jquery.tokeninput.js', ['depends' => \yii\web\JqueryAsset::className()]);
$this->registerCssFile(Yii::$app->getUrlManager()->getBaseUrl() . '/plugins/tokeninput/styles/token-input-facebook.css');
$this->registerJsFile(Yii::$app->getUrlManager()->getBaseUrl() . '/plugins/ajaxfileupload.js', ['depends' => \yii\web\JqueryAsset::className()]);
$this->registerJsFile(Yii::$app->getUrlManager()->getBaseUrl() . '/js/message.js', ['depends' => \yii\web\JqueryAsset::className()]);
$this->registerJsFile(Yii::$app->getUrlManager()->getBaseUrl() . '/js/message_view.js', ['depends' => \yii\web\JqueryAsset::className()]);
$localJs = 'var tokenInputUrl = "' . urldecode(Yii::$app->urlManager->createUrl(['/user'])) . '";'
        . 'var uploadMessageDocUrl = "' . urldecode(Yii::$app->urlManager->createUrl(['/message/upload'])) . '";';
$this->registerJs($localJs, View::POS_HEAD);
$this->title = Yii::t('app', 'View Message');
?>

<div class="content-wrapper">
  <!-- Content Title Sec -->
  <section class="content-header">
    <h1><?php echo $this->title ?></h1>
    <ol class="breadcrumb">
      <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i> Message</a></li>
      <li class="active">Details</li>
    </ol>
  </section>
  <!-- Content Title Sec -->

  <!-- Main content -->
  <section class="content">
    <div class="">
      <div class="row">
        <div class="internal-messege-sec">
                    <div class="page_holder_div">

                        <div class="message_main_part">
                            <?=
                            $this->render(
                                    '_left-sidebar', ['action' => 'compose']
                            )
                            ?>

                            <div class="col-md-9 col-sm-8">
                                <div class="row">
                                    <div class="message_content_part">
                                        <div class="message_content_top_part clearfix">
                                            <div class="pull-left"><a class="btn dropdown-toggle" href="#"><i class="fa fa-reply"></i> <?=Yii::t('app', 'Reply')?></a></div>


<!--                                            <div class="pull-right"><a class="btn dropdown-toggle" href="<?= Message::next($modelMessage['id']) ?>"><?=Yii::t('app', 'Next')?>  <i class="fa fa-angle-right"></i></a></div>
                                            <div class="pull-right"><a class="btn dropdown-toggle" href="<?= Message::prev($modelMessage['id']) ?>"><i class="fa fa-angle-left"></i> <?=Yii::t('app', 'Prev')?></a></div>-->
                                            <div class="clear"></div>
                                        </div>
                                        <div class="message_content_holder clearfix">


                                            <div class="profile_message_img"> <img alt="<?= $modelMessage['sender']->commonName ?>" src="<?= $modelMessage['sender']->getImageUrl(User::THUMBNAIL) ?> "> </div>
                                            <div class="profile_message_details">
                                                <p><strong><?= Html::encode($modelMessage['subject']) ?></strong></p>
                                                <p><?= $modelMessage['sender']->fullName ?></p>
                                                <p><?= Yii::$app->formatter->asDatetime($modelMessage['created_at']) ?></p>
                                            </div>
                                            <div class="clear"></div>
                                            <div class="message_body">
                                                <div class="message_text_holder">
                                                    <?= $modelMessage['message'] ?>
                                                    <p>---------------</p>
                                                </div>
                                            </div>
                                            <?php if (!empty($attachments)) : ?>
                                                <div class="col-attachment">
                                                    <?php foreach ($attachments as $at) : ?>
                                                        <a target="_blank" href="<?= Yii::$app->urlManager->createUrl(['/messages/attachment-download', 'id' => $at->id]) ?>" class="label label-primary"><i class="fa fa-paperclip"></i> <?= $at->goodFilename ?></a>
                                                    <?php endforeach; ?>
                                                </div>
                                                <div class="clear"></div>
                                            <?php endif; ?>
                                            <div class="message_text_holder">
                                                <?php
                                                $form = ActiveForm::begin(['id' => 'user-reply-form',
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
                                                <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>" />
                                                <input type="hidden" name="Message[mode]" id="mode" value="reply" />

                                                <input type="hidden" name="Message[mdud]" id="mdud" value="" /> 
                                                <div class="message_text_holder_icon">
                                                    <div class="input-group">
                                                        <div class="input-group-btn">
                                                            <button data-toggle="dropdown" class="btn btn-default 
                                                                    dropdown-toggle reply" type="button" aria-expanded="false"> <i class="fa fa-reply"></i><?=Yii::t('app', ' Reply')?> <span class="caret"></span> </button>
                                                            <ul class="dropdown-menu">

                                                                <li ><a class="reply forward" href="javascript:void(0)"><i class="fa fa-mail-forward "></i> <?=Yii::t('app', 'Forward')?></a></li>
                                                            </ul>
                                                        </div>
                                                        <!-- /btn-group -->
                                                        <input type="text" id="to_field" name="Message[to]"  placeholder="Type a name.." class="form-control fade">
                                                    </div>
                                                </div>
                                                <div class="form-group">

                                                    <?php
                                                    echo $form->field($model, 'message')->widget(TinyMce::className(), [
                                                        'clientOptions' => [
                                                            'plugins' => [
                                                            ],
                                                            'toolbar' => "undo redo",
                                                        ],
                                                        'options' => ['rows' => 6, 'style' => 'display:none'],
                                                    ])->label(false);
                                                    ?>
                                                    <textarea id="reply_s_e" class="form-control" placeholder="Click here to reply."></textarea>              

                                                </div>
<!--                                                <div class="form-group">
                                                    <div class="input-group"> <span class="input-group-btn"> <span class="btn btn-primary btn-file"> <i class="fa fa-paperclip"></i>  <?=Yii::t('app', 'Attach file')?>
                                                                <input type="file" name="message_upload_file" id="message_upload_file">
                                                            </span> </span>

                                                    </div>
                                                    <div class="uploaded_files">

                                                        <div class="col-attachment filetext">

                                                        </div>
                                                        <div class="clear"></div>
                                                    </div>
                                                </div>-->
                                                <button name="" value="Send" class="btn btn_success" type="submit"><?=Yii::t('app', 'Send')?></button>    
                                                <button name="" value="Cancel" class="btn btn_success cancel" type="button"><?=Yii::t('app', 'Cancel')?></button>    
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