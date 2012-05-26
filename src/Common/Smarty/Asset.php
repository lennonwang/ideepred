<?php
/**
 * Smarty Asset Plugin
 * 
 * @author purpen
 * @version $Id$
 */
class Common_Smarty_Asset extends Anole_Object {
    /**
     * 获取缩略图或附件
     * 
     * @param array $params
     * @param Anole_Util_Smarty_Base $smarty
     * @return string
     */
    public static function smarty_function_Thumb($params,&$smarty){
        $var='';
        $path_id=null;
        $domain='product';
        $is_result_mode='sigleurl';
		$by_width=null;
        $w = 90;
        $h = 90;
        
        extract($params,EXTR_IF_EXISTS);
		
        if(empty($path_id) || empty($domain)){
            return null;
        }
		//裁切方式
		if(is_null($by_width)){
			$type = 2;
		}else{
			$type = 3;
		}
        
        $data = Common_Util_Asset::makeThumb($path_id,$w,$h,$domain,$type);
        
        if(!empty($var)){
        	if($is_result_mode == 'sigleurl'){
        		$smarty->assign($var,$data['url']);
        	}else{
        		$smarty->assign($var,$data);
        	}
        }else{
        	if($is_result_mode == 'sigleurl'){
        		return $data['url'];
        	}
            return $data;
        }
    }
}
/**vim:sw=4 et ts=4 **/
?>