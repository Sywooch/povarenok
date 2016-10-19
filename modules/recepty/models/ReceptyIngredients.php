<?php

namespace app\modules\recepty\models;

use Yii;

/**
 * This is the model class for table "np_recepty_ingredients".
 *
 * @property integer $id
 * @property integer $recept_id
 * @property integer $ingredient_id
 * @property integer $kolvo
 * @property integer $id_measure
 */
class ReceptyIngredients extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'np_recepty_ingredients';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['recept_id', 'ingredient_id', 'id_measure'], 'required'],
            [['recept_id', 'ingredient_id', 'id_measure'], 'integer'],
            [['kolvo'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'recept_id' => 'Id Catalog',
            'ingredient_id' => 'Ингредиент',
            'kolvo' => 'Кол-во',
            'id_measure' => 'Мера веса',
        ];
    }

    public function getIngredients()
    {
        return $this->hasMany(Ingredients::className(), ['id' => 'ingredient_id']);
    }

	public function getReceptIngredient($id)
	{
		return ReceptyIngredients::find()
			->joinWith('ingredients')
			->where(['recept_id'=>$id])
			->all();	
	}
	
}
