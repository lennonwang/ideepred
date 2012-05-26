<?php
/**
 * Smarty Url Plugin
 * 
 * @author purpen
 * @version $Id$
 */
class Common_Smarty_Url extends Anole_Object {
    /**
     * 获取文章的访问地址
     * 
     * @param string $params
     * @param Anole_Util_Smarty_Base $smarty
     * @return string
     */
    public function smarty_function_ArticleUrl($params,&$smarty){
        $type = null;
        $name = null;
        $time = null;
        $prefix = 8; 
        $id = null;
        $page = 1;
        $var = null;
        
        extract($params,EXTR_IF_EXISTS);
        
        if(empty($type) || empty($time) || empty($id)){
            self::warn('Get article url and params not enough!',__METHOD__);
            return null;
        }
        if($type == Common_Model_Article::ARTICLE_TYPE){
            if($page == 1){
                $file = 'index.shtml';
            }else{
                $file = "post-$page.shtml";
            }
            $url = Common_Util_Url::getAricleStaticUrl($id,$time,$prefix,$file);
        }else{
            $url = Common_Util_Url::app_root_url();
        }
        if(!empty($var)){
            $smarty->assign($var,$url);
        }else{
            return $url;
        }
    }
    
    /**
     * 替换%s参数,格式化url
     *
     * @param array $params
     * @param Anole_Util_Smarty_Base $smarty
     * @return string
     */
    public static function smarty_function_format($params,&$smarty){
        $key = array_shift($params);
        $var_args = array_values($params);
        
        $url_format = Anole_Config::get('greare.'.$key);
        
        $need_num = substr_count($url_format, '%s');
        $give_num = count($var_args);
        
        if($need_num > $give_num){
            for($i=0;$i<$need_num-$give_num;$i++){
                array_push($var_args, 0);
            }
        }
        self::debug("push format url and give_num[".count($var_args)."]!", __METHOD__);
        array_unshift($var_args,$url_format);
        
        $url = call_user_func_array('sprintf', $var_args);
        
        return $url;
    }
}
/**vim:sw=4 et ts=4 **/
?>