<?php

namespace app\modules\users\models;

use Yii;

/**
 * This is the model class for table "np_users_dialogs".
 *
 * @property integer $id
 * @property integer $iuser_id
 * @property integer $im_user_id
 * @property string $idate
 * @property integer $msg_num
 * @property integer $is_delete
 */
class UsersDialogs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'np_users_dialogs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['iuser_id', 'im_user_id', 'idate', 'msg_num'], 'required'],
            [['iuser_id', 'im_user_id', 'msg_num', 'is_delete'], 'integer'],
            [['idate'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'iuser_id' => 'Iuser ID',
            'im_user_id' => 'Im User ID',
            'idate' => 'Idate',
            'msg_num' => 'Msg Num',
            'is_delete' => 'Is Delete',
        ];
    }
	
	public function getCountMsg() 
	{
		$razryad = $this->msg_num;
		
		if ($this->msg_num > 20) $razryad = $this->msg_num % 10;
		$text = 'новых сообщений';
		if ( $razryad == 1 ) $text = "новое сообщение"; 
		if (( $razryad > 1 ) && ($razryad <= 4)) $text = "новых сообщения"; 

		$result = $this->msg_num.' '.$text;
		
		if ($this->msg_num == 0) $result = "";

		return $result;	
	}
				
	public static function getDialog($limit = false) 
	{
		return UsersDialogs::find()
			->where(['iuser_id' => Yii::$app->user->identity->id])
			->andWhere(['is_delete' => 0])
			->orderBy(['id' => SORT_DESC])
			->all();		
	}
	
	public static function getNewCount() 
	{
		return UsersDialogs::find()->where(['>','msg_num',0])->andWhere(['iuser_id' => Yii::$app->user->identity->id])->count();
	}
			
}
