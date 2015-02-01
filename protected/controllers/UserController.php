<?php

class UserController extends BaseController
{
	public function actionIndex()
	{

        $inStat = Incount::model()->findAll(array('select'=>'customer_id,sum(money) as money','condition'=>'user_id=:userID', 'params'=>array(':userID'=>3), 'group'=>'customer_id'));
        foreach($inStat as $row) {
            echo $row->customer_id.' '.$row->money.' '.$row->customer->name;
        }
        $data = array(
            'incount'=>$inStat
        );
		$this->render('general', $data);
	}

    /**
     * 包括进、出帐列表
     */
    public function actionList()
    {
        $mode = User::model()->findAll();
        $this->render("list", array('data'=>$mode));
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
     * delete a customer record, include incount and outcount record
     */
    public function actionDelete()
    {
        $user_id = Yii::app()->request->getParam('user_id');
        $return = array('error'=>0, 'msg'=>'');
        if ($user_id) {
            try {
                Incount::model()->deleteAllByAttributes(array('user_id'=>$user_id));
                Outcount::model()->deleteAllByAttributes(array('user_id'=>$user_id));
                User::model()->deleteByPk($user_id);
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
     * reset user password
     */
    public function actionResetPasswd()
    {
        $user_id = Yii::app()->request->getParam('user_id');
        $user_name = Yii::app()->request->getParam('user_name');
        $userForm = Yii::app()->request->getParam('User');

        $isadmin = false;
        //supper administrator can reset password directely
        if ($user_name && $user_name == "admin") {
            $formModel = new User('adminresetpwd');
            $isadmin = true;
        } else {
            $formModel = new User('resetpasswd');
        }
        if (!is_null($userForm)) {
            $formModel->attributes = $userForm;
            if ($formModel->validate()) {
                $resetModel = User::model()->findByPk($user_id);
                $resetModel->setAttributes(array('password'=>User::encrypt($userForm['newpassword'])));
                $resetModel->save();
            }
        }

        //fill form when reset
        if ($user_id) {
            $formModel->attributes = User::model()->findByPk($user_id)->getAttributes();
        }

        $this->render("reset_password", array('model'=>$formModel, 'isadmin'=>$isadmin));
    }
}