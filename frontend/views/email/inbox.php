<?php

use yii\web\View;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use \yii\widgets\LinkPager;
use frontend\models\Common;
use common\models\User;

$this->title = Yii::t('app', 'My Messages Inbox');

switch (Yii::$app->request->get('filter')) {
    case 'read' :
        $messageType = Yii::t('app', 'Read Messages');
        break;
    case 'unread' :
        $messageType = Yii::t('app', 'Unread Messages');
        break;
    default:
        $messageType = Yii::t('app', 'All Messages');
        break;
}
$this->registerJsFile(Yii::$app->getUrlManager()->getBaseUrl() . '/js/message.js', ['depends' => \yii\web\JqueryAsset::className()]);
?>
<div class="content-wrapper">
    <!-- Content Title Sec -->
    <section class="content-header">
        <h1><?php echo $this->title ?></h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i> Message</a></li>
            <li class="active">Inbox</li>
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
            <div class="message_search padding">
              <form action="<?= Yii::$app->request->url ?>" method="get">
                <div class="input-group">
                  <input class="form-control" name="keyword" value="<?= Yii::$app->request->get('keyword') ?>" type="text">
                  <span class="input-group-btn">
                    <button class="btn btn-default" type="submit"> <i class="fa fa-search"></i> </button>
                  </span> </div>
              </form>
            </div>
            <div class="message_main_part">
              <?=
              $this->render(
                      '_left-sidebar', ['action' => 'inbox']
              )
              ?>
              <div class="col-md-9 col-sm-8">

                <div class="row">
                  <div class="message_content_part">
                    <div class="message_content_top_part clearfix">
                      <div class="dropdown pull-left"> 
                        <a href="#" class="btn dropdown-toggle" id="all_messages" data-toggle="dropdown"><?= $messageType ?> <span class="caret"></span> </a>
                        <div class="top_arrow_left dropdown-menu dropdown_toggle" aria-labelledby="all_messages" role="menu">
                          <ul>
                            <li> <a href="<?= Yii::$app->urlManager->createUrl(['/message/inbox']) ?>"><?= Yii::t('app', 'All Messages') ?></a> </li>
                            <li> <a href="<?= Yii::$app->urlManager->createUrl(['/message/inbox', 'filter' => 'read']) ?>"><?= Yii::t('app', 'Read Messages') ?></a> </li>
                            <li> <a href="<?= Yii::$app->urlManager->createUrl(['/message/inbox', 'filter' => 'unread']) ?>"><?= Yii::t('app', 'Unread Messages') ?></a> </li>
                          </ul>
                        </div>
                      </div>

                      <div class="pull-right">
                        <input id="selectall" type="checkbox">
                        <label for="selectall" class="checkbox_class tooltip-test" title="" data-original-title="<?= Yii::t('app', 'Select All') ?>" data-toggle="tooltip"><span></span></label>
                      </div>
                      <div class="pull-right">
                        <a class="btn dropdown-toggle deleteselected" href="#">
                          <i class="fa fa-trash"></i> <?= Yii::t('app', 'Delete') ?>
                        </a>
                      </div>

                      
                    </div>

                    <?php
                    if (!empty($model)) :
                        foreach ($model as $message) :
                            $recipient = $message->getRecipient(Yii::$app->user->id)->one();


                            $sender = $message->sender;
                            ?>
                            <div class="message_content_holder clearfix <?= $recipient->status == 0 ? 'unread_message' : '' ?>">
                              <div class="profile_message_img">
                                <a href="<?= Yii::$app->urlManager->createUrl(['/message/view', 'id' => $message->id]) ?>">
                                  <img src="<?= $sender->getImageUrl(User::THUMBNAIL) ?>" alt="<?= $sender->commonName ?>" height="67" width="67">
                                </a>
                              </div>
                              <div class="profile_message_details">
                                <div class="details_messages"> <a href="<?= Yii::$app->urlManager->createUrl(['/message/view', 'id' => $message->id]) ?>"> <span><strong><?= $sender->fullName ?></strong></span> <span><?= $message->subject ?></span> <span><?= Common::excerpt($message->message) ?></span> </a> </div>
                                <div class="profile_message_footer">
                                  <div class="message_footer_left">
                                    <?=
                                    $this->render(
                                            '_buttons', ['message' => $message]
                                    )
                                    ?>


                                  </div>
                                  <div class="message_footer_right"> <?= Yii::$app->formatter->asDate($message->created_at) ?>
                                    <input id="checkbox<?= $message->id ?>" class="message_action" type="checkbox" value="<?= $message->id ?>">
                                    <label for="checkbox<?= $message->id ?>" class="checkbox_class tooltip-test" title="" data-original-title="<?= Yii::t('app', 'Select this message') ?>" data-toggle="tooltip"><span></span></label>
                                  </div>
                                  <div class="clear"></div>
                                </div>
                              </div>
                              <div class="clear"></div>
                            </div>
                            <?php
                        endforeach;
                    else:
                        ?>
                        <div class="message_content_holder">
                          <p><?php echo Yii::t('app', 'You do not have any messages.') ?></p>
                        </div>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
              <div class="clear"></div>
            </div>
            <div class="message_pagination">
              <?=
              LinkPager::widget([
                  'pagination' => $pages,
              ]);
              ?>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>
</div>