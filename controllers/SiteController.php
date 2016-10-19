<?php
namespace app\controllers;

use Yii;
use app\models\form\ContactForm;
use app\models\form\LoginForm;
use app\models\form\PasswordResetRequestForm;
use app\models\form\ResetPasswordForm;
use app\models\form\SignupForm;
use app\modules\recepty\models\ReceptyTree;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\widgets\ActiveForm;

use app\models\User;
use app\modules\users\models\Users;
use app\modules\users\models\UsersProfile;

/**
 * Site controller
 */
class SiteController extends Controller
{
	
	public $layout = 'recept';
	
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
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
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

    public function actionInsertUsers()
    {
        $models = Users::find()->orderBy(['id' => SORT_ASC])->all();
		foreach($models as $model) {
			/*$new_user = new User();
			$new_user->id = $model->id;
			$new_user->email = $model->email;
			$new_user->image = $model->image;
			$new_user->created_at = strtotime($model->date_create);
			$new_user->updated_at = strtotime($model->last_visit);
			$new_user->status = 10;
			$new_user->username = $model->name;
			$new_user->password_hash = Yii::$app->security->generatePasswordHash($model->password);
			$new_user->generateAuthKey();
			$new_user->save();	
			
			
			$profile = UsersProfile::findOne(['user_id' => $model->id]);
			if (empty($profile->id)) continue;
			$profile->name = $model->name;
			$profile->birthday_day = $model->birthday_day;
			$profile->birthday_month = $model->birthday_month;
			$profile->birthday_year = $model->birthday_year;
			$profile->city = $model->city;
			$profile->current_info = $model->current_info;
			$profile->about = $model->about;
			$profile->interes = $model->interes;
			$profile->sex = $model->sex;
			$profile->save();*/		
			
		}
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
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {	
		$this->layout = 'main';
	
		Yii::$app->view->title = @$title;
		Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => @$description]); 
		Yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => @$keywords]); 
	
		$trees = ReceptyTree::find()
			->where(['active' => 1,'pid' => 1])
			->orderBy('prioritet desc')
			->limit(8)
            ->all();

        return $this->render('index',[
			'trees' => $trees,
		]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
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

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Благодарим Вас за обращение к нам. Мы ответим вам как можно скорее.');
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка отправки электронной почты.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionRegister()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            } 
        } 

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Проверьте свою электронную почту для получения дальнейших инструкций.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'К сожалению, мы не можем сбросить пароль для электронной почты при условии.');
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
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'Новый пароль был сохранен.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
