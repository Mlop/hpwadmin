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
    public $callbackFunName = "success_callback";

    /**
	 * jsonp回调函数
	 */
    public function actionCallback()
    {
        $this->callbackFunName = $this->request->getParam('callback');
        $this->sign = $this->request->getParam("sign");
        if (!$this->validateSign()) {
            $this->returnData = $this->encodeResult(t('prompt', 'INVALIDSIGN'), 2);
            echo $this->getCallbackData();
            return ;
        }
        $this->controller = $this->request->getParam("controller");
        $this->action = $this->request->getParam("action");

        $route = $this->controller.'/'.$this->action;
        if (($ca = Yii::app()->createController($route)) !== null) {
            list($controller, $action) = $ca;
            $controller->init();
            $controller->run($action);
            $this->returnData = $controller->returnData;
        } else {
            $this->returnData = $this->encodeResult(t('prompt', 'INVALIDACTION')."：".$route, 2);
        }

//        Yii::app()->runController($this->controller.'/'.$this->action);

        echo $this->getCallbackData();
    }

    /**
     * 封装JSONP返回的数据
     * @return string
     */
    private function getCallbackData()
    {
        return $this->callbackFunName.'('.$this->returnData.')';
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

        $checkAuth = AuthUser::model()->exists('auth_user_name=:name', array(':name'=>$signArr[count($signArr) - 1]));

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