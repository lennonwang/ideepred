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
		 self::debug("getWineYearArray::".$array);
		 return $array;
	} 
	
	
	/**
	 * 获取葡萄酒推荐类型
	 */
	public static function getWineModeArray(){
		$wine_mode_array=array(array("id"=>"1","name"=>"Top9"),array("id"=>"2","name"=>"低度畅饮")
		,array("id"=>"3","name"=>"甜蜜口感"),array("id"=>"4","name"=>"女性最爱"),array("id"=>"5","name"=>"男士精选") );  
         self::debug("getWineModeArray::".$wine_mode_array);
		 return $wine_mode_array; 
	}
	
	/**
	 * 获取葡萄品种 莎当妮（霞多丽）
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
		,array("id"=>"5","name"=>"美国"),array("id"=>"6","name"=>"德国")
		,array("id"=>"7","name"=>"智利")
		,array("id"=>"8","name"=>"南非"),array("id"=>"9","name"=>"澳大利亚")
				,array("id"=>"10","name"=>"葡萄牙")
				,array("id"=>"11","name"=>"阿根廷")
		);  
		 self::debug("getWineGrapeCountryArray.".$grape_country);
		 return $grape_country;
	}
	
		/**
	 * 获取葡萄产区
	 */
	public static function getWineGrapeAreaArray(){
		$wine_area=array(
				array("id"=>"101","cid"=>"1","name"=>"普罗旺斯") 
			,array("id"=>"102","cid"=>"1","name"=>"波尔多") 
			,array("id"=>"103","cid"=>"1","name"=>"罗纳河谷") 
			,array("id"=>"104","cid"=>"1","name"=>"勃艮第")  
			,array("id"=>"105","cid"=>"1","name"=>"薄若莱") 
			,array("id"=>"106","cid"=>"1","name"=>"香槟区")  
			,array("id"=>"107","cid"=>"1","name"=>"西南产区")  
			,array("id"=>"108","cid"=>"1","name"=>"朗格多克-鲁西荣") 
			,array("id"=>"109","cid"=>"1","name"=>"卢瓦河谷")  
			,array("id"=>"110","cid"=>"1","name"=>"其他子产区") 
			 
		
		,array("id"=>"201","cid"=>"2","name"=>"皮埃蒙特大区")  
	,array("id"=>"202","cid"=>"2","name"=>"伦巴蒂大区")  
	,array("id"=>"203","cid"=>"2","name"=>"弗留利－威尼斯－朱利亚大区 ")  
	,array("id"=>"204","cid"=>"2","name"=>"威尼托大区")  
	,array("id"=>"205","cid"=>"2","name"=>"托斯卡纳大区")  
	,array("id"=>"206","cid"=>"2","name"=>"翁布里亚大区")  
	,array("id"=>"207","cid"=>"2","name"=>"其他产区")  

 
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

				,array("id"=>"801","cid"=>"8","name"=>"西开普产区")
				
				,array("id"=>"1101","cid"=>"11","name"=>"门多萨产区")
);  
		 self::debug("getWineGrapeAreaArray.".$wine_area);
		 return $wine_area;
	}
	
		/**
	 * 获取葡萄等级
	 */
	public static function getWineLevelArray(){
		$level_items=array(
				array("id"=>"101","cid"=>"1","name"=>"不分级")
,array("id"=>"102","cid"=>"1","name"=>"地区餐酒VDP ")
,array("id"=>"103","cid"=>"1","name"=>"村庄级AOC")
,array("id"=>"104","cid"=>"1","name"=>"地区餐酒VDP")
,array("id"=>"105","cid"=>"1","name"=>"特级名庄(Grand cru)")
,array("id"=>"106","cid"=>"1","name"=>"中级酒庄( Cru Bourgeois)")
,array("id"=>"107","cid"=>"1","name"=>"区域级（镇级）AOC ")
,array("id"=>"108","cid"=>"1","name"=>"高级AOC( Superieur AOC)")
,array("id"=>"109","cid"=>"1","name"=>"大区法定产区AOC")
,array("id"=>"110","cid"=>"1","name"=>"优良产区餐酒VDQS")
,array("id"=>"111","cid"=>"1","name"=>"原产地命名保护葡萄酒AOP")
,array("id"=>"112","cid"=>"1","name"=>"产区标识保护葡萄酒IGP")
,array("id"=>"113","cid"=>"1","name"=>"无产区限制葡萄酒VDF")

		
		,array("id"=>"201","cid"=>"2","name"=>"保证法定产区DOCG")  
		,array("id"=>"202","cid"=>"2","name"=>"法定产区DOC ")  
		,array("id"=>"203","cid"=>"2","name"=>"典型产区IGT ")  
		,array("id"=>"204","cid"=>"2","name"=>"佐餐酒VDT ")  
 
		
		,array("id"=>"701","cid"=>"7","name"=>"家族珍藏级Reserva De Familia") 
		,array("id"=>"702","cid"=>"7","name"=>"特级珍藏级Gran Reserva") 
		,array("id"=>"703","cid"=>"7","name"=>"珍藏级Reserva ") 
		,array("id"=>"704","cid"=>"7","name"=>"品种级Varietal")
		
		,array("id"=>"601","cid"=>"6","name"=>"日常餐酒Tafelwein")
		,array("id"=>"602","cid"=>"6","name"=>"地区餐酒Landwein")
		,array("id"=>"603","cid"=>"6","name"=>"Qba优质葡萄酒")
		,array("id"=>"604","cid"=>"6","name"=>"QmP 特别优质酒")

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
	
	
	/**
	 * 获取葡萄酒初品口感
	 * occasion
	 * 甜润白
小清鲜
渐浓郁
浓厚型
小辛辣
	 */
	public static function getWineTasteArray(){
		$wine_taste=array(array("id"=>"1","name"=>"甜润白"),array("id"=>"2","name"=>"小清鲜")
				,array("id"=>"3","name"=>"渐浓郁"),array("id"=>"4","name"=>"浓厚型")
				,array("id"=>"5","name"=>"小辛辣")
		);
		self::debug("getWineTasteArray.".$wine_taste);
		return $wine_taste;
	}
	
	/**
	 * 获取葡萄酒匹配红酒
	 * 
	 * 首选美食搭配

    首选餐前开胃酒
    白灼海鲜
    意粉/沙拉
    生鲜鱼肉/白肉
    匹萨/甜品/水果
    各类肉排/烧烤
    清蒸/炒中餐
    红肉/浓味中餐

	 * occasion
	 */
	public static function getWineMatchArray(){
		$wine_match=array(array("id"=>"1","name"=>"首选餐前开胃酒"),array("id"=>"2","name"=>"白灼海鲜")
				,array("id"=>"3","name"=>"意粉/沙拉")
				,array("id"=>"4","name"=>"生鲜鱼肉/白肉")
				,array("id"=>"5","name"=>"匹萨/甜品/水果")
				,array("id"=>"6","name"=>"各类肉排/烧烤")
				,array("id"=>"7","name"=>"清蒸/炒中餐")
				,array("id"=>"8","name"=>"红肉/浓味中餐")
		);
		self::debug("getWineMatchArray.".$wine_match);
		return $wine_match;
	}
} 
	
/**vim:sw=4 et ts=4 **/
?>