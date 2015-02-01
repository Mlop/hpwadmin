<?php

class UserController extends BaseController
{
    public function __construct($id,$module = null)
    {
        $this->setPageTitle("用户管理");
        parent::__construct($id,$module);
    }
	public function actionIndex()
	{
		$this->render('index');
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
}