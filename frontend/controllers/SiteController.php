<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use yii\web\Response;
use common\helpers\SendMail;
use common\models\SiteConfig;
use common\models\UserConfig;
use common\models\User;
use common\models\PropertySearch;
use frontend\models\SocialSignupForm;
use common\models\StaticPage;
use common\models\StaticPageSearch;



use common\components\MailSend;
use common\components\Sms;
use common\models\EmailTemplate;


/**
 * Site controller
 */
class SiteController extends Controller
{
    public function init() {
        $this->layout   =   'public_main';
    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
            'eauth' => [
                // required to disable csrf validation on OpenID requests
                'class' => \nodge\eauth\openid\ControllerBehavior::className(),
                'only' => ['login'],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
//                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionCheckLogin(){
        Yii::$app->response->format     = Response::FORMAT_JSON;
        if(Yii::$app->user->isGuest){
            return ['status' => false, 'is_guest' => true, 'message' => 'You are not logged in'];
        }else{
            return ['status' => true, 'is_guest' => false, 'message' => 'You are logged in'];
        }
    }
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
        
    }
    
    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin($popup = NULL)
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $msg = '';
        $hrs = Yii::$app->request->post('_cur_time');
        if ($hrs >  0) $msg = "Good Morning";      // After 12am
        if ($hrs >= 12) $msg = "Good Afternoon";    // After 12pm
        if ($hrs >= 17) $msg = "Good Evening";      // After 5pm
        
