<?php
/**
 * Admin Smarty Plugins
 * 
 * @version $Id$
 * @author purpen
 */
class Admin_Smarty_System extends Anole_Object {
	/**
	 * 获取对应的permission
	 *
	 * @param array $params
	 * @param Anole_Util_Smarty_Base $smarty
	 * 
	 * @return mixed
	 */
	public static function smarty_function_ownPermission($params,&$smarty){
		$resource = null;
        $privilege = null;
        $var = 'permiss';
        
        extract($params, EXTR_IF_EXISTS);
        
        if(empty($resource) || empty($privilege)){
        	self::warn("Get own permission and resource or privilege is null!", __METHOD__);
        	return;
        }
        try{
        	$model = new Common_Model_Permission();
        	$options = array(
        	   'condition'=>'resource=? AND privilege=?',
        	   'vars'=>array($resource,$privilege)
        	);
        	$permiss = $model->findFirst($options)->getResultArray();
        }catch(Anole_ActiveRecord_Exception $e){
        	self::warn("Get own permission and dba failed: ".$e->getMessage(), __METHOD__);
        	return;
        }
        if(!is_null($var)){
        	$smarty->assign($var,$permiss);
        }else{
        	return $permiss;
        }
	}
	
}
?>