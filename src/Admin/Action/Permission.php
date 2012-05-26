<?php
/**
 * Admin_Action_Permission
 *
 * @version $Id$
 * @author purpen
 */
class Admin_Action_Permission extends Admin_Action_Entry {
    protected $_model_class='Common_Model_Permission';
    
    public $_main_menu = 'system';
    
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
        return 'permission';
    }
    /**
     * 
     * @return Common_Model_Permission
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
     * permission list
     * 
     * @return string
     */
    public function group(){
    	$model = $this->wiredModel();
    	//get total page
    	$records = $model->countIf();
    	$total = ceil($records/$this->_size);
    	$_page = min($total,$this->_page);
    	
    	//get current page data
    	$options = array(
    	   'page'=>$_page,
    	   'size'=>$this->_size
    	);
    	$model->find($options);
    	
    	$this->putContext('permissions', $model);
    	$this->putContext('records', $records);
    	$this->putContext('total', $total);
    	$this->putContext('page', $_page);
    	
    	//set menu style
    	$this->putMenu();
    	
    	return $this->smartyResult('admin.permission.list');
    }
    
    public function edit(){
    	$model = $this->wiredModel();
        
    	$id = $this->getId();
    	if(!empty($id)){
    		$model->findById($id);
    	}

    	$this->putContext('permission', $model);
    	
    	//set menu style
        $this->putMenu();
    	
    	return $this->smartyResult('admin.permission.edit');
    }
    /**
     * save permission info
     * 
     * @return string
     */
    public function save(){
    	$model = $this->wiredModel();
    	if(empty($this->_id) || $this->_id < 0){
    		$model->setIsNew(True);
    		$model->setId(null);
    	}else{
    		$model->setId($this->_id);
    		$model->setIsNew(False);
    	}
    	try{
    		$model->save();
    		
    		$id = $model->getId();
    		
    	}catch(Anole_ActiveRecord_Exception $e){
    		self::warn("Save permission failed:".$e->getMessage(), __CLASS__);
    		return $this->_jqErrorTip($e->getMessage());
    	}
    	
    	$this->putContext('permission_id', $id);
    	
    	return $this->jqueryResult('admin.permission.edit_ok');
    }
    /**
     * 单个或批量删除记录
     *
     * @param int or array $_ids
     * 
     * @return string
     */
    public function remove(){        
        if(empty($this->_id) || $this->_id < 0){
        	self::warn('删除权限的Id为空!', __METHOD__);
        	return $this->_hintResult('删除权限的Id为空!',true);
        }
        //split id string
        $_ids = preg_split('/,/',$this->_id);
        try{
        	$model = $this->wiredModel();
        	$model->destroy($_ids);
        }catch(Anole_ActiveRecord_Exception $e){
        	self::warn("Destory validate failed:".$e->getMessage(), __METHOD__);
        	return $this->_jqErrorTip($e->getMessage());
        }catch(Anole_Exception $e){
        	self::warn("Destory excute failed:".$e->getMessage(), __METHOD__);
        	return $this->_jqErrorTip($e->getMessage());
        }
        
        $this->putContext('ids', $_ids);
        
        return $this->jqueryResult('admin.permission.del_ok');
    }
    
    #------------Parameters------------------
    public function setId($id){
    	$this->_id = $id;
    	return $this;
    }
    
    public function getId(){
    	return $this->_id;
    }
    //set page
    public function setPage($page){
    	$this->_page = $page;
    	return $this;
    }
    public function getPage(){
    	return $this->_page;
    }
}
/**vim:sw=4 et ts=4 **/
?>