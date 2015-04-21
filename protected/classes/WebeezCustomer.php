<?php
/**
 * This customer is used for user login
 */
class WebeezCustomer extends CWebUser {

    public $user = null;
    public $session = null;
    public $returnUrl = "";

	/**
	 * after login add session and cookie
     * user_id: user's id
     * is_login: the state weather login
     * LoginDate: last login date
	 */
	function afterLogin($user)
    {
        $this->session['user'] = $this->user->user;
        $this->session['user_id'] = $this->id;
        $this->session['is_login'] = (isset($this->session['user_id']) && $this->session['user_id'] > 0) ? true : false;
        setcookie('LoginDate', date('Ymd his', time()));
        return true;
	}

    public function getId()
    {
        return $this->user->getId();
    }

    /**
     * 使用用户名和密码登陆，写cookie
     * @return bool|void
     */
    public function login($user)
    {
        $this->user = $user;
        $this->session = Yii::app()->getSession();
        if ($this->afterLogin($user)) {

        }
    }
}

