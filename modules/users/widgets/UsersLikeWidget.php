<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\modules\users\widgets;

class UsersLikeWidget extends \yii\bootstrap\Widget
{
	public $id_table;

	public $table_name;
	
	public $id_variate;
	
    public function run()
    {
		return $this->render('users_like', [
			'id_table' => $this->id_table,
			'table_name' => $this->table_name,
			'id_variate' => $this->id_variate,
		]);
    }
	
}
