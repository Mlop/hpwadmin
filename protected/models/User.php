<?php
/**
 * The Administrator user model
 * @author vera zhang 2015-01-25
 * @property string $username
 * @property string $password
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property integer $user_id
 * @property integer $active
 * @property integer $date_created
 * @property string $last_updated
 * @property int $email_notification
 */
class User extends CActiveRecord {
//        const UNASSIGNED = 10001;
//		private $_provider_id = null;
//		private $_provider = -1;

        public function tableName()
        {
                return 'user';
        }
        public function relations(){
                return array(
//                        'groups'=>array(self::MANY_MANY,'Group','user_group(user_id,group_id)'),
//                        'permissions'=>array(self::MANY_MANY,'Permission','user_permission(user_id,permission_id)'),
//                        'login_history'=>array(self::HAS_ONE , 'UserLoginHistory' , 'user_id'),
//                        'orderHistoryUpdates' => array(self::HAS_MANY, 'OrderStatusHistory', 'updated_by'),
//                        'orderSettlementInformations'=>array(self::HAS_MANY, 'OrderSettlementInformation', 'updated_by'),
//                        'orderProductDepartureHistories'=>array(self::HAS_MANY, 'OrderProductDepartureHistory', 'op_history_modify_by_id'),
//			            'OrderCsrOperators' => array(self::HAS_MANY, 'OrderCsrOperator', 'user_id'),
                );
        }

        public function rules(){
                return array(
                        array('name,password','required'),
                        array('password','required','on'=>'insert'),
                        array('name', 'length', 'max'=>100),
                        array('password', 'length', 'max'=>50),
                        array('username','unique','allowEmpty'=>false),
                );
        }

        public static function model($className=__CLASS__)
        {
                return parent::model($className);
        }
        /**
         * encrypt a password
         * @param unknown_type $plainPassword
         */
        public static function encrypt($password){
                $salt = substr(md5(mt_rand(1, 10000)),mt_rand(0,30),2);
                return md5($salt.$password).$salt;
        }
        /**
         * validate the password
         * @param encrypt the encrypted password
         * @param string $password plain password
         */
        public static function validatePassword($encrypt='' , $password = ''){
                if(strlen($encrypt) != 34 || $password == ''){
                        return false ;
                }
                $salt = substr($encrypt,32);
                return md5($salt.$password).$salt == $encrypt;
        }
		
		 /**
         * validate the provider old password with md5 only
		 * @param encrypt the encrypted password
         * @param string $password plain password
		 * amit created for allow old provider with same password
         */
        public static function validatePasswordProviderOld($encrypt='' , $password = ''){
				if($password == ''){
					 return false ;
				}
                return md5($password) == $encrypt;
        }
        /**
         * Find User by Username
         * @param unknown_type $username
         */
        public static function findByUsername($username){
                return User::model()->findByAttributes(array('username'=>$username));
        }
        
        public function getIsProviderAccount(){
        	return $this->getProviderId() > 0;
        }
        
        public function getProviderId(){
        	if($this->_provider_id === null){
        		$provider_id = UserProvider::findByUserid($this->user_id);
        		$this->_provider_id = $provider_id != null ? $provider_id->provider_id:0;
        	}
        	return $this->_provider_id;
        }
        
        public function getProvider(){
        	if($this->_provider === -1){        		
        		$this->_provider =  Provider::model()->findByPk($this->getProviderId());
        	}
        	return $this->_provider;
        	
        }

