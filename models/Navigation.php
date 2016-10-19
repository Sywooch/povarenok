<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "np_navigation".
 *
 * @property integer $id
 * @property integer $pid
 * @property string $name
 * @property string $path
 * @property integer $active
 * @property integer $prioritet
 * @property integer $created_at
 */
class Navigation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'np_navigation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'path', 'active'], 'required'],
            [['pid', 'active', 'prioritet', 'created_at', 'updated_at'], 'integer'],
			['pid', 'default', 'value' => 0],
			['prioritet', 'default', 'value' => 0],
            [['name', 'path'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Код',
            'pid' => 'Родитель',
            'name' => 'Название',
            'path' => 'Путь',
            'active' => 'Активен',
            'prioritet' => 'Приоритет',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата редактирования',
        ];
    }
	
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),			
        ];
    }
		
}
