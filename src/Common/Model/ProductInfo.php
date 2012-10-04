<?php
/**
 * Model Common_Model_ProductInfo
 *  用于存放属性数据
 */
class Common_Model_ProductInfo     {
  
   /**
     *  字段属性
     * 
     * @var array
     */
    public $id;
    public $wine_country_name;
    public $wine_area_name;
    public $wine_level_name;
    public $wine_year_name;
    
    public $wine_taste_name;
    
    public   function getProductInfo($product){
    	$wine_country_id = $product['wine_country'];
    	$wine_area_id = $product['wine_area'];
    	$wine_level_id  = $product['wine_level']; 
		$productInfo = new Common_Model_ProductInfo();
		$productInfo->setId($product['id']);
	//	echo ("[param]:wine_country_id:".$wine_country_id);
		//国家
		$wine_country_name = $productInfo->getWineCountryById( $wine_country_id); 
		$productInfo->wine_country_name =($wine_country_name); 
	//	 echo ("[param]:wine_country_name:".$wine_country_name);
		//区域
		 $wine_area_name = $productInfo->getWineAreaById( $wine_area_id);  
	//	  echo ("[param]:wine_area_name:".$wine_area_name);
		 $productInfo->wine_area_name = $wine_area_name;
		  
		//级别
		 $wine_level_name = $productInfo->getWineLevelById( $wine_level_id);  
	//	   echo ("[param]:wine_level_name:".$wine_level_name);
		 $productInfo->wine_level_name = $wine_level_name;
		
		 
		 $wine_year_id  = $product['wine_year'];
		 $wine_year_name = $productInfo->getWineYearById($wine_year_id);
		 $productInfo->wine_year_name = $wine_year_name;
		 
		 $wine_taste_id  = $product['wine_first_taste'];
		 $wine_taste_name = $productInfo->getWineTasteById($wine_taste_id);
		 $productInfo->wine_taste_name = $wine_taste_name;
		 
		return $productInfo;
    }
    
    public function getWineTasteById($wine_taste_id){
    	$tasteArray = Common_Util_ProductProUtil::getWineTasteArray();
    	for($i=0;$i<count($tasteArray);$i++){
    		$tasteId = $tasteArray[$i]['id'];
    		if($wine_taste_id == $tasteId){
    			$tasteName = $tasteArray[$i]['name'];
    			return $tasteName;
    		}
    	}
    	return "";
    }
    
   
 	public function getWineAreaById($wine_area_id){
        $areaArray = Common_Util_ProductProUtil::getWineGrapeAreaArray();  
        for($i=0;$i<count($areaArray);$i++){
        	$areaId = $areaArray[$i]['id'];
            if($wine_area_id == $areaId){
               $areaName = $areaArray[$i]['name'];   
                return $areaName;
            }
        } 
        return "";
    }
    
     public function getWineCountryById($wine_country_id){
        $countryArray = Common_Util_ProductProUtil::getWineGrapeCountryArray();  
        for($i=0;$i<count($countryArray);$i++){
        	$countryId = $countryArray[$i]['id'];
            if($wine_country_id == $countryId){
               $countryName = $countryArray[$i]['name'];  
                return $countryName;
            }
        } 
        return "";
    }
    
 	public function getWineLevelById($wine_level_id){
        $itemArray = Common_Util_ProductProUtil::getWineLevelArray();  
        for($i=0;$i<count($itemArray);$i++){
        	$itemId = $itemArray[$i]['id'];
            if($wine_level_id == $itemId){
               $itemName = $itemArray[$i]['name'];  
                return $itemName;
            }
        } 
        return "";
    }
    
    
    public function getWineYearById($wine_year_id){
    	$itemArray = Common_Util_ProductProUtil::getWineYearArray();
    	for($i=0;$i<count($itemArray);$i++){
    		$itemId = $itemArray[$i]['id'];
    		if($wine_year_id == $itemId){
    			$itemName = $itemArray[$i]['name'];
    			return $itemName;
    		}
    	}
    	return "";
    }
    
    
    
   
    public function setId($value){
         $this->id = $value;
    } 
    public function getId(){
     return $this->id; 
    }
     public function setWineCountryName($value){ 
         $this->wine_country_name = $value;
    }
    
    public function getWineCountryName(){
    	return $this->wine_country_name; 
    }
    
    
}
 
?>