        /**
         * create a new user .
         * add userloginhistory .etc
         */
        public static function create($username , $password='' , $email='',$firstname='',$lastname='',$active = 1,$email_notification=1){
                $u = new User;
                if($password == ''){
                        $password = self::generatePassword(10);
                }
                if(is_array($username)){
                        $u->setAttributes($username);
                }else{
                        $u->setAttributes(array(
                                'username'=>$username,
                                'password'=>User::encrypt($password),
                                'email'=>$email,
                                'first_name'=>$firstname,
                                'last_name'=>$lastname,
                                'email_notification'=>$email_notification,
                                'last_updated'=>date('Y-m-d H:i:s',time()),
                                'active'=>$active
                        ));
                }
                if($u->validate()){
                        $u->insert();
                }
                if(!$u->hasErrors()){
                        $ulh = new UserLoginHistory();
                        $ulh->user_id = $u->user_id;
                        $ulh->login_count = 0 ;
                        $ulh->ip = Yii::app()->request->userHostAddress;
                        $ulh->insert();
                }
                return $u ;
        }
        /**
         * generate a random password for user
         * @param int $len string length
         */
        public static function generatePassword($len){
                $src = '0123456789abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ%*!$&#';
                $strlen = strlen($src);
                $password = '';
                for($i=0;$i<$len;$i++){
                        $password.= substr($src,mt_rand(0, $strlen),1);
                }
                return $password;
        }
        /**
         * Check user is valiable
         */
        public function isActive(){
                return $this->getAttribute('active') == 1;
        }
        /**
         *generate full name for user
         */
        public function getFullName(){
                return $this->first_name.' '.$this->last_name;
        }
        /**
         * Remove user with transaction
         * @author vincent.mi@toursforfun.com (2012-2-14)
         */
        public function removeUser(){
                $transaction = $this->dbConnection->beginTransaction();
                try{
                        UserLoginHistory::model()->deleteAllByAttributes(array('user_id'=>$this->user_id));
                        self::$db->createCommand('DELETE FROM user_permission WHERE user_id = '.intval($this->user_id))->execute();
                        self::$db->createCommand('DELETE FROM user_group WHERE user_id = '.intval($this->user_id))->execute();
                        $this->delete();
                        $transaction->commit();
                        return true;
                }catch(Exception $e){
                        $transaction->rollBack();
                        return false;
                }
        }
        public function getGroupNames(){
                $groups = $this->groups;
                $names = array();
                foreach($groups as $g){
                        $names[]  =$g['name'];
                }
                return implode(',',$names);
        }
        /**
         * get groups id array , array(group_id)
         * @return array array(group_id)
         * @author vincent.mi@toursforfun.com (2012-2-14)
         */
        public function getGroupIds(){
                $reader=$this->dbConnection->createCommand('SELECT group_id FROM user_group WHERE user_id = ? ORDER by group_id ASC')->query(array($this->user_id));
                $arr = array();
                foreach($reader as $r){
                        $arr[] = $r['group_id'];
                }
                return $arr ;
        }
        /**
        * get permissions id array , array(group_id)
        * @return array array(permission_id)
        * @author vincent.mi@toursforfun.com (2012-2-14)
        */
        public function getPermissionIds(){
                $reader=$this->dbConnection->createCommand('SELECT permission_id FROM user_permission WHERE user_id = ? ORDER by permission_id ASC')->query(array($this->user_id));
                $arr = array();
                foreach($reader as $r){
                        $arr[] = $r['permission_id'];
                }
                return $arr ;
        }

