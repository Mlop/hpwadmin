<?php

/**
 * bank account transfer class
 * @author vera zhang 2015-01-25
 */
class TransferController extends CController
{
	/**
	 * Index action is the default action in a controller.
	 */
	public function actionIndex()
	{
        echo 'transfer';
//        var_dump(get_include_path());
//        $user = User::model()->findByPk(15);
//		echo $user->username.'   mymy my Hello World';
	}

    /**
     * 记录转账给他人
     */
    public function actionIncount()
    {

    }

    /**
     * 记录收入
     */
    public function actionOutcount()
    {

    }

    /**
     * 统计（a 固定时间内所有出、入账情况，b 按出账人姓名统计）
     */
    public function actionStat()
    {

    }
}