<?php

class CustomerController extends BaseController
{
	public function actionIndex()
	{
        $mode = Customer::model()->findAll();
        $this->render("list", array('data'=>$mode));
	}

    /**
     * create a record into customer db
     */
    public function actionCreate()
    {
        $customer_id = Yii::app()->request->getParam('customer_id');
        $customerForm = Yii::app()->request->getParam('CustomerForm');
        if (!is_null($customerForm)) {
            try {
                //modify
                if ($customer_id) {
                    $updateModel = Customer::model()->findByPk($customer_id);
                    $updateModel->setAttributes($customerForm);
                    $updateModel->save();
                } else {//new record
                    $model = Customer::model();
                    $model->setAttributes($customerForm);
                    $model->setIsNewRecord(true);
                    $model->save();
                }
            } catch (Exception $ex) {
                $this->addError($ex->getMessage());
            }
            echo 'save successfully';
        }

        $formModel = new CustomerForm;
        //fill form when modify
        if ($customer_id) {
            $formModel->attributes = Customer::model()->findByPk($customer_id)->getAttributes();
        }
        $this->render("form", array('model'=>$formModel));
    }

    /**
     * delete a customer record, include incount and outcount record
     */
    public function actionDelete()
    {
        $customer_id = Yii::app()->request->getParam('customer_id');
        $return = array('error'=>0, 'msg'=>'');
        if ($customer_id) {
            try {
                Incount::model()->deleteAllByAttributes(array('customer_id'=>$customer_id));
                Outcount::model()->deleteAllByAttributes(array('customer_id'=>$customer_id));
                Customer::model()->deleteByPk($customer_id);
            } catch (Exception $ex) {
                $return = array('error'=>1, 'msg'=>'delete error');
                echo CJSON::encode($return);
                return;
            }
            echo CJSON::encode($return);
        } else {
            $return = array('error'=>1, 'msg'=>'no id');
            echo CJSON::encode($return);
            return;
        }
    }
}