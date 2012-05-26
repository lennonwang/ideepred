<?php
/**
 * 系统会员管理
 *
 * @version $Id$
 * @author purpen
 */
class Admin_Action_User extends Admin_Action_Entry {
	
    protected $_model_class='Common_Model_User';
    
    protected $_role_id = null;
    
    private $_state = 0;
    
    public $_main_menu = 'user';
    
    private $_account = null;
    private $_username = null;
    
    
    /**
     * 
     * @return Common_Model_User
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
     * 会员用户列表
     * 
     * @return string
     */
    public function group(){
		if(!$this->isLogged()){
            return $this->_redirectLogin();
        }
    	$model = $this->wiredModel();
    	
    	$state = $this->getState();
    	$page  = $this->getPage();
    	$size  = $this->_size;
    	$role_id = $this->getRoleId();
    	
    	if(!is_null($state)){
    		$conditions[] = 'state=?';
    		$vars[] = $state;
    	}
    	if(!is_null($role_id)){
    		$conditions[] = 'role_id=?';
    		$vars[] = $role_id;
    	}
    	
    	if(!empty($conditions)){
    		$condition = implode(' AND ', $conditions);
    	}else{
    		$condition = null;
    	}
    	//get total page
        $records = $model->countIf($condition,$vars);
        $total = ceil($records/$size);
        $page = min($total, $page);
        
    	$options = array(
    	   'condition'=>$condition,
    	   'vars'=>$vars,
    	   'order'=>'updated_on DESC,created_on DESC',
    	   'page'=>$page,
    	   'size'=>$this->_size
    	);
    	$model->find($options);
    	
    	$this->putContext('users', $model);
    	$this->putContext('state',$state);
    	
    	$this->putContext('records', $records);
    	$this->putContext('total', $total);
    	$this->putContext('page', $page);
    	
    	$start = ($page - 1)*$size + 1;
        $end = min($page*$size, $records);
    	$this->putContext('start', $start);
        $this->putContext('end',$end);
        
        $page_list = Common_Util_Pager::XE_NewPager(array('page'=>$page,'total'=>$total));
        $this->putContext('page_list', $page_list);
    	
        //获取每个角色的数量
        if(!is_null($role_id)){
            $all_count = $model->countIf();
        }else{
            $all_count = $records;
        }
        $admin_count = $model->countIf('role_id=?',array(9));
        $editor_count = $model->countIf('role_id=?',array(3));
        $service_count = $model->countIf('role_id=?',array(2));
        $vip_count = $model->countIf('role_id=?',array(1));
		$active_count = $model->countIf('state=?',array(1));
        
        $this->putContext('all_count', $all_count);
        $this->putContext('admin_count', $admin_count);
        $this->putContext('editor_count', $editor_count);
        $this->putContext('service_count', $service_count);
        $this->putContext('vip_count', $vip_count);
		$this->putContext('active_count', $active_count);
        
    	return $this->smartyResult('admin.user.list');
    }
    /**
     * 查询用户
     * 
     * @return string
     */
    public function search(){
    	return $this->smartyResult('admin.user.search');
    }
    
