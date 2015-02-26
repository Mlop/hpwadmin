<?php

class UserController extends BaseController
{
	public function actionIndex()
	{
		$this->render('index');
	}

    /**
     * 包括进、出帐列表
     */
    public function actionList()
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
     * modify user information
     */
    public function actionModify()
    {
        $user_id = Yii::app()->request->getParam('user_id');
        $userForm = Yii::app()->request->getParam('UserForm');
        if (!is_null($userForm)) {
            try {
                //modify
                if ($user_id) {
                    $updateModel = User::model()->findByPk($user_id);
                    $updateModel->setAttributes($userForm);
                    $updateModel->save();
                } else {
                    echo 'no user id';
                }
            } catch (Exception $ex) {
                $this->addError($ex->getMessage());
            }
            echo 'save successfully';
        }

        $formModel = new UserForm;
        //fill form when modify
        if ($user_id) {
            $formModel->attributes = User::model()->findByPk($user_id)->getAttributes();
        }
        $this->render("form", array('model'=>$formModel));
    }

    /**
     * reset user password
     */
    public function actionResetPasswd()
    {
        $user_id = Yii::app()->request->getParam('user_id');
        $user_name = Yii::app()->request->getParam('user_name');
        //supper administrator can reset password directely
        if ($user_name && $user_name == "admin") {

        }
        $formModel = new UserForm;
        //fill form when modify
        if ($user_id) {
            $formModel->attributes = User::model()->findByPk($user_id)->getAttributes();
        }
        $this->render("reset_password", array('model'=>$formModel));
    }
}