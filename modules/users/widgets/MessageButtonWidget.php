<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\modules\users\widgets;

class MessageButtonWidget extends \yii\bootstrap\Widget
{
	public $user;
	
	public $no_btn = false;

    public function run()
    {
		return $this->render('message_buttons', [
			'user' => $this->user,
			'no_btn' => $this->no_btn,
		]);
    }
	
}
