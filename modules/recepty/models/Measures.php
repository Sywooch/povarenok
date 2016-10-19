<?php

namespace app\modules\recepty\models;

use Yii;

/**
 * This is the model class for table "np_measures".
 *
 * @property integer $id
 * @property string $name
 * @property integer $active
 */
class Measures extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'np_measures';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'active'], 'required'],
            [['active'], 'integer'],
            [['name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'active' => 'Активен',
        ];
    }
}
