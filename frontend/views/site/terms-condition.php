<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use common\models\StaticPage;
use yii\helpers\Url;



//$this->params['breadcrumbs'][] = $this->title;

$staticPage = StaticPage::findByName('Terms and Conditions');

$this->title = $staticPage->pageTitle;
$this->registerMetaTag([
    'name' => 'description',
    'content' => $staticPage->meta_description
]);
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => $staticPage->meta_keywords
]);


?>
<!-- Start Content Section ==================================================-->
<section>
    <div class="inner-content-sec">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 cms-content-sec">
                    <?php
                        if (!empty($staticPage)) {
                    ?>
                    <h2 class="content-title"><?= $staticPage->name ?></h2>
                    <?php
                            echo $staticPage->content;
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>

</section>
<!-- Start Content Section ==================================================-->
