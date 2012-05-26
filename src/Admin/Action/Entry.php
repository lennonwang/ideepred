<?php
/**
 * Admin模块的公用Action入口Class
 *
 * @version $Id$
 * @author purpen
 */
abstract class Admin_Action_Entry extends Anole_Dispatcher_Action_ModelDriven  {
	
	public $_id = null;
	
	public $_page = 1;
	
	public $_size = 15;
	
	/**
     * authentication
     *
     * @var Anole_Auth_Authentication
     */
    private $_authentication;
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
            )
        );
    }
    /**
     * 当前Resource的唯一标识,与ACL中的resource应对应
     */
    public function getResourceId(){
        return 'user';
    }
    
    /**
     * 检验是否已经登录
     * 
     * @return string
     */
    public function isLogged(){
        return Anole_Util_Cookie::getAdminID() > 0;
    }
    /**
     * 跳转到登录页
     * 
     * @return string
     */
    public function _redirectLogin($next_url=null){
		if(is_null($next_url)){
			$next_url = Admin_Util_Url::app_login_url();
		}
        return $this->redirectResult($next_url);
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
     * validate user isn't administrator
     *
     * @return bool
     */
    public function validateAdministrator(){
    	return true;
    }
    
    /**
     * 检测用户是否有查看的权限
     */
    public function validateViewPower(){
        return true;
    }
    /**
     * 检测用户是否有编辑的权限
     */
    public function validateEditPower(){
        return true;
    }
    /**
     * 检测用户是否有删除的权限
     */
    public function validateDeletePower(){
        return true;
    }
    /*
     *检测用户是否有审核的权限 
     */
    public function validateCheckPower(){
        return true;
    }
    /**
     * put display menu flag
     */
    public function putMenu(){
    	//放置扩展数据
    }
    /**
     * 获取随机数标识
     * 
     * @return int
     */
    public function _genRandsign(){
        return '0000'.rand(0,10000);
    }
    /**
     * 返回操作提示页面
     *
     * @param string $message 要显示的信息
     * @param boolean $is_error 是否为错误提示
     * @param string $url 重定向的url
     * 
     * @return string
     */
    protected function _hintResult($message,$is_error=false,$url=null){
        $this->putContext('has_error', $isError);
        $this->putContext('message', $message);
        $this->putContext('url', $url);
        
        return $this->smartyResult('admin.system.hint');
    }
    
    /**
     * display tip message
     *
     * @param string $msg
     * @param string $append_to
     * @param bool $auto_hide
     * @return string
     */
    public function _jqErrorTip($msg,$append_to=null,$auto_hide=true){
        $this->putContext('jq_error_tip_message', $msg);
        $this->putContext('jq_error_tip_append_to', $append_to);
        $this->putContext('jq_error_tip_auto_hide', $auto_hide);
        
        return $this->jqueryResult('admin.system.jq_error_tip');
    }
    
    
    public function setId($value){
        $this->_id = $value;
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
    
    
    
}
/**vim:sw=4 et ts=4 **/
?>