<?php
namespace app\models\form;

use app\models\User;
use app\models\UsersProfile;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $email;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Этот Email уже занят.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }
	
    public function attributeLabels()
    {
        return [
            'password' => 'Пароль',
            'email' => 'Email',
        ];
    }
	
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
			if ($user->save()) {
				return $user;
			}			
        }

        return null;
    }
}