        $redirectUrl = Yii::$app->request->post('_redirect_url');
        $serviceName = Yii::$app->getRequest()->getQueryParam('service');
        if (isset($serviceName)) {
            /** @var $eauth \nodge\eauth\ServiceBase */
            $eauth = Yii::$app->get('eauth')->getIdentity($serviceName);
            $eauth->setRedirectUrl(Yii::$app->getUser()->getReturnUrl());
            $eauth->setCancelUrl(Yii::$app->getUrlManager()->createAbsoluteUrl('site/login'));
            try {
                if ($eauth->authenticate()) {
                    //                 var_dump($eauth->getIsAuthenticated(), $eauth->getAttributes()); exit;
                    $session = Yii::$app->session;
                    $session->open();
                    $reqF = $session->get('requestedFrom');
                    if (!empty($reqF)) {
                        $session->remove('requestedFrom');
                        $this->redirect($reqF);
                    }
                    $identity = User::findByEAuth($eauth);
                    Yii::$app->getUser()->login($identity);
                    // special redirect with closing popup window
                    $user = User::findUserByEAuth($eauth);
                    if ($user) {
                        Yii::$app->user->login($user);
                        $redirectUrl = $user->getDashboardUrl();
                        $eauth->redirect($redirectUrl);
                        
                    } else {

                        $user = User::findByEAuthEmail($eauth);

                        if ($user) {
                            Yii::$app->user->login($user);
                            $redirectUrl = $user->getDashboardUrl();
                            $eauth->redirect($redirectUrl);
                        }
//                        $cookies = Yii::$app->response->cookies;
//                        $cookies->add(new \yii\web\Cookie([
//                            'name' => 'socialSignup', 'value' => 'y'
//                        ]));
//                        $eauth->redirect(['site/index']);
                        $model = new SocialSignupForm();
                        $signup = $model->signup();
                        if ($signup['status'] === true) {
                            $user = $signup['user'];
                            $cookies = Yii::$app->response->cookies;
                            $cookies->remove('socialSignup');

                            Yii::$app->user->login($user);
//                            $auth = Yii::$app->authManager;
//                            $authorRole = $auth->getRole($user->profile->type);
//                            $auth->revokeAll($user->getId());
//                            $auth->assign($authorRole, $user->getId());

                            $userPreferance = new UserConfig();
                            $userPreferance->user_id = $user->id;
                            $userPreferance->title = 'Profile Setup';
                            $userPreferance->type = 'system';
                            $userPreferance->key = 'profileSetup';
                            $userPreferance->value = 'no';
                            $userPreferance->save();
//                            echo $userPreferance->id;die();
                            $redirectUrl = $user->getDashboardUrl();
                            $eauth->redirect($redirectUrl);
                        } else {
                            $eauth->cancel();
                        }
                    }
                } else {
                    // close popup window and redirect to cancelUrl
                    $eauth->cancel();
                }
            } catch (\nodge\eauth\ErrorException $e) {
                // save error to show it later
                Yii::$app->getSession()->setFlash('error', 'EAuthException: ' . $e->getMessage());

                // close popup window and redirect to cancelUrl
//              $eauth->cancel();
                $eauth->redirect($eauth->getCancelUrl());
            }
        }
        
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->login()) {//echo 11;
                $user = Yii::$app->user->identity;
                if(!$redirectUrl){
                    $redirectUrl = $user->dashboardUrl;
                    $welMsg = SiteConfig::item('loginWelcomeMsg');
                    $welMsg = str_replace(['{wish}', '{userName}'], [$msg, $user->fullName], $welMsg);
                    Yii::$app->session->setFlash('success', $welMsg);
                }
                if(Yii::$app->request->isAjax){
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    $res = array(
                        'success' => true, 'message' => \Yii::t('app', 'Login Successfully. Please Wait...'),'redirect_url' => $redirectUrl
                    );
                    return $res;
                }
                return $this->redirect($redirectUrl);
            } else {
                if(Yii::$app->request->isAjax){
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ['success' => false, 'message' => Yii::t('app', 'Invalid Username/Password.')];
                }else{
                    Yii::$app->session->setFlash('error', Yii::t('app', 'Invalid Username/Password.'));
                    return $this->redirect(['site/login']);
                }
            }
        } else {
            if($popup == 1){
                return $this->renderAjax('loginpopup', [
                    'model' => $model,
                ]);
            }
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    public function actionTermsCondition()
    {
        return $this->render('terms-condition');
    }
    public function actionPrivacyPolicy()
    {
        return $this->render('privacy-policy');
    }
    

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup($popup = NULL){
        $model = new SignupForm();
        $siteConfigModel = new SiteConfig();
        $userConfigModel = new UserConfig();
        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $user = $model->signup();
            
            if (empty($model->errors)) {
                return ['success' => true, 'token' => $user->id, 'message' => \Yii::t('app', 'Thank you for your registration. Please check your email for verification.')];
            } else {
                return ['success' => false, "message" => \Yii::t('app', "signup form contains error(s)"), "errors" => $model->errors];
            }
        }
        if($popup == 1){
            return $this->renderAjax('signuppopup', [
                'model' => $model,
            ]);
        }
        return $this->render('signup', [
            'model' => $model,
        ]);
        //return $this->renderAjax('signup', ['model' => $model]);
    }
    /**
     * Email verification Signup user.
     *
     * @return mixed
     */
    
    public function actionVerify($key){
        $error = "Invalide Email activation link";
        if(empty($key)){
            Yii::$app->session->setFlash('error', $error);
            return $this->goHome();
        }
        $user = User::findOne(['email_activation_key' => $key]);
       
        if(empty($user)){
            Yii::$app->session->setFlash('error', $error);
            return $this->goHome();
        }
        $msg = "Your email address has been successfully verified. Please you can now log in.";
        $user->status = 'active';
        $user->email_verified  = 1;
        $user->email_activation_sent = null;
        $user->email_activation_key = null;
        
        $needAdminApproval = SiteConfig::item("userVerification");
//        \yii\helpers\VarDumper::dump($needAdminApproval,12,1); exit;
        if($needAdminApproval == 'yes'){
            $user->status = 'pending_approval';
            $msg = 'Your Email verified successfully.You can login after admin approval';
        }
        if($user->save()){
            $template = EmailTemplate::findOne(['code' => 'NEW_USER_CREATE_PROFILE']);
            $ar['{{%FULL_NAME%}}']                  = $user->fullName;
            $ar['{{%LOGIN_URL_LINK%}}']             = Yii::$app->urlManager->createAbsoluteUrl(['site/login']);

            MailSend::sendMail('NEW_USER_CREATE_PROFILE', $user->email, $ar);
//            Yii::$app
//            ->mailer
//            ->compose(
//                ['html' => 'newUserCreateProfile-html'],
//                ['user' => $user,'loginUrl' => Yii::$app->urlManager->createAbsoluteUrl(['site/login'])]
//
//            )
//            ->setTo($user->email)
//            ->setSubject('Complete your Profile - ' . Yii::$app->name)
//            ->send();
        }
                
        Yii::$app->session->setFlash('success', $msg);
        return $this->goHome();
    }
    public function actionValidateemail(){
        $model = new SignupForm();
        Yii::$app->response->format = Response::FORMAT_JSON;
        $emailId = Yii::$app->request->post('emailId');
        $valid = $model->validateEmailAddress($emailId);
        if($valid == FALSE){
            return ['success' => false, "message" => \Yii::t('app', "This mail address already Registered. Try other !!!")];
        }else{
           return ['success' => true]; 
        }
    }
    
    
    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset(){
        
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->validate()){
                if ($model->sendEmail()) { //echo 11; exit;
                    return ['success' => true, 'message' => 'Password reset link has been sent to your registered email address'];
                }else {// echo 22; exit;
                    return ['success' => false, 'message' => 'Sorry, we are unable to reset password for email provided.'];
                }
            }else {
                return ['success' => false, 'message' => 'Invalid mail Address, Please Enter Registred email Address'];
            }
        }
        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }
    

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token){
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');
            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['success' => true, 'message' => 'Password successfully set', 'redirect_to' => Yii::$app->homeUrl];
            }else{
                return $this->goHome();
            }
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
    
    public function actionPropertyListSearch(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $propertySearch          =   new PropertySearch();
    }
    
    public function actionStaticPage($slug = null){
        $searchModel = new StaticPage();
        $searchModel->slug  =  $slug;
        $staticPage = StaticPage::findBySlug($slug);
        return $this->render('static-page',['staticPage' => $staticPage]);
    }
    
    public function actionPing(){
        $tzOffset = Yii::$app->request->post('tz_offset');
        $tzOffset = -1 * $tzOffset;
        if(!Yii::$app->session->has('tz')){
            $tzModel = \common\models\TimezoneMaster::find()->where(['offset' => $tzOffset])->one();
            if(!empty($tzModel)){
                Yii::$app->session->set('tz', $tzModel->name);
            }
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['status' => true];
    }
    
    public function actionConvertCurrency(){
        $currency = Yii::$app->request->post('selected_currency');
        $cookies = Yii::$app->response->cookies;
        $cookies->add(new \yii\web\Cookie([
	    'name' => 'selected_currency',
	    'value' => $currency,
	]));
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['status' => true, 'currency' => $currency];
    }
    
}
