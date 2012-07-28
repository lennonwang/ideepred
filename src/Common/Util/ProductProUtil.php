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
		,array("id"=>"7","name"=>"2009-2010"),array("id"=>"8","name"=>"2010-2011")
		,array("id"=>"9","name"=>"2012")
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
	 * 获取葡萄所属国家
	 */
	public static function getWineGrapeCountryArray(){
	 
		$grape_country=array(array("id"=>"1","name"=>"法国"),array("id"=>"2","name"=>"意大利")
		,array("id"=>"3","name"=>"西班牙"),array("id"=>"4","name"=>"中国大陆")
		,array("id"=>"5","name"=>"美国"),array("id"=>"6","name"=>"德国"),array("id"=>"7","name"=>"智利"));  
		 self::debug("getWineGrapeCountryArray.".$grape_country);
		 return $grape_country;
	}
	
		/**
	 * 获取葡萄产区
	 */
	public static function getWineGrapeAreaArray(){
		$wine_area=array(array("id"=>"1","cid"=>"1","name"=>"法国大区1")
											,array("id"=>"2","cid"=>"1","name"=>"法国大区2")  
		,array("id"=>"3","cid"=>"1","name"=>"法国大区3")  
		,array("id"=>"4","cid"=>"1","name"=>"法国大区4")  
		,array("id"=>"5","cid"=>"2","name"=>"意大利1")  
		,array("id"=>"6","cid"=>"2","name"=>"意大利2")  
		,array("id"=>"7","cid"=>"3","name"=>"西班牙1")
		,array("id"=>"8","cid"=>"3","name"=>"西班牙2")
		,array("id"=>"9","cid"=>"3","name"=>"西班牙3")
		,array("id"=>"10","cid"=>"3","name"=>"西班牙4")
		
		  ,array("id"=>"701","cid"=>"7","name"=>"依基山谷")
      ,array("id"=>"702","cid"=>"7","name"=>"利玛尼山谷")
      ,array("id"=>"703","cid"=>"7","name"=>"亚冈卡加山谷")
      ,array("id"=>"704","cid"=>"7","name"=>"卡萨布兰加山谷")
		 , array("id"=>"705","cid"=>"7","name"=>"圣安东尼山谷")
          ,array("id"=>"706","cid"=>"7","name"=>"米埔山谷")
          ,array("id"=>"707","cid"=>"7","name"=>"加查普山谷")
          ,array("id"=>"708","cid"=>"7","name"=>"高查加山谷")  
		  ,array("id"=>"709","cid"=>"7","name"=>"古力高山谷")
          ,array("id"=>"710","cid"=>"7","name"=>"依达他山谷")
          ,array("id"=>"711","cid"=>"7","name"=>"拜奥山谷")
          ,array("id"=>"712","cid"=>"7","name"=>"马利高山谷")  
);  
		 self::debug("getWineGrapeAreaArray.".$wine_area);
		 return $wine_area;
	}
	
		/**
	 * 获取葡萄等级
	 */
	public static function getWineLevelArray(){
		$level_items=array(array("id"=>"1","cid"=>"1","name"=>"AOC")
											,array("id"=>"2","cid"=>"1","name"=>"法国Level2")  
		,array("id"=>"3","cid"=>"1","name"=>"法国Level3")  
		,array("id"=>"4","cid"=>"1","name"=>"法国Level4")  
		,array("id"=>"5","cid"=>"2","name"=>"意大利Level1")  
		,array("id"=>"6","cid"=>"2","name"=>"意大利Level2")  
		,array("id"=>"7","cid"=>"3","name"=>"西班牙Levle1")
		,array("id"=>"8","cid"=>"3","name"=>"西班牙Level2")
		,array("id"=>"9","cid"=>"3","name"=>"西班牙Level3")
		,array("id"=>"10","cid"=>"3","name"=>"西班牙Level4")
		
		,array("id"=>"701","cid"=>"7","name"=>"家族珍藏级Reserva De Familia") 
		,array("id"=>"702","cid"=>"7","name"=>"特级珍藏级Gran Reserva") 
		,array("id"=>"703","cid"=>"7","name"=>"珍藏级Reserva ") 
		,array("id"=>"704","cid"=>"7","name"=>"品种级Varietal")  
);  
		 self::debug("getWineLevelArray.".$level_items);
		 return $level_items;
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
	
	/**
	 * 获取葡萄酒制作工艺
	 * occasion
	 */
	public static function getWineCraftArray(){
		$items=array(array("id"=>"1","name"=>"单一葡萄品种"),array("id"=>"2","name"=>"混合葡萄品种") 
		 );  
		 self::debug("getWineCraftArray.".$items);
		 return $items;
	} 
} 
	
/**vim:sw=4 et ts=4 **/
?>