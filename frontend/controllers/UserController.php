<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use common\models\User;
use yii\web\NotFoundHttpException;
use common\models\Question;
use common\models\ReviewRating;
use common\models\Recommend;
use common\models\UserSearch;
use common\models\Notification;

use common\components\MailSend;
use common\models\EmailTemplate;
use common\models\Property;
use yii\data\ActiveDataProvider;

class UserController extends Controller{
    
    public function actionUploadCoverPhoto(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $uploadPath = Yii::getAlias('@uploadsPath/tmp');
        $image = $_FILES['img'];
        $name = time(). '_'. str_replace(' ', '_', $image['name']);
        move_uploaded_file($image['tmp_name'], $uploadPath.'/'. $name);
        $image_info = getimagesize($uploadPath.'/'. $name);
//        print_r($image_info);die();
        return [
                    "status" => 'success',
                    "url" => Yii::getAlias('@uploadsUrl/tmp/'. $name),
                    'file' => '',
                    "width" => $image_info[0],
                    "height" => $image_info[1]
                ];
    }
    
    public function actionUpdateCoverPhoto() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $userId = Yii::$app->user->id;
        $imgUrl = $_POST['imgUrl'];
// original sizes
        $imgInitW = $_POST['imgInitW'];
        $imgInitH = $_POST['imgInitH'];
// resized sizes
        $imgW = $_POST['imgW'];
        $imgH = $_POST['imgH'];
// offsets
        $imgY1 = $_POST['imgY1'];
        $imgX1 = $_POST['imgX1'];
// crop box
        $cropW = $_POST['cropW'];
        $cropH = $_POST['cropH'];
// rotation angle
        $angle = $_POST['rotation'];

        $jpeg_quality = 100;

        $basePath = Yii::getAlias('@uploadsPath/User');
        $baseUrl = Yii::getAlias('@uploadsUrl/User');
        $baseName = 'cover_photo_'. rand() . time();
        $output_filename = "$basePath/$baseName";

// uncomment line below to save the cropped image in the same location as the original image.
//$output_filename = dirname($imgUrl). "/croppedImg_".rand();

        $what = getimagesize($imgUrl);

        switch (strtolower($what['mime'])) {
            case 'image/png':
                $img_r = imagecreatefrompng($imgUrl);
                $source_image = imagecreatefrompng($imgUrl);
                $type = '.png';
                break;
            case 'image/jpeg':
                $img_r = imagecreatefromjpeg($imgUrl);
                $source_image = imagecreatefromjpeg($imgUrl);
                error_log("jpg");
                $type = '.jpeg';
                break;
            case 'image/gif':
                $img_r = imagecreatefromgif($imgUrl);
                $source_image = imagecreatefromgif($imgUrl);
                $type = '.gif';
                break;
            default: die('image type not supported');
        }


//Check write Access to Directory

        if (!is_writable(dirname($output_filename))) {
            $response = Array(
                "status" => 'error',
                "message" => 'Can`t write cropped File'
            );
        } else {

            // resize the original image to size of editor
            $resizedImage = imagecreatetruecolor($imgW, $imgH);
            imagecopyresampled($resizedImage, $source_image, 0, 0, 0, 0, $imgW, $imgH, $imgInitW, $imgInitH);
            // rotate the rezized image
            $rotated_image = imagerotate($resizedImage, -$angle, 0);
            // find new width & height of rotated image
            $rotated_width = imagesx($rotated_image);
            $rotated_height = imagesy($rotated_image);
            // diff between rotated & original sizes
            $dx = $rotated_width - $imgW;
            $dy = $rotated_height - $imgH;
            // crop rotated image to fit into original rezized rectangle
            $cropped_rotated_image = imagecreatetruecolor($imgW, $imgH);
            imagecolortransparent($cropped_rotated_image, imagecolorallocate($cropped_rotated_image, 0, 0, 0));
            imagecopyresampled($cropped_rotated_image, $rotated_image, 0, 0, $dx / 2, $dy / 2, $imgW, $imgH, $imgW, $imgH);
            // crop image into selected area
            $final_image = imagecreatetruecolor($cropW, $cropH);
            imagecolortransparent($final_image, imagecolorallocate($final_image, 0, 0, 0));
            imagecopyresampled($final_image, $cropped_rotated_image, 0, 0, $imgX1, $imgY1, $cropW, $cropH, $cropW, $cropH);
            // finally output png image
            //imagepng($final_image, $output_filename.$type, $png_quality);
            imagejpeg($final_image, $output_filename . $type, $jpeg_quality);
            
            $user = User::findOne($userId);
            $user->cover_photo = $baseName.$type;
            $user->save(false);
            
            $response = Array(
                "status" => 'success',
                "url" => "$baseUrl/$baseName$type"
            );
        }

