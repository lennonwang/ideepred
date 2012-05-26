<?php
/**
 * html过滤器,清除用户输入的特殊字符，以及敏感词语。
 * 
 * @author purpen
 * @version $Id$
 */
class Common_Util_FilterCode extends Anole_Object {
    
	/**
	 * 过滤所有不安全的元素
	 * 
	 * @return string
	 */
	public static function filtor($content){
		//过滤代码
		//$content = self::replaceCode($content);
		//清除不健康词语
		$content = self::clearWords($content);
		
		return $content;
	}
	/**
	 * 替换特殊字符或不安全代码
	 * 
	 * @return string
	 */
	public static function replaceCode($content){
		
		 $rules = array(
		     "/s+/",
		     "/<(/?)(script|i?frame|style|html|body|title|link|meta|?|%)([^>]*?)>/isU",
		     "/(<[^>]*)on[a-zA-Z]+s*=([^>]*>)/isU"
		 );
		 
		 $reptxt = array(
		     " ",
             " ", //如果要直接清除不安全的标签，这里可以留空
             " "
		 );
		 
		 $content = preg_replace($rules,$reptxt,$content);
		 
		 return $content;
	}
	/**
	 * 清除敏感或不健康词语
	 * 
	 * @return string
	 */
	public static function clearWords($content){
		$bad_string = Anole_Config::get('wordfilter.seword');
		if(!empty($bad_string)){
			$content = preg_replace("/$bad_string/i","", $content);
		} 
		return $content;
	}
}
/**vim:sw=4 et ts=4 **/
?>