<?php
use yii\web\View;
use yii\helpers\Html;
$sentH = $inboxH = '';

switch ($action) {
    case 'sent':
        $sentH = 'class="active"';
        break;
    case 'inbox':
        $inboxH = 'class="active"';
        break;
}
if (isset($_REQUEST['action'])) {
    switch ($_REQUEST['action']) {
         case 'forward':
            $localJs = 'var rAction = "fd";';
            break;
        default:
            $localJs = 'var rAction = "rp";';
            break;
       
    }
    $this->registerJs($localJs, View::POS_HEAD);
}
?>
<div class="col-md-3 col-sm-4 messages_holder">
    <div class="row">
        <div class="compose_div"><a href="<?= Yii::$app->urlManager->createUrl(['/message/compose']) ?>" class="btn btn_success_small btn-block"><i class="fa fa-pencil"></i> &nbsp; <?=Yii::t('app', 'Compose')?></a></div>
        <div class="option_messages">
            <ul>
                <li <?= $inboxH ?>><a href="<?= Yii::$app->urlManager->createUrl(['/message/inbox']) ?>"><?=Yii::t('app', 'Inbox')?></a></li>
                <li <?= $sentH ?>><a href="<?= Yii::$app->urlManager->createUrl(['/message/sent']) ?>"><?=Yii::t('app', 'Sent')?></a></li>

            </ul>
        </div>
    </div>
    <?php if(isset($templates) && !empty($templates)){?>
    <div >
        <h4><?= Yii::t('app', 'Templates');?></h4>
        <ul class="message-templates">
        <?php
        
        foreach ($templates as $tpl){
           echo Html::tag('li', Html::a(ucfirst($tpl->subject), '#', ['class' => 'lnkMessageTemplate', 'data-subject' => Html::encode($tpl->subject), 'data-content' => str_replace("\n", '</p><p>', Html::encode($tpl->content))])); 
        }?>
            <?php   echo Html::tag('li', Html::a(Yii::t('app', 'Message Administrator'), '#', ['class' => 'lnkMessageTemplate', 'data-subject' => '', 'data-content' =>'', 'data-user' => 'Administrator'])); ?>
        </ul>
    </div>
    <?php }?>
    <div>
        
        
    </div>
</div>
<?php

$js = "$(function(){
        $('.lnkMessageTemplate').on('click', function(){
            var thisLink = $(this);
            if(typeof thisLink.data('user') != 'undefined'){
            console.log(thisLink.data('user'));
                 //$('#messages-to').tokenInput('add', {id: -1, name: 'Administrator'});
               // $('#messages-to').val(thisLink.data('user'));
                $('#messages-to').tokenInput('add', {id: -1, name: thisLink.data('user')});
//                return false;                
            }
            $('#messages-subject').val(thisLink.data('subject'));
            tinymce.activeEditor.execCommand('mceSetContent', false, thisLink.data('content'));
            return false;
        });
    });";
$this->registerJs($js, View::POS_END);