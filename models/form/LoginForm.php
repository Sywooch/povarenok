<?php
namespace app\models\form;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;

    private $_user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // email and password are both required
            [['email', 'password'], 'required'],
			['email', 'email'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
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
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
 
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError('password', 'Неверный email или пароль.');
            } elseif ($user && $user->status == User::STATUS_DELETED) {
                $this->addError('username', 'Ваш аккаунт заблокирован.');
            } elseif ($user && $user->status == User::STATUS_WAIT) {
                $this->addError('username', 'Ваш аккаунт не подтвежден.');
            }
        }		
    }

    /**
     * Logs in a user using the provided email and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[email]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;
    }

	public function loginAdmin()
	{
		if ($this->validate() && User::isUserAdmin($this->email)) {
			return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
		} else {
			return false;
		}
	}
}
