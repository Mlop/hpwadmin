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
        //登陆后才能添加
        var_dump($this->isGuest);exit;
        $incountForm = Yii::app()->request->getParam('IncountForm');
        $formModel = new IncountForm;
        if (!is_null($incountForm)) {
            try {
                $model = Incount::model();
                $model->setAttributes($incountForm);
                $model->setIsNewRecord(true);
                $model->save();
//                var_dump($incountForm);exit;
            } catch (Exception $ex) {
                $this->addError($ex->getMessage());
            }
        }
        $this->render("form", array('model'=>$formModel));
    }

    /**
     * get the incount list
     */
    public function actionGetList()
    {
        $mode = Incount::model()->findAllByAttributes();
    }
}