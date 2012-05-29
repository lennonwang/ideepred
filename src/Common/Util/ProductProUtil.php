<?php
/**
 * 红酒属性相关工具类
 * 
 * @author wangjia
 * @version 1.0
 */
class Common_Util_Product_Pro_Util extends Anole_Object {
	/**
	 * 获取葡萄产地
	 */
	public static function getWineGrapeAreaArray(){
		 $grape_area = array("1"=>'法国',"2"=>'意大利',"3"=>'西班牙');
		 self::debug("getWineGrapeAreaArray.".$grape_area);
		 return $grape_area;
	} 
	
	/**
	 * 获取葡萄品种
	 */
	public static function getWineGrapeBreedArray(){
		 $grape_breed_array = array("1"=>'黑皮诺',"2"=>'赤霞珠',"3"=>'西拉',"4"=>'梅洛',"5"=>'长相思'
        ,"6"=>'雷司令',"7"=>'白苏维翁',"8"=>'马尔贝克',"9"=>'琼瑶浆',"10"=>'其他品种' );
         self::debug("getWineGrapeAreaArray.".$grape_breed_array);
		 return $grape_breed_array;
	} 
	
} 
	
/**vim:sw=4 et ts=4 **/
?>