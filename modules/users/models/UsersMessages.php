<?php

namespace app\modules\users\models;

use Yii;
use app\modules\users\models\UsersDialogs;
use app\modules\users\models\Messages;
use app\models\User;
use yii\helpers\Url;

/**
 * This is the model class for table "np_users_messages".
 *
 * @property integer $id
 * @property integer $id_dialog
 * @property integer $for_user_id
 * @property integer $from_user_id
 * @property integer $id_message
 * @property integer $active
 * @property integer $is_read
 * @property integer $is_delete
 */
class UsersMessages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'np_users_messages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_dialog', 'for_user_id', 'from_user_id', 'id_message'], 'required'],
            [['id_dialog', 'for_user_id', 'from_user_id', 'id_message', 'active', 'is_read', 'is_delete'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_dialog' => 'Id Dialog',
            'for_user_id' => 'For User ID',
            'from_user_id' => 'From User ID',
            'id_message' => 'Id Message',
            'active' => 'Active',
            'is_read' => 'Is Read',
            'is_delete' => 'Is Delete',
        ];
    }
	
	public function getUsersDialogs()
	{
		return $this->hasOne(UsersDialogs::className(), ['id' => 'id_dialog']);
	}	
	
	public function getMessages()
	{
		return $this->hasOne(Messages::className(), ['id' => 'id_message']);
	}	
	
	public static function getUsersMessages($for_user_id)
	{
		$id_dialog = self::createDialog(Yii::$app->user->identity->id,$for_user_id);	
		return UsersMessages::find()->where(['id_dialog' => $id_dialog, 'is_delete' => 0])->all();	
	}

	public static function addMessage() 
	{
		$response = array();
		$response['succes'] = false;		
		if (!Yii::$app->user->isGuest) {
				
			$for_user_id = Yii::$app->request->post('id');
			$comment = Yii::$app->request->post('comment');
			
			$user = User::findOne($for_user_id);
			$message = new Messages();
			
			if (!empty($user)) {
				
				$message->comment = $comment;
				$message->date_create = date('Y-m-d H:i:s');
				$message->save();
				$message->getPrimaryKey();

				$dialog = new UsersMessages();
				$dialog->id_message = $message->id;
				$dialog->id_dialog = self::createDialog(Yii::$app->user->identity->id,$for_user_id);
				$dialog->for_user_id = $for_user_id;
				$dialog->from_user_id = Yii::$app->user->identity->id;
				$dialog->save();
				
				$dialog2 = new UsersMessages();
				$dialog2->id_message = $message->id;
				$dialog2->id_dialog = self::createDialog($for_user_id,Yii::$app->user->identity->id);
				$dialog2->for_user_id = $for_user_id;
				$dialog2->from_user_id = Yii::$app->user->identity->id;
				$dialog2->save();

				$response['succes'] = true;
				$response['url'] = Url::to(['/users/messages/dialog','id' => $for_user_id]);

			} else {	
				$response['message'] = 'Такого пользователя не существует';	
			}
		} else {
			$response['message'] = 'Зарегистрируйтесь или войдите в учетную запись';				
		}
		return $response;

	}
	
	public static function createDialog($iuser_id,$im_user_id) 
	{
		$dialog = UsersDialogs::find()
			->where(['iuser_id' => $iuser_id])
			->andWhere(['im_user_id' => $im_user_id])
			->orderBy(['id' => SORT_DESC])
			->one();

		if(empty($dialog)) {

			$new_dialog = new UsersDialogs();
			
			$msg_num = (Yii::$app->user->identity->id == $iuser_id) ? 0 : 1;
			
			$new_dialog->iuser_id = $iuser_id;
			$new_dialog->im_user_id = $im_user_id;
			$new_dialog->idate = date('Y-m-d H:i:s');
			$new_dialog->msg_num = $msg_num;
			$new_dialog->save();
			$new_dialog->getPrimaryKey();
			return $new_dialog->id;
			
		} else {
	
			$msg_num = (Yii::$app->user->identity->id == $dialog->iuser_id) ? $dialog->msg_num : ++$dialog->msg_num;
			
			$dialog->idate = date('Y-m-d H:i:s');
			$dialog->is_delete = 0;
			$dialog->msg_num = $msg_num;
			$dialog->update();
			return $dialog->id;

		}

	}
	
	public static function readMessage($for_user_id) 
	{
		UsersMessages::updateAll(['is_read' => 1],[
			'for_user_id' => Yii::$app->user->identity->id, 
			'from_user_id' => $for_user_id]);

		UsersDialogs::updateAll(['msg_num' => 0],[
			'iuser_id' => Yii::$app->user->identity->id,
			'im_user_id' => $for_user_id]);	
	}
	
	public static function deleteMessage($id) 
	{
		$response = array();
		$response['succes'] = false;		
		if (!Yii::$app->user->isGuest) {		
		
			UsersMessages::updateAll(['is_delete' => 1],['id' => $id]);	

			$response['succes'] = true;
			$response['message'] = 'Сообщение было удалено!';
			$response['url'] = $_SERVER['HTTP_REFERER'];
		} else {
			$response['message'] = 'Зарегистрируйтесь или войдите в учетную запись';			
		}
		
		return $response;
	}
  					
	public static function deleteDialog($id) 
	{
		$response = array();
		$response['succes'] = false;		
		if (!Yii::$app->user->isGuest) {		
		
			UsersMessages::updateAll(['is_delete' => 1, 'is_read' => 1],['id_dialog' => $id]);
			UsersDialogs::updateAll(['is_delete' => 1, 'msg_num' => 0],['id' => $id]);

			$response['succes'] = true;
			$response['message'] = 'Диалог был удален!';
			$response['url'] = $_SERVER['HTTP_REFERER'];
		} else {
			$response['message'] = 'Зарегистрируйтесь или войдите в учетную запись';			
		}
		
		return $response;
	}
  			
}
