<?php
/**
 * smarty dataset plugin
 * 
 * @author purpen
 * @version $Id$
 */ 
class Admin_Smarty_DataSet extends Anole_Object {
	/**
	 * 
	 * @param array $params
	 * @param string $content
	 * @param Anole_Util_Smarty_Base $smarty
	 * @param bool $repeat
	 * @return string
	 */
	public static function smarty_block_insertAsset($params,$content,&$smarty,&$repeat){
		$id = null;
		$var = 'assets';
		$item = 'p';
		
		extract($params,EXTR_IF_EXISTS);
		if(empty($id)){
			return null;
		}
		static $_index;
		static $asset_list;
		if(is_null($content)){
			if(!is_int($id)){
				$ids = preg_split('/,/',$id);
			}else{
				$ids = array($id);
			}
			
			$assets = new Common_Model_Asset();
			$asset_list = $assets->findById($ids)->getResultArray();
			$_index = 0;
		}
		$current = $asset_list[$_index];
		if(!empty($current)){
			$repeat = true;
			$_index++;
			$current['thumb_url'] = Common_Util_Storage::getAssetUrl($current['domain'],$current['path']);
			$current['waterimg_url'] = Common_Util_Asset::fetchWatetImage($current['domain'],$current['path']);
			$smarty->assign($item, $current);
		}else{
			$repeat = false;
			$smarty->assign($item, null);
			unset($assets);
		}
		
		return $content;
	}
	
	/**
	 * 用字符串显示时间
	 * 
	 * @param array $params
	 * @param Anole_Util_Smarty_Base $smarty
	 * @return string
	 */
	public static function smarty_function_dateString($params,&$smarty){
		$start = null;
		$now = Greare_Util_Date::getNow();
		$var = null;
		
		extract($params, EXTR_IF_EXISTS);
		if(empty($start)){
			return null;
		}
		$stt = Greare_Util_Date::dateToString($start,$now);
		if(empty($var)){
			return $stt;
		}else{
			$smarty->assign($var,$stt);
		}
		return;
	}
	/**
	 * 获取父级分类
	 * 
	 * @param $params
	 * @param Anole_Util_Smarty_Base $smarty
	 * @return string
	 */
	public static function smarty_function_parentCategory($params,&$smarty){
		$id = null;
		$var = null;
		
		extract($params, EXTR_IF_EXISTS);
		if(empty($id)){
			return null;
		}
		$category = new Common_Model_Category();
		$data = $category->findById($id)->getResultArray();
		$title = isset($data['title']) ? $data['title'] : Null;
		
		unset($category);
		
		if(empty($var)){
			return $title;
		}else{
			$smarty->assign($var,$title);
		}
		
		return;
	}
	
	/**
	 * 获取地域名
	 * 
	 * @param array $params
	 * @param Anole_Util_Smarty_Base $smarty
	 * @return string
	 */
	public static function smarty_function_getArea($params,&$smarty){
		$id = null;
        $var = null;
        
        extract($params, EXTR_IF_EXISTS);
	    if(empty($id)){
            return null;
        }
        $area = new Common_Model_Areas();
        $data = $area->findById($id)->getResultArray();
        $name = isset($data['name']) ? $data['name'] : Null;
        
        unset($area);
        
        if(empty($var)){
        	return $name;
        }else{
        	$smarty->assign($var,$name);
        }
        
        return;
	}
	/**
	 * 获取产品附件属性
	 * 
	 * @param array $params
	 * @param Anole_Util_Smarty_Base $smarty
	 * @return void
	 */
	public static function smarty_function_fetchFeatures($params,&$smarty){
		$id = null;
        $var = null;
        
	    extract($params, EXTR_IF_EXISTS);
        if(empty($id)){
            return null;
        }
        $model = new Common_Model_Features();
        $data = $model->findFeaturesByCategory($id);
        unset($model);
        
        if(empty($var)){
            return $data;
        }else{
            $smarty->assign($var,$data);
        }
        
        return;
	}
	/**
	 * 获取附件所属的对象
	 * 
	 * @param $params
	 * @param Anole_Util_Smarty_Base $smarty
	 * @return string
	 */
	public static function smarty_function_assetParent($params,&$smarty){
		$parent_id=null;
		$parent_type=null;
		$var=null;
	    
		extract($params, EXTR_IF_EXISTS);
		
        if(empty($parent_id) || empty($parent_type)){
            return null;
        }
        try{
        	$link = null;
        	switch($parent_type){
        		case Common_Model_Constant::PRODUCT_THUMB:
        			break;
        		case Common_Model_Constant::PRODUCT_WHOLE:
        			break;
        		case Common_Model_Constant::ADVERTISE:
        			$advertise = new Common_Model_Advertise();
        			$advertise->findById($parent_id,array('select'=>'title,link,id'));
        			$link = sprintf('<a href="%s" />广告：%s</a>',$advertise['link'],$advertise['title']);
        			self::debug("asset parent is advertise[$link].", __METHOD__);
        			unset($advertise);
        			break;
        		default:
        			break;
        	}
        }catch(Common_Model_Exception $e){
        	self::warn("get asset parent failed:".$e->getMessage(), __METHOD__);
        }
        
        if(!empty($var)){
        	$smarty->assign($var,$link);
        }else{
        	return $link;
        }
		
	}
}
/**vim:sw=4 et ts=4 **/
?>