<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\modules\users\models\UsersFriends;
use app\models\User;

use yii\helpers\ArrayHelper;

$user_friends = new UsersFriends();

$action = 'add';
$text_btn = 'Добавить в друзья';

if (!\Yii::$app->user->isGuest) {

	if ($user_friends->isSubscriber($id)) {
		$action = 'apply';
		$text_btn = 'Принять заявку';						
	} elseif ($user_friends->isFriend($id)) {
		$action = 'delete_friend';
		$text_btn = 'Убрать из друзей';			
	} elseif ($user_friends->isSigned($id)) {
		$action = 'abort_apply';								
		$text_btn = 'Отменить заявку';
	} elseif ($user_friends->isOldest($id)) {
		$action = 'add_repeat';
		$text_btn = 'Добавить снова';
	} 
	
}

?>

<?php ActiveForm::begin([
	'action' => '/users/friends/'.$action,
	'enableAjaxValidation' => false,
	'options' => [
		'class' => 'form-horizontal jsform',
	],
]); ?>								
	<?= Html::input('hidden','friend_id',$id); ?>
	<?= Html::submitButton($text_btn, ['class' => 'btn btn-default '.$btn_style.' button-panel__btn']) ?>
<?php ActiveForm::end(); ?>