        /**
        * Update user permission
        * @param User $user
        * @param array $new_groups
        * @author vincent.mi@toursforfun.com (2012-2-14)
        */
        public function updatePermissions($newPermissions){
                $newAuthItems = (array)$newPermissions;
                $oldAuthItems  = $this->permissionIds ;
                $pItemId = $this->user_id;
                $affected = 0;
                if(empty($newAuthItems)){
                        $affected = self::$db->createCommand('DELETE FROM user_permission WHERE user_id = '.intval($pItemId))->execute();
                }else{
                        if(empty($oldAuthItems)){
                                $needDelete = array();
                                $needInsert = $newAuthItems;
                        }else{
                                $needDelete = array_diff($oldAuthItems ,$newAuthItems);
                                $needInsert = array_diff($newAuthItems ,$oldAuthItems);
                        }
                        foreach($needDelete as $itemId ){
                                if(is_numeric($itemId)){
                                        self::$db->createCommand('DELETE FROM user_permission WHERE user_id = '.$pItemId.' AND permission_id = '.intval($itemId))->execute();
                                        $affected++;
                                }
                        }
                        foreach($needInsert as $itemId ){
                                if(is_numeric($itemId)){
                                        self::$db->createCommand('INSERT INTO user_permission (user_id,permission_id) VALUES ( '.$pItemId.','.intval($itemId).')')->execute();;
                                        $affected++;
                                }
                        }
                }
                return $affected;
        }
        /**
        * Update user groups
        * @param User $user
        * @param array $new_groups
        * @author vincent.mi@toursforfun.com (2012-2-14)
        */
        public function updateGroups($newGroups){
                $newAuthItems = (array)$newGroups;
                $oldAuthItems  = $this->groupIds ;
                $pItemId = $this->user_id;
                $affected = 0;
                if(empty($newAuthItems)){
                        $affected = self::$db->createCommand('DELETE FROM user_group WHERE user_id = '.intval($pItemId))->execute();
                }else{
                        if(empty($oldAuthItems)){
                                $needDelete = array();
                                $needInsert = $newAuthItems;
                        }else{
                                $needDelete = array_diff($oldAuthItems ,$newAuthItems);
                                $needInsert = array_diff($newAuthItems ,$oldAuthItems);
                        }
                        foreach($needDelete as $itemId ){
                                if(is_numeric($itemId)){
                                        self::$db->createCommand('DELETE FROM user_group WHERE user_id = '.$pItemId.' AND group_id = '.intval($itemId))->execute();
                                        $affected++;
                                }
                        }
                        foreach($needInsert as $itemId ){
                                if(is_numeric($itemId)){
                                        self::$db->createCommand('INSERT INTO user_group (user_id,group_id) VALUES ( '.$pItemId.','.intval($itemId).')')->execute();;
                                        $affected++;
                                }
                        }
                }
                return $affected;
        }


        public function beforeSave(){
                if(!$this->isNewRecord){
                        $this->last_updated = date('Y-m-d H:i:s');
                }else{
                        $this->created = date('Y-m-d H:i:s');
                }
                return true;
        }

        public function getAllUserList($group_id = null){
            $arr = array();
            $criteria = new CDbCriteria();
            $criteria->addCondition('u.parent_user_id is NULL');
            $criteria->addCondition('u.user_id != 10001');
            $criteria->select = 'u.user_id, u.first_name, u.last_name';
            $criteria->alias = 'u';
            if($group_id){
                $criteria->join = ' LEFT JOIN user_group ug ON u.user_id = ug.user_id';
                if(is_array($group_id)){
                    $criteria->addInCondition('ug.group_id', $group_id);
                } else {
                    $criteria->addCondition('ug.group_id = :group_id');
                    $criteria->params[':group_id'] = $group_id;
                }
            }
            $all = $this->findAll($criteria);
            if($all){
                foreach($all as $rows){
                    $arr[$rows['user_id']] = $rows['first_name'].' '.$rows['last_name'];
                }
            }
            return $arr;
        }

        public function getAdminUserName($id) {
            $user = User::model()->findByPk($id, array('select' => 'first_name, last_name, email'));
            if ($user) {
                return $user->first_name ? $user->first_name . ' ' . $user->last_name : $user->email;
            }
            return '';
		}
		/**
         * Check user is parent provider
        */
        public static function isParentProvider($id){
                $row = User::model()->find('user_id=:user_id',array(':user_id'=>(int)$id));
				return (int)$row->parent_user_id;
        }
		//for deleting records from order_csr_operator table on deletion of user.
		public function beforeDelete(){
				OrderCsrOperator::model()->deleteAllByAttributes(array('user_id'=>(int)$this->user_id));
		}

    public static function getBuAccessList()
    {
        $access = array();
        foreach (Product::$bu_list as $bu) {
            if(Yii::app()->user->checkAccess(':access_bu_' . $bu)) {
                $access[$bu] = $bu;
            }
        }
        return $access;
    }
}
?>
