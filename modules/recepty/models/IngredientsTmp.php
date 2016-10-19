<?php

namespace app\modules\recepty\models;

use Yii;

/**
 * This is the model class for table "np_ingredients_tmp".
 *
 * @property integer $id
 * @property string $name
 * @property string $short_desciption
 * @property double $belki
 * @property double $zhiri
 * @property double $yglevodi
 * @property integer $kkal
 */
class IngredientsTmp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'np_ingredients_tmp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['short_desciption'], 'string'],
            [['belki', 'zhiri', 'yglevodi'], 'number'],
            [['kkal'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'short_desciption' => 'Short Desciption',
            'belki' => 'Belki',
            'zhiri' => 'Zhiri',
            'yglevodi' => 'Yglevodi',
            'kkal' => 'Kkal',
        ];
    }
}
