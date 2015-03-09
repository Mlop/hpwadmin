<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $user_id
 * @property string $name
 * @property string $password
 * @property string $add_time
 * @property string $last_login_time
 *
 * The followings are the available model relations:
 * @property Incount[] $incounts
 * @property Outcount[] $outcounts
 */
class User extends CActiveRecord
{
    public $name;
    public $password;
    public $oldpassword;
    public $newpassword;
    public $retrypassword;

    private $_identity;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'length', 'max'=>100),
			array('password', 'length', 'max'=>50, 'min'=>4, 'on'=>'register,resetpasswd,adminresetpwd'),
            array('newpassword', 'length', 'max'=>50,'min'=>4),
            array('add_time, last_login_time', 'safe'),
			array('user_id, name, password, add_time, last_login_time', 'safe', 'on'=>'search'),

            //login
            array('name, password', 'required', 'on'=>'login,register'),
            array('password', 'authenticateLogin', 'on'=>'login'),
            array('name', 'unique', 'on'=>'register'),
            // when reset password normal
            array('name, oldpassword', 'required', 'on'=>'resetpasswd'),
            array('oldpassword', 'authenticate_oldpasswd', 'on'=>'resetpasswd'),
            array('retrypassword', 'compare', 'compareAttribute'=>'newpassword', 'on'=>'resetpasswd,adminresetpwd'),
            // when reset password by admin
            array('name', 'required', 'on'=>'adminresetpwd'),
		);
	}
    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate_oldpasswd($attribute, $params)
    {
        $user = User::model()->findByAttributes(array('name'=>$this->name));
        if (count($user) == 0) {
            $this->addError('name', 'the user not exists.');
        } else {
            if (User::validatePassword($user->password, $this->oldpassword) === false) {
                $this->addError('oldpassword', 'the password incorrect.');
            }
        }
    }
    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticateLogin ($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $this->_identity=new UserIdentity($this->name, $this->password);
            if ($this->_identity->authenticate()) {
                $this->addError('password', 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login()
    {
        if ($this->_identity === null) {
            $this->_identity = new UserIdentity($this->name, $this->password);
            $this->_identity->authenticate();
        }
        if ($this->_identity->errorCode === UserIdentity::ERROR_NONE) {
            Yii::app()->user->login($this->_identity);
            return true;
        } else {
            return false;
        }
    }

    /**
     * register a user
     * @param $attributes
     * @return bool
     */
    public function register($attributes)
    {
        try {
            $attributes['password'] = User::encrypt($attributes['password']);
            $this->password = $attributes['password'];
            $user = User::model();
            $user->setAttributes($attributes);
            $user->setIsNewRecord(true);
            $user->save();

            $userIdentity = new UserIdentity($this->name, $this->password);
            Yii::app()->user->login($userIdentity);
        } catch (Exception $ex) {
            $this->addError('name', $ex->getMessage());
            return false;
        }
        return true;
    }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'incounts' => array(self::HAS_MANY, 'Incount', 'user_id'),
			'outcounts' => array(self::HAS_MANY, 'Outcount', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'name' => 'Name',
			'password' => 'Password',
			'add_time' => 'Add Time',
			'last_login_time' => 'Last Login Time',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('add_time',$this->add_time,true);
		$criteria->compare('last_login_time',$this->last_login_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * Find User by Username
     * @param unknown_type $username
     */
    public static function findByUsername($username){
        return User::model()->findByAttributes(array('name'=>$username));
    }

    /**
     * encrypt a password
     * @param unknown_type $plainPassword
     */
    public static function encrypt($plainPassword){
        $src = '0123456789abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ%*!$&#';
        $strlen = strlen($src);
        $salt = '';
        $len = 2;
        for($i=0;$i<$len;$i++){
            $salt.= substr($src,mt_rand(0, $strlen),1);
        }
        $password = md5($salt.$plainPassword).$salt;
        return $password;
    }

    /**
     * validate the password
     * @param encrypt the encrypted password
     * @param string $password plain password
     */
    public static function validatePassword($encrypt = '' , $password = '')
    {
        if(strlen($encrypt) != 34 || $password == ''){
            return false;
        }
        $salt = substr($encrypt,-2);
        return md5($salt.$password).$salt == $encrypt;
    }

    /**
     * create a new user .
     * add userloginhistory .etc
     */
    public static function createUser($username , $password=''){
        $u = new User;
        if($password == ''){
            $password = self::generatePassword(10);
        }
        if(is_array($username)){
            $u->setAttributes($username);
        }else{
            $u->setAttributes(array(
                    'username'=>$username,
                    'password'=>User::encrypt($password),
                    'email'=>$email,
                    'first_name'=>$firstname,
                    'last_name'=>$lastname,
                    'email_notification'=>$email_notification,
                    'last_updated'=>date('Y-m-d H:i:s',time()),
                    'active'=>$active
                ));
        }
        if($u->validate()){
            $u->insert();
        }
        if(!$u->hasErrors()){
            $ulh = new UserLoginHistory();
            $ulh->user_id = $u->user_id;
            $ulh->login_count = 0 ;
            $ulh->ip = Yii::app()->request->userHostAddress;
            $ulh->insert();
        }
        return $u ;
    }
}
