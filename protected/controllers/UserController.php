<?php

class UserController extends BaseController
{
	public function actionIndex()
	{

        $inStat = Incount::model()->findAll(array('select'=>'customer_id,sum(money) as money','condition'=>'user_id=:userID', 'params'=>array(':userID'=>3), 'group'=>'customer_id'));
        $outStat = Outcount::model()->findAll(array('select'=>'customer_id,sum(money) as money','condition'=>'user_id=:userID', 'params'=>array(':userID'=>3), 'group'=>'customer_id'));
        $incount = array();
        foreach ($inStat as $row) {
            $incount[] = array('name'=>$row->customer->name, 'value'=>$row->money);
        }
        $outcount = array();
        foreach ($outStat as $row) {
            $outcount[] = array('name'=>$row->customer->name, 'value'=>$row->money);
        }
        $data = array(
            'incount'=>CJSON::encode($incount),
            'outcount'=>CJSON::encode($outcount),
        );
		$this->render('general', $data);
	}
    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        $model=new LoginForm;

        // if it is ajax validation request
//		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
//		{
//			echo CActiveForm::validate($model);
//			Yii::app()->end();
//		}

        // collect user input data
        if(isset($_POST['LoginForm']))
        {
            $model->attributes=$_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if($model->validate() && $model->login()){
//                var_dump($_SESSION);
//                $this->session['is_login'] = true;
                $this->redirect(Yii::app()->user->returnUrl);

            }
        }
        // display the login form
        $this->render('login',array('model'=>$model));
    }
    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }
    /**
     * 注册用户
     */
    public function actionRegister()
    {//var_dump(file_exists(dirname(__FILE__).'/../data/hpw.db'));
        $model=new RegisterForm;
        $userPost = Yii::app()->request->getParam('RegisterForm');
//        var_dump($userPost,$model);exit;
        if (isset($userPost)) {
            $model->setAttributes($userPost);
            if ($model->validate() && $model->register($userPost)) {
                //@todo 注册后进入默认页面
                $this->redirect(Yii::app()->user->returnUrl);

//                $this->redirect($this->createUrl('site/login'));
            } else {
                $model->addError('name','注册失败！');
            }
//            $model->addError('name','请输入用户名，不允许为空格！');
            /*$username = trim($userPost['name']);
            $password = $userPost['password'];
            if ($username == "") {
                $this->addError('name','请输入用户名，不允许为空格！');
//                $model->name = $username;
            } else if ($password == "") {
//                $model->password = $password;
                $this->addError('password','请输入密码！');
            }else if ($username != "" && $password != "") {
                $userPost['name'] = $username;
                $userPost['password'] = User::encrypt($password);
                $model->attributes=$userPost;
                var_dump($model->attributes);
                $model->isNewRecord = true;
                $model->save();
                //@todo 注册后进入默认页面
                $this->redirect(Yii::app()->user->returnUrl);
            }*/
        }
        $this->render('register',array('model'=>$model));
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