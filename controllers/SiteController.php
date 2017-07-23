<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use app\models\Mailer as AcmeMailer;
use yii\web\NotFoundHttpException;
use app\components\AuthHandler;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
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
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }
    
    public function onAuthSuccess($client) {
        (new AuthHandler($client))->handle();
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    
    public function actionRegister(){
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        $newUser = new User();
        if ($newUser->load(Yii::$app->request->post()) && $newUser->save() && AcmeMailer::send(AcmeMailer::TYPE_REGISTRATION, $newUser)) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Successfully registered'));
            return $this->goHome();
        }
        return $this->render('register', [
            'newUser' => $newUser
        ]);
    } 
    
    public function actionActivate($user, $token){
        $userToActivate = User::find()->where(['id' => $user, 'uid' => $token])->one();
        
        if(empty($userToActivate)){
            throw new NotFoundHttpException('User not found');
        }
        if(!$userToActivate->activate()){
            Yii::$app->session->setFlash('error', Yii::t('app', 'Can not activate'));            
        }else{
            Yii::$app->session->setFlash('success', Yii::t('app', 'Successfully activated'));
        }
        return $this->goHome();
    }    

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
