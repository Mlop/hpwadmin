<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class RegisterForm extends CFormModel
{
	public $name;
	public $password;
//	public $rememberMe;

//	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('name, password', 'required'),
			// password needs to be authenticated
			array('password', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
//	public function attributeLabels()
//	{
//		return array(
//			'rememberMe'=>'Remember me next time',
//		);
//	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
        $len = strlen($this->password);

        if ($len < 4) {
            $this->addError('password','the length must greater than four characters.');
        }
//        if (preg_match('/^[a-z0-9]+$/',$this->password) == 1){
//            $this->addError('password','too simple.');
//        }
        $userCount = User::model()->countByAttributes(array('name'=>$this->name));
        if ($userCount > 0) {
            $this->addError('name','the name '.$this->name.' had exist yet.');
        }
	}

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
            $this->addError('name',$ex->getMessage());
            return false;
        }
        return true;
    }
}
