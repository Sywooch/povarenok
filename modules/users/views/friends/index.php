<?php 
$this->registerCssFile('/css/users/list.css',['depends' => ['app\assets\AppAsset']]);	

use yii\widgets\LinkPager;
use app\modules\users\models\UsersFriends;

$users_friends = new UsersFriends();

$section = Yii::$app->request->get('section');
?>

<div class="item_users">

	<div class="item-preview">

		<div class="page_block_header">
			<h1><?= Yii::$app->view->title; ?></h1>
		</div>
		
		<div class="page_block_tabs">
		
			<div class='friend-tab <?php if ($section === null) echo "active"; ?>'><a href="/users/friends">Все друзья <?= $users_friends->getBadgeFriends($friends->count()); ?></a></div>
			<div class='friend-tab <?php if ($section === 'new') echo "active"; ?>'><a href="/users/friends?section=new">Заявка в друзья <?= $users_friends->getBadgeFriends($new_friends->count()); ?></a></div>
			<div class='friend-tab <?php if ($section === 'out') echo "active"; ?>'><a href="/users/friends?section=out">Исходящие заявки <?= $users_friends->getBadgeFriends($out_friends->count()); ?></a></div>
			<div class='friend-tab <?php if ($section === 'old') echo "active"; ?>'><a href="/users/friends?section=old">Все подписчики <?= $users_friends->getBadgeFriends($old_friends->count()); ?></a></div>
				
		</div>
		
		<div class="row">
			
			<?= $this->render('@app/modules/users/views/site/user_card',['models' => $models]); ?>
			
		</div>
		
	</div>
	
</div>	
<?php
// display pagination
echo LinkPager::widget([
    'pagination' => $pagination
]);
?>
