<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\modules\users\widgets;

use app\modules\recepty\models\Messages;

class FriendsButtonWidget extends \yii\bootstrap\Widget
{
	public $id;
	
	public $btn_style = false;

    public function run()
    {
		return $this->render('friends_buttons', [
			'id' => $this->id,
			'btn_style' => $this->btn_style,
		]);
    }
	
}
