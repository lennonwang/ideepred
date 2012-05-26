<?php
/**
 * 电子商务系统共用变量及通用操作方法
 * 
 * @author purpen
 * @version $Id$
 */
abstract class Eshop_Action_Common extends Anole_Dispatcher_Action_ModelDriven {
	
	public $_id = null;
	
	public $_page=1;
	
	/**
	 * 检验是否已经登录
	 * 
	 * @return string
	 */
	public function isLogged(){
	    return Anole_Util_Cookie::getUserID() > 0;
	}
	/**
	 * 跳转到登录页
	 * 
	 * @return string
	 */
	public function _redirectLogin($next_url=null){
		if(is_null($next_url)){
			$next_url = Common_Util_Url::app_root_url();
		}
		Common_Util_Url::setBackUrl($next_url);
	    return $this->redirectResult(Common_Util_Url::app_elogin_url());
	}
    /**
     * 返回操作提示页面
     *
     * @param string $message 要显示的信息
     * @param boolean $isError 是否为错误提示
     * @param string $url 重定向的url
     */
    protected function _hintResult($message,$isError=false,$url=null){
        $this->putContext('hasError', $isError);
        $this->putContext('message', $message);
        $this->putContext('url', $url);
        return $this->smartyResult('eshop.common.hint');
    }
	
    /**
     * jquery/taconiate返回结果
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
        
        return $this->jqueryResult('eshop.common.jq_error_tip');
    }

	/**
	 * 设置共用参数
	 */
	public function putSharedParam(){
		$this->putUserAuth();
		$this->putCartCount();
	}
	
	/**
     * 设置用户认证信息
     * 
     * @return void
     */
    public function putUserAuth(){
    	$this->putContext('user_auth_id', Anole_Util_Cookie::getUserID());
    	$this->putContext('user_auth_name', Anole_Util_Cookie::getUserName());
    }
	
	/**
     * 获取购物车里的花样数
     * 
     * @return int
     */
    public function putCartCount(){
		$cart = new Common_Util_Cart();
        
        $total_money = $cart->getTotalAmount();
        $items_count = $cart->getItemCount();
		
		$this->putContext('total_money', $total_money);
        $this->putContext('items_count', $items_count);
    }
	/**
	 * 获取友情链接
	 */
	protected function _getFriendLinks($order_by='sort',$size=30){
		$model = new Common_Model_Link();
		if($order_by == 'time'){
            $order = 'created_at DESC';
        }else{
            $order = 'sort ASC';
        }
		//get current data
        $options = array(
           'condition'=>array(),
           'vars'=>array(),
           'order'=>$order,
           'page'=>1,
           'size'=>$size
        );
        return $link_list = $model->find($options);
	}
	
	public function setId($v){
		$this->_id = $v;
		return $this;
	}
	public function getId(){
		return $this->_id;
	}
	
    public function setPage($v){
        if($v == 0){
            $this->_page = 1;
        }else{
            $this->_page = $v;
        }
        return $this;
    }
    public function getPage(){
        return $this->_page;
    }
	
	
}
/**vim:sw=4 et ts=4 **/
?>