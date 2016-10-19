<?php
namespace app\modules\adminpanel\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;
use app\models\User;
use app\modules\comments\models\UsersComment;
use app\modules\users\models\UsersLike;

/**
 * Site controller
 */
class SiteController extends Controller
{

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
		$comments = UsersComment::find();
		$users_like = UsersLike::find()->where(['table_name' => UsersComment::RECEPTY,'id_variate' => UsersLike::LIKE])->count();
		$users_note = UsersLike::find()->where(['table_name' => UsersComment::RECEPTY,'id_variate' => UsersLike::NOTE])->count();
		
        return $this->render('index',[
			'comments' => $comments,
			'users_like' => $users_like,
			'users_note' => $users_note,			
		]);
		
    }

}
