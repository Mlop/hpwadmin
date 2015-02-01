<?php

class IncountController extends BaseController
{
	public function actionIndex()
	{
//		$this->render('index');
	}

    /**
     * add new incount
     */
    public function actionCreate()
    {
        $form = new IncountForm();

        $this->render("form");
    }
}