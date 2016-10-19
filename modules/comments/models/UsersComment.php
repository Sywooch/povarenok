<?php

namespace app\modules\comments\models;

use Yii;

use app\models\User;
use yii\helpers\Html;
use app\modules\article\models\Article;
use app\modules\recepty\models\Recepty;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "np_users_comment".
 *
 * @property integer $id
 * @property integer $id_table
 * @property integer $id_user
 * @property string $comment
 * @property string $created_at
 * @property string $updated_at
 * @property integer $pid
 * @property string $table_name
 * @property integer $active
 */
class UsersComment extends \yii\db\ActiveRecord
{
    const RECEPTY = 'recepty';	
    const ARTICLE = 'article';	
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'np_users_comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_table', 'id_user', 'comment'], 'required'],
            [['id_table', 'id_user', 'pid',  'created_at',  'updated_at', 'active'], 'integer'],
            [['comment'], 'string'],		
            [['table_name'], 'string', 'max' => 100]
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
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_table' => 'Id Table',
            'id_user' => 'Пользователь',
            'comment' => 'Комментарий',
            'created_at' => 'Дата созданий',
            'updated_at' => 'Дата изменения',
            'pid' => 'Pid',
            'table_name' => 'Название таблицы',
            'active' => 'Активен',
        ];
    }
	
	public static function getComments($id_table,$table_name)
	{

		$items = UsersComment::find()
			->where(['active' => 1])
			->andWhere(['table_name' => $table_name])
			->andWhere(['id_table' => $id_table])
			->all();
		
		return $items;		
				
	}

	public static function getCountComment($kolvo) 
	{
		$razryad = $kolvo;
		
		if ($kolvo > 20) $razryad = $kolvo % 10;
		$text = 'комментариев';
		if ( $razryad == 1 ) $text = "комментарий"; 
		if (( $razryad > 1 ) and ($razryad <= 4)) $text = "комментария"; 

		$result = $kolvo.' '.$text;
		
		if ($kolvo == 0) $result = "";
		
		return $result;
	}
	
	public function getDateCreate()
	{
		$date = date('Y-m-d',strtotime($this->updated_at));
		$date_now = date('Y-m-d');
		$yesterday = date('Y-m-d',mktime(0, 0, 0, date('m')  , date('d')-1, date('Y')));
		
		if ($date_now == $date) {
			$result = 'cегодня';
		} elseif ($yesterday == $date) {
			$result = 'вчера';
		} else {
			$result = Yii::$app->formatter->asDate($this->updated_at, 'medium');
		}

		return $result;			
	}
	
	public function getUser()
	{
		return $this->hasOne(User::className(), ['id' => 'id_user']);
	}
	
	public function getTable()
	{
		if ($this->table_name == self::RECEPTY) {
			return $this->hasOne(Recepty::className(), ['id' => 'id_table']);		
		}
		if ($this->table_name == self::ARTICLE) {
			return $this->hasOne(Article::className(), ['id' => 'id_table']);
		}
		
	}
	
	public function getUrl()
	{
		return Url::toRoute(['/'. $this->table_name .'/default/view', 'path' => $this->table->path]);
	}

}
