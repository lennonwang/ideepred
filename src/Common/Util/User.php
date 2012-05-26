<?php
/**
 * 设置或获取用户SESSION值
 * 
 * @author purpen
 * @version $Id$
 */
class Common_Util_User extends Anole_Object{
	/**
	 * set user_id session
	 * 
	 * @param $id
	 * @return void
	 */
	public static function setUserId($id){
		Anole_Session_Context::getContext()->set('_INSTYLES_USER_ID_', $id);
	}
	/**
	 * get session user_id
	 * @return int
	 */
	public static function getUserId(){
		return Anole_Session_Context::getContext()->get('_INSTYLES_USER_ID_');
	}
	/**
	 * set designer_id session
	 * 
	 * @param $id
	 * @return void
	 */
	public static function setDesignerId($id){
		Anole_Session_Context::getContext()->set('_INSTYLES_DESIGNER_ID_', $id);
	}
	/**
	 * get designer_id session
	 * 
	 * @return int
	 */
	public static function getDesignerId(){
		return Anole_Session_Context::getContext()->get('_INSTYLES_DESIGNER_ID_');
	}
	/**
	 * set username session
	 * 
	 * @param $name
	 * @return void
	 */
	public static function setUsername($name){
		Anole_Session_Context::getContext()->set('_INSTYLES_USER_NAME_', $name);
	}
	/**
	 * get session username
	 * @return string
	 */
	public static function getUsername(){
		return Anole_Session_Context::getContext()->get('_INSTYLES_USER_NAME_');
	}
	
}
/**vim:sw=4 et ts=4 **/
?>