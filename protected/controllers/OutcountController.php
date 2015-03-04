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
        $outcountForm = Yii::app()->request->getParam('Outcount');
        if (!is_null($outcountForm)) {
            try {
                unset($outcountForm['customerName']);
                $outcountForm['user_id'] = 3;

                //modify
                if ($outcount_id) {
                    $updateModel = Outcount::model()->findByPk($outcount_id);
                    $updateModel->setAttributes($outcountForm);
                    $updateModel->save();
                } else {//new record
                    $model = Outcount::model();
                    $model->setAttributes($outcountForm);
                    $model->setIsNewRecord(true);
                    $model->save();
                }

            } catch (Exception $ex) {
                $this->addError('customerName', $ex->getMessage());
            }
        }
        $formModel = new Outcount;
        //fill form when modify
        if ($outcount_id) {
            $formModel->attributes = Outcount::model()->findByPk($outcount_id)->getAttributes();
        }
        $this->render("form", array('model'=>$formModel));
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