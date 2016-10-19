<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\modules\recepty\widgets;
 
use app\modules\recepty\models\ReceptyTree;

class CategoriesWidget extends \yii\bootstrap\Widget
{

	public $category;

    public function run()
    {
        $categories = ReceptyTree::find()->where(['active' => 1])->orderBy('name asc')->all();
			
		$items = $this->getItemsRecursive($categories, 1);

		return $this->render('categories', [
			'items' => $items,
		]);
    }
	
	private function getItemsRecursive($categories, $parentId)
	{
		$items = [];
		foreach($categories as $category) {		
			if ($category->pid == $parentId) {
				$items[] = [
					'label' => $category->name,
					'url' => ['/recepty/default/filtr', 'path' => $category->path],
					'active' => $this->category && $this->category->id == $category->id ? true : null,
					'items' => $this->getItemsRecursive($categories, $category->id),
				];
			}
		}
		return $items;
	}
}
