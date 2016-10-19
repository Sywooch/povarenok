<?php
namespace app\modules\comments\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;
use app\modules\comments\models\UsersComment;


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
        return $this->goHome();
    }
	
		
	public function actionAdd()
	{
		$model = new UsersComment();

        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
			if ($model->load(Yii::$app->request->post())) {

				if (!Yii::$app->user->isGuest) {
					if ($model->save()) {	
						$id_table = $model->id_table;				
						$comments = UsersComment::getComments($id_table,$model->table_name);
						$response['html'] = $this->renderAjax('index',['comments' => $comments]);
						$response['id'] = $id_table;				
						$response['succes'] = true;
					} else {
						$response['succes'] = false;						
					}
				} else {
					$response['succes'] = false;
					$response['message'] = 'Зарегистрируйтесь или войдите в учетную запись';					
				}
				Yii::$app->response->format = Response::FORMAT_JSON;			
				return $response;				
			}
        } 		

	}

	public function actionEdit()
	{
		$id = (int)Yii::$app->request->post('id');		
		$comment = Yii::$app->request->post('comment');		
		$model = UsersComment::findOne(['id' => $id]);
		
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
			$model->comment = $comment;
				if ($model->save()) {	
					$id_table = $model->id_table;
					$comments = UsersComment::getComments($id_table,$model->table_name);
					$response['html'] = $this->renderAjax('index',['comments' => $comments]);
					$response['id'] = $id_table;			
					$response['succes'] = true;				
				} else {
					$response['succes'] = false;				
				}
			
		}

		Yii::$app->response->format = Response::FORMAT_JSON;			
		return $response;		
	}
	
	public function actionDel()
	{
		$id = (int)Yii::$app->request->post('id');		
		$model = UsersComment::findOne(['id' => $id]);
	
		if ($model->delete()) {	
			$id_table = $model->id_table;
			$comments = UsersComment::getComments($id_table,$model->table_name);
			$response['html'] = $this->renderAjax('index',['comments' => $comments]);
			$response['id'] = $id_table;			
			$response['succes'] = true;				
		} else {
			$response['succes'] = false;				
		}

		Yii::$app->response->format = Response::FORMAT_JSON;			
		return $response;		
	}
	
	public function actionEdit_form() {
		
		$response = array();
		
		$id = (int)Yii::$app->request->post('id');	
		$model = UsersComment::findOne($id);		
		$response['succes'] = true;
		$response['html'] = $this->renderAjax('_form_comment_edit',['model' => $model]);

		Yii::$app->response->format = Response::FORMAT_JSON;			
		return $response;	
				
	}
	

}
