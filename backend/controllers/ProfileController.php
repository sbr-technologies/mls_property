<?php
namespace backend\controllers;

use Yii;
use common\models\User;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class ProfileController extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    
    public function actionManage()
    {
        $userId = Yii::$app->user->id;
        $model = $this->findModel($userId);
        
        $oldFileName = $model->profile_image_file_name;
        $oldFileExt = $model->profile_image_extension;
        
        if ($model->load(Yii::$app->request->post())) {
            $profileImage = $model->uploadImage();
            
            if($model->save()){
                if ($profileImage !== false) { // delete old and overwrite
                    if($oldFileName && $oldFileExt){
                        $model::unlinkFiles($oldFileName, $oldFileExt);
                    }
                    $path = $model->getImageFile();
                    $profileImage->saveAs($path);
                    $model->resizeImage();
                }
                Yii::$app->session->setFlash('success', 'Successfully uploaded');
                return $this->refresh();
            }
        }
        return $this->render('manage', ['model' => $model]);
    }
    
    
    public function actionUpdatePassword(){
        if(Yii::$app->request->isPost){
            $userId = Yii::$app->user->id;
            $model = $this->findModel($userId);
            if($model->load(Yii::$app->request->post())){
                $model->scenario = $model::SCENARIO_UPDATE_PASSWORD;
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                if($model->save()){
                    $model->sendChangePasswordMail();
                    return ['output' => '********'];
                }else{
                    return ['success' => false, 'errors' => $model->errors];
                }
            }
        }
    }

        /**
     * Finds the PropertyCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PropertyCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}