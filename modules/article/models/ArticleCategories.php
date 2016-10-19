<?php

namespace app\modules\article\models;

use Yii;

/**
 * This is the model class for table "np_article_categories".
 *
 * @property integer $id_categories
 * @property integer $id_article
 * @property integer $id_tree
 */
class ArticleCategories extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'np_article_categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_article', 'id_tree'], 'required'],
            [['id_article', 'id_tree'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_categories' => 'Id Categories',
            'id_article' => 'Id Article',
            'id_tree' => 'Id Tree',
        ];
    }
}
