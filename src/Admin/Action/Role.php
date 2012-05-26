<?php
/**
 * Admin_Action_Role
 *
 * @version $Id$
 * @author purpen
 */
class Admin_Action_Role extends Admin_Action_Entry {
    protected $_model_class='Common_Model_Role';
    
    public $_main_menu = 'system';

    protected $_permission_ids = null;
    
    
    /**
     * authentication object
     *
     * @var Anole_Auth_Authentication
     */
    protected $_authentication;
    /**
     * authorizedresource interface
     *
     * @return array
     */
    public function getPrivilegeMap(){
        return array(
            '*'=>array(
                'privilege'=>Anole_Auth_AuthenticationResource::PRIV_CUSTOM,
                'custom'=>'validateAdministrator'
            ),
            'execute'=>array(
                'privilege'=> Anole_Auth_AuthenticationResource::PRIV_CUSTOM,
                'custom'=>'validateViewPower'
            ),
            'group'=>array(
                'privilege'=> Anole_Auth_AuthenticationResource::PRIV_CUSTOM,
                'custom'=>'validateViewPower'
            ),
            'edit'=>array(
                'privilege'=> Anole_Auth_AuthenticationResource::PRIV_CUSTOM,
                'custom'=>'validateEditPower'
            ),
            'save'=>array(
                'privilege'=> Anole_Auth_AuthenticationResource::PRIV_CUSTOM,
                'custom'=>'validateEditPower'
            ),
            'remove'=>array(
                'privilege'=> Anole_Auth_AuthenticationResource::PRIV_CUSTOM,
                'custom'=>'validateDeletePower'
            ));
    }
    /**
     * 当前Resource的唯一标识,与ACL中的resource应对应
     */
    public function getResourceId(){
        return 'role';
    }
    /**
     * 设置当前用户的Authentication
     *
     * @param Anole_Auth_Authentication $authentication
     */
    public function _setAuthentication(Anole_Auth_Authentication $authentication){
        $this->_authentication = $authentication;
    }
    /**
     * 
     * @return Common_Model_Role
     */
    public function wiredModel(){
        return parent::wiredModel();
    }
    //~~~~~~~~~~~~~~Action implements~~~~~~~~~~
    /**
     * default action method
     */
    public function execute(){
        return $this->group();
    }
    /**
     * edit role info
     *
     * @return string
     */
    public function edit(){
    	$model = $this->wiredModel();
    	if(!empty($this->_id)){
    		//get role info
    		$model->findById($this->_id);
    		
    		//role acl condition
    		$options = array(
    		  'condition'=>'role_id=?',
    		  'vars'=>array($this->_id)
    		);
    		$acl = new Common_Model_Acl();
    		$acl->find($options);
    		$this->putContext('permission', $acl);
    	}
    	
    	//get all permission
    	$permission = new Common_Model_Permission();
        $permission->find();
    	$this->putContext('permissable' ,$permission);
    	
    	
    	$this->putContext('role' ,$model);
    	
    	//set menu style
        $this->putMenu();
    	return $this->smartyResult('admin.role.edit');
    }
    /**
     * 用户组列表
     *
     * @return string
     */
    public function group(){
    	$model = $this->wiredModel();
    	$options = array(
    	   'condition'=>'state=?',
    	   'vars'=>array(Common_Model_Role::DEFAULT_STATE),
    	   'page'=>$this->_page,
    	   'size'=>$this->_size
    	);
    	$model->find($options);
    	
    	$this->putContext('roles', $model);
    	//set menu style
        $this->putMenu();
    	return $this->smartyResult('admin.role.list');
    }
    /**
     * save role and permission
     * 
     * @return string
     */
    public function save(){
    	$model = $this->wiredModel();
    	$id = $this->getId();
    	if(empty($id) || $id < 0){
    		$model->setIsNew(true);
            $model->setId(null);
    	}else{
    		$model->setIsNew(false);
            $model->setId($this->_id);
    	}
        //save role permissions
        if(!empty($this->_permission_ids)){
            $_ids = preg_split('/,/', $this->_permission_ids);
            $_ids = array_unique($_ids);
            $model->addPermissions($_ids);
        }else{//remove all selected allow permission
        	if(!$model->isNew()){//modify role info
        		$acl = new Common_Model_Acl();
                $acl->removeAllowPermission($this->_id);
        	}
        }
    	try{
    		$model->save();
    		
    		$id = $model->getId();
    	}catch(Anole_ActiveRecord_Exception $e){
    		self::warn("Save role db failed:".$e->getMessage(), __METHOD__);
    		return $this->_jqErrorTip($e->getMessage());
    	}catch(Anole_Exception $e){
    		self::warn("Save role failed:".$e->getMessage(), __METHOD__);
    		return $this->_jqErrorTip($e->getMessage());
    	}
    	
        $this->putContext('role_id', $id);
        
        return $this->jqueryResult('admin.role.edit_ok');
    }
    /**
     * 单个或批量删除用户组
     *
     * @return string
     */
    public function remove(){
    	if(empty($this->_id)){
    		//error page
    		return $this->_hintResult('删除用户组的Id为空!');
    	}
    	//split id string
    	$_ids = preg_split('/,/',$this->_id);
    	try{
    		$model = $this->wiredModel();
    		$model->destroy($_ids);
    	}catch(Anole_ActiveRecord_Exception $e){
    		self::warn("Destory role db failed: ".$e->getMessage(), __METHOD__);
    		return $this->_jqErrorTip($e->getMessage());
    	}catch(Anole_Exception $e){
            self::warn("Destory excute failed: ".$e->getMessage(), __METHOD__);
            return $this->_jqErrorTip($e->getMessage());
        }
        
        $this->putContext('ids', $_ids);
        
        return $this->jqueryResult('admin.role.del_ok');
    }
    #--------------Params----------------
    public function setId($id){
    	$this->_id = $id;
    	return $this;
    }
    public function getId(){
    	return $this->_id;
    }
    public function setPage($page){
    	$this->_page = $page;
    	return $this;
    }
    public function getPage(){
    	return $this->_page;
    }
    
    public function setPermissionIds($v){
    	$this->_permission_ids = $v;
    	return $this;
    }
    public function getPermissionIds(){
    	return $this->_permission_ids;
    }
}
/**vim:sw=4 et ts=4 **/
?>