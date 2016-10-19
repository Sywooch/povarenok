<?php
namespace app\modules\users\controllers;

use Yii;
use yii\web\Controller;
use app\models\User;
use app\modules\users\models\UsersFriends;
use app\modules\users\models\UsersRecept;
use app\modules\users\models\UsersLike;
use app\modules\comments\models\UsersComment;
use app\modules\recepty\models\Recepty;
use yii\data\Pagination;


/**
 * Site controller
 */
class SiteController extends Controller
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
		Yii::$app->view->title = 'Пользователи';
		Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => 'Пользователи']); 
		Yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => 'Пользователи']); 		
		
		$query = User::find()->where(['status' => 10]);

		$pagination = new Pagination(['totalCount' => $query->count(),'pageSize' => 20,'forcePageParam' => false]);
		
		$models = $query->offset($pagination->offset)
			->limit($pagination->limit)
			->orderBy(['updated_at' => SORT_DESC])
			->all();

		return $this->render('index', [
			'models' => $models,
			'pagination' => $pagination,
		]);		

    }

    public function actionView($id)
    {	
		$user = $this->findModel($id);
		
		Yii::$app->view->title = $user->name;
		Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => $user->name]); 
		Yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => $user->name]); 		
				
		$users_friends = new UsersFriends();		
				
		return $this->render('view', [
			'user' => $user,
			'profile' => $user->profile,
			'count_friends' => count($users_friends->getUserFriends($id)),
			'count_subscribe' => count($users_friends->getUserOldFriends($id)),
			'count_recepts' => UsersRecept::find()->where(['id_user' => $id])->count(),
			'count_notes' => UsersLike::getCountNotes($id,UsersComment::RECEPTY),
		]);
	}
		
    public function actionSaveAvatar()
    {
        $model = $this->findModel(Yii::$app->request->post('User')['id']);
			
		$model->old_image = $model->image;			
			
        if ($model->load(Yii::$app->request->post())) {

			$model->upload();
				
			$model->save();
			
			return $this->redirect(['view', 'id' => $model->id]);
			
        } else {
            return false;
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
