<?php

class IncountController extends BaseController
{
    public function __construct($id, $module = null)
    {
        parent::__construct($id, $module);
        $this->breadcrumbs->add('incount', $this->createUrl('incount/list'));
    }

    /**
     * create a record into incount db
     */
    public function actionCreate()
    {
        $this->breadcrumbs->add('create');

        $incount_id = Yii::app()->request->getParam('incount_id');
        $incountForm = Yii::app()->request->getParam('Account');

        //modify
        if ($incount_id) {
            $model = Incount::model()->findByPk($incount_id);
        } else {//new record
            $model = new Incount();
        }
        if (!is_null($incountForm)) {
            try {
                $model->setAttributes($incountForm);
                if ($model->save()) {
                    $this->returnData = $this->encodeResult($model);
                } else {
                    $this->returnData = $this->encodeResult($model->getErrors(), self::ERROR_CODE_ARRAY);
                }
            } catch (Exception $ex) {
                $this->returnData = $this->encodeResult($ex->getMessage(), self::ERROR_CODE_STRING);
            }
        } else {
            $this->returnData = $this->encodeResult("未提交表单数据", self::ERROR_CODE_STRING);
        }
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