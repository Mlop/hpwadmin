<?php

class CustomerController extends BaseController
{
	public function actionIndex()
	{
		$this->render('index');
	}

    /**
     * create a record into incount db
     */
    public function actionCreate()
    {
        $customerForm = Yii::app()->request->getParam('CustomerForm');
        $formModel = new CustomerForm;
        if (!is_null($customerForm)) {
            try {
                $model = Customer::model();
                $model->setAttributes($customerForm);
                $model->setIsNewRecord(true);
                $model->save();
            } catch (Exception $ex) {
                $this->addError($ex->getMessage());
            }
            echo 'save successfully';
        }
        $this->render("form", array('model'=>$formModel));
    }
}