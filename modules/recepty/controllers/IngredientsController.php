<?php
namespace app\modules\recepty\controllers;

use app\modules\recepty\models\Ingredients;

class IngredientsController extends \yii\web\Controller
{
	
    public function actionIndex()
    {	
		$items = new Ingredients();
	
        return $this->render('index',[
			'items' => $items->getIngredientsJoin()
		]);
    }
	
}
