<?php
/**
 * Smarty Plugin Pager
 * 
 * @author purpen
 * @version $Id$
 */
class Common_Smarty_Pager extends Anole_Object {
    /**
     * 新的分页类型
     *
     * @param array $params
     * @param string $content
     * @param Anole_Util_Smarty_Base $smarty
     * @param bool $repeat
     * @return string
     */
    public static function smarty_block_newpager($params, $content, &$smarty, &$repeat){        
        $size = 10;
        $page = 1;
        $total = 0;
        $item = 'p';

        extract($params, EXTR_IF_EXISTS);
           
        static $page_list = array();
        
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
        if (is_null($content)){
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
            $smarty->assign('total', $total);
        }
        
        if (!empty($page_list)){
            $current = array_shift($page_list);
            if ($current){
                $smarty->assign($item, $current);
                $repeat = true;
            }else{
                $repeat = false;
            }
        }
        
        return $content;
    }
}
/**vim:sw=4 et ts=4 **/
?>