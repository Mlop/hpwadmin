<?php
/**
 * This component is used filter ssl
 * @author Star
 */
class WebeezRequestFilter extends CFilter
{
    
    protected function preFilter($filterChain)
    {
        $_controller = Yii::app()->controller;
        $_action_name =  $_controller->getAction()->id;
        $_controller_name = $_controller->id;
        $_urlManager = Yii::app()->urlManager;
        $route = $_controller_name.'/'.$_action_name;
        if ($_urlManager->checkSSLRoute($route) && !$this->is_SSL()) {
            $url = Yii::app()->request->getHostInfo('https') . $_SERVER['REQUEST_URI'];
            Yii::app()->request->redirect($url);
        }
        return true;
    }

    private function is_SSL()
    {
        if ($_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
            return true;
        } else if ($_SERVER['HTTPS'] === 1) {
            return true;
        } else if ($_SERVER['HTTPS'] === 'on') {
            return true;
        } else if ($_SERVER['SERVER_PORT'] === 443) {
            return true;
        }
        return false;
    }
}
