<?php

namespace app\modules\comments\widgets;
 
use app\models\User;
use app\modules\comments\models\UsersComment;

class CommentsWidget extends \yii\bootstrap\Widget
{
	public $id_table;
	
	public $id_user;
	
	public $table_name;
	
	public $comments;

    public function run()
    {
		$model = new UsersComment();
		$model->id_table = $this->id_table;
		$model->id_user = $this->id_user;
		$model->table_name = $this->table_name;
		$model->active = 1;

		return $this->render('comments', [
			'model' => $model,
			'widget' => $this,
		]);
    }

}