        return $response;
    }
    
    public function actionUploadProfilePhoto(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $uploadPath = Yii::getAlias('@uploadsPath/tmp');
        $image = $_FILES['img'];
        $name = time(). '_'. str_replace(' ', '_', $image['name']);
        move_uploaded_file($image['tmp_name'], $uploadPath.'/'. $name);
        $image_info = getimagesize($uploadPath.'/'. $name);
//        print_r($image_info);die();
        return [
                    "status" => 'success',
                    "url" => Yii::getAlias('@uploadsUrl/tmp/'. $name),
                    'file' => '',
                    "width" => $image_info[0],
                    "height" => $image_info[1]
                ];
    }
    
    public function actionUpdateProfilePhoto() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $userId = Yii::$app->user->id;
        $imgUrl = $_POST['imgUrl'];
// original sizes
        $imgInitW = $_POST['imgInitW'];
        $imgInitH = $_POST['imgInitH'];
// resized sizes
        $imgW = $_POST['imgW'];
        $imgH = $_POST['imgH'];
// offsets
        $imgY1 = $_POST['imgY1'];
        $imgX1 = $_POST['imgX1'];
// crop box
        $cropW = $_POST['cropW'];
        $cropH = $_POST['cropH'];
// rotation angle
        $angle = $_POST['rotation'];

        $jpeg_quality = 100;

        $basePath = Yii::getAlias('@uploadsPath/User');
        $baseUrl = Yii::getAlias('@uploadsUrl/User');
        $baseName = 'cover_photo_'. rand() . time();
        $output_filename = "$basePath/$baseName";

// uncomment line below to save the cropped image in the same location as the original image.
//$output_filename = dirname($imgUrl). "/croppedImg_".rand();

        $what = getimagesize($imgUrl);

        switch (strtolower($what['mime'])) {
            case 'image/png':
                $img_r = imagecreatefrompng($imgUrl);
                $source_image = imagecreatefrompng($imgUrl);
                $type = '.png';
                break;
            case 'image/jpeg':
                $img_r = imagecreatefromjpeg($imgUrl);
                $source_image = imagecreatefromjpeg($imgUrl);
                error_log("jpg");
                $type = '.jpeg';
                break;
            case 'image/gif':
                $img_r = imagecreatefromgif($imgUrl);
                $source_image = imagecreatefromgif($imgUrl);
                $type = '.gif';
                break;
            default: die('image type not supported');
        }


