<?php
/**
 * 红酒属性相关工具类
 * 
 * @author wangjia
 * @version 1.0
 */
class Common_Util_ProductProUtil extends Anole_Object {
	/**
	 * 获取葡萄年份
	 */
	public static function getWineYearArray(){
		$array=array(array("id"=>"1","name"=>"2000之前"),array("id"=>"2","name"=>"2000-2001")
		,array("id"=>"3","name"=>"2002-2003"),array("id"=>"4","name"=>"2004-2005")
		,array("id"=>"5","name"=>"2006-2007"),array("id"=>"6","name"=>"2008-2009")
		,array("id"=>"7","name"=>"2010-2011"),array("id"=>"8","name"=>"2012")
		);  
		 self::debug("getWineYearArray.".$array);
		 return $array;
	} 
	
	/**
	 * 获取葡萄品种
	 */
	public static function getWineGrapeBreedArray(){
		$grape_breed_array=array(array("id"=>"1","name"=>"黑皮诺"),array("id"=>"2","name"=>"赤霞珠")
		,array("id"=>"3","name"=>"西拉"),array("id"=>"4","name"=>"梅洛")
		,array("id"=>"5","name"=>"长相思"),array("id"=>"6","name"=>"雷司令")
		,array("id"=>"7","name"=>"白苏维翁"),array("id"=>"8","name"=>"马尔贝克")
		,array("id"=>"9","name"=>"琼瑶浆"),array("id"=>"10","name"=>"其他品种"));  
         self::debug("getWineGrapeAreaArray.".$grape_breed_array);
		 return $grape_breed_array;
	} 
	
	
	/**
	 * 获取葡萄产地
	 */
	public static function getWineGrapeAreaArray(){
		$grape_area=array(array("id"=>"1","name"=>"法国"),array("id"=>"2","name"=>"意大利")
		,array("id"=>"3","name"=>"西班牙"),array("id"=>"4","name"=>"中国大陆")
		,array("id"=>"5","name"=>"美国"),array("id"=>"6","name"=>"德国"));  
		 self::debug("getWineGrapeAreaArray.".$grape_area);
		 return $grape_area;
	} 
	
	/**
	 * 获取葡萄糖分
	 */
	public static function getWineSugarArray(){
		$grape_area=array(array("id"=>"1","name"=>"干葡萄酒 （含糖量小于4克/升）"),array("id"=>"2","name"=>"半干葡萄酒（含糖量 4-12克/升）")
		,array("id"=>"3","name"=>"半甜葡萄酒 （含糖量 12-40克/升）"),array("id"=>"4","name"=>"甜葡萄酒（含糖量大于40克/升）")
		 );  
		 self::debug("getWineGrapeAreaArray.".$grape_area);
		 return $grape_area;
	} 
	
	/**
	 * 获取葡萄酒适用场合
	 * occasion
	 */
	public static function getWineOccasionArray(){
		$grape_area=array(array("id"=>"1","name"=>"婚庆用酒区"),array("id"=>"2","name"=>"团圆小酌区")
		,array("id"=>"3","name"=>"朋友小聚"),array("id"=>"4","name"=>"商务宴请区")
		 );  
		 self::debug("getWineGrapeAreaArray.".$grape_area);
		 return $grape_area;
	} 
} 
	
/**vim:sw=4 et ts=4 **/
?>