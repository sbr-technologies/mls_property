<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use common\models\BlogPost;
Use common\models\BlogPostSearch;
use common\models\BlogComment;
use common\models\BlogCommentSearch;

/**
 * Site controller
 */
class BlogController extends Controller
{
    public function init() {
        $this->layout   =   'public_main';
    }
    /**
     * @inheritdoc
     */
    

    /**
     * @inheritdoc
     */
    public function actions(){
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex($category_id = Null){
        
        $searchModel = new BlogPostSearch();
        $searchModel->status = 'published';
        if(isset($category_id) && $category_id != ''){
            $searchModel->category_id = $category_id;
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', ['dataProvider' => $dataProvider,'category_id' => $category_id]);
    }
    
    public function actionDetail($id){
        $model = BlogPost::findOne(['id' => $id]);
        $commentPost = new BlogComment();
        return $this->render('detail', ['model' => $model, 'commentPost' => $commentPost]);
    }
    
    public function actionSaveBlog(){
        Yii::$app->response->format     = Response::FORMAT_JSON;
        if(Yii::$app->user->isGuest){
            return ['status' => false, 'is_guest' => true, 'message' => 'You are not logged in'];
        }
        $commentPost = new BlogComment();
        $commentPost->status    =   "pending";
        if ($commentPost->load(Yii::$app->request->post())) {
            Yii::$app->response->format     = Response::FORMAT_JSON;
            $transaction = Yii::$app->db->beginTransaction();
            //\yii\helpers\VarDumper::dump($model); exit;
            try {
                if(!$commentPost->save()){
                    return ['success' => false,'errors' => $commentPost->errors];
                }
                
                $transaction->commit();
                return ['success' => true,'message' => 'Thank you for giving your valuable comment.'];
            } catch (Exception $ex) {
                $transaction->rollBack();
            }
        }
    }
}