<?php
/**
 * This component is used for back-end  access control 
 * this component not implement management features of IAuthManager , so you can 
 * manage authitem use this component.
 * you can setup in main config like that .
 * <code>
 * 'authManager'=>array(
 * 		'class'=>'webeez.classes.WebeezAuthManager',
 * 		'enableSuperUser'=>true,
 * 		'superUserId'=>1,
 * 		'enableSuperGroup'=>true,
 *		'superGroupId'=>1
 * ),
 * </code>
 * @author vincent.mi@toursforfun.com
 */
class WebeezAuthManager extends CApplicationComponent implements IAuthManager{
        private $groupCache = array();
        private $groupCacheLength = 0 ;
        /**
         * Super User will skip all permission check ,
         * default we set user_id = 1  is a super user
         * @var boolean
         * @author vincent.mi@toursforfun.com
         */
        public $enableSuperUser = true ;
        public $superUserId = 1 ;
        /**
         * Super group will allow members skip all permission check
         * default we set group_id = 1 is a super group
         * @var boolean
         * @author vincent.mi@toursforfun.com
         */
        public $enableSuperGroup = true ;
        public $superGroupId = 1 ;
        
       
        public function createAuthItem($name,$type,$description='',$bizRule=null,$data=null){
                throw new CException('Not avaliable ');
        }
        public function removeAuthItem($name){
                throw new CException('Not avaliable ');
        }
        public function getAuthItems($type=null,$userId=null){
                throw new CException('Not avaliable ');
        }
        public function getAuthItem($name){
                throw new CException('Not avaliable ');
        }
        public function saveAuthItem($item,$oldName=null){
                throw new CException('Not avaliable ');
        }
        public function addItemChild($itemName,$childName){
                throw new CException('Not avaliable ');
        }
        public function removeItemChild($itemName,$childName){
                throw new CException('Not avaliable ');
        }
        public function hasItemChild($itemName,$childName){
                throw new CException('Not avaliable ');
        }
        public function getItemChildren($itemName){
                throw new CException('Not avaliable ');
        }

        public function assign($itemName,$userId,$bizRule=null,$data=null){
                throw new CException('Not avaliable ');
        }
        public function revoke($itemName,$userId){
                throw new CException('Not avaliable ');
        }
        public function isAssigned($itemName,$userId){
                throw new CException('Not avaliable ');
        }
        public function getAuthAssignment($itemName,$userId){
                throw new CException('Not avaliable ');
        }
        public function getAuthAssignments($userId){
                throw new CException('Not avaliable ');
        }
        public function saveAuthAssignment($assignment){
                throw new CException('Not avaliable ');
        }
        public function clearAll(){
                throw new CException('Not avaliable ');
        }
        public function save(){
                throw new CException('Not avaliable ');
        }
        public function executeBizRule($bizRule,$params,$data){
                throw new CException('Not avaliable ');
        }
        public function clearAuthAssignments(){
                throw new CException('Not avaliable ');
        }
        /**
         * Check if user has some group ,the result will cache in this request
         * MAX allow cache size is 100 users
         * @param mix $groupId group id or group_name
         * @param mix $userId user id or username ,null will use current user's id
         * @author vincent.mi@toursforfun.com (2012-2-29)
         */
        public function hasGroup($groupId , $userId = null){
                if(is_numeric($groupId)){
                        $groupId = intval($groupId);
                }else{
                        $param = array(strval($groupId));
                        $groupId = Yii::app()->db->createCommand("SELECT group_id       FROM `group` WHERE name = ?")->queryScalar($param);
                }

                if($userId == null){
                        $userId = Yii::app()->user->getId(); //null for current user
                }else if(is_numeric($userId)){
                        $userId = intval($userId);
                }else{
                        $param = array(strval($userId));
                        $userId = Yii::app()->db->createCommand("SELECT user_id FROM `user` WHERE username = ?")->queryScalar($param);
                }

                if(isset($this->groupCache[$userId])){
                        return isset($this->groupCache[$userId][$groupId]);
                }else{
                        $result = false;
                        $rows = Yii::app()->db->createCommand("SELECT group_id FROM user_group WHERE user_id = ?")->queryAll(true,array(intval($userId)));
                        $cacheArray = array();
                        foreach($rows as $row){
                                if($row['group_id'] == $groupId){
                                        $result = true ;
                                }
                                $cacheArray[$row['group_id']] = 1 ;
                        }
                        if($this->groupCacheLength < 99){
                                $this->groupCache[$userId] = $cacheArray;
                                $this->groupCacheLength++;
                        }
                        return $result ;
                }
        }
        /**
         * (non-PHPdoc)
         * @see IAuthManager::checkAccess()
         * @author vincent.mi@toursforfun.com (2012-2-24)
         */
        public function checkAccess($itemName,$userId,$params=array()){
              //if($itemName == ':product_change_cost') return false;
                $userId =  $userId == null ? intval(Yii::app()->user->getId()) : intval($userId);//null for current user
                
                //root user and root group will skip permission check
                if($this->enableSuperUser === true && $userId == $this->superUserId){
	               return true ;
	            }                
                if($this->enableSuperGroup === true && $this->hasGroup($this->superGroupId,$userId)){
                   return true ;
                }                
                //root user skip end 
                if(is_numeric($itemName)){
                	$attr = array('permission_id'=>intval($itemName));
                }else{
                	$attr = array('name'=>strval($itemName));
                }
                $permission = Permission::model()->findByAttributes($attr);
                if($permission == null){
                   Yii::app()->user->setFlash('notice',sprintf("Permission '%s' not exists.please contact site administrator to fix this problem.", $itemName));
                   return false;
                }
                //check permission
                $row = Yii::app()->db->createCommand("
                SELECT
                        COUNT(*) AS cnt
                FROM
                        user_permission
                WHERE
                        user_id = ".$userId." AND permission_id = ".$permission->permission_id
                )->queryRow();

                if($row['cnt'] > 0 ){
                        return true;
                }
                //check group
                $row = $row = Yii::app()->db->createCommand("
                SELECT
                        COUNT(*) AS cnt
                FROM
                        user_group ug, group_permission gp
                WHERE
                        ug.group_id = gp.group_id  AND  permission_id = ".$permission->permission_id." AND ug.user_id = ".$userId
                )->queryRow();
                if($row['cnt'] > 0 ){
                        return true;
                }
                return false;
        }
}
