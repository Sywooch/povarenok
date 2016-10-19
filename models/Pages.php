<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "np_pages".
 *
 * @property integer $id
 * @property integer $active
 * @property string $name
 * @property string $path
 * @property integer $prioritet
 * @property string $short_description
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 */
class Pages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'np_pages';
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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['active', 'name', 'path', 'prioritet'], 'required'],
            [['active', 'prioritet', 'created_at', 'updated_at'], 'integer'],
            [['short_description'], 'string'],
            [['name', 'path', 'title', 'keywords', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'active' => 'Активен',
            'name' => 'Название',
            'path' => 'Путь',
            'prioritet' => 'Приоритет',
            'short_description' => 'Краткое описание',
            'title' => 'Title',
            'keywords' => 'Keywords',
            'description' => 'Description',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }
}
