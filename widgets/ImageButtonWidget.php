<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\widgets;

class ImageButtonWidget extends \yii\bootstrap\Widget
{
	public $user;
    public $imageSmallWidth;
    public $imageSmallHeight;	
    public $actionUrl;	
	
    public function run()
    {
		return $this->render('image_button', [
			'widget' => $this,
		]);
    }
	
}
