<?php

namespace app\modules\users\models;

use Yii;

/**
 * This is the model class for table "np_messages".
 *
 * @property integer $id
 * @property string $comment
 * @property string $date_create
 */
class Messages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'np_messages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['comment', 'date_create'], 'required'],
            [['comment'], 'string'],
            [['date_create'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'comment' => 'Сообщение',
            'date_create' => 'Date Create',
        ];
    }
	
	
	public function getLastMessage() 
	{

		$date = Yii::$app->formatter->asDate($this->date_create, 'medium');
		$time = Yii::$app->formatter->asTime($this->date_create, 'short');

		return $date . ' в ' . $time;
	}
		
}
