<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\widgets;
 
use yii\helpers\Url;
use app\models\Navigation;

class NavigationWidget extends \yii\bootstrap\Widget
{

    public function run()
    {
		$navigation = Navigation::find()->where(['active' => 1])->orderBy(['prioritet' => SORT_DESC])->all();

		$items = [];
		foreach($navigation as $nav) {
			$items[] = [
					'label' => $nav->name,
					'url' => ['/'.$nav->path],
					'active' => Url::to('') && Url::to('') == '/'.$nav->path ? true : null,
				];
		}

		return $this->render('navigation', [
			'items' => $items,
			'path_image' => \Yii::$app->params['recepty_image']['image'],

		]);
    }

}
