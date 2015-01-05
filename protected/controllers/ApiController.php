<?php

/**
 * 提供给前端调用公共接口，通过curl获取数据后返回。主要用于提供前端jsonp的回调函数
 * @author vera zhang 2015-01-25
 */
class ApiController extends BaseController
{
    public $controller = "user";
    public $action = "login";
    public $sign = "";

	/**
	 * jsonp回调函数
	 */
	public function actionCallback()
	{
        $request = Yii::app()->request;
        $this->sign = $request->getParam("sign");
        if (!$this->validateSign()) {
            echo $this->encodeResult(t('prompt', 'INVALIDSIGN'), 2);
            return ;
        }
        $this->controller = $request->getParam("controller");
        $this->action = $request->getParam("action");

        Yii::app()->runController($this->controller.'/'.$this->action);
    }

    /**
     * 验证接口来源是否正确, userID_userName_authUserName#动态串
     * @return bool
     */
    private function validateSign()
    {
        if ($this->sign == "") {
            return false;
        }

        $sourceSign = base64_decode($this->sign);
        $sign = substr($sourceSign, 0, strpos($sourceSign, "#"));
        $signArr = explode("_", $sign);

        $checkAuth = AuthUser::model()->exists('auth_user_name=:name',array(':name'=>$signArr[count($signArr) - 1]));

        return $checkAuth;
    }

    /**
     * 测试用
     */
    public function actionIndex()
    {
        $this->render('index');
    }
}