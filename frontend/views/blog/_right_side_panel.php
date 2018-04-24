<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\BlogPostCategory;

$categoryList   = BlogPostCategory::find()->active()->all();


?>

<!-- Blog Search Well -->
<div class="blog-right-box">
    <h3>Blog Search</h3>
    <div class="blog-right-box-inner">
    	<div class="property-search-bar">
        <div class="input-group">
            <input name="" class="form-control" type="text">
            <div class="input-group-btn">
                <button class="btn btn-default" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
            </div>
        </div>
    </div>
    </div>
</div>
<!-- Blog Categories Well -->
<?php 
if(!empty($categoryList)){
?>
    <div class="blog-right-box">
        <h3>Blog Categories</h3>
        <ul class="categories-listing">
            <?php 
            foreach($categoryList as $category){
            ?>
                <li><a href="<?= Url::to(['blog/index','category_id' => $category->id]);?>"><?= $category->title ?></a></li>
            <?php 
            }
            ?>
        </ul>
    </div>
<?php
}
?>