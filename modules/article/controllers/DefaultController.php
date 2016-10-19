<?php

namespace app\modules\article\controllers;

use Yii;
use yii\web\Controller;
use app\modules\article\models\Article;
use app\modules\article\models\ArticleTree;
use app\modules\comments\models\UsersComment;
use app\modules\users\models\UsersLike;
use yii\data\Pagination;
use yii\widgets\ActiveForm;
use yii\web\Response;

/**
 * Default controller for the `article` module
 */
class DefaultController extends Controller
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
			
    /**
     * Renders the index view for the module
     * @return string
     */
	
    public function actionIndex()
    {
		Yii::$app->view->title = 'Статьи';
		Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => 'Статьи']); 
		Yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => 'Статьи']); 		
		
		$query = Article::find()->where(['active' => 1]);

		$pagination = new Pagination(['totalCount' => $query->count(),'pageSize' => 20,'forcePageParam' => false]);
		
		$models = $query->offset($pagination->offset)
			->limit($pagination->limit)
			->orderBy('id desc')
			->all();

		return $this->render('index', [
			'models' => $models,
			'pagination' => $pagination,
		]);		

    }
	
	public function actionFiltr($path)
	{
		$tree = ArticleTree::getTreeByPath($path);

		if ($tree === null) {
            throw new \yii\web\HttpException(404, 'Страница не найдена.');
        }
		
		Yii::$app->view->title = $tree->title;
		Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => $tree->description]); 
		Yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => $tree->keywords]); 
			
		$query = Article::getArticleByTreeId($tree->id);

		$pagination = new Pagination(['totalCount' => $query->count(),'pageSize' => 20,'forcePageParam' => false]);
		
		$models = $query->offset($pagination->offset)
			->limit($pagination->limit)
			->orderBy('id desc')
			->all();
				
		return $this->render('index', [
			'models' => $models,
			'pagination' => $pagination,
			'tree' => $tree,
			'breadcrumbs' => ArticleTree::getBreadcrumbs($tree->id),
			'nameh1' => $tree->name
		]);		

	}
		
	public function actionView($path)
	{
 
		$model = Article::findOne(['path' => $path]);

		if ($model === null) {
            throw new \yii\web\HttpException(404, 'Страница не найдена.');
        }

		Yii::$app->view->title = $model->title;
		Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => $model->description]); 
		Yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => $model->keywords]); 
			
		$model->count_show = ++$model->count_show;
		$model->save();
		
		$id_product = $model->id;
		
		$tree = ArticleTree::getCategoryByIdArticle($id_product);
	
		$comments = UsersComment::getComments($id_product,UsersComment::ARTICLE);

		return $this->render('view', [
			'model' => $model,
			'comments' => $comments,
			'breadcrumbs' => ArticleTree::getBreadcrumbs($tree->id),
			'nameh1' => $model->name
		]);			
	
	}
		
	
}
