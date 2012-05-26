<?php
/**
 * Smarty Category Plugin
 * 
 * @author purpen
 * @version $Id$
 */
class Common_Smarty_Sort extends Anole_Object {
    /**
     * 获取文章的分类
     * 
     * @param string $params
     * @param Anole_Util_Smarty_Base $smarty
     * @return string
     */
    public function smarty_function_getCategoryList($params,&$smarty){
        $page = 1;
        $var = null;
        
        extract($params,EXTR_IF_EXISTS);
        
        $category = new Common_Model_Sort();
        $options = array(
            'page'=>$page,
            'condition'=>'state=?',
            'vars'=>array(1),
            'order'=>'id ASC'
        );
        $category_list = $category->find($options)->getResultArray();
        
        if(!empty($var)){
            $smarty->assign($var,$category_list);
        }else{
            return $category_list;
        }
    }
    /**
     * 获取站点频道菜单
     * 
     * @param array $params
     * @param mixed $content
     * @param Anole_Util_Smarty_Base $smarty
     * @param boolean $repeat
     * @return string
     */
    public static function smarty_block_siteChannelMenu($params,$content,$smarty,&$repeat){
    	$var='site';
    	$item='channels';
    	
    	extract($params,EXTR_IF_EXISTS);
    	
    	static $_index;
    	if(is_null($content)){
    		$category = new Common_Model_Category();
    		$site_id = Common_Model_Category::ROOT_ID;
    		$options = array(
    		    'condition'=>'parent_id=?',
    		    'vars'=>array($site_id),
    		    'order'=>'left_ref ASC'
    		);
    		$channel_list = $category->find($options)->getResultArray();
    		
    		$smarty->assign($var,$channel_list);
    		
    		$_index = 0;
    	}
    	
    	$channel_list = $smarty->get_template_vars($var);
    	if(!empty($channel_list[$_index])){
    		$smarty->assign($item, $channel_list[$_index]);
    		
    		$repeat=true;
            $_index++;
    	}else{
    		$smarty->assign($var,null);
            $smarty->assign($item,null);
            $repeat=false;
    	}
    	
    	return $content;
    }
    /**
     * 获取站点频道分类
     * 
     * @param array $params
     * @param Anole_Util_Smarty_Base $smarty
     * @return string
     */
    public static function smarty_function_siteChannelCategories($params,$smarty){
        $var='categories';
        $channel_id=null;
        $left_ref=null;
        $right_ref=null;
        
        extract($params,EXTR_IF_EXISTS);
        
        if(empty($channel_id) && (empty($left_ref) || empty($right_ref)) ) return null;
        
        try{
        	$category = new Common_Model_Category();
            if(!empty($left_ref) && !empty($right_ref)){
                $options = array(
                    'condition'=>'left_ref>? AND right_ref<?',
                    'vars'=>array($left_ref,$right_ref),
                    'order'=>'left_ref ASC'
                );
            }
            $category_list = $category->find($options)->getResultArray();
            
            $categories = array();
            $cnt = count($category_list);
            for($i=0;$i<$cnt;$i++){
            	$id_key = 'k'.$category_list[$i]['id'];
            	$parent_key = 'k'.$category_list[$i]['parent_id'];
            	if(!isset($categories[$parent_key])){
            		$categories[$id_key] = $category_list[$i];
            		$categories[$id_key]['children'] = array();
            	}else{
            		$categories[$parent_key]['children'][] = $category_list[$i];
            	}
            }
            
        }catch(Anole_ActiveRecord_Exception $e){
        	self::warn("fetch categories failed: ".$e->getMessages(), __METHOD__);
        }
        if(!empty($var)){
            $smarty->assign($var,$categories);
        }else{
            return $categories;
        }
    }
    
