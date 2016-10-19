<?php
namespace app\modules\users\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\User;
use app\modules\users\models\UsersFriends;
use yii\data\Pagination;


/**
 * Site controller
 */
class FriendsController extends Controller
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
		Yii::$app->view->title = 'Мои друзья';
		Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => 'Мои друзья']); 
		Yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => 'Мои друзья']);
		
		$user = new User();
		
		$old_friends = $user->getOldFriends();
		$new_friends = $user->getNewFriends();
		$out_friends = $user->getOutFriends();
		$friends = $user->getFriends();
			
		switch (Yii::$app->request->get('section')) {
			case 'old':
				$query = $old_friends;
				break;
			case 'new':
				$query = $new_friends;
				break;
			case 'out':
				$query = $out_friends;
				break;
			default:
				$query = $friends;
				break;
		}				

		$pagination = new Pagination(['totalCount' => $query->count(),'pageSize' => 20,'forcePageParam' => false]);
		
		$models = $query->offset($pagination->offset)
			->limit($pagination->limit)
			->all();
	
		return $this->render('index', [
			'models' => $models,
			'pagination' => $pagination,
			'friends' => $user->getOldFriends(),
			'old_friends' => $old_friends,
			'new_friends' => $new_friends,
			'out_friends' => $out_friends,
			'friends' => $friends,
		]);	
		
    }
	
	
	public function actionAdd() 
	{	
		$response = array();

		if (!Yii::$app->user->isGuest) {
				
			$friend_id = Yii::$app->request->post('friend_id');
						
			if (isset($friend_id) and !empty($friend_id)) {

				if (Yii::$app->user->identity->id == $friend_id) {
					
					$response['succes'] = false;
					$response['message'] = 'Это Вы :-)';
				
				} else {

					if (!UsersFriends::isRepeatAdd($friend_id)) {

						if (UsersFriends::isWasAdd($friend_id)) {

							UsersFriends::addFriend($friend_id);

							UsersFriends::updateMutual($friend_id);
													
						} else {
							
							UsersFriends::addNewFriend($friend_id);
							
						}							
		
						$response['succes'] = true;
						$response['message'] = 'Запрос на дружбу был отправлен!';
						$response['url'] = $_SERVER['HTTP_REFERER'];					
												
					} else {
				
						$response['succes'] = false;
						$response['message'] = 'Вы уже отправили запрос на дружбу!';
												
					}
					
				}
			}

		} else {
			
			$response['succes'] = false;		
			$response['message'] = 'Зарегистрируйтесь или войдите в учетную запись';					
			
		}	
		Yii::$app->response->format = Response::FORMAT_JSON;			
		return $response;		
		
	}	
	
	public function actionAdd_repeat() {
		
		$response = array();

		if (!Yii::$app->user->isGuest) {
				
			$friend_id = Yii::$app->request->post('friend_id');
			
			if (isset($friend_id) and !empty($friend_id)) {

				UsersFriends::addFriend($friend_id);
				UsersFriends::updateMutual($friend_id);
			
				$response['succes'] = true;
				$response['message'] = 'Запрос на дружбу был отправлен!';
				$response['url'] = $_SERVER['HTTP_REFERER'];					
				
			}
			
		} else {
			
			$response['succes'] = false;		
			$response['message'] = 'Зарегистрируйтесь или войдите в учетную запись';					
			
		}
		
		echo json_encode($response);			
		
	}
	
	public function actionApply() {
		
		$response = array();
		
		if (!Yii::$app->user->isGuest) {

			$friend_id = Yii::$app->request->post('friend_id');
				
			if (isset($friend_id) and !empty($friend_id)) {

				if (!UsersFriends::isRepeatAdd($friend_id)) {
				
					UsersFriends::addFriend($friend_id);
					
					UsersFriends::updateMutual($friend_id);
				
					$response['succes'] = true;
					$response['message'] = 'Заявка в друзья была принята!';
					$response['url'] = $_SERVER['HTTP_REFERER'];
								
				} else {
					
					$response['succes'] = true;
					$response['message'] = 'Вы уже приняли заявку!';					
					
				}
				
			}
			
		} else {
			
			$response['succes'] = false;		
			$response['message'] = 'Зарегистрируйтесь или войдите в учетную запись';					
			
		}
		
		echo json_encode($response);		
		
	}
		
	public function actionAbort_apply() {
		
		$response = array();
		
		if (!Yii::$app->user->isGuest) {
				
			$friend_id = Yii::$app->request->post('friend_id');
						
			if (isset($friend_id) and !empty($friend_id)) {

				if (UsersFriends::isAgainAdd($friend_id)) {
				
					UsersFriends::cancel($friend_id);

				} else {
				
					UsersFriends::clean($friend_id);
				
				}
			
				$response['succes'] = true;
				$response['message'] = 'Заявка в друзья была отменена!';
				$response['url'] = $_SERVER['HTTP_REFERER'];
							
			}
			
		} else {
			
			$response['succes'] = false;		
			$response['message'] = 'Зарегистрируйтесь или войдите в учетную запись';					
			
		}
		
		echo json_encode($response);		
		
	}
			
	public function actionDelete_friend() {
		
		$response = array();
				
		$friend_id = Yii::$app->request->post('friend_id');
						
		if (isset($friend_id) and !empty($friend_id)) {

			UsersFriends::cancel($friend_id);
	
			$response['succes'] = true;
			$response['message'] = 'Заявка в друзья была удалена!';
			$response['url'] = $_SERVER['HTTP_REFERER'];
						
			
		}

		echo json_encode($response);		
		
	}
		

}
