<?php

namespace app\modules\users\models;

use Yii;

/**
 * This is the model class for table "np_users_recept".
 *
 * @property integer $id
 * @property integer $id_catalog
 * @property integer $id_user
 */
class UsersRecept extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'np_users_recept';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_catalog', 'id_user'], 'required'],
            [['id_catalog', 'id_user'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_catalog' => 'Id Catalog',
            'id_user' => 'Id User',
        ];
    }
}