//Check write Access to Directory

        if (!is_writable(dirname($output_filename))) {
            $response = Array(
                "status" => 'error',
                "message" => 'Can`t write cropped File'
            );
        } else {

            // resize the original image to size of editor
            $resizedImage = imagecreatetruecolor($imgW, $imgH);
            imagecopyresampled($resizedImage, $source_image, 0, 0, 0, 0, $imgW, $imgH, $imgInitW, $imgInitH);
            // rotate the rezized image
            $rotated_image = imagerotate($resizedImage, -$angle, 0);
            // find new width & height of rotated image
            $rotated_width = imagesx($rotated_image);
            $rotated_height = imagesy($rotated_image);
            // diff between rotated & original sizes
            $dx = $rotated_width - $imgW;
            $dy = $rotated_height - $imgH;
            // crop rotated image to fit into original rezized rectangle
            $cropped_rotated_image = imagecreatetruecolor($imgW, $imgH);
            imagecolortransparent($cropped_rotated_image, imagecolorallocate($cropped_rotated_image, 0, 0, 0));
            imagecopyresampled($cropped_rotated_image, $rotated_image, 0, 0, $dx / 2, $dy / 2, $imgW, $imgH, $imgW, $imgH);
            // crop image into selected area
            $final_image = imagecreatetruecolor($cropW, $cropH);
            imagecolortransparent($final_image, imagecolorallocate($final_image, 0, 0, 0));
            imagecopyresampled($final_image, $cropped_rotated_image, 0, 0, $imgX1, $imgY1, $cropW, $cropH, $cropW, $cropH);
            // finally output png image
            //imagepng($final_image, $output_filename.$type, $png_quality);
            imagejpeg($final_image, $output_filename . $type, $jpeg_quality);
            
            copy($output_filename. $type, $output_filename. User::THUMBNAIL. $type);
            
            $user = User::findOne($userId);
            $user->profile_image_file_name = $baseName;
            $user->profile_image_extension = trim($type, '.');
            $user->save(false);
            
            $response = Array(
                "status" => 'success',
                "url" => "$baseUrl/$baseName$type"
            );
        }

        return $response;
    }

    
    public function actionViewProfile($slug){
//        $model = User::findByMlsId($mls_id);
        $model = User::findBySlug($slug);
        if(empty($model)){
            throw new NotFoundHttpException;
        }
        
        $s_la = Yii::$app->request->get('s_la');
        $order = ["CONCAT_WS('', town, state)" => SORT_ASC];
        if ($s_la == 'area') {
            $order = ["area" => SORT_ASC];
        } elseif ($s_la == 'town') {
            $order = ["town" => SORT_ASC];
        } elseif ($s_la == 'price') {
            $order = ['price' => SORT_ASC];
        }
        
        //print_r($agentList);die();

        $query = Property::find()->where(['user_id' => $model->id])->activeSold()->orderBy($order);
        
        $listingActivitDataProvider = new ActiveDataProvider([
            'query' => $query
        ]);
        
        $this->layout = 'public_main';
        return $this->render('view-profile', ['model' => $model, 'listingActivitDataProvider' => $listingActivitDataProvider]);
    }
    
    public function actionAskQuestion($id){
        if(Yii::$app->user->isGuest){ 
            Yii::$app->response->format     = Response::FORMAT_JSON;
            return ['status' => false, 'is_guest' => true, 'message' => 'You are not logged in'];
        }else{
            $userId                     =   Yii::$app->user->id;
            $userModel                  =   User::findOne(['id' => $userId]);
            $questioModel   =   new Question();
            if ($questioModel->load(Yii::$app->request->post())) {
                $questioModel->ask_by = Yii::$app->user->id;
                Yii::$app->response->format     = Response::FORMAT_JSON;
                $questioModel->status = 'active';
//                \yii\helpers\VarDumper::dump($questioModel->user->email,12,1); exit;
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if($questioModel->save()){ 
                        $template = EmailTemplate::findOne(['code' => 'ASK_QUESTION_ADMIN']);
                        $adminEmail                             = $questioModel->user->email;
                        $arr['{{%AGENT_NAME%}}']                 = $questioModel->user->fullName;
                        $arr['{{%FULL_NAME%}}']                 = $questioModel->name;
                        $arr['{{%EMAIL%}}']                     = $questioModel->email;
                        $arr['{{%MOBILE%}}']                    = $questioModel->mobile;
                        $arr['{{%DESCRIPTION%}}']               = $questioModel->description;
                        
//                        \yii\helpers\VarDumper::dump($arr,4,12); //exit;
                        MailSend::sendMail('ASK_QUESTION_ADMIN', $adminEmail, $arr);
                        
                        $template = EmailTemplate::findOne(['code' => 'ASK_QUESTION_USER']);
                        $ar['{{%FULL_NAME%}}']                  = $questioModel->name;
                        $ar['{{%AGENT_NAME%}}']                 = $questioModel->user->fullName;
                        
//                        \yii\helpers\VarDumper::dump($ar,4,12); exit;
                        MailSend::sendMail('ASK_QUESTION_USER', $questioModel->email, $ar);
                        $transaction->commit();
                        return ['success' => true,'message' => 'You successfully messaged your selected agents. Expect a response soon!'];//exit;
                    }else{
                        $transaction->rollBack();
                        //\yii\helpers\VarDumper::dump($questioModel->errors);
                        return ['success' => false,'message' => 'Following Fileds can not be blank','errors' => $questioModel->errors];// exit;   
                    }

                } catch (Exception $ex) {
                    $transaction->rollBack();
                }
            }
            return $this->renderAjax('ask-question', [
                'questioModel'  =>  $questioModel,
                'id'            =>  $id,
                'userModel'     =>  $userModel,
            ]);
        }
    }
    
    public function actionWriteReview($id){
        if(Yii::$app->user->isGuest){ 
            Yii::$app->response->format     = Response::FORMAT_JSON;
            return ['status' => false, 'is_guest' => true, 'message' => 'You are not logged in'];
        }else{
            $reviewModel                        =   new ReviewRating();
            if ($reviewModel->load(Yii::$app->request->post())) {
                $reviewModel->user_id          = Yii::$app->user->id;
                $reviewModel->model             =   "User";
                Yii::$app->response->format     = Response::FORMAT_JSON;
                $reviewModel->status            = 'active';
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if($reviewModel->save()){ 
                        $transaction->commit();
                        return ['success' => true,'message' => 'Thank you for your Review'];//exit;
                    }else{
                        $transaction->rollBack();
                        //\yii\helpers\VarDumper::dump($reviewModel->errors);
                        return ['success' => false,'message' => 'Following Fileds can not be blank','errors' => $reviewModel->errors];// exit;   
                    }

                } catch (Exception $ex) {
                    $transaction->rollBack();
                }
            }
            return $this->renderAjax('write-review', [
                'reviewModel' => $reviewModel,
                'id' => $id,
                
            ]);
        }
    }
    
    public function actionRecommend($id){
        if(!Yii::$app->request->isAjax){
            return $this->goHome();
        }
        Yii::$app->response->format     = Response::FORMAT_JSON;
        if(Yii::$app->user->isGuest){
            return ['status' => false, 'is_guest' => true, 'message' => 'You are not logged in'];
        }
        $insert = false;
        $userId = Yii::$app->user->id;
        $recommendModel = Recommend::find()->where(['model' => 'User', 'model_id' => $id])->one();
        //\yii\helpers\VarDumper::dump($userId,4,12); exit;
        if(empty($recommendModel)){
            $model = new Recommend();
            $model->model = 'User';
            $model->model_id = $id;
            $model->recommend_id = $userId;
            $model->save();
            $insert = true;
        }else{
            Recommend::findOne($recommendModel->id)->delete();
        }
        return ['status' => true, 'id' => $id, 'insert' => $insert];
    }
    
    public function actionIndex(){
        $q = Yii::$app->request->get('q');
        $searchModel = new UserSearch();
        $searchModel->keyword = $q;
        $searchModel->status = User::STATUS_ACTIVE;
        $searchModel->profile_id = [3, 4, 5, 6];
        $dataProvider = $searchModel->search(null);
        $found = [];
        foreach ($dataProvider->getModels() as $user) {
            $found[] = ['id' => $user->id, 'name' => $user->fullName.' ('. $user->profile->title. ')'];
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $found;
    }
    
    public function actionNotification() {
        if (Yii::$app->request->isAjax && Yii::$app->user->identity) {
            return $this->renderAjax('//layouts/_notification');
        } else {
            echo "";
        }
    }
    
    public function actionClearNotification() {
        ignore_user_abort();
        if (Yii::$app->request->isAjax && Yii::$app->user->id) {
            $action = Yii::$app->request->post('action');
            $id = Yii::$app->request->post('id');
            if ($action == 'readall') {
                $allMessages = Notification::findAll(['shown_to' => Yii::$app->user->id]);
                foreach ($allMessages as $message) {
                    $message->read = Notification::STATUS_READ;
                    $message->save();
                }
            } else if ($action == 'readit' && $id != '') {
                $message = Notification::findOne(['id' => $id, 'shown_to' => Yii::$app->user->id]);
                if (!empty($message)) {
                    $message->read = Notification::STATUS_READ;
                    $message->save();
                }
            }
            echo "1";
        }
    }
}