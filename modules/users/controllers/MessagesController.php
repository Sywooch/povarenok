<?php

namespace app\modules\users\controllers;

use Yii;
use app\models\User;
use app\modules\users\models\UsersMessages;
use app\modules\users\models\UsersDialogs;
use yii\web\Response;
use yii\filters\AccessControl;

class MessagesController extends \yii\web\Controller
{
	
	
	public $layout = '@app/views/layouts/recept';
	
	/**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
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

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
		
    public function actionIndex()
    {
		Yii::$app->view->title = 'Диалоги';
		Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => 'Диалоги']); 
		Yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => 'Диалоги']); 		
				
		$models = UsersDialogs::getDialog();
		
        return $this->render('index',[
			'models' => $models,
		]);
    }
		
    public function actionDialog($id)
    {
		Yii::$app->view->title = 'Диалоги';
		Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => 'Диалоги']); 
		Yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => 'Диалоги']); 		

		$user = User::findOne($id);
		$models = UsersMessages::getUsersMessages($id);
		UsersMessages::readMessage($id);

        return $this->render('dialog',[
			'models' => $models,
			'user' => $user,
		]);
    }
	
    public function actionCreate()
    {
        if (Yii::$app->request->isPost) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			return UsersMessages::addMessage();
        } 
    }
	
    public function actionDelete()
    {
        if (Yii::$app->request->isPost) {
			Yii::$app->response->format = Response::FORMAT_JSON;			
			return UsersMessages::deleteMessage(Yii::$app->request->post('id'));
        } 
    }

	public function actionDialogDel() 
	{
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
			Yii::$app->response->format = Response::FORMAT_JSON;	
			return UsersMessages::deleteDialog(Yii::$app->request->post('id'));
        } 			
	}
			

}
