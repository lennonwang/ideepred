<?php
/**
 * smarty dataset plugin
 * 
 * @author purpen
 * @version $Id$
 */
class Common_Smarty_DataSet extends Anole_Object {
	
    /**
     * 获取用户评论、反馈、咨询等
     * 
     * @return string
     */
    public static function smarty_block_comment($params,$content,&$smarty,&$repeat){
        $target_id = null;
        $type = 1;
        $size = 10;
        $page = 1;
        $var = 'comment';
        $item = 'cmt';
        
        extract($params,EXTR_IF_EXISTS);
		
        static $_index;
        if(is_null($content)){
            $model = new Common_Model_Comment();
			$conditions = array();
			$vars = array();
			
			$conditions[] = 'state=?';
			$vars[] = 1;
			if(!empty($type)){
				$conditions[] = 'type=?';
				$vars[] = $type;
			}
			if(!empty($target_id)){
				$conditions[] = 'target_id=?';
				$vars[] = $target_id;
			}
			
			if(!empty($conditions)){
				$condition = implode(' AND ', $conditions);
			}else{
				$condition = null;
			}
            $options = array(
                'condition'=>$condition,
                'vars'=>$vars,
                'page'=>$page,
                'size'=>$size,
                'order'=>'created_on DESC'
            );
            $comment_list = $model->find($options)->getResultArray();
            
            $smarty->assign($var, $comment_list);
            $_index = 0;
        }
        if(!isset($comment)){
            $comment = $smarty->get_template_vars($var);
        }
        if(!empty($comment[$_index])){
            $current = $comment[$_index];
            $smarty->assign($item, $current);
            $smarty->assign('_first', $_index == 0);
            $smarty->assign('loop', $_index);
            
            $_index++;
            $repeat = true;
        }else{
            $smarty->assign($item, null);
            
            $repeat = false;
        }
        
        return $content;
    }
    /**
     * 获取地名
	 *
     * @param array $params
     * @param Anole_Util_Smarty_Base $smarty
     * @return string
     */
	public function smarty_function_placeName($params,&$smarty){
		$id=null;
		$var='place';
		
		extract($params, EXTR_IF_EXISTS);
		
        if(is_null($id)){
            return null;
        }
		$areas = new Common_Model_Areas();
		$place = $areas->findById($id);
		if(!empty($place)){
			return $place['name'];
		}
		return null;
    }
	/**
	 * get child category
	 * 
     * @param array $params
     * @param Anole_Util_Smarty_Base $smarty
     * @return string	
	 */
	public function smarty_function_children($params,&$smarty){
		$code=null;
		$var='children';
		
		extract($params, EXTR_IF_EXISTS);
		
		if(is_null($code)){
			return null;
		}
		$category = new Common_Model_Category();
		$rows = $category->findChildrenCategory($code);
		unset($category);
		
		if(!empty($var)){
			$smarty->assign($var,$rows);
		}else{
			return $rows;
		}
	}
    /**
     * 获取订单的状态
     * 
     * @param array $params
     * @param Anole_Util_Smarty_Base $smarty
     * @return string
     */
    public function smarty_function_orderStatus($params,&$smarty){
        $status = null;
        
        extract($params, EXTR_IF_EXISTS);
        if(is_null($status)){
            return null;
        }
        switch($status){
            case Common_Model_Constant::ORDER_CANCELED:
                $s = '已取消';
                break;
            case Common_Model_Constant::ORDER_EXPIRED:
                $s = '已过期';
                break;
            case Common_Model_Constant::ORDER_WAIT_PAYMENT:
                $s = '等待付款中';
                break;
            case Common_Model_Constant::ORDER_WAIT_CHECK:
                $s = '等待审核中';
                break;
            case Common_Model_Constant::ORDER_READY_GOODS:
                $s = '正在配货中';
                break;
            case Common_Model_Constant::ORDER_SENDED_GOODS:
                $s = '已发货';
                break;
            case Common_Model_Constant::ORDER_PUBLISHED:
                $s = '已完成';
                break;
            default:
                break;
        }
        return $s;
    }

}
/**vim:sw=4 et ts=4 **/
?>