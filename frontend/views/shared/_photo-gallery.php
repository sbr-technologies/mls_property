<?php 
use yii\helpers\Html;
use common\models\PhotoGallery;
use yii\web\View;

if(isset($single) && $single){
    $photos = [$model->photo];
}else{
    $photos = $model->photos;
}

if(!isset($size)){
    $size = PhotoGallery::THUMBNAIL;
}

//yii\helpers\VarDumper::dump($photos,4,12);die();

if(!empty($photos) && $photos[0] != NULL){
    echo '<div class="gallery-photo-contaner clearfix">';
    foreach($photos as $key => $photo){
        echo '<div class="photo_item">';
        echo "<img src='".$photo->getImageUrl($size)."' />"; ?>
        <?php if(isset($delete) && $delete === true){
            echo Html::a(Yii::t('app', '<i class="fa fa-trash"></i>'), ['delete-photo', 'id' => $photo->id, 'property_id' => $model->id], [
                'class' => 'btn btn-danger frmbtngroup btn_delete_photo',
                'id' => $photo->id,
                'data' => [
                    'method' => 'post',
                ],
            ]);
        }
        if(isset($update) && $update === true){
            echo '<div class="row">';
                echo '<div class="form-group col-sm-9">';
                    echo Html::hiddenInput('property_photo['.$key.'][id]',$photo->id ? $photo->id : '', ['class' => 'form-control propertyImageCls','id' => 'id']);
                    echo Html::hiddenInput('property_photo['.$key.'][property_id]',$model->id ? $model->id : '', ['class' => 'form-control','id' => 'proprty_id']);
                    echo Html::textInput('property_photo['.$key.'][description]',$photo->description ? $photo->description : '', ['class' => 'form-control','placeholder' => 'Add Caption','id' => 'description']);
                echo '</div>';
                echo '<div class="form-group col-sm-3">';
                    echo Html::textInput('property_photo['.$key.'][sort_order]',$photo->sort_order == 999 ? "": $photo->sort_order, ['class' => 'form-control','id' => 'sort_order']);
                echo '</div>';
            echo '</div>';
        }else if(isset($view) && $view === true){
            echo '<label class="control-label text-center">';
            echo $photo->description ? $photo->description : '';
            echo '</span>';
        }
        
        echo '</div>';
        
    }
    echo '</div>';
}

$js = "$(function(){
        $('.gallery-photo-contaner').on('click', '.btn_delete_photo', function(e){
            e.preventDefault();
            if(!confirm('Are you sure you want to delete this item?')){
                return false;
            }
            var thisButton = $(this);
            $.post(thisButton.attr('href'), {}, function(response){
                if(response.status == true){
                    thisButton.closest('.photo_item').remove();
                }
            }, 'json');
            return false;
        });
});";

$this->registerJs($js, View::POS_END);