<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class CustomerForm extends CFormModel
{
	public $name;
	public $type;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and type are required
			array('name, type', 'required'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'name'=>'Name',
            'type'=>'Type',
		);
	}

    /**
     * get customer type list data, used for generate form field
     * array(2) { [0]=> string(9) "借款人" [1]=> string(9) "贷款人" }
     */
    public static function getTypeListData()
    {
        return CHtml::listData(
            array(
                array('value' => 0,'name' => t('operation', 'BORROWER')),
                array('value' => 1,'name' => t('operation', 'LENDER'))
            ),
            'value',
            'name'
        );
    }
}
