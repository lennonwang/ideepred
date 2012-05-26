<?php
/**
 * 后台管理登录接口
 * 
 * @author purpen
 * @version $Id$
 *
 */
class Admin_Action_Authorize extends Admin_Action_Entry {
	
    protected $_account = null;
    
    protected $_password = null;
    
    protected $_url = null;
    
    private $_rememberme = null;
    
    const BACK_URL_KEY='__back_url__';
    
    /**
     * 
     * @return Common_Model_Article
     */
    public function wiredModel(){
        return parent::wiredModel();
    }
    //~~~~~~~~~~~~~~Action implements~~~~~~~~~~
    /**
     * default action method
     */
    public function execute(){   
        return $this->welcome();
    }
    /**
     * 默认后台管理欢迎页面
     *
     * @return string
     */
    public function welcome(){
    	$user_id = Anole_Util_Cookie::getAdminID();
    	if(empty($user_id)){
    		return $this->login();
    	}
    	$user = new Common_Model_User();
    	$user->findById($user_id);
        $this->putContext('user', $user);
        
    	$this->putContext('admin_name', Anole_Util_Cookie::getAdminName());
    	$this->putContext('admin_id', $user_id);
    	
    	return $this->smartyResult('admin.system.manage');
    }
    /**
     * 执行登录授权的方法
     * 
     * 如果当前用户尚未登录则会被调用此方法
     */
    public function login(){
        $user_id = Anole_Util_Cookie::getAdminID();
        if(!empty($user_id)){
            return $this->welcome();
        }
    	return $this->smartyResult('admin.system.login');
    }
    /**
     * 权限被拒绝时调用此方法
     */
    public function deny(){
    	$back_url = $this->getContext()->getRequest()->getReferer();
    	
    	$user_id = Common_Util_User::getUserId();
    	
    	$msg = '非常抱歉，您没有足够的权限访问本页面。';
    	
    	$this->putContext('user_id', $user_id);
    	
    	return $this->_hintResult($msg, True, $back_url);
    }
    /**
     * 注销登录
     */
    public function logout(){
    	$url = $this->getNextUrl();
    	if(empty($url)){
    		$url = Admin_Util_Url::app_root_url();
    	}
    	
    	$this->_setNextUrl(null);
    	
        //清空用户登录的cookie
        Anole_Util_Cookie::clearAdminer();
        
        return $this->redirectResult(Admin_Util_Url::app_index_url());
    }
    /**
     * 注册新用户
     */
    public function register(){}
    /**
     * 设置登录注销后需要跳转的url
     *
     * @param string $url
     * @return Admin_Action_Authorize
     */
    public function _setNextUrl($url){
    	$this->getContext()->setSession(self::BACK_URL_KEY,$url);
    	return $this;
    }
    /**
     * 获取需跳转的uri
     *
     * @return string
     */
    public function getNextUrl(){
    	return $this->getContext()->getSession(self::BACK_URL_KEY);
    }
    /**
     * 登陆 注册成功后，跳转的应用程序的地址
     *
     * @return redirectResult
     */
    private function _redirectNext(){
    	$url = $this->getNextUrl();
    	//empty,redirect to welcome page
    	if(empty($url)){
    		$url = Admin_Util_Url::app_root_url();
    	}
    	//重新置空
    	$this->_setNextUrl(null);
        return $this->redirectResult($url);
    }
    /**
     * Validate administrator login 
     *
     * @return string
     */
    public function vlogin(){
    	$_account = $this->getAccount();
    	$_passwd = $this->getPassword();
    	$_remember = $this->getRememberme();
    	
    	$user = new Common_Model_User();
    	$options = array(
    	   'condition'=>'account=? AND role_id<>? AND state=?',
    	   'vars'=>array($_account,0,1)
    	);
    	$user->findFirst($options);
    	if(!$user->count()){
    		return $this->_hintResult('此用户不存在，请返回重新输入!');
    	}
    	
    	//user isn't administrator
    	if(!$user->isAdministrator($_account)){
    		self::warn("Account[$_account] is not administrator!", __METHOD__);
    	}
    	
    	$user_id = $user['id'];
    	$role_id = $user['role_id'];
    	$username = $user['username'];
    	$store_id = $user['store_id'];
    	
    	//user password isn't right
    	$_passwd = hash('sha1', $_passwd);
    	$_passwd2 = $user['password'];
    	if($_passwd !== $_passwd2){
    		return $this->_hintResult('此用户密码输入有误，请返回重新输入!');
    	}
    	
        //验证成功，Set Cookie
        $life_time = 0;
        if($_remember == 1){ // 保存一个月
            $life_time = 864000;
        }
    	//set cookie
    	Anole_Util_Cookie::setAdminID($user_id,$life_time);
    	Anole_Util_Cookie::setAdminName($username,$life_time);
        
        unset($user);
        
        return $this->_redirectNext();
    }
    
    #--------------params--------------
    public function setAccount($account){
    	$this->_account = $account;
    	return $this;
    }
    public function getAccount(){
    	return $this->_account;
    }
    public function setPassword($password){
    	$this->_password = $password;
    	return $this;
    }
    public function getPassword(){
    	return $this->_password;
    }
    
    public function setRememberme($v){
    	$this->_rememberme = $v;
    	return $this;
    }
    public function getRememberme(){
    	return $this->_rememberme;
    }
}
/**vim:sw=4 et ts=4 **/
?>