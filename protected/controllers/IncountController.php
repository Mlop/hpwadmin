<?php

class IncountController extends BaseController
{
    public function __construct($id, $module = null)
    {
        parent::__construct($id, $module);
        $this->breadcrumbs->add('incount', $this->createUrl('incount/list'));
    }
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
        $this->breadcrumbs->add('create');

        $incount_id = Yii::app()->request->getParam('incount_id');
        $incountForm = Yii::app()->request->getParam('IncountForm');
        if (!is_null($incountForm)) {
            try {
                unset($incountForm['customerName']);
                $incountForm['user_id'] = 3;

                //modify
                if ($incount_id) {
                    $updateModel = Incount::model()->findByPk($incount_id);
                    $updateModel->setAttributes($incountForm);
                    $updateModel->save();
                } else {//new record
                    $model = Incount::model();
                    $model->setAttributes($incountForm);
                    $model->setIsNewRecord(true);
                    $model->save();
                }

            } catch (Exception $ex) {
                $this->addError('customerName', $ex->getMessage());
            }
        }

        $formModel = new IncountForm;
        //fill form when modify
        if ($incount_id) {
            $formModel->attributes = Incount::model()->findByPk($incount_id)->getAttributes();
        }
        $this->render("form", array('model'=>$formModel));
    }

    /**
     * delete a incount record
     */
    public function actionDelete()
    {
        $incount_id = Yii::app()->request->getParam('incount_id');
        $return = array('error'=>0, 'msg'=>'');
        if ($incount_id) {
            try {
                Incount::model()->deleteByPk($incount_id);
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

    /**
     * get the incount list
     */
    public function actionList()
    {
        $mode = Incount::model()->findAllByAttributes(array('user_id'=>3));
        $this->render("list", array('data'=>$mode));
    }
}