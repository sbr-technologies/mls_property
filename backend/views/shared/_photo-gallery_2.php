<?php 
use yii\helpers\Html;

if(isset($single) && $single){
    $photos = [$model->photo];
}else{
    $photos = $model->photos;
}

//yii\helpers\VarDumper::dump($photos[0]);die();

if(!empty($photos) && $photos[0] != NULL){
    echo '<div class="gallery-photo-contaner clearfix">';
    foreach($photos as $photo){
        echo '<div class="photo_item">';
        echo "<img src='".$photo->getImageUrl($photo::THUMBNAIL)."' height='150px' width='200px'/>"; ?>
        <?php if(isset($delete) && $delete === true){
            echo Html::a(Yii::t('app', '<i class="fa fa-trash"></i>'), ['delete-photo', 'id' => $photo->id], [
                'class' => 'btn btn-danger lnk_delete_image',
                'id' => $photo->id,
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]);
        }
        echo '</div>';
    }
    echo '</div>';
}