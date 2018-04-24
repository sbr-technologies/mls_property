<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>


<?= $form->field($metaTagModel, 'page_title')->textInput(['maxlength' => true]) ?>

<?= $form->field($metaTagModel, 'description')->textarea(['rows' => 6]) ?>

<?= $form->field($metaTagModel, 'keywords')->textInput(['maxlength' => true]) ?>