<?php

namespace app\modules\recepty\models;

use Yii;

/**
 * This is the model class for table "np_recepty_categories".
 *
 * @property integer $id_categories
 * @property integer $recept_id
 * @property integer $tree_id
 */
class ReceptyCategories extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'np_recepty_categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['recept_id', 'tree_id'], 'required'],
            [['recept_id', 'tree_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_categories' => 'Id Categories',
            'recept_id' => 'Catalog ID',
            'tree_id' => 'Tree ID',
        ];
    }
	
}
