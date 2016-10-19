<?php

namespace app\modules\users\models;

use Yii;

/**
 * This is the model class for table "np_users_profile".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property integer $active
 * @property string $date_create
 * @property integer $birthday_day
 * @property integer $birthday_month
 * @property integer $birthday_year
 * @property string $city
 * @property string $current_info
 * @property string $about
 * @property string $interes
 * @property integer $sex
 */
class UsersProfile extends \yii\db\ActiveRecord
{
	
    const NOSEX   = 0;
    const MALE 	  = 1;
    const FEMALE  = 2;	
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'np_users_profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'birthday_day', 'birthday_month', 'birthday_year', 'sex'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['city'], 'string', 'max' => 100],
            [['current_info', 'about', 'interes'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'name' => 'Имя',
            'birthday_day' => 'День',
            'birthday_month' => 'Месяц',
            'birthday_year' => 'Год',
            'city' => 'Город',
            'current_info' => 'Подпись',
            'about' => 'О себе',
            'interes' => 'Интересы',
            'sex' => 'Пол',
        ];
    }
	
    public static function getSexDropList()
    {
        return [
            self::NOSEX => 'не выбран',
            self::MALE => 'муж',
            self::FEMALE => 'жен',
        ];
    }

	function getMonthArr() {
		return [
				0 => '',1 => 'Января',2 => 'Февраля',3 => 'Марта',4 => 'Апреля',5 => 'Мая',6 => 'Июня',
				7 => 'Июля',8 => 'Августа',9 => 'Сентября',10 => 'Октября',11 => 'Ноября',12 => 'Декабря'
				];
	}
	
	public function getBirthday()
	{
		$day = (!empty($this->birthday_day)) ? $this->birthday_day : '';
		$m = $this->getMonthArr();
		$month = mb_strtolower($m[$this->birthday_month], 'UTF-8');
		$year = (!empty($this->birthday_year)) ? $this->birthday_year : '';
		return "$day $month $year";		
	}
	
}
