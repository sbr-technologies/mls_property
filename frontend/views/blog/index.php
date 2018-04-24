<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\BlogPostCategory;

$this->title = "Blog";
$blogPost = $dataProvider->getModels();
$categoryName = BlogPostCategory::find()->where(['id' => $category_id])->one();

?>

<!-- Start Content Section ==================================================-->
<section>
    <div class="inner-content-sec">
        <div class="container">
            <div class="row">
                <!-- Blog Entries Column -->
                <div class="col-sm-9">
                    <h2 class="content-title">
                        Blog
                        <?php 
                        if(!empty($categoryName)){
                        ?>
                        <small><?= $categoryName->title ? $categoryName->title : "" ?></small>
                        <?php 
                        }
                        ?>
                    </h2>
                    <!-- First Blog Post -->
                    <?php 
                    if(!empty($blogPost)){
                        foreach($blogPost as $post){
                    ?>
                    	<div class="blog-listing">
                            <h3><a href="<?= Url::to(['blog/detail','id' => $post->id]);?>"><?= $post->title ?></a></h3>
                            <p class="blog-date-time"><span class="glyphicon glyphicon-time"></span> Posted on <?= Yii::$app->formatter->asDatetime($post->created_at) ?> | by <a href="javascript:void(0)"><?= $post->user->fullName ?></a></p>
                            <div class="row">
                                <div class="col-sm-2 blog-img">
                                    <?php if(isset($post->photos[0])){ ?>
                                    <img class="img-responsive" src="<?= $post->photos[0]->imageUrl ?>" alt="">
                                    <?php } ?>
                                </div>
                                <div class="col-sm-10">
                                    <?= $post->content ?>
                                    <a class="btn btn-primary btn-sm red-btn" href="<?= Url::to(['blog/detail','id' => $post->id]);?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                                </div>
                            </div>
                            </div>
                        <?php
                        }
                    }
                    ?>
                    <!-- Pager -->
    				<!--<ul class="pager">
                        <li class="previous">
                            <a href="#">&larr; Older</a>
                        </li>
                        <li class="next">
                            <a href="#">Newer &rarr;</a>
                        </li>
                    </ul>-->
                </div>
    
                <!-- Blog Sidebar Widgets Column -->
                <div class="col-sm-3">
                    <?php echo $this->render('_right_side_panel'); ?>
                </div>
            </div>
        </div>
    </div>

</section>
<!-- Start Content Section ==================================================-->
