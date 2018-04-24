<?php 
use yii\helpers\Html;
use common\models\Attachment;

if(isset($single) && $single){
    $photos = [$model->document];
}else{
    $photos = $model->documents;
}



//yii\helpers\VarDumper::dump($photos[0]);die();
$slNo = 1;
if(!empty($photos) && $photos[0] != NULL){
    echo '<div class="row">';
    foreach($photos as $key => $photo){
        echo Html::hiddenInput('id',$photo->id, ['class' => 'form-control','id' => 'document_id']);
        echo '<div class="form-group col-sm-12">';
            echo '<div class="form-group col-sm-4">';
                echo  $slNo. " : " .$photo->original_file_name; 
            echo '</div>'; 
            echo '<div class="form-group col-sm-6">';
                if(isset($update) && $update === true){
                    echo '<div class="row">';
                        echo '<div class="form-group col-sm-9">';
                            echo Html::textInput('property_document['.$photo->id.'][description]',$photo->description ? $photo->description : '', ['class' => 'form-control','placeholder' => 'Add Caption','id' => 'description']);
                        echo '</div>';
                        echo '<div class="form-group col-sm-3">';
                            echo Html::textInput('property_document['.$photo->id.'][sort_order]',$photo->sort_order == 999 ? '' :$photo->sort_order, ['class' => 'form-control','id' => 'sort_order']);
                        echo '</div>';
                    echo '</div>';
                }else if(isset($view) && $view === true){
                    echo '<label class="control-label text-center">';
                    echo $photo->description ? $photo->description : '';
                    echo '</span>';
                }
            echo '</div>';
            echo '<div class="form-group col-sm-2">';
                //echo Html::button('<i class="fa fa-save"></i>', ['class' => 'btn btn-primary lnk_save_caption']).'&nbsp&nbsp&nbsp';
                if(isset($delete) && $delete === true){
                    echo Html::a(Yii::t('app', '<i class="fa fa-trash"></i>'), ['delete-document', 'id' => $photo->id, 'property_id' => $model->id], [
                        'class' => 'btn btn-danger lnk_delete_image frmbtngroup',
                        'id' => $photo->id,
                        'data' => [
                            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                    ]);
                }
            echo '</div>';
            $slNo++;
        echo '</div>';
        
    }
    
    echo '</div>';
}