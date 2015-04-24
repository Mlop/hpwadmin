<?php

class OutcountController extends BaseController
{
    public function __construct($id, $module = null)
    {
        parent::__construct($id, $module);
        $this->breadcrumbs->add('outcount', $this->createUrl('outcount/list'));
    }
    /**
     * create a record into outcount db
     */
    public function actionCreate()
    {
        $this->breadcrumbs->add('create');

        $outcount_id = Yii::app()->request->getParam('outcount_id');
        $outcountForm = Yii::app()->request->getParam('Account');

        //modify
        if ($incount_id) {
            $model = Outcount::model()->findByPk($outcount_id);
        } else {//new record
            $model = new Outcount();
        }

        if (!is_null($outcountForm)) {
            try {
                $model->setAttributes($outcountForm);
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
     * delete a outcount record
     */
    public function actionDelete()
    {
        $outcount_id = Yii::app()->request->getParam('outcount_id');
        $return = array('error'=>0, 'msg'=>'');
        if ($outcount_id) {
            try {
                Outcount::model()->deleteByPk($outcount_id);
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
     * get the outcount list
     */
    public function actionList()
    {
        $mode = Outcount::model()->findAllByAttributes(array('user_id'=>3));
        $this->render("list", array('data'=>$mode));
    }
}