    public function doSearch(){
    	$model = $this->wiredModel();
    	
    	$id = $this->getId();
    	$username = $this->getUsername();
    	$account = $this->getAccount();
    	
    	$conditions = array();
    	$vars = array();
    	
    	if(!empty($id)){
    		$conditions[] = 'id=?';
    		$vars[] = $id;
    	}
    	
    	if(!empty($username)){
    		$conditions[] = 'username like ?';
    		$vars[] = "%$username%";
    	}
    	
    	if(!empty($account)){
    		$conditions[] = 'account like ?';
    		$vars[] = "%$account%";
    	}
    	
    	if(!empty($conditions)){
    		$condition = implode(' AND ', $conditions);
    	}else{
    		$condition = null;
    	}
    	
    	$records = $model->countIf($condition,$vars);
    	$total = ceil($records/$this->_size);
        $page = min($total, $this->_page);
        
        $options = array(
            'condition'=>$condition,
            'vars'=>$vars,
            'page'=>$page,
            'size'=>$this->_size
        );
        $model->find($options);
        
        $this->putContext('records', $records);
        $this->putContext('page',$page);
        $this->putContext('total', $total);
        
        $this->putContext('users', $model);
        
        return $this->jqueryResult('admin.user.search_result');
    }
    /**
     * 具有详细信息的用户
     * 
     * @return string
     */
    public function realityUser(){
        $model = $this->wiredModel();
        $condition = 'state=? AND is_reality=?';
        $vars = array($this->_state,1);
        
        //get total page
        $records = $model->countIf($condition,$vars);
        $total = ceil($records/$this->_size);
        $page = min($total, $this->_page);
        
        $options = array(
           'condition'=>$condition,
           'vars'=>$vars,
           'order'=>'updated_on DESC,created_on DESC',
           'page'=>$page,
           'size'=>$this->_size
        );
        $model->find($options);
        
        $this->putContext('users', $model);
        $this->putContext('state',$this->_state);
        
        $this->putContext('records', $records);
        $this->putContext('total', $total);
        $this->putContext('page', $page);
        
        //set menu style
        $this->putMenu();
        
        return $this->smartyResult('admin.user.reality');
    }
    /**
     * 添加或编辑用户信息
     * 
     * @return string
     */
    public function edit(){
		if(!$this->isLogged()){
            return $this->_redirectLogin();
        }
    	$model = $this->wiredModel();
    	
    	$id = $this->getId();
    	
    	$edit_mode = 'create';
    	if(!empty($id)){
    		$edit_mode = 'edit';
    		$model->findById($id);
    	}
    	
    	$this->putContext('user', $model);
    	$this->putContext('edit_mode', $edit_mode);
    	
    	
    	return $this->smartyResult('admin.user.edit');
    }
    /**
     * add user info
     * 
     * @return string
     */
    public function save(){
		if(!$this->isLogged()){
            return $this->_redirectLogin();
        }
    	$model = $this->wiredModel();
    	$id = $this->getId();
    	if(empty($id) || $id < 0){
    		$model->setIsNew(true);
    		$model->setId(null);
    		$edit_mode = 'create';
    	}else{
    		$model->setIsNew(false);
    		$model->setId($id);
    		$edit_mode = 'edit';
    	}
    	try{
    		$model->save();
    		
    		$id = $model->getId();
    	}catch(Anole_ActiveRecord_Exception $e){
    		self::warn("Save user record failed:".$e->getMessage(), __METHOD__);
    		$this->putContext('msg', $e->getMessage());
    		return $this->jsonResult(500);
    	}catch(Anole_Exception $e){
    		self::warn("Save user info failed:".$e->getMessage(), __METHOD__);
    		$this->putContext('msg', $e->getMessage());
            return $this->jsonResult(500);
    	}
        
    	$this->putContext('user_id', $id);
    	$this->putContext('edit_mode',$edit_mode);
    	
    	return $this->jqueryResult('admin.user.edit_ok');
    }
    /**
     * 单个或批量删除user
     *
     * @return string
     */
    public function remove(){
		if(!$this->isLogged()){
            return $this->_redirectLogin();
        }
    	if(empty($this->_id)){
    		//error page
    		return $this->_hintResult('删除用户的Id为空!');
    	}
        //split id string
        $_ids = preg_split('/,/',$this->_id);
        try{
            $model = $this->wiredModel();
            $model->destroy($_ids);
        }catch(Anole_ActiveRecord_Exception $e){
            self::warn("Destory user db failed: ".$e->getMessage(), __METHOD__);
            return $this->_jqErrorTip($e->getMessage());
        }catch(Anole_Exception $e){
            self::warn("Destory excute failed: ".$e->getMessage(), __METHOD__);
            return $this->_jqErrorTip($e->getMessage());
        }
        unset($model);
        
        $this->putContext('ids', $_ids);
        $this->putContext('edit_mode', 'delete');
        
        return $this->jqueryResult('admin.user.edit_ok');
    }
    /**
     * 会员用户激活
     * 
     * @return string
     */
    public function activate(){
    	$model = $this->wiredModel();
    	try{
    		if(empty($this->_id)){
	            //error page
	            return $this->_hintResult('激活用户的Id为空!');
	        }
	        //split id string
	        $_ids = preg_split('/,/',$this->_id);
	        foreach($_ids as $id){
	        	$model->setIsNew(false);
                $model->setId($id);
                $model->setState(Common_Model_User::STATE_ACTIVE);
                $model->save();
	        }
    	}catch(Anole_ActiveRecord_Exception $e){
    		self::warn("activate user failed:".$e->getMessage(), __METHOD__);
    	}
    	unset($model);
    	
    	$this->putContext('ids', $_ids);
    
    	return $this->jqueryResult('admin.user.del_ok');
    }
    
    
    public function setAccount($account){
        $this->_account = $account;
        return $this;
    }
    public function getAccount(){
        return $this->_account;
    }
    
    public function setUsername($username){
        $this->_username = $username;
        return $this;
    }
    public function getUsername(){
        return $this->_username;
    }
    
    public function setRoleId($id){
    	$this->_role_id = $id;
    	return $this;
    }
    public function getRoleId(){
    	return $this->_role_id;
    }
    
    public function setState($state){
    	$this->_state = $state;
    	return $this;
    }
    public function getState(){
    	return $this->_state;
    }
}
/**vim:sw=4 et ts=4 **/
?>