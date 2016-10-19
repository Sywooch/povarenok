<?php
namespace app\modules\users\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\User;
use app\modules\recepty\models\Recepty;
use app\modules\users\models\UsersLike;
use yii\data\Pagination;


/**
 * Site controller
 */
class UsersLikeController extends Controller
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
		Yii::$app->view->title = 'Мои заметки';
		Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => 'Мои заметки']); 
		Yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => 'Мои заметки']); 		
				
		$id_variate = (Yii::$app->request->get('variate')) ? Yii::$app->request->get('variate') : 2;
		
		$query = Recepty::getReceptyNotes($id_variate);

		$pagination = new Pagination(['totalCount' => $query->count(),'pageSize' => 20,'forcePageParam' => false]);
		
		$models = $query->offset($pagination->offset)
			->limit($pagination->limit)
			->all();

		return $this->render('index', [
			'models' => $models,
			'pagination' => $pagination,			
		]);		
	}
	
	public function actionAdd() 
	{	
		$response = array();
		$response['succes'] = false;
		
		if (!Yii::$app->user->isGuest) {
			
			$id_table = Yii::$app->request->post('id_table');
			$table_name = Yii::$app->request->post('table_name');
			$id_variate = Yii::$app->request->post('id_variate');
				
			if (is_numeric($id_table)) {
				UsersLike::addLike();	

				if ($id_variate == UsersLike::LIKE)	$render_form = '_form_like';
				if ($id_variate == UsersLike::NOTE)	$render_form = '_form_note';
	
				$response['succes'] = true;
				$response['html'] = $this->renderAjax($render_form,[
												'id_table' => $id_table,
												'table_name' => $table_name,
											]);
			}
			
		} else {	
			$response['message'] = 'Зарегистрируйтесь или войдите в учетную запись';	
		}

		Yii::$app->response->format = Response::FORMAT_JSON;			
		return $response;
	}
	
}
