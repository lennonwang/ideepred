<?php
/**
 * rebuild url tools class
 * 
 * @author purpen
 * @version $Id$
 * 
 */
class Common_Util_Url extends Anole_Object {
    /**
     * 获取静态文件的路径
     * 
     * @param int $id
     * @param datetime $time
     * @param string $file
     * 
     * @return string
     */
    public static function buildPathIdByTime($id,$time,$prefix,$file='index.shtml'){
        return strftime("%y%m%d", strtotime($time))."/c${id}${prefix}/$file";
    }
    /**
     * 获取文章的访问地址
     * 
     * @param int $id
     * @param datetime $time
     * @return string
     */
    public static function getAricleStaticUrl($id,$time,$prefix,$file='index.shtml'){
    	$path = self::buildPathIdByTime($id,$time,$prefix,$file);
    	$domain = Anole_Config::get('runtime.uri.static');
    	return $domain.'/'.$path;
    }
    /**
     * 获取专题的访问地址
     * 
     * @param string $name
     * @return string
     */
    public static function getTopicStaticUrl($name){
    	$domain = Anole_Config::get('runtime.uri.static');
    	return $domain.'/'.$name.'/index.shtml';
    }
    /**
     * 获取根路径
     * 
     * @return string
     */
    public static function app_root_url(){
        return Anole_Config::get('runtime.uri.root');
    }
    /**
     * 获取登录
     */
	public static function app_elogin_url(){
		return Anole_Config::get('runtime.uri.elogin');
	}
	/**
	 * 获取没有权限
	 */
	public static function app_no_auth_url(){
		return Anole_Config::get('runtime.uri.no_auth');
	}
    /**
     * 设置返回路径到session
     * 
     * @param string $url
     * @return void
     */
    public static function setBackUrl($url){
        Anole_Session_Context::getContext()->set('_XE_BACK_URL_', $url);
    }
    /**
     * 获得返回路径从session
     * 
     * @return string
     */
    public static function getBackUrl(){
        $back_url = Anole_Session_Context::getContext()->get('_XE_BACK_URL_');
        if(empty($back_url)){
            $back_url = self::app_root_url();
        }
        return $back_url;
    }
    /**
     * 快钱支付后，显示给用户结果
     * 
     * @return string
     */
    public static function billBackShow($order_ref,$pay_amount,$msg=null){
        $back = self::app_root_url();
        $back .= 'app/eshop/bill_pay/show?order_ref='.$order_ref.'&pay_amount='.$pay_amount;
        if(!is_null($msg)){
            $back .= '&msg='.$msg;
        }
        
        return $back;
    }
}
/**vim:sw=4 et ts=4 **/
?>