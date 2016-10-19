<?php

namespace app\modules\users\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "np_users_like".
 *
 * @property integer $id
 * @property integer $id_user
 * @property integer $id_table
 * @property integer $id_variate
 * @property string $table_name
 */
class UsersLike extends \yii\db\ActiveRecord
{
	const LIKE = 1;
	const NOTE = 2;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'np_users_like';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'id_table', 'id_variate', 'table_name'], 'required'],
            [['id_user', 'id_table', 'id_variate'], 'integer'],
            [['table_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'id_table' => 'Id Table',
            'id_variate' => 'Id Variate',
            'table_name' => 'Table Name',
        ];
    }

	public static function getCountNotes($id_user,$table_name) 
	{	
		return UsersLike::find()
					->where(['id_user' => $id_user])
					->andWhere(['table_name' => $table_name])
					->andWhere(['id_variate' => self::NOTE])
					->count();

	}

	public static function addLike() 
	{	
		/* id_variate, 1: like, 2: note */
		$request = Yii::$app->request->post();
		if (isset($request['id_variate'])) {

			if (isset($request['id_table']) and !empty($request['id_table'])) {
			
				$id_table = $request['id_table'];
				$id_variate = $request['id_variate'];
				$table_name = $request['table_name'];
				$users_like = self::getUsersVariate($id_table,$id_variate,$table_name);
								
				if (isset($users_like) and !empty($users_like)) {	
					$model = UsersLike::findOne(['id'=>$users_like['id']]);
					$model->delete();				
				} else {	
					$model = new UsersLike;
					$model->id_user = Yii::$app->user->getId();
					$model->id_table = $id_table;
					$model->id_variate = $id_variate;
					$model->table_name = $table_name;
					$model->save();								
				}				
			}
		}
	}
  
	public static function getUsersVariate($id_table,$id_variate,$table_name) 
	{
		return UsersLike::find()
			->where([
				'id_table' => $id_table,
				'table_name' => $table_name,
				'id_variate' => $id_variate,	
				'id_user' => Yii::$app->user->getId()
			])
			->limit(1)
			->orderBy(['id'=>'desc'])
			->one();
	}

	public static function getCountVariate($id_table,$id_variate,$table_name) 
	{
		$result = UsersLike::find()
			->where([
				'id_table' => $id_table,
				'table_name' => $table_name,
				'id_variate' => $id_variate
			])
			->orderBy(['id'=>'desc'])
			->count();
			
		if ($result > 0) return $result;
	}

	public static function getStatusClass($elem) 
	{		
		return (isset($elem) && !empty($elem)) ? '' : '-empty';
	}

}
