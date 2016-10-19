<?php

namespace app\modules\recepty\controllers;

use Yii;
use yii\web\Controller;
use app\modules\recepty\models\Recepty;
use app\modules\recepty\models\form\ParseForm;
use app\modules\comments\models\UsersComment;
use app\modules\recepty\models\ReceptyTree;
use app\modules\recepty\models\Ingredients;
use app\models\User;
use app\functions\VideoThumb;
use yii\data\Pagination;
use yii\web\Response;
use app\functions\Functions;

/**
 * Default controller for the `recepty` module
 */
class DefaultController extends Controller
{
	public $layout = '@app/views/layouts/recept';
	
    public function actionIndex()
    {
		Yii::$app->view->title = 'Кулинарные рецепты';
		Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => 'Кулинарные рецепты с фото']); 
		Yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => 'Кулинарные рецепты с фото']); 		
		
		$query = Recepty::find()->where(['active' => 1]);

		$pagination = new Pagination(['totalCount' => $query->count(),'pageSize' => 20,'forcePageParam' => false]);
		
		$models = $query->offset($pagination->offset)
			->limit($pagination->limit)
			->orderBy('id desc')
			->all();

		return $this->render('index', [
			'models' => $models,
			'pagination' => $pagination,
			'query' => $query,
		]);		

    }
	
	public function actionFiltr($path)
	{
		$tree = ReceptyTree::getTreeByPath($path);
		
		if ($tree === null) {
            throw new \yii\web\HttpException(404, 'Страница не найдена.');
		}	
		
		Yii::$app->view->title = $tree->title;
		Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => $tree->description]); 
		Yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => $tree->keywords]); 
			
		$query = Recepty::getReceptyByTreeId($tree->id)->andWhere(['active' => 1]);

		$pagination = new Pagination(['totalCount' => $query->count(),'pageSize' => 20,'forcePageParam' => false]);
		
		$models = $query->offset($pagination->offset)
			->limit($pagination->limit)
			->orderBy('id desc')
			->all();
				
		return $this->render('index', [
			'models' => $models,
			'pagination' => $pagination,
			'tree' => $tree,
			'query' => $query,
			'breadcrumbs' => ReceptyTree::getBreadcrumbs($tree->id),
		]);		

	}
	
	public function actionView($path)
	{
 
		$model = Recepty::findOne(['path' => $path]);

		if ($model === null) {
            throw new \yii\web\HttpException(404, 'Страница не найдена.');
		}

		if ($model->active === 0) {
            throw new \yii\web\HttpException(423, 'Данный рецепт находится в обработке.');
		}

		$video = new VideoThumb($model->url_video); 

		Yii::$app->view->title = $model->title;
		Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => $model->description]); 
		Yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => $model->keywords]); 
			
		$model->count_show = ++$model->count_show;
		$model->save();
		
		$id_product = $model->id;
		
		$tree = ReceptyTree::getCategoryByIdRecept($id_product);
		
		$html_ingredient = Ingredients::getHtmlIngredient($id_product);

		$comments = UsersComment::getComments($id_product,UsersComment::RECEPTY);
		
		$author = array();

		if (!empty($model->author)) $author = User::findOne($model->author->id_user);
		 
		return $this->render('view', [
			'model' => $model,
			'html_ingredient' => $html_ingredient,
			'comments' => $comments,
			'author' => $author,
			'video' => @$video,
			'breadcrumbs' => ReceptyTree::getBreadcrumbs($tree->id),
		]);			
	
	}
	
    public function actionIngredient($path)
	{
		$ingredient = Ingredients::findOne(['path' => $path]);

		Yii::$app->view->title = $ingredient->name.' - рецепты';
		Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => $ingredient->short_description]); 
		Yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => $ingredient->name.' - рецепты']); 
			
		$query = Recepty::find()
			->joinWith('receptyIngredients')
			->where(['ingredient_id' => $ingredient->id]);

		$pagination = new Pagination(['totalCount' => $query->count(),'pageSize' => 20,'forcePageParam' => false]);
		
		$models = $query->offset($pagination->offset)
			->limit($pagination->limit)
			->orderBy('recept_id desc')
			->all();
				
		return $this->render('index', [
			'models' => $models,
			'query' => $query,			
			'pagination' => $pagination,
			'tree' => $ingredient,
		]);		

	}
		
	public function actionSearch($q)
	{
		Yii::$app->view->title = "Поиск рецептов по запросу ".$q;
		Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => "Поиск рецептов по запросу ".$q]); 
		Yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => "Поиск рецептов по запросу ".$q]); 
			
		$searchModel = new Recepty();
		
		$query = $searchModel->search($q);

		$pagination = new Pagination(['totalCount' => $query->count(),'pageSize' => 20,'forcePageParam' => false]);
		
		$models = $query->offset($pagination->offset)
			->limit($pagination->limit)
			->orderBy('id desc')
			->all();
				
		return $this->render('index', [
			'models' => $models,
			'query' => $query,			
			'pagination' => $pagination,
		]);		

	}
		
    public function actionNotifications()
    {
		Yii::$app->view->title = 'Мои ответы';
		Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => 'Мои ответы']); 
		Yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => 'Мои ответы']); 		

		$query = Recepty::getReceptyNotifications();

		$pagination = new Pagination(['totalCount' => $query->count(),'pageSize' => 20,'forcePageParam' => false]);
		
		$models = $query->offset($pagination->offset)
			->limit($pagination->limit)
			->all();

		return $this->render('index', [
			'models' => $models,
			'query' => $query,
			'pagination' => $pagination,
		]);	
				
	}
	
	public function actionAdd_recept()
	{
		Yii::$app->view->title = 'Добавление рецепта';
		Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => 'Добавление рецепта']); 
		Yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => 'Добавление рецепта']); 	
		
        $model = new Recepty();
		$f = new Functions();
		$parse_model = new ParseForm();

		if (Yii::$app->request->post('ParseForm')) {
			$parse_model = new ParseForm();		
			if ($parse_model->load(Yii::$app->request->post())) {
				$model = $parse_model->parse();
				return $this->render('create', [
					'model' => $model,
					'parse_model' => $parse_model,
				]);
				
			}		
		}
        if ($model->load(Yii::$app->request->post())) {

			$model->upload();
			
			$model->path = $f->translit_path($model->name);
			$model->date_create = date("Y-m-d H:i:s");
				
			$model->save();
							
            return $this->redirect(['/recepty']);
        } else {
            return $this->render('create', [
                'model' => $model,
				'parse_model' => $parse_model,
            ]);
        }
		
	}
	
}
