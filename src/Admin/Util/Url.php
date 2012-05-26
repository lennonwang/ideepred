<?php
/**
 * 后台管理地址工具类
 * 
 * @author purpen
 * @version $Id$
 */
class Admin_Util_Url extends Anole_Object {
    /**
     * 获取后台管理地址
     * 
     * @return string
     */
    public static function app_root_url(){
        return Anole_Config::get('runtime.uri.admin_root');
    }
    /**
     * 后台登录地址
     * 
     * @return string
     */
    public static function app_login_url(){
        return Anole_Config::get('runtime.uri.login');
    }
    /**
     * 首页地址
     * 
     * @return string
     */
    public static function app_index_url(){
        return Anole_Config::get('greare.domain');
    }
}
/**vim:sw=4 et ts=4 **/
?>