<?php
use yii\helpers\Url;
use common\models\Advice;

$adviceListArr = Advice::find()->orderBy(['id' => SORT_ASC])->all();
?>
<section>
    <div class="news-details-top-part">
        <img src="<?= $model->photo->imageUrl ?>" alt="" height="284px">
    </div>

    <div class="inner-content-sec">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="news-details-sec">
                        <h2><?= $model->title ?></h2>
                        <?= $model->content ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="news-similar-topic">
        <div class="container">
            <div class="row">
                <h2>Similar Topics</h2>
                <div class="col-sm-12">
                    <div class="row">
                        <?php
                        if (!empty($adviceListArr)) {
                            foreach ($adviceListArr as $key => $advice) {
                        ?>
                        <div class="col-sm-6">
                            <div class="latest-news-listing">
                                <div class="row">
                                    <div class="col-sm-3 latest-news-listing-img">
                                        <a href="<?php echo Url::to(['news/advice_view','id' => $advice->id]) ?>"><img src="<?= $advice->photo->imageUrl ?>" alt=""></a>
                                    </div>
                                    <div class="col-sm-9 latest-news-listing-con">
                                        <p><?= $advice->getReadMore($advice->content) ?></p>
                                        <span>11 hours ago</span>
                                        <a href="<?php echo Url::to(['news/advice-view','id' => $advice->id]) ?>">Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                            }
                        }
                        ?>
                        
                    </div>

                </div>


            </div>
        </div>
    </div>

</section>
