<?php

/**
 * This is the model class for table "incount".
 *
 * The followings are the available columns in table 'incount':
 * @property integer $incount_id
 * @property integer $customer_id
 * @property double $money
 * @property string $phone
 * @property string $note
 * @property string $add_time
 * @property integer $user_id
 *
 * The followings are the available model relations:
 * @property User $user
 * @property Customer $customer
 */
class Incount extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'incount';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('money, phone', 'required'),
			array('customer_id, user_id', 'numerical', 'integerOnly'=>true),
			array('money', 'numerical'),
			array('phone', 'length', 'max'=>50),
			array('note, add_time, confer_repayment_date, is_repayment, real_repayment_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('incount_id, customer_id, money, phone, note, add_time, user_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'incount_id' => 'Incount',
			'customer_id' => 'Customer',
			'money' => 'Money',
			'phone' => 'Phone',
			'note' => 'Note',
			'add_time' => 'Add Time',
			'user_id' => 'User',
            'confer_repayment_date' => 'Confer Repayment Date',
            'is_repayment' => 'Is Repayment',
            'real_repayment_date' => 'Real Repayment Date',
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

		$criteria->compare('incount_id',$this->incount_id);
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('money',$this->money);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('add_time',$this->add_time,true);
		$criteria->compare('user_id',$this->user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Incount the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
