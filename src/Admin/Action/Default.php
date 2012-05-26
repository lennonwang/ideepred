<?php
/**
 * 后台信息管理入口
 * 
 * @version $Id$
 * @author purpen
 * 
 */
class Admin_Action_Default extends Admin_Action_Entry {
    protected $_model_class='Common_Model_User';
    
    
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
        return $this->defaultEntery();
    }
    /**
     * 后台管理入口
     * 
     * @return string
     */
    public function defaultEntery(){
        if(!$this->isLogged()){
            return $this->_redirectLogin();
        }
        
        $this->putContext('admin_name', Anole_Util_Cookie::getAdminName());
        $this->putContext('admin_id', Anole_Util_Cookie::getAdminID());
    	
    	
    	return $this->smartyResult('admin.system.manage');
    }
    
/**
     * 主控制面板显示
     * 
     * @return string
     */
    public function main(){
        if(!$this->isLogged()){
            return $this->_redirectLogin();
        }
        $this->putContext('admin_name', Anole_Util_Cookie::getAdminName());
        
        return $this->smartyResult('admin.system.main');
    }
    /**
     * 系统顶部信息
     * @return string
     */
    public function top(){
        $this->putContext('admin_name', Anole_Util_Cookie::getAdminName());
        $this->putContext('admin_id', Anole_Util_Cookie::getAdminID());
        
        return $this->smartyResult('admin.system.top');
    }
    /**
     * 系统菜单信息
     * @return string
     */
    public function left(){
        $admin_id = Anole_Util_Cookie::getAdminID();
        
        return $this->smartyResult('admin.system.left');
    }
    /**
     * 系统收放按钮
     * @return string
     */
    public function click(){
        return $this->smartyResult('admin.system.click');
    }
    /**
     * 系统底部信息
     * @return string
     */
    public function footer(){
        return $this->smartyResult('admin.system.footer');
    }
    
	public function building(){
		return $this->smartyResult('admin.system.building');
	}
}
/**vim:sw=4 et ts=4 **/
?>