    /**
     * 
     * @param array $params
     * @param mixed $content
     * @param Anole_Util_Smarty_Base $smarty
     * @param boolean $repeat
     * @return string
     */
    public static function smarty_block_siteCategoryTree($params,$content,$smarty,&$repeat){
        $var='tree';
        $item='cate';
        $parent_id=0;
        
        extract($params,EXTR_IF_EXISTS);
        
        static $_index;
        static $_result;
        static $_monitor;
        
        if(is_null($content)){
            $category = new Common_Model_Category();
            if(empty($parent_id)){
            	$parent_id = Common_Model_Category::ROOT_ID;
            }
            $category_list = $category->findAllChildrenNodes($parent_id,true);
            $smarty->assign($var,$category_list);
            
            $_index=0;
            $_stack=array();
            $_result=array();
            //构建一个树状的数组
            $cnt = count($category_list);
            //self::debug("total site nodes:$cnt",__METHOD__);
            for($i=0;$i<$cnt;$i++){
                $node = $category_list[$i];
                
                if(count($_stack)>0){
                    while(count($_stack)>0 && $_stack[count($_stack)-1]['right_ref'] < $node['right_ref']){
                       $node2 = array_pop($_stack);
                       $_result[] = $node2;
                       //self::debug("close ".$node2['name'],__METHOD__);
                    }
                }
                $_result[] = $node;
                $_stack[] = $node;
                //self::debug("open ".$node['name'],__METHOD__);
            }
            if(count($_stack)>0){
                while(count($_stack)>0){
                    $node2= array_pop($_stack);
                    //self::debug("[clean]close ".$node2['name'],__METHOD__);
                    $_result[] = $node2;
                }
            }
            $_monitor=array();
            
        }
        $node = $_result[$_index];
        if(!empty($node)){
            $smarty->assign($item,$node);
            $id = $node['id'];
            //关闭节点
            if( isset($_monitor['k'.$id])){
                $smarty->assign($item.'_close',true);
                $smarty->assign($item.'_open',false);
                $first=0;
            }else{
                $smarty->assign($item.'_close',false);
                $smarty->assign($item.'_open',true);
                $_monitor['k'.$id]=1;
                $first=1;
            }
            //self::debug("output node,is_first:$first,name:".$node['name'],__METHOD__);
            $repeat=true;
            $_index++;
        }else{
            $smarty->assign($var,null);
            $smarty->assign($item,null);
            $smarty->assign($item.'_close',false);
            $smarty->assign($item.'_open',false);
            $repeat=false;
            $_monitor=array();
            $_result=array();
        }
        return $content;
    }
    
    /**
     * 
     * @param array $params
     * @param mixed $content
     * @param Anole_Util_Smarty_Base $smarty
     * @param boolean $repeat
     * 
     * @return string
     */
    public static function smarty_block_noChildrenTree($params,$content,$smarty,&$repeat){
        $var = 'tree';
        $item = 'cate';
        $id = null;
        
        extract($params,EXTR_IF_EXISTS);
                
        static $_index;
        static $_result;
        static $_monitor;
        
        if(empty($id)) return;
        
        if(is_null($content)){
        	$category = new Common_Model_Category();
            $category_list = $category->findAllNonChildrenNodes($id);
            $smarty->assign($var,$category_list);
            
            $_index = 0;
            $_stack = array();
            $_result = array();
            //构建一个树状的数组
            $cnt = count($category_list);
            self::debug("total site nodes:$cnt",__METHOD__);
            for($i = 0;$i < $cnt;$i++){
                $node = $category_list[$i];
                
                if(count($_stack)>0){
                    while(count($_stack)>0 && $_stack[count($_stack)-1]['right_ref'] < $node['right_ref']){
                       $node2= array_pop($_stack);
                       $_result[] = $node2;
                       self::debug("close ".$node2['name'],__METHOD__);
                    }
                }
                $_result[] = $node;
                $_stack[] = $node;
                self::debug("open ".$node['name'],__METHOD__);
            }
            if(count($_stack)>0){
                while(count($_stack)>0){
                    $node2= array_pop($_stack);
                    self::debug("[clean]close ".$node2['name'],__METHOD__);
                    $_result[] = $node2;
                }
            }
            $_monitor=array();
            
        }
        $node = $_result[$_index];
        if(!empty($node)){
            $smarty->assign($item,$node);
            $id = $node['id'];
            //关闭节点
            if( isset($_monitor['k'.$id])){
                $smarty->assign($item.'_close',true);
                $smarty->assign($item.'_open',false);
                $first=0;
            }else{
                $smarty->assign($item.'_close',false);
                $smarty->assign($item.'_open',true);
                $_monitor['k'.$id]=1;
                $first=1;
            }
            self::debug("output node,is_first:$first,name:".$node['name'],__METHOD__);
            $repeat=true;
            $_index++;
        }else{
            $smarty->assign($var,null);
            $smarty->assign($item,null);
            $smarty->assign($item.'_close',false);
            $smarty->assign($item.'_open',false);
            $repeat=false;
            $_monitor=array();
            $_result=array();
        }
        return $content;
    }
}
/**vim:sw=4 et ts=4 **/
?>