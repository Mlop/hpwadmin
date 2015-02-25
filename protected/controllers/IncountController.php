<?php

class IncountController extends BaseController
{
	public function actionIndex()
	{
		$this->render('index');
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/

    /**
     * create a record into incount db
     */
    public function actionCreate()
    {
        $incountForm = Yii::app()->request->getParam('IncountForm');
        $formModel = new IncountForm;
        if (!is_null($incountForm)) {
            try {
                unset($incountForm['customerName']);
                $incountForm['user_id'] = 3;
                $model = Incount::model();
                $model->setAttributes($incountForm);
                $model->setIsNewRecord(true);
                $model->save();
            } catch (Exception $ex) {
                $this->addError('customerName', $ex->getMessage());
            }
        }
        $this->render("form", array('model'=>$formModel));
    }

    /**
     * get the incount list
     */
    public function actionList()
    {
        $mode = Incount::model()->findAllByAttributes(array('user_id'=>3));
        $this->render("list", array('data'=>$mode));
    }
}