<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use app\modules\users\models\UsersLike;

$count = UsersLike::getCountVariate($id_table,UsersLike::NOTE,$table_name);
$status = UsersLike::getStatusClass(UsersLike::getUsersVariate($id_table,UsersLike::NOTE,$table_name));

?>

<?php ActiveForm::begin([
	'action' => '/users/users-like/add',
	'options' => [
		'class' => 'form_users-like',
	],
]); ?>
<?= Html::input('hidden','id_variate',UsersLike::NOTE); ?>
<?= Html::input('hidden','id_table',$id_table); ?>
<?= Html::input('hidden','table_name',$table_name); ?>
<?= Html::submitButton(
		'<i class="glyphicon glyphicon-star'.$status.'"></i> '.$count,
		[
			'class' => 'btn btn-default btn-sm',
			'title' => 'Добавить в заметки',
		]);
?>
<?php ActiveForm::end(); ?>