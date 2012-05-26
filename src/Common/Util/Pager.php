<?php
/**
 * 生产分页格式
 * 
 * @author purpen
 * @version $Id$
 */
class Common_Util_Pager extends Anole_Object {
	/**
	 * 设置分页显示形式
	 * 
	 * @param $params
	 * @return array
	 */
	public static function XE_NewPager($params){        
	    $size = 10;
	    $page = 1;
	    $total = 0;
	    
	    extract($params, EXTR_IF_EXISTS);
	           
	    $page_list = array();
	    if ($page == 'index'){
	       $page = 1;
	    }
	    if ($total < 1 || is_null($total)){
	        return;
	    }
	    if ($page > $total){
	        return;
	    }
	    if ($page < 1 || is_null($page)){
	        $page = 1;
	    }
	    
	    //判断起始页
	    if($total <= 8){
	        $start = 1;
	        $end = 8;
	        if($end >= $total){
	            $end = $total;
	        }
	    }else{
	        if($page <= 5 ){
	            $start = 1;
	            $end = 8;
	            if($end > $total)
	                $end = $total;
	        }else{
	            if($page == $total-4){
	                $start = $page -3;
	                $end = $page + 4;
	                if($end >= $total){
	                    $end = $total;
	                }
	            }else{
	                $start = $page -3;
	                $end = $page + 3;
	                if($end >= $total){
	                    $end = $total;
	                    $start = $total - 6;
	                }
	            }
	        }
	    }
	    for($i = $start; $i <= $end; $i++){
	        $page_list[] = $i;
	    }
	    
	    return $page_list;
	}
}
?>