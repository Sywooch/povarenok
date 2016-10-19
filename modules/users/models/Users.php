<?php

namespace app\modules\users\models;

use Yii;

/**
 * This is the model class for table "np_users".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $image
 * @property integer $active
 * @property string $date_create
 * @property string $auth_token
 * @property integer $birthday_day
 * @property integer $birthday_month
 * @property integer $birthday_year
 * @property string $city
 * @property string $current_info
 * @property string $about
 * @property string $interes
 * @property integer $sex
 * @property string $last_visit
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'np_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'password', 'image', 'active', 'date_create', 'auth_token', 'birthday_day', 'birthday_month', 'birthday_year', 'city', 'current_info', 'about', 'interes', 'sex', 'last_visit'], 'required'],
            [['active', 'birthday_day', 'birthday_month', 'birthday_year', 'sex'], 'integer'],
            [['date_create', 'last_visit'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['email', 'city'], 'string', 'max' => 100],
            [['password', 'image', 'auth_token', 'current_info', 'about', 'interes'], 'string', 'max' => 255],
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
            'email' => 'Email',
            'password' => 'Password',
            'image' => 'Image',
            'active' => 'Active',
            'date_create' => 'Date Create',
            'auth_token' => 'Auth Token',
            'birthday_day' => 'Birthday Day',
            'birthday_month' => 'Birthday Month',
            'birthday_year' => 'Birthday Year',
            'city' => 'City',
            'current_info' => 'Current Info',
            'about' => 'About',
            'interes' => 'Interes',
            'sex' => 'Sex',
            'last_visit' => 'Last Visit',
        ];
    }
}
