<?php
namespace frontend\controllers;

use Yii;
use yii\web\Response;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\ContactForm;
use common\models\ContactFormDb;
use yii\helpers\StringHelper;
use common\helpers\SendMail;
use yii\helpers\Url;



class ConnectController extends \yii\web\Controller
{ 
    public function init() {
        $this->layout   =   'public_main';
    }
    
      /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact(){
        $model = new ContactForm();
        
        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format     = Response::FORMAT_JSON;
            if($model->sendContactMessage()){
                return ['success' => true,'message' => 'Thank you for contacting us.'];
            }else{
                return ['success' => false,'errors' => $model->errors];
            }
        }
        return $this->render('contact',['model' => $model]);
    }
    public function actionLocate(){
        return $this->render('locate');
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

}