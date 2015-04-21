<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    const ERROR_USER_NOT_EXISTS = 3;

    public $user = null;
    public $name = "";

    /**
     * Constructor.
     * @param string $username username
     * @param string $password password
     */
    public function __construct($name, $password)
    {
        $this->name = $name;
        $this->password = $password;
        $this->username = $name;
    }
	/**
	 * Authenticates a user for login.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
        $user = User::model()->findByAttributes(array('name'=>$this->name));
        if (count($user) == 0) {
            $this->errorCode = ERROR_USER_NOT_EXISTS;
        } else if (User::validatePassword($user->password, $this->password) === false) {
            $this->errorCode = ERROR_PASSWORD_INVALID;
        } else {
            $this->errorCode = self::ERROR_NONE;
            $this->user = $user;
        }

        return $this->errorCode;
	}

    /**
     * 填充user对象
     * @param $user 对象中必须包含user_id字段
     * @return bool 赋值是否成功
     */
    public function assignUser($user)
    {
        if (!is_object($user)) {
            if (is_numeric($user)) {
                $user = User::model()->findByPk(intval($user));
            } else {
                return false;
            }
        }

        if ($user == null) {
            return false;
        }
        $this->user = $user;
        $this->username = $user->name;
        $this->password = $user->password;
    }

    public function getName()
    {
        return $this->user->name;
    }

    public function getId()
    {
        return $this->user->user_id;
    }

    public function getUser()
    {
        return $this->user;
    }
}
