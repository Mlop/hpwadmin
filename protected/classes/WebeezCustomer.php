<?php
/**
 * This customer is used for TFF customer login
 * @author vincent.mi@toursforfun.com
 */
class WebeezCustomer extends CWebUser {
	function beforeLogin($id, $states, $fromCookie){
		return true ;
	}
	/**
	 * after login add
	 * @see CWebUser::afterLogin()
	 * @author vincent.mi@toursforfun.com
	 */
	function afterLogin($fromCookie){
		//remember user account name
//		setcookie('user_remembered_accountname',$this->getState('email'),time() + 3600*24*30*12);
		setcookie('LoginDate', date('Ymd his',time()));
//		$this->updateLoginCount();
//		$this->updateOnlineStatus();
//		$this->saveFavoritesToDatabase();
//		$this->addScoreForEveryDayLogin();
//		$this->countSuccessPurchased();
	}
//	public function getCountSuccessPurchased(){
//		return $_SESSION['total_pur_suc_nos_of_cnt'];
//	}
	/**
	 * count current user's success purchased orders
	 * if you want get the cached data ,use $_SESSION['total_pur_suc_nos_of_cnt']
	 * this method will recalculate count and update session value .
	 * @return int
	 */
//	public function countSuccessPurchased(){
//		if(!is_numeric($this->id) || $this->id <= 0 ){
//			return 0;
//		}
//		$num =  Order::model()->countByAttributes(array('customer_id'=>$this->id , 'status'=>'100006'));//total purchased
//		$_SESSION['total_pur_suc_nos_of_cnt'] = $num;
//		return $num;
//	}
	/**
	 * Insert or update current user's online status
	 * when you want refresh customer online status
	 * please call Yii::app()->user->updateOnlineStatus();
	 * @return boolean true=>user has been updated
	 */
//	public function updateOnlineStatus(){
//		if(!is_numeric($this->id) || $this->id <= 0){
//			return false;
//		}
//		$co = CustomerOnline::model()->findByAttributes(array('customer_id'=>$this->id));
//		if($co == null){
//			$co = new CustomerOnline();
//			$co->customer_id = $this->id ;
//		}
//		$co->last_activity = date('Y-m-d H:i:s' , time());
//		Yii::log('update online activity','trace','login');
//		return $co->save();
//	}
	/**
	 * update user's login count
	 * this method will be called when user loged in
	 */
//	protected function updateLoginCount(){
//		if(!is_numeric($this->id) || $this->id <= 0){
//			return false;
//		}
//		$info  = CustomerInfo::model()->findByAttributes(array('customer_id' => $this->id));
//		if($info  == null ) {
//			CustomerInfo::$db->createCommand('
//					INSERT INTO '.CustomerInfo::model()->tableName().'
//					( number_of_logins,global_product_notification,created,last_updated,last_login,idle_mail_send_date,customer_id)
//					VALUES
//					(1 , 0 ,\''.date('Y-m-d H:i:s' ,time()). '\',\''.date('Y-m-d H:i:s' ,time()). '\',\''.date('Y-m-d H:i:s' ,time()). '\',\'0000-00-00 00:00:00\' , '.intval($this->id).')')->execute();
//		}else{
//			CustomerInfo::$db->createCommand(' UPDATE '.CustomerInfo::model()->tableName().'  SET last_login = \''.date('Y-m-d H:i:s' ,time()). '\' , number_of_logins = number_of_logins + 1 WHERE customer_id = '.intval($this->id))->execute();
//		}
//		Yii::log('update login count','trace','login');
//		//$info->save(false);
//	}
	/**
	 * add score for every day login save a cookie value
	 * this method will be called when user loged in
	 * @todo use cookie is not safe ,imporve in the future
	 * @author vincent.mi@toursforfun.com
	 */
//	protected function addScoreForEveryDayLogin(){
//		if(!is_numeric($this->id) || $this->id <= 0){
//			return false;
//		}
//		$everyDayScoreDescription = defined('EVERY_DAY_LOGIN') ? strval(EVERY_DAY_LOGIN):'EVERY_DAY_CHECKIN';
//		$everyDayScore = defined('EVERY_DAY_LOGIN_SCORE') ? strval(EVERY_DAY_LOGIN_SCORE):'+5';
//		//check added everydaylogin score
//
//		$count = CustomerPoint::model()->count(
//			'comment = :comment AND customer_id = :cid AND ( created >= :date1 AND created <= :date2)' ,
//			array( ':comment'=>EVERY_DAY_CHECKIN ,':cid'=>$this->id , ':date1'=> date('Y-m-d 00:00:00') , ':date2'=>date('Y-m-d 23:59:59') )
//		);
//
//		if($count > 0){
//			return  false;
//		}
//
//		$cp = new CustomerPoint()  ;
//		$cp->addConfirmedPoints($this->id, 0, $everyDayScore, $everyDayScoreDescription, 'CH');
//		$cp->updateCustomerShoppingPoints($this->id);
//
//        $customer = Customer::model()->findByPk($this->id);
//        $result = $customer->calculateCustomerExperience();
//
//		return $result;
//	}
	/**
	 * save favorite from session to database .
	 * this function  will just called when customer login
	 * @author vincent.mi@toursforfun.com
	 */
//	protected function saveFavoritesToDatabase(){
//		if(isset($_SESSION['favorites']) && is_array($_SESSION['favorites'])) {
//			foreach($_SESSION['favorites'] as $favoriteItem){
//				$favorite = new CustomerFavorite();
//				$favorite->setAttribute('product_id', intval($favoriteItem['product_id']));
//				$favorite->setAttribute('customer_id', intval($this->id));
//				$favorite->setAttribute('added_time', date('Y-m-d H:i:s' , time()));
//				$favorite->setAttribute('updated_time', date('Y-m-d H:i:s' , time()));
//				$favorite->save();
//			}
//			Yii::log('favorites saved.','trace','login');
//			unset($_SESSION['favorites']);
//		}
//		Yii::log('no favorites.','trace','login');
//	}

	/**
	 * @author demon.deng@toursforfun.com
	 */
//        public function loginRequired()
//        {
//                $app=Yii::app();
//                $request=$app->getRequest();
//
//                if(!$request->getIsAjaxRequest())
//                        $this->setReturnUrl($request->getUrl());
//                elseif(isset($this->loginRequiredAjaxResponse))
//                {
//                        echo $this->loginRequiredAjaxResponse;
//                        Yii::app()->end();
//                }
//
//                if(($url=$this->loginUrl)!==null)
//                {
//                        if(is_array($url))
//                        {
//                                $route=isset($url[0]) ? $url[0] : $app->defaultController;
//                                $url=$app->createUrl($route,array_splice($url,1),'ssl');
//                        }
//                        $request->redirect($url);
//                }
//                else
//                        throw new CHttpException(403,Yii::t('yii','Login Required'));
//        }
//
//    public function getId()
//    {
//        return $this->username;
//    }
    /**
     * 使用用户名和密码登陆，写cookie
     * @return bool|void
     */
//    public function login($user, $duration = 0)
//    {
//        if ($this->beforeLogin()) {
//
//        }
//    }
}

