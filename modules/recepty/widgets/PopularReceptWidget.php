<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\modules\recepty\widgets;
 
use app\modules\recepty\models\Recepty;

class PopularReceptWidget extends \yii\bootstrap\Widget
{

    public function run()
    {
		$items = Recepty::find()->where(['active'=>1])
			->orderBy(['count_show' => SORT_DESC])
			->limit(5)
			->all();

		return $this->render('popular', [
			'items' => $items,
			'path_image' => \Yii::$app->params['recepty_image']['image'],

		]);
    }

}
