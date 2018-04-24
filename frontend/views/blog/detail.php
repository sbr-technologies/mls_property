<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\View;
use yii\helpers\Url;
use common\models\BlogComment;


$this->title = "Blog Details";

$comments   = BlogComment::find()->where(['post_id' => $model->id])->active()->all();


$this->registerJsFile(
    '@web/js/jquery.form.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

?>
<!-- Start Content Section ==================================================-->
<section>
    <div class="inner-content-sec">
        <div class="container">
            <div class="row">
                <div class="col-sm-9 blog-details-sec">
                    <h2 class="content-title"><?= $model->title ?></a></h2>
                    <?php 
                    if(!empty($model)){
                    ?>
                        <p class="blog-date-time"><span class="glyphicon glyphicon-time"></span> Posted on <?= Yii::$app->formatter->asDatetime($model->created_at) ?> | by <a href="javascript:void(0)"><?= $model->user->fullName ?></a></p>
                            <div class="row">
                                <div class="col-sm-3 blog-img">
                                    <?php if(isset($model->photos[0])){ ?>
                                    <img class="img-responsive" src="<?= $model->photos[0]->imageUrl ?>" alt="">
                                </div>
                                <div class="col-sm-9">
                                    <?= $model->content ?>
                                </div>
                            </div>

                        <?php
                            }
                    }
                    ?>

                    <div class="blog-connent-sec">
                        <?php
                        if(Yii::$app->user->isGuest){
                        ?>
                        <p>
                           <?= Html::a(Yii::t('app', 'Login to Comment'), ['blog/save-blog'], ['class' => 'btn btn-default red-btn bnt_check_login']) ?>
                        </p>
                        <?php
                        }else{
                        ?>
                        <div class="col-sm-12 give-comment-sec">
                            <h3>Give Comment</h3>
                            <div class="give-comment-inner">
                                <div role="alert" class="alert alert-success alert-dismissible fade in" style="display:none;" id="sucMsgDiv">
                                    <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                                    <span class="sucmsgdiv"></span>
                                </div>
                                <div role="alert" class="alert alert-danger alert-dismissible fade in" style="display:none;" id="failMsgDiv">
                                    <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                                    <span class="failmsgdiv"></span>
                                </div>
                                <div class="col-sm-12">
                                    <?php $form = ActiveForm::begin(['action' => 'save-blog','method' => 'post', 'options' => ['autocomplete' => 'off', 'id' => 'frm_blog_comment_data']]); ?>
                                    <?= $form->field($commentPost, 'post_id')->hiddenInput(['maxlength' => true,'class'=>'form-control','value' => $model->id])->label(false) ?>
                                        <div class="form-sec">
                                            <div class="row">
                                                <div class="form-group">
                                                    <?= $form->field($commentPost, 'title')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group">
                                                    <?= $form->field($commentPost, 'content')->textarea(['class'=> 'form-control','style'=> 'resize:none;']) ?>
                                                </div>
                                            </div>
                                            <div class="form-group text-right">
                                                <?= Html::button($model->isNewRecord ? Yii::t('app', 'comment') : Yii::t('app', 'Comment'), ['class' => $model->isNewRecord ? 'btn btn-default red-btn' : 'btn btn-primary red-btn bnt_save_comment']) ?>
                                            </div>
                                        </div>
                                    <?php ActiveForm::end(); ?>
                                </div>
                            </div>
                        </div>
                        <?php
                        }

                        if(!empty($comments)){
                        ?>
                            <div class="col-sm-12 give-comment-sec">
                                <h3>User Comments</h3>
                                <div class="give-comment-inner">
                                    <?php
                                    foreach($comments as $comment){
                                    ?>
                                        <div class="row">
                                           <div class="col-sm-2">
                                                <div class="thumbnail">
                                                    <?php
                                                    if(isset($comment->user)){
                                                        $userImage = $comment->user->ImageUrl;
                                                        echo Html::img($userImage,['class' => 'img-responsive user-photo']);
                                                    }else{
                                                    ?>
                                                        <img class="img-responsive user-photo" src="https://ssl.gstatic.com/accounts/ui/avatar_2x.png">
                                                    <?php    
                                                    }
                                                    ?>

                                                </div><!-- /thumbnail -->
                                            </div>
                                            <div class="col-sm-10">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <?= $comment->title ?>
                                                    </div>
                                                    <div class="panel-body">
                                                        <?= $comment->content ?>
                                                    </div><!-- /panel-body -->
                                                    <div class="panel-footer text-right">


                                                        <strong><?= ucwords($comment->user->fullName) ?></strong> <span class="text-muted">commented <b><?= $comment->timeElapsedString($comment->created_at) ?></b></span>
                                                    </div>
                                                </div><!-- /panel panel-default -->
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="col-sm-3">
                    <?php echo $this->render('_right_side_panel'); ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Start Content Section ==================================================-->
<?php
$js =   "$(function(){
            $(document).on('click', '.bnt_check_login', function(){
                var thisBtn = $(this);
                $.get(thisBtn.attr('href'), function(response){ 
                    if(response.status === false){
                        $('#mls_bs_modal_one').modal({remote: '".Url::to(['site/login', 'popup' => 1])."'});
                        $('#mls_bs_modal_one').on('shown.bs.modal', function (e) {
                            $('#mls_bs_modal_one').find('.login_redirect_url').val(location.href);
                        });
                    }
                }, 'json');
                return false;
            });
        });";
$this->registerJs($js, View::POS_END);