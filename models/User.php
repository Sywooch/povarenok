<?php
namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\modules\users\models\UsersProfile;
use app\modules\users\models\UsersFriends;
use yii\web\UploadedFile;
use yii\imagine\Image;

/**
 * User model
 *
 * @property integer $id
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_WAIT  	 = 5;	
    const STATUS_ACTIVE  = 10;
	const ROLE_USER 	 = 'user';
	const ROLE_ADMIN 	 = 'admin';
	
	public $old_image = '';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }
	
    public function getStatusName()
    {
        return ArrayHelper::getValue(self::getStatusesArray(), $this->status);
    }
 
    public static function getStatusesArray()
    {
        return [
            self::STATUS_DELETED => 'Удален',
            self::STATUS_ACTIVE => 'Активен',
            self::STATUS_WAIT => 'Ожидает подтверждения',
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
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['status', 'created_at', 'updated_at', 'role'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email', 'image'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['email'], 'unique'],
            ['email', 'email'],
            [['password_reset_token'], 'unique'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_WAIT, self::STATUS_DELETED]],			
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Логин',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'image' => 'Изображение',
            'status' => 'Статус',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
            'role' => 'Роль',
        ];
    }	

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
		$user = static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
		$user->updated_at = time();
		$user->save();
        return $user;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by id
     *
     * @param string $id
     * @return static|null
     */
    public static function findById($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
		return md5($password) === $this->password_hash ||
				Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    /**
     * @param string $email_confirm_token
     * @return static|null
     */
    public static function findByEmailConfirmToken($email_confirm_token)
    {
        return static::findOne(['email_confirm_token' => $email_confirm_token, 'status' => self::STATUS_WAIT]);
    }
 
    /**
     * Generates email confirmation token
     */
    public function generateEmailConfirmToken()
    {
        $this->email_confirm_token = Yii::$app->security->generateRandomString();
    }
 
    /**
     * Removes email confirmation token
     */
    public function removeEmailConfirmToken()
    {
        $this->email_confirm_token = null;
    }
	
	public function getUrl()
	{
		return Url::toRoute(['/users/site/view', 'id' => $this->id]);
	}
	
	public function getAdresUser()
	{
		return (!empty($this->profile->city) ? $this->profile->city : 'Без города');
	}
	
	public function getName()
	{
		return (!empty($this->profile->name) ? $this->profile->name : 'Без имени');
	}
			
	public function getImagePath()
	{
		$img_path = Yii::$app->params['users']['image']['small']['path'];
		
		return !empty($this->image) ? $img_path.$this->image : '/img/no_photo_man.png';
	}

	public function getImagePathBig()
	{
		$img_path = Yii::$app->params['users']['image']['big']['path'];
		
		return !empty($this->image) ? $img_path.$this->image : '/img/no_photo_man.png';
	}
	
    public function getRoleName()
    {
        $auth = Yii::$app->authManager;
        $roles = $auth->getRolesByUser($this->id);
        return !empty($roles) ? array_keys($roles) : null;
    }
	
    public function afterSave($insert, $changedAttributes) 
	{
		parent::afterSave($insert, $changedAttributes);
		// установка роли пользователя
		$auth = Yii::$app->authManager;
		$name = $this->roleName ? $this->roleName : self::ROLE_USER;
		$role = $auth->getRole($name);
		if (!$insert) {
			$auth->revokeAll($this->id);
		} else {
			$profile = NEW UsersProfile();
			$profile->user_id = $this->id;
			$profile->save();				
		}
		$auth->assign($role, $this->id);

    }

	public function getProfile()
	{
		return $this->hasOne(UsersProfile::className(), ['user_id' => 'id']);
	}	
	
	public function getLastVisit() 
	{
		$html = 'Online';

		if (($this->updated_at + 900) < time()) {
			$html = '';
			$sex = 'заходил';
			if ($this->profile->sex == 2) $sex .= 'а';
			$date = Yii::$app->formatter->asDate($this->updated_at, 'medium');
			$time = Yii::$app->formatter->asTime($this->updated_at, 'short');
			$html .= $sex.' ' . $date . ' в ' . $time;
		}
		return $html;
	}
	
	public function getUserFriends()
	{
		return $this->hasMany(UsersFriends::className(), ['user_id' => 'id']);
	}
	
	public function getFriendsUser()
	{
		return $this->hasMany(UsersFriends::className(), ['friend_id' => 'id']);
	}

	public function getFriends()
	{		
		return User::find()
			->joinWith('friendsUser')
			->where(['is_mutual' => UsersFriends::IS_FRIEND])
			->andWhere(['user_id' => Yii::$app->user->identity->id])
			->orderBy(['np_users_friends.id' => SORT_DESC]);	
	}	
	
	public function getOutFriends()
	{		
		return User::find()
			->joinWith('friendsUser')
			->where(['<>', 'is_mutual', UsersFriends::IS_FRIEND])
			->andWhere(['user_id' => Yii::$app->user->identity->id])
			->orderBy(['np_users_friends.id' => SORT_DESC]);	
	}	
		
	public function getOldFriends()
	{		
		return User::find()
			->joinWith('userFriends')
			->where(['is_mutual' => UsersFriends::OLD_FRIEND])
			->andWhere(['friend_id' => Yii::$app->user->identity->id])
			->orderBy(['np_users_friends.id' => SORT_DESC]);	
	}	
			
	public function getNewFriends()
	{		
		return User::find()
			->joinWith('userFriends')
			->where(['is_mutual' => UsersFriends::NO_FRIEND])
			->andWhere(['friend_id' => Yii::$app->user->identity->id])
			->orderBy(['np_users_friends.id' => SORT_DESC]);	
	}

	public function upload()
	{
		$paramsCrop = Yii::$app->request;
		$this->image = UploadedFile::getInstance($this, 'image');
		if (!empty($this->image)) {	

			$this->deleteImage($this->image);

			$param_img = Yii::$app->params['users']['image'];
			$path_big = substr($param_img['big']['path'], 1);
			$path_small = substr($param_img['small']['path'], 1);
					
			$image_name = 'user' . $this->id . '.' . $this->image->extension;
			
			$this->image->saveAs($path_big.$image_name);
					
			$x = ($paramsCrop->post('datax') > 0) ? $paramsCrop->post('datax') : 0;
			$y = ($paramsCrop->post('datay') > 0) ? $paramsCrop->post('datay') : 0;
						
			Image::crop($path_big.$image_name, $paramsCrop->post('width'), $paramsCrop->post('height'), [$x, $y])
				->save($path_small.$image_name, ['quality' => 50]);

			$this->image = $image_name;

		} else {
			$this->image = $this->old_image;			
		}
	}	
	
	public function deleteImage($file)
	{ 		
		$param_img = Yii::$app->params['users']['image'];
		$path_big = substr($param_img['big']['path'], 1);
		$path_small = substr($param_img['small']['path'], 1);
			
		if(!empty($file)){
			@unlink($path_big.$file);
			@unlink($path_small.$file);
		}            
	} 
			
}
