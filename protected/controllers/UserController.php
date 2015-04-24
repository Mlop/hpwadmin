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
     * jsonp登陆
     */
    public function actionLogin()
    {
        $model = new User('login');
        $loginForm = $this->request->getParam("User");
        // collect user input data
        if (isset($loginForm)) {
            $model->attributes = $loginForm;
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()) {
                $loginUser = User::findUserByPhone($model->phone);
                $loginUser->setAttribute('last_login_time', date('Y-m-d H:i:s'));
                $loginUser->save();
                $this->returnData = $this->encodeResult($loginUser);
            } else if ($model->hasErrors()) {
                $this->returnData = $this->encodeResult($model->getErrors(), self::ERROR_CODE_ARRAY);
            }
            return;
        }

        $this->returnData = $this->encodeResult(t('prompt', 'NOPARAM'), self::ERROR_CODE_STRING);
    }

    /**
     * 获取某用户的所有借入借出列表
     */
    public function actionGetAll()
    {
        $user_id = $this->request->getParam("user_id");

        $sql = "SELECT customer.name username,customer.phone iphone,money,way,is_repayment,IFNULL(datediff(confer_repayment_date, NOW()),'unlimit') leftday from (
                select *,incount_id id,'borrow' way from incount where user_id={$user_id}
                UNION
                select *,outcount_id id,'lend' way from outcount where user_id={$user_id}
                ) tab join customer on customer.customer_id=tab.customer_id
                ORDER BY leftday asc";
        $command = Yii::app()->db->createCommand($sql);
        $data = $command->queryAll();
        $this->returnData = $this->encodeResult($data);
//        var_dump($this->returnData);
    }

    /**
     * Displays the login page
     */
    public function actionLogin_web()
    {
        $model = new User('login');
        $loginForm = $this->request->getParam("User");
        // collect user input data
        if (isset($loginForm)) {
            $model->attributes = $loginForm;
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()) {
                $this->redirect(Yii::app()->user->returnUrl);
            }
        }
        // display the login form
        $this->render('login', array('model' => $model));
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
     * jsonp注册用户
     */
    public function actionRegister()
    {
        $model = new User('register');
        $userPost = $this->request->getParam('User');
        if (isset($userPost)) {
            $model->setAttributes($userPost);
            if ($model->validate() && $model->register($userPost)) {
                $this->returnData = $this->encodeResult($model);
            } else if ($model->hasErrors()) {
                $this->returnData = $this->encodeResult($model->getErrors(), self::ERROR_CODE_ARRAY);
            }
            return;
        }
        $this->returnData = $this->encodeResult(t('prompt', 'NOPARAM'), self::ERROR_CODE_STRING);
    }

    /**
     * 注册用户
     */
    public function actionRegister_web()
    {
        $this->layout = "";
        $model = new User('register');
        $userPost = $this->request->getParam('User');
        if (isset($userPost)) {
            $model->setAttributes($userPost);
            if ($model->validate() && $model->register($userPost)) {
                //@todo 注册后进入默认页面
                $this->redirect(Yii::app()->user->returnUrl);
            } else {
                $model->addError('name', '注册失败！');
            }
        }
        $this->render('register', array('model'=>$model));
    }

    /**
     * 包括进、出帐列表
     */
    public function actionList()
    {
        $mode = User::model()->findAll();
        $this->render("list", array('data'=>$mode));
    }

    /**
     * modify user information
     */
    public function actionModify()
    {
        $user_id = Yii::app()->request->getParam('user_id');
        $userForm = Yii::app()->request->getParam('User');
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

        $formModel = new User;
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