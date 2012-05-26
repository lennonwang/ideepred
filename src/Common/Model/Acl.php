<?php
/**
 * Model Common_Model_Acl
 * 
 * @version $Id$
 * @author purpen
 */
class Common_Model_Acl extends Common_Model_Table_Acl {
    
    //关系映射表
    protected $_relation_map = array(
    );
    /**
     * 默认的magic field
     */
    protected $_magic_field = array();
    
    const POLICE_ALLOW = 1;
    const POLICE_DENY = 0;
    
    /**
     * @return Common_Model_Acl
     */
    public static function getModel($data=array(),$class=__CLASS__){
        return parent::getModel($data,$class);
    }
    
    /**
     * remove role all allow privilege
     *
     * @param int $role_id
     * 
     * @return Common_Model_Acl
     */
    public function removeAllowPermission($role_id=null){
    	if(is_null($role_id)){
    		$role_id = $this->getRoleId();
    	}
    	if(empty($role_id)){
    		self::warn("Remove all acl and role_id is NUll!", __METHOD__);
    		return $this;
    	}
    	$condition = 'role_id=? AND police=?';
    	$vars = array($role_id, self::POLICE_ALLOW);
    	$this->deleteAll($condition, $vars);
    	
    	return $this;
    }
    /**
     * remove user deny privilege
     *
     * @param int $user_id
     * 
     * @return Common_Model_Acl
     */
    public function removeDenyPermission($user_id=null){
    	if(is_null($user_id)){
    		$user_id = $this->getUserId();
    	}
    	if(empty($user_id)){
    		self::warn("Remove user acl and user_id is Null!", __METHOD__);
    		return $this;
    	}
    	$condition = 'user_id=? AND police=? ';
    	$vars = array($user_id,self::POLICE_DENY);
    	$this->deleteAll($condition,$vars);
    	
    	return $this;
    }
    
}
/**vim:sw=4 et ts=4 **/
?>