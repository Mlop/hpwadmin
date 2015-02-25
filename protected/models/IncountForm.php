<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class IncountForm extends CFormModel
{
	public $money;
	public $phone;
    public $note;
    public $customerName;
    public $customer_id;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('money, phone', 'required'),
			// password needs to be authenticated
			array('note, customerName, customer_id', 'safe'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'money'=>'Money',
            'phone'=>'Phone',
            'note'=>'Note',
		);
	}

//    public function register($attributes)
//    {
//        try {
//            $attributes['password'] = User::encrypt($attributes['password']);
//            $this->password = $attributes['password'];
//            $user = User::model();
//            $user->setAttributes($attributes);
//            $user->setIsNewRecord(true);
//            $user->save();
//
//            $userIdentity = new UserIdentity($this->name, $this->password);
//            Yii::app()->user->login($userIdentity);
//        } catch (Exception $ex) {
//            $this->addError('name',$ex->getMessage());
//            return false;
//        }
//        return true;
//    }
}
