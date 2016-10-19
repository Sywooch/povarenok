<?php

namespace app\modules\users\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "np_users_friends".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $friend_id
 * @property integer $is_mutual
 */
class UsersFriends extends \yii\db\ActiveRecord
{
	const NO_FRIEND = 0;
    const IS_FRIEND = 1;
    const OLD_FRIEND = 2;
 
    public static function getStatusesArray()
    {
        return [
            self::IS_FRIEND => 'Друзья',
            self::NO_FRIEND => 'Не друзья',
        ];
    }
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'np_users_friends';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'friend_id', 'is_mutual'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'friend_id' => 'Friend ID',
            'is_mutual' => 'Is Mutual',
        ];
    }
 
	public static function clean($friend_id) 
	{
		UsersFriends::deleteAll(['user_id' => Yii::$app->user->identity->id, 'friend_id' => $friend_id]);
	}
    
	public static function cancel($friend_id) 
	{
		self::clean($friend_id);

		UsersFriends::updateAll(['is_mutual' => 2],
			['user_id' => $friend_id, 'friend_id' => Yii::$app->user->identity->id]);
	}
	
	public static function updateMutual($friend_id) 
	{
		UsersFriends::updateAll(
			['is_mutual' => self::IS_FRIEND],
			['user_id' => $friend_id, 'friend_id' => Yii::$app->user->identity->id]);
	}
		
	public static function addFriend($friend_id) 
	{
		$friend = new UsersFriends();
		
		$friend->user_id = Yii::$app->user->identity->id;
		$friend->friend_id = $friend_id;
		$friend->is_mutual = self::IS_FRIEND;
		$friend->save();

	}
			
	public static function addNewFriend($friend_id) 
	{
		$friend = new UsersFriends();
		
		$friend->user_id = Yii::$app->user->identity->id;
		$friend->friend_id = $friend_id;
		$friend->is_mutual = self::NO_FRIEND;
		$friend->save();	
	}
	
	public static function getUserFriends($user_id) 
	{
		return UsersFriends::find()
			->where(['is_mutual' => self::IS_FRIEND])
			->andWhere(['user_id' => $user_id])
			->orderBy(['id' => SORT_DESC])
			->all();	
			
	}

	public static function getUserOldFriends($user_id) 
	{
		return UsersFriends::find()
			->where(['is_mutual' => self::OLD_FRIEND])
			->andWhere(['friend_id' => $user_id])
			->orderBy(['id' => SORT_DESC])
			->all();	
			
	}

	public static function getUserOutFriends($user_id) 
	{
		return UsersFriends::find()
			->where(['<>', 'is_mutual', self::IS_FRIEND])
			->andWhere(['user_id' => $user_id])
			->orderBy(['id' => SORT_DESC])
			->all();	
	}

	public static function getUserNewFriends($user_id) 
	{
		return UsersFriends::find()
			->where(['is_mutual' => self::NO_FRIEND])
			->andWhere(['friend_id' => $user_id])
			->orderBy(['id' => SORT_DESC])
			->all();	
	}

	public static function getBadgeFriends($kolvo) 
	{
		return $kolvo ? '<span>'.$kolvo.'</span>' : '';
	}
	

	public static function isRepeatAdd($friend_id) 
	{
		return UsersFriends::find()
			->where(['user_id' => Yii::$app->user->identity->id])
			->andWhere(['friend_id' => $friend_id])
			->count();
	}
	
	public static function isAgainAdd($friend_id) 
	{
		return UsersFriends::find()
			->where(['user_id' => $friend_id])
			->andWhere(['friend_id' => Yii::$app->user->identity->id])
			->andWhere(['is_mutual' => 1])
			->count();
		
	}
		
	public static function isWasAdd($friend_id) 
	{
		return UsersFriends::find()
			->where(['user_id' => $friend_id])
			->andWhere(['friend_id' => Yii::$app->user->identity->id])
			->andWhere(['is_mutual' => 0])
			->count();
	}
	
	public function isFriend($friend_id) 
	{
		$friends = ArrayHelper::getColumn(UsersFriends::getUserFriends(Yii::$app->user->identity->id), 'friend_id');
		return in_array($friend_id,$friends);	
	}

	public function isSubscriber($friend_id) 
	{
		$friends = ArrayHelper::getColumn(UsersFriends::getUserNewFriends(Yii::$app->user->identity->id), 'user_id');
		return in_array($friend_id,$friends);
	}

	public function isSigned($friend_id) 
	{
		$friends = ArrayHelper::getColumn(UsersFriends::getUserOutFriends(Yii::$app->user->identity->id), 'friend_id');
		return in_array($friend_id,$friends);
	}

	public function isOldest($friend_id) 
	{
		$friends = ArrayHelper::getColumn(UsersFriends::getUserOldFriends(Yii::$app->user->identity->id), 'user_id');
		return in_array($friend_id,$friends);
	}
	
	 
}
