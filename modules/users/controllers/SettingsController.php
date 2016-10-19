<?php
namespace app\modules\users\controllers;

use Yii;
use yii\web\Controller;
use app\models\User;
use app\modules\users\models\UsersProfile;


/**
 * Site controller
 */
class SettingsController extends Controller
{
	
	public $layout = '@app/views/layouts/recept';
 
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
		$user_id = Yii::$app->user->identity->id;
		$user = $this->findModel($user_id);
		$profile = UsersProfile::find()->where(['user_id' => $user_id])->one();

		if ($user->load(Yii::$app->request->post()) && $profile->load(Yii::$app->request->post())) {
			if ($user->validate() && $profile->validate()) {
				$user->save();
				$user->link('profile', $profile);	
				return $this->redirect(['/users/settings']);
			} 
		} else {		
			return $this->render('index', [
				'user' => $user,
				'profile' => $profile,
			]);	
		}		
	}
		
    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
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
