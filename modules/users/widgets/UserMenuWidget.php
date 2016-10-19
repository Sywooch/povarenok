<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\modules\users\widgets;

use app\models\User;
use app\modules\users\models\UsersDialogs;

class UserMenuWidget extends \yii\bootstrap\Widget
{
	
    public function run()
    {
		$user = new User();
		$new_friends = $this->getBadge($user->getNewFriends()->count());
		$new_message = $this->getBadge(UsersDialogs::getNewCount());
			
		$items = [
			['url' => ['/users/site/view', 'id' => \Yii::$app->user->identity->id], 'label' => 'Личный кабинет'],
			['url' => ($new_friends) ? ['/users/friends/index', 'section' => 'new'] : ['/users/friends/index'], 'label' => $new_friends.'Мои друзья', 'encode' => false],
			['url' => ['/recepty/default/notifications'], 'label' => 'Мои ответы'],
			['url' => ['/users/messages/index'], 'label' => $new_message.'Мои сообщения', 'encode' => false],
			['url' => ['/users/users-like/index'], 'label' => 'Мои заметки'],
			['url' => ['/users/settings/index'], 'label' => 'Мои настройки'],
		];

		return $this->render('categories', [
			'items' => $items,
		]);
    }
	
	private function getBadge($count)
	{
		return $count > 0 ? '<span class="badge__count pull-right">'.$count.'</span>' : '';
	}
	